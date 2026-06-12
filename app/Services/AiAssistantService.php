<?php

namespace App\Services;

class AiAssistantService
{
    public function generateTags(string $title, string $body): array
    {
        // Simulate AI generation by extracting common words and using title
        $content = $title.' '.strip_tags($body);
        $words = str_word_count(strtolower($content), 1);

        // Remove common stop words (simplified list)
        $stopWords = ['the', 'is', 'at', 'which', 'and', 'a', 'an', 'for', 'with', 'on', 'this', 'that', 'to', 'in'];
        $filtered = array_filter($words, fn ($w) => strlen($w) > 3 && ! in_array($w, $stopWords));

        $counts = array_count_values($filtered);
        arsort($counts);

        return array_slice(array_keys($counts), 0, 5);
    }

    public function generateOutline(string $title): array
    {
        return [
            'Introduction to '.$title,
            'Historical Context and Background',
            'Key Highlights and Major Events',
            'Detailed Analysis of Impact',
            'Community and Fan Reactions',
            'Future Outlook and Conclusion',
        ];
    }
}
