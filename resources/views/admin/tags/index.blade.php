@extends('admin.layouts.app')

@section('title', 'Tags — Debesties Studio')
@section('page_title', 'Tags')

@section('content')
<div style="display: flex; flex-direction: column; gap: 20px;">

    {{-- Top Bar --}}
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap;">
        <div>
            <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg3);">
                {{ $tags->total() }} tags total
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 8px; width: 220px; height: 38px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 0 12px;"
                 onfocusin="this.style.borderColor='var(--cms-gold)'" onfocusout="this.style.borderColor='var(--cms-border)'">
                <i data-lucide="search" style="width: 15px; height: 15px; color: var(--cms-fg4); flex-shrink: 0;"></i>
                <input id="tag-search" placeholder="Search tags…" oninput="filterTags(this.value)"
                       style="border: none; outline: none; background: none; flex: 1; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1);" />
            </div>
            <button onclick="openAddTag()"
                    style="display: inline-flex; align-items: center; gap: 7px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; padding: 0 18px; height: 38px; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; white-space: nowrap;"
                    onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                <i data-lucide="plus" style="width: 16px; height: 16px; stroke-width: 2.2;"></i>
                Add Tag
            </button>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start;">

        {{-- Left: Tag Cloud + Table --}}
        <div style="display: flex; flex-direction: column; gap: 16px;">

            {{-- Tag Cloud --}}
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 20px; box-shadow: var(--cms-sh-card);">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                    <i data-lucide="tag" style="width: 16px; height: 16px; color: var(--cms-gold);"></i>
                    <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1);">Tag Cloud</span>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 8px;" id="tag-cloud">
                    @php $maxCount = $tags->max('posts_count') ?: 1; @endphp
                    @foreach($tags as $tag)
                        @php
                            $ratio = $tag->posts_count / $maxCount;
                            $size = 12 + ($ratio * 10);
                            $opacity = 0.5 + ($ratio * 0.5);
                            $bg = "rgba(232,168,0," . ($opacity * 0.15) . ")";
                            $border = "rgba(232,168,0," . ($opacity * 0.4) . ")";
                            $tagStyle = "display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; background: $bg; color: var(--cms-gold-deep); border: 1.5px solid $border; border-radius: 999px; font-family: var(--cms-font-ui), sans-serif; font-size: {$size}px; font-weight: 600; cursor: pointer; transition: all 150ms;";
                        @endphp
                        <button onclick="selectTag({{ $tag->id }}, '{{ $tag->name }}', '{{ $tag->slug }}')"
                                data-tag-id="{{ $tag->id }}"
                                data-tag-name="{{ strtolower($tag->name) }}"
                                style="{!! $tagStyle !!}"
                                onmouseover="this.style.background='var(--cms-gold-soft)'; this.style.borderColor='var(--cms-gold)'"
                                onmouseout="this.style.background='{{ $bg }}'; this.style.borderColor='{{ $border }}'">
                            {{ $tag->name }}
                            <span style="font-size: 11px; opacity: 0.7;">{{ $tag->posts_count }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Tags Table --}}
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--cms-border);">
                    <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1);">All Tags</span>
                    <div id="bulk-bar" style="display: none; align-items: center; gap: 8px;">
                        <span id="bulk-count" style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg3);">0 selected</span>
                        <button onclick="bulkDelete()" style="height: 32px; padding: 0 14px; font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; font-weight: 600; background: var(--cms-red-soft); color: var(--cms-red-deep); border: 1.5px solid rgba(200,55,43,0.2); border-radius: var(--cms-r-md); cursor: pointer;">Delete Selected</button>
                    </div>
                </div>
                <table style="width: 100%; border-collapse: collapse; font-family: var(--cms-font-ui), sans-serif;" id="tags-table">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--cms-border);">
                            <th style="width: 40px; padding: 10px 16px; text-align: center;">
                                <input type="checkbox" id="select-all" onchange="toggleAll(this)" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                            </th>
                            <th style="padding: 10px 16px 10px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase;">Name</th>
                            <th style="padding: 10px 16px 10px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase;">Slug</th>
                            <th style="padding: 10px 16px 10px 0; text-align: center; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase;">Posts</th>
                            <th style="padding: 10px 16px; width: 80px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tags as $tag)
                            <tr @class(['tag-row', 'tag-row--border' => ! $loop->last])
                                data-name="{{ strtolower($tag->name) }}"
                                onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 12px 16px; text-align: center;">
                                    <input type="checkbox" class="tag-cb" value="{{ $tag->id }}" onchange="updateBulk()" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                                </td>
                                <td style="padding: 12px 16px 12px 0;">
                                    <div id="name-display-{{ $tag->id }}" style="display: flex; align-items: center; gap: 8px;">
                                        <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; color: var(--cms-fg1);">{{ $tag->name }}</span>
                                    </div>
                                    <input id="name-input-{{ $tag->id }}" type="text" value="{{ $tag->name }}"
                                           style="display: none; width: 100%; height: 32px; padding: 0 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-gold); border-radius: var(--cms-r-md); outline: none;"
                                           onkeydown="if(event.key==='Enter') saveTag({{ $tag->id }}); if(event.key==='Escape') cancelEdit({{ $tag->id }});"
                                           onblur="saveTag({{ $tag->id }})" />
                                </td>
                                <td style="padding: 12px 16px 12px 0;">
                                    <span style="font-family: var(--cms-font-mono), monospace; font-size: 12px; color: var(--cms-fg3);">{{ $tag->slug }}</span>
                                </td>
                                <td style="padding: 12px 16px 12px 0; text-align: center;">
                                    <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 600; color: var(--cms-fg2);">{{ $tag->posts_count }}</span>
                                </td>
                                <td style="padding: 12px 16px; text-align: right;">
                                    <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                        <button onclick="editTag({{ $tag->id }})" title="Edit"
                                                style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);"
                                                onmouseover="this.style.background='var(--cms-bg)'; this.style.color='var(--cms-fg1)'"
                                                onmouseout="this.style.background='var(--cms-surface)'; this.style.color='var(--cms-fg3)'">
                                            <i data-lucide="edit-2" style="width: 13px; height: 13px;"></i>
                                        </button>
                                        <button onclick="confirmDeleteTag({{ $tag->id }}, '{{ $tag->name }}')" title="Delete"
                                                style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(200,55,43,0.2); background: var(--cms-red-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red);"
                                                onmouseover="this.style.background='#F8D5D2'" onmouseout="this.style.background='var(--cms-red-soft)'">
                                            <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right: Add Tag Form --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card); position: sticky; top: 88px;">
            <div style="padding: 14px 18px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; gap: 8px;">
                <i data-lucide="plus-circle" style="width: 15px; height: 15px; color: var(--cms-gold);"></i>
                <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1);" id="form-title">Add New Tag</span>
            </div>
            <form id="tag-form" method="POST" action="{{ route('admin.tags.store') }}" style="padding: 18px; display: flex; flex-direction: column; gap: 14px;">
                @csrf
                <input type="hidden" id="edit-tag-id" value="" />
                <div>
                    <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Name</label>
                    <input id="new-tag-name" name="name" type="text" placeholder="e.g. Afrobeats" oninput="autoSlug(this.value)"
                           style="display: block; width: 100%; height: 40px; padding: 0 12px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;"
                           onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                           onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'" />
                </div>
                <div>
                    <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Slug</label>
                    <div style="display: flex; align-items: center; gap: 6px; height: 40px; background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 0 12px;">
                        <input id="new-tag-slug" type="text" placeholder="auto-generated"
                               style="border: none; outline: none; background: none; flex: 1; font-family: var(--cms-font-mono), monospace; font-size: 12.5px; color: var(--cms-fg2);" />
                    </div>
                </div>
                <div style="display: flex; gap: 8px; padding-top: 4px;">
                    <button type="button" id="cancel-btn" onclick="resetForm()" style="display: none; flex: 1; height: 38px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; background: var(--cms-bg); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Cancel</button>
                    <button type="submit" id="submit-btn"
                            style="flex: 1; height: 38px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;"
                            onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                        Add Tag
                    </button>
                </div>
            </form>
            <div style="padding: 0 18px 16px; border-top: 1px solid var(--cms-border); padding-top: 14px;">
                <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; color: var(--cms-fg4); line-height: 1.5;">
                    Tags are keywords that describe the topic of a post. They are used for filtering and related content suggestions.
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Delete Modal --}}
<div id="delete-modal" style="display: none; position: fixed; inset: 0; background: rgba(20,16,12,0.5); z-index: 200; align-items: center; justify-content: center; animation: dsFade 180ms ease;">
    <div style="background: var(--cms-surface); border-radius: var(--cms-r-xl); padding: 28px; width: 360px; max-width: calc(100vw - 40px); box-shadow: var(--cms-sh-pop); animation: dsPop 200ms ease;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
            <div style="width: 40px; height: 40px; border-radius: var(--cms-r-md); background: var(--cms-red-soft); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-lucide="trash-2" style="width: 20px; height: 20px; color: var(--cms-red);"></i>
            </div>
            <div>
                <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Delete Tag?</div>
                <div id="delete-label" style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg3); margin-top: 2px;"></div>
            </div>
        </div>
        <div style="display: flex; gap: 8px; justify-content: flex-end; margin-top: 20px;">
            <button onclick="closeModal()" style="height: 38px; padding: 0 18px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; background: var(--cms-surface); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Cancel</button>
            <button onclick="executeDelete()" style="height: 38px; padding: 0 18px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; background: var(--cms-red); color: #fff; border: none; border-radius: var(--cms-r-md); cursor: pointer;">Delete</button>
        </div>
    </div>
</div>

<script>
    let deleteId = null;

    function autoSlug(val) {
        document.getElementById('new-tag-slug').value = val.toLowerCase().replace(/[^\w\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-');
    }

    function filterTags(q) {
        const lq = q.toLowerCase();
        document.querySelectorAll('.tag-row').forEach(r => {
            r.style.display = r.dataset.name.includes(lq) ? '' : 'none';
        });
        document.querySelectorAll('#tag-cloud button').forEach(b => {
            b.style.display = b.dataset.tagName.includes(lq) ? '' : 'none';
        });
    }

    function editTag(id) {
        document.getElementById('edit-tag-id').value = id;
        document.getElementById('form-title').textContent = 'Edit Tag';
        document.getElementById('submit-btn').textContent = 'Save Changes';
        document.getElementById('cancel-btn').style.display = 'block';
        document.getElementById('new-tag-name').value = document.querySelector(`#name-display-${id} span`).textContent;
        document.getElementById('new-tag-slug').value = '';
        document.getElementById('new-tag-name').focus();
    }

    function resetForm() {
        document.getElementById('edit-tag-id').value = '';
        document.getElementById('form-title').textContent = 'Add New Tag';
        document.getElementById('submit-btn').textContent = 'Add Tag';
        document.getElementById('cancel-btn').style.display = 'none';
        document.getElementById('new-tag-name').value = '';
        document.getElementById('new-tag-slug').value = '';
    }

    function openAddTag() {
        resetForm();
        document.getElementById('new-tag-name').focus();
    }

    function confirmDeleteTag(id, name) {
        deleteId = id;
        document.getElementById('delete-label').textContent = `"${name}" will be removed from all posts.`;
        document.getElementById('delete-modal').style.display = 'flex';
        lucide.createIcons();
    }
    function closeModal() { document.getElementById('delete-modal').style.display = 'none'; }
    function executeDelete() { closeModal(); console.log('Delete tag:', deleteId); }

    function toggleAll(master) {
        document.querySelectorAll('.tag-cb').forEach(cb => cb.checked = master.checked);
        updateBulk();
    }
    function updateBulk() {
        const n = document.querySelectorAll('.tag-cb:checked').length;
        const bar = document.getElementById('bulk-bar');
        bar.style.display = n > 0 ? 'flex' : 'none';
        document.getElementById('bulk-count').textContent = n + ' selected';
    }
    function bulkDelete() { console.log('Bulk delete tags'); }

    function selectTag(id, name, slug) {
        document.getElementById('edit-tag-id').value = id;
        document.getElementById('new-tag-name').value = name;
        document.getElementById('new-tag-slug').value = slug;
        document.getElementById('form-title').textContent = 'Edit Tag';
        document.getElementById('submit-btn').textContent = 'Save Changes';
        document.getElementById('cancel-btn').style.display = 'block';
    }

    // Inline edit in table
    function editTagInline(id) {
        document.getElementById('name-display-' + id).style.display = 'none';
        document.getElementById('name-input-' + id).style.display = 'block';
        document.getElementById('name-input-' + id).focus();
    }
    function saveTag(id) {
        const val = document.getElementById('name-input-' + id).value.trim();
        if (val) document.querySelector('#name-display-' + id + ' span').textContent = val;
        document.getElementById('name-display-' + id).style.display = 'flex';
        document.getElementById('name-input-' + id).style.display = 'none';
    }
    function cancelEdit(id) {
        document.getElementById('name-display-' + id).style.display = 'flex';
        document.getElementById('name-input-' + id).style.display = 'none';
    }
</script>
@endsection
