@extends('admin.layouts.app')

@section('title', 'Edit Newsletter Draft — Debesties Studio')
@section('page_title', 'Edit Newsletter Draft')

@section('content')

<div style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 20px;">
    
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <a href="{{ route('admin.newsletters.show', $newsletter) }}" style="display: inline-flex; align-items: center; gap: 6px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg3); text-decoration: none;">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
            Back to Campaign
        </a>
    </div>

    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card); padding: 24px;">
        <form action="{{ route('admin.newsletters.update', $newsletter) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 24px;">
                <div>
                    <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Email Subject</label>
                    <input type="text" name="subject" value="{{ old('subject', $newsletter->subject) }}" required placeholder="e.g. Weekly Roundup: Art & Music Scene in Accra"
                           style="display: block; width: 100%; height: 42px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;"
                           onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                           onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'" />
                    @error('subject')
                        <span style="color: var(--cms-red); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Newsletter Body (Markdown / Text)</label>
                    <textarea name="body" required placeholder="Write your newsletter copy here..."
                              style="display: block; width: 100%; height: 350px; padding: 12px; font-family: var(--cms-font-ui); font-size: 14px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; resize: vertical; line-height: 1.5;"
                              onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                              onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'">{{ old('body', $newsletter->body) }}</textarea>
                    @error('body')
                        <span style="color: var(--cms-red); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div style="border-top: 1px solid var(--cms-border); padding-top: 18px; display: flex; justify-content: flex-end; gap: 12px;">
                <a href="{{ route('admin.newsletters.show', $newsletter) }}" 
                   style="display: inline-flex; align-items: center; justify-content: center; height: 38px; padding: 0 16px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); text-decoration: none; background: transparent; cursor: pointer;">
                    Cancel
                </a>
                <button type="submit"
                        style="display: inline-flex; align-items: center; gap: 7px; height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; transition: background 150ms;"
                        onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                    <i data-lucide="save" style="width: 15px; height: 15px;"></i>
                    Update Draft
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
