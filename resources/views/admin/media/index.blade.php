@extends('admin.layouts.app')

@section('title', 'Media Library — Debesties Studio')
@section('page_title', 'Media Library')

@section('content')

{{-- Toolbar --}}
<div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 16px;">
    <form method="GET" action="{{ route('admin.media.index') }}" style="display: flex; align-items: center; gap: 10px; flex: 1; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 8px; flex: 1; min-width: 200px; height: 38px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 0 12px;">
            <i data-lucide="search" style="width: 15px; height: 15px; color: var(--cms-fg4); flex-shrink: 0;"></i>
            <input name="search" value="{{ request('search') }}" placeholder="Search files…" style="border: none; outline: none; background: none; flex: 1; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1);" />
        </div>
        <select name="folder" onchange="this.form.submit()"
                style="height: 38px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
            @foreach($folders as $f)
                <option value="{{ $f }}" {{ request('folder', 'All') === $f ? 'selected' : '' }}>{{ ucfirst($f) }}</option>
            @endforeach
        </select>
    </form>
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
    <button onclick="document.getElementById('file-upload-input').click()"
            style="display: inline-flex; align-items: center; gap: 7px; height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;"
            onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
        <i data-lucide="upload" style="width: 15px; height: 15px;"></i>
        Upload Files
    </button>
    <form id="upload-form" method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" style="display: none;">
        @csrf
        <input type="file" name="files[]" id="file-upload-input" multiple accept="image/*" onchange="this.form.submit()" />
    </form>
</div>

@if(session('success'))
    <div style="background: var(--cms-green-soft); color: var(--cms-green-deep); padding: 12px 18px; border-radius: var(--cms-r-md); border: 1px solid rgba(26,138,75,0.2); margin-bottom: 16px; font-family: var(--cms-font-ui); font-size: 14px; font-weight: 600;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background: var(--cms-red-soft); color: var(--cms-red-deep); padding: 12px 18px; border-radius: var(--cms-r-md); border: 1px solid rgba(200,55,43,0.2); margin-bottom: 16px; font-family: var(--cms-font-ui); font-size: 14px; font-weight: 600;">
        {{ session('error') }}
    </div>
@endif

{{-- Grid View --}}
<div id="media-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 14px;">
    @forelse($files as $file)
        <div class="media-card" data-name="{{ strtolower($file->file_name) }}" data-folder="{{ $file->folder }}"
             style="background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card); cursor: pointer; transition: all 180ms; position: relative;"
             onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--cms-sh-pop)';"
             onmouseout="this.style.transform=''; this.style.boxShadow='var(--cms-sh-card)';"
             onclick="openDetail({{ $file->id }})">
            <div style="aspect-ratio: 4/3; overflow: hidden; background: var(--cms-bg);">
                <img src="{{ $file->file_url }}" alt="{{ $file->alt_text }}" loading="lazy"
                     style="width: 100%; height: 100%; object-fit: cover; transition: transform 300ms;" />
            </div>
            <div style="padding: 10px 12px;">
                <div style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $file->file_name }}</div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 4px;">
                    <span style="font-family: var(--cms-font-ui); font-size: 11.5px; color: var(--cms-fg4);">{{ number_format($file->file_size / 1024, 0) }} KB</span>
                    <span style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4);">{{ $file->width }}×{{ $file->height }}</span>
                </div>
            </div>
        </div>
    @empty
        <div style="grid-column: 1/-1; padding: 48px; text-align: center; background: var(--cms-surface); border: 1px dashed var(--cms-border); border-radius: var(--cms-r-lg);">
            <i data-lucide="image-off" style="width: 32px; height: 32px; color: var(--cms-fg4); margin: 0 auto 12px;"></i>
            <div style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 600; color: var(--cms-fg2);">No media files found</div>
        </div>
    @endforelse
</div>

{{-- List View --}}
<div id="media-list" style="display: none; background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid var(--cms-border);">
                <th style="width: 56px; padding: 10px 16px;"></th>
                <th style="padding: 10px 16px 10px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; font-family: var(--cms-font-ui);">Name</th>
                <th style="padding: 10px 16px 10px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; font-family: var(--cms-font-ui);">Type</th>
                <th style="padding: 10px 16px 10px 0; text-align: right; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; font-family: var(--cms-font-ui);">Size</th>
                <th style="padding: 10px 16px 10px 0; text-align: center; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; font-family: var(--cms-font-ui);">Dimensions</th>
                <th style="padding: 10px 16px 10px 0; text-align: right; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; font-family: var(--cms-font-ui);">Uploaded</th>
                <th style="padding: 10px 16px; width: 60px;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($files as $i => $file)
                <tr style="border-bottom: {{ !$loop->last ? '1px solid var(--cms-border)' : 'none' }}; transition: background 100ms; cursor: pointer;"
                    onclick="openDetail({{ $file->id }})"
                    onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 11px 16px;">
                        <img src="{{ $file->file_url }}" alt="{{ $file->alt_text }}" style="width: 44px; height: 36px; object-fit: cover; border-radius: 5px; display: block;" />
                    </td>
                    <td style="padding: 11px 16px 11px 0;">
                        <span style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 500; color: var(--cms-fg1);">{{ $file->file_name }}</span>
                    </td>
                    <td style="padding: 11px 16px 11px 0;">
                        <span style="font-family: var(--cms-font-mono); font-size: 11.5px; color: var(--cms-fg3);">{{ $file->mime_type }}</span>
                    </td>
                    <td style="padding: 11px 16px 11px 0; text-align: right;">
                        <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg3);">{{ number_format($file->file_size / 1024, 0) }} KB</span>
                    </td>
                    <td style="padding: 11px 16px 11px 0; text-align: center;">
                        <span style="font-family: var(--cms-font-mono); font-size: 11.5px; color: var(--cms-fg3);">{{ $file->width }}×{{ $file->height }}</span>
                    </td>
                    <td style="padding: 11px 16px 11px 0; text-align: right;">
                        <span style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4);">{{ $file->created_at->diffForHumans() }}</span>
                    </td>
                    <td style="padding: 11px 16px;" onclick="event.stopPropagation()">
                        <form method="POST" action="{{ route('admin.media.destroy', $file->id) }}" onsubmit="return confirm('Are you sure you want to delete this file?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(200,55,43,0.2); background: var(--cms-red-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red);"
                                    onmouseover="this.style.background='#F8D5D2'" onmouseout="this.style.background='var(--cms-red-soft)'">
                                <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 32px; text-align: center; font-family: var(--cms-font-ui); font-size: 14px; color: var(--cms-fg3);">No media files found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 16px;">
    {{ $files->links() }}
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
                <input id="detail-alt" type="text" readonly style="display: block; width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;" />
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
        <form id="detail-delete-form" method="POST" action="" style="flex: 1;" onsubmit="return confirm('Are you sure you want to delete this file?')">
            @csrf
            @method('DELETE')
            <button type="submit" style="width: 100%; height: 38px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; background: var(--cms-red-soft); color: var(--cms-red-deep); border: 1.5px solid rgba(200,55,43,0.2); border-radius: var(--cms-r-md); cursor: pointer;">Delete File</button>
        </form>
    </div>
</div>

<script>
    const mediaData = @json($files->items());
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
        document.getElementById('detail-img').src = f.file_url;
        document.getElementById('detail-img').alt = f.alt_text || '';
        document.getElementById('detail-alt').value = f.alt_text || '';
        document.getElementById('detail-url').value = f.file_url;
        
        const deleteForm = document.getElementById('detail-delete-form');
        const deleteUrl = "{{ route('admin.media.destroy', ':id') }}";
        deleteForm.action = deleteUrl.replace(':id', id);

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
</script>
@endsection
