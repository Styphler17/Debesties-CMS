@extends('admin.layouts.app')

@section('title', 'Categories — Debesties Studio')
@section('page_title', 'Categories')

@section('content')
@php
    $categories = [
        ['id'=>1, 'name'=>'Awards History',  'slug'=>'awards-history',  'parent'=>null,          'count'=>38, 'visible'=>true,  'order'=>1],
        ['id'=>2, 'name'=>'Profiles',        'slug'=>'profiles',        'parent'=>null,          'count'=>27, 'visible'=>true,  'order'=>2],
        ['id'=>3, 'name'=>'Analysis',        'slug'=>'analysis',        'parent'=>null,          'count'=>19, 'visible'=>true,  'order'=>3],
        ['id'=>4, 'name'=>'Explainers',      'slug'=>'explainers',      'parent'=>null,          'count'=>11, 'visible'=>true,  'order'=>4],
        ['id'=>5, 'name'=>'News',            'slug'=>'news',            'parent'=>null,          'count'=>5,  'visible'=>true,  'order'=>5],
        ['id'=>6, 'name'=>'Lifestyle',       'slug'=>'lifestyle',       'parent'=>null,          'count'=>8,  'visible'=>true,  'order'=>6],
        ['id'=>7, 'name'=>'Entertainment',   'slug'=>'entertainment',   'parent'=>null,          'count'=>6,  'visible'=>true,  'order'=>7],
        ['id'=>8, 'name'=>'Sports',          'slug'=>'sports',          'parent'=>null,          'count'=>4,  'visible'=>false, 'order'=>8],
        ['id'=>9, 'name'=>'TGMA Winners',    'slug'=>'tgma-winners',    'parent'=>'Awards History','count'=>22,'visible'=>true, 'order'=>1],
        ['id'=>10,'name'=>'Artist Profiles', 'slug'=>'artist-profiles', 'parent'=>'Profiles',    'count'=>14, 'visible'=>true,  'order'=>1],
    ];

    $topLevel = array_filter($categories, fn($c) => is_null($c['parent']));
    $children  = array_filter($categories, fn($c) => !is_null($c['parent']));
@endphp

<div style="display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start;">

    {{-- Left: Category Tree Table --}}
    <div style="display: flex; flex-direction: column; gap: 0;">
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--cms-border);">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="folder-tree" style="width: 16px; height: 16px; color: var(--cms-gold);"></i>
                    <span style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">All Categories</span>
                    <span style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4);">{{ count($categories) }} total</span>
                </div>
                <div id="bulk-bar" style="display: none; align-items: center; gap: 8px;">
                    <span id="bulk-count" style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3);">0 selected</span>
                    <button style="height: 32px; padding: 0 14px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; background: var(--cms-red-soft); color: var(--cms-red-deep); border: 1.5px solid rgba(200,55,43,0.2); border-radius: var(--cms-r-md); cursor: pointer;">Delete</button>
                </div>
            </div>

            <table style="width: 100%; border-collapse: collapse; font-family: var(--cms-font-ui);">
                <thead>
                    <tr style="border-bottom: 1px solid var(--cms-border);">
                        <th style="width: 40px; padding: 10px 16px; text-align: center;">
                            <input type="checkbox" onchange="toggleAll(this)" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                        </th>
                        <th style="padding: 10px 16px 10px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase;">Name</th>
                        <th style="padding: 10px 16px 10px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase;">Slug</th>
                        <th style="padding: 10px 16px 10px 0; text-align: left; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase;">Parent</th>
                        <th style="padding: 10px 16px 10px 0; text-align: center; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase;">Posts</th>
                        <th style="padding: 10px 16px 10px 0; text-align: center; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase;">Visible</th>
                        <th style="padding: 10px 16px; width: 80px;"></th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Top-level categories --}}
                    @foreach($topLevel as $cat)
                        <tr style="border-bottom: 1px solid var(--cms-border); transition: background 100ms;"
                            onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 13px 16px; text-align: center;">
                                <input type="checkbox" class="cat-cb" value="{{ $cat['id'] }}" onchange="updateBulk()" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                            </td>
                            <td style="padding: 13px 16px 13px 0;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 7px; height: 7px; border-radius: 999px; background: var(--cms-gold); flex-shrink: 0;"></div>
                                    <span style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; color: var(--cms-fg1);">{{ $cat['name'] }}</span>
                                </div>
                            </td>
                            <td style="padding: 13px 16px 13px 0;">
                                <span style="font-family: var(--cms-font-mono); font-size: 12px; color: var(--cms-fg3);">{{ $cat['slug'] }}</span>
                            </td>
                            <td style="padding: 13px 16px 13px 0;">
                                <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg4);">—</span>
                            </td>
                            <td style="padding: 13px 16px 13px 0; text-align: center;">
                                <a href="{{ route('admin.posts.index', ['category' => $cat['slug']]) }}"
                                   style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; color: var(--cms-blue); text-decoration: none;">
                                    {{ $cat['count'] }}
                                </a>
                            </td>
                            <td style="padding: 13px 16px 13px 0; text-align: center;">
                                <button onclick="toggleVisible({{ $cat['id'] }}, this)"
                                        data-visible="{{ $cat['visible'] ? 'true' : 'false' }}"
                                        style="width: 38px; height: 22px; border-radius: 999px; border: none; cursor: pointer; transition: background 200ms; position: relative; background: {{ $cat['visible'] ? 'var(--cms-green)' : 'var(--cms-border-st)' }};">
                                    <span style="position: absolute; top: 3px; width: 16px; height: 16px; border-radius: 999px; background: #fff; transition: left 200ms; left: {{ $cat['visible'] ? '19px' : '3px' }};"></span>
                                </button>
                            </td>
                            <td style="padding: 13px 16px;">
                                <div style="display: flex; gap: 5px; justify-content: flex-end;">
                                    <button onclick="editCategory({{ $cat['id'] }}, '{{ $cat['name'] }}', '{{ $cat['slug'] }}', '', {{ $cat['order'] }})" title="Edit"
                                            style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);"
                                            onmouseover="this.style.background='var(--cms-bg)'; this.style.color='var(--cms-fg1)'"
                                            onmouseout="this.style.background='var(--cms-surface)'; this.style.color='var(--cms-fg3)'">
                                        <i data-lucide="edit-2" style="width: 13px; height: 13px;"></i>
                                    </button>
                                    <button onclick="confirmDelete({{ $cat['id'] }}, '{{ $cat['name'] }}')" title="Delete"
                                            style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(200,55,43,0.2); background: var(--cms-red-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red);"
                                            onmouseover="this.style.background='#F8D5D2'" onmouseout="this.style.background='var(--cms-red-soft)'">
                                        <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Child categories (indented) --}}
                        @foreach($children as $child)
                            @if($child['parent'] === $cat['name'])
                                <tr style="border-bottom: 1px solid var(--cms-border); background: #FDFBF8; transition: background 100ms;"
                                    onmouseover="this.style.background='#FAF7F2'" onmouseout="this.style.background='#FDFBF8'">
                                    <td style="padding: 10px 16px; text-align: center;">
                                        <input type="checkbox" class="cat-cb" value="{{ $child['id'] }}" onchange="updateBulk()" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                                    </td>
                                    <td style="padding: 10px 16px 10px 0;">
                                        <div style="display: flex; align-items: center; gap: 8px; padding-left: 20px;">
                                            <i data-lucide="corner-down-right" style="width: 13px; height: 13px; color: var(--cms-fg4);"></i>
                                            <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 500; color: var(--cms-fg2);">{{ $child['name'] }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 10px 16px 10px 0;">
                                        <span style="font-family: var(--cms-font-mono); font-size: 11.5px; color: var(--cms-fg4);">{{ $child['slug'] }}</span>
                                    </td>
                                    <td style="padding: 10px 16px 10px 0;">
                                        <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg3);">{{ $child['parent'] }}</span>
                                    </td>
                                    <td style="padding: 10px 16px 10px 0; text-align: center;">
                                        <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; color: var(--cms-fg2);">{{ $child['count'] }}</span>
                                    </td>
                                    <td style="padding: 10px 16px 10px 0; text-align: center;">
                                        <button onclick="toggleVisible({{ $child['id'] }}, this)" data-visible="{{ $child['visible'] ? 'true' : 'false' }}"
                                                style="width: 38px; height: 22px; border-radius: 999px; border: none; cursor: pointer; background: {{ $child['visible'] ? 'var(--cms-green)' : 'var(--cms-border-st)' }}; position: relative; transition: background 200ms;">
                                            <span style="position: absolute; top: 3px; width: 16px; height: 16px; border-radius: 999px; background: #fff; transition: left 200ms; left: {{ $child['visible'] ? '19px' : '3px' }};"></span>
                                        </button>
                                    </td>
                                    <td style="padding: 10px 16px;">
                                        <div style="display: flex; gap: 5px; justify-content: flex-end;">
                                            <button onclick="editCategory({{ $child['id'] }}, '{{ $child['name'] }}', '{{ $child['slug'] }}', '{{ $child['parent'] }}', {{ $child['order'] }})"
                                                    style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);"
                                                    onmouseover="this.style.background='var(--cms-bg)'" onmouseout="this.style.background='var(--cms-surface)'">
                                                <i data-lucide="edit-2" style="width: 13px; height: 13px;"></i>
                                            </button>
                                            <button onclick="confirmDelete({{ $child['id'] }}, '{{ $child['name'] }}')"
                                                    style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(200,55,43,0.2); background: var(--cms-red-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red);"
                                                    onmouseover="this.style.background='#F8D5D2'" onmouseout="this.style.background='var(--cms-red-soft)'">
                                                <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Right: Add / Edit Form --}}
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card); position: sticky; top: 88px;">
        <div style="padding: 14px 18px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; gap: 8px;">
            <i data-lucide="folder-plus" style="width: 15px; height: 15px; color: var(--cms-gold);"></i>
            <span id="form-title" style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">Add New Category</span>
        </div>
        <form style="padding: 18px; display: flex; flex-direction: column; gap: 14px;">
            @csrf
            <input type="hidden" id="edit-cat-id" value="" />

            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Name <span style="color: var(--cms-red);">*</span></label>
                <input id="cat-name" type="text" placeholder="e.g. Music Awards" oninput="autoCatSlug(this.value)"
                       style="display: block; width: 100%; height: 40px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;"
                       onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                       onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'" />
            </div>

            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Slug</label>
                <input id="cat-slug" type="text" placeholder="auto-generated"
                       style="display: block; width: 100%; height: 40px; padding: 0 12px; font-family: var(--cms-font-mono); font-size: 12.5px; color: var(--cms-fg2); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;"
                       onfocus="this.style.borderColor='var(--cms-gold)'" onblur="this.style.borderColor='var(--cms-border)'" />
            </div>

            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Description</label>
                <textarea id="cat-desc" rows="2" placeholder="Optional description…"
                          style="display: block; width: 100%; padding: 10px 12px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; resize: vertical; line-height: 1.5;"
                          onfocus="this.style.borderColor='var(--cms-gold)'" onblur="this.style.borderColor='var(--cms-border)'"></textarea>
            </div>

            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Parent Category</label>
                <select id="cat-parent"
                        style="width: 100%; height: 40px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
                    <option value="">None (top-level)</option>
                    @foreach($topLevel as $cat)
                        <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Sort Order</label>
                <input id="cat-order" type="number" value="0" min="0"
                       style="display: block; width: 100%; height: 40px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;"
                       onfocus="this.style.borderColor='var(--cms-gold)'" onblur="this.style.borderColor='var(--cms-border)'" />
            </div>

            <div style="display: flex; gap: 8px; padding-top: 4px;">
                <button type="button" id="cancel-btn" onclick="resetCatForm()" style="display: none; flex: 1; height: 38px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-bg); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Cancel</button>
                <button type="submit" id="cat-submit"
                        style="flex: 1; height: 40px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;"
                        onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                    Add Category
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Modal --}}
<div id="delete-modal" style="display: none; position: fixed; inset: 0; background: rgba(20,16,12,0.5); z-index: 200; align-items: center; justify-content: center; animation: dsFade 180ms ease;">
    <div style="background: var(--cms-surface); border-radius: var(--cms-r-xl); padding: 28px; width: 380px; max-width: calc(100vw - 40px); box-shadow: var(--cms-sh-pop); animation: dsPop 200ms ease;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
            <div style="width: 40px; height: 40px; border-radius: var(--cms-r-md); background: var(--cms-red-soft); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-lucide="folder-x" style="width: 20px; height: 20px; color: var(--cms-red);"></i>
            </div>
            <div>
                <div style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Delete Category?</div>
                <div id="delete-label" style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3); margin-top: 2px;"></div>
            </div>
        </div>
        <div style="background: var(--cms-gold-soft); border: 1px solid rgba(232,168,0,0.3); border-radius: var(--cms-r-md); padding: 10px 14px; margin: 12px 0; font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-gold-deep);">
            Posts in this category will be set to uncategorized.
        </div>
        <div style="display: flex; gap: 8px; justify-content: flex-end;">
            <button onclick="closeModal()" style="height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-surface); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Cancel</button>
            <button onclick="executeDelete()" style="height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-red); color: #fff; border: none; border-radius: var(--cms-r-md); cursor: pointer;">Delete</button>
        </div>
    </div>
</div>

<script>
    let deleteId = null;

    function autoCatSlug(val) {
        document.getElementById('cat-slug').value = val.toLowerCase().replace(/[^\w\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-');
    }

    function editCategory(id, name, slug, parent, order) {
        document.getElementById('edit-cat-id').value = id;
        document.getElementById('cat-name').value = name;
        document.getElementById('cat-slug').value = slug;
        document.getElementById('cat-desc').value = '';
        document.getElementById('cat-order').value = order;
        document.getElementById('form-title').textContent = 'Edit Category';
        document.getElementById('cat-submit').textContent = 'Save Changes';
        document.getElementById('cancel-btn').style.display = 'block';
        // Set parent select
        const sel = document.getElementById('cat-parent');
        for (let opt of sel.options) { if (opt.text === parent) { opt.selected = true; break; } }
        document.getElementById('cat-name').focus();
    }

    function resetCatForm() {
        document.getElementById('edit-cat-id').value = '';
        document.getElementById('cat-name').value = '';
        document.getElementById('cat-slug').value = '';
        document.getElementById('cat-desc').value = '';
        document.getElementById('cat-order').value = '0';
        document.getElementById('cat-parent').value = '';
        document.getElementById('form-title').textContent = 'Add New Category';
        document.getElementById('cat-submit').textContent = 'Add Category';
        document.getElementById('cancel-btn').style.display = 'none';
    }

    function toggleVisible(id, btn) {
        const isOn = btn.dataset.visible === 'true';
        btn.dataset.visible = isOn ? 'false' : 'true';
        btn.style.background = isOn ? 'var(--cms-border-st)' : 'var(--cms-green)';
        btn.querySelector('span').style.left = isOn ? '3px' : '19px';
    }

    function confirmDelete(id, name) {
        deleteId = id;
        document.getElementById('delete-label').textContent = `"${name}"`;
        document.getElementById('delete-modal').style.display = 'flex';
        lucide.createIcons();
    }
    function closeModal() { document.getElementById('delete-modal').style.display = 'none'; }
    function executeDelete() { closeModal(); console.log('Delete category:', deleteId); }

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
