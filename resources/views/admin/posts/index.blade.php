@extends('admin.layouts.app')

@section('title', 'Posts — Debesties Studio')
@section('page_title', 'Posts')

@section('content')

<div style="display: flex; flex-direction: column; gap: 20px;">

    {{-- ── TOP ACTION ROW ────────────────────────────────────── --}}
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap;">
        {{-- Status Tabs --}}
        <div style="display: flex; gap: 2px; background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 3px; flex-shrink: 0;">
            @foreach(['all'=>'All', 'published'=>'Published', 'draft'=>'Drafts', 'review'=>'In Review', 'scheduled'=>'Scheduled'] as $key => $label)
                @php $isActive = (request('status', 'all') === $key); @endphp
                <a href="{{ route('admin.posts.index', ['status' => $key]) }}"
                   style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 13px; border-radius: 7px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: {{ $isActive ? '700' : '500' }}; color: {{ $isActive ? 'var(--cms-fg1)' : 'var(--cms-fg3)' }}; background: {{ $isActive ? 'var(--cms-bg)' : 'transparent' }}; text-decoration: none; box-shadow: {{ $isActive ? 'var(--cms-sh-card)' : 'none' }}; transition: color 120ms, background 120ms;">
                    {{ $label }}
                    <span style="font-size: 11px; font-weight: 600; color: {{ $isActive ? 'var(--cms-fg3)' : 'var(--cms-fg4)' }};">{{ $counts[$key] }}</span>
                </a>
            @endforeach
        </div>

        {{-- Right: Search + New Post --}}
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 8px; width: 220px; height: 38px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 0 12px;"
                 onfocusin="this.style.borderColor='var(--cms-gold)'"
                 onfocusout="this.style.borderColor='var(--cms-border)'">
                <i data-lucide="search" style="width: 15px; height: 15px; color: var(--cms-fg4); flex-shrink: 0;"></i>
                <input placeholder="Search posts…" style="border: none; outline: none; background: none; flex: 1; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); min-width: 0;" />
            </div>
            <a href="{{ route('admin.posts.create') }}"
               style="display: inline-flex; align-items: center; gap: 7px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; padding: 0 18px; height: 38px; background: var(--cms-gold); color: #1A1410; border-radius: var(--cms-r-md); text-decoration: none; white-space: nowrap;"
               onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                <i data-lucide="plus" style="width: 16px; height: 16px; stroke-width: 2.2;"></i>
                New Post
            </a>
        </div>
    </div>

    {{-- ── FILTER ROW ──────────────────────────────────────────── --}}
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        {{-- Category filter --}}
        <select style="height: 36px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg2); background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
            <option value="">All Categories</option>
            <option>Awards History</option>
            <option>Profiles</option>
            <option>Analysis</option>
            <option>Explainers</option>
            <option>News</option>
        </select>
        {{-- Author filter --}}
        <select style="height: 36px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg2); background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
            <option value="">All Authors</option>
            <option>Ama Boateng</option>
            <option>Yaw Owusu</option>
            <option>Kwesi Mensah</option>
            <option>Esi Arthur</option>
        </select>
        {{-- Date filter --}}
        <select style="height: 36px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg2); background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
            <option value="">Any Date</option>
            <option>This Week</option>
            <option>This Month</option>
            <option>Last 3 Months</option>
        </select>

        <div style="flex: 1;"></div>

        {{-- Bulk action bar (shows when items checked) --}}
        <div id="bulk-bar" style="display: none; align-items: center; gap: 8px; animation: dsPop 180ms ease;">
            <span id="bulk-count" style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3);">0 selected</span>
            <button onclick="bulkAction('publish')" style="height: 34px; padding: 0 14px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; background: var(--cms-green-soft); color: var(--cms-green-deep); border: 1.5px solid rgba(26,138,75,0.2); border-radius: var(--cms-r-md); cursor: pointer;">Publish</button>
            <button onclick="bulkAction('draft')" style="height: 34px; padding: 0 14px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; background: #F0EDE8; color: var(--cms-fg3); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Move to Draft</button>
            <button onclick="bulkAction('trash')" style="height: 34px; padding: 0 14px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; background: var(--cms-red-soft); color: var(--cms-red-deep); border: 1.5px solid rgba(200,55,43,0.2); border-radius: var(--cms-r-md); cursor: pointer;">Trash</button>
        </div>

        {{-- Items per page --}}
        <select style="height: 36px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg2); background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
            <option>25 / page</option>
            <option>50 / page</option>
            <option>100 / page</option>
        </select>
    </div>

    {{-- ── TABLE ────────────────────────────────────────────────── --}}
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
        <table style="width: 100%; border-collapse: collapse; font-family: var(--cms-font-ui);" id="posts-table">
            <thead>
                <tr style="border-bottom: 1px solid var(--cms-border);">
                    <th style="width: 40px; padding: 11px 16px; text-align: center;">
                        <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)" style="cursor: pointer; accent-color: var(--cms-gold); width: 15px; height: 15px;" />
                    </th>
                    <th style="padding: 11px 16px 11px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase; cursor: pointer; white-space: nowrap;" onclick="sortTable('title')">
                        <span style="display: inline-flex; align-items: center; gap: 4px;">Title <i data-lucide="chevrons-up-down" style="width: 12px; height: 12px;"></i></span>
                    </th>
                    <th style="padding: 11px 16px 11px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase; white-space: nowrap;">Category</th>
                    <th style="padding: 11px 16px 11px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase; white-space: nowrap;">Author</th>
                    <th style="padding: 11px 16px 11px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase; white-space: nowrap;">Status</th>
                    <th style="padding: 11px 16px 11px 0; text-align: right; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase; cursor: pointer; white-space: nowrap;" onclick="sortTable('views')">
                        <span style="display: inline-flex; align-items: center; gap: 4px; justify-content: flex-end;">Views <i data-lucide="chevrons-up-down" style="width: 12px; height: 12px;"></i></span>
                    </th>
                    <th style="padding: 11px 16px 11px 0; text-align: center; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase; white-space: nowrap;">SEO</th>
                    <th style="padding: 11px 16px 11px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase; cursor: pointer; white-space: nowrap;" onclick="sortTable('date')">
                        <span style="display: inline-flex; align-items: center; gap: 4px;">Date <i data-lucide="chevrons-up-down" style="width: 12px; height: 12px;"></i></span>
                    </th>
                    <th style="padding: 11px 16px; width: 48px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    @php $sm = $statusMeta[$post->status] ?? $statusMeta['draft']; @endphp
                    <tr class="post-row"
                        style="border-bottom: {{ !$loop->last ? '1px solid var(--cms-border)' : 'none' }}; transition: background 100ms; cursor: default;"
                        onmouseover="this.style.background='#FDFBF8'"
                        onmouseout="this.style.background='transparent'">

                        {{-- Checkbox --}}
                        <td style="padding: 14px 16px; text-align: center;">
                            <input type="checkbox" class="post-checkbox" value="{{ $post->id }}"
                                   onchange="updateBulkBar()"
                                   style="cursor: pointer; accent-color: var(--cms-gold); width: 15px; height: 15px;" />
                        </td>

                        {{-- Title + hover actions --}}
                        <td style="padding: 14px 16px 14px 0; max-width: 340px;">
                            <div style="font-size: 13.5px; font-weight: 600; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 4px;">
                                {{ $post->title }}
                            </div>
                            <div class="row-actions" style="display: flex; gap: 10px;">
                                <a href="{{ route('admin.posts.edit', $post->id) }}"
                                   style="font-size: 12px; font-weight: 600; color: var(--cms-gold); text-decoration: none;"
                                   onmouseover="this.style.color='var(--cms-gold-deep)'" onmouseout="this.style.color='var(--cms-gold)'">Edit</a>
                                <span style="color: var(--cms-border-st); font-size: 12px;">|</span>
                                <a href="{{ route('admin.posts.show', $post->id) }}"
                                   style="font-size: 12px; font-weight: 600; color: var(--cms-fg3); text-decoration: none;"
                                   onmouseover="this.style.color='var(--cms-fg1)'" onmouseout="this.style.color='var(--cms-fg3)'">Preview</a>
                                <span style="color: var(--cms-border-st); font-size: 12px;">|</span>
                                <button onclick="confirmDelete({{ $post->id }})"
                                        style="font-size: 12px; font-weight: 600; color: var(--cms-red); background: none; border: none; cursor: pointer; padding: 0; font-family: var(--cms-font-ui);"
                                        onmouseover="this.style.color='var(--cms-red-deep)'" onmouseout="this.style.color='var(--cms-red)'">Trash</button>
                            </div>
                        </td>

                        {{-- Category --}}
                        <td style="padding: 14px 16px 14px 0; font-size: 13px; color: var(--cms-fg2); white-space: nowrap;">
                            {{ $post->category?->name ?? '—' }}
                        </td>

                        {{-- Author --}}
                        <td style="padding: 14px 16px 14px 0; white-space: nowrap;">
                            <div style="display: flex; align-items: center; gap: 7px;">
                                <div style="width: 24px; height: 24px; border-radius: 999px; background: rgba(74,66,54,0.12); color: var(--cms-fg2); display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; border: 1px solid rgba(74,66,54,0.18); flex-shrink: 0;">
                                    {{ strtoupper(substr($post->user->name, 0, 1) . substr(strrchr($post->user->name, ' ') ?: ' ', 1, 1)) }}
                                </div>
                                <span style="font-size: 13px; color: var(--cms-fg2);">{{ $post->user->name }}</span>
                            </div>
                        </td>

                        {{-- Status badge --}}
                        <td style="padding: 14px 16px 14px 0; white-space: nowrap;">
                            <span style="display: inline-flex; align-items: center; gap: 4px; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 999px; background: {{ $sm['bg'] }}; color: {{ $sm['color'] }};">
                                @if($post->status === 'published')
                                    <span style="width: 6px; height: 6px; border-radius: 999px; background: var(--cms-green); display: inline-block;"></span>
                                @elseif($post->status === 'scheduled')
                                    <i data-lucide="clock" style="width: 11px; height: 11px;"></i>
                                @elseif($post->status === 'review')
                                    <i data-lucide="eye" style="width: 11px; height: 11px;"></i>
                                @endif
                                {{ $sm['label'] }}
                            </span>
                        </td>

                        {{-- Views --}}
                        <td style="padding: 14px 16px 14px 0; text-align: right; font-size: 13px; color: var(--cms-fg2); font-weight: 500; white-space: nowrap;">
                            {{ number_format($post->view_count) }}
                        </td>

                        {{-- SEO Score --}}
                        <td style="padding: 14px 16px 14px 0; text-align: center;">
                            <span style="font-size: 13px; color: var(--cms-fg4);">—</span>
                        </td>

                        {{-- Date --}}
                        <td style="padding: 14px 16px 14px 0; font-size: 12.5px; color: var(--cms-fg3); white-space: nowrap;">
                            {{ $post->created_at->format('M j, Y') }}
                        </td>

                        {{-- Row menu --}}
                        <td style="padding: 14px 16px; text-align: center; position: relative;">
                            <button onclick="toggleRowMenu({{ $post->id }}, event)"
                                    style="border: none; background: none; cursor: pointer; color: var(--cms-fg4); padding: 4px; border-radius: 6px; display: flex; align-items: center; justify-content: center;"
                                    onmouseover="this.style.background='var(--cms-border)'; this.style.color='var(--cms-fg2)'"
                                    onmouseout="this.style.background='transparent'; this.style.color='var(--cms-fg4)'">
                                <i data-lucide="more-horizontal" style="width: 17px; height: 17px;"></i>
                            </button>
                            <div id="row-menu-{{ $post->id }}" style="display: none; position: absolute; right: 12px; top: 42px; width: 160px; background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-md); box-shadow: var(--cms-sh-pop); z-index: 50; overflow: hidden; animation: dsPop 150ms ease;">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 14px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); text-decoration: none;" onmouseover="this.style.background='#FBF9F5'" onmouseout="this.style.background='transparent'">
                                    <i data-lucide="edit-2" style="width: 14px; height: 14px; color: var(--cms-fg3);"></i> Edit
                                </a>
                                <a href="#" style="display: flex; align-items: center; gap: 8px; padding: 9px 14px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); text-decoration: none;" onmouseover="this.style.background='#FBF9F5'" onmouseout="this.style.background='transparent'">
                                    <i data-lucide="copy" style="width: 14px; height: 14px; color: var(--cms-fg3);"></i> Duplicate
                                </a>
                                <a href="#" style="display: flex; align-items: center; gap: 8px; padding: 9px 14px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); text-decoration: none;" onmouseover="this.style.background='#FBF9F5'" onmouseout="this.style.background='transparent'">
                                    <i data-lucide="external-link" style="width: 14px; height: 14px; color: var(--cms-fg3);"></i> View live
                                </a>
                                <div style="border-top: 1px solid var(--cms-border); margin: 3px 0;"></div>
                                <button onclick="confirmDelete({{ $post->id }})" style="display: flex; align-items: center; gap: 8px; padding: 9px 14px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-red); background: none; border: none; cursor: pointer; width: 100%; text-align: left;" onmouseover="this.style.background='var(--cms-red-soft)'" onmouseout="this.style.background='transparent'">
                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i> Move to Trash
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 20px; border-top: 1px solid var(--cms-border);">
            <span style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3);">Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of {{ $posts->total() }} posts</span>
            <div style="font-family: var(--cms-font-ui); font-size: 13px;">
                {{ $posts->links() }}
            </div>
        </div>
    </div>

</div>

{{-- Delete Confirmation Modal --}}
<div id="delete-modal" style="display: none; position: fixed; inset: 0; background: rgba(20,16,12,0.5); z-index: 200; display: flex; align-items: center; justify-content: center; animation: dsFade 180ms ease;" onclick="closeDeleteModal(event)" style="display: none;">
    <div style="background: var(--cms-surface); border-radius: var(--cms-r-xl); padding: 28px; width: 380px; max-width: calc(100vw - 40px); box-shadow: var(--cms-sh-pop); animation: dsPop 200ms ease;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
            <div style="width: 40px; height: 40px; border-radius: var(--cms-r-md); background: var(--cms-red-soft); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-lucide="trash-2" style="width: 20px; height: 20px; color: var(--cms-red);"></i>
            </div>
            <div>
                <div style="font-family: var(--cms-font-ui); font-size: 16px; font-weight: 700; color: var(--cms-fg1);">Move to Trash?</div>
                <div style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3); margin-top: 2px;">This post will be moved to trash. You can restore it later.</div>
            </div>
        </div>
        <div style="display: flex; gap: 8px; justify-content: flex-end; margin-top: 20px;">
            <button onclick="closeDeleteModal()" style="height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-surface); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Cancel</button>
            <button onclick="executeDelete()" style="height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-red); color: #fff; border: none; border-radius: var(--cms-r-md); cursor: pointer;">Move to Trash</button>
        </div>
    </div>
</div>

<script>
    let deleteTargetId = null;

    function confirmDelete(id) {
        deleteTargetId = id;
        document.getElementById('delete-modal').style.display = 'flex';
        // re-init icons in modal
        lucide.createIcons();
    }
    function closeDeleteModal(e) {
        if (!e || e.target === document.getElementById('delete-modal')) {
            document.getElementById('delete-modal').style.display = 'none';
        }
    }
    function executeDelete() {
        // Submit delete form for deleteTargetId
        closeDeleteModal();
    }

    // Bulk selection
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

    // Row menus
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
        // Sorting placeholder — will hook into backend via URL params
        console.log('Sort by:', col);
    }
</script>
@endsection
