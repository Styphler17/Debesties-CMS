<?php

namespace App\Services;

class PageLayoutCompiler
{
    /**
     * Compile a layout array (sections with columns and widgets) into semantic HTML.
     */
    public function compile(array $sections): string
    {
        $html = '';

        foreach ($sections as $section) {
            $html .= $this->renderSection($section);
        }

        return $html;
    }

    protected function renderSection(array $section): string
    {
        $bg = $this->resolveBackground($section['background'] ?? 'white');
        $padding = $section['padding'] ?? 'medium';
        $paddingCss = match ($padding) {
            'small' => 'padding: 2rem 0;',
            'large' => 'padding: 6rem 0;',
            default => 'padding: 4rem 0;',
        };

        $columnsHtml = '';
        $columns = $section['columns'] ?? [];
        $colCount = count($columns);

        if ($colCount > 0) {
            $gridCols = match ($colCount) {
                1 => '1fr',
                2 => '1fr 1fr',
                3 => '1fr 1fr 1fr',
                4 => '1fr 1fr 1fr 1fr',
                default => 'repeat('.$colCount.', 1fr)',
            };

            $columnsHtml .= '<div style="display: grid; grid-template-columns: '.$gridCols.'; gap: 2rem; max-width: 1200px; margin: 0 auto; padding: 0 2rem;">';

            foreach ($columns as $column) {
                $columnsHtml .= '<div>';
                foreach (($column['widgets'] ?? []) as $widget) {
                    $columnsHtml .= $this->renderWidget($widget);
                }
                $columnsHtml .= '</div>';
            }

            $columnsHtml .= '</div>';
        }

        return '<section style="'.$bg.$paddingCss.'">'.$columnsHtml.'</section>';
    }

    protected function renderWidget(array $widget): string
    {
        $type = $widget['type'] ?? '';
        $settings = $widget['settings'] ?? [];

        return match ($type) {
            'text' => $this->renderText($settings),
            'heading' => $this->renderHeading($settings),
            'image' => $this->renderImage($settings),
            'cta' => $this->renderCta($settings),
            'feature_cards' => $this->renderFeatureCards($settings),
            'faq' => $this->renderFaq($settings),
            'video' => $this->renderVideo($settings),
            'alert' => $this->renderAlert($settings),
            'spacer' => $this->renderSpacer($settings),
            default => '',
        };
    }

    protected function renderText(array $s): string
    {
        $content = $s['content'] ?? '';
        $align = $s['alignment'] ?? 'left';

        return '<div style="text-align: '.e($align).'; line-height: 1.8; font-size: 1.1rem; margin-bottom: 1.5rem;">'.$content.'</div>';
    }

    protected function renderHeading(array $s): string
    {
        $text = e($s['text'] ?? '');
        $level = $s['level'] ?? 'h2';
        $align = $s['alignment'] ?? 'left';
        $tag = in_array($level, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6']) ? $level : 'h2';

        $sizes = [
            'h1' => '2.5rem',
            'h2' => '2rem',
            'h3' => '1.5rem',
            'h4' => '1.25rem',
            'h5' => '1.1rem',
            'h6' => '1rem',
        ];

        $size = $sizes[$tag] ?? '2rem';

        return '<'.$tag.' style="text-align: '.e($align).'; font-size: '.$size.'; font-family: \'Playfair Display\', Georgia, serif; margin-bottom: 1rem;">'.$text.'</'.$tag.'>';
    }

    protected function renderImage(array $s): string
    {
        $src = e($s['src'] ?? '');
        $alt = e($s['alt'] ?? '');
        $caption = $s['caption'] ?? '';

        $html = '<figure style="margin: 1.5rem 0; text-align: center;">';
        $html .= '<img src="'.$src.'" alt="'.$alt.'" style="max-width: 100%; height: auto; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);" loading="lazy" />';
        if ($caption) {
            $html .= '<figcaption style="margin-top: 0.75rem; font-size: 0.9rem; color: #888; font-style: italic;">'.e($caption).'</figcaption>';
        }
        $html .= '</figure>';

        return $html;
    }

    protected function renderCta(array $s): string
    {
        $text = e($s['text'] ?? 'Learn More');
        $url = e($s['url'] ?? '#');
        $style = $s['style'] ?? 'primary';
        $align = $s['alignment'] ?? 'center';

        $btnColor = match ($style) {
            'secondary' => 'background: transparent; color: #E8A800; border: 2px solid #E8A800;',
            'dark' => 'background: #1A1410; color: #fff; border: none;',
            default => 'background: #E8A800; color: #1A1410; border: none;',
        };

        return '<div style="text-align: '.e($align).'; margin: 2rem 0;">'
            .'<a href="'.$url.'" style="display: inline-block; padding: 14px 32px; font-family: \'Outfit\', sans-serif; font-size: 1rem; font-weight: 700; border-radius: 8px; text-decoration: none; transition: transform 150ms, box-shadow 150ms; '.$btnColor.'">'.$text.'</a>'
            .'</div>';
    }

    protected function renderFeatureCards(array $s): string
    {
        $cards = $s['cards'] ?? [];
        if (empty($cards)) {
            return '';
        }

        $html = '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; margin: 2rem 0;">';
        foreach ($cards as $card) {
            $icon = e($card['icon'] ?? '⭐');
            $title = e($card['title'] ?? '');
            $desc = e($card['description'] ?? '');

            $html .= '<div style="background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 2px 16px rgba(0,0,0,0.06); border: 1px solid rgba(0,0,0,0.06); text-align: center;">'
                .'<div style="font-size: 2.5rem; margin-bottom: 1rem;">'.$icon.'</div>'
                .'<h3 style="font-family: \'Playfair Display\', Georgia, serif; font-size: 1.25rem; margin-bottom: 0.75rem;">'.$title.'</h3>'
                .'<p style="font-size: 0.95rem; color: #666; line-height: 1.6;">'.$desc.'</p>'
                .'</div>';
        }
        $html .= '</div>';

        return $html;
    }

    protected function renderFaq(array $s): string
    {
        $items = $s['items'] ?? [];
        if (empty($items)) {
            return '';
        }

        $html = '<div style="max-width: 800px; margin: 2rem auto;">';
        foreach ($items as $item) {
            $q = e($item['question'] ?? '');
            $a = e($item['answer'] ?? '');

            $html .= '<details style="border-bottom: 1px solid rgba(0,0,0,0.08); padding: 1.25rem 0; cursor: pointer;">'
                .'<summary style="font-family: \'Outfit\', sans-serif; font-weight: 600; font-size: 1.05rem; list-style: none; display: flex; align-items: center; justify-content: space-between;">'
                .$q.'<span style="font-size: 1.5rem; color: #E8A800;">+</span></summary>'
                .'<p style="margin-top: 1rem; color: #555; line-height: 1.7;">'.$a.'</p>'
                .'</details>';
        }
        $html .= '</div>';

        return $html;
    }

    protected function renderVideo(array $s): string
    {
        $url = $s['url'] ?? '';
        $embedUrl = $this->convertToEmbed($url);

        if (! $embedUrl) {
            return '';
        }

        return '<div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; margin: 2rem 0; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">'
            .'<iframe src="'.e($embedUrl).'" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;" allowfullscreen loading="lazy"></iframe>'
            .'</div>';
    }

    protected function renderAlert(array $s): string
    {
        $message = e($s['message'] ?? '');
        $type = $s['type'] ?? 'info';

        $colors = match ($type) {
            'warning' => 'background: #FFF8E1; border-left: 4px solid #F9A825; color: #5D4037;',
            'success' => 'background: #E8F5E9; border-left: 4px solid #43A047; color: #1B5E20;',
            'danger' => 'background: #FFEBEE; border-left: 4px solid #E53935; color: #B71C1C;',
            default => 'background: #E3F2FD; border-left: 4px solid #1E88E5; color: #0D47A1;',
        };

        return '<div style="'.$colors.' padding: 1.25rem 1.5rem; border-radius: 8px; margin: 1.5rem 0; font-size: 1rem; line-height: 1.6;">'.$message.'</div>';
    }

    protected function renderSpacer(array $s): string
    {
        $height = (int) ($s['height'] ?? 40);

        return '<div style="height: '.$height.'px;"></div>';
    }

    protected function resolveBackground(string $preset): string
    {
        return match ($preset) {
            'cream' => 'background: #FBF7F0;',
            'soft-gold' => 'background: linear-gradient(135deg, #FBF7F0, #F5ECD5);',
            'soft-green' => 'background: #F0F7F0;',
            'dark-charcoal' => 'background: #1A1410; color: #F4F1EC;',
            'dark' => 'background: #0F0D0A; color: #F4F1EC;',
            'gradient-warm' => 'background: linear-gradient(135deg, #FBF7F0, #FCE4BE);',
            default => 'background: #ffffff;',
        };
    }

    protected function convertToEmbed(string $url): ?string
    {
        // YouTube
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        // Vimeo
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
            return 'https://player.vimeo.com/video/'.$matches[1];
        }

        return null;
    }
}
