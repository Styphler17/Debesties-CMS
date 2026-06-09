// Debesties CMS — Posts List View
// Exports to window: PostsList

function PostsList({ onNavigate, onEditPost, onNewPost, accent }) {
  const [search, setSearch] = React.useState('');
  const [statusFilter, setStatusFilter] = React.useState('all');
  const [selected, setSelected] = React.useState([]);
  const [menuOpen, setMenuOpen] = React.useState(null);
  const [catFilter, setCatFilter] = React.useState('All categories');
  const [catOpen, setCatOpen] = React.useState(false);

  const counts = {
    all: POSTS.length,
    published: POSTS.filter(p => p.status === 'published').length,
    draft: POSTS.filter(p => p.status === 'draft').length,
    review: POSTS.filter(p => p.status === 'review').length,
    scheduled: POSTS.filter(p => p.status === 'scheduled').length,
  };

  const filtered = POSTS.filter(p => {
    if (statusFilter !== 'all' && p.status !== statusFilter) return false;
    if (catFilter !== 'All categories' && p.category !== catFilter) return false;
    if (search && !p.title.toLowerCase().includes(search.toLowerCase()) && !p.author.toLowerCase().includes(search.toLowerCase())) return false;
    return true;
  });

  const allSel = filtered.length > 0 && filtered.every(p => selected.includes(p.id));
  const toggleAll = () => setSelected(allSel ? [] : filtered.map(p => p.id));
  const toggleOne = (id) => setSelected(s => s.includes(id) ? s.filter(x => x !== id) : [...s, id]);

  const cats = ['All categories', ...Array.from(new Set(POSTS.map(p => p.category)))];

  const Check = ({ on, onClick }) => (
    <button onClick={onClick} style={{
      width: 18, height: 18, borderRadius: 5, flexShrink: 0, cursor: 'pointer',
      border: `1.5px solid ${on ? DS.gold : DS.borderSt}`, background: on ? DS.gold : DS.surface,
      display: 'flex', alignItems: 'center', justifyContent: 'center', padding: 0, transition: 'all 120ms',
    }}>{on && <Icon name="check" size={12} color="#1A1410" stroke={3} />}</button>
  );

  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
      {/* Toolbar */}
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: 14, flexWrap: 'wrap' }}>
        <SegTabs
          tabs={[
            { value: 'all', label: 'All', count: counts.all },
            { value: 'published', label: 'Published', count: counts.published },
            { value: 'draft', label: 'Drafts', count: counts.draft },
            { value: 'review', label: 'In Review', count: counts.review },
            { value: 'scheduled', label: 'Scheduled', count: counts.scheduled },
          ]}
          active={statusFilter} onChange={setStatusFilter} />
        <div style={{ display: 'flex', gap: 10, alignItems: 'center', flexWrap: 'wrap' }}>
          <SearchInput value={search} onChange={setSearch} placeholder="Search title or author…" width={240} />
          <div style={{ position: 'relative' }}>
            <Btn variant="soft" icon="filter" iconRight="chevron-down" onClick={() => setCatOpen(o => !o)}>{catFilter === 'All categories' ? 'Category' : catFilter}</Btn>
            {catOpen && (
              <div style={{ position: 'absolute', top: 44, right: 0, width: 200, background: DS.surface, borderRadius: DS.rMd, boxShadow: DS.shPop, border: `1px solid ${DS.border}`, zIndex: 50, padding: 6, animation: 'dsPop 160ms ease' }}>
                {cats.map(c => (
                  <button key={c} onClick={() => { setCatFilter(c); setCatOpen(false); }} style={{ display: 'block', width: '100%', textAlign: 'left', padding: '8px 10px', border: 'none', background: catFilter === c ? DS.goldSoft : 'transparent', borderRadius: 6, cursor: 'pointer', fontFamily: DS.fontUI, fontSize: 13, fontWeight: catFilter === c ? 600 : 500, color: DS.fg1 }}
                    onMouseEnter={e => { if (catFilter !== c) e.currentTarget.style.background = '#FBF9F5'; }} onMouseLeave={e => { if (catFilter !== c) e.currentTarget.style.background = 'transparent'; }}>{c}</button>
                ))}
              </div>
            )}
          </div>
          <Btn variant="primary" icon="plus" onClick={onNewPost}>New Post</Btn>
        </div>
      </div>

      {/* Bulk action bar */}
      {selected.length > 0 && (
        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', padding: '10px 16px', background: DS.fg1, borderRadius: DS.rMd, animation: 'dsFade 160ms ease' }}>
          <span style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: '#fff' }}>{selected.length} selected</span>
          <div style={{ display: 'flex', gap: 8 }}>
            <Btn variant="ghost" size="sm" icon="check" style={{ color: '#fff', borderColor: 'rgba(255,255,255,0.25)' }}>Publish</Btn>
            <Btn variant="ghost" size="sm" icon="tag" style={{ color: '#fff', borderColor: 'rgba(255,255,255,0.25)' }}>Add tag</Btn>
            <Btn variant="ghost" size="sm" icon="trash" style={{ color: '#fff', borderColor: 'rgba(255,255,255,0.25)' }}>Delete</Btn>
            <Btn variant="ghost" size="sm" onClick={() => setSelected([])} style={{ color: 'rgba(255,255,255,0.6)', borderColor: 'transparent' }}>Clear</Btn>
          </div>
        </div>
      )}

      {/* Table */}
      <Card pad={0} style={{ overflow: 'visible' }}>
        <div style={{ overflowX: 'auto' }}>
          <table style={{ width: '100%', borderCollapse: 'collapse', minWidth: 880 }}>
            <thead>
              <tr style={{ borderBottom: `1px solid ${DS.border}`, background: '#FBF9F5' }}>
                <th style={{ padding: '12px 16px', width: 40 }}><Check on={allSel} onClick={toggleAll} /></th>
                {['Article', 'Status', 'Author', 'Category', 'SEO', 'Views', 'Updated', ''].map((h, i) => (
                  <th key={i} style={{ padding: '12px 14px', textAlign: i >= 4 && i <= 5 ? 'right' : 'left', fontFamily: DS.fontUI, fontSize: 11, fontWeight: 700, letterSpacing: '0.06em', textTransform: 'uppercase', color: DS.fg4, whiteSpace: 'nowrap' }}>{h}</th>
                ))}
              </tr>
            </thead>
            <tbody>
              {filtered.map(p => {
                const sel = selected.includes(p.id);
                return (
                  <tr key={p.id} style={{ borderBottom: `1px solid ${DS.border}`, background: sel ? DS.goldSoft + '88' : 'transparent', transition: 'background 120ms' }}
                    onMouseEnter={e => { if (!sel) e.currentTarget.style.background = '#FBF9F5'; }} onMouseLeave={e => { if (!sel) e.currentTarget.style.background = 'transparent'; }}>
                    <td style={{ padding: '12px 16px' }}><Check on={sel} onClick={() => toggleOne(p.id)} /></td>
                    <td style={{ padding: '12px 14px' }}>
                      <div style={{ display: 'flex', alignItems: 'center', gap: 12, cursor: 'pointer', maxWidth: 360 }} onClick={() => onEditPost(p)}>
                        <div style={{ width: 52, height: 38, borderRadius: 7, background: p.grad, flexShrink: 0, display: 'flex', alignItems: 'center', justifyContent: 'center', position: 'relative' }}>
                          {p.featured && <span style={{ position: 'absolute', top: -5, right: -5, width: 18, height: 18, borderRadius: 999, background: DS.gold, display: 'flex', alignItems: 'center', justifyContent: 'center' }}><Icon name="star" size={10} color="#1A1410" fill="#1A1410" /></span>}
                          <Icon name="image" size={15} color="rgba(255,255,255,0.5)" />
                        </div>
                        <div style={{ minWidth: 0 }}>
                          <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1, lineHeight: 1.3, overflow: 'hidden', textOverflow: 'ellipsis', display: '-webkit-box', WebkitLineClamp: 1, WebkitBoxOrient: 'vertical' }}>{p.title}</div>
                          <div style={{ fontFamily: DS.fontMono, fontSize: 11, color: DS.fg4, marginTop: 2, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>/{p.slug}</div>
                        </div>
                      </div>
                    </td>
                    <td style={{ padding: '12px 14px' }}><Badge tone={p.status}>{p.status === 'review' ? 'In Review' : p.status}</Badge></td>
                    <td style={{ padding: '12px 14px' }}>
                      <div style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
                        <Avatar name={p.author} size={26} />
                        <span style={{ fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg2, whiteSpace: 'nowrap' }}>{p.author}</span>
                      </div>
                    </td>
                    <td style={{ padding: '12px 14px' }}><span style={{ fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg2, whiteSpace: 'nowrap' }}>{p.category}</span></td>
                    <td style={{ padding: '12px 14px' }}><div style={{ display: 'flex', justifyContent: 'flex-end' }}><ScoreRing score={p.seo} size={34} stroke={3.5} label={`SEO score ${p.seo}`} /></div></td>
                    <td style={{ padding: '12px 14px', textAlign: 'right', fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: p.views ? DS.fg1 : DS.fg4, whiteSpace: 'nowrap' }}>{p.views ? (p.views >= 1000 ? (p.views/1000).toFixed(1) + 'K' : p.views) : '—'}</td>
                    <td style={{ padding: '12px 14px', fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3, whiteSpace: 'nowrap' }}>{p.updated}</td>
                    <td style={{ padding: '12px 14px', position: 'relative' }}>
                      <button onClick={() => setMenuOpen(menuOpen === p.id ? null : p.id)} style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg3, padding: 5, borderRadius: 6, display: 'flex' }}
                        onMouseEnter={e => e.currentTarget.style.background = '#EFEBE3'} onMouseLeave={e => e.currentTarget.style.background = 'transparent'}>
                        <Icon name="more-horizontal" size={18} />
                      </button>
                      {menuOpen === p.id && (
                        <>
                          <div onClick={() => setMenuOpen(null)} style={{ position: 'fixed', inset: 0, zIndex: 40 }} />
                          <div style={{ position: 'absolute', top: 36, right: 14, width: 168, background: DS.surface, borderRadius: DS.rMd, boxShadow: DS.shPop, border: `1px solid ${DS.border}`, zIndex: 50, padding: 5, animation: 'dsPop 150ms ease' }}>
                            {[
                              { l: 'Edit', i: 'edit', a: () => onEditPost(p) },
                              { l: 'View live', i: 'external-link' },
                              { l: 'Duplicate', i: 'copy' },
                              { l: 'Delete', i: 'trash', danger: true },
                            ].map(m => (
                              <button key={m.l} onClick={() => { m.a && m.a(); setMenuOpen(null); }} style={{ display: 'flex', alignItems: 'center', gap: 9, width: '100%', textAlign: 'left', padding: '8px 10px', border: 'none', background: 'transparent', borderRadius: 6, cursor: 'pointer', fontFamily: DS.fontUI, fontSize: 13, fontWeight: 500, color: m.danger ? DS.red : DS.fg1 }}
                                onMouseEnter={e => e.currentTarget.style.background = m.danger ? DS.redSoft : '#FBF9F5'} onMouseLeave={e => e.currentTarget.style.background = 'transparent'}>
                                <Icon name={m.i} size={15} stroke={2} />{m.l}
                              </button>
                            ))}
                          </div>
                        </>
                      )}
                    </td>
                  </tr>
                );
              })}
            </tbody>
          </table>
        </div>
        {filtered.length === 0 && (
          <EmptyState icon="search" title="No posts found" body="Try adjusting your search or filters to find what you're looking for."
            action={<Btn variant="soft" onClick={() => { setSearch(''); setStatusFilter('all'); setCatFilter('All categories'); }}>Clear filters</Btn>} />
        )}
        {filtered.length > 0 && (
          <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', padding: '14px 20px', borderTop: `1px solid ${DS.border}` }}>
            <span style={{ fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg3 }}>Showing <b style={{ color: DS.fg1 }}>{filtered.length}</b> of {POSTS.length} posts</span>
            <div style={{ display: 'flex', gap: 6 }}>
              <Btn variant="soft" size="sm" icon="chevron-left" disabled>Prev</Btn>
              <Btn variant="soft" size="sm" iconRight="chevron-right">Next</Btn>
            </div>
          </div>
        )}
      </Card>
    </div>
  );
}

Object.assign(window, { PostsList });
