@extends('admin.layouts.app')

@section('title', 'Pages — Debesties Studio')
@section('page_title', 'Pages')

@section('content')
<div style="display: flex; align-items: center; justify-content: center; min-height: 320px;">
    <div style="text-align: center; max-width: 360px;">
        <div style="width: 56px; height: 56px; border-radius: var(--cms-r-lg); background: var(--cms-gold-soft); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
            <i data-lucide="file" style="width: 26px; height: 26px; color: var(--cms-gold-deep);"></i>
        </div>
        <div style="font-family: var(--cms-font-disp); font-size: 20px; font-weight: 700; color: var(--cms-fg1); margin-bottom: 8px;">Pages</div>
        <div style="font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg3); line-height: 1.6;">Static pages (About, Contact, etc.) will be managed here.</div>
    </div>
</div>
@endsection
