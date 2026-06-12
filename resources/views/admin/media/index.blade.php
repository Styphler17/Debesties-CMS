@extends('admin.layouts.app')

@section('title', 'Media Library — Debesties Studio')
@section('page_title', 'Media Library')

@section('content')

{{-- Toolbar --}}
<div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 20px;">
    <form method="GET" action="{{ route('admin.media.index') }}" style="display: flex; align-items: center; gap: 12px; flex: 1; flex-wrap: wrap;">
        <div class="cms-search-bar" style="display: flex; align-items: center; gap: 8px; flex: 1; min-width: 240px; height: 40px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 0 12px; transition: all 140ms ease;">
            <i data-lucide="search" style="width: 16px; height: 16px; color: var(--cms-fg4); flex-shrink: 0;"></i>
            <input name="search" value="{{ request('search') }}" placeholder="Search files…" style="border: none; outline: none; background: none; flex: 1; font-family: var(--cms-font-ui); font-size: 14px; color: var(--cms-fg1);" />
        </div>
        <select name="folder" onchange="this.form.submit()" class="form-select" style="width: auto; height: 40px; padding: 0 32px 0 12px;">
            @foreach($folders as $f)
                <option value="{{ $f }}" {{ request('folder', 'All') === $f ? 'selected' : '' }}>{{ ucfirst($f) }}</option>
            @endforeach
        </select>
    </form>
    <div style="display: flex; gap: 0; border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); overflow: hidden; box-shadow: var(--cms-sh-card);">
        <button id="view-grid" onclick="setView('grid')"
                style="width: 40px; height: 38px; border: none; background: var(--cms-gold); cursor: pointer; display: flex; align-items: center; justify-content: center; color: #1A1410; transition: all 120ms ease;">
            <i data-lucide="layout-grid" style="width: 16px; height: 16px;"></i>
        </button>
        <button id="view-list" onclick="setView('list')"
                style="width: 40px; height: 38px; border: none; border-left: 1px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3); transition: all 120ms ease;">
            <i data-lucide="list" style="width: 16px; height: 16px;"></i>
        </button>
    </div>
    <button onclick="document.getElementById('file-upload-input').click()" class="btn-primary">
        <i data-lucide="upload" style="width: 16px; height: 16px; stroke-width: 2.5;"></i>
        Upload Media
    </button>
    <form id="upload-form" method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" style="display: none;">
        @csrf
        <input type="file" name="files[]" id="file-upload-input" multiple accept="image/*" onchange="this.form.submit()" />
    </form>
</div>

@if(session('success'))
    <div class="badge badge-success" style="width: 100%; padding: 12px 18px; margin-bottom: 20px; font-size: 13.5px; border-radius: var(--cms-r-md);">
        <i data-lucide="check-circle" style="width: 16px; height: 16px; margin-right: 8px;"></i>
        {{ session('success') }}
    </div>
@endif

{{-- Grid View --}}
<div id="media-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
    @forelse($files as $file)
        <div class="cms-card media-card" data-name="{{ strtolower($file->file_name) }}" data-folder="{{ $file->folder }}"
             style="cursor: pointer; position: relative;"
             onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='var(--cms-sh-raised)';"
             onmouseout="this.style.transform=''; this.style.boxShadow='var(--cms-sh-card)';"
             onclick="openDetail({{ $file->id }})">
            <div style="aspect-ratio: 1/1; overflow: hidden; background: #F9F7F3; display: flex; align-items: center; justify-content: center;">
                <img src="{{ $file->file_url }}" alt="{{ $file->alt_text }}" loading="lazy"
                     style="width: 100%; height: 100%; object-fit: cover;" />
            </div>
            <div style="padding: 12px 14px; border-top: 1px solid var(--cms-border);">
                <div style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $file->file_name }}</div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 6px;">
                    <span class="badge badge-info" style="font-size: 10px; padding: 1px 6px;">{{ strtoupper(pathinfo($file->file_name, PATHINFO_EXTENSION)) }}</span>
                    <span style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4); font-weight: 600;">{{ number_format($file->file_size / 1024, 0) }} KB</span>
                </div>
            </div>
        </div>
    @empty
        <div style="grid-column: 1/-1; padding: 80px 20px; text-align: center; background: var(--cms-surface); border: 2px dashed var(--cms-border); border-radius: var(--cms-r-xl); display: flex; flex-direction: column; align-items: center; gap: 16px;">
            <div style="width: 64px; height: 64px; border-radius: 999px; background: var(--cms-bg); display: flex; align-items: center; justify-content: center; color: var(--cms-fg4);">
                <i data-lucide="image" style="width: 32px; height: 32px;"></i>
            </div>
            <div>
                <div style="font-family: var(--cms-font-disp); font-size: 18px; font-weight: 700; color: var(--cms-fg1);">No media assets yet</div>
                <div style="font-family: var(--cms-font-ui); font-size: 14px; color: var(--cms-fg4); margin-top: 4px;">Upload images to start building your library.</div>
            </div>
            <button onclick="document.getElementById('file-upload-input').click()" class="btn-primary" style="margin-top: 8px;">Upload first file</button>
        </div>
    @endforelse
</div>

{{-- List View --}}
<div id="media-list" style="display: none;" class="cms-card">
    <table class="cms-table">
        <thead>
            <tr>
                <th style="width: 64px;"></th>
                <th style="padding-left: 0;">Name</th>
                <th>Extension</th>
                <th style="text-align: right;">Size</th>
                <th style="text-align: center;">Dimensions</th>
                <th style="text-align: right;">Uploaded</th>
                <th style="width: 60px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
                <tr onclick="openDetail({{ $file->id }})" style="cursor: pointer;">
                    <td style="padding: 10px 16px;">
                        <div style="width: 44px; height: 44px; border-radius: 8px; overflow: hidden; background: #F9F7F3; border: 1px solid var(--cms-border);">
                            <img src="{{ $file->file_url }}" alt="{{ $file->alt_text }}" style="width: 100%; height: 100%; object-fit: cover;" />
                        </div>
                    </td>
                    <td style="padding-left: 0;">
                        <span style="font-weight: 600; color: var(--cms-fg1);">{{ $file->file_name }}</span>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ strtoupper(pathinfo($file->file_name, PATHINFO_EXTENSION)) }}</span>
                    </td>
                    <td style="text-align: right; font-weight: 600;">
                        {{ number_format($file->file_size / 1024, 0) }} KB
                    </td>
                    <td style="text-align: center; font-family: var(--cms-font-mono); font-size: 11.5px; color: var(--cms-fg3);">
                        {{ $file->width }} × {{ $file->height }}
                    </td>
                    <td style="text-align: right; font-size: 12.5px; color: var(--cms-fg4);">
                        {{ $file->created_at->format('M j, Y') }}
                    </td>
                    <td style="text-align: center;" onclick="event.stopPropagation()">
                        <form method="POST" action="{{ route('admin.media.destroy', $file->id) }}" onsubmit="return confirm('Permanently delete this file?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="border: none; background: none; cursor: pointer; color: var(--cms-red); padding: 6px; border-radius: 6px; transition: all 140ms ease;" onmouseover="this.style.background='var(--cms-red-soft)'" onmouseout="this.style.background='transparent'">
                                <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top: 24px;">
    {{ $files->links() }}
</div>

{{-- Detail Panel --}}
<div id="detail-panel"
     style="display: none; position: fixed; top: 0; right: 0; bottom: 0; width: 340px; background: var(--cms-surface); border-left: 1px solid var(--cms-border); box-shadow: -10px 0 40px rgba(0,0,0,0.1); z-index: 150; overflow-y: auto; flex-direction: column; animation: cmsSlideLeft 250ms cubic-bezier(0.2, 0, 0, 1);">
    <div style="display: flex; align-items: center; justify-content: space-between; padding: 20px 24px; border-bottom: 1px solid var(--cms-border); position: sticky; top: 0; background: rgba(255,255,255,0.9); backdrop-filter: blur(8px); z-index: 2;">
        <span style="font-family: var(--cms-font-disp); font-size: 16px; font-weight: 700; color: var(--cms-fg1);">Asset Details</span>
        <button onclick="closeDetail()" style="width: 32px; height: 32px; border-radius: 8px; border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3); transition: all 140ms ease;" onmouseover="this.style.borderColor='var(--cms-fg4)'; this.style.color='var(--cms-fg1)'">
            <i data-lucide="x" style="width: 16px; height: 16px;"></i>
        </button>
    </div>
    <div style="padding: 24px; flex: 1; display: flex; flex-direction: column; gap: 20px;">
        <div style="width: 100%; border-radius: var(--cms-r-lg); overflow: hidden; border: 1px solid var(--cms-border); background: #F9F7F3;">
            <img id="detail-img" src="" alt="" style="width: 100%; display: block; object-fit: contain; max-height: 240px;" />
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 16px;">
            <div>
                <label class="form-label">Filename</label>
                <div id="detail-name" style="font-family: var(--cms-font-mono); font-size: 13px; color: var(--cms-fg1); word-break: break-all;"></div>
            </div>
            <div>
                <label class="form-label">Dimensions & Size</label>
                <div id="detail-specs" style="font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg2); font-weight: 600;"></div>
            </div>
            <div>
                <label class="form-label">Alt Text</label>
                <input id="detail-alt" type="text" class="form-input" placeholder="Describe this image for SEO…" />
            </div>
            <div>
                <label class="form-label">File URL</label>
                <div style="display: flex; gap: 8px;">
                    <input id="detail-url" readonly class="form-input" style="font-family: var(--cms-font-mono); font-size: 12px; background: var(--cms-bg); height: 36px;" />
                    <button onclick="copyUrl()" class="btn-secondary" style="width: 36px; height: 36px; padding: 0; flex-shrink: 0;" title="Copy to clipboard">
                        <i data-lucide="copy" style="width: 14px; height: 14px;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 20px 24px; border-top: 1px solid var(--cms-border); display: grid; grid-template-columns: 1fr 1fr; gap: 12px; position: sticky; bottom: 0; background: var(--cms-surface);">
        <button onclick="applyAltText()" class="btn-primary" style="font-size: 13px;">Save Edits</button>
        <form id="detail-delete-form" method="POST" action="" onsubmit="return confirm('Permanently delete this file?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-secondary" style="width: 100%; color: var(--cms-red); border-color: rgba(200,55,43,0.2); font-size: 13px;">Delete Asset</button>
        </form>
    </div>
</div>

<script>
    const mediaData = @json($files->items());
    let activeId = null;

    function setView(v) {
        const grid = document.getElementById('media-grid');
        const list = document.getElementById('media-list');
        const gridBtn = document.getElementById('view-grid');
        const listBtn = document.getElementById('view-list');

        if (v === 'grid') {
            grid.style.display = 'grid';
            list.style.display = 'none';
            gridBtn.style.background = 'var(--cms-gold)';
            gridBtn.style.color = '#1A1410';
            listBtn.style.background = 'var(--cms-surface)';
            listBtn.style.color = 'var(--cms-fg3)';
        } else {
            grid.style.display = 'none';
            list.style.display = 'block';
            gridBtn.style.background = 'var(--cms-surface)';
            gridBtn.style.color = 'var(--cms-fg3)';
            listBtn.style.background = 'var(--cms-gold)';
            listBtn.style.color = '#1A1410';
        }
    }

    function openDetail(id) {
        activeId = id;
        const f = mediaData.find(m => m.id === id);
        if (!f) return;
        
        document.getElementById('detail-img').src = f.file_url;
        document.getElementById('detail-name').textContent = f.file_name;
        document.getElementById('detail-specs').textContent = `${f.width}×${f.height} • ${Math.round(f.file_size/1024)} KB`;
        document.getElementById('detail-alt').value = f.alt_text || '';
        document.getElementById('detail-url').value = f.file_url;
        
        const deleteForm = document.getElementById('detail-delete-form');
        deleteForm.action = "{{ route('admin.media.destroy', ':id') }}".replace(':id', id);

        document.getElementById('detail-panel').style.display = 'flex';
        lucide.createIcons();
    }

    function closeDetail() {
        document.getElementById('detail-panel').style.display = 'none';
    }

    function copyUrl() {
        const input = document.getElementById('detail-url');
        input.select();
        document.execCommand('copy');
        // Simple visual feedback
        const btn = input.nextElementSibling;
        const icon = btn.querySelector('i');
        const oldIcon = icon.getAttribute('data-lucide');
        icon.setAttribute('data-lucide', 'check');
        lucide.createIcons();
        setTimeout(() => {
            icon.setAttribute('data-lucide', oldIcon);
            lucide.createIcons();
        }, 1500);
    }

    function applyAltText() {
        // Implementation for updating alt text via AJAX
        alert('Alt text updated (Simulated)');
    }
</script>

<style>
    @keyframes cmsSlideLeft {
        from { transform: translateX(100%); }
        to { transform: translateX(0); }
    }
    .media-card { transition: all 200ms cubic-bezier(0.2, 0, 0, 1); }
    .cms-search-bar:focus-within {
        border-color: var(--cms-gold) !important;
        box-shadow: 0 0 0 3px rgba(232, 168, 0, 0.13) !important;
    }
</style>
@endsection
