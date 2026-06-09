@extends('admin.layouts.app')

@section('title', 'Users — Debesties Studio')
@section('page_title', 'Users')

@section('content')
@php
    $users = [
        ['id'=>1,'name'=>'Ama Boateng','email'=>'ama@debesties.com','role'=>'Administrator','role_color'=>'var(--cms-gold)','role_bg'=>'var(--cms-gold-soft)','status'=>'active','last_login'=>'2m ago','avatar_bg'=>'#E8A800','posts'=>38],
        ['id'=>2,'name'=>'Kofi Mensah','email'=>'kofi@debesties.com','role'=>'Editor','role_color'=>'var(--cms-blue)','role_bg'=>'rgba(74,121,255,0.1)','status'=>'active','last_login'=>'1h ago','avatar_bg'=>'#4A79FF','posts'=>27],
        ['id'=>3,'name'=>'Adjoa Sarpong','email'=>'adjoa@debesties.com','role'=>'Author','role_color'=>'#9B59B6','role_bg'=>'rgba(155,89,182,0.1)','status'=>'active','last_login'=>'3h ago','avatar_bg'=>'#9B59B6','posts'=>14],
        ['id'=>4,'name'=>'Kwame Asante','email'=>'kwame@debesties.com','role'=>'Author','role_color'=>'#9B59B6','role_bg'=>'rgba(155,89,182,0.1)','status'=>'active','last_login'=>'1d ago','avatar_bg'=>'#2ECC71','posts'=>9],
        ['id'=>5,'name'=>'Efua Darko','email'=>'efua@debesties.com','role'=>'Editor','role_color'=>'var(--cms-blue)','role_bg'=>'rgba(74,121,255,0.1)','status'=>'suspended','last_login'=>'2w ago','avatar_bg'=>'#E67E22','posts'=>5],
    ];
@endphp

{{-- Toolbar --}}
<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
    <div style="display: flex; gap: 2px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 4px;">
        @foreach(['All','Active','Suspended'] as $tab)
            @php $count = $tab === 'All' ? count($users) : count(array_filter($users, fn($u) => $u['status'] === strtolower($tab))); @endphp
            <button onclick="filterStatus('{{ strtolower($tab) }}', this)" class="status-tab"
                    data-status="{{ strtolower($tab) }}"
                    style="height: 30px; padding: 0 14px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; border: none; border-radius: var(--cms-r-md); cursor: pointer; background: {{ $tab === 'All' ? 'var(--cms-gold)' : 'transparent' }}; color: {{ $tab === 'All' ? '#1A1410' : 'var(--cms-fg3)' }}; display: flex; align-items: center; gap: 5px; transition: all 150ms;">
                {{ $tab }} <span style="font-size: 11px; background: {{ $tab === 'All' ? 'rgba(0,0,0,0.15)' : 'var(--cms-border)' }}; padding: 0 5px; border-radius: 999px;">{{ $count }}</span>
            </button>
        @endforeach
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <select style="height: 38px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
            <option>All Roles</option>
            <option>Administrator</option>
            <option>Editor</option>
            <option>Author</option>
        </select>
        <button onclick="openInviteModal()"
                style="display: inline-flex; align-items: center; gap: 7px; height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;"
                onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
            <i data-lucide="user-plus" style="width: 16px; height: 16px;"></i>
            Invite User
        </button>
    </div>
</div>

{{-- Users Table --}}
<div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid var(--cms-border);">
                <th style="padding: 11px 16px; width: 40px;"><input type="checkbox" onchange="toggleAll(this)" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" /></th>
                <th style="padding: 11px 0 11px 0; text-align: left; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">User</th>
                <th style="padding: 11px 16px 11px 0; text-align: left; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">Role</th>
                <th style="padding: 11px 16px 11px 0; text-align: center; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">Status</th>
                <th style="padding: 11px 16px 11px 0; text-align: center; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">Posts</th>
                <th style="padding: 11px 16px 11px 0; text-align: right; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">Last Login</th>
                <th style="padding: 11px 16px; width: 100px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                @php $initials = implode('', array_map(fn($w) => strtoupper($w[0]), array_filter(explode(' ', $user['name'])))); @endphp
                <tr class="user-row" data-status="{{ $user['status'] }}"
                    style="border-bottom: 1px solid var(--cms-border); transition: background 100ms;"
                    onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 14px 16px;">
                        <input type="checkbox" class="user-cb" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                    </td>
                    <td style="padding: 14px 0;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 38px; height: 38px; border-radius: 999px; background: {{ $user['avatar_bg'] }}; display: flex; align-items: center; justify-content: center; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 800; color: #fff; flex-shrink: 0;">
                                {{ substr($initials, 0, 2) }}
                            </div>
                            <div>
                                <div style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 600; color: var(--cms-fg1);">{{ $user['name'] }}</div>
                                <div style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg4);">{{ $user['email'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 14px 16px 14px 0;">
                        <span style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 700; padding: 3px 10px; border-radius: 999px; background: {{ $user['role_bg'] }}; color: {{ $user['role_color'] }};">{{ $user['role'] }}</span>
                    </td>
                    <td style="padding: 14px 16px 14px 0; text-align: center;">
                        @if($user['status'] === 'active')
                            <span style="display: inline-flex; align-items: center; gap: 5px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 700; color: var(--cms-green);">
                                <span style="width: 6px; height: 6px; border-radius: 999px; background: var(--cms-green); display: inline-block;"></span>Active
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; gap: 5px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 700; color: var(--cms-red);">
                                <span style="width: 6px; height: 6px; border-radius: 999px; background: var(--cms-red); display: inline-block;"></span>Suspended
                            </span>
                        @endif
                    </td>
                    <td style="padding: 14px 16px 14px 0; text-align: center;">
                        <a href="{{ route('admin.posts.index', ['author' => $user['id']]) }}"
                           style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; color: var(--cms-blue); text-decoration: none;">{{ $user['posts'] }}</a>
                    </td>
                    <td style="padding: 14px 16px 14px 0; text-align: right;">
                        <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg4);">{{ $user['last_login'] }}</span>
                    </td>
                    <td style="padding: 14px 16px;">
                        <div style="display: flex; gap: 5px; justify-content: flex-end;">
                            <button title="Edit user"
                                    style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);"
                                    onmouseover="this.style.background='var(--cms-bg)'; this.style.color='var(--cms-fg1)'"
                                    onmouseout="this.style.background='var(--cms-surface)'; this.style.color='var(--cms-fg3)'">
                                <i data-lucide="edit-2" style="width: 13px; height: 13px;"></i>
                            </button>
                            @if($user['status'] === 'active')
                                <button title="Suspend user"
                                        style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(232,168,0,0.2); background: var(--cms-gold-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-gold-deep);"
                                        onmouseover="this.style.background='rgba(232,168,0,0.2)'" onmouseout="this.style.background='var(--cms-gold-soft)'">
                                    <i data-lucide="pause-circle" style="width: 13px; height: 13px;"></i>
                                </button>
                            @else
                                <button title="Activate user"
                                        style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(46,204,113,0.25); background: rgba(46,204,113,0.1); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-green);"
                                        onmouseover="this.style.background='rgba(46,204,113,0.2)'" onmouseout="this.style.background='rgba(46,204,113,0.1)'">
                                    <i data-lucide="play-circle" style="width: 13px; height: 13px;"></i>
                                </button>
                            @endif
                            <button onclick="confirmDelete({{ $user['id'] }}, '{{ $user['name'] }}')" title="Delete"
                                    style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(200,55,43,0.2); background: var(--cms-red-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red);"
                                    onmouseover="this.style.background='#F8D5D2'" onmouseout="this.style.background='var(--cms-red-soft)'">
                                <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Invite Modal --}}
<div id="invite-modal" style="display: none; position: fixed; inset: 0; background: rgba(20,16,12,0.5); z-index: 200; align-items: center; justify-content: center;">
    <div style="background: var(--cms-surface); border-radius: var(--cms-r-xl); padding: 28px; width: 420px; max-width: calc(100vw - 40px); box-shadow: var(--cms-sh-pop); animation: dsPop 200ms ease;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: var(--cms-r-md); background: var(--cms-gold-soft); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="user-plus" style="width: 18px; height: 18px; color: var(--cms-gold);"></i>
                </div>
                <span style="font-family: var(--cms-font-ui); font-size: 16px; font-weight: 700; color: var(--cms-fg1);">Invite New User</span>
            </div>
            <button onclick="closeInviteModal()" style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-bg); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);">
                <i data-lucide="x" style="width: 14px; height: 14px;"></i>
            </button>
        </div>
        <div style="display: flex; flex-direction: column; gap: 14px;">
            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Email Address</label>
                <input type="email" placeholder="journalist@example.com"
                       style="display: block; width: 100%; height: 42px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;"
                       onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                       onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'" />
            </div>
            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Role</label>
                <select style="width: 100%; height: 42px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
                    <option value="author">Author</option>
                    <option value="editor">Editor</option>
                    <option value="administrator">Administrator</option>
                </select>
            </div>
        </div>
        <div style="display: flex; gap: 8px; margin-top: 20px;">
            <button onclick="closeInviteModal()" style="flex: 1; height: 40px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-bg); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Cancel</button>
            <button style="flex: 2; height: 40px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;"
                    onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                Send Invite
            </button>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div id="delete-modal" style="display: none; position: fixed; inset: 0; background: rgba(20,16,12,0.5); z-index: 200; align-items: center; justify-content: center;">
    <div style="background: var(--cms-surface); border-radius: var(--cms-r-xl); padding: 28px; width: 380px; max-width: calc(100vw - 40px); box-shadow: var(--cms-sh-pop); animation: dsPop 200ms ease;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
            <div style="width: 40px; height: 40px; border-radius: var(--cms-r-md); background: var(--cms-red-soft); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-lucide="user-x" style="width: 20px; height: 20px; color: var(--cms-red);"></i>
            </div>
            <div>
                <div style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Delete User?</div>
                <div id="delete-label" style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3); margin-top: 2px;"></div>
            </div>
        </div>
        <div style="background: var(--cms-red-soft); border: 1px solid rgba(200,55,43,0.2); border-radius: var(--cms-r-md); padding: 10px 14px; margin: 12px 0; font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-red-deep);">
            This will remove all post author attributions for this user.
        </div>
        <div style="display: flex; gap: 8px; justify-content: flex-end;">
            <button onclick="closeDelete()" style="height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-surface); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Cancel</button>
            <button style="height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-red); color: #fff; border: none; border-radius: var(--cms-r-md); cursor: pointer;">Delete User</button>
        </div>
    </div>
</div>

<script>
    function filterStatus(status, btn) {
        document.querySelectorAll('.status-tab').forEach(b => {
            const active = b.dataset.status === status;
            b.style.background = active ? 'var(--cms-gold)' : 'transparent';
            b.style.color = active ? '#1A1410' : 'var(--cms-fg3)';
        });
        document.querySelectorAll('.user-row').forEach(row => {
            row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
        });
    }

    function openInviteModal() {
        document.getElementById('invite-modal').style.display = 'flex';
        lucide.createIcons();
    }
    function closeInviteModal() { document.getElementById('invite-modal').style.display = 'none'; }

    function confirmDelete(id, name) {
        document.getElementById('delete-label').textContent = name;
        document.getElementById('delete-modal').style.display = 'flex';
        lucide.createIcons();
    }
    function closeDelete() { document.getElementById('delete-modal').style.display = 'none'; }

    function toggleAll(master) {
        document.querySelectorAll('.user-cb').forEach(cb => cb.checked = master.checked);
    }
</script>
@endsection
