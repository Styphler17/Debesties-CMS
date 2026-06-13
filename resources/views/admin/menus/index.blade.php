@extends('admin.layouts.app')

@section('title', 'Navigation Builder — Debesties Studio')
@section('page_title', 'Navigation Builder')

@section('content')

{{-- Toast Container --}}
<div id="toast-container" style="position: fixed; bottom: 24px; right: 24px; z-index: 999; display: flex; flex-direction: column; gap: 8px;"></div>

<style>
.menu-list-card {
    background: var(--cms-surface);
    border: 1px solid var(--cms-border);
    border-radius: var(--cms-r-lg);
    padding: 14px;
    cursor: pointer;
    transition: all 120ms;
}
.menu-list-card.active {
    border: 1.5px solid var(--cms-gold) !important;
}
.location-assigned {
    color: var(--cms-gold-deep);
}
</style>

<div style="display: grid; grid-template-columns: 280px 1fr; gap: 24px; align-items: start;">
    
    {{-- Left Panel: Menus List --}}
    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">Your Menus</span>
            <button onclick="openCreateMenuModal()"
                    style="display: inline-flex; align-items: center; gap: 4px; height: 28px; padding: 0 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 600; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;">
                <i data-lucide="plus" style="width: 12px; height: 12px;"></i> Add Menu
            </button>
        </div>

        <div id="menus-list-container" style="display: flex; flex-direction: column; gap: 10px;">
            @foreach($menus as $menu)
                <div class="menu-list-card {{ $loop->first ? 'active' : '' }}" data-menu-id="{{ $menu->id }}" onclick="selectMenu(this.getAttribute('data-menu-id'), this)">
                    <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1);">{{ $menu->name }}</div>
                    <div style="font-size: 11.5px; color: var(--cms-fg3); margin-top: 4px;">Location: <strong class="{{ $menu->location !== 'none' ? 'location-assigned' : '' }}">{{ $menu->location === 'header' ? 'Header Main' : ($menu->location === 'footer' ? 'Footer Left' : 'Unassigned') }}</strong></div>
                    <div style="font-size: 11.5px; color: var(--cms-fg4); margin-top: 2px;">{{ $menu->items->count() }} items • Updated {{ $menu->updated_at->diffForHumans() }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Right Panel: Menu Editor --}}
    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 24px; align-items: start;">
        
        {{-- Add Item Box --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 20px; box-shadow: var(--cms-sh-card);">
            <h3 style="font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="plus-circle" style="width: 16px; height: 16px; color: var(--cms-gold-deep);"></i>
                Add Link to Menu
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <div>
                    <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 5px;">Link Title</label>
                    <input type="text" id="new-item-title" placeholder="e.g. Culture"
                           style="display: block; width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;" />
                </div>

                <div>
                    <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 5px;">Link Type</label>
                    <select id="new-item-type" onchange="toggleLinkSource()"
                            style="display: block; width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
                        <option value="custom">Custom URL</option>
                        <option value="page">Static Page</option>
                        <option value="category">Category</option>
                        <option value="post">Individual Post</option>
                    </select>
                </div>

                {{-- Source Select Panel --}}
                <div id="source-custom-panel">
                    <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 5px;">URL Path</label>
                    <input type="text" id="new-item-url" value="https://"
                           style="display: block; width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;" />
                </div>

                <div id="source-select-panel" style="display: none;">
                    <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 5px;">Reference Destination</label>
                    <select id="new-item-ref"
                            style="display: block; width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;"></select>
                </div>

                <button onclick="addMenuItem()"
                        style="height: 38px; width: 100%; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 700; background: var(--cms-fg1); color: #fff; border: none; border-radius: var(--cms-r-md); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: background 120ms;"
                        onmouseover="this.style.background='var(--cms-fg2)'" onmouseout="this.style.background='var(--cms-fg1)'">
                    <i data-lucide="plus" style="width: 14px; height: 14px;"></i>
                    Add to Menu
                </button>
            </div>
        </div>

        {{-- Tree Builder Structure --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 24px; box-shadow: var(--cms-sh-card); display: flex; flex-direction: column; gap: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--cms-border); padding-bottom: 14px;">
                <div>
                    <h2 id="menu-editor-title" style="font-family: var(--cms-font-disp), serif; font-size: 20px; font-weight: 700; color: var(--cms-fg1);">Primary Header Navigation</h2>
                    <p style="font-size: 12.5px; color: var(--cms-fg3); margin-top: 1px;">Drag handles or use controls to nest and sort links.</p>
                </div>

                <div style="display: flex; align-items: center; gap: 8px;">
                    <select id="menu-location-select"
                            style="height: 34px; padding: 0 8px; font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 600; color: var(--cms-fg2); background: var(--cms-bg); border: 1px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
                        <option value="header">Location: Header Main</option>
                        <option value="footer">Location: Footer Left</option>
                        <option value="none">Location: Unassigned</option>
                    </select>
                </div>
            </div>

            {{-- Tree Content --}}
            <div id="tree-container" style="display: flex; flex-direction: column; gap: 6px; min-height: 200px;">
                {{-- Items rendered dynamically by JS --}}
            </div>

            {{-- Save CTA --}}
            <div style="border-top: 1px solid var(--cms-border); padding-top: 16px; display: flex; justify-content: flex-end;">
                <button onclick="saveMenuStructure()"
                        style="display: inline-flex; align-items: center; gap: 7px; height: 40px; padding: 0 20px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; transition: background 150ms;"
                        onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                    <i data-lucide="check" style="width: 16px; height: 16px;"></i>
                    Save Menu Layout
                </button>
            </div>

        </div>

    </div>

</div>

{{-- Add Menu Modal --}}
<div id="create-menu-modal" style="display: none; position: fixed; inset: 0; background: rgba(20,16,12,0.5); z-index: 200; align-items: center; justify-content: center;">
    <div style="background: var(--cms-surface); border-radius: var(--cms-r-xl); padding: 28px; width: 380px; max-width: calc(100vw - 40px); box-shadow: var(--cms-sh-pop); animation: dsPop 200ms ease;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
            <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 16px; font-weight: 700; color: var(--cms-fg1);">Create New Menu</span>
            <button onclick="closeCreateMenuModal()" style="width: 28px; height: 28px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-bg); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);">
                <i data-lucide="x" style="width: 12px; height: 12px;"></i>
            </button>
        </div>
        <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 20px;">
            <div>
                <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Menu Name</label>
                <input type="text" id="new-menu-name" placeholder="e.g. Primary Header"
                       style="display: block; width: 100%; height: 40px; padding: 0 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;" />
            </div>
        </div>
        <div style="display: flex; gap: 8px;">
            <button onclick="closeCreateMenuModal()" style="flex: 1; height: 38px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 600; background: var(--cms-bg); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Cancel</button>
            <button onclick="submitCreateMenu()" style="flex: 1.5; height: 38px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;">Create</button>
        </div>
    </div>
</div>

<div id="menu-editor-data" data-active-menu-id="{{ $menus->count() > 0 ? $menus->first()->id : '' }}"></div>

<script type="application/json" id="menus-data">
    {!! json_encode(collect($menus)->keyBy('id')->map(function($menu) {
        return [
            'name' => $menu->name,
            'location' => $menu->location,
            'items' => collect($menu->items)->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'type' => 'custom',
                    'url' => $item->url,
                    'indent' => (int) ($item->target ?? 0)
                ];
            })->all()
        ];
    })->all()) !!}
</script>

<script type="application/json" id="references-data">
    {!! json_encode([
        "page" => collect($pages)->map(fn($page) => ['title' => $page->title, 'url' => route('pages.show', $page->slug)])->all(),
        "category" => collect($categories)->map(fn($category) => ['title' => $category->name, 'url' => route('categories.show', $category->slug)])->all(),
        "post" => collect($posts)->map(fn($post) => ['title' => $post->title, 'url' => route('posts.show', $post->slug)])->all()
    ]) !!}
</script>

<script>
    const editorData = document.getElementById('menu-editor-data');
    let activeMenuId = editorData && editorData.dataset.activeMenuId ? parseInt(editorData.dataset.activeMenuId) : null;
    let nextItemId = 1000; // Offset for new items

    // Seed Data structure from backend parsed from script blocks
    const menusData = JSON.parse(document.getElementById('menus-data').textContent);

    // References mapping for selectors from backend parsed from script blocks
    const references = JSON.parse(document.getElementById('references-data').textContent);

    document.addEventListener("DOMContentLoaded", () => {
        if (activeMenuId) {
            const firstCard = document.querySelector('.menu-list-card');
            if (firstCard) selectMenu(activeMenuId, firstCard);
        }
        toggleLinkSource();
    });

    function selectMenu(id, cardElement) {
        activeMenuId = id;
        
        // Highlight card
        document.querySelectorAll('.menu-list-card').forEach(el => {
            el.classList.remove('active');
            el.style.borderColor = 'var(--cms-border)';
            el.style.borderWidth = '1px';
        });
        cardElement.classList.add('active');
        cardElement.style.borderColor = 'var(--cms-gold)';
        cardElement.style.borderWidth = '1.5px';

        // Update titles
        const menu = menusData[id];
        if (menu) {
            document.getElementById('menu-editor-title').textContent = menu.name;
            document.getElementById('menu-location-select').value = menu.location;
            renderMenuTree();
        }
    }

    function toggleLinkSource() {
        const type = document.getElementById('new-item-type').value;
        const customPanel = document.getElementById('source-custom-panel');
        const selectPanel = document.getElementById('source-select-panel');
        const selectElement = document.getElementById('new-item-ref');

        if (type === 'custom') {
            customPanel.style.display = 'block';
            selectPanel.style.display = 'none';
        } else {
            customPanel.style.display = 'none';
            selectPanel.style.display = 'block';
            
            // Populate selector
            selectElement.innerHTML = '';
            if (references[type]) {
                references[type].forEach(ref => {
                    const opt = document.createElement('option');
                    opt.value = ref.url;
                    opt.textContent = ref.title;
                    selectElement.appendChild(opt);
                });
            }
        }
    }

    // Render tree with L connectors
    function renderMenuTree() {
        const container = document.getElementById('tree-container');
        container.innerHTML = '';

        if (!activeMenuId || !menusData[activeMenuId]) {
            container.innerHTML = `<div style="padding: 40px; text-align: center; color: var(--cms-fg4);">Select a menu to start editing.</div>`;
            return;
        }

        const items = menusData[activeMenuId].items;

        if (items.length === 0) {
            container.innerHTML = `
                <div style="border: 2px dashed var(--cms-border); border-radius: var(--cms-r-md); padding: 32px; text-align: center; color: var(--cms-fg4); font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px;">
                    <i data-lucide="link-2" style="width:24px; height:24px; color:var(--cms-fg4); margin-bottom:8px;"></i>
                    <div>This menu is empty. Add menu links on the left panel.</div>
                </div>
            `;
            lucide.createIcons();
            return;
        }

        items.forEach((item, index) => {
            const div = document.createElement('div');
            div.style.display = 'flex';
            div.style.alignItems = 'center';
            div.style.position = 'relative';
            
            // Indentation spacing
            const indentPixels = (item.indent || 0) * 24;
            div.style.paddingLeft = `${indentPixels}px`;

            // Draw line connector for nested items
            let connectorHtml = '';
            if (item.indent > 0) {
                connectorHtml = `
                    <div style="position: absolute; left: ${indentPixels - 14}px; top: -14px; width: 12px; height: 32px; border-left: 2px solid var(--cms-border-st); border-bottom: 2px solid var(--cms-border-st); border-bottom-left-radius: 6px; pointer-events: none;"></div>
                `;
            }

            div.innerHTML = `
                ${connectorHtml}
                <div style="flex: 1; display: flex; align-items: center; justify-content: space-between; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 10px 14px; min-height: 48px; box-shadow: 0 1px 2px rgba(0,0,0,0.01); margin-bottom: 4px;">
                    <div style="display: flex; align-items: center; gap: 8px; min-width: 0;">
                        <i data-lucide="grip-vertical" style="width: 14px; height: 14px; color: var(--cms-fg4); cursor: move; flex-shrink: 0;"></i>
                        <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${item.title}</span>
                        <span style="font-family: var(--cms-font-mono), monospace; font-size: 11px; color: var(--cms-fg4); overflow: hidden; text-overflow: ellipsis; max-width: 180px;">${item.url}</span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 4px; flex-shrink: 0;">
                        <button onclick="adjustIndent(${index}, -1)" title="Outdent" style="width: 24px; height: 24px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3); border-radius: 4px;" onmouseover="this.style.background='var(--cms-bg)'" onmouseout="this.style.background='transparent'">
                            <i data-lucide="arrow-left" style="width: 12px; height: 12px;"></i>
                        </button>
                        <button onclick="adjustIndent(${index}, 1)" title="Indent" style="width: 24px; height: 24px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3); border-radius: 4px;" onmouseover="this.style.background='var(--cms-bg)'" onmouseout="this.style.background='transparent'">
                            <i data-lucide="arrow-right" style="width: 12px; height: 12px;"></i>
                        </button>
                        <span style="width: 1px; height: 16px; background: var(--cms-border); margin: 0 4px;"></span>
                        <button onclick="deleteItem(${index})" title="Delete Link" style="width: 24px; height: 24px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red); border-radius: 4px;" onmouseover="this.style.background='var(--cms-red-soft)'" onmouseout="this.style.background='transparent'">
                            <i data-lucide="trash-2" style="width: 12px; height: 12px;"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        });

        lucide.createIcons();
    }

    function adjustIndent(index, amount) {
        const items = menusData[activeMenuId].items;
        let newIndent = (items[index].indent || 0) + amount;
        
        if (newIndent < 0) newIndent = 0;
        if (newIndent > 2) newIndent = 2;

        if (index === 0) newIndent = 0;
        else {
            const prevIndent = items[index - 1].indent || 0;
            if (newIndent > prevIndent + 1) newIndent = prevIndent + 1;
        }

        items[index].indent = newIndent;
        renderMenuTree();
    }

    function deleteItem(index) {
        menusData[activeMenuId].items.splice(index, 1);
        renderMenuTree();
    }

    function addMenuItem() {
        if (!activeMenuId) {
            alert('Please select or create a menu first.');
            return;
        }

        const titleInput = document.getElementById('new-item-title');
        const typeSelect = document.getElementById('new-item-type');
        
        const title = titleInput.value.trim();
        const type = typeSelect.value;
        let url = '';

        if (!title) {
            alert('Please specify a Link Title.');
            return;
        }

        if (type === 'custom') {
            url = document.getElementById('new-item-url').value.trim();
        } else {
            url = document.getElementById('new-item-ref').value;
        }

        const items = menusData[activeMenuId].items;
        const defaultIndent = items.length > 0 ? (items[items.length - 1].indent || 0) : 0;

        items.push({
            id: nextItemId++,
            title: title,
            type: type,
            url: url,
            indent: defaultIndent
        });

        titleInput.value = '';
        renderMenuTree();
        showToast(`"${title}" added to menu structure.`);
    }

    function openCreateMenuModal() {
        document.getElementById('create-menu-modal').style.display = 'flex';
        document.getElementById('new-menu-name').value = '';
        lucide.createIcons();
    }

    function closeCreateMenuModal() {
        document.getElementById('create-menu-modal').style.display = 'none';
    }

    async function submitCreateMenu() {
        const nameInput = document.getElementById('new-menu-name');
        const name = nameInput.value.trim();
        if (!name) return;

        try {
            const response = await fetch("{{ route('admin.menus.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name: name })
            });

            const data = await response.json();
            if (data.success) {
                const id = data.menu.id;
                menusData[id] = {
                    name: data.menu.name,
                    location: data.menu.location,
                    items: []
                };

                const container = document.getElementById('menus-list-container');
                const card = document.createElement('div');
                card.className = 'menu-list-card';
                card.onclick = () => selectMenu(id, card);
                card.style.cssText = "background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 14px; cursor: pointer; transition: all 120ms;";
                card.innerHTML = `
                    <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1);">${data.menu.name}</div>
                    <div style="font-size: 11.5px; color: var(--cms-fg3); margin-top: 4px;">Location: <strong>Unassigned</strong></div>
                    <div style="font-size: 11.5px; color: var(--cms-fg4); margin-top: 2px;">0 items • Created just now</div>
                `;
                
                container.appendChild(card);
                closeCreateMenuModal();
                selectMenu(id, card);
                showToast("Menu created successfully.");
            }
        } catch (error) {
            console.error('Error creating menu:', error);
            alert('Failed to create menu.');
        }
    }

    async function saveMenuStructure() {
        if (!activeMenuId) return;

        const location = document.getElementById('menu-location-select').value;
        const items = menusData[activeMenuId].items;

        try {
            const url = "{{ route('admin.menus.items.store', ':id') }}".replace(':id', activeMenuId);
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    location: location,
                    items: JSON.stringify(items)
                })
            });

            const data = await response.json();
            if (data.success) {
                menusData[activeMenuId].location = location;
                const activeCard = document.querySelector('.menu-list-card.active');
                if (activeCard) {
                    const locationStr = location === 'header' ? 'Header Main' : (location === 'footer' ? 'Footer Left' : 'Unassigned');
                    activeCard.querySelector('strong').textContent = locationStr;
                }
                showToast("Menu layout and link tree saved successfully ✓");
            }
        } catch (error) {
            console.error('Error saving menu:', error);
            alert('Failed to save menu structure.');
        }
    }

    function showToast(message) {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.style.cssText = "background: #17120D; border: 1.5px solid var(--cms-gold); border-radius: var(--cms-r-md); padding: 12px 20px; color: #fff; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 8px; box-shadow: var(--cms-sh-pop); animation: dsPop 180ms ease; min-width: 280px;";
        toast.innerHTML = `<i data-lucide="check-circle" style="width: 16px; height: 16px; color: var(--cms-gold); flex-shrink: 0;"></i> <span>${message}</span>`;
        container.appendChild(toast);
        lucide.createIcons();
        setTimeout(() => {
            toast.style.animation = "dsFade 200ms ease reverse";
            toast.style.opacity = "0";
            setTimeout(() => toast.remove(), 200);
        }, 3000);
    }
</script>
@endsection
