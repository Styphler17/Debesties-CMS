@extends('admin.layouts.app')

@section('title', 'New Post — Debesties Studio')
@section('page_title', 'New Post')

@section('content')

<form id="post-form" method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
@csrf

<div class="cms-editor-cols" style="display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start;">

    {{-- ══════════════════════ MAIN EDITOR ══════════════════════ --}}
    <div style="display: flex; flex-direction: column; gap: 16px;">

        {{-- Title --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 20px 22px; box-shadow: var(--cms-sh-card);">
            <input id="post-title" name="title" type="text"
                   placeholder="Enter post title…"
                   style="display: block; width: 100%; border: none; outline: none; font-family: var(--cms-font-disp), serif; font-size: 28px; font-weight: 700; color: var(--cms-fg1); background: transparent; letter-spacing: -0.015em; line-height: 1.2;"
                   oninput="generateSlug(this.value)" />
            <input id="post-subtitle" name="subtitle" type="text"
                   placeholder="Subtitle (optional)…"
                   style="display: block; width: 100%; border: none; outline: none; font-family: var(--cms-font-ui), sans-serif; font-size: 16px; font-weight: 400; color: var(--cms-fg3); background: transparent; margin-top: 6px;" />
            {{-- Slug row --}}
            <div style="display: flex; align-items: center; gap: 8px; margin-top: 10px; padding-top: 10px; border-top: 1px solid var(--cms-border);">
                <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; color: var(--cms-fg4);">debesties.com/</span>
                <input id="post-slug" name="slug" type="text"
                       style="font-family: var(--cms-font-mono), monospace; font-size: 12.5px; color: var(--cms-fg2); background: transparent; border: none; outline: none; flex: 1; padding: 2px 0;"
                       placeholder="post-slug-will-appear-here" />
                <button type="button" onclick="editSlug()" style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; color: var(--cms-gold); background: none; border: none; cursor: pointer; font-weight: 600;">Edit</button>
            </div>
        </div>

        {{-- Excerpt --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="padding: 12px 20px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; justify-content: space-between;">
                <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1);">Excerpt</span>
                <span id="excerpt-count" style="font-family: var(--cms-font-mono), monospace; font-size: 11.5px; color: var(--cms-fg4);">0 / 160</span>
            </div>
            <textarea id="post-excerpt" name="excerpt" rows="3" maxlength="160"
                      placeholder="Write a concise summary (shown in search results and social cards)…"
                      oninput="document.getElementById('excerpt-count').textContent = this.value.length + ' / 160'"
                      style="display: block; width: 100%; padding: 14px 20px; border: none; outline: none; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: transparent; resize: vertical; line-height: 1.6;"></textarea>
        </div>

        {{-- Body Editor --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 16px; border-bottom: 1px solid var(--cms-border); gap: 8px; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 2px; flex-wrap: wrap;">
                    @php
                        $toolbar = [
                            ['cmd'=>'bold',          'icon'=>'bold',          'tip'=>'Bold'],
                            ['cmd'=>'italic',        'icon'=>'italic',        'tip'=>'Italic'],
                            ['cmd'=>'underline',     'icon'=>'underline',     'tip'=>'Underline'],
                            ['sep'=>true],
                            ['cmd'=>'h2',            'icon'=>'heading-2',     'tip'=>'Heading 2'],
                            ['cmd'=>'h3',            'icon'=>'heading-3',     'tip'=>'Heading 3'],
                            ['sep'=>true],
                            ['cmd'=>'link',          'icon'=>'link',          'tip'=>'Insert link'],
                            ['cmd'=>'image',         'icon'=>'image',         'tip'=>'Insert image'],
                            ['cmd'=>'blockquote',    'icon'=>'quote',         'tip'=>'Blockquote'],
                            ['sep'=>true],
                            ['cmd'=>'ul',            'icon'=>'list',          'tip'=>'Bullet list'],
                            ['cmd'=>'ol',            'icon'=>'list-ordered',  'tip'=>'Numbered list'],
                            ['sep'=>true],
                            ['cmd'=>'undo',          'icon'=>'undo-2',        'tip'=>'Undo'],
                            ['cmd'=>'redo',          'icon'=>'redo-2',        'tip'=>'Redo'],
                        ];
                    @endphp
                    @foreach($toolbar as $btn)
                        @if(isset($btn['sep']))
                            <div style="width: 1px; height: 20px; background: var(--cms-border); margin: 0 4px;"></div>
                        @else
                            <button type="button" title="{{ $btn['tip'] }}"
                                    onclick="editorCommand('{{ $btn['cmd'] }}')"
                                    style="width: 32px; height: 32px; border-radius: 6px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg2);"
                                    onmouseover="this.style.background='var(--cms-border)'; this.style.color='var(--cms-fg1)'"
                                    onmouseout="this.style.background='transparent'; this.style.color='var(--cms-fg2)'">
                                <i data-lucide="{{ $btn['icon'] }}" style="width: 16px; height: 16px; stroke-width: 2;"></i>
                            </button>
                        @endif
                    @endforeach
                </div>
                {{-- Word count --}}
                <div style="font-family: var(--cms-font-mono), monospace; font-size: 11.5px; color: var(--cms-fg4);">
                    <span id="word-count">0</span> words
                </div>
            </div>

            {{-- Editable content area --}}
            <div id="post-body" contenteditable="true"
                 style="min-height: 380px; padding: 20px 24px; font-family: var(--cms-font-ui), sans-serif; font-size: 15px; line-height: 1.75; color: var(--cms-fg1); outline: none;"
                 oninput="updateWordCount()"
                 data-placeholder="Start writing your article here… Use the toolbar above for formatting.">
            </div>
            {{-- Hidden textarea to capture body for form submit --}}
            <textarea name="body" id="post-body-hidden" style="display: none;"></textarea>
        </div>

        {{-- SEO Panel --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <button type="button" onclick="toggleSection('seo-panel')"
                    style="width: 100%; padding: 14px 20px; border: none; background: none; cursor: pointer; display: flex; align-items: center; justify-content: space-between; font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1);">
                <span style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="search" style="width: 16px; height: 16px; color: var(--cms-blue);"></i>
                    SEO & Meta
                </span>
                <i data-lucide="chevron-down" id="seo-panel-arrow" style="width: 16px; height: 16px; color: var(--cms-fg4); transition: transform 200ms;"></i>
            </button>
            <div id="seo-panel" style="border-top: 1px solid var(--cms-border); padding: 18px 20px; display: flex; flex-direction: column; gap: 14px;">
                <div>
                    <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.03em; text-transform: uppercase; display: block; margin-bottom: 6px;">Meta Title</label>
                    <div style="position: relative;">
                        <input name="meta_title" type="text" id="meta-title" placeholder="Defaults to post title if empty"
                               style="display: block; width: 100%; height: 40px; padding: 0 12px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;"
                               onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                               onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'"
                               oninput="document.getElementById('seo-title-count').textContent = this.value.length" />
                        <span id="seo-title-count" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); font-family: var(--cms-font-mono), monospace; font-size: 11px; color: var(--cms-fg4);">0</span>
                    </div>
                </div>
                <div>
                    <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.03em; text-transform: uppercase; display: block; margin-bottom: 6px;">Meta Description</label>
                    <textarea name="meta_description" rows="3" placeholder="Recommended: 120–160 characters"
                              style="display: block; width: 100%; padding: 10px 12px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; resize: vertical; line-height: 1.6;"
                              onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                              onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'"></textarea>
                </div>
                {{-- SERP Preview --}}
                <div style="background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 14px 16px;">
                    <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 11px; font-weight: 700; color: var(--cms-fg4); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 8px;">Google Preview</div>
                    <div style="font-family: Arial, sans-serif; font-size: 20px; color: #1a0dab; line-height: 1.25; margin-bottom: 2px;" id="serp-title">Your post title will appear here</div>
                    <div style="font-family: Arial, sans-serif; font-size: 13px; color: #006621; margin-bottom: 4px;">debesties.com › <span id="serp-slug">post-slug</span></div>
                    <div style="font-family: Arial, sans-serif; font-size: 13.5px; color: #545454; line-height: 1.5;" id="serp-desc">Your meta description will appear here. Write a compelling summary to improve click-through rate.</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════ SIDEBAR RAIL ══════════════════════ --}}
    <div class="cms-editor-rail" style="display: flex; flex-direction: column; gap: 14px; position: sticky; top: 88px;">

        {{-- Publish Panel --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="padding: 13px 16px; border-bottom: 1px solid var(--cms-border); font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1); display: flex; align-items: center; gap: 7px;">
                <i data-lucide="send" style="width: 15px; height: 15px; color: var(--cms-fg3);"></i> Publish
            </div>
            <div style="padding: 14px 16px; display: flex; flex-direction: column; gap: 11px;">

                {{-- Status --}}
                <div>
                    <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 5px;">Status</label>
                    <select name="status" id="post-status" style="width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;" onchange="updateStatusIndicator(this.value)">
                        <option value="draft">Draft</option>
                        <option value="review">Submit for Review</option>
                        <option value="approved">Approved</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>

                {{-- Scheduled Date (hidden by default) --}}
                <div id="schedule-row" style="display: none;">
                    <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 5px;">Schedule For</label>
                    <input type="datetime-local" name="scheduled_for"
                           style="width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;" />
                </div>

                {{-- Visibility --}}
                <div>
                    <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 5px;">Visibility</label>
                    <select name="visibility" style="width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
                        <option value="public">Public</option>
                        <option value="members">Members Only</option>
                        <option value="private">Private</option>
                    </select>
                </div>

                {{-- Author --}}
                <div>
                    <label style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 5px;">Author</label>
                    <select name="author_id" style="width: 100%; height: 38px; padding: 0 10px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
                        @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="border-top: 1px solid var(--cms-border); padding-top: 12px; display: flex; flex-direction: column; gap: 8px;">
                    {{-- Save Draft --}}
                    <button type="submit" name="action" value="draft"
                            style="width: 100%; height: 38px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; background: var(--cms-bg); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">
                        Save Draft
                    </button>
                    {{-- Publish --}}
                    <button type="submit" name="action" value="publish"
                            onclick="syncBody()"
                            style="width: 100%; height: 40px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 7px;"
                            onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                        <i data-lucide="send" style="width: 15px; height: 15px; stroke-width: 2.2;"></i>
                        Publish Now
                    </button>
                </div>
            </div>
        </div>

        {{-- Featured Image --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="padding: 13px 16px; border-bottom: 1px solid var(--cms-border); font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1); display: flex; align-items: center; gap: 7px;">
                <i data-lucide="image" style="width: 15px; height: 15px; color: var(--cms-fg3);"></i> Featured Image
            </div>
            <div style="padding: 14px 16px;">
                <div id="featured-drop"
                     onclick="document.getElementById('featured-file').click()"
                     style="border: 2px dashed var(--cms-border); border-radius: var(--cms-r-md); padding: 24px 12px; text-align: center; cursor: pointer; transition: border-color 150ms, background 150ms;"
                     ondragover="event.preventDefault(); this.style.borderColor='var(--cms-gold)'; this.style.background='var(--cms-gold-soft)'"
                     ondragleave="this.style.borderColor='var(--cms-border)'; this.style.background='transparent'"
                     ondrop="handleImageDrop(event)"
                     onmouseover="this.style.borderColor='var(--cms-gold)'; this.style.background='#FFFBF0'"
                     onmouseout="this.style.borderColor='var(--cms-border)'; this.style.background='transparent'">
                    <div id="featured-placeholder">
                        <i data-lucide="upload-cloud" style="width: 28px; height: 28px; color: var(--cms-fg4); margin: 0 auto 8px;"></i>
                        <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; color: var(--cms-fg3);">Click or drag to upload</div>
                        <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 11.5px; color: var(--cms-fg4); margin-top: 3px;">JPG, PNG, WEBP · Max 5MB</div>
                    </div>
                    <img id="featured-preview" src="" alt="Preview" style="display: none; width: 100%; border-radius: 7px; margin-top: 6px;" />
                </div>
                <input type="file" id="featured-file" name="featured_image" accept="image/*" style="display: none;" onchange="previewFeatured(event)" />
                <button type="button" id="featured-remove" onclick="removeFeatured()" style="display: none; margin-top: 8px; width: 100%; height: 34px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 600; color: var(--cms-red); background: var(--cms-red-soft); border: none; border-radius: var(--cms-r-md); cursor: pointer;">Remove Image</button>
            </div>
        </div>

        {{-- Category --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="padding: 13px 16px; border-bottom: 1px solid var(--cms-border); font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1); display: flex; align-items: center; gap: 7px;">
                <i data-lucide="folder" style="width: 15px; height: 15px; color: var(--cms-fg3);"></i> Category
            </div>
            <div style="padding: 14px 16px; display: flex; flex-direction: column; gap: 6px; max-height: 200px; overflow-y: auto;">
                @foreach($categories as $cat)
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg2);">
                        <input type="radio" name="category_id" value="{{ $cat->id }}" style="accent-color: var(--cms-gold); width: 15px; height: 15px; cursor: pointer;" />
                        {{ $cat->name }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Tags --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="padding: 13px 16px; border-bottom: 1px solid var(--cms-border); font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1); display: flex; align-items: center; gap: 7px;">
                <i data-lucide="tag" style="width: 15px; height: 15px; color: var(--cms-fg3);"></i> Tags
            </div>
            <div style="display: flex; flex-direction: column; gap: 6px; max-height: 200px; overflow-y: auto; padding: 14px 16px;">
                @foreach($tags as $tag)
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg2);">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                               style="accent-color: var(--cms-gold); width: 15px; height: 15px; cursor: pointer;" />
                        {{ $tag->name }}
                    </label>
                @endforeach
            </div>
        </div>

    </div>

</div>
</form>

{{-- Editor Placeholder CSS --}}
<style>
    #post-body:empty::before {
        content: attr(data-placeholder);
        color: var(--cms-fg4);
        pointer-events: none;
        font-style: italic;
    }
    #post-body:focus { outline: none; }
    #post-body h2 { font-family: var(--cms-font-disp), serif; font-size: 22px; font-weight: 700; color: var(--cms-fg1); margin: 18px 0 8px; }
    #post-body h3 { font-family: var(--cms-font-disp), serif; font-size: 18px; font-weight: 600; color: var(--cms-fg1); margin: 14px 0 6px; }
    #post-body blockquote { border-left: 3px solid var(--cms-gold); margin: 12px 0; padding: 8px 16px; background: var(--cms-gold-soft); border-radius: 0 6px 6px 0; color: var(--cms-fg2); font-style: italic; }
    #post-body a { color: var(--cms-blue); }
    #post-body ul, #post-body ol { padding-left: 20px; margin: 8px 0; }
    #post-body li { margin-bottom: 4px; }
</style>

<script>
    // ── Slug generation ──────────────────────────────────────
    function generateSlug(title) {
        const slug = title.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .substring(0, 80);
        document.getElementById('post-slug').value = slug;
        document.getElementById('serp-slug').textContent = slug || 'post-slug';
        document.getElementById('serp-title').textContent = document.getElementById('meta-title').value || title || 'Your post title will appear here';
    }
    function editSlug() {
        const slugInput = document.getElementById('post-slug');
        slugInput.focus();
        slugInput.select();
    }

    // ── SEO SERP preview ─────────────────────────────────────
    document.getElementById('meta-title')?.addEventListener('input', function() {
        document.getElementById('serp-title').textContent = this.value || document.getElementById('post-title').value || 'Your post title will appear here';
    });
    document.querySelector('[name="meta_description"]')?.addEventListener('input', function() {
        document.getElementById('serp-desc').textContent = this.value || 'Your meta description will appear here.';
    });

    // ── SEO Panel toggle ─────────────────────────────────────
    function toggleSection(id) {
        const panel = document.getElementById(id);
        const arrow = document.getElementById(id + '-arrow');
        const isOpen = panel.style.display !== 'none';
        panel.style.display = isOpen ? 'none' : 'flex';
        if (arrow) arrow.style.transform = isOpen ? 'rotate(-90deg)' : 'rotate(0deg)';
    }

    // ── Word count ───────────────────────────────────────────
    function updateWordCount() {
        const text = document.getElementById('post-body').innerText;
        const words = text.trim().split(/\s+/).filter(w => w.length > 0).length;
        document.getElementById('word-count').textContent = words;
    }

    // ── Content editable toolbar ─────────────────────────────
    function editorCommand(cmd) {
        document.getElementById('post-body').focus();
        switch(cmd) {
            case 'bold':        document.execCommand('bold'); break;
            case 'italic':      document.execCommand('italic'); break;
            case 'underline':   document.execCommand('underline'); break;
            case 'h2':          document.execCommand('formatBlock', false, 'H2'); break;
            case 'h3':          document.execCommand('formatBlock', false, 'H3'); break;
            case 'blockquote':  document.execCommand('formatBlock', false, 'BLOCKQUOTE'); break;
            case 'ul':          document.execCommand('insertUnorderedList'); break;
            case 'ol':          document.execCommand('insertOrderedList'); break;
            case 'link': {
                const url = prompt('Enter URL:');
                if (url) document.execCommand('createLink', false, url);
                break;
            }
            case 'image': {
                const url = prompt('Enter image URL:');
                if (url) document.execCommand('insertImage', false, url);
                break;
            }
            case 'undo':        document.execCommand('undo'); break;
            case 'redo':        document.execCommand('redo'); break;
        }
        updateWordCount();
    }

    function syncBody() {
        document.getElementById('post-body-hidden').value =
            document.getElementById('post-body').innerHTML;
    }
    document.getElementById('post-form').addEventListener('submit', syncBody);

    // ── Status toggle ────────────────────────────────────────
    function updateStatusIndicator(val) {
        const row = document.getElementById('schedule-row');
        row.style.display = val === 'scheduled' ? 'block' : 'none';
    }

    // ── Featured Image ───────────────────────────────────────
    function previewFeatured(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('featured-placeholder').style.display = 'none';
            const img = document.getElementById('featured-preview');
            img.src = e.target.result;
            img.style.display = 'block';
            document.getElementById('featured-remove').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
    function handleImageDrop(e) {
        e.preventDefault();
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('featured-file').files = dt.files;
            previewFeatured({ target: { files: [file] } });
        }
    }
    function removeFeatured() {
        document.getElementById('featured-file').value = '';
        document.getElementById('featured-preview').style.display = 'none';
        document.getElementById('featured-remove').style.display = 'none';
        document.getElementById('featured-placeholder').style.display = 'block';
    }

</script>
@endsection
