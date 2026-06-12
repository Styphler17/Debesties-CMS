@extends('admin.layouts.app')

@section('title', 'Edit Page — Debesties Studio')
@section('page_title', 'Edit Page')

@section('content')
<div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 28px; box-shadow: var(--cms-sh-card); max-width: 800px; margin: 0 auto;">
    
    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div>
            <label style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Page Title</label>
            <input type="text" name="title" value="{{ old('title', $page->title) }}" placeholder="e.g. About Us" required
                   style="display: block; width: 100%; height: 42px; padding: 0 14px; font-family: var(--cms-font-ui); font-size: 14px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; transition: border-color 150ms;"
                   onfocus="this.style.borderColor='var(--cms-gold)';" onblur="this.style.borderColor='var(--cms-border)';" />
        </div>

        {{-- Status --}}
        <div>
            <label style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Status</label>
            <select name="status" required
                    style="display: block; width: 100%; height: 42px; padding: 0 14px; font-family: var(--cms-font-ui); font-size: 14px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; cursor: pointer;">
                <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Draft (hidden from public)</option>
                <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Published (live on site)</option>
            </select>
        </div>

        {{-- Page Body --}}
        <div>
            <label style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Page Content (HTML supported)</label>
            <textarea name="body" placeholder="Write page content here..." required
                      style="display: block; width: 100%; min-height: 250px; padding: 14px; font-family: var(--cms-font-ui); font-size: 14px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; resize: vertical; transition: border-color 150ms;"
                      onfocus="this.style.borderColor='var(--cms-gold)';" onblur="this.style.borderColor='var(--cms-border)';">{{ old('body', $page->body) }}</textarea>
        </div>

        {{-- Action Buttons --}}
        <div style="border-top: 1px solid var(--cms-border); padding-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
            <a href="{{ route('admin.pages.index') }}"
               style="display: inline-flex; align-items: center; justify-content: center; height: 40px; padding: 0 20px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-surface); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; text-decoration: none;"
               onmouseover="this.style.background='var(--cms-bg)';" onmouseout="this.style.background='var(--cms-surface)';">
                Cancel
            </a>
            <button type="submit"
                    style="display: inline-flex; align-items: center; justify-content: center; height: 40px; padding: 0 20px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;"
                    onmouseover="this.style.background='#D69B00';" onmouseout="this.style.background='var(--cms-gold)';">
                Save Changes
            </button>
        </div>

    </form>
</div>
@endsection
