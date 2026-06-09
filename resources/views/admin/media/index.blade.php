@extends('admin.layouts.app')

@section('title', 'Media Library — Debesties Studio')
@section('page_title', 'Media Library')

@section('content')
@php
    $files = [
        ['id'=>1,'name'=>'tgma-2024-winners.jpg','type'=>'image/jpeg','size'=>'248 KB','dims'=>'1200×800','folder'=>'articles','url'=>'https://placehold.co/400x267/2D2416/E8A800?text=TGMA+2024','uploaded'=>'2h ago','alt'=>'TGMA 2024 winners on stage'],
        ['id'=>2,'name'=>'black-sherif-profile.jpg','type'=>'image/jpeg','size'=>'184 KB','dims'=>'800×800','folder'=>'profiles','url'=>'https://placehold.co/400x400/1A1410/E8A800?text=Black+Sherif','uploaded'=>'5h ago','alt'=>'Black Sherif artist photo'],
        ['id'=>3,'name'=>'ghana-music-awards.jpg','type'=>'image/jpeg','size'=>'312 KB','dims'=>'1440×960','folder'=>'articles','url'=>'https://placehold.co/400x267/2D2416/C8372B?text=Ghana+Awards','uploaded'=>'1d ago','alt'=>'Ghana Music Awards ceremony'],
        ['id'=>4,'name'=>'debesties-logo.png','type'=>'image/png','size'=>'42 KB','dims'=>'512×512','folder'=>'branding','url'=>'https://placehold.co/400x400/E8A800/1A1410?text=Logo','uploaded'=>'3d ago','alt'=>'Debesties logo'],
        ['id'=>5,'name'=>'celebrity-feature.jpg','type'=>'image/jpeg','size'=>'290 KB','dims'=>'1280×720','folder'=>'articles','url'=>'https://placehold.co/400x225/2D2416/C8C8C8?text=Celebrity+Feature','uploaded'=>'4d ago','alt'=>'Celebrity feature image'],
        ['id'=>6,'name'=>'highlife-concert.jpg','type'=>'image/jpeg','size'=>'375 KB','dims'=>'1600×900','folder'=>'events','url'=>'https://placehold.co/400x225/1A1410/4A9EFF?text=Highlife+Concert','uploaded'=>'1w ago','alt'=>'Highlife concert crowd'],
        ['id'=>7,'name'=>'king-promise.jpg','type'=>'image/jpeg','size'=>'210 KB','dims'=>'900×900','folder'=>'profiles','url'=>'https://placehold.co/400x400/2D2416/E8A800?text=King+Promise','uploaded'=>'1w ago','alt'=>'King Promise artist photo'],
        ['id'=>8,'name'=>'sports-ghana.jpg','type'=>'image/jpeg','size'=>'268 KB','dims'=>'1200×800','folder'=>'articles','url'=>'https://placehold.co/400x267/1A1410/4CAF50?text=Sports+Ghana','uploaded'=>'2w ago','alt'=>'Ghana sports team'],
    ];

    $folders = ['All', 'articles', 'profiles', 'events', 'branding'];
@endphp

{{-- Toolbar --}}
<div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 16px;">
    <div style="display: flex; align-items: center; gap: 8px; flex: 1; min-width: 200px; height: 38px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 0 12px;">
        <i data-lucide="search" style="width: 15px; height: 15px; color: var(--cms-fg4); flex-shrink: 0;"></i>
        <input placeholder="Search files…" oninput="filterMedia(this.value)"
               style="border: none; outline: none; background: none; flex: 1; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1);" />
    </div>
    <select onchange="filterFolder(this.value)"
            style="height: 38px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
        @foreach($folders as $f)
            <option value="{{ $f }}">{{ ucfirst($f) }}</option>
        @endforeach
    </select>
    <div style="display: flex; gap: 0; border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); overflow: hidden;">
        <button id="view-grid" onclick="setView('grid')"
                style="width: 38px; height: 36px; border: none; background: var(--cms-gold); cursor: pointer; display: flex; align-items: center; justify-content: center; color: #1A1410;">
            <i data-lucide="layout-grid" style="width: 15px; height: 15px;"></i>
        </button>
        <button id="view-list" onclick="setView('list')"
                style="width: 38px; height: 36px; border: none; border-left: 1px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);">
            <i data-lucide="list" style="width: 15px; height: 15px;"></i>
        </button>
    </div>
    <div id="bulk-bar" style="display: none; align-items: center; gap: 8px;">
        <span id="bulk-count" style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3);">0 selected</span>
        <button style="height: 36px; padding: 0 14px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; background: var(--cms-red-soft); color: var(--cms-red-deep); border: 1.5px solid rgba(200,55,43,0.2); border-radius: var(--cms-r-md); cursor: pointer;">Delete Selected</button>
    </div>
    <button onclick="document.getElementById('file-upload-input').click()"
            style="display: inline-flex; align-items: center; gap: 7px; height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;"
            onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
        <i data-lucide="upload" style="width: 15px; height: 15px;"></i>
        Upload Files
    </button>
    <input type="file" id="file-upload-input" multiple accept="image/*" style="display: none;" onchange="handleUpload(this.files)" />
</div>

{{-- Upload Drop Zone --}}
<div id="drop-zone"
     style="border: 2px dashed var(--cms-border); border-radius: var(--cms-r-lg); padding: 28px; text-align: center; margin-bottom: 16px; transition: all 200ms; cursor: pointer; background: var(--cms-surface);"
     ondragover="event.preventDefault(); this.style.borderColor='var(--cms-gold)'; this.style.background='var(--cms-gold-soft)'"
     ondragleave="this.style.borderColor='var(--cms-border)'; this.style.background='var(--cms-surface)'"
     ondrop="handleDrop(event)"
     onclick="document.getElementById('file-upload-input').click()">
    <i data-lucide="image-plus" style="width: 28px; height: 28px; color: var(--cms-fg4); margin-bottom: 8px;"></i>
    <div style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 600; color: var(--cms-fg2);">Drop images here or <span style="color: var(--cms-gold);">browse files</span></div>
    <div style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg4); margin-top: 4px;">JPEG, PNG, WEBP, GIF — max 10MB per file</div>
    <div id="upload-progress-area" style="margin-top: 14px;"></div>
    <button onclick="event.stopPropagation(); document.getElementById('drop-zone').style.display='none'"
            style="margin-top: 12px; font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4); background: none; border: none; cursor: pointer; text-decoration: underline;">
        Hide upload area
    </button>
</div>

{{-- Grid View --}}
<div id="media-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 14px;">
    @foreach($files as $file)
        <div class="media-card" data-name="{{ strtolower($file['name']) }}" data-folder="{{ $file['folder'] }}"
             style="background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card); cursor: pointer; transition: all 180ms; position: relative;"
             onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--cms-sh-pop)'; this.querySelector('.hover-overlay').style.opacity='1'"
             onmouseout="this.style.transform=''; this.style.boxShadow='var(--cms-sh-card)'; this.querySelector('.hover-overlay').style.opacity='0'"
             onclick="openDetail({{ $file['id'] }})">
            {{-- Checkbox --}}
            <div class="hover-overlay" style="position: absolute; inset: 0; opacity: 0; transition: opacity 150ms; z-index: 2; pointer-events: none;">
                <div style="position: absolute; top: 8px; left: 8px; pointer-events: all;" onclick="event.stopPropagation()">
                    <input type="checkbox" class="media-cb" value="{{ $file['id'] }}" onchange="updateBulk()"
                           style="width: 18px; height: 18px; accent-color: var(--cms-gold); cursor: pointer; border-radius: 4px;" />
                </div>
            </div>
            <div style="aspect-ratio: 4/3; overflow: hidden; background: var(--cms-bg);">
                <img src="{{ $file['url'] }}" alt="{{ $file['alt'] }}" loading="lazy"
                     style="width: 100%; height: 100%; object-fit: cover; transition: transform 300ms;"
                     onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform=''" />
            </div>
            <div style="padding: 10px 12px;">
                <div style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $file['name'] }}</div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 4px;">
                    <span style="font-family: var(--cms-font-ui); font-size: 11.5px; color: var(--cms-fg4);">{{ $file['size'] }}</span>
                    <span style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4);">{{ $file['dims'] }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- List View --}}
<div id="media-list" style="display: none; background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid var(--cms-border);">
                <th style="width: 40px; padding: 10px 16px; text-align: center;"><input type="checkbox" onchange="toggleAll(this)" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" /></th>
                <th style="width: 56px; padding: 10px 0;"></th>
                <th style="padding: 10px 16px 10px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; font-family: var(--cms-font-ui);">Name</th>
                <th style="padding: 10px 16px 10px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; font-family: var(--cms-font-ui);">Type</th>
                <th style="padding: 10px 16px 10px 0; text-align: right; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; font-family: var(--cms-font-ui);">Size</th>
                <th style="padding: 10px 16px 10px 0; text-align: center; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; font-family: var(--cms-font-ui);">Dimensions</th>
                <th style="padding: 10px 16px 10px 0; text-align: right; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; font-family: var(--cms-font-ui);">Uploaded</th>
                <th style="padding: 10px 16px; width: 60px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $i => $file)
                <tr style="border-bottom: {{ $i < count($files)-1 ? '1px solid var(--cms-border)' : 'none' }}; transition: background 100ms; cursor: pointer;"
                    onclick="openDetail({{ $file['id'] }})"
                    onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 11px 16px; text-align: center;" onclick="event.stopPropagation()">
                        <input type="checkbox" class="media-cb" value="{{ $file['id'] }}" onchange="updateBulk()" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                    </td>
                    <td style="padding: 11px 0;">
                        <img src="{{ $file['url'] }}" alt="{{ $file['alt'] }}" style="width: 44px; height: 36px; object-fit: cover; border-radius: 5px; display: block;" />
                    </td>
                    <td style="padding: 11px 16px 11px 0;">
                        <span style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 500; color: var(--cms-fg1);">{{ $file['name'] }}</span>
                    </td>
                    <td style="padding: 11px 16px 11px 0;">
                        <span style="font-family: var(--cms-font-mono); font-size: 11.5px; color: var(--cms-fg3);">{{ $file['type'] }}</span>
                    </td>
                    <td style="padding: 11px 16px 11px 0; text-align: right;">
                        <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg3);">{{ $file['size'] }}</span>
                    </td>
                    <td style="padding: 11px 16px 11px 0; text-align: center;">
                        <span style="font-family: var(--cms-font-mono); font-size: 11.5px; color: var(--cms-fg3);">{{ $file['dims'] }}</span>
                    </td>
                    <td style="padding: 11px 16px 11px 0; text-align: right;">
                        <span style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4);">{{ $file['uploaded'] }}</span>
                    </td>
                    <td style="padding: 11px 16px;" onclick="event.stopPropagation()">
                        <button onclick="confirmDelete({{ $file['id'] }})"
                                style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(200,55,43,0.2); background: var(--cms-red-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red);"
                                onmouseover="this.style.background='#F8D5D2'" onmouseout="this.style.background='var(--cms-red-soft)'">
                            <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Detail Panel --}}
<div id="detail-panel"
     style="display: none; position: fixed; top: 0; right: 0; bottom: 0; width: 320px; background: var(--cms-surface); border-left: 1px solid var(--cms-border); box-shadow: -6px 0 24px rgba(0,0,0,0.12); z-index: 150; overflow-y: auto; flex-direction: column;">
    <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 18px; border-bottom: 1px solid var(--cms-border); position: sticky; top: 0; background: var(--cms-surface); z-index: 2;">
        <span style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">File Details</span>
        <button onclick="closeDetail()" style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-bg); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);">
            <i data-lucide="x" style="width: 14px; height: 14px;"></i>
        </button>
    </div>
    <div style="padding: 18px; flex: 1;">
        <img id="detail-img" src="" alt="" style="width: 100%; border-radius: var(--cms-r-md); margin-bottom: 16px; object-fit: cover; max-height: 200px;" />
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg4); text-transform: uppercase; letter-spacing: 0.06em; display: block; margin-bottom: 5px;">Alt Text</label>
                <input id="detail-alt" type="text" style="display: block; width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;"
                       onfocus="this.style.borderColor='var(--cms-gold)'" onblur="this.style.borderColor='var(--cms-border)'" />
            </div>
            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg4); text-transform: uppercase; letter-spacing: 0.06em; display: block; margin-bottom: 5px;">Caption</label>
                <textarea rows="2" style="display: block; width: 100%; padding: 8px 10px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; resize: vertical;"
                          onfocus="this.style.borderColor='var(--cms-gold)'" onblur="this.style.borderColor='var(--cms-border)'"></textarea>
            </div>
            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg4); text-transform: uppercase; letter-spacing: 0.06em; display: block; margin-bottom: 5px;">File URL</label>
                <div style="display: flex; gap: 6px;">
                    <input id="detail-url" readonly style="flex: 1; height: 34px; padding: 0 10px; font-family: var(--cms-font-mono); font-size: 11.5px; color: var(--cms-fg3); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;" />
                    <button onclick="copyUrl()" style="width: 34px; height: 34px; border-radius: var(--cms-r-md); border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);"
                            title="Copy URL" onmouseover="this.style.background='var(--cms-bg)'" onmouseout="this.style.background='var(--cms-surface)'">
                        <i data-lucide="copy" style="width: 13px; height: 13px;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 16px 18px; border-top: 1px solid var(--cms-border); display: flex; gap: 8px; position: sticky; bottom: 0; background: var(--cms-surface);">
        <button style="flex: 1; height: 38px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;"
                onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">Save Changes</button>
        <button onclick="confirmDelete()" style="height: 38px; padding: 0 14px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; background: var(--cms-red-soft); color: var(--cms-red-deep); border: 1.5px solid rgba(200,55,43,0.2); border-radius: var(--cms-r-md); cursor: pointer;">Delete</button>
    </div>
</div>

<script>
    const mediaData = @json($files);
    let activeId = null;

    function setView(v) {
        if (v === 'grid') {
            document.getElementById('media-grid').style.display = 'grid';
            document.getElementById('media-list').style.display = 'none';
            document.getElementById('view-grid').style.background = 'var(--cms-gold)';
            document.getElementById('view-grid').style.color = '#1A1410';
            document.getElementById('view-list').style.background = 'var(--cms-surface)';
            document.getElementById('view-list').style.color = 'var(--cms-fg3)';
        } else {
            document.getElementById('media-grid').style.display = 'none';
            document.getElementById('media-list').style.display = 'block';
            document.getElementById('view-grid').style.background = 'var(--cms-surface)';
            document.getElementById('view-grid').style.color = 'var(--cms-fg3)';
            document.getElementById('view-list').style.background = 'var(--cms-gold)';
            document.getElementById('view-list').style.color = '#1A1410';
        }
    }

    function openDetail(id) {
        activeId = id;
        const f = mediaData.find(m => m.id === id);
        if (!f) return;
        document.getElementById('detail-img').src = f.url;
        document.getElementById('detail-img').alt = f.alt;
        document.getElementById('detail-alt').value = f.alt;
        document.getElementById('detail-url').value = f.url;
        const panel = document.getElementById('detail-panel');
        panel.style.display = 'flex';
        setTimeout(() => lucide.createIcons(), 50);
    }

    function closeDetail() {
        document.getElementById('detail-panel').style.display = 'none';
    }

    function copyUrl() {
        navigator.clipboard.writeText(document.getElementById('detail-url').value).catch(() => {});
    }

    function filterMedia(q) {
        const lq = q.toLowerCase();
        document.querySelectorAll('.media-card').forEach(c => c.style.display = c.dataset.name.includes(lq) ? '' : 'none');
    }

    function filterFolder(folder) {
        document.querySelectorAll('.media-card').forEach(c => {
            c.style.display = (folder === 'All' || c.dataset.folder === folder) ? '' : 'none';
        });
    }

    function handleUpload(files) {
        const area = document.getElementById('upload-progress-area');
        area.innerHTML = '';
        Array.from(files).forEach(f => {
            const bar = document.createElement('div');
            bar.style.cssText = 'margin: 6px auto; max-width: 280px; background: var(--cms-border); border-radius: 999px; height: 4px; overflow: hidden;';
            const fill = document.createElement('div');
            fill.style.cssText = 'height: 100%; background: var(--cms-gold); width: 0; border-radius: 999px; transition: width 600ms;';
            bar.appendChild(fill);
            const label = document.createElement('div');
            label.style.cssText = 'font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg3); text-align: center; margin-bottom: 4px;';
            label.textContent = f.name;
            area.appendChild(label); area.appendChild(bar);
            setTimeout(() => { fill.style.width = '100%'; }, 50);
        });
    }

    function handleDrop(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--cms-border)';
        this.style.background = 'var(--cms-surface)';
        handleUpload(e.dataTransfer.files);
    }

    function updateBulk() {
        const n = document.querySelectorAll('.media-cb:checked').length;
        const bar = document.getElementById('bulk-bar');
        bar.style.display = n > 0 ? 'flex' : 'none';
        document.getElementById('bulk-count').textContent = n + ' selected';
    }

    function toggleAll(master) {
        document.querySelectorAll('.media-cb').forEach(cb => cb.checked = master.checked);
        updateBulk();
    }

    function confirmDelete(id) { console.log('Delete media', id || activeId); }
</script>
@endsection
