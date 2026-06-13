@extends('admin.layouts.app')

@section('title', 'New Page — Page Builder — Debesties Studio')
@section('page_title', 'Create New Page')

@section('content')

{{-- Toast Container --}}
<div id="toast-container" style="position: fixed; bottom: 24px; right: 24px; z-index: 999; display: flex; flex-direction: column; gap: 8px;"></div>

{{-- Tabs: Document Info vs Visual Builder --}}
<div style="display: flex; align-items: center; gap: 0; margin-bottom: 24px; border-bottom: 2px solid var(--cms-border);">
    <button id="tab-info" onclick="switchTab('info')"
            style="font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; padding: 12px 20px; background: none; border: none; border-bottom: 2.5px solid var(--cms-gold); color: var(--cms-fg1); cursor: pointer; margin-bottom: -2px; transition: all 150ms;">
        <span style="display: flex; align-items: center; gap: 6px;"><i data-lucide="file-text" style="width: 15px; height: 15px;"></i> Document Info</span>
    </button>
    <button id="tab-builder" onclick="switchTab('builder')"
            style="font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; padding: 12px 20px; background: none; border: none; border-bottom: 2.5px solid transparent; color: var(--cms-fg3); cursor: pointer; margin-bottom: -2px; transition: all 150ms;">
        <span style="display: flex; align-items: center; gap: 6px;"><i data-lucide="layout" style="width: 15px; height: 15px;"></i> Visual Builder</span>
    </button>
</div>

<form id="page-form" action="{{ route('admin.pages.store') }}" method="POST">
    @csrf
    <input type="hidden" name="layout" id="layout-input" />

    {{-- TAB 1: Document Info --}}
    <div id="panel-info">
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 28px; box-shadow: var(--cms-sh-card); max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 20px;">

            {{-- Title --}}
            <div>
                <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Page Title</label>
                <input type="text" name="title" id="page-title" value="{{ old('title') }}" placeholder="e.g. About Us" required
                       style="display: block; width: 100%; height: 42px; padding: 0 14px; font-family: var(--cms-font-ui), sans-serif; font-size: 14px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; transition: border-color 150ms;"
                       onfocus="this.style.borderColor='var(--cms-gold)';" onblur="this.style.borderColor='var(--cms-border)';" />
            </div>

            {{-- Status --}}
            <div>
                <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Status</label>
                <select name="status" required
                        style="display: block; width: 100%; height: 42px; padding: 0 14px; font-family: var(--cms-font-ui), sans-serif; font-size: 14px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; cursor: pointer;">
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (hidden from public)</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published (live on site)</option>
                </select>
            </div>

            {{-- Traditional Body (fallback for non-builder pages) --}}
            <div id="traditional-body-field">
                <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">
                    Page Content (HTML) — <span style="font-weight: 400; text-transform: none; font-size: 11.5px; color: var(--cms-fg4);">Ignored when using Visual Builder</span>
                </label>
                <textarea name="body" id="body-textarea" placeholder="Write page content here..."
                          style="display: block; width: 100%; min-height: 200px; padding: 14px; font-family: var(--cms-font-ui), sans-serif; font-size: 14px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; resize: vertical; transition: border-color 150ms;"
                          onfocus="this.style.borderColor='var(--cms-gold)';" onblur="this.style.borderColor='var(--cms-border)';">{{ old('body') }}</textarea>
            </div>

            {{-- Info about builder mode --}}
            <div id="builder-active-notice" style="display: none; background: rgba(232,168,0,0.08); border: 1.5px solid rgba(232,168,0,0.25); border-radius: var(--cms-r-md); padding: 14px 18px;">
                <div style="display: flex; align-items: center; gap: 8px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg2);">
                    <i data-lucide="layout" style="width: 16px; height: 16px; color: var(--cms-gold);"></i>
                    <strong>Visual Builder Active</strong> — Page content is managed through the builder canvas. Switch to the <em>Visual Builder</em> tab to edit sections.
                </div>
            </div>
        </div>
    </div>

    {{-- TAB 2: Visual Builder --}}
    <div id="panel-builder" style="display: none;">
        <div style="display: grid; grid-template-columns: 240px 1fr 300px; gap: 20px; align-items: start;">

            {{-- Left: Widget Library --}}
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 18px; box-shadow: var(--cms-sh-card); position: sticky; top: 88px;">
                <h3 style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; font-weight: 700; color: var(--cms-fg2); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                    <i data-lucide="box" style="width: 14px; height: 14px; color: var(--cms-gold);"></i>
                    Widgets
                </h3>

                <div style="display: flex; flex-direction: column; gap: 6px;" id="widget-palette">
                    {{-- Widgets are added via JS --}}
                </div>

                <div style="border-top: 1px solid var(--cms-border); margin-top: 14px; padding-top: 14px;">
                    <h3 style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; font-weight: 700; color: var(--cms-fg2); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                        <i data-lucide="columns" style="width: 14px; height: 14px; color: var(--cms-gold);"></i>
                        Add Section
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 6px;" id="section-palette">
                        {{-- Section layouts added via JS --}}
                    </div>
                </div>
            </div>

            {{-- Center: Canvas --}}
            <div>
                <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 20px; box-shadow: var(--cms-sh-card);">
                    <div style="border-bottom: 1px solid var(--cms-border); padding-bottom: 12px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <h2 style="font-family: var(--cms-font-disp), serif; font-size: 18px; font-weight: 700; color: var(--cms-fg1);">Page Canvas</h2>
                            <p style="font-size: 12px; color: var(--cms-fg3); margin-top: 2px;">Drag sections to reorder. Click ⚙ to configure widgets.</p>
                        </div>
                        <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 11px; font-weight: 600; color: var(--cms-fg4); background: var(--cms-bg); padding: 4px 10px; border-radius: 999px;">
                            <span id="section-count">0</span> sections
                        </div>
                    </div>

                    <div id="canvas-container" style="display: flex; flex-direction: column; gap: 12px; min-height: 300px; padding: 4px; border-radius: var(--cms-r-lg);">
                        {{-- Dynamic Sections --}}
                    </div>
                </div>
            </div>

            {{-- Right: Inspector --}}
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 18px; box-shadow: var(--cms-sh-card); position: sticky; top: 88px;">
                <h3 style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; font-weight: 700; color: var(--cms-fg2); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                    <i data-lucide="settings" style="width: 14px; height: 14px; color: var(--cms-fg3);"></i>
                    Inspector
                </h3>

                <div id="inspector-placeholder" style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; color: var(--cms-fg3); text-align: center; padding: 40px 12px; border: 1.5px dashed var(--cms-border); border-radius: var(--cms-r-md); margin-top: 12px;">
                    <i data-lucide="mouse-pointer-click" style="width: 22px; height: 22px; color: var(--cms-fg4); margin-bottom: 8px; display: inline-block;"></i>
                    <div>Click <strong style="color: var(--cms-gold);">⚙</strong> on a section or widget to customize it.</div>
                </div>

                <div id="inspector-panel" style="display: none; margin-top: 12px;">
                    <div style="background: var(--cms-bg); border-radius: var(--cms-r-md); padding: 10px 12px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                        <span id="inspector-title" style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 700; color: var(--cms-fg1);">—</span>
                        <span id="inspector-badge" style="font-size: 10px; font-weight: 700; color: var(--cms-fg3); background: rgba(0,0,0,0.05); padding: 1px 6px; border-radius: 999px; text-transform: uppercase;">—</span>
                    </div>

                    <div id="inspector-fields" style="display: flex; flex-direction: column; gap: 12px; max-height: 50vh; overflow-y: auto; padding-right: 4px;">
                        {{-- Dynamic fields --}}
                    </div>

                    <button type="button" onclick="applyInspector()"
                            style="height: 36px; width: 100%; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 700; background: var(--cms-fg1); color: #fff; border: none; border-radius: var(--cms-r-md); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 14px; transition: background 120ms;"
                            onmouseover="this.style.background='var(--cms-fg2)'" onmouseout="this.style.background='var(--cms-fg1)'">
                        <i data-lucide="check" style="width: 14px; height: 14px;"></i>
                        Apply
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Sticky Save Bar --}}
    <div style="position: sticky; bottom: 0; left: 0; right: 0; z-index: 50; background: rgba(244,241,236,0.92); backdrop-filter: blur(12px); border-top: 1px solid var(--cms-border); padding: 14px 24px; margin: 24px -24px -24px -24px; display: flex; justify-content: flex-end; gap: 10px;">
        <a href="{{ route('admin.pages.index') }}"
           style="display: inline-flex; align-items: center; justify-content: center; height: 40px; padding: 0 20px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; background: var(--cms-surface); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; text-decoration: none;"
           onmouseover="this.style.background='var(--cms-bg)';" onmouseout="this.style.background='var(--cms-surface)';">
            Cancel
        </a>
        <button type="submit" id="save-btn"
                style="display: inline-flex; align-items: center; justify-content: center; gap: 7px; height: 40px; padding: 0 22px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;"
                onmouseover="this.style.background='#D69B00';" onmouseout="this.style.background='var(--cms-gold)';">
            <i data-lucide="save" style="width: 15px; height: 15px;"></i>
            Create Page
        </button>
    </div>
</form>

{{-- SortableJS --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    // ─── STATE ───────────────────────────────────────────────
    let sections = [];       // array of section objects
    let nextId = 1;          // auto-incrementing ID
    let inspectorTarget = null; // { type: 'section'|'widget', sectionId, widgetId? }

    // ─── WIDGET DEFINITIONS ─────────────────────────────────
    const widgetDefs = [
        { type: 'heading',       name: 'Heading',        icon: 'heading',      desc: 'Headline or subheading' },
        { type: 'text',          name: 'Text Block',     icon: 'align-left',   desc: 'Rich text paragraph' },
        { type: 'image',         name: 'Image',          icon: 'image',        desc: 'Photo or graphic' },
        { type: 'cta',           name: 'Call to Action', icon: 'external-link', desc: 'Button with link' },
        { type: 'feature_cards', name: 'Feature Cards',  icon: 'grid',         desc: 'Card grid layout' },
        { type: 'faq',           name: 'FAQ Accordion',  icon: 'help-circle',  desc: 'Question & answer list' },
        { type: 'video',         name: 'Video Embed',    icon: 'play-circle',  desc: 'YouTube or Vimeo' },
        { type: 'alert',         name: 'Alert Box',      icon: 'alert-circle', desc: 'Info, warning, success' },
        { type: 'spacer',        name: 'Spacer',         icon: 'minus',        desc: 'Vertical space divider' },
    ];

    const sectionLayouts = [
        { cols: 1, name: '1 Column',    icon: 'square' },
        { cols: 2, name: '2 Columns',   icon: 'columns' },
        { cols: 3, name: '3 Columns',   icon: 'grid' },
    ];

    const backgroundPresets = [
        { value: 'white',         label: 'White',          color: '#ffffff' },
        { value: 'cream',         label: 'Cream',          color: '#FBF7F0' },
        { value: 'soft-gold',     label: 'Soft Gold',      color: '#F5ECD5' },
        { value: 'soft-green',    label: 'Sage Green',     color: '#F0F7F0' },
        { value: 'gradient-warm', label: 'Warm Gradient',  color: 'linear-gradient(135deg, #FBF7F0, #FCE4BE)' },
        { value: 'dark-charcoal', label: 'Charcoal',       color: '#1A1410' },
        { value: 'dark',          label: 'Dark',           color: '#0F0D0A' },
    ];

    // ─── INIT ─────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        renderWidgetPalette();
        renderSectionPalette();
        renderCanvas();
    });

    // ─── TAB SWITCHING ────────────────────────────────────────
    function switchTab(tab) {
        const infoPanel  = document.getElementById('panel-info');
        const buildPanel = document.getElementById('panel-builder');
        const tabInfo    = document.getElementById('tab-info');
        const tabBuilder = document.getElementById('tab-builder');

        if (tab === 'info') {
            infoPanel.style.display  = 'block';
            buildPanel.style.display = 'none';
            tabInfo.style.borderBottomColor = 'var(--cms-gold)';
            tabInfo.style.color = 'var(--cms-fg1)';
            tabBuilder.style.borderBottomColor = 'transparent';
            tabBuilder.style.color = 'var(--cms-fg3)';
        } else {
            infoPanel.style.display  = 'none';
            buildPanel.style.display = 'block';
            tabBuilder.style.borderBottomColor = 'var(--cms-gold)';
            tabBuilder.style.color = 'var(--cms-fg1)';
            tabInfo.style.borderBottomColor = 'transparent';
            tabInfo.style.color = 'var(--cms-fg3)';
        }
    }

    // ─── PALETTE RENDERING ────────────────────────────────────
    function renderWidgetPalette() {
        const el = document.getElementById('widget-palette');
        el.innerHTML = widgetDefs.map(w => `
            <div onclick="promptAddWidget('${w.type}')" title="${w.desc}"
                 style="background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 9px 10px; cursor: pointer; transition: all 120ms; display: flex; align-items: center; gap: 8px;"
                 onmouseover="this.style.borderColor='var(--cms-gold)'" onmouseout="this.style.borderColor='var(--cms-border)'">
                <i data-lucide="${w.icon}" style="width: 14px; height: 14px; color: var(--cms-gold-deep); flex-shrink: 0;"></i>
                <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; font-weight: 600; color: var(--cms-fg1);">${w.name}</span>
            </div>
        `).join('');
        lucide.createIcons();
    }

    function renderSectionPalette() {
        const el = document.getElementById('section-palette');
        el.innerHTML = sectionLayouts.map(s => `
            <div onclick="addSection(${s.cols})" title="Add ${s.name} section"
                 style="background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 9px 10px; cursor: pointer; transition: all 120ms; display: flex; align-items: center; gap: 8px;"
                 onmouseover="this.style.borderColor='var(--cms-gold)'" onmouseout="this.style.borderColor='var(--cms-border)'">
                <i data-lucide="${s.icon}" style="width: 14px; height: 14px; color: var(--cms-gold-deep); flex-shrink: 0;"></i>
                <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; font-weight: 600; color: var(--cms-fg1);">${s.name}</span>
            </div>
        `).join('');
        lucide.createIcons();
    }

    // ─── ADD SECTION ──────────────────────────────────────────
    function addSection(cols) {
        const columns = [];
        for (let i = 0; i < cols; i++) {
            columns.push({ id: nextId++, widgets: [] });
        }
        sections.push({
            id: nextId++,
            background: 'white',
            padding: 'medium',
            columns: columns,
        });
        renderCanvas();
        showToast(`${cols}-column section added to canvas.`);
    }

    // ─── ADD WIDGET ───────────────────────────────────────────
    function promptAddWidget(widgetType) {
        // If we have no sections, add one first
        if (sections.length === 0) {
            addSection(1);
        }
        // Add to the last section's first column
        const lastSection = sections[sections.length - 1];
        const firstCol = lastSection.columns[0];
        const widget = createWidget(widgetType);
        firstCol.widgets.push(widget);
        renderCanvas();

        const def = widgetDefs.find(w => w.type === widgetType);
        showToast(`"${def?.name || widgetType}" widget added.`);
    }

    function addWidgetToColumn(sectionId, colId, widgetType) {
        const section = sections.find(s => s.id === sectionId);
        if (!section) return;
        const col = section.columns.find(c => c.id === colId);
        if (!col) return;
        col.widgets.push(createWidget(widgetType));
        renderCanvas();
    }

    function createWidget(type) {
        const id = nextId++;
        const defaults = {
            heading:       { text: 'Your Heading Here', level: 'h2', alignment: 'left' },
            text:          { content: '<p>Enter your text content here. You can use HTML.</p>', alignment: 'left' },
            image:         { src: '', alt: 'Image description', caption: '' },
            cta:           { text: 'Get Started', url: '#', style: 'primary', alignment: 'center' },
            feature_cards: { cards: [
                { icon: '✨', title: 'Feature One', description: 'Description of the first feature.' },
                { icon: '🚀', title: 'Feature Two', description: 'Description of the second feature.' },
                { icon: '💎', title: 'Feature Three', description: 'Description of the third feature.' },
            ]},
            faq:           { items: [
                { question: 'What is this?', answer: 'This is a frequently asked question.' },
                { question: 'How does it work?', answer: 'It works like this.' },
            ]},
            video:         { url: '' },
            alert:         { message: 'This is an important notice.', type: 'info' },
            spacer:        { height: 40 },
        };

        return { id, type, settings: JSON.parse(JSON.stringify(defaults[type] || {})) };
    }

    // ─── REMOVE ───────────────────────────────────────────────
    function removeSection(sectionId) {
        sections = sections.filter(s => s.id !== sectionId);
        closeInspector();
        renderCanvas();
    }

    function removeWidget(sectionId, colId, widgetId) {
        const section = sections.find(s => s.id === sectionId);
        if (!section) return;
        const col = section.columns.find(c => c.id === colId);
        if (!col) return;
        col.widgets = col.widgets.filter(w => w.id !== widgetId);
        closeInspector();
        renderCanvas();
    }

    // ─── CANVAS RENDERING ─────────────────────────────────────
    function renderCanvas() {
        const container = document.getElementById('canvas-container');
        container.innerHTML = '';
        document.getElementById('section-count').textContent = sections.length;

        // Update hidden input
        if (sections.length > 0) {
            document.getElementById('layout-input').value = JSON.stringify(sections);
            document.getElementById('traditional-body-field').style.display = 'none';
            document.getElementById('builder-active-notice').style.display = 'block';
            // body not required when builder active
            document.getElementById('body-textarea').removeAttribute('required');
        } else {
            document.getElementById('layout-input').value = '';
            document.getElementById('traditional-body-field').style.display = 'block';
            document.getElementById('builder-active-notice').style.display = 'none';
        }

        if (sections.length === 0) {
            container.innerHTML = `
                <div style="border: 2px dashed var(--cms-border); border-radius: var(--cms-r-lg); padding: 60px 24px; text-align: center; color: var(--cms-fg4); font-family: var(--cms-font-ui), sans-serif; font-size: 13px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <i data-lucide="layers" style="width: 36px; height: 36px; color: var(--cms-fg4); margin-bottom: 10px;"></i>
                    <div style="font-weight: 700; color: var(--cms-fg2); margin-bottom: 4px;">Empty Canvas</div>
                    <div>Use the <strong>Add Section</strong> buttons on the left to start building.</div>
                </div>
            `;
            lucide.createIcons();
            return;
        }

        sections.forEach((section, sIdx) => {
            const sectionEl = document.createElement('div');
            sectionEl.setAttribute('data-section-id', section.id);
            sectionEl.style.cssText = 'background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; transition: border-color 150ms;';
            sectionEl.onmouseover = () => sectionEl.style.borderColor = 'var(--cms-border-st)';
            sectionEl.onmouseout  = () => sectionEl.style.borderColor = 'var(--cms-border)';

            // Section header bar
            const bgPreset = backgroundPresets.find(b => b.value === section.background);
            const bgLabel = bgPreset ? bgPreset.label : section.background;

            sectionEl.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: var(--cms-bg); border-bottom: 1px solid var(--cms-border);">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div class="section-grip" style="cursor: move; color: var(--cms-fg4); padding: 2px;">
                            <i data-lucide="grip-vertical" style="width: 14px; height: 14px;"></i>
                        </div>
                        <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; font-weight: 700; color: var(--cms-fg1);">Section ${sIdx + 1}</span>
                        <span style="font-size: 10.5px; color: var(--cms-fg4); font-family: var(--cms-font-ui), sans-serif;">${section.columns.length} col · ${bgLabel}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 3px;">
                        <button type="button" onclick="inspectSection(${section.id})" title="Section settings" style="width: 26px; height: 26px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-gold-deep); border-radius: 4px;" onmouseover="this.style.background='var(--cms-gold-soft)'" onmouseout="this.style.background='transparent'">
                            <i data-lucide="settings" style="width: 13px; height: 13px;"></i>
                        </button>
                        <button type="button" onclick="removeSection(${section.id})" title="Remove section" style="width: 26px; height: 26px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red); border-radius: 4px;" onmouseover="this.style.background='var(--cms-red-soft)'" onmouseout="this.style.background='transparent'">
                            <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                        </button>
                    </div>
                </div>
            `;

            // Column grid
            const colGrid = document.createElement('div');
            const colCount = section.columns.length;
            colGrid.style.cssText = `display: grid; grid-template-columns: repeat(${colCount}, 1fr); gap: 8px; padding: 12px;`;

            section.columns.forEach(col => {
                const colEl = document.createElement('div');
                colEl.style.cssText = 'min-height: 60px; border: 1.5px dashed var(--cms-border); border-radius: var(--cms-r-md); padding: 8px; position: relative;';

                // Widget drop zone
                const widgetZone = document.createElement('div');
                widgetZone.setAttribute('data-column-id', col.id);
                widgetZone.setAttribute('data-section-id', section.id);
                widgetZone.style.cssText = 'display: flex; flex-direction: column; gap: 6px; min-height: 40px;';

                if (col.widgets.length === 0) {
                    widgetZone.innerHTML = `<div style="text-align: center; padding: 16px 8px; font-family: var(--cms-font-ui), sans-serif; font-size: 11px; color: var(--cms-fg4);">Empty column — add widgets from palette</div>`;
                } else {
                    col.widgets.forEach(widget => {
                        const wDef = widgetDefs.find(d => d.type === widget.type);
                        const wEl = document.createElement('div');
                        wEl.setAttribute('data-widget-id', widget.id);
                        wEl.style.cssText = 'background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: 6px; padding: 8px 10px; display: flex; align-items: center; justify-content: space-between; transition: border-color 120ms; cursor: default;';
                        wEl.onmouseover = () => wEl.style.borderColor = 'var(--cms-gold)';
                        wEl.onmouseout  = () => wEl.style.borderColor = 'var(--cms-border)';

                        let preview = '';
                        if (widget.type === 'heading') preview = widget.settings.text || '';
                        else if (widget.type === 'text') preview = (widget.settings.content || '').replace(/<[^>]*>/g, '').substring(0, 40);
                        else if (widget.type === 'cta') preview = widget.settings.text || '';
                        else if (widget.type === 'image') preview = widget.settings.alt || 'Image';
                        else if (widget.type === 'video') preview = widget.settings.url ? 'Embedded' : 'No URL';
                        else if (widget.type === 'alert') preview = widget.settings.message?.substring(0, 30) || '';
                        else if (widget.type === 'spacer') preview = `${widget.settings.height}px`;
                        else if (widget.type === 'faq') preview = `${(widget.settings.items||[]).length} items`;
                        else if (widget.type === 'feature_cards') preview = `${(widget.settings.cards||[]).length} cards`;

                        wEl.innerHTML = `
                            <div style="display: flex; align-items: center; gap: 7px; min-width: 0; flex: 1;">
                                <div class="widget-grip" style="cursor: move; color: var(--cms-fg4);"><i data-lucide="grip-vertical" style="width: 11px; height: 11px;"></i></div>
                                <i data-lucide="${wDef?.icon || 'box'}" style="width: 13px; height: 13px; color: var(--cms-gold); flex-shrink: 0;"></i>
                                <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 11.5px; font-weight: 600; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${wDef?.name || widget.type}</span>
                                <span style="font-size: 10.5px; color: var(--cms-fg4); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;">${preview}</span>
                            </div>
                            <div style="display: flex; gap: 2px; flex-shrink: 0;">
                                <button type="button" onclick="inspectWidget(${section.id}, ${col.id}, ${widget.id})" title="Settings" style="width: 22px; height: 22px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-gold-deep); border-radius: 4px;">
                                    <i data-lucide="settings" style="width: 11px; height: 11px;"></i>
                                </button>
                                <button type="button" onclick="removeWidget(${section.id}, ${col.id}, ${widget.id})" title="Remove" style="width: 22px; height: 22px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red); border-radius: 4px;">
                                    <i data-lucide="x" style="width: 11px; height: 11px;"></i>
                                </button>
                            </div>
                        `;
                        widgetZone.appendChild(wEl);
                    });
                }

                colEl.appendChild(widgetZone);

                // Add widget button for this column
                const addBtn = document.createElement('div');
                addBtn.style.cssText = 'margin-top: 6px; text-align: center;';
                addBtn.innerHTML = `
                    <div style="position: relative; display: inline-block;">
                        <button type="button" onclick="toggleColumnMenu(this, ${section.id}, ${col.id})" style="font-family: var(--cms-font-ui), sans-serif; font-size: 10.5px; font-weight: 600; color: var(--cms-fg3); border: 1px dashed var(--cms-border); background: transparent; padding: 5px 12px; border-radius: var(--cms-r-md); cursor: pointer; display: inline-flex; align-items: center; gap: 4px;" onmouseover="this.style.borderColor='var(--cms-gold)'; this.style.color='var(--cms-gold)'" onmouseout="this.style.borderColor='var(--cms-border)'; this.style.color='var(--cms-fg3)'">
                            <i data-lucide="plus" style="width: 11px; height: 11px;"></i> Add Widget
                        </button>
                    </div>
                `;
                colEl.appendChild(addBtn);

                colGrid.appendChild(colEl);
            });

            sectionEl.appendChild(colGrid);
            container.appendChild(sectionEl);

            // Init sortable for widgets in each column
            section.columns.forEach(col => {
                const zone = container.querySelector(`[data-column-id="${col.id}"][data-section-id="${section.id}"]`);
                if (zone) {
                    Sortable.create(zone, {
                        animation: 150,
                        handle: '.widget-grip',
                        group: 'widgets',
                        ghostClass: 'pb-sortable-ghost',
                        onEnd: () => syncWidgetOrder(),
                    });
                }
            });
        });

        // Init section-level sortable
        Sortable.create(container, {
            animation: 180,
            handle: '.section-grip',
            ghostClass: 'pb-sortable-ghost',
            onEnd: () => {
                const newOrder = [];
                container.querySelectorAll('[data-section-id]').forEach(el => {
                    const id = parseInt(el.getAttribute('data-section-id'));
                    const s = sections.find(sec => sec.id === id);
                    if (s && !newOrder.find(x => x.id === s.id)) newOrder.push(s);
                });
                sections = newOrder;
                renderCanvas();
            },
        });

        lucide.createIcons();
    }

    function syncWidgetOrder() {
        // Re-read widget order from DOM
        sections.forEach(section => {
            section.columns.forEach(col => {
                const zone = document.querySelector(`[data-column-id="${col.id}"][data-section-id="${section.id}"]`);
                if (!zone) return;
                const newWidgets = [];
                zone.querySelectorAll('[data-widget-id]').forEach(wEl => {
                    const wId = parseInt(wEl.getAttribute('data-widget-id'));
                    // Search across all sections/columns for this widget
                    let found = null;
                    sections.forEach(s => s.columns.forEach(c => {
                        const w = c.widgets.find(w => w.id === wId);
                        if (w) found = w;
                    }));
                    if (found) newWidgets.push(found);
                });
                col.widgets = newWidgets;
            });
        });
        // Update hidden input
        document.getElementById('layout-input').value = JSON.stringify(sections);
    }

    // ─── COLUMN WIDGET MENU ────────────────────────────────────
    function toggleColumnMenu(btn, sectionId, colId) {
        // Remove any existing menu
        document.querySelectorAll('.pb-widget-menu').forEach(m => m.remove());

        const menu = document.createElement('div');
        menu.className = 'pb-widget-menu';
        menu.style.cssText = 'position: absolute; top: 100%; left: 50%; transform: translateX(-50%); z-index: 100; background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-md); box-shadow: var(--cms-sh-pop); padding: 6px; min-width: 160px; margin-top: 4px; animation: dsPop 120ms ease;';

        menu.innerHTML = widgetDefs.map(w => `
            <div onclick="addWidgetToColumn(${sectionId}, ${colId}, '${w.type}'); document.querySelectorAll('.pb-widget-menu').forEach(m=>m.remove());"
                 style="display: flex; align-items: center; gap: 8px; padding: 7px 10px; border-radius: 4px; cursor: pointer; font-family: var(--cms-font-ui), sans-serif; font-size: 12px; color: var(--cms-fg1);"
                 onmouseover="this.style.background='var(--cms-bg)'" onmouseout="this.style.background='transparent'">
                <i data-lucide="${w.icon}" style="width: 13px; height: 13px; color: var(--cms-gold);"></i>
                ${w.name}
            </div>
        `).join('');

        btn.parentElement.appendChild(menu);
        lucide.createIcons();

        // Close on outside click
        setTimeout(() => {
            document.addEventListener('click', function handler(e) {
                if (!menu.contains(e.target) && e.target !== btn) {
                    menu.remove();
                    document.removeEventListener('click', handler);
                }
            });
        }, 10);
    }

    // ─── INSPECTOR ────────────────────────────────────────────
    function inspectSection(sectionId) {
        const section = sections.find(s => s.id === sectionId);
        if (!section) return;

        inspectorTarget = { type: 'section', sectionId };
        showInspector('Section Settings', 'section');

        const fields = document.getElementById('inspector-fields');

        // Background picker
        let bgOptions = backgroundPresets.map(b =>
            `<option value="${b.value}" ${section.background === b.value ? 'selected' : ''}>${b.label}</option>`
        ).join('');

        // Padding
        let padOptions = ['small', 'medium', 'large'].map(p =>
            `<option value="${p}" ${section.padding === p ? 'selected' : ''}>${p.charAt(0).toUpperCase() + p.slice(1)}</option>`
        ).join('');

        fields.innerHTML = `
            <div>
                <label class="insp-lbl">Background Theme</label>
                <select id="insp-bg" class="insp-sl">${bgOptions}</select>
            </div>
            <div>
                <label class="insp-lbl">Vertical Padding</label>
                <select id="insp-pad" class="insp-sl">${padOptions}</select>
            </div>
        `;
    }

    function inspectWidget(sectionId, colId, widgetId) {
        let widget = null;
        const section = sections.find(s => s.id === sectionId);
        if (section) {
            const col = section.columns.find(c => c.id === colId);
            if (col) widget = col.widgets.find(w => w.id === widgetId);
        }
        if (!widget) return;

        inspectorTarget = { type: 'widget', sectionId, colId, widgetId };
        const def = widgetDefs.find(d => d.type === widget.type);
        showInspector(def?.name || widget.type, widget.type);

        const fields = document.getElementById('inspector-fields');
        const s = widget.settings;

        if (widget.type === 'heading') {
            fields.innerHTML = `
                <div><label class="insp-lbl">Heading Text</label><input type="text" id="insp-text" value="${escHtml(s.text||'')}" class="insp-in"></div>
                <div><label class="insp-lbl">Level</label><select id="insp-level" class="insp-sl">
                    ${['h1','h2','h3','h4','h5','h6'].map(h => `<option value="${h}" ${s.level===h?'selected':''}>${h.toUpperCase()}</option>`).join('')}
                </select></div>
                <div><label class="insp-lbl">Alignment</label><select id="insp-align" class="insp-sl">
                    ${['left','center','right'].map(a => `<option value="${a}" ${s.alignment===a?'selected':''}>${a.charAt(0).toUpperCase()+a.slice(1)}</option>`).join('')}
                </select></div>
            `;
        } else if (widget.type === 'text') {
            fields.innerHTML = `
                <div><label class="insp-lbl">Content (HTML)</label><textarea id="insp-content" class="insp-ta" style="min-height: 120px;">${escHtml(s.content||'')}</textarea></div>
                <div><label class="insp-lbl">Alignment</label><select id="insp-align" class="insp-sl">
                    ${['left','center','right'].map(a => `<option value="${a}" ${s.alignment===a?'selected':''}>${a.charAt(0).toUpperCase()+a.slice(1)}</option>`).join('')}
                </select></div>
            `;
        } else if (widget.type === 'image') {
            fields.innerHTML = `
                <div><label class="insp-lbl">Image URL</label><input type="text" id="insp-src" value="${escHtml(s.src||'')}" class="insp-in" placeholder="/storage/media/..."></div>
                <div><label class="insp-lbl">Alt Text</label><input type="text" id="insp-alt" value="${escHtml(s.alt||'')}" class="insp-in"></div>
                <div><label class="insp-lbl">Caption</label><input type="text" id="insp-caption" value="${escHtml(s.caption||'')}" class="insp-in"></div>
            `;
        } else if (widget.type === 'cta') {
            fields.innerHTML = `
                <div><label class="insp-lbl">Button Text</label><input type="text" id="insp-text" value="${escHtml(s.text||'')}" class="insp-in"></div>
                <div><label class="insp-lbl">URL Link</label><input type="text" id="insp-url" value="${escHtml(s.url||'')}" class="insp-in"></div>
                <div><label class="insp-lbl">Button Style</label><select id="insp-style" class="insp-sl">
                    ${['primary','secondary','dark'].map(v => `<option value="${v}" ${s.style===v?'selected':''}>${v.charAt(0).toUpperCase()+v.slice(1)}</option>`).join('')}
                </select></div>
                <div><label class="insp-lbl">Alignment</label><select id="insp-align" class="insp-sl">
                    ${['left','center','right'].map(a => `<option value="${a}" ${s.alignment===a?'selected':''}>${a.charAt(0).toUpperCase()+a.slice(1)}</option>`).join('')}
                </select></div>
            `;
        } else if (widget.type === 'video') {
            fields.innerHTML = `
                <div><label class="insp-lbl">Video URL (YouTube/Vimeo)</label><input type="text" id="insp-url" value="${escHtml(s.url||'')}" class="insp-in" placeholder="https://youtube.com/watch?v=..."></div>
            `;
        } else if (widget.type === 'alert') {
            fields.innerHTML = `
                <div><label class="insp-lbl">Message</label><textarea id="insp-msg" class="insp-ta">${escHtml(s.message||'')}</textarea></div>
                <div><label class="insp-lbl">Alert Type</label><select id="insp-type" class="insp-sl">
                    ${['info','warning','success','danger'].map(t => `<option value="${t}" ${s.type===t?'selected':''}>${t.charAt(0).toUpperCase()+t.slice(1)}</option>`).join('')}
                </select></div>
            `;
        } else if (widget.type === 'spacer') {
            fields.innerHTML = `
                <div><label class="insp-lbl">Height (px)</label><input type="number" id="insp-height" value="${s.height||40}" class="insp-in" min="10" max="200"></div>
            `;
        } else if (widget.type === 'faq') {
            let faqHtml = '<div><label class="insp-lbl">FAQ Items</label></div>';
            (s.items || []).forEach((item, i) => {
                faqHtml += `
                    <div style="background: var(--cms-bg); padding: 10px; border-radius: 6px; margin-bottom: 4px;">
                        <input type="text" class="insp-in faq-q" data-idx="${i}" value="${escHtml(item.question)}" placeholder="Question" style="margin-bottom: 6px;">
                        <textarea class="insp-ta faq-a" data-idx="${i}" placeholder="Answer">${escHtml(item.answer)}</textarea>
                        <button type="button" onclick="removeFaqItem(${i})" style="font-size: 11px; color: var(--cms-red); background: none; border: none; cursor: pointer; margin-top: 4px;">Remove</button>
                    </div>
                `;
            });
            faqHtml += `<button type="button" onclick="addFaqItem()" style="font-family: var(--cms-font-ui), sans-serif; font-size: 11.5px; font-weight: 600; color: var(--cms-gold-deep); background: none; border: 1px dashed var(--cms-border); padding: 6px 12px; border-radius: var(--cms-r-md); cursor: pointer; width: 100%;">+ Add FAQ Item</button>`;
            fields.innerHTML = faqHtml;
        } else if (widget.type === 'feature_cards') {
            let cardsHtml = '<div><label class="insp-lbl">Feature Cards</label></div>';
            (s.cards || []).forEach((card, i) => {
                cardsHtml += `
                    <div style="background: var(--cms-bg); padding: 10px; border-radius: 6px; margin-bottom: 4px;">
                        <div style="display: flex; gap: 6px; margin-bottom: 6px;">
                            <input type="text" class="insp-in card-icon" data-idx="${i}" value="${escHtml(card.icon)}" placeholder="Icon/Emoji" style="width: 50px; flex-shrink: 0;">
                            <input type="text" class="insp-in card-title" data-idx="${i}" value="${escHtml(card.title)}" placeholder="Card Title">
                        </div>
                        <textarea class="insp-ta card-desc" data-idx="${i}" placeholder="Description">${escHtml(card.description)}</textarea>
                        <button type="button" onclick="removeCard(${i})" style="font-size: 11px; color: var(--cms-red); background: none; border: none; cursor: pointer; margin-top: 4px;">Remove</button>
                    </div>
                `;
            });
            cardsHtml += `<button type="button" onclick="addCard()" style="font-family: var(--cms-font-ui), sans-serif; font-size: 11.5px; font-weight: 600; color: var(--cms-gold-deep); background: none; border: 1px dashed var(--cms-border); padding: 6px 12px; border-radius: var(--cms-r-md); cursor: pointer; width: 100%;">+ Add Card</button>`;
            fields.innerHTML = cardsHtml;
        }
    }

    function showInspector(title, badge) {
        document.getElementById('inspector-placeholder').style.display = 'none';
        document.getElementById('inspector-panel').style.display = 'block';
        document.getElementById('inspector-title').textContent = title;
        document.getElementById('inspector-badge').textContent = badge;
    }

    function closeInspector() {
        document.getElementById('inspector-placeholder').style.display = 'block';
        document.getElementById('inspector-panel').style.display = 'none';
        inspectorTarget = null;
    }

    function applyInspector() {
        if (!inspectorTarget) return;

        if (inspectorTarget.type === 'section') {
            const section = sections.find(s => s.id === inspectorTarget.sectionId);
            if (section) {
                section.background = document.getElementById('insp-bg').value;
                section.padding = document.getElementById('insp-pad').value;
            }
        } else if (inspectorTarget.type === 'widget') {
            const section = sections.find(s => s.id === inspectorTarget.sectionId);
            if (!section) return;
            const col = section.columns.find(c => c.id === inspectorTarget.colId);
            if (!col) return;
            const widget = col.widgets.find(w => w.id === inspectorTarget.widgetId);
            if (!widget) return;

            const s = widget.settings;
            const t = widget.type;

            if (t === 'heading') {
                s.text = el('insp-text')?.value?.trim() || '';
                s.level = el('insp-level')?.value || 'h2';
                s.alignment = el('insp-align')?.value || 'left';
            } else if (t === 'text') {
                s.content = el('insp-content')?.value || '';
                s.alignment = el('insp-align')?.value || 'left';
            } else if (t === 'image') {
                s.src = el('insp-src')?.value?.trim() || '';
                s.alt = el('insp-alt')?.value?.trim() || '';
                s.caption = el('insp-caption')?.value?.trim() || '';
            } else if (t === 'cta') {
                s.text = el('insp-text')?.value?.trim() || '';
                s.url = el('insp-url')?.value?.trim() || '#';
                s.style = el('insp-style')?.value || 'primary';
                s.alignment = el('insp-align')?.value || 'center';
            } else if (t === 'video') {
                s.url = el('insp-url')?.value?.trim() || '';
            } else if (t === 'alert') {
                s.message = el('insp-msg')?.value?.trim() || '';
                s.type = el('insp-type')?.value || 'info';
            } else if (t === 'spacer') {
                s.height = parseInt(el('insp-height')?.value) || 40;
            } else if (t === 'faq') {
                const items = [];
                document.querySelectorAll('.faq-q').forEach(qEl => {
                    const idx = parseInt(qEl.dataset.idx);
                    const aEl = document.querySelector(`.faq-a[data-idx="${idx}"]`);
                    items.push({ question: qEl.value.trim(), answer: aEl?.value?.trim() || '' });
                });
                s.items = items;
            } else if (t === 'feature_cards') {
                const cards = [];
                document.querySelectorAll('.card-icon').forEach(iconEl => {
                    const idx = parseInt(iconEl.dataset.idx);
                    const titleEl = document.querySelector(`.card-title[data-idx="${idx}"]`);
                    const descEl = document.querySelector(`.card-desc[data-idx="${idx}"]`);
                    cards.push({
                        icon: iconEl.value.trim(),
                        title: titleEl?.value?.trim() || '',
                        description: descEl?.value?.trim() || '',
                    });
                });
                s.cards = cards;
            }
        }

        renderCanvas();
        closeInspector();
        showToast('Settings applied.');
    }

    // ─── FAQ / CARDS HELPERS ──────────────────────────────────
    function addFaqItem() {
        if (!inspectorTarget || inspectorTarget.type !== 'widget') return;
        const section = sections.find(s => s.id === inspectorTarget.sectionId);
        const col = section?.columns.find(c => c.id === inspectorTarget.colId);
        const widget = col?.widgets.find(w => w.id === inspectorTarget.widgetId);
        if (widget && widget.type === 'faq') {
            widget.settings.items.push({ question: '', answer: '' });
            inspectWidget(inspectorTarget.sectionId, inspectorTarget.colId, inspectorTarget.widgetId);
        }
    }
    function removeFaqItem(idx) {
        if (!inspectorTarget || inspectorTarget.type !== 'widget') return;
        const section = sections.find(s => s.id === inspectorTarget.sectionId);
        const col = section?.columns.find(c => c.id === inspectorTarget.colId);
        const widget = col?.widgets.find(w => w.id === inspectorTarget.widgetId);
        if (widget && widget.type === 'faq') {
            widget.settings.items.splice(idx, 1);
            inspectWidget(inspectorTarget.sectionId, inspectorTarget.colId, inspectorTarget.widgetId);
        }
    }
    function addCard() {
        if (!inspectorTarget || inspectorTarget.type !== 'widget') return;
        const section = sections.find(s => s.id === inspectorTarget.sectionId);
        const col = section?.columns.find(c => c.id === inspectorTarget.colId);
        const widget = col?.widgets.find(w => w.id === inspectorTarget.widgetId);
        if (widget && widget.type === 'feature_cards') {
            widget.settings.cards.push({ icon: '⭐', title: '', description: '' });
            inspectWidget(inspectorTarget.sectionId, inspectorTarget.colId, inspectorTarget.widgetId);
        }
    }
    function removeCard(idx) {
        if (!inspectorTarget || inspectorTarget.type !== 'widget') return;
        const section = sections.find(s => s.id === inspectorTarget.sectionId);
        const col = section?.columns.find(c => c.id === inspectorTarget.colId);
        const widget = col?.widgets.find(w => w.id === inspectorTarget.widgetId);
        if (widget && widget.type === 'feature_cards') {
            widget.settings.cards.splice(idx, 1);
            inspectWidget(inspectorTarget.sectionId, inspectorTarget.colId, inspectorTarget.widgetId);
        }
    }

    // ─── UTILITIES ────────────────────────────────────────────
    function el(id) { return document.getElementById(id); }

    function escHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Handle form submit: serialize layout before POST
    document.getElementById('page-form').addEventListener('submit', function(e) {
        if (sections.length > 0) {
            document.getElementById('layout-input').value = JSON.stringify(sections);
            // Clear body textarea so validation passes with layout
            document.getElementById('body-textarea').value = '';
        }
    });

    // Toast
    function showToast(message) {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.style.cssText = "background: #17120D; border: 1.5px solid var(--cms-gold); border-radius: var(--cms-r-md); padding: 12px 20px; color: #fff; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; box-shadow: var(--cms-sh-pop); animation: dsPop 180ms ease; min-width: 250px;";
        toast.innerHTML = `<i data-lucide="check-circle" style="width: 15px; height: 15px; color: var(--cms-gold); flex-shrink: 0;"></i> <span>${message}</span>`;
        container.appendChild(toast);
        lucide.createIcons();
        setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity 200ms'; setTimeout(() => toast.remove(), 200); }, 2500);
    }
</script>

<style>
    .pb-sortable-ghost { opacity: 0.35; background: var(--cms-gold-soft) !important; border: 2px dashed var(--cms-gold) !important; }
    .insp-lbl { font-family: var(--cms-font-ui), sans-serif; font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 5px; }
    .insp-in { display: block; width: 100%; height: 36px; padding: 0 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; box-sizing: border-box; }
    .insp-in:focus, .insp-ta:focus, .insp-sl:focus { border-color: var(--cms-gold); }
    .insp-ta { display: block; width: 100%; min-height: 60px; padding: 8px 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; resize: vertical; box-sizing: border-box; }
    .insp-sl { display: block; width: 100%; height: 36px; padding: 0 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none; box-sizing: border-box; }
</style>

@endsection
