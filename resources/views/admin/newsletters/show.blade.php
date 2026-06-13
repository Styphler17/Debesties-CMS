@extends('admin.layouts.app')

@section('title', 'Newsletter Details — Debesties Studio')
@section('page_title', 'Newsletter Campaign')

@section('content')

{{-- Toast Container --}}
<div id="toast-container" style="position: fixed; bottom: 24px; right: 24px; z-index: 999; display: flex; flex-direction: column; gap: 8px;"></div>

<div style="max-width: 900px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px;">
    
    {{-- Top Navigation & Actions Bar --}}
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
        <a href="{{ route('admin.newsletters.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg3); text-decoration: none;">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
            Back to Campaigns
        </a>

        @if($newsletter->status === 'draft')
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.newsletters.edit', $newsletter) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 600; padding: 8px 14px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); color: var(--cms-fg1); text-decoration: none; cursor: pointer;">
                    <i data-lucide="edit-3" style="width: 15px; height: 15px;"></i>
                    Edit Draft
                </a>

                <form action="{{ route('admin.newsletters.destroy', $newsletter) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this draft campaign?')" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            style="display: inline-flex; align-items: center; gap: 6px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 600; padding: 8px 14px; background: var(--cms-surface); border: 1.5px solid var(--cms-red); border-radius: var(--cms-r-md); color: var(--cms-red); cursor: pointer;">
                        <i data-lucide="trash-2" style="width: 15px; height: 15px;"></i>
                        Delete Draft
                    </button>
                </form>

                <form action="{{ route('admin.newsletters.send', $newsletter) }}" method="POST" onsubmit="return confirm('Are you sure you want to broadcast this newsletter to all subscribers? This action cannot be undone.')" style="display: inline;">
                    @csrf
                    <button type="submit" 
                            style="display: inline-flex; align-items: center; gap: 6px; font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 700; padding: 8px 16px; background: var(--cms-green-deep); border: none; border-radius: var(--cms-r-md); color: #fff; cursor: pointer; transition: background 120ms;"
                            onmouseover="this.style.background='#144522'" onmouseout="this.style.background='var(--cms-green-deep)'">
                        <i data-lucide="send" style="width: 15px; height: 15px;"></i>
                        Send Broadcast
                    </button>
                </form>
            </div>
        @endif
    </div>

    {{-- Details Section Card --}}
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card); padding: 24px; display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        
        <div>
            <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">Subject Line</span>
            <h2 style="font-family: var(--cms-font-ui), sans-serif; font-size: 18px; font-weight: 800; color: var(--cms-fg1); margin: 0 0 16px 0;">{{ $newsletter->subject }}</h2>

            @if($newsletter->status === 'sent')
                <div style="background: var(--cms-green-soft); border: 1.5px solid var(--cms-green-deep); border-radius: var(--cms-r-md); padding: 14px 16px; display: flex; align-items: flex-start; gap: 10px; color: var(--cms-green-deep); font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px;">
                    <i data-lucide="check-circle" style="width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px;"></i>
                    <div>
                        <strong style="display: block; font-weight: 700; margin-bottom: 2px;">Broadcast Complete!</strong>
                        Successfully sent to {{ number_format($newsletter->sent_to_count) }} subscribers at {{ $newsletter->sent_at->format('M d, Y H:i') }}.
                    </div>
                </div>
            @elseif($newsletter->status === 'sending')
                <div style="background: var(--cms-blue-soft); border: 1.5px solid var(--cms-blue); border-radius: var(--cms-r-md); padding: 14px 16px; display: flex; align-items: flex-start; gap: 10px; color: var(--cms-blue); font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px;">
                    <i data-lucide="loader-2" class="spin" style="width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px;"></i>
                    <div>
                        <strong style="display: block; font-weight: 700; margin-bottom: 2px;">Sending Broadcast...</strong>
                        The system is broadcasting this newsletter. Refresh page to check updated status.
                    </div>
                </div>
            @else
                <div style="background: #F0EDE8; border: 1.5px solid var(--cms-border-st); border-radius: var(--cms-r-md); padding: 14px 16px; display: flex; align-items: flex-start; gap: 10px; color: var(--cms-fg2); font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px;">
                    <i data-lucide="info" style="width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px;"></i>
                    <div>
                        <strong style="display: block; font-weight: 700; margin-bottom: 2px;">Draft Campaign</strong>
                        Review the preview layout below. Once satisfied, click "Send Broadcast" to deliver it to subscribers.
                    </div>
                </div>
            @endif
        </div>

        <div style="border-left: 1px solid var(--cms-border); padding-left: 24px; display: flex; flex-direction: column; gap: 14px; font-family: var(--cms-font-ui), sans-serif;">
            <div>
                <span style="font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 2px;">Campaign Status</span>
                @php
                    $statusBg = '#F0EDE8';
                    $statusColor = 'var(--cms-fg3)';
                    if ($newsletter->status === 'sent') {
                        $statusBg = 'var(--cms-green-soft)';
                        $statusColor = 'var(--cms-green-deep)';
                    } elseif ($newsletter->status === 'sending') {
                        $statusBg = 'var(--cms-blue-soft)';
                        $statusColor = 'var(--cms-blue)';
                    }
                @endphp
                @php $badgeStyle = "display: inline-flex; align-items: center; height: 22px; padding: 0 8px; border-radius: 4px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.02em; background: $statusBg; color: $statusColor;"; @endphp
                <span style="{!! $badgeStyle !!}">
                    {{ $newsletter->status }}
                </span>
            </div>
            
            <div>
                <span style="font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 2px;">Created</span>
                <span style="font-size: 13px; color: var(--cms-fg1); font-weight: 500;">{{ $newsletter->created_at->format('M d, Y H:i') }}</span>
            </div>

            @if($newsletter->sent_at)
                <div>
                    <span style="font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 2px;">Broadcast Time</span>
                    <span style="font-size: 13px; color: var(--cms-fg1); font-weight: 500;">{{ $newsletter->sent_at->format('M d, Y H:i') }}</span>
                </div>
            @endif
        </div>

    </div>

    {{-- Email Preview Frame Section --}}
    <div>
        <h4 style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; margin: 0 0 10px 0;">Email Layout Preview</h4>
        
        <div style="border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; background: #FAF9F6; padding: 40px 20px; box-shadow: var(--cms-sh-card);">
            
            {{-- Mimic mail.newsletter template rendering --}}
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #E8E5DF; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);">
                <!-- Header -->
                <div style="background-color: #1A5C2E; padding: 32px; text-align: center;">
                    <h1 style="color: #E8A800; font-family: 'Playfair Display', serif; font-size: 28px; margin: 0; font-weight: 700; letter-spacing: -0.5px;">Debesties</h1>
                    <p style="color: #F8F5F0; font-size: 13px; margin: 8px 0 0 0; font-family: 'Space Mono', monospace; text-transform: uppercase; letter-spacing: 1.5px;">Newsletter Broadcast</p>
                </div>
                
                <!-- Content -->
                <div style="padding: 32px; font-family: 'Outfit', sans-serif;">
                    <h2 style="color: #1A5C2E; font-size: 20px; font-weight: 700; margin-top: 0; margin-bottom: 20px;">{{ $newsletter->subject }}</h2>
                    <div style="font-size: 15px; color: #333333; line-height: 1.6; white-space: pre-wrap;">{!! e($newsletter->body) !!}</div>
                </div>

                <!-- Footer -->
                <div style="background-color: #F0EDE6; padding: 24px; text-align: center; border-top: 1px solid #E8E5DF; font-size: 12px; color: #666666;">
                    <p style="margin: 0 0 8px 0;">Thank you for reading the Debesties newsletter.</p>
                    <p style="margin: 0;">You are receiving this because you subscribed to updates at debesties.com.</p>
                    <p style="margin: 12px 0 0 0; font-size: 11px; color: #999999;">&copy; {{ date('Y') }} Debesties CMS. All rights reserved.</p>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    function showToast(message) {
        const container = document.getElementById('toast-container');
        if (!container) return;
        
        const toast = document.createElement('div');
        toast.style.cssText = "background: #17120D; border: 1.5px solid var(--cms-gold); border-radius: var(--cms-r-md); padding: 12px 20px; color: #fff; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 8px; box-shadow: var(--cms-sh-pop); animation: dsPop 180ms ease; min-width: 280px;";
        toast.innerHTML = `<i data-lucide="check-circle" style="width: 16px; height: 16px; color: var(--cms-gold); flex-shrink: 0;"></i> <span>${message}</span>`;
        
        container.appendChild(toast);
        if (window.lucide) {
            lucide.createIcons();
        }

        setTimeout(() => {
            toast.style.animation = "dsFade 200ms ease reverse";
            toast.style.opacity = "0";
            setTimeout(() => toast.remove(), 200);
        }, 3000);
    }
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast("{{ session('success') }}");
    });
</script>
@endif
@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        alert("{{ session('error') }}");
    });
</script>
@endif

@endsection
