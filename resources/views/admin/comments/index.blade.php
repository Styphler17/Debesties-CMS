@extends('admin.layouts.app')

@section('title', 'Comments Moderation — Debesties Studio')
@section('page_title', 'Comments')

@section('content')
@php
    $comments = [
        [
            'id' => 1,
            'name' => 'Kojo Antwi',
            'email' => 'kojo.antwi@example.com',
            'comment' => 'This is a stellar breakdown of the TGMA winners. The analysis on how Ghanaian highlife is gaining traction is spot on. Keep it up!',
            'post_title' => 'The Elite Club: 4 Artists Who Dominated TGMAs',
            'post_id' => 1,
            'status' => 'pending',
            'date' => '20m ago',
            'parent_comment' => null,
            'avatar_bg' => 'var(--cms-gold)',
        ],
        [
            'id' => 2,
            'name' => 'Akosua Serwaa',
            'email' => 'akosua.s@outlook.com',
            'comment' => 'Can you please do a follow-up article on the historical trends from the last decade? That would be very useful.',
            'post_title' => 'The Elite Club: 4 Artists Who Dominated TGMAs',
            'post_id' => 1,
            'status' => 'pending',
            'date' => '2h ago',
            'parent_comment' => null,
            'avatar_bg' => 'var(--cms-blue)',
        ],
        [
            'id' => 3,
            'name' => 'Sarah Jenkins',
            'email' => 's.jenkins@gmail.com',
            'comment' => 'I completely agree with Akosua\'s request! Ten-year stats would be a fantastic follow-up.',
            'post_title' => 'The Elite Club: 4 Artists Who Dominated TGMAs',
            'post_id' => 1,
            'status' => 'approved',
            'date' => '1d ago',
            'parent_comment' => 'Can you please do a follow-up article on the historical trends from the last decade? That would be very useful.',
            'avatar_bg' => '#9B59B6',
        ],
        [
            'id' => 4,
            'name' => 'Fast Crypto Boost',
            'email' => 'getrich@scambot.info',
            'comment' => 'MAKE $5000 A DAY WORKING FROM HOME! CLICK HERE: http://scam-link.xyz/opportunity to get instant payout and starts making real revenue!',
            'post_title' => '10 Tips for Optimizing Your Web Vitals',
            'post_id' => 2,
            'status' => 'spam',
            'date' => '2d ago',
            'parent_comment' => null,
            'avatar_bg' => 'var(--cms-fg4)',
        ]
    ];
@endphp

{{-- Comments Summary / Action Bar --}}
<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
    
    {{-- Tabs --}}
    <div style="display: flex; gap: 2px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 4px;">
        @foreach(['Pending','Approved','Spam','All'] as $tab)
            @php 
                $statusVal = strtolower($tab);
                $count = $statusVal === 'all' ? count($comments) : count(array_filter($comments, fn($c) => $c['status'] === $statusVal));
            @endphp
            <button onclick="filterStatus('{{ $statusVal }}', this)" class="comment-tab"
                    data-status="{{ $statusVal }}"
                    style="height: 30px; padding: 0 14px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; border: none; border-radius: var(--cms-r-md); cursor: pointer; background: {{ $statusVal === 'pending' ? 'var(--cms-gold)' : 'transparent' }}; color: {{ $statusVal === 'pending' ? '#1A1410' : 'var(--cms-fg3)' }}; display: flex; align-items: center; gap: 5px; transition: all 150ms;">
                {{ $tab }} 
                <span class="tab-badge" style="font-size: 11px; background: {{ $statusVal === 'pending' ? 'rgba(0,0,0,0.15)' : 'var(--cms-border)' }}; padding: 0 5px; border-radius: 999px;">{{ $count }}</span>
            </button>
        @endforeach
    </div>

    {{-- Bulk Actions Bar (displays when rows checked) --}}
    <div id="bulk-actions-bar" style="display: flex; align-items: center; gap: 8px; visibility: hidden; opacity: 0; transition: opacity 150ms;">
        <span style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3); margin-right: 4px;" id="selected-count">0 selected</span>
        <button onclick="bulkChangeStatus('approved')" style="display: inline-flex; align-items: center; gap: 5px; height: 34px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; background: var(--cms-green-soft); color: var(--cms-green-deep); border: 1px solid rgba(26,138,75,0.2); border-radius: var(--cms-r-md); cursor: pointer;">
            <i data-lucide="check" style="width: 14px; height: 14px;"></i> Approve
        </button>
        <button onclick="bulkChangeStatus('spam')" style="display: inline-flex; align-items: center; gap: 5px; height: 34px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; background: var(--cms-red-soft); color: var(--cms-red); border: 1px solid rgba(200,55,43,0.2); border-radius: var(--cms-r-md); cursor: pointer;">
            <i data-lucide="slash" style="width: 14px; height: 14px;"></i> Spam
        </button>
        <button onclick="bulkDelete()" style="display: inline-flex; align-items: center; gap: 5px; height: 34px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; background: var(--cms-bg); color: var(--cms-fg1); border: 1px solid var(--cms-border-st); border-radius: var(--cms-r-md); cursor: pointer;">
            <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i> Delete
        </button>
    </div>
</div>

{{-- Comments Table --}}
<div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid var(--cms-border); background: var(--cms-bg);">
                <th style="padding: 12px 16px; width: 40px; text-align: left;"><input type="checkbox" onchange="toggleAll(this)" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" /></th>
                <th style="padding: 12px 0; text-align: left; font-family: var(--cms-font-ui); font-size: 11.5px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em;">Author</th>
                <th style="padding: 12px 16px; text-align: left; font-family: var(--cms-font-ui); font-size: 11.5px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em;">Comment Excerpt</th>
                <th style="padding: 12px 16px 12px 0; text-align: left; font-family: var(--cms-font-ui); font-size: 11.5px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em;">On Post</th>
                <th style="padding: 12px 16px 12px 0; text-align: center; font-family: var(--cms-font-ui); font-size: 11.5px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em; width: 100px;">Status</th>
                <th style="padding: 12px 16px 12px 0; text-align: right; font-family: var(--cms-font-ui); font-size: 11.5px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em; width: 100px;">Submitted</th>
                <th style="padding: 12px 16px; width: 140px;"></th>
            </tr>
        </thead>
        <tbody id="comments-tbody">
            @foreach($comments as $comment)
                @php 
                    $initials = implode('', array_map(fn($w) => strtoupper($w[0]), array_filter(explode(' ', $comment['name'])))); 
                @endphp
                {{-- Master Row --}}
                <tr class="comment-row" 
                    id="comment-row-{{ $comment['id'] }}" 
                    data-status="{{ $comment['status'] }}" 
                    data-id="{{ $comment['id'] }}"
                    onclick="toggleExpand({{ $comment['id'] }})"
                    style="border-bottom: 1px solid var(--cms-border); cursor: pointer; transition: background 120ms;"
                    onmouseover="this.style.background='#FDFBF9'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 16px;" onclick="event.stopPropagation()">
                        <input type="checkbox" class="comment-cb" onchange="updateCheckedState()" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                    </td>
                    <td style="padding: 16px 0; vertical-align: top;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 34px; height: 34px; border-radius: 999px; background: {{ $comment['avatar_bg'] }}; color: #fff; display: flex; align-items: center; justify-content: center; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 800; flex-shrink: 0;">
                                {{ substr($initials, 0, 2) }}
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 700; color: var(--cms-fg1); text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $comment['name'] }}</div>
                                <div style="font-family: var(--cms-font-ui); font-size: 11.5px; color: var(--cms-fg4); text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $comment['email'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 16px; vertical-align: top;">
                        <div style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg2); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" class="comment-text-excerpt">
                            {{ $comment['comment'] }}
                        </div>
                    </td>
                    <td style="padding: 16px 16px 16px 0; vertical-align: top; max-width: 180px;">
                        <div style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; color: var(--cms-blue); text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $comment['post_title'] }}</div>
                    </td>
                    <td style="padding: 16px 16px 16px 0; vertical-align: top; text-align: center;" class="status-cell">
                        <span class="status-badge status-{{ $comment['status'] }}" style="padding: 3px 8px; border-radius: 999px; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.02em;">
                            {{ $comment['status'] }}
                        </span>
                    </td>
                    <td style="padding: 16px 16px 16px 0; vertical-align: top; text-align: right; white-space: nowrap;">
                        <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg4);">{{ $comment['date'] }}</span>
                    </td>
                    <td style="padding: 16px; text-align: right; vertical-align: top;" onclick="event.stopPropagation()">
                        <div style="display: flex; gap: 4px; justify-content: flex-end;">
                            <button onclick="changeStatus({{ $comment['id'] }}, 'approved')" class="action-btn-approve" title="Approve" style="width: 28px; height: 28px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-green);">
                                <i data-lucide="check" style="width: 14px; height: 14px;"></i>
                            </button>
                            <button onclick="changeStatus({{ $comment['id'] }}, 'spam')" class="action-btn-spam" title="Mark Spam" style="width: 28px; height: 28px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red);">
                                <i data-lucide="slash" style="width: 14px; height: 14px;"></i>
                            </button>
                            <button onclick="deleteComment({{ $comment['id'] }})" title="Delete" style="width: 28px; height: 28px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);">
                                <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- Detail / Expander Row --}}
                <tr class="detail-row" id="detail-row-{{ $comment['id'] }}" style="display: none; background: #FAF8F5; border-bottom: 1px solid var(--cms-border);">
                    <td colspan="7" style="padding: 24px 32px 24px 62px;" onclick="event.stopPropagation()">
                        
                        {{-- Thread Context if exists --}}
                        @if($comment['parent_comment'])
                            <div style="border-left: 3px solid var(--cms-border-st); padding-left: 14px; margin-bottom: 16px; font-style: italic;">
                                <div style="font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg4); text-transform: uppercase; margin-bottom: 2px;">In reply to parent comment:</div>
                                <div style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg3); line-height: 1.4;">"{{ $comment['parent_comment'] }}"</div>
                            </div>
                        @endif

                        {{-- Full Comment Text --}}
                        <div style="margin-bottom: 20px;">
                            <div style="font-family: var(--cms-font-ui); font-size: 14.5px; color: var(--cms-fg1); line-height: 1.6; font-weight: 400; white-space: pre-line;">
                                {{ $comment['comment'] }}
                            </div>
                        </div>

                        {{-- Quick Reply Area --}}
                        <div style="border-top: 1px solid var(--cms-border); padding-top: 18px; margin-top: 14px; max-width: 680px;">
                            <div style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 8px;">Quick Reply as Ama Boateng</div>
                            <div style="display: flex; gap: 12px; align-items: flex-end;">
                                <textarea placeholder="Type your response to {{ $comment['name'] }}…" style="flex: 1; height: 72px; padding: 10px 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; resize: none; transition: border-color 150ms;" onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.11)'" onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'"></textarea>
                                <button onclick="sendReply({{ $comment['id'] }}, this)" style="height: 38px; padding: 0 16px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; background: var(--cms-fg1); color: #fff; border: none; border-radius: var(--cms-r-md); cursor: pointer; display: flex; align-items: center; gap: 6px; transition: background 150ms;" onmouseover="this.style.background='var(--cms-fg2)'" onmouseout="this.style.background='var(--cms-fg1)'">
                                    <i data-lucide="corner-down-right" style="width: 14px; height: 14px;"></i> Reply
                                </button>
                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Styling for status badges --}}
<style>
    .status-badge.status-pending {
        background: var(--cms-gold-soft);
        color: var(--cms-gold-deep);
        border: 1px solid rgba(232,168,0,0.22);
    }
    .status-badge.status-approved {
        background: var(--cms-green-soft);
        color: var(--cms-green-deep);
        border: 1px solid rgba(26,138,75,0.22);
    }
    .status-badge.status-spam {
        background: var(--cms-red-soft);
        color: var(--cms-red);
        border: 1px solid rgba(200,55,43,0.18);
    }
</style>

<script>
    let activeFilter = 'pending';

    document.addEventListener("DOMContentLoaded", () => {
        // Run filter initially on 'pending' status
        filterStatus('pending', document.querySelector('.comment-tab[data-status="pending"]'));
    });

    function filterStatus(status, btn) {
        activeFilter = status;
        
        // Highlight active tab
        document.querySelectorAll('.comment-tab').forEach(b => {
            const active = b.dataset.status === status;
            b.style.background = active ? 'var(--cms-gold)' : 'transparent';
            b.style.color = active ? '#1A1410' : 'var(--cms-fg3)';
            
            const badge = b.querySelector('.tab-badge');
            if (badge) {
                badge.style.background = active ? 'rgba(0,0,0,0.15)' : 'var(--cms-border)';
            }
        });

        // Hide or show rows
        document.querySelectorAll('.comment-row').forEach(row => {
            const rowStatus = row.dataset.status;
            const match = (status === 'all' || rowStatus === status);
            row.style.display = match ? '' : 'none';
            
            // Hide detail row if parent is hidden
            const id = row.dataset.id;
            const detailRow = document.getElementById(`detail-row-${id}`);
            if (detailRow && !match) {
                detailRow.style.display = 'none';
            }
        });

        // Clear all checkmarks
        document.querySelectorAll('.comment-cb').forEach(cb => cb.checked = false);
        const masterCb = document.querySelector('thead input[type="checkbox"]');
        if (masterCb) masterCb.checked = false;
        
        updateCheckedState();
    }

    function toggleExpand(id) {
        const detailRow = document.getElementById(`detail-row-${id}`);
        if (detailRow) {
            const isCurrentlyOpen = detailRow.style.display !== 'none';
            // Close other detail rows
            document.querySelectorAll('.detail-row').forEach(row => row.style.display = 'none');
            // Toggle current
            detailRow.style.display = isCurrentlyOpen ? 'none' : 'table-row';
        }
    }

    function changeStatus(id, newStatus) {
        const row = document.getElementById(`comment-row-${id}`);
        if (!row) return;

        row.dataset.status = newStatus;
        
        // Update badge
        const badgeCell = row.querySelector('.status-cell');
        badgeCell.innerHTML = `
            <span class="status-badge status-${newStatus}" style="padding: 3px 8px; border-radius: 999px; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.02em;">
                ${newStatus}
            </span>
        `;

        // Update counts in tabs
        updateTabCounts();

        // Refresh filter
        filterStatus(activeFilter, document.querySelector(`.comment-tab[data-status="${activeFilter}"]`));
    }

    function deleteComment(id) {
        const row = document.getElementById(`comment-row-${id}`);
        const detail = document.getElementById(`detail-row-${id}`);
        if (row) row.remove();
        if (detail) detail.remove();

        updateTabCounts();
    }

    function sendReply(id, button) {
        const textarea = button.previousElementSibling;
        const replyText = textarea.value.trim();
        if (!replyText) return;

        // Visual success indicator
        const originalContent = button.innerHTML;
        button.style.background = 'var(--cms-green)';
        button.innerHTML = '<i data-lucide="check" style="width: 14px; height: 14px;"></i> Sent';
        lucide.createIcons();

        // Auto-approve the comment being replied to
        changeStatus(id, 'approved');

        setTimeout(() => {
            button.style.background = 'var(--cms-fg1)';
            button.innerHTML = originalContent;
            textarea.value = '';
            toggleExpand(id);
            lucide.createIcons();
        }, 1200);
    }

    // Bulk actions
    function toggleAll(master) {
        document.querySelectorAll('.comment-row').forEach(row => {
            if (row.style.display !== 'none') {
                const cb = row.querySelector('.comment-cb');
                if (cb) cb.checked = master.checked;
            }
        });
        updateCheckedState();
    }

    function updateCheckedState() {
        const checkedBoxes = Array.from(document.querySelectorAll('.comment-cb')).filter(cb => cb.checked);
        const count = checkedBoxes.length;
        
        const bulkBar = document.getElementById('bulk-actions-bar');
        const countSpan = document.getElementById('selected-count');

        if (count > 0) {
            bulkBar.style.visibility = 'visible';
            bulkBar.style.opacity = '1';
            countSpan.textContent = `${count} selected`;
        } else {
            bulkBar.style.visibility = 'hidden';
            bulkBar.style.opacity = '0';
        }
    }

    function bulkChangeStatus(newStatus) {
        const checkedBoxes = Array.from(document.querySelectorAll('.comment-cb')).filter(cb => cb.checked);
        checkedBoxes.forEach(cb => {
            const row = cb.closest('.comment-row');
            if (row) {
                const id = row.dataset.id;
                changeStatus(id, newStatus);
            }
        });
    }

    function bulkDelete() {
        const checkedBoxes = Array.from(document.querySelectorAll('.comment-cb')).filter(cb => cb.checked);
        checkedBoxes.forEach(cb => {
            const row = cb.closest('.comment-row');
            if (row) {
                const id = row.dataset.id;
                deleteComment(id);
            }
        });
    }

    function updateTabCounts() {
        const allRows = Array.from(document.querySelectorAll('.comment-row'));
        const total = allRows.length;
        
        document.querySelectorAll('.comment-tab').forEach(tab => {
            const status = tab.dataset.status;
            const badge = tab.querySelector('.tab-badge');
            
            const count = status === 'all' 
                ? total 
                : allRows.filter(row => row.dataset.status === status).length;
                
            if (badge) badge.textContent = count;
        });
    }
</script>
@endsection
