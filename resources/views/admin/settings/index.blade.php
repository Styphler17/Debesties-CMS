@extends('admin.layouts.app')

@section('title', 'Site Settings — Debesties Studio')
@section('page_title', 'Site Settings')

@section('content')

{{-- Toast Container --}}
<div id="toast-container" style="position: fixed; bottom: 24px; right: 24px; z-index: 999; display: flex; flex-direction: column; gap: 8px;"></div>

<style>
.robots-btn {
    flex: 1;
    height: 38px;
    border-radius: var(--cms-r-md);
    cursor: pointer;
    font-family: var(--cms-font-ui), sans-serif;
    font-size: 13px;
    transition: all 120ms;
}
#robots-index-btn.active {
    border: 1.5px solid var(--cms-gold) !important;
    background: var(--cms-gold-soft) !important;
    color: var(--cms-gold-deep) !important;
    font-weight: 700 !important;
}
#robots-index-btn:not(.active) {
    border: 1.5px solid var(--cms-border) !important;
    background: var(--cms-surface) !important;
    color: var(--cms-fg3) !important;
    font-weight: 600 !important;
}
#robots-noindex-btn.active {
    border: 1.5px solid var(--cms-red) !important;
    background: var(--cms-red-soft) !important;
    color: var(--cms-red-deep) !important;
    font-weight: 700 !important;
}
#robots-noindex-btn:not(.active) {
    border: 1.5px solid var(--cms-border) !important;
    background: var(--cms-surface) !important;
    color: var(--cms-fg3) !important;
    font-weight: 600 !important;
}
</style>

<div style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 16px;">

    {{-- Section 1: General Settings --}}
    <div class="settings-group" style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
        <header onclick="toggleAccordion('general')" style="padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: background 150ms;" onmouseover="this.style.background='#FDFBF9'" onmouseout="this.style.background='transparent'">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 40px; height: 40px; border-radius: var(--cms-r-md); background: var(--cms-gold-soft); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="sliders" style="width: 18px; height: 18px; color: var(--cms-gold-deep);"></i>
                </div>
                <div>
                    <h3 style="font-family: var(--cms-font-ui), sans-serif; font-size: 15px; font-weight: 700; color: var(--cms-fg1);">General Settings</h3>
                    <p style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; color: var(--cms-fg3); margin-top: 1px;">Configure site title, email, timezone, and formatting settings.</p>
                </div>
            </div>
            <i data-lucide="chevron-down" class="accordion-chevron" id="chevron-general" style="width: 18px; height: 18px; color: var(--cms-fg4); transition: transform 200ms;"></i>
        </header>

        <div class="accordion-content" id="content-general" style="border-top: 1px solid var(--cms-border); padding: 24px; display: block;">
            <form action="{{ route('admin.settings.store') }}" method="POST">
                @csrf
                <input type="hidden" name="settings_form_type" value="general">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div style="grid-column: span 2;">
                        <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Site Name</label>
                        <input type="text" name="site_name" value="{{ \App\Services\SettingsService::get('site_name', 'Debesties Studio') }}" required
                               style="display: block; width: 100%; height: 42px; padding: 0 12px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;"
                               onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                               onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'" />
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Tagline / Site Description</label>
                        <textarea name="site_description" style="display: block; width: 100%; height: 72px; padding: 10px 12px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; resize: none;"
                                  onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                                  onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'">{{ \App\Services\SettingsService::get('site_description', 'A premium digital publishing and creative blog CMS platform.') }}</textarea>
                    </div>

                    <div>
                        <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Site URL</label>
                        <div style="display: flex; align-items: center; background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); overflow: hidden; height: 42px;">
                            <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg4); padding: 0 12px; background: rgba(0,0,0,0.02); height: 100%; display: flex; align-items: center; border-right: 1.5px solid var(--cms-border);">https://</span>
                            <input type="text" name="site_url" value="{{ \App\Services\SettingsService::get('site_url', 'debesties.com') }}"
                                   style="border: none; outline: none; background: transparent; flex: 1; padding: 0 12px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1);" />
                        </div>
                    </div>

                    <div>
                        <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">System Email Address</label>
                        <input type="email" name="system_email" value="{{ \App\Services\SettingsService::get('system_email', 'hello@debesties.com') }}" required
                               style="display: block; width: 100%; height: 42px; padding: 0 12px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;"
                               onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                               onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'" />
                    </div>

                    <div>
                        <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Timezone</label>
                        <select name="timezone" style="display: block; width: 100%; height: 42px; padding: 0 12px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
                            @php $tz = \App\Services\SettingsService::get('timezone', 'Europe/Brussels'); @endphp
                            <option value="Europe/Brussels" {{ $tz == 'Europe/Brussels' ? 'selected' : '' }}>Europe/Brussels (Belgium)</option>
                            <option value="Africa/Accra" {{ $tz == 'Africa/Accra' ? 'selected' : '' }}>Africa/Accra (Ghana)</option>
                        </select>
                    </div>

                    <div>
                        <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Posts Per Page (Admin list)</label>
                        <input type="number" name="posts_per_page" value="{{ \App\Services\SettingsService::get('posts_per_page', '15') }}" min="5" max="100"
                               style="display: block; width: 100%; height: 42px; padding: 0 12px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;"
                               onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                               onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'" />
                    </div>
                </div>

                <div style="border-top: 1px solid var(--cms-border); padding-top: 18px; display: flex; justify-content: flex-end;">
                    <button type="submit"
                            style="display: inline-flex; align-items: center; gap: 7px; height: 38px; padding: 0 18px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; transition: background 150ms;"
                            onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                        <i data-lucide="save" style="width: 15px; height: 15px;"></i>
                        Save General Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Section 2: SEO Defaults --}}
    <div class="settings-group" style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
        <header onclick="toggleAccordion('seo')" style="padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: background 150ms;" onmouseover="this.style.background='#FDFBF9'" onmouseout="this.style.background='transparent'">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 40px; height: 40px; border-radius: var(--cms-r-md); background: var(--cms-blue-soft); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="search" style="width: 18px; height: 18px; color: var(--cms-blue);"></i>
                </div>
                <div>
                    <h3 style="font-family: var(--cms-font-ui), sans-serif; font-size: 15px; font-weight: 700; color: var(--cms-fg1);">SEO Defaults</h3>
                    <p style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; color: var(--cms-fg3); margin-top: 1px;">Manage default meta templates, Open Graph structures, and indexing rules.</p>
                </div>
            </div>
            <i data-lucide="chevron-down" class="accordion-chevron" id="chevron-seo" style="width: 18px; height: 18px; color: var(--cms-fg4); transition: transform 200ms;"></i>
        </header>

        <div class="accordion-content" id="content-seo" style="border-top: 1px solid var(--cms-border); padding: 24px; display: none;">
            <form action="{{ route('admin.settings.store') }}" method="POST">
                @csrf
                <input type="hidden" name="settings_form_type" value="seo">
                <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Default Meta Title Template</label>
                        <input type="text" name="default_meta_title" id="seo-title-template" value="{{ \App\Services\SettingsService::get('default_meta_title', '{title} — Debesties Studio') }}"
                               style="display: block; width: 100%; height: 42px; padding: 0 12px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; margin-bottom: 6px;"
                               onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                               onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'" />
                        <div style="display: flex; gap: 6px;">
                            <button type="button" onclick="insertSeoTag('{title}')" style="font-size: 11px; background: var(--cms-bg); border: 1px solid var(--cms-border); border-radius: var(--cms-r-sm); padding: 4px 8px; color: var(--cms-fg2); cursor: pointer;">+ Add Title Tag</button>
                            <button type="button" onclick="insertSeoTag('{site_name}')" style="font-size: 11px; background: var(--cms-bg); border: 1px solid var(--cms-border); border-radius: var(--cms-r-sm); padding: 4px 8px; color: var(--cms-fg2); cursor: pointer;">+ Add Site Name</button>
                        </div>
                    </div>

                    <div>
                        <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Default Meta Description</label>
                        <textarea name="default_meta_description" style="display: block; width: 100%; height: 72px; padding: 10px 12px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; resize: none;"
                                  onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                                  onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'">{{ \App\Services\SettingsService::get('default_meta_description', 'Discover the latest trends in art, entertainment, technology, and culture at Debesties Studio.') }}</textarea>
                    </div>

                    <div>
                        <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Default Open Graph (OG) Image</label>
                        <div style="display: flex; gap: 16px; align-items: center;">
                            <div style="width: 140px; height: 80px; border-radius: var(--cms-r-md); border: 1.5px solid var(--cms-border); background: #FAF9F6; overflow: hidden; display: flex; align-items: center; justify-content: center; position: relative;">
                                <img id="og-preview-img" src="https://images.unsplash.com/photo-1542435503-956c469947f6?q=80&w=200&auto=format&fit=crop" style="width: 100%; height: 100%; object-fit: cover;" />
                            </div>
                            <div>
                                <input type="file" id="og-file-input" style="display: none;" onchange="previewOgImage(this)" />
                                <button type="button" onclick="document.getElementById('og-file-input').click()"
                                        style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 600; background: var(--cms-surface); border: 1.5px solid var(--cms-border); padding: 8px 14px; border-radius: var(--cms-r-md); color: var(--cms-fg1); cursor: pointer; transition: all 120ms;"
                                        onmouseover="this.style.background='var(--cms-bg)'" onmouseout="this.style.background='var(--cms-surface)'">
                                    Replace Image
                                </button>
                                <p style="font-size: 11.5px; color: var(--cms-fg4); margin-top: 6px;">Recommended dimensions: 1200×630px (Landscape).</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Default Robots Meta Tag</label>
                        @php
                            $robotsIndex = \App\Services\SettingsService::get('robots_index', '1');
                        @endphp
                        <input type="hidden" name="robots_index" id="robots-index-input" value="{{ $robotsIndex }}" />
                        <div style="display: flex; gap: 8px;">
                            <button type="button" id="robots-index-btn" onclick="toggleRobots(true)" class="robots-btn {{ $robotsIndex == '1' ? 'active' : '' }}">
                                Index, Follow
                            </button>
                            <button type="button" id="robots-noindex-btn" onclick="toggleRobots(false)" class="robots-btn {{ $robotsIndex == '0' ? 'active' : '' }}">
                                Noindex, Nofollow
                            </button>
                        </div>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--cms-border); padding-top: 18px; display: flex; justify-content: flex-end;">
                    <button type="submit"
                            style="display: inline-flex; align-items: center; gap: 7px; height: 38px; padding: 0 18px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; transition: background 150ms;"
                            onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                        <i data-lucide="save" style="width: 15px; height: 15px;"></i>
                        Save SEO Defaults
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Section 3: Media Settings --}}
    <div class="settings-group" style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
        <header onclick="toggleAccordion('media')" style="padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: background 150ms;" onmouseover="this.style.background='#FDFBF9'" onmouseout="this.style.background='transparent'">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 40px; height: 40px; border-radius: var(--cms-r-md); background: var(--cms-green-soft); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="image" style="width: 18px; height: 18px; color: var(--cms-green);"></i>
                </div>
                <div>
                    <h3 style="font-family: var(--cms-font-ui), sans-serif; font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Media & Uploads</h3>
                    <p style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; color: var(--cms-fg3); margin-top: 1px;">Adjust maximum upload parameters, compressions, and accepted file extensions.</p>
                </div>
            </div>
            <i data-lucide="chevron-down" class="accordion-chevron" id="chevron-media" style="width: 18px; height: 18px; color: var(--cms-fg4); transition: transform 200ms;"></i>
        </header>

        <div class="accordion-content" id="content-media" style="border-top: 1px solid var(--cms-border); padding: 24px; display: none;">
            <form action="{{ route('admin.settings.store') }}" method="POST">
                @csrf
                <input type="hidden" name="settings_form_type" value="media">
                <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 20px;">
                    
                    {{-- Max Upload Limit --}}
                    @php
                        $maxUploadSize = \App\Services\SettingsService::get('max_upload_size', '20');
                    @endphp
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                            <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">Max File Upload Size</label>
                            <span id="max-size-val" style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 700; color: var(--cms-fg1);">{{ $maxUploadSize }} MB</span>
                        </div>
                        <input type="range" name="max_upload_size" min="2" max="100" value="{{ $maxUploadSize }}" oninput="document.getElementById('max-size-val').textContent = this.value + ' MB'"
                               style="width: 100%; accent-color: var(--cms-gold); height: 6px; border-radius: 999px; cursor: pointer; display: block;" />
                    </div>

                    {{-- Compress Quality slider --}}
                    @php
                        $compressionQuality = \App\Services\SettingsService::get('image_compression_quality', '82');
                    @endphp
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                            <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">Image Compression Quality</label>
                            <span id="compression-val" style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 700; color: var(--cms-green);">{{ $compressionQuality }}%</span>
                        </div>
                        <input type="range" name="image_compression_quality" min="50" max="100" value="{{ $compressionQuality }}" oninput="updateCompressionLabel(this.value)"
                               style="width: 100%; accent-color: var(--cms-gold); height: 6px; border-radius: 999px; cursor: pointer; display: block;" />
                    </div>

                    {{-- Accepted Formats checklist --}}
                    <div>
                        <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 10px;">Allowed File Formats</label>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                            @php
                                $allowedFormats = json_decode(\App\Services\SettingsService::get('allowed_formats', '["JPEG","PNG","WEBP","GIF","PDF","MP4"]'), true);
                                if (!is_array($allowedFormats)) {
                                    $allowedFormats = ["JPEG","PNG","WEBP","GIF","PDF","MP4"];
                                }
                            @endphp
                            @foreach(['JPEG','PNG','WEBP','GIF','PDF','MP4'] as $ext)
                                <label style="display: flex; align-items: center; gap: 8px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); padding: 10px; border-radius: var(--cms-r-md); border: 1.5px solid var(--cms-border); background: var(--cms-bg); cursor: pointer; user-select: none;"
                                       onmouseover="this.style.borderColor='var(--cms-border-st)'" onmouseout="this.style.borderColor='var(--cms-border)'">
                                    <input type="checkbox" name="allowed_formats[]" value="{{ $ext }}" {{ in_array($ext, $allowedFormats) ? 'checked' : '' }} style="accent-color: var(--cms-gold); cursor: pointer; width: 14px; height: 14px;" />
                                    {{ $ext }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div style="border-top: 1px solid var(--cms-border); padding-top: 18px; display: flex; justify-content: flex-end;">
                    <button type="submit"
                            style="display: inline-flex; align-items: center; gap: 7px; height: 38px; padding: 0 18px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; transition: background 150ms;"
                            onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                        <i data-lucide="save" style="width: 15px; height: 15px;"></i>
                        Save Media Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    let activeAccordion = 'general';
    let isRobotsIndex = document.getElementById('robots-index-input') ? document.getElementById('robots-index-input').value === '1' : true;

    function toggleAccordion(key) {
        const content = document.getElementById(`content-${key}`);
        const chevron = document.getElementById(`chevron-${key}`);
        
        if (!content) return;

        const isCurrentlyOpen = content.style.display !== 'none';

        // Close all accordion panels
        document.querySelectorAll('.accordion-content').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.accordion-chevron').forEach(el => el.style.transform = 'rotate(0deg)');

        if (!isCurrentlyOpen) {
            content.style.display = 'block';
            chevron.style.transform = 'rotate(180deg)';
            activeAccordion = key;
        } else {
            activeAccordion = null;
        }
    }

    // SEO Insert tag
    function insertSeoTag(tag) {
        const input = document.getElementById('seo-title-template');
        if (input) {
            const start = input.selectionStart;
            const end = input.selectionEnd;
            const val = input.value;
            input.value = val.substring(0, start) + tag + val.substring(end);
            input.focus();
            input.selectionStart = input.selectionEnd = start + tag.length;
        }
    }

    // Robots switch logic
    function toggleRobots(shouldIndex) {
        isRobotsIndex = shouldIndex;
        const indexInput = document.getElementById('robots-index-input');
        if (indexInput) {
            indexInput.value = shouldIndex ? '1' : '0';
        }
        const indexBtn = document.getElementById('robots-index-btn');
        const noindexBtn = document.getElementById('robots-noindex-btn');

        if (indexBtn && noindexBtn) {
            if (shouldIndex) {
                indexBtn.classList.add('active');
                noindexBtn.classList.remove('active');
            } else {
                indexBtn.classList.remove('active');
                noindexBtn.classList.add('active');
            }
        }
    }

    // File Preview
    function previewOgImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('og-preview-img').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Compression quality label helper
    function updateCompressionLabel(val) {
        const label = document.getElementById('compression-val');
        if (val >= 90) {
            label.textContent = `${val}% (Lossless / High Quality)`;
            label.style.color = 'var(--cms-green)';
        } else if (val >= 75) {
            label.textContent = `${val}% (Balanced / Recommended)`;
            label.style.color = 'var(--cms-blue)';
        } else {
            label.textContent = `${val}% (Low Size / Compressed)`;
            label.style.color = 'var(--cms-gold-deep)';
        }
    }

    // Toast Generator
    function showToast(message) {
        const container = document.getElementById('toast-container');
        if (!container) return;
        
        const toast = document.createElement('div');
        toast.style.cssText = "background: #17120D; border: 1.5px solid var(--cms-gold); border-radius: var(--cms-r-md); padding: 12px 20px; color: #fff; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 8px; box-shadow: var(--cms-sh-pop); animation: dsPop 180ms ease; min-width: 280px;";
        toast.innerHTML = `<i data-lucide="check-circle" style="width: 16px; height: 16px; color: var(--cms-gold); flex-shrink: 0;"></i> <span>${message}</span>`;
        
        container.appendChild(toast);
        if (window.lucide) {
            lucide.createIcons();
        }

        // Auto remove toast
        setTimeout(() => {
            toast.style.animation = "dsFade 200ms ease reverse";
            toast.style.opacity = "0";
            setTimeout(() => toast.remove(), 200);
        }, 3000);
    }
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast("{{ session('success') }}");
    });
</script>
@endif
@endsection
