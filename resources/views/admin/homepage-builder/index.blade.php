@extends('admin.layouts.app')

@section('title', 'Homepage Builder — Debesties Studio')
@section('page_title', 'Homepage Builder')

@section('content')

{{-- Toast Container --}}
<div id="toast-container" style="position: fixed; bottom: 24px; right: 24px; z-index: 999; display: flex; flex-direction: column; gap: 8px;"></div>

<div style="display: grid; grid-template-columns: 260px 1fr 320px; gap: 24px; align-items: start;">
    
    {{-- Left Panel: Widget Palette --}}
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 20px; box-shadow: var(--cms-sh-card);">
        <h3 style="font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; color: var(--cms-fg2); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 12px;">Widget Library</h3>
        <p style="font-size: 12.5px; color: var(--cms-fg3); margin-bottom: 16px; line-height: 1.4;">Click a widget card to add it as a new section on your homepage canvas.</p>
        
        <div style="display: flex; flex-direction: column; gap: 10px;">
            @php
                $widgets = [
                    ['type' => 'hero', 'name' => 'Hero Banner', 'desc' => 'High-impact greeting section with CTA button and image.', 'icon' => 'layout-template'],
                    ['type' => 'grid', 'name' => 'Featured Posts Grid', 'desc' => 'Displays curated articles in a modern masonry block grid.', 'icon' => 'grid'],
                    ['type' => 'categories', 'name' => 'Category Showcase', 'desc' => 'Lists main editorial categories with quick tags.', 'icon' => 'folder-heart'],
                    ['type' => 'strip', 'name' => 'Latest News Strip', 'desc' => 'Horizontal ticker layout of the most recent publications.', 'icon' => 'newspaper'],
                    ['type' => 'newsletter', 'name' => 'Newsletter Signup', 'desc' => 'Email capture form to grow mailing list subscribers.', 'icon' => 'mail']
                ];
            @endphp

            @foreach($widgets as $w)
                <div class="widget-card"
                     data-widget-type="{{ $w['type'] }}"
                     data-widget-name="{{ $w['name'] }}"
                     style="background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 12px; cursor: pointer; transition: all 120ms; text-align: left;"
                     onmouseover="this.style.borderColor='var(--cms-gold)'; this.style.background='var(--cms-surface)'"
                     onmouseout="this.style.borderColor='var(--cms-border)'; this.style.background='var(--cms-bg)'">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                        <span style="display: flex; align-items: center; gap: 6px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; color: var(--cms-fg1);">
                            <i data-lucide="{{ $w['icon'] }}" style="width: 14px; height: 14px; color: var(--cms-gold-deep);"></i>
                            {{ $w['name'] }}
                        </span>
                        <i data-lucide="plus" style="width: 13px; height: 13px; color: var(--cms-fg3);"></i>
                    </div>
                    <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 11.5px; color: var(--cms-fg3); line-height: 1.4;">{{ $w['desc'] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Main Panel: Drop Canvas --}}
    <div style="display: flex; flex-direction: column; gap: 20px;">
        
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 24px; box-shadow: var(--cms-sh-card);">
            <div style="border-bottom: 1px solid var(--cms-border); padding-bottom: 14px; margin-bottom: 20px;">
                <h2 style="font-family: var(--cms-font-disp), serif; font-size: 20px; font-weight: 700; color: var(--cms-fg1);">Active Homepage Layout</h2>
                <p style="font-size: 12.5px; color: var(--cms-fg3); margin-top: 1px;">Drag and drop blocks to reorder. Changes take effect on the live site after saving.</p>
            </div>

            {{-- Canvas Box --}}
            <div id="canvas-container" style="display: flex; flex-direction: column; gap: 12px; min-height: 350px; padding: 6px; background: rgba(0,0,0,0.01); border-radius: var(--cms-r-lg);">
                {{-- Dynamic Canvas Blocks --}}
            </div>

            {{-- Save Action --}}
            <div style="border-top: 1px solid var(--cms-border); padding-top: 20px; margin-top: 20px; display: flex; justify-content: flex-end;">
                <button id="save-btn" onclick="saveLayout()"
                        style="display: inline-flex; align-items: center; gap: 7px; height: 40px; padding: 0 20px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; transition: background 150ms;"
                        onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                    <i data-lucide="save" style="width: 16px; height: 16px;"></i>
                    Save Homepage Layout
                </button>
            </div>
        </div>

    </div>

    {{-- Right Panel: Configuration Sidebar --}}
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 20px; box-shadow: var(--cms-sh-card); position: sticky; top: 88px;">
        <h3 style="font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; color: var(--cms-fg2); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
            <i data-lucide="settings" style="width: 15px; height: 15px; color: var(--cms-fg3);"></i>
            Widget Inspector
        </h3>
        <div id="inspector-placeholder" style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg3); text-align: center; padding: 48px 0; border: 1.5px dashed var(--cms-border); border-radius: var(--cms-r-md); margin-top: 14px;">
            <i data-lucide="info" style="width: 20px; height: 20px; color: var(--cms-fg4); margin-bottom: 6px; display: inline-block;"></i>
            <div>Click the settings cog <strong style="color:var(--cms-gold-deep)">⚙</strong> on any section block to inspect and customize its variables.</div>
        </div>

        {{-- Dynamic configuration forms --}}
        <div id="inspector-form-container" style="display: none; flex-direction: column; gap: 14px; margin-top: 14px;">
            <div style="background: var(--cms-bg); border-radius: var(--cms-r-md); padding: 10px 12px; margin-bottom: 4px;">
                <span id="inspector-widget-title" style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 700; color: var(--cms-fg1);">Hero Banner</span>
                <span id="inspector-widget-type-badge" style="font-size: 10px; font-weight: 700; color: var(--cms-fg3); background: rgba(0,0,0,0.05); padding: 1px 6px; border-radius: 999px; float: right; text-transform: uppercase;">hero</span>
            </div>

            <div id="inspector-fields" style="display: flex; flex-direction: column; gap: 12px;">
                {{-- Form fields injected here by JS --}}
            </div>

            <button onclick="applySettings()"
                    style="height: 38px; width: 100%; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 700; background: var(--cms-fg1); color: #fff; border: none; border-radius: var(--cms-r-md); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 8px; transition: background 120ms;"
                    onmouseover="this.style.background='var(--cms-fg2)'" onmouseout="this.style.background='var(--cms-fg1)'">
                <i data-lucide="check" style="width: 14px; height: 14px;"></i>
                Apply Changes
            </button>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script id="homepage-layout-data" type="application/json">
    {!! $layout !!}
</script>
<script id="homepage-categories-data" type="application/json">
    {!! json_encode($categories) !!}
</script>
<div id="homepage-builder-config"
     data-store-url="{{ route('admin.homepage-builder.store') }}"
     data-csrf-token="{{ csrf_token() }}"
     hidden></div>

<script>
    let activeWidgets = JSON.parse(document.getElementById('homepage-layout-data').textContent);
    const categories = JSON.parse(document.getElementById('homepage-categories-data').textContent);
    const homepageBuilderConfigElement = document.getElementById('homepage-builder-config');
    const homepageBuilderConfig = {
        storeUrl: homepageBuilderConfigElement.dataset.storeUrl,
        csrfToken: homepageBuilderConfigElement.dataset.csrfToken
    };

    let nextWidgetId = activeWidgets.reduce((max, w) => Math.max(max, w.id || 0), 0) + 1;
    let selectedInspectorId = null;
    let sortable = null;

    document.addEventListener("DOMContentLoaded", () => {
        initSortable();
        document.querySelectorAll('.widget-card').forEach(card => {
            card.addEventListener('click', () => {
                addWidget(card.dataset.widgetType, card.dataset.widgetName);
            });
        });
        renderCanvas();
    });

    function initSortable() {
        const el = document.getElementById('canvas-container');
        sortable = Sortable.create(el, {
            animation: 150,
            handle: '.grip-handle',
            ghostClass: 'cms-sortable-ghost',
            onEnd: function (evt) {
                // Update activeWidgets array based on new DOM order
                const newOrder = [];
                const blocks = el.querySelectorAll('[data-widget-id]');
                blocks.forEach(block => {
                    const id = parseInt(block.getAttribute('data-widget-id'));
                    const widget = activeWidgets.find(w => w.id === id);
                    if (widget) newOrder.push(widget);
                });
                activeWidgets = newOrder;
                renderCanvas();
            },
        });
    }

    function renderCanvas() {
        const container = document.getElementById('canvas-container');
        container.innerHTML = '';

        if (activeWidgets.length === 0) {
            container.innerHTML = `
                <div style="border: 2px dashed var(--cms-border); border-radius: var(--cms-r-lg); padding: 48px; text-align: center; color: var(--cms-fg4); font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; display: flex; flex-direction: column; align-items: center; justify-content: center; flex: 1;">
                    <i data-lucide="layers" style="width: 32px; height: 32px; color: var(--cms-fg4); margin-bottom: 12px;"></i>
                    <div style="font-weight: 600; color: var(--cms-fg2);">Your Homepage is Empty</div>
                    <div style="margin-top: 4px;">Click components in the Widget Library to assemble the landing page.</div>
                </div>
            `;
            lucide.createIcons();
            return;
        }

        activeWidgets.forEach((widget, index) => {
            const block = document.createElement('div');
            block.setAttribute('data-widget-id', widget.id);
            block.style.cssText = "background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 14px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.01); transition: border-color 150ms;";
            block.onmouseover = () => { block.style.borderColor = 'var(--cms-border-st)'; };
            block.onmouseout = () => { block.style.borderColor = 'var(--cms-border)'; };

            let previewText = '';
            if (widget.type === 'hero') {
                previewText = `"${widget.settings.headline}"`;
            } else if (widget.type === 'grid') {
                previewText = `Limit: ${widget.settings.limit} • Category: ${widget.settings.category}`;
            } else if (widget.type === 'newsletter') {
                previewText = `CTA: "${widget.settings.cta}"`;
            } else if (widget.type === 'categories') {
                previewText = `Showcase Section`;
            } else if (widget.type === 'strip') {
                previewText = `News ticker style`;
            }

            block.innerHTML = `
                <div style="display: flex; align-items: center; gap: 12px; min-width: 0;">
                    <div class="grip-handle" style="padding: 4px; cursor: move; color: var(--cms-fg4);">
                        <i data-lucide="grip-vertical" style="width: 14px; height: 14px;"></i>
                    </div>
                    
                    {{-- Mini block preview representing sections --}}
                    <div style="width: 50px; height: 34px; border-radius: 4px; background: var(--cms-bg); border: 1px solid var(--cms-border); display: flex; flex-direction: column; justify-content: center; gap: 3px; padding: 4px; flex-shrink: 0; opacity: 0.85;">
                        <div style="width: 70%; height: 5px; background: var(--cms-fg3); border-radius: 2px;"></div>
                        <div style="width: 45%; height: 3px; background: var(--cms-fg4); border-radius: 2px;"></div>
                        <div style="width: 25%; height: 4px; background: var(--cms-gold); border-radius: 2px; margin-top: 2px;"></div>
                    </div>

                    <div style="min-width: 0;">
                        <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; color: var(--cms-fg1); display: block;">${widget.name}</span>
                        <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 11.5px; color: var(--cms-fg4); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; max-width: 320px;">${previewText}</span>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 4px;">
                    {{-- Configure --}}
                    <button onclick="inspectWidget(${widget.id})" title="Configure settings" style="width: 26px; height: 26px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-gold-deep); border-radius: 4px;" onmouseover="this.style.background='var(--cms-gold-soft)'" onmouseout="this.style.background='transparent'">
                        <i data-lucide="settings" style="width: 14px; height: 14px;"></i>
                    </button>

                    {{-- Remove --}}
                    <button onclick="removeWidget(${index})" title="Remove Widget" style="width: 26px; height: 26px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red); border-radius: 4px;" onmouseover="this.style.background='var(--cms-red-soft)'" onmouseout="this.style.background='transparent'">
                        <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                    </button>
                </div>
            `;
            container.appendChild(block);
        });

        lucide.createIcons();
    }

    function addWidget(type, name) {
        let settings = {};
        if (type === 'hero') {
            settings = { headline: 'Welcome to Debesties Studio', subtext: 'Discover curated stories.', cta_label: 'Explore', cta_link: '#', theme: 'gold-black' };
        } else if (type === 'grid') {
            settings = { limit: 6, category: 'all', style: 'grid' };
        } else if (type === 'newsletter') {
            settings = { placeholder: 'Your email address...', cta: 'Subscribe' };
        } else if (type === 'categories') {
            settings = { heading: 'Read by Category' };
        } else if (type === 'strip') {
            settings = { items: 5 };
        }

        activeWidgets.push({
            id: nextWidgetId++,
            type: type,
            name: name,
            settings: settings
        });

        renderCanvas();
        showToast(`"${name}" appended to layout canvas.`);
    }

    function removeWidget(index) {
        const widget = activeWidgets[index];
        if (selectedInspectorId === widget.id) {
            closeInspector();
        }
        activeWidgets.splice(index, 1);
        renderCanvas();
    }

    // INSPECTOR PANEL LOGIC
    function inspectWidget(id) {
        selectedInspectorId = id;
        const widget = activeWidgets.find(w => w.id === id);
        if (!widget) return;

        document.getElementById('inspector-placeholder').style.display = 'none';
        document.getElementById('inspector-form-container').style.display = 'flex';

        // Update titles
        document.getElementById('inspector-widget-title').textContent = widget.name;
        document.getElementById('inspector-widget-type-badge').textContent = widget.type;

        // Render Fields
        const fieldsBox = document.getElementById('inspector-fields');
        fieldsBox.innerHTML = '';

        if (widget.type === 'hero') {
            fieldsBox.innerHTML = `
                <div>
                    <label class="insp-lbl">Headline Text</label>
                    <input type="text" id="insp-hero-head" value="${widget.settings.headline}" class="insp-in">
                </div>
                <div>
                    <label class="insp-lbl">Subtext Description</label>
                    <textarea id="insp-hero-sub" class="insp-ta">${widget.settings.subtext}</textarea>
                </div>
                <div>
                    <label class="insp-lbl">CTA Button Label</label>
                    <input type="text" id="insp-hero-cta" value="${widget.settings.cta_label}" class="insp-in">
                </div>
                <div>
                    <label class="insp-lbl">CTA Button URL Link</label>
                    <input type="text" id="insp-hero-link" value="${widget.settings.cta_link}" class="insp-in">
                </div>
                <div>
                    <label class="insp-lbl">Hero Color Palette</label>
                    <select id="insp-hero-theme" class="insp-sl">
                        <option value="gold-black" ${widget.settings.theme === 'gold-black' ? 'selected' : ''}>Gold Accents & Sleek Black</option>
                        <option value="sunset" ${widget.settings.theme === 'sunset' ? 'selected' : ''}>Sunset Orange & Deep Purple</option>
                        <option value="skyline" ${widget.settings.theme === 'skyline' ? 'selected' : ''}>Midnight Blue & Silver</option>
                    </select>
                </div>
            `;
        } else if (widget.type === 'grid') {
            let catOptions = `<option value="all" ${widget.settings.category === 'all' ? 'selected' : ''}>All Categories</option>`;
            categories.forEach(cat => {
                catOptions += `<option value="${cat.slug}" ${widget.settings.category === cat.slug ? 'selected' : ''}>${cat.name}</option>`;
            });

            fieldsBox.innerHTML = `
                <div>
                    <label class="insp-lbl">Post Limit</label>
                    <input type="number" id="insp-grid-limit" value="${widget.settings.limit}" class="insp-in">
                </div>
                <div>
                    <label class="insp-lbl">Category Filter</label>
                    <select id="insp-grid-cat" class="insp-sl">
                        ${catOptions}
                    </select>
                </div>
                <div>
                    <label class="insp-lbl">Grid Layout style</label>
                    <select id="insp-grid-style" class="insp-sl">
                        <option value="masonry" ${widget.settings.style === 'masonry' ? 'selected' : ''}>Visual Masonry Blocks</option>
                        <option value="grid" ${widget.settings.style === 'grid' ? 'selected' : ''}>Balanced Column Grid</option>
                    </select>
                </div>
            `;
        } else if (widget.type === 'newsletter') {
            fieldsBox.innerHTML = `
                <div>
                    <label class="insp-lbl">Input Field Placeholder</label>
                    <input type="text" id="insp-news-holder" value="${widget.settings.placeholder}" class="insp-in">
                </div>
                <div>
                    <label class="insp-lbl">Subscribe Button Text</label>
                    <input type="text" id="insp-news-cta" value="${widget.settings.cta}" class="insp-in">
                </div>
            `;
        } else if (widget.type === 'categories') {
            fieldsBox.innerHTML = `
                <div>
                    <label class="insp-lbl">Section Header</label>
                    <input type="text" id="insp-cat-heading" value="${widget.settings.heading || 'Read by Category'}" class="insp-in">
                </div>
            `;
        } else if (widget.type === 'strip') {
            fieldsBox.innerHTML = `
                <div>
                    <label class="insp-lbl">Number of Articles in Strip</label>
                    <input type="number" id="insp-strip-items" value="${widget.settings.items || 5}" class="insp-in">
                </div>
            `;
        }

        lucide.createIcons();
    }

    function applySettings() {
        if (!selectedInspectorId) return;
        const widget = activeWidgets.find(w => w.id === selectedInspectorId);
        if (!widget) return;

        if (widget.type === 'hero') {
            widget.settings.headline = document.getElementById('insp-hero-head').value.trim();
            widget.settings.subtext = document.getElementById('insp-hero-sub').value.trim();
            widget.settings.cta_label = document.getElementById('insp-hero-cta').value.trim();
            widget.settings.cta_link = document.getElementById('insp-hero-link').value.trim();
            widget.settings.theme = document.getElementById('insp-hero-theme').value;
        } else if (widget.type === 'grid') {
            widget.settings.limit = parseInt(document.getElementById('insp-grid-limit').value);
            widget.settings.category = document.getElementById('insp-grid-cat').value;
            widget.settings.style = document.getElementById('insp-grid-style').value;
        } else if (widget.type === 'newsletter') {
            widget.settings.placeholder = document.getElementById('insp-news-holder').value.trim();
            widget.settings.cta = document.getElementById('insp-news-cta').value.trim();
        } else if (widget.type === 'categories') {
            widget.settings.heading = document.getElementById('insp-cat-heading').value.trim();
        } else if (widget.type === 'strip') {
            widget.settings.items = parseInt(document.getElementById('insp-strip-items').value);
        }

        renderCanvas();
        closeInspector();
        showToast("Settings applied successfully to preview.");
    }

    function closeInspector() {
        document.getElementById('inspector-placeholder').style.display = 'block';
        document.getElementById('inspector-form-container').style.display = 'none';
        selectedInspectorId = null;
    }

    function saveLayout() {
        const btn = document.getElementById('save-btn');
        const originalContent = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i data-lucide="loader-2" class="spin" style="width: 16px; height: 16px;"></i> Saving...';
        lucide.createIcons();

        fetch(homepageBuilderConfig.storeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': homepageBuilderConfig.csrfToken
            },
            body: JSON.stringify({
                layout: JSON.stringify(activeWidgets)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message || "Homepage layout configuration saved successfully ✓");
            } else {
                showToast("Failed to save layout configuration.");
            }
        })
        .catch(error => {
            console.error('Error saving layout:', error);
            showToast("An error occurred while saving.");
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalContent;
            lucide.createIcons();
        });
    }

    // Toast Generator
    function showToast(message) {
        const container = document.getElementById('toast-container');
        
        const toast = document.createElement('div');
        toast.style.cssText = "background: #17120D; border: 1.5px solid var(--cms-gold); border-radius: var(--cms-r-md); padding: 12px 20px; color: #fff; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 8px; box-shadow: var(--cms-sh-pop); animation: dsPop 180ms ease; min-width: 280px;";
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

<style>
    .cms-sortable-ghost {
        opacity: 0.4;
        background: var(--cms-gold-soft) !important;
        border: 2px dashed var(--cms-gold) !important;
    }
    .spin {
        animation: dsRotate 1s linear infinite;
    }
    @keyframes dsRotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .insp-lbl {
        font-family: var(--cms-font-ui), sans-serif;
        font-size: 11px;
        font-weight: 700;
        color: var(--cms-fg3);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        display: block;
        margin-bottom: 5px;
    }
    .insp-in {
        display: block;
        width: 100%;
        height: 38px;
        padding: 0 10px;
        font-family: var(--cms-font-ui), sans-serif;
        font-size: 13px;
        color: var(--cms-fg1);
        background: var(--cms-bg);
        border: 1.5px solid var(--cms-border);
        border-radius: var(--cms-r-md);
        outline: none;
    }
    .insp-ta {
        display: block;
        width: 100%;
        height: 60px;
        padding: 8px 10px;
        font-family: var(--cms-font-ui), sans-serif;
        font-size: 13px;
        color: var(--cms-fg1);
        background: var(--cms-bg);
        border: 1.5px solid var(--cms-border);
        border-radius: var(--cms-r-md);
        outline: none;
        resize: none;
    }
    .insp-sl {
        display: block;
        width: 100%;
        height: 38px;
        padding: 0 10px;
        font-family: var(--cms-font-ui), sans-serif;
        font-size: 13px;
        color: var(--cms-fg1);
        background: var(--cms-bg);
        border: 1.5px solid var(--cms-border);
        border-radius: var(--cms-r-md);
        cursor: pointer;
        outline: none;
    }
</style>
@endsection
