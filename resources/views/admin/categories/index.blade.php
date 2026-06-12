@extends('admin.layouts.app')

@section('title', 'Categories — Debesties Studio')
@section('page_title', 'Categories')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start;">

    {{-- Left: Category Tree Table --}}
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <div class="cms-card">
            <div class="cms-card-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: var(--cms-gold-soft); display: flex; align-items: center; justify-content: center; color: var(--cms-gold-deep);">
                        <i data-lucide="folder-tree" style="width: 16px; height: 16px;"></i>
                    </div>
                    <div>
                        <span style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">All Categories</span>
                        <div style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 1px;">{{ $categories->total() }} taxonomy units</div>
                    </div>
                </div>
                <div id="bulk-bar" style="display: none; align-items: center; gap: 10px; animation: dsPop 180ms ease;">
                    <span id="bulk-count" style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3); font-weight: 600;">0 selected</span>
                    <button class="badge badge-danger" style="height: 30px; cursor: pointer; border: 1px solid rgba(200,55,43,0.1);">Delete Bulk</button>
                </div>
            </div>

            <table class="cms-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center; padding-right: 16px;">
                            <input type="checkbox" onchange="toggleAll(this)" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                        </th>
                        <th style="padding-left: 0;">Name</th>
                        <th>Slug</th>
                        <th style="text-align: center;">Posts</th>
                        <th style="text-align: center;">Visible</th>
                        <th style="width: 80px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                        <tr class="cat-row">
                            <td style="text-align: center; padding-right: 16px;">
                                <input type="checkbox" class="cat-cb" value="{{ $cat->id }}" onchange="updateBulk()" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                            </td>
                            <td style="padding-left: 0;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 8px; height: 8px; border-radius: 999px; background: var(--cms-gold); flex-shrink: 0; box-shadow: 0 0 0 3px var(--cms-gold-soft);"></div>
                                    <span style="font-weight: 700; color: var(--cms-fg1); font-size: 14px;">{{ $cat->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span style="font-family: var(--cms-font-mono); font-size: 12px; color: var(--cms-fg3); background: var(--cms-bg); padding: 2px 6px; border-radius: 4px;">{{ $cat->slug }}</span>
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.posts.index', ['category' => $cat->slug]) }}"
                                   style="font-weight: 700; color: var(--cms-blue); text-decoration: none; font-size: 13.5px;">
                                    {{ $cat->posts_count ?? $cat->posts()->count() }}
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <button onclick="toggleVisible({{ $cat->id }}, this)"
                                        data-visible="{{ $cat->is_visible ? 'true' : 'false' }}"
                                        style="width: 36px; height: 20px; border-radius: 999px; border: none; cursor: pointer; transition: all 200ms ease; position: relative; background: {{ $cat->is_visible ? 'var(--cms-green)' : 'var(--cms-border-st)' }};">
                                    <span style="position: absolute; top: 2px; width: 16px; height: 16px; border-radius: 999px; background: #fff; transition: left 200ms; left: {{ $cat->is_visible ? '18px' : '2px' }}; box-shadow: 0 1px 2px rgba(0,0,0,0.1);"></span>
                                </button>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                    <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn-secondary" style="width: 32px; height: 32px; padding: 0;" title="Edit">
                                        <i data-lucide="edit-2" style="width: 14px; height: 14px;"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete {{ $cat->name }}?')" class="btn-secondary" style="width: 32px; height: 32px; padding: 0; color: var(--cms-red); border-color: rgba(200,55,43,0.15);" title="Delete">
                                            <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Children --}}
                        @foreach($cat->children as $child)
                            <tr style="background: #FDFBF8;">
                                <td style="text-align: center; padding-right: 16px;">
                                    <input type="checkbox" class="cat-cb" value="{{ $child->id }}" onchange="updateBulk()" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                                </td>
                                <td style="padding-left: 0;">
                                    <div style="display: flex; align-items: center; gap: 10px; padding-left: 20px;">
                                        <i data-lucide="corner-down-right" style="width: 14px; height: 14px; color: var(--cms-fg4);"></i>
                                        <span style="font-weight: 600; color: var(--cms-fg2); font-size: 13.5px;">{{ $child->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-family: var(--cms-font-mono); font-size: 11.5px; color: var(--cms-fg4);">{{ $child->slug }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <span style="font-weight: 600; color: var(--cms-fg2); font-size: 13px;">{{ $child->posts()->count() }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <button onclick="toggleVisible({{ $child->id }}, this)" data-visible="{{ $child->is_visible ? 'true' : 'false' }}"
                                            style="width: 36px; height: 20px; border-radius: 999px; border: none; cursor: pointer; background: {{ $child->is_visible ? 'var(--cms-green)' : 'var(--cms-border-st)' }}; position: relative; transition: all 200ms ease;">
                                        <span style="position: absolute; top: 2px; width: 16px; height: 16px; border-radius: 999px; background: #fff; transition: left 200ms; left: {{ $child->is_visible ? '18px' : '2px' }};"></span>
                                    </button>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                        <a href="{{ route('admin.categories.edit', $child->id) }}" class="btn-secondary" style="width: 30px; height: 30px; padding: 0;">
                                            <i data-lucide="edit-2" style="width: 13px; height: 13px;"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $child->id) }}" style="display: inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete {{ $child->name }}?')" class="btn-secondary" style="width: 30px; height: 30px; padding: 0; color: var(--cms-red); border-color: rgba(200,55,43,0.1);">
                                                <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 48px 20px; text-align: center; color: var(--cms-fg4); font-size: 14px;">No categories defined yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if($categories->hasPages())
                <div style="padding: 16px 20px; border-top: 1px solid var(--cms-border); background: #FDFBF8;">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Right: Add / Edit Form --}}
    <div class="cms-card" style="position: sticky; top: 88px;">
        <div class="cms-card-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: var(--cms-blue-soft); display: flex; align-items: center; justify-content: center; color: var(--cms-blue);">
                    <i data-lucide="folder-plus" style="width: 16px; height: 16px;"></i>
                </div>
                <span id="form-title" style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Create Category</span>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.categories.store') }}" class="cms-card-body" style="display: flex; flex-direction: column; gap: 16px; padding: 24px;">
            @csrf
            <input type="hidden" id="edit-cat-id" value="" />

            <div class="form-group">
                <label class="form-label">Category Name</label>
                <input id="cat-name" name="name" type="text" class="form-input" placeholder="e.g. Industry Analysis" oninput="autoCatSlug(this.value)" required />
            </div>

            <div class="form-group">
                <label class="form-label">URL Slug</label>
                <input id="cat-slug" name="slug" type="text" class="form-input" style="font-family: var(--cms-font-mono); font-size: 12.5px;" placeholder="industry-analysis" />
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea id="cat-desc" name="description" rows="3" class="form-textarea" placeholder="Describe this category's focus…"></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Parent Category</label>
                <select id="cat-parent" name="parent_id" class="form-select">
                    <option value="">None (Top Level)</option>
                    @foreach($topLevel as $tc)
                        <option value="{{ $tc->id }}">{{ $tc->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input id="cat-order" name="sort_order" type="number" value="0" min="0" class="form-input" />
            </div>

            <div style="display: flex; gap: 10px; margin-top: 8px;">
                <button type="button" id="cancel-btn" onclick="resetCatForm()" class="btn-secondary" style="display: none; flex: 1;">Cancel</button>
                <button type="submit" id="cat-submit" class="btn-primary" style="flex: 1.5;">Create Category</button>
            </div>
        </form>
    </div>
</div>

<script>
    function autoCatSlug(val) {
        document.getElementById('cat-slug').value = val.toLowerCase().replace(/[^\w\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-').substring(0, 50);
    }

    function resetCatForm() {
        document.getElementById('edit-cat-id').value = '';
        document.getElementById('cat-name').value = '';
        document.getElementById('cat-slug').value = '';
        document.getElementById('cat-desc').value = '';
        document.getElementById('cat-order').value = '0';
        document.getElementById('cat-parent').value = '';
        document.getElementById('form-title').textContent = 'Create Category';
        document.getElementById('cat-submit').textContent = 'Create Category';
        document.getElementById('cancel-btn').style.display = 'none';
    }

    function toggleVisible(id, btn) {
        const isOn = btn.dataset.visible === 'true';
        btn.dataset.visible = isOn ? 'false' : 'true';
        btn.style.background = isOn ? 'var(--cms-border-st)' : 'var(--cms-green)';
        btn.querySelector('span').style.left = isOn ? '2px' : '18px';
    }

    function toggleAll(master) {
        document.querySelectorAll('.cat-cb').forEach(cb => cb.checked = master.checked);
        updateBulk();
    }
    function updateBulk() {
        const n = document.querySelectorAll('.cat-cb:checked').length;
        const bar = document.getElementById('bulk-bar');
        bar.style.display = n > 0 ? 'flex' : 'none';
        document.getElementById('bulk-count').textContent = n + ' selected';
    }
</script>
@endsection
