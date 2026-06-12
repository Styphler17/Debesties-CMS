@extends('admin.layouts.app')

@section('title', 'Newsletter Campaigns — Debesties Studio')
@section('page_title', 'Newsletter Campaigns')

@section('content')

{{-- Toast Container --}}
<div id="toast-container" style="position: fixed; bottom: 24px; right: 24px; z-index: 999; display: flex; flex-direction: column; gap: 8px;"></div>

<div style="max-width: 1000px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px;">
    
    {{-- Header Widget --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
        <!-- Subscribers Stat -->
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 20px 24px; display: flex; align-items: center; gap: 16px; box-shadow: var(--cms-sh-card);">
            <div style="width: 48px; height: 48px; border-radius: var(--cms-r-md); background: var(--cms-gold-soft); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-lucide="users" style="width: 22px; height: 22px; color: var(--cms-gold-deep);"></i>
            </div>
            <div>
                <div style="font-family: var(--cms-font-ui); font-size: 26px; font-weight: 800; color: var(--cms-fg1); line-height: 1.1;">{{ number_format($subscriberCount) }}</div>
                <div style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3); margin-top: 2px;">Active Subscribers</div>
            </div>
        </div>
        
        <!-- Campaigns Stat -->
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 20px 24px; display: flex; align-items: center; gap: 16px; box-shadow: var(--cms-sh-card);">
            <div style="width: 48px; height: 48px; border-radius: var(--cms-r-md); background: var(--cms-green-soft); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-lucide="mail" style="width: 22px; height: 22px; color: var(--cms-green-deep);"></i>
            </div>
            <div>
                <div style="font-family: var(--cms-font-ui); font-size: 26px; font-weight: 800; color: var(--cms-fg1); line-height: 1.1;">{{ $campaigns->total() }}</div>
                <div style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3); margin-top: 2px;">Total Campaigns</div>
            </div>
        </div>

        <!-- Action Button -->
        <div style="display: flex; align-items: center; justify-content: flex-end;">
            <a href="{{ route('admin.newsletters.create') }}" 
               style="display: inline-flex; align-items: center; gap: 8px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 700; padding: 12px 20px; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; text-decoration: none; transition: background 150ms;"
               onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                <i data-lucide="plus" style="width: 16px; height: 16px; stroke-width: 2.5;"></i>
                Compose Newsletter
            </a>
        </div>
    </div>

    {{-- Campaign List Table --}}
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; justify-content: space-between;">
            <h3 style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">All Campaigns</h3>
        </div>

        @if($campaigns->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--cms-border); background: #FAF9F6;">
                            <th style="padding: 14px 24px; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em;">Subject</th>
                            <th style="padding: 14px 24px; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                            <th style="padding: 14px 24px; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em;">Sent To</th>
                            <th style="padding: 14px 24px; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em;">Sent At</th>
                            <th style="padding: 14px 24px; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $campaign)
                            @php
                                $statusBg = '#F0EDE8';
                                $statusColor = 'var(--cms-fg3)';
                                if ($campaign->status === 'sent') {
                                    $statusBg = 'var(--cms-green-soft)';
                                    $statusColor = 'var(--cms-green-deep)';
                                } elseif ($campaign->status === 'sending') {
                                    $statusBg = 'var(--cms-blue-soft)';
                                    $statusColor = 'var(--cms-blue)';
                                }
                            @endphp
                            <tr style="border-bottom: 1px solid var(--cms-border); transition: background 120ms;" onmouseover="this.style.background='#FDFBF9'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 16px 24px;">
                                    <a href="{{ route('admin.newsletters.show', $campaign) }}" style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; color: var(--cms-fg1); text-decoration: none; display: block;">
                                        {{ $campaign->subject }}
                                    </a>
                                </td>
                                <td style="padding: 16px 24px;">
                                    <span style="display: inline-flex; align-items: center; height: 22px; padding: 0 8px; border-radius: 4px; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.02em; background: {{ $statusBg }}; color: {{ $statusColor }};">
                                        {{ $campaign->status }}
                                    </span>
                                </td>
                                <td style="padding: 16px 24px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg2);">
                                    {{ $campaign->status === 'sent' ? number_format($campaign->sent_to_count) . ' subscribers' : '—' }}
                                </td>
                                <td style="padding: 16px 24px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3);">
                                    {{ $campaign->sent_at ? $campaign->sent_at->format('M d, Y H:i') : 'Not sent yet' }}
                                </td>
                                <td style="padding: 16px 24px; text-align: right;">
                                    <div style="display: inline-flex; gap: 8px; align-items: center;">
                                        <a href="{{ route('admin.newsletters.show', $campaign) }}" style="color: var(--cms-fg2);" title="View details">
                                            <i data-lucide="eye" style="width: 17px; height: 17px;"></i>
                                        </a>
                                        @if($campaign->status === 'draft')
                                            <a href="{{ route('admin.newsletters.edit', $campaign) }}" style="color: var(--cms-gold-deep);" title="Edit campaign">
                                                <i data-lucide="edit-3" style="width: 17px; height: 17px;"></i>
                                            </a>
                                            <form action="{{ route('admin.newsletters.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this draft campaign?')" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer; color: var(--cms-red);" title="Delete campaign">
                                                    <i data-lucide="trash-2" style="width: 17px; height: 17px;"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            @if($campaigns->hasPages())
                <div style="padding: 20px 24px; border-top: 1px solid var(--cms-border); display: flex; justify-content: center;">
                    {{ $campaigns->links() }}
                </div>
            @endif
        @else
            <div style="padding: 48px; text-align: center;">
                <div style="width: 56px; height: 56px; border-radius: 999px; background: var(--cms-bg); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <i data-lucide="mail-open" style="width: 24px; height: 24px; color: var(--cms-fg4);"></i>
                </div>
                <h4 style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg2); margin: 0 0 4px 0;">No Campaigns Yet</h4>
                <p style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg4); margin: 0 0 20px 0;">Compose and send your first newsletter campaign to all subscribers.</p>
                <a href="{{ route('admin.newsletters.create') }}" 
                   style="display: inline-flex; align-items: center; gap: 8px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; padding: 9px 16px; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; text-decoration: none;"
                   onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                    <i data-lucide="plus" style="width: 15px; height: 15px;"></i>
                    Create First Campaign
                </a>
            </div>
        @endif
    </div>

</div>

<script>
    function showToast(message) {
        const container = document.getElementById('toast-container');
        if (!container) return;
        
        const toast = document.createElement('div');
        toast.style.cssText = "background: #17120D; border: 1.5px solid var(--cms-gold); border-radius: var(--cms-r-md); padding: 12px 20px; color: #fff; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 8px; box-shadow: var(--cms-sh-pop); animation: dsPop 180ms ease; min-width: 280px;";
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
