// Debesties CMS — App Shell (Sidebar + Topbar)
// Exports to window: Sidebar, Topbar

function Sidebar({ active, onNavigate, collapsed, mobileOpen, onCloseMobile, accent }) {
  const width = collapsed ? 72 : 248;
  return (
    <>
      {/* Mobile backdrop */}
      {mobileOpen && (
        <div onClick={onCloseMobile} style={{
          position: 'fixed', inset: 0, background: 'rgba(20,16,12,0.5)', zIndex: 90,
          display: 'none', animation: 'dsFade 160ms ease',
        }} className="cms-mobile-backdrop" />
      )}
      <aside className={`cms-sidebar ${mobileOpen ? 'cms-mobile-open' : ''}`} style={{
        width, background: DS.sidebar, height: '100vh', position: 'sticky', top: 0,
        display: 'flex', flexDirection: 'column', flexShrink: 0,
        transition: 'width 200ms cubic-bezier(0.25,0,0,1)', zIndex: 95,
        borderRight: '1px solid rgba(255,255,255,0.06)',
      }}>
        {/* Logo */}
        <div style={{
          height: 64, display: 'flex', alignItems: 'center', gap: 10,
          padding: collapsed ? '0 16px' : '0 20px', flexShrink: 0,
          borderBottom: '1px solid rgba(255,255,255,0.06)',
        }}>
          <div style={{
            width: 36, height: 36, borderRadius: 9, flexShrink: 0,
            background: `linear-gradient(125deg, ${DS.aiFrom}, ${DS.aiTo})`,
            display: 'flex', alignItems: 'center', justifyContent: 'center',
            fontFamily: DS.fontUI, fontWeight: 800, fontSize: 19, color: '#fff',
            boxShadow: '0 2px 10px rgba(120,79,224,0.4)',
          }}>d</div>
          {!collapsed && (
            <div style={{ overflow: 'hidden' }}>
              <div style={{ fontFamily: DS.fontUI, fontWeight: 700, fontSize: 16, color: '#fff', letterSpacing: '-0.01em', lineHeight: 1.1 }}>debesties</div>
              <div style={{ fontFamily: DS.fontUI, fontSize: 10.5, color: 'rgba(255,255,255,0.4)', letterSpacing: '0.08em', textTransform: 'uppercase', fontWeight: 600 }}>Studio</div>
            </div>
          )}
        </div>

        {/* Nav */}
        <nav style={{ flex: 1, overflowY: 'auto', padding: '14px 12px', display: 'flex', flexDirection: 'column', gap: 4 }} className="cms-nav-scroll">
          {NAV_ITEMS.map(group => (
            <div key={group.group} style={{ marginBottom: 10 }}>
              {!collapsed && (
                <div style={{ fontFamily: DS.fontUI, fontSize: 10.5, fontWeight: 700, letterSpacing: '0.1em', textTransform: 'uppercase', color: 'rgba(255,255,255,0.32)', padding: '6px 10px 4px' }}>{group.group}</div>
              )}
              {group.items.map(item => {
                const on = active === item.key;
                return (
                  <button key={item.key} onClick={() => { onNavigate(item.key); onCloseMobile && onCloseMobile(); }}
                    title={collapsed ? item.label : undefined}
                    style={{
                      display: 'flex', alignItems: 'center', gap: 11, width: '100%',
                      padding: collapsed ? '10px' : '9px 10px', justifyContent: collapsed ? 'center' : 'flex-start',
                      border: 'none', borderRadius: DS.rMd, cursor: 'pointer', marginBottom: 1,
                      background: on ? 'rgba(232,168,0,0.14)' : 'transparent',
                      color: on ? accent : 'rgba(255,255,255,0.66)',
                      fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: on ? 600 : 500,
                      transition: 'background 140ms, color 140ms', position: 'relative',
                    }}
                    onMouseEnter={e => { if (!on) { e.currentTarget.style.background = 'rgba(255,255,255,0.05)'; e.currentTarget.style.color = 'rgba(255,255,255,0.92)'; } }}
                    onMouseLeave={e => { if (!on) { e.currentTarget.style.background = 'transparent'; e.currentTarget.style.color = 'rgba(255,255,255,0.66)'; } }}>
                    {on && !collapsed && <span style={{ position: 'absolute', left: -12, top: 8, bottom: 8, width: 3, borderRadius: 999, background: accent }}></span>}
                    <Icon name={item.icon} size={18} stroke={2} />
                    {!collapsed && <span style={{ flex: 1, textAlign: 'left' }}>{item.label}</span>}
                    {!collapsed && item.count != null && (
                      <span style={{ fontFamily: DS.fontUI, fontSize: 11, fontWeight: 700, color: on ? accent : 'rgba(255,255,255,0.4)', background: 'rgba(255,255,255,0.06)', padding: '1px 7px', borderRadius: 999 }}>{item.count}</span>
                    )}
                    {!collapsed && item.badge && (
                      <span style={{ fontFamily: DS.fontUI, fontSize: 9.5, fontWeight: 800, letterSpacing: '0.05em', color: '#fff', background: `linear-gradient(120deg,${DS.aiFrom},${DS.aiTo})`, padding: '2px 6px', borderRadius: 999 }}>{item.badge}</span>
                    )}
                  </button>
                );
              })}
            </div>
          ))}
        </nav>

        {/* User footer */}
        <div style={{ padding: 12, borderTop: '1px solid rgba(255,255,255,0.06)', flexShrink: 0 }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: 10, padding: collapsed ? 0 : '8px 8px', justifyContent: collapsed ? 'center' : 'flex-start', borderRadius: DS.rMd, cursor: 'pointer' }}
            onMouseEnter={e => e.currentTarget.style.background = 'rgba(255,255,255,0.05)'}
            onMouseLeave={e => e.currentTarget.style.background = 'transparent'}>
            <Avatar name="Ama Boateng" size={34} />
            {!collapsed && (
              <div style={{ flex: 1, overflow: 'hidden' }}>
                <div style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: '#fff', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>Ama Boateng</div>
                <div style={{ fontFamily: DS.fontUI, fontSize: 11, color: 'rgba(255,255,255,0.4)' }}>Admin</div>
              </div>
            )}
            {!collapsed && <Icon name="chevron-down" size={15} color="rgba(255,255,255,0.4)" />}
          </div>
        </div>
      </aside>
    </>
  );
}

function Topbar({ title, onToggleSidebar, onMobileMenu, onNewPost, accent }) {
  const [notifOpen, setNotifOpen] = React.useState(false);
  return (
    <header style={{
      height: 64, background: 'rgba(244,241,236,0.85)', backdropFilter: 'blur(12px)',
      WebkitBackdropFilter: 'blur(12px)', borderBottom: `1px solid ${DS.border}`,
      display: 'flex', alignItems: 'center', justifyContent: 'space-between',
      padding: '0 24px', gap: 16, position: 'sticky', top: 0, zIndex: 80, flexShrink: 0,
    }}>
      <div style={{ display: 'flex', alignItems: 'center', gap: 12, minWidth: 0 }}>
        <button onClick={onToggleSidebar} className="cms-desktop-only" style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg3, display: 'flex', padding: 6, borderRadius: 8 }} title="Toggle sidebar">
          <Icon name="panel-left" size={20} />
        </button>
        <button onClick={onMobileMenu} className="cms-mobile-only" style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg2, display: 'none', padding: 6 }}>
          <Icon name="menu" size={22} />
        </button>
        <div style={{ minWidth: 0 }}>
          <h1 style={{ fontFamily: DS.fontDisp, fontSize: 21, fontWeight: 700, color: DS.fg1, margin: 0, letterSpacing: '-0.01em', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{title}</h1>
        </div>
      </div>

      <div style={{ display: 'flex', alignItems: 'center', gap: 10 }}>
        <div className="cms-search-hide">
          <SearchInput value="" onChange={() => {}} placeholder="Search posts, media…" width={240} />
        </div>
        <div style={{ position: 'relative' }}>
          <button onClick={() => setNotifOpen(o => !o)} style={{ border: `1.5px solid ${DS.border}`, background: DS.surface, cursor: 'pointer', color: DS.fg2, display: 'flex', padding: 9, borderRadius: DS.rMd, position: 'relative' }} title="Notifications">
            <Icon name="bell" size={18} />
            <span style={{ position: 'absolute', top: 6, right: 7, width: 7, height: 7, borderRadius: 999, background: DS.red, border: '1.5px solid ' + DS.surface }}></span>
          </button>
          {notifOpen && (
            <div style={{ position: 'absolute', top: 48, right: 0, width: 300, background: DS.surface, borderRadius: DS.rLg, boxShadow: DS.shPop, border: `1px solid ${DS.border}`, zIndex: 100, overflow: 'hidden', animation: 'dsPop 180ms ease' }}>
              <div style={{ padding: '12px 16px', borderBottom: `1px solid ${DS.border}`, fontFamily: DS.fontUI, fontWeight: 700, fontSize: 13.5, color: DS.fg1 }}>Notifications</div>
              {[
                { t: 'Yaw submitted a post for review', s: '3h ago', tone: 'review' },
                { t: 'V.I.P article flagged for content decay', s: '1d ago', tone: 'decay' },
                { t: '12 new comments awaiting moderation', s: '1d ago', tone: 'neutral' },
              ].map((n, i) => (
                <div key={i} style={{ padding: '11px 16px', borderBottom: i < 2 ? `1px solid ${DS.border}` : 'none', display: 'flex', gap: 10, cursor: 'pointer' }}
                  onMouseEnter={e => e.currentTarget.style.background = '#FBF9F5'} onMouseLeave={e => e.currentTarget.style.background = 'transparent'}>
                  <span style={{ width: 7, height: 7, borderRadius: 999, background: BADGE_TONES[n.tone].dot, marginTop: 5, flexShrink: 0 }}></span>
                  <div><div style={{ fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg1, lineHeight: 1.4 }}>{n.t}</div><div style={{ fontFamily: DS.fontUI, fontSize: 11, color: DS.fg4, marginTop: 2 }}>{n.s}</div></div>
                </div>
              ))}
            </div>
          )}
        </div>
        <div className="cms-newpost-hide">
          <Btn variant="primary" icon="plus" onClick={onNewPost}>New Post</Btn>
        </div>
      </div>
    </header>
  );
}

Object.assign(window, { Sidebar, Topbar });
