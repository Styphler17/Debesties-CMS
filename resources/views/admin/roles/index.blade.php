@extends('admin.layouts.app')

@section('title', 'Roles & Permissions — Debesties Studio')
@section('page_title', 'Roles & Permissions')

@section('content')

@if(session('success'))
    <div style="background: var(--cms-green-soft); color: var(--cms-green-deep); padding: 12px 18px; border-radius: var(--cms-r-md); border: 1px solid rgba(26,138,75,0.2); margin-bottom: 16px; font-family: var(--cms-font-ui); font-size: 14px; font-weight: 600;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background: var(--cms-red-soft); color: var(--cms-red-deep); padding: 12px 18px; border-radius: var(--cms-r-md); border: 1px solid rgba(200,55,43,0.2); margin-bottom: 16px; font-family: var(--cms-font-ui); font-size: 14px; font-weight: 600;">
        {{ session('error') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: 320px 1fr; gap: 24px; align-items: start;">
    
    {{-- Left Panel: Role List --}}
    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">System Roles</div>
            <button onclick="openAddRoleModal()"
                    style="display: inline-flex; align-items: center; gap: 5px; height: 32px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; transition: background 150ms;"
                    onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                <i data-lucide="plus" style="width: 14px; height: 14px;"></i>
                Add Role
            </button>
        </div>

        <div id="role-cards-container" style="display: flex; flex-direction: column; gap: 10px;">
            @foreach($roles as $role)
                @php
                    $isSystemRole = in_array($role->slug, ['super_admin', 'subscriber']);
                @endphp
                <div class="role-card" 
                     id="role-card-{{ $role->id }}" 
                     onclick="selectRole({{ $role->id }})"
                     data-role-id="{{ $role->id }}"
                     data-name="{{ $role->name }}"
                     data-description="{{ $role->description ?: 'No description provided.' }}"
                     data-cannot-delete="{{ $isSystemRole ? 'true' : 'false' }}"
                     data-permissions='@json($role->permissions->pluck('id'))'
                     style="background: var(--cms-surface); border: 1.5px solid {{ $loop->first ? 'var(--cms-gold)' : 'var(--cms-border)' }}; border-radius: var(--cms-r-lg); padding: 16px; cursor: pointer; transition: all 150ms; position: relative;"
                     onmouseover="if(this.style.borderColor!=='var(--cms-gold)') this.style.borderColor='var(--cms-border-st)'"
                     onmouseout="if(this.style.borderColor!=='var(--cms-gold)') this.style.borderColor='var(--cms-border)'">
                    
                    @if($isSystemRole)
                        <span style="position: absolute; top: 16px; right: 16px; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 999px; background: var(--cms-bg); color: var(--cms-fg3); border: 1px solid var(--cms-border);">SYSTEM</span>
                    @endif

                    <div style="font-family: var(--cms-font-ui); font-size: 14.5px; font-weight: 700; color: var(--cms-fg1); margin-bottom: 4px;" class="role-card-name">
                        {{ $role->name }}
                    </div>
                    
                    <div style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg3); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 12px;" class="role-card-desc">
                        {{ $role->description ?: 'No description provided.' }}
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--cms-border); padding-top: 10px; margin-top: 8px;">
                        <span style="font-size: 12px; font-weight: 500; color: var(--cms-fg4);" class="role-card-users">
                            <i data-lucide="users" style="width: 12px; height: 12px; vertical-align: -1px; margin-right: 4px;"></i>{{ $role->users_count }} user{{ $role->users_count !== 1 ? 's' : '' }}
                        </span>

                        @if(!$isSystemRole)
                            <button onclick="event.stopPropagation(); confirmDeleteRole({{ $role->id }}, '{{ $role->name }}')" 
                                    style="border: none; background: transparent; cursor: pointer; color: var(--cms-red); display: flex; padding: 4px; border-radius: 4px;"
                                    onmouseover="this.style.background='var(--cms-red-soft)'"
                                    onmouseout="this.style.background='transparent'">
                                <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Right Panel: Permission Matrix --}}
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 28px; box-shadow: var(--cms-sh-card);">
        
        {{-- Header Info --}}
        <div style="border-bottom: 1px solid var(--cms-border); padding-bottom: 20px; margin-bottom: 24px;">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;">
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                        <h2 id="active-role-name" style="font-family: var(--cms-font-disp); font-size: 24px; font-weight: 700; color: var(--cms-fg1); cursor: pointer; border-bottom: 1px dashed var(--cms-border-st); padding-bottom: 2px;" onclick="startEditRoleName()" title="Click to edit role name">
                            Super Admin
                        </h2>
                        <input id="active-role-name-input" type="text" style="display: none; font-family: var(--cms-font-disp); font-size: 24px; font-weight: 700; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-gold); border-radius: var(--cms-r-md); padding: 2px 8px; outline: none; width: 300px;" onblur="finishEditRoleName()" onkeydown="if(event.key === 'Enter') finishEditRoleName()" />
                        <button class="edit-pencil-btn" onclick="startEditRoleName()" style="border: none; background: none; cursor: pointer; color: var(--cms-fg4); display: flex; padding: 4px; border-radius: 4px;" onmouseover="this.style.color='var(--cms-fg2)'" onmouseout="this.style.color='var(--cms-fg4)'">
                            <i data-lucide="edit-3" style="width: 15px; height: 15px;"></i>
                        </button>
                    </div>
                    <div id="active-role-desc" style="font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg3); line-height: 1.5; cursor: pointer;" onclick="startEditRoleDesc()" title="Click to edit description">
                        Full access to all system features.
                    </div>
                    <textarea id="active-role-desc-input" style="display: none; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-gold); border-radius: var(--cms-r-md); padding: 6px 10px; outline: none; width: 100%; height: 60px; resize: none; margin-top: 4px;" onblur="finishEditRoleDesc()" onkeydown="if(event.key === 'Enter') { event.preventDefault(); finishEditRoleDesc(); }"></textarea>
                </div>
                
                <div id="admin-fixed-badge" style="display: flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: var(--cms-r-md); background: var(--cms-gold-soft); border: 1px solid rgba(232,168,0,0.25);">
                    <i data-lucide="shield-check" style="width: 15px; height: 15px; color: var(--cms-gold-deep);"></i>
                    <span style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-gold-deep);">Permissions Locked</span>
                </div>
            </div>
        </div>

        {{-- Permission Grid --}}
        <div>
            <div style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; color: var(--cms-fg2); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 14px;">Capabilities Matrix</div>
            
            <div style="border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse; background: var(--cms-surface);">
                    <thead>
                        <tr style="background: var(--cms-bg); border-bottom: 1px solid var(--cms-border);">
                            <th style="padding: 14px 20px; text-align: left; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">Permission Name</th>
                            <th style="padding: 14px 20px; text-align: center; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; width: 120px;">Allowed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                            <tr style="border-bottom: 1px solid var(--cms-border);" class="permission-row" data-id="{{ $permission->id }}">
                                <td style="padding: 16px 20px;">
                                    <div style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 600; color: var(--cms-fg1);">{{ $permission->name }}</div>
                                    <div style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4); margin-top: 1px;">Grant access to the <code>{{ $permission->slug }}</code> capability.</div>
                                </td>
                                <td style="padding: 16px 20px; text-align: center;">
                                    <input type="checkbox" class="perm-cb" value="{{ $permission->id }}" style="cursor: pointer; accent-color: var(--cms-gold); width: 18px; height: 18px;" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Actions --}}
        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 24px;">
            <div id="status-hint-text" style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3);">
                * System roles are locked and cannot be edited.
            </div>
            
            <button onclick="savePermissions()" id="save-permissions-btn"
                    style="display: inline-flex; align-items: center; gap: 7px; height: 40px; padding: 0 20px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; transition: background 150ms;"
                    onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                <i data-lucide="check" style="width: 16px; height: 16px;"></i>
                Save Permissions
            </button>
        </div>

    </div>

</div>

{{-- Add Role Modal --}}
<div id="add-role-modal" style="display: none; position: fixed; inset: 0; background: rgba(20,16,12,0.5); z-index: 200; align-items: center; justify-content: center;">
    <div style="background: var(--cms-surface); border-radius: var(--cms-r-xl); padding: 28px; width: 440px; max-width: calc(100vw - 40px); box-shadow: var(--cms-sh-pop); animation: dsPop 200ms ease;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: var(--cms-r-md); background: var(--cms-gold-soft); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="shield" style="width: 18px; height: 18px; color: var(--cms-gold);"></i>
                </div>
                <span style="font-family: var(--cms-font-ui); font-size: 16px; font-weight: 700; color: var(--cms-fg1);">Create Custom Role</span>
            </div>
            <button onclick="closeAddRoleModal()" style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-bg); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);">
                <i data-lucide="x" style="width: 14px; height: 14px;"></i>
            </button>
        </div>
        <div style="display: flex; flex-direction: column; gap: 14px;">
            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Role Name</label>
                <input type="text" id="new-role-name" placeholder="e.g. Moderator, Contributor"
                       style="display: block; width: 100%; height: 42px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;"
                       onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                       onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'" />
            </div>
            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; display: block; margin-bottom: 6px;">Description</label>
                <textarea id="new-role-desc" placeholder="What is this role allowed to do?"
                          style="display: block; width: 100%; height: 80px; padding: 10px 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; resize: none;"
                          onfocus="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232,168,0,0.13)'"
                          onblur="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none'"></textarea>
            </div>
        </div>
        <div style="display: flex; gap: 8px; margin-top: 20px;">
            <button onclick="closeAddRoleModal()" style="flex: 1; height: 40px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-bg); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Cancel</button>
            <button onclick="submitAddRole()" style="flex: 2; height: 40px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; transition: background 150ms;"
                    onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                Create Role
            </button>
        </div>
    </div>
</div>

{{-- Delete Role Modal --}}
<div id="delete-role-modal" style="display: none; position: fixed; inset: 0; background: rgba(20,16,12,0.5); z-index: 200; align-items: center; justify-content: center;">
    <div style="background: var(--cms-surface); border-radius: var(--cms-r-xl); padding: 28px; width: 380px; max-width: calc(100vw - 40px); box-shadow: var(--cms-sh-pop); animation: dsPop 200ms ease;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
            <div style="width: 40px; height: 40px; border-radius: var(--cms-r-md); background: var(--cms-red-soft); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-lucide="shield-alert" style="width: 20px; height: 20px; color: var(--cms-red);"></i>
            </div>
            <div>
                <div style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Delete Role?</div>
                <div id="delete-role-label" style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3); margin-top: 2px;"></div>
            </div>
        </div>
        <div style="background: var(--cms-red-soft); border: 1px solid rgba(200,55,43,0.2); border-radius: var(--cms-r-md); padding: 10px 14px; margin: 12px 0; font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-red-deep);">
            All users currently assigned to this role will need to be reassigned.
        </div>
        <div style="display: flex; gap: 8px; justify-content: flex-end;">
            <button onclick="closeDeleteRole()" style="height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-surface); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Cancel</button>
            <button onclick="submitDeleteRole()" style="height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-red); color: #fff; border: none; border-radius: var(--cms-r-md); cursor: pointer;">Delete Role</button>
        </div>
    </div>
</div>

<script>
    let activeRoleId = {{ $roles->first() ? $roles->first()->id : 1 }};
    let deleteRoleId = null;

    document.addEventListener("DOMContentLoaded", () => {
        selectRole(activeRoleId);
    });

    function selectRole(id) {
        activeRoleId = id;
        
        // Highlight active card
        document.querySelectorAll('.role-card').forEach(card => {
            const isActive = parseInt(card.dataset.roleId) === id;
            card.style.borderColor = isActive ? 'var(--cms-gold)' : 'var(--cms-border)';
        });

        const activeCard = document.getElementById(`role-card-${id}`);
        if (!activeCard) return;

        const name = activeCard.dataset.name;
        const description = activeCard.dataset.description;
        const cannotDelete = activeCard.dataset.cannotDelete === 'true';
        const permissions = JSON.parse(activeCard.dataset.permissions); // Array of checked permission IDs

        // Update main texts
        document.getElementById('active-role-name').textContent = name;
        document.getElementById('active-role-desc').textContent = description;

        // Toggle badge visibility
        const fixedBadge = document.getElementById('admin-fixed-badge');
        const saveBtn = document.getElementById('save-permissions-btn');
        const editPencilBtn = document.querySelector('.edit-pencil-btn');
        const statusHintText = document.getElementById('status-hint-text');

        if (cannotDelete) {
            fixedBadge.style.display = 'flex';
            saveBtn.style.display = 'none';
            editPencilBtn.style.display = 'none';
            statusHintText.textContent = "* System roles are locked and cannot be edited.";
        } else {
            fixedBadge.style.display = 'none';
            saveBtn.style.display = 'inline-flex';
            editPencilBtn.style.display = 'flex';
            statusHintText.textContent = "* Changes to this role's capability matrix will take effect immediately upon saving.";
        }

        // Set checkboxes
        document.querySelectorAll('.perm-cb').forEach(cb => {
            const permId = parseInt(cb.value);
            cb.checked = permissions.includes(permId);
            cb.disabled = cannotDelete;
        });

        lucide.createIcons();
    }

    // Inline edit name
    function startEditRoleName() {
        const activeCard = document.getElementById(`role-card-${activeRoleId}`);
        if (activeCard && activeCard.dataset.cannotDelete === 'true') return;

        const h2 = document.getElementById('active-role-name');
        const input = document.getElementById('active-role-name-input');
        const pencil = document.querySelector('.edit-pencil-btn');

        input.value = h2.textContent.trim();
        h2.style.display = 'none';
        pencil.style.display = 'none';
        input.style.display = 'inline-block';
        input.focus();
    }

    function finishEditRoleName() {
        const h2 = document.getElementById('active-role-name');
        const input = document.getElementById('active-role-name-input');
        const pencil = document.querySelector('.edit-pencil-btn');

        const newName = input.value.trim();
        if (newName && newName !== h2.textContent.trim()) {
            h2.textContent = newName;
            
            // Sync with card
            const activeCard = document.getElementById(`role-card-${activeRoleId}`);
            if (activeCard) {
                activeCard.dataset.name = newName;
                activeCard.querySelector('.role-card-name').textContent = newName;
                savePermissions(); // Save name changes directly
            }
        }

        input.style.display = 'none';
        h2.style.display = 'inline-block';
        pencil.style.display = 'flex';
    }

    // Inline edit description
    function startEditRoleDesc() {
        const activeCard = document.getElementById(`role-card-${activeRoleId}`);
        if (activeCard && activeCard.dataset.cannotDelete === 'true') return;

        const descDiv = document.getElementById('active-role-desc');
        const textarea = document.getElementById('active-role-desc-input');

        textarea.value = descDiv.textContent.trim();
        descDiv.style.display = 'none';
        textarea.style.display = 'block';
        textarea.focus();
    }

    function finishEditRoleDesc() {
        const descDiv = document.getElementById('active-role-desc');
        const textarea = document.getElementById('active-role-desc-input');

        const newDesc = textarea.value.trim();
        if (newDesc && newDesc !== descDiv.textContent.trim()) {
            descDiv.textContent = newDesc;

            // Sync with card
            const activeCard = document.getElementById(`role-card-${activeRoleId}`);
            if (activeCard) {
                activeCard.dataset.description = newDesc;
                activeCard.querySelector('.role-card-desc').textContent = newDesc;
                savePermissions(); // Save description changes directly
            }
        }

        textarea.style.display = 'none';
        descDiv.style.display = 'block';
    }

    // Save permissions and role details via AJAX
    function savePermissions() {
        const activeCard = document.getElementById(`role-card-${activeRoleId}`);
        if (!activeCard || activeCard.dataset.cannotDelete === 'true') return;

        let permissions = [];
        document.querySelectorAll('.perm-cb:checked').forEach(cb => {
            permissions.push(parseInt(cb.value));
        });

        const saveBtn = document.getElementById('save-permissions-btn');
        const originalText = saveBtn.innerHTML;
        saveBtn.disabled = true;

        fetch(`/admin/roles/${activeRoleId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                _method: 'PUT',
                name: activeCard.dataset.name,
                description: activeCard.dataset.description,
                permissions: permissions
            })
        })
        .then(res => res.json())
        .then(data => {
            saveBtn.disabled = false;
            if (data.success) {
                activeCard.dataset.permissions = JSON.stringify(data.role.permissions_matrix);
                
                // Show temporary success state
                saveBtn.style.background = 'var(--cms-green)';
                saveBtn.style.color = '#fff';
                saveBtn.innerHTML = '<i data-lucide="check" style="width: 16px; height: 16px;"></i> Saved!';
                lucide.createIcons();

                setTimeout(() => {
                    saveBtn.style.background = 'var(--cms-gold)';
                    saveBtn.style.color = '#1A1410';
                    saveBtn.innerHTML = originalText;
                    lucide.createIcons();
                }, 1500);
            } else {
                alert(data.message || 'Error saving permissions');
            }
        })
        .catch(() => {
            saveBtn.disabled = false;
            alert('An error occurred while saving.');
        });
    }

    // Modal Add Role
    function openAddRoleModal() {
        document.getElementById('add-role-modal').style.display = 'flex';
        document.getElementById('new-role-name').value = '';
        document.getElementById('new-role-desc').value = '';
        lucide.createIcons();
    }

    function closeAddRoleModal() {
        document.getElementById('add-role-modal').style.display = 'none';
    }

    function submitAddRole() {
        const nameInput = document.getElementById('new-role-name');
        const descInput = document.getElementById('new-role-desc');

        const name = nameInput.value.trim();
        const desc = descInput.value.trim();

        if (!name) {
            alert("Role Name is required");
            return;
        }

        fetch('{{ route("admin.roles.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                name: name,
                description: desc
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Error creating role');
            }
        })
        .catch(() => {
            alert('An error occurred.');
        });
    }

    // Modal Delete Role
    function confirmDeleteRole(id, name) {
        deleteRoleId = id;
        document.getElementById('delete-role-label').textContent = name;
        document.getElementById('delete-role-modal').style.display = 'flex';
        lucide.createIcons();
    }

    function closeDeleteRole() {
        document.getElementById('delete-role-modal').style.display = 'none';
        deleteRoleId = null;
    }

    function submitDeleteRole() {
        if (!deleteRoleId) return;
        
        fetch(`/admin/roles/${deleteRoleId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                _method: 'DELETE'
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Error deleting role');
            }
        })
        .catch(() => {
            alert('An error occurred.');
        });
    }
</script>
@endsection
