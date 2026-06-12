@extends('admin.layouts.app')

@section('title', 'Posts — Debesties Studio')
@section('page_title', 'Posts')

@section('content')

<div style="display: flex; flex-direction: column; gap: 20px;">

    {{-- ── TOP ACTION ROW ────────────────────────────────────── --}}
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap;">
        {{-- Status Tabs --}}
        <div style="display: flex; gap: 2px; background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 3px; flex-shrink: 0; box-shadow: var(--cms-sh-card);">
            @foreach(['all'=>'All', 'published'=>'Published', 'draft'=>'Drafts', 'review'=>'In Review', 'scheduled'=>'Scheduled'] as $key => $label)
                @php $isActive = (request('status', 'all') === $key); @endphp
                <a href="{{ route('admin.posts.index', ['status' => $key]) }}"
                   style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 13px; border-radius: 7px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: {{ $isActive ? '700' : '500' }}; color: {{ $isActive ? 'var(--cms-fg1)' : 'var(--cms-fg3)' }}; background: {{ $isActive ? 'var(--cms-bg)' : 'transparent' }}; text-decoration: none; box-shadow: {{ $isActive ? 'var(--cms-sh-card)' : 'none' }}; transition: all 140ms ease;">
                    {{ $label }}
                    <span style="font-size: 11px; font-weight: 600; color: {{ $isActive ? 'var(--cms-fg3)' : 'var(--cms-fg4)' }};">{{ $counts[$key] }}</span>
                </a>
            @endforeach
        </div>

        {{-- Right: Search + New Post --}}
        <div style="display: flex; align-items: center; gap: 10px;">
            <form method="GET" action="{{ route('admin.posts.index') }}" style="display: flex; align-items: center; gap: 10px; margin: 0;">
                <input type="hidden" name="status" value="{{ request('status', 'all') }}" />
                @if(request('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}" />
                @endif
                @if(request('author_id'))
                    <input type="hidden" name="author_id" value="{{ request('author_id') }}" />
                @endif
                <div class="cms-search-bar" style="display: flex; align-items: center; gap: 8px; width: 220px; height: 38px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 0 12px; transition: all 140ms ease;">
                    <i data-lucide="search" style="width: 15px; height: 15px; color: var(--cms-fg4); flex-shrink: 0;"></i>
                    <input name="search" value="{{ request('search') }}" placeholder="Search posts…" 
                           style="border: none; outline: none; background: none; flex: 1; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); min-width: 0;" />
                </div>
            </form>
            <a href="{{ route('admin.posts.create') }}" class="btn-primary">
                <i data-lucide="plus" style="width: 16px; height: 16px; stroke-width: 2.2;"></i>
                New Post
            </a>
        </div>
    </div>

    {{-- ── FILTER ROW ──────────────────────────────────────────── --}}
    <form method="GET" action="{{ route('admin.posts.index') }}" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin: 0;">
        <input type="hidden" name="status" value="{{ request('status', 'all') }}" />
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}" />
        @endif
        
        {{-- Category filter --}}
        <select name="category_id" onchange="this.form.submit()" class="form-select" style="width: auto; height: 36px; padding: 0 32px 0 12px;">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        
        {{-- Author filter --}}
        <select name="author_id" onchange="this.form.submit()" class="form-select" style="width: auto; height: 36px; padding: 0 32px 0 12px;">
            <option value="">All Authors</option>
            @foreach($authors as $auth)
                <option value="{{ $auth->id }}" {{ request('author_id') == $auth->id ? 'selected' : '' }}>{{ $auth->name }}</option>
            @endforeach
        </select>

        <div style="flex: 1;"></div>

        {{-- Bulk action bar --}}
        <div id="bulk-bar" style="display: none; align-items: center; gap: 8px; animation: dsPop 180ms ease;">
            <span id="bulk-count" style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3); font-weight: 600;">0 selected</span>
            <button type="button" onclick="bulkAction('publish')" class="badge badge-success" style="height: 32px; cursor: pointer; border: 1px solid rgba(26,138,75,0.15);">Publish</button>
            <button type="button" onclick="bulkAction('draft')" class="badge badge-info" style="height: 32px; cursor: pointer; border: 1px solid rgba(47,107,216,0.15);">Move to Draft</button>
            <button type="button" onclick="bulkAction('trash')" class="badge badge-danger" style="height: 32px; cursor: pointer; border: 1px solid rgba(200,55,43,0.15);">Trash</button>
        </div>
    </form>

    {{-- ── TABLE ────────────────────────────────────────────────── --}}
    <div class="cms-card">
        <table class="cms-table" id="posts-table">
            <thead>
                <tr>
                    <th style="width: 40px; text-align: center; padding-right: 16px;">
                        <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)" style="cursor: pointer; accent-color: var(--cms-gold); width: 15px; height: 15px;" />
                    </th>
                    <th style="padding-left: 0; cursor: pointer;" onclick="sortTable('title')">
                        <span style="display: inline-flex; align-items: center; gap: 4px;">Title <i data-lucide="chevrons-up-down" style="width: 12px; height: 12px;"></i></span>
                    </th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th style="text-align: right; cursor: pointer;" onclick="sortTable('views')">
                        <span style="display: inline-flex; align-items: center; gap: 4px; justify-content: flex-end;">Views <i data-lucide="chevrons-up-down" style="width: 12px; height: 12px;"></i></span>
                    </th>
                    <th style="text-align: center;">SEO</th>
                    <th style="cursor: pointer;" onclick="sortTable('date')">
                        <span style="display: inline-flex; align-items: center; gap: 4px;">Date <i data-lucide="chevrons-up-down" style="width: 12px; height: 12px;"></i></span>
                    </th>
                    <th style="width: 48px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    @php 
                        $statusClass = [
                            'published' => 'badge-success',
                            'draft' => 'badge-info',
                            'review' => 'badge-warning',
                            'scheduled' => 'badge-warning',
                            'approved' => 'badge-success',
                            'archived' => 'badge-danger',
                        ][$post->status] ?? 'badge-info';
                    @endphp
                    <tr class="post-row">
                        {{-- Checkbox --}}
                        <td style="text-align: center; padding-right: 16px;">
                            <input type="checkbox" class="post-checkbox" value="{{ $post->id }}"
                                   onchange="updateBulkBar()"
                                   style="cursor: pointer; accent-color: var(--cms-gold); width: 15px; height: 15px;" />
                        </td>

                        {{-- Title + hover actions --}}
                        <td style="padding-left: 0; max-width: 340px;">
                            <div style="font-size: 14px; font-weight: 600; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px;">
                                {{ $post->title }}
                            </div>
                            <div class="row-actions" style="display: flex; gap: 10px;">
                                <a href="{{ route('admin.posts.edit', $post->id) }}"
                                   style="font-size: 11.5px; font-weight: 600; color: var(--cms-gold); text-decoration: none;"
                                   onmouseover="this.style.color='var(--cms-gold-deep)'" onmouseout="this.style.color='var(--cms-gold)'">Edit</a>
                                <span style="color: var(--cms-border-st); font-size: 11.5px;">|</span>
                                <a href="{{ route('admin.posts.show', $post->id) }}"
                                   style="font-size: 11.5px; font-weight: 600; color: var(--cms-fg3); text-decoration: none;"
                                   onmouseover="this.style.color='var(--cms-fg1)'" onmouseout="this.style.color='var(--cms-fg3)'">Preview</a>
                                <span style="color: var(--cms-border-st); font-size: 11.5px;">|</span>
                                <button onclick="confirmDelete({{ $post->id }})"
                                        style="font-size: 11.5px; font-weight: 600; color: var(--cms-red); background: none; border: none; cursor: pointer; padding: 0; font-family: var(--cms-font-ui);"
                                        onmouseover="this.style.color='var(--cms-red-deep)'" onmouseout="this.style.color='var(--cms-red)'">Trash</button>
                            </div>
                        </td>

                        {{-- Category --}}
                        <td style="white-space: nowrap;">
                            @if($post->category)
                                <span style="color: var(--cms-fg2);">{{ $post->category->name }}</span>
                            @else
                                <span style="color: var(--cms-fg4); font-style: italic;">Uncategorized</span>
                            @endif
                        </td>

                        {{-- Author --}}
                        <td style="white-space: nowrap;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 26px; height: 26px; border-radius: 999px; background: var(--cms-bg); color: var(--cms-fg1); display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; border: 1.5px solid var(--cms-border); flex-shrink: 0;">
                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                </div>
                                <span style="font-size: 13px; color: var(--cms-fg2);">{{ $post->user->name }}</span>
                            </div>
                        </td>

                        {{-- Status badge --}}
                        <td style="white-space: nowrap;">
                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>

                        {{-- Views --}}
                        <td style="text-align: right; font-weight: 600; color: var(--cms-fg1); white-space: nowrap;">
                            {{ number_format($post->view_count) }}
                        </td>

                        {{-- SEO Score --}}
                        <td style="text-align: center;">
                            @php $score = \App\Services\SeoService::calculateScore($post); @endphp
                            <div style="width: 32px; height: 32px; border-radius: 999px; border: 2px solid {{ $score > 70 ? 'var(--cms-green)' : ($score > 40 ? 'var(--cms-gold)' : 'var(--cms-red)') }}; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800; color: var(--cms-fg1); margin: 0 auto;">
                                {{ $score }}
                            </div>
                        </td>

                        {{-- Date --}}
                        <td style="font-size: 12.5px; color: var(--cms-fg3); white-space: nowrap;">
                            <div title="Created: {{ $post->created_at->format('M j, Y H:i') }}">
                                {{ $post->created_at->format('M j, Y') }}
                            </div>
                        </td>

                        {{-- Row menu --}}
                        <td style="text-align: center; position: relative;">
                            <button onclick="toggleRowMenu({{ $post->id }}, event)"
                                    style="border: none; background: none; cursor: pointer; color: var(--cms-fg4); padding: 6px; border-radius: 8px; display: flex; align-items: center; justify-content: center; transition: all 140ms ease;"
                                    onmouseover="this.style.background='var(--cms-bg)'; this.style.color='var(--cms-fg2)'"
                                    onmouseout="this.style.background='transparent'; this.style.color='var(--cms-fg4)'">
                                <i data-lucide="more-horizontal" style="width: 17px; height: 17px;"></i>
                            </button>
                            <div id="row-menu-{{ $post->id }}" style="display: none; position: absolute; right: 12px; top: 42px; width: 160px; background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-md); box-shadow: var(--cms-sh-pop); z-index: 50; overflow: hidden; animation: dsPop 150ms ease;">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" style="display: flex; align-items: center; gap: 8px; padding: 10px 14px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); text-decoration: none;" onmouseover="this.style.background='#FBF9F5'" onmouseout="this.style.background='transparent'">
                                    <i data-lucide="edit-2" style="width: 14px; height: 14px; color: var(--cms-fg3);"></i> Edit Post
                                </a>
                                <a href="{{ route('admin.posts.show', $post->id) }}" style="display: flex; align-items: center; gap: 8px; padding: 10px 14px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); text-decoration: none;" onmouseover="this.style.background='#FBF9F5'" onmouseout="this.style.background='transparent'">
                                    <i data-lucide="external-link" style="width: 14px; height: 14px; color: var(--cms-fg3);"></i> Preview
                                </a>
                                <div style="border-top: 1px solid var(--cms-border); margin: 4px 0;"></div>
                                <button onclick="confirmDelete({{ $post->id }})" style="display: flex; align-items: center; gap: 8px; padding: 10px 14px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-red); background: none; border: none; cursor: pointer; width: 100%; text-align: left;" onmouseover="this.style.background='var(--cms-red-soft)'" onmouseout="this.style.background='transparent'">
                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i> Move to Trash
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="padding: 60px 20px; text-align: center;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                <div style="width: 48px; height: 48px; border-radius: 999px; background: var(--cms-bg); display: flex; align-items: center; justify-content: center; color: var(--cms-fg4);">
                                    <i data-lucide="file-text" style="width: 24px; height: 24px;"></i>
                                </div>
                                <div style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 600; color: var(--cms-fg2);">No posts found</div>
                                <div style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg4);">Try adjusting your search or filters.</div>
                                <a href="{{ route('admin.posts.create') }}" class="btn-primary" style="margin-top: 8px;">Create your first post</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($posts->hasPages())
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-top: 1px solid var(--cms-border); background: #FDFBF8;">
                <span style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3);">Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of {{ $posts->total() }} posts</span>
                <div class="cms-pagination">
                    {{ $posts->links() }}
                </div>
            </div>
        @endif
    </div>

</div>

{{-- Delete Confirmation Modal --}}
<div id="delete-modal" style="display: none; position: fixed; inset: 0; background: rgba(26,20,16,0.4); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); z-index: 200; align-items: center; justify-content: center; animation: dsFade 180ms ease;" onclick="closeDeleteModal(event)">
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 32px; width: 400px; max-width: calc(100vw - 40px); box-shadow: var(--cms-sh-pop); animation: dsPop 200ms ease;" onclick="event.stopPropagation()">
        <div style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 16px;">
            <div style="width: 56px; height: 56px; border-radius: 999px; background: var(--cms-red-soft); display: flex; align-items: center; justify-content: center; color: var(--cms-red);">
                <i data-lucide="trash-2" style="width: 28px; height: 28px;"></i>
            </div>
            <div>
                <div style="font-family: var(--cms-font-disp); font-size: 20px; font-weight: 700; color: var(--cms-fg1);">Move to Trash?</div>
                <div style="font-family: var(--cms-font-ui); font-size: 14px; color: var(--cms-fg3); margin-top: 6px; line-height: 1.5;">This post will be removed from your active collection. You can recover it from the trash later.</div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; width: 100%; margin-top: 8px;">
                <button onclick="closeDeleteModal()" class="btn-secondary">Cancel</button>
                <button onclick="executeDelete()" class="btn-primary" style="background: var(--cms-red); color: #fff; box-shadow: 0 2px 4px rgba(200,55,43,0.15);">Move to Trash</button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteTargetId = null;

    function confirmDelete(id) {
        deleteTargetId = id;
        document.getElementById('delete-modal').style.display = 'flex';
        lucide.createIcons();
    }
    function closeDeleteModal(e) {
        document.getElementById('delete-modal').style.display = 'none';
    }

    function executeDelete() {
        if (!deleteTargetId) return;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('admin.posts.destroy', ':id') }}".replace(':id', deleteTargetId);
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden'; csrfToken.name = '_token'; csrfToken.value = "{{ csrf_token() }}";
        form.appendChild(csrfToken);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden'; methodInput.name = '_method'; methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    }

    function toggleSelectAll(master) {
        document.querySelectorAll('.post-checkbox').forEach(cb => cb.checked = master.checked);
        updateBulkBar();
    }
    function updateBulkBar() {
        const checked = document.querySelectorAll('.post-checkbox:checked');
        const bar = document.getElementById('bulk-bar');
        const count = document.getElementById('bulk-count');
        if (checked.length > 0) {
            bar.style.display = 'flex';
            count.textContent = checked.length + ' selected';
        } else {
            bar.style.display = 'none';
        }
    }
    function bulkAction(action) {
        const ids = [...document.querySelectorAll('.post-checkbox:checked')].map(c => c.value);
        console.log('Bulk action:', action, ids);
    }

    function toggleRowMenu(id, e) {
        e.stopPropagation();
        document.querySelectorAll('[id^="row-menu-"]').forEach(m => {
            if (m.id !== 'row-menu-' + id) m.style.display = 'none';
        });
        const menu = document.getElementById('row-menu-' + id);
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
    window.addEventListener('click', () => {
        document.querySelectorAll('[id^="row-menu-"]').forEach(m => m.style.display = 'none');
    });

    function sortTable(col) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', col);
        url.searchParams.set('direction', url.searchParams.get('direction') === 'asc' ? 'desc' : 'asc');
        window.location.href = url.href;
    }
</script>

<style>
    .cms-search-bar:focus-within {
        border-color: var(--cms-gold) !important;
        box-shadow: 0 0 0 3px rgba(232, 168, 0, 0.13) !important;
    }
    .cms-pagination nav { display: flex; gap: 4px; }
    .cms-pagination span, .cms-pagination a {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 32px; height: 32px; padding: 0 8px; border-radius: 6px;
        background: var(--cms-surface); border: 1px solid var(--cms-border);
        color: var(--cms-fg2); text-decoration: none; font-weight: 600;
    }
    .cms-pagination .active { background: var(--cms-gold); color: #1A1410; border-color: var(--cms-gold); }
    .cms-pagination a:hover { background: var(--cms-bg); border-color: var(--cms-border-st); }
</style>
@endsection
