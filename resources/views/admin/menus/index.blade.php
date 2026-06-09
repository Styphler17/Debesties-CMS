@extends('admin.layouts.app')

@section('title', 'Navigation Builder — Debesties Studio')
@section('page_title', 'Navigation Builder')

@section('content')

{{-- Toast Container --}}
<div id="toast-container" style="position: fixed; bottom: 24px; right: 24px; z-index: 999; display: flex; flex-direction: column; gap: 8px;"></div>

<div style="display: grid; grid-template-columns: 280px 1fr; gap: 24px; align-items: start;">
    
    {{-- Left Panel: Menus List --}}
    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">Your Menus</span>
            <button onclick="openCreateMenuModal()"
                    style="display: inline-flex; align-items: center; gap: 4px; height: 28px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 600; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;">
                <i data-lucide="plus" style="width: 12px; height: 12px;"></i> Add Menu
            </button>
        </div>

        <div id="menus-list-container" style="display: flex; flex-direction: column; gap: 10px;">
            <div class="menu-list-card active" onclick="selectMenu(1, this)"
                 style="background: var(--cms-surface); border: 1.5px solid var(--cms-gold); border-radius: var(--cms-r-lg); padding: 14px; cursor: pointer; transition: all 120ms;">
                <div style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">Primary Header Navigation</div>
                <div style="font-size: 11.5px; color: var(--cms-fg3); margin-top: 4px;">Location: <strong style="color:var(--cms-gold-deep)">Header Main</strong></div>
                <div style="font-size: 11.5px; color: var(--cms-fg4); margin-top: 2px;">6 items • Updated 1d ago</div>
            </div>

            <div class="menu-list-card" onclick="selectMenu(2, this)"
                 style="background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 14px; cursor: pointer; transition: all 120ms;">
                <div style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">Footer Quick Links</div>
                <div style="font-size: 11.5px; color: var(--cms-fg3); margin-top: 4px;">Location: <strong>Footer Left</strong></div>
                <div style="font-size: 11.5px; color: var(--cms-fg4); margin-top: 2px;">3 items • Updated 3d ago</div>
            </div>
        </div>
    </div>

    {{-- Right Panel: Menu Editor --}}
    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 24px; align-items: start;">
        
        {{-- Add Item Box --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 20px; box-shadow: var(--cms-sh-card);">
            <h3 style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="plus-circle" style="width: 16px; height: 16px; color: var(--cms-gold-deep);"></i>
                Add Link to Menu
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <div>
                    <label style="font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 5px;">Link Title</label>
                    <input type="text" id="new-item-title" placeholder="e.g. Culture"
                           style="display: block; width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;" />
                </div>

                <div>
                    <label style="font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 5px;">Link Type</label>
                    <select id="new-item-type" onchange="toggleLinkSource()"
                            style="display: block; width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
                        <option value="custom">Custom URL</option>
                        <option value="page">Static Page</option>
                        <option value="category">Category</option>
                        <option value="post">Individual Post</option>
                    </select>
                </div>

                {{-- Source Select Panel --}}
                <div id="source-custom-panel">
                    <label style="font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 5px;">URL Path</label>
                    <input type="text" id="new-item-url" value="https://"
                           style="display: block; width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;" />
                </div>

                <div id="source-select-panel" style="display: none;">
                    <label style="font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 5px;">Reference Destination</label>
                    <select id="new-item-ref"
                            style="display: block; width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;"></select>
                </div>

                <button onclick="addMenuItem()"
                        style="height: 38px; width: 100%; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; background: var(--cms-fg1); color: #fff; border: none; border-radius: var(--cms-r-md); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: background 120ms;"
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
                    <h2 id="menu-editor-title" style="font-family: var(--cms-font-disp); font-size: 20px; font-weight: 700; color: var(--cms-fg1);">Primary Header Navigation</h2>
                    <p style="font-size: 12.5px; color: var(--cms-fg3); margin-top: 1px;">Drag handles or use controls to nest and sort links.</p>
                </div>

                <div style="display: flex; align-items: center; gap: 8px;">
                    <select id="menu-location-select"
                            style="height: 34px; padding: 0 8px; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 600; color: var(--cms-fg2); background: var(--cms-bg); border: 1px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
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
                        style="display: inline-flex; align-items: center; gap: 7px; height: 40px; padding: 0 20px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; transition: background 150ms;"
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
            <span style="font-family: var(--cms-font-ui); font-size: 16px; font-weight: 700; color: var(--cms-fg1);">Create New Menu</span>
            <button onclick="closeCreateMenuModal()" style="width: 28px; height: 28px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-bg); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);">
                <i data-lucide="x" style="width: 12px; height: 12px;"></i>
            </button>
        </div>
        <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 20px;">
            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Menu Name</label>
                <input type="text" id="new-menu-name" placeholder="e.g. Primary Header"
                       style="display: block; width: 100%; height: 40px; padding: 0 10px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;" />
            </div>
        </div>
        <div style="display: flex; gap: 8px;">
            <button onclick="closeCreateMenuModal()" style="flex: 1; height: 38px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; background: var(--cms-bg); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Cancel</button>
            <button onclick="submitCreateMenu()" style="flex: 1.5; height: 38px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;">Create</button>
        </div>
    </div>
</div>

<script>
    let activeMenuId = 1;
    let nextItemId = 10;
    let nextMenuId = 3;

    // Seed Data structure
    const menusData = {
        1: {
            name: "Primary Header Navigation",
            location: "header",
            items: [
                { id: 1, title: "Home", type: "page", url: "/", indent: 0 },
                { id: 2, title: "Features", type: "page", url: "/features", indent: 0 },
                { id: 3, title: "Categories", type: "category", url: "/category/all", indent: 0 },
                { id: 4, title: "Music & Beats", type: "category", url: "/category/music", indent: 1 },
                { id: 5, title: "Culture & Life", type: "category", url: "/category/culture", indent: 1 },
                { id: 6, title: "Contact Us", type: "custom", url: "/contact", indent: 0 }
            ]
        },
        2: {
            name: "Footer Quick Links",
            location: "footer",
            items: [
                { id: 7, title: "About Studio", type: "page", url: "/about", indent: 0 },
                { id: 8, title: "Advertise", type: "page", url: "/advertise", indent: 0 },
                { id: 9, title: "Privacy Statement", type: "custom", url: "/privacy", indent: 0 }
            ]
        }
    };

    // References mapping for selectors
    const references = {
        page: [
            { title: "Home Page", url: "/" },
            { title: "About Us", url: "/about" },
            { title: "Advertise", url: "/advertise" },
            { title: "Gallery", url: "/gallery" }
        ],
        category: [
            { title: "Music & Beats", url: "/category/music" },
            { title: "Culture & Life", url: "/category/culture" },
            { title: "Fashion Trends", url: "/category/fashion" }
        ],
        post: [
            { title: "The Elite Club: Artists Domination", url: "/posts/elite-club" },
            { title: "10 Tips for Web Vitals Optimization", url: "/posts/web-vitals" }
        ]
    };

    document.addEventListener("DOMContentLoaded", () => {
        renderMenuTree();
        toggleLinkSource();
    });

    function selectMenu(id, cardElement) {
        activeMenuId = id;
        
        // Highlight card
        document.querySelectorAll('.menu-list-card').forEach(el => {
            el.classList.remove('active');
            el.style.borderColor = 'var(--cms-border)';
        });
        cardElement.classList.add('active');
        cardElement.style.borderColor = 'var(--cms-gold)';

        // Update titles
        const menu = menusData[id];
        document.getElementById('menu-editor-title').textContent = menu.name;
        document.getElementById('menu-location-select').value = menu.location;

        renderMenuTree();
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
            references[type].forEach(ref => {
                const opt = document.createElement('option');
                opt.value = ref.url;
                opt.textContent = ref.title;
                selectElement.appendChild(opt);
            });
        }
    }

    // Render tree with L connectors
    function renderMenuTree() {
        const container = document.getElementById('tree-container');
        container.innerHTML = '';

        const items = menusData[activeMenuId].items;

        if (items.length === 0) {
            container.innerHTML = `
                <div style="border: 2px dashed var(--cms-border); border-radius: var(--cms-r-md); padding: 32px; text-align: center; color: var(--cms-fg4); font-family: var(--cms-font-ui); font-size: 13.5px;">
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
            const indentPixels = item.indent * 24;
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
                <div style="flex: 1; display: flex; align-items: center; justify-content: space-between; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 10px 14px; min-height: 48px; box-shadow: 0 1px 2px rgba(0,0,0,0.01);">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="grip-vertical" style="width: 14px; height: 14px; color: var(--cms-fg4); cursor: move;"></i>
                        <span style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; color: var(--cms-fg1);">${item.title}</span>
                        <span style="font-size: 10.5px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; background: var(--cms-bg); padding: 1px 6px; border-radius: 999px;">${item.type}</span>
                        <span style="font-family: var(--cms-font-mono); font-size: 11px; color: var(--cms-fg4); overflow: hidden; text-overflow: ellipsis; max-width: 200px;">${item.url}</span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 4px;">
                        {{-- Indentation Controls --}}
                        <button onclick="adjustIndent(${index}, -1)" title="Outdent" style="width: 24px; height: 24px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3); border-radius: 4px;" onmouseover="this.style.background='var(--cms-bg)'" onmouseout="this.style.background='transparent'">
                            <i data-lucide="arrow-left" style="width: 12px; height: 12px;"></i>
                        </button>
                        <button onclick="adjustIndent(${index}, 1)" title="Indent" style="width: 24px; height: 24px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3); border-radius: 4px;" onmouseover="this.style.background='var(--cms-bg)'" onmouseout="this.style.background='transparent'">
                            <i data-lucide="arrow-right" style="width: 12px; height: 12px;"></i>
                        </button>
                        <span style="width: 1px; height: 16px; background: var(--cms-border); margin: 0 4px;"></span>
                        {{-- Delete --}}
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
        
        let newIndent = items[index].indent + amount;
        
        // Boundaries: 0 to 2 indentation levels
        if (newIndent < 0) newIndent = 0;
        if (newIndent > 2) newIndent = 2;

        // Prevent indents without a parent
        if (index === 0) newIndent = 0;
        else {
            const prevIndent = items[index - 1].indent;
            if (newIndent > prevIndent + 1) {
                newIndent = prevIndent + 1;
            }
        }

        items[index].indent = newIndent;
        renderMenuTree();
    }

    function deleteItem(index) {
        menusData[activeMenuId].items.splice(index, 1);
        renderMenuTree();
    }

    function addMenuItem() {
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
        
        // Find default indent matching the last item
        const defaultIndent = items.length > 0 ? items[items.length - 1].indent : 0;

        items.push({
            id: nextItemId++,
            title: title,
            type: type,
            url: url,
            indent: defaultIndent
        });

        // Clear title field
        titleInput.value = '';
        renderMenuTree();
        showToast(`"${title}" added to menu structure.`);
    }

    // Modal Add Menu
    function openCreateMenuModal() {
        document.getElementById('create-menu-modal').style.display = 'flex';
        document.getElementById('new-menu-name').value = '';
        lucide.createIcons();
    }

    function closeCreateMenuModal() {
        document.getElementById('create-menu-modal').style.display = 'none';
    }

    function submitCreateMenu() {
        const nameInput = document.getElementById('new-menu-name');
        const name = nameInput.value.trim();
        if (!name) return;

        const id = nextMenuId++;
        menusData[id] = {
            name: name,
            location: "none",
            items: []
        };

        const container = document.getElementById('menus-list-container');
        const card = document.createElement('div');
        card.className = 'menu-list-card';
        card.onclick = () => selectMenu(id, card);
        card.style.cssText = "background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 14px; cursor: pointer; transition: all 120ms;";
        card.innerHTML = `
            <div style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">${name}</div>
            <div style="font-size: 11.5px; color: var(--cms-fg3); margin-top: 4px;">Location: <strong>Unassigned</strong></div>
            <div style="font-size: 11.5px; color: var(--cms-fg4); margin-top: 2px;">0 items • Created just now</div>
        `;
        
        container.appendChild(card);
        closeCreateMenuModal();
        selectMenu(id, card);
    }

    // Save AJAC simulation
    function saveMenuStructure() {
        const location = document.getElementById('menu-location-select').value;
        menusData[activeMenuId].location = location;

        const activeCard = document.querySelector('.menu-list-card.active');
        if (activeCard) {
            // Update location label inside left panel card
            const locationStr = location === 'header' ? 'Header Main' : (location === 'footer' ? 'Footer Left' : 'Unassigned');
            activeCard.querySelector('strong').textContent = locationStr;
        }

        showToast("Menu layout and link tree saved successfully ✓");
    }

    // Toast Generator
    function showToast(message) {
        const container = document.getElementById('toast-container');
        
        const toast = document.createElement('div');
        toast.style.cssText = "background: #17120D; border: 1.5px solid var(--cms-gold); border-radius: var(--cms-r-md); padding: 12px 20px; color: #fff; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 8px; box-shadow: var(--cms-sh-pop); animation: dsPop 180ms ease; min-width: 280px;";
        toast.innerHTML = `<i data-lucide="check-circle" style="width: 16px; height: 16px; color: var(--cms-gold); flex-shrink: 0;"></i> <span>${message}</span>`;
        
        container.appendChild(toast);
        lucide.createIcons();

        // Auto remove toast
        setTimeout(() => {
            toast.style.animation = "dsFade 200ms ease reverse";
            toast.style.opacity = "0";
            setTimeout(() => toast.remove(), 200);
        }, 3000);
    }
</script>
@endsection
