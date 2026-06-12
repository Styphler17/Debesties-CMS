@extends('admin.layouts.app')

@section('title', 'Pages — Debesties Studio')
@section('page_title', 'Pages')

@section('content')
<div style="display: flex; flex-direction: column; gap: 20px;">

    {{-- Top Action Bar --}}
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap;">
        {{-- Tabs --}}
        <div style="display: flex; gap: 4px; background: rgba(0,0,0,0.03); padding: 4px; border-radius: var(--cms-r-md);">
            @foreach(['All', 'Published', 'Draft'] as $tab)
                @php
                    $isActive = request('status', 'All') === $tab;
                @endphp
                <a href="{{ route('admin.pages.index', array_merge(request()->query(), ['status' => $tab])) }}"
                   style="display: inline-flex; align-items: center; justify-content: center; height: 32px; padding: 0 16px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; text-decoration: none; border-radius: var(--cms-r-sm); transition: all 120ms;
                          color: {{ $isActive ? 'var(--cms-fg1)' : 'var(--cms-fg3)' }};
                          background: {{ $isActive ? 'var(--cms-surface)' : 'transparent' }};
                          box-shadow: {{ $isActive ? 'var(--cms-sh-card)' : 'none' }};">
                    {{ $tab }}
                </a>
            @endforeach
        </div>

        {{-- Search & Create --}}
        <div style="display: flex; align-items: center; gap: 10px;">
            <form action="{{ route('admin.pages.index') }}" method="GET" style="display: flex; align-items: center; gap: 8px; width: 240px; height: 38px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 0 12px;">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <i data-lucide="search" style="width: 15px; height: 15px; color: var(--cms-fg4); flex-shrink: 0;"></i>
                <input name="q" value="{{ request('q') }}" placeholder="Search pages…"
                       style="border: none; outline: none; background: none; flex: 1; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1);" />
            </form>
            <a href="{{ route('admin.pages.create') }}"
               style="display: inline-flex; align-items: center; gap: 7px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; padding: 0 18px; height: 38px; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; text-decoration: none; line-height: 38px;"
               onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                <i data-lucide="plus" style="width: 16px; height: 16px; stroke-width: 2.2;"></i>
                Add Page
            </a>
        </div>
    </div>

    {{-- Pages List Table --}}
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
        <table style="width: 100%; border-collapse: collapse; font-family: var(--cms-font-ui); text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--cms-border);">
                    <th style="padding: 14px 20px; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase;">Title</th>
                    <th style="padding: 14px 20px; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase;">Slug</th>
                    <th style="padding: 14px 20px; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase;">Author</th>
                    <th style="padding: 14px 20px; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase;">Status</th>
                    <th style="padding: 14px 20px; font-size: 12px; font-weight: 700; color: var(--cms-fg3); letter-spacing: 0.04em; text-transform: uppercase;">Created At</th>
                    <th style="padding: 14px 20px; width: 100px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr style="border-bottom: {{ !$loop->last ? '1px solid var(--cms-border)' : 'none' }}; transition: background 120ms;"
                        onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 14px 20px; font-weight: 600; color: var(--cms-fg1);">
                            {{ $page->title }}
                        </td>
                        <td style="padding: 14px 20px; font-family: var(--cms-font-mono); font-size: 12.5px; color: var(--cms-fg2);">
                            /pages/{{ $page->slug }}
                        </td>
                        <td style="padding: 14px 20px; color: var(--cms-fg2);">
                            {{ $page->user->name ?? 'System' }}
                        </td>
                        <td style="padding: 14px 20px;">
                            @if($page->status === 'published')
                                <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 99px; font-size: 11px; font-weight: 700; background: rgba(26,92,46,0.1); color: var(--cms-green);">
                                    Published
                                </span>
                            @else
                                <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 99px; font-size: 11px; font-weight: 700; background: rgba(92,84,72,0.1); color: var(--cms-fg3);">
                                    Draft
                                </span>
                            @endif
                        </td>
                        <td style="padding: 14px 20px; font-size: 13px; color: var(--cms-fg3);">
                            {{ $page->created_at->format('M d, Y') }}
                        </td>
                        <td style="padding: 14px 20px; text-align: right;">
                            <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                <a href="{{ route('admin.pages.edit', $page->id) }}" title="Edit Page"
                                   style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);"
                                   onmouseover="this.style.background='var(--cms-bg)'; this.style.color='var(--cms-fg1)'"
                                   onmouseout="this.style.background='var(--cms-surface)'; this.style.color='var(--cms-fg3)'">
                                    <i data-lucide="edit" style="width: 14px; height: 14px;"></i>
                                </a>
                                <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this page?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete Page"
                                            style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(200,55,43,0.2); background: var(--cms-red-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red);"
                                            onmouseover="this.style.background='#F8D5D2'" onmouseout="this.style.background='var(--cms-red-soft)'">
                                        <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 48px; text-align: center; color: var(--cms-fg4); font-size: 14px;">
                            No pages found. Click "Add Page" to create a new page.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($pages->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 10px;">
            {{ $pages->links() }}
        </div>
    @endif

</div>
@endsection
