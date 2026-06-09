// Debesties CMS — Editorial Calendar + Content Views
// Exports to window: Calendar, Pages, MediaLibrary, Categories, Tags, Comments

/* ── PAGES ─────────────────────────────────────────────── */
function Pages({ onEditPost, onNewPost, accent }) {
  const [search, setSearch] = React.useState('');
  const [statusFilter, setStatusFilter] = React.useState('all');
  const [nav, setNav] = React.useState(() => Object.fromEntries(PAGES.map(p => [p.id, p.inNav])));
  const [menuOpen, setMenuOpen] = React.useState(null);

  const counts = { all: PAGES.length, published: PAGES.filter(p => p.status === 'published').length, draft: PAGES.filter(p => p.status === 'draft').length, scheduled: PAGES.filter(p => p.status === 'scheduled').length };
  const filtered = PAGES.filter(p => {
    if (statusFilter !== 'all' && p.status !== statusFilter) return false;
    if (search && !p.title.toLowerCase().includes(search.toLowerCase())) return false;
    return true;
  });
  const tplTone = { Standard: '#7A7163', Legal: '#7A7163', 'Contact form': '#2F6BD8', Landing: '#E8A800', Timeline: '#1A8A4B', 'Team grid': '#B14FD8' };

  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
      {/* Toolbar */}
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: 14, flexWrap: 'wrap' }}>
        <SegTabs
          tabs={[
            { value: 'all', label: 'All', count: counts.all },
            { value: 'published', label: 'Published', count: counts.published },
            { value: 'draft', label: 'Drafts', count: counts.draft },
            { value: 'scheduled', label: 'Scheduled', count: counts.scheduled },
          ]}
          active={statusFilter} onChange={setStatusFilter} />
        <div style={{ display: 'flex', gap: 10, alignItems: 'center', flexWrap: 'wrap' }}>
          <SearchInput value={search} onChange={setSearch} placeholder="Search pages…" width={220} />
          <Btn variant="primary" icon="plus" onClick={onNewPost}>New Page</Btn>
        </div>
      </div>

      <Card pad={0} style={{ overflow: 'visible' }}>
        <div style={{ overflowX: 'auto' }}>
          <table style={{ width: '100%', borderCollapse: 'collapse', minWidth: 760 }}>
            <thead>
              <tr style={{ borderBottom: `1px solid ${DS.border}`, background: '#FBF9F5' }}>
                {['Page', 'Status', 'Template', 'In Menu', 'Views', 'Updated', ''].map((h, i) => (
                  <th key={i} style={{ padding: '12px 16px', textAlign: i === 4 ? 'right' : 'left', fontFamily: DS.fontUI, fontSize: 11, fontWeight: 700, letterSpacing: '0.06em', textTransform: 'uppercase', color: DS.fg4, whiteSpace: 'nowrap' }}>{h}</th>
                ))}
              </tr>
            </thead>
            <tbody>
              {filtered.map(p => (
                <tr key={p.id} style={{ borderBottom: `1px solid ${DS.border}` }}
                  onMouseEnter={e => e.currentTarget.style.background = '#FBF9F5'} onMouseLeave={e => e.currentTarget.style.background = 'transparent'}>
                  <td style={{ padding: '12px 16px' }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: 12, cursor: 'pointer', maxWidth: 340 }} onClick={() => onEditPost && onEditPost(null)}>
                      <div style={{ width: 34, height: 34, borderRadius: 8, background: '#EFEBE3', flexShrink: 0, display: 'flex', alignItems: 'center', justifyContent: 'center', color: DS.fg3 }}><Icon name="book-open" size={16} stroke={2} /></div>
                      <div style={{ minWidth: 0 }}>
                        <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{p.title}</div>
                        <div style={{ fontFamily: DS.fontMono, fontSize: 11, color: DS.fg4, marginTop: 2 }}>debesties.com/{p.slug}</div>
                      </div>
                    </div>
                  </td>
                  <td style={{ padding: '12px 16px' }}><Badge tone={p.status}>{p.status}</Badge></td>
                  <td style={{ padding: '12px 16px' }}><span style={{ display: 'inline-flex', alignItems: 'center', gap: 6, fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg2, whiteSpace: 'nowrap' }}><span style={{ width: 7, height: 7, borderRadius: 999, background: tplTone[p.template] || DS.fg4 }}></span>{p.template}</span></td>
                  <td style={{ padding: '12px 16px' }}><Toggle on={nav[p.id]} onChange={() => setNav(n => ({ ...n, [p.id]: !n[p.id] }))} size="sm" /></td>
                  <td style={{ padding: '12px 16px', textAlign: 'right', fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: p.views ? DS.fg1 : DS.fg4 }}>{p.views ? (p.views >= 1000 ? (p.views / 1000).toFixed(1) + 'K' : p.views) : '—'}</td>
                  <td style={{ padding: '12px 16px', fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3, whiteSpace: 'nowrap' }}>{p.updated}</td>
                  <td style={{ padding: '12px 16px', position: 'relative' }}>
                    <button onClick={() => setMenuOpen(menuOpen === p.id ? null : p.id)} style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg3, padding: 5, borderRadius: 6, display: 'flex' }}
                      onMouseEnter={e => e.currentTarget.style.background = '#EFEBE3'} onMouseLeave={e => e.currentTarget.style.background = 'transparent'}>
                      <Icon name="more-horizontal" size={18} />
                    </button>
                    {menuOpen === p.id && (
                      <>
                        <div onClick={() => setMenuOpen(null)} style={{ position: 'fixed', inset: 0, zIndex: 40 }} />
                        <div style={{ position: 'absolute', top: 36, right: 14, width: 160, background: DS.surface, borderRadius: DS.rMd, boxShadow: DS.shPop, border: `1px solid ${DS.border}`, zIndex: 50, padding: 5, animation: 'dsPop 150ms ease' }}>
                          {[{ l: 'Edit', i: 'edit', a: () => onEditPost && onEditPost(null) }, { l: 'View live', i: 'external-link' }, { l: 'Duplicate', i: 'copy' }, { l: 'Delete', i: 'trash', danger: true }].map(m => (
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
              ))}
            </tbody>
          </table>
        </div>
        {filtered.length === 0 && (
          <EmptyState icon="book-open" title="No pages found" body="Static pages like About, Contact, and Privacy Policy live here — separate from your blog posts."
            action={<Btn variant="soft" onClick={() => { setSearch(''); setStatusFilter('all'); }}>Clear filters</Btn>} />
        )}
      </Card>
    </div>
  );
}

/* ── EDITORIAL CALENDAR ────────────────────────────────── */
function Calendar({ onEditPost, accent }) {
  const [view, setView] = React.useState('month');
  // June 2026 starts on Monday
  const days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
  const sched = {
    3: [{ t: 'Highlife Roots Explainer', tone: 'draft', a: 'Esi' }],
    9: [{ t: 'Weekly TGMA Recap', tone: 'published', a: 'Ama' }],
    12: [{ t: 'TGMA 2026: Full Winners List', tone: 'scheduled', a: 'Ama' }, { t: 'Sarkodie Feature', tone: 'review', a: 'Yaw' }],
    16: [{ t: 'Stonebwoy Cover Story', tone: 'draft', a: 'Kwesi' }],
    19: [{ t: 'Mid-Year Music Report', tone: 'scheduled', a: 'Ama' }],
    23: [{ t: 'Black Sherif Interview', tone: 'review', a: 'Yaw' }],
    26: [{ t: 'Afrobeats vs Drill Debate', tone: 'draft', a: 'Esi' }],
    30: [{ t: 'June Wrap-up', tone: 'scheduled', a: 'Kwesi' }],
  };
  const firstDay = 0; // Monday index for June 1, 2026 (Mon)
  const daysInMonth = 30;
  const cells = [];
  for (let i = 0; i < firstDay; i++) cells.push(null);
  for (let d = 1; d <= daysInMonth; d++) cells.push(d);

  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 18 }}>
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', flexWrap: 'wrap', gap: 12 }}>
        <div style={{ display: 'flex', alignItems: 'center', gap: 12 }}>
          <div style={{ display: 'flex', gap: 4 }}>
            <Btn variant="soft" size="sm" icon="chevron-left" style={{ padding: '6px 10px' }}>{''}</Btn>
            <Btn variant="soft" size="sm" iconRight="chevron-right" style={{ padding: '6px 10px' }}>{''}</Btn>
          </div>
          <span style={{ fontFamily: DS.fontDisp, fontSize: 20, fontWeight: 700, color: DS.fg1 }}>June 2026</span>
          <Btn variant="ghost" size="sm">Today</Btn>
        </div>
        <div style={{ display: 'flex', gap: 10, alignItems: 'center' }}>
          <SegTabs tabs={[{value:'month',label:'Month'},{value:'week',label:'Week'},{value:'list',label:'List'}]} active={view} onChange={setView} size="sm" />
          <Btn variant="primary" size="md" icon="plus">Schedule</Btn>
        </div>
      </div>

      {/* Legend */}
      <div style={{ display: 'flex', gap: 16, flexWrap: 'wrap' }}>
        {[['Draft','draft'],['In Review','review'],['Scheduled','scheduled'],['Published','published']].map(([l, tone]) => (
          <div key={l} style={{ display: 'flex', alignItems: 'center', gap: 6 }}>
            <span style={{ width: 9, height: 9, borderRadius: 3, background: BADGE_TONES[tone].dot }}></span>
            <span style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3 }}>{l}</span>
          </div>
        ))}
      </div>

      <Card pad={0} style={{ overflow: 'hidden' }}>
        {/* Day headers */}
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(7,1fr)', borderBottom: `1px solid ${DS.border}`, background: '#FBF9F5' }}>
          {days.map(d => <div key={d} style={{ padding: '11px 14px', fontFamily: DS.fontUI, fontSize: 11.5, fontWeight: 700, letterSpacing: '0.05em', textTransform: 'uppercase', color: DS.fg4, textAlign: 'left' }}>{d}</div>)}
        </div>
        {/* Grid */}
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(7,1fr)' }}>
          {cells.map((d, i) => {
            const events = d ? (sched[d] || []) : [];
            const isToday = d === 9;
            return (
              <div key={i} style={{ minHeight: 116, borderRight: (i + 1) % 7 !== 0 ? `1px solid ${DS.border}` : 'none', borderBottom: `1px solid ${DS.border}`, padding: 8, background: d ? (isToday ? DS.goldSoft + '66' : DS.surface) : '#FBF9F5', display: 'flex', flexDirection: 'column', gap: 5 }}>
                {d && (
                  <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                    <span style={{ fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: isToday ? 700 : 500, color: isToday ? DS.goldDeep : DS.fg3, width: 22, height: 22, display: 'flex', alignItems: 'center', justifyContent: 'center', borderRadius: 999, background: isToday ? DS.gold : 'transparent' }}>{d}</span>
                  </div>
                )}
                {events.map((e, j) => (
                  <div key={j} onClick={() => onEditPost && onEditPost(null)} style={{ cursor: 'pointer', padding: '5px 7px', borderRadius: 6, background: BADGE_TONES[e.tone].bg, borderLeft: `2.5px solid ${BADGE_TONES[e.tone].dot}` }}>
                    <div style={{ fontFamily: DS.fontUI, fontSize: 11, fontWeight: 600, color: BADGE_TONES[e.tone].fg, lineHeight: 1.25, overflow: 'hidden', textOverflow: 'ellipsis', display: '-webkit-box', WebkitLineClamp: 2, WebkitBoxOrient: 'vertical' }}>{e.t}</div>
                  </div>
                ))}
              </div>
            );
          })}
        </div>
      </Card>
    </div>
  );
}

/* ── MEDIA LIBRARY ─────────────────────────────────────── */
function MediaLibrary({ accent }) {
  const [sel, setSel] = React.useState(null);
  const [search, setSearch] = React.useState('');
  const filtered = MEDIA.filter(m => m.name.toLowerCase().includes(search.toLowerCase()));
  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 18 }}>
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: 12, flexWrap: 'wrap' }}>
        <div style={{ display: 'flex', gap: 10, alignItems: 'center' }}>
          <SearchInput value={search} onChange={setSearch} placeholder="Search media…" width={240} />
          <Btn variant="soft" icon="filter" iconRight="chevron-down">All types</Btn>
        </div>
        <Btn variant="primary" icon="upload">Upload media</Btn>
      </div>

      {/* Upload dropzone */}
      <div style={{ border: `2px dashed ${DS.borderSt}`, borderRadius: DS.rLg, padding: '28px', display: 'flex', flexDirection: 'column', alignItems: 'center', gap: 8, background: '#FBF9F5', cursor: 'pointer' }}
        onMouseEnter={e => { e.currentTarget.style.borderColor = DS.gold; e.currentTarget.style.background = DS.goldSoft + '55'; }}
        onMouseLeave={e => { e.currentTarget.style.borderColor = DS.borderSt; e.currentTarget.style.background = '#FBF9F5'; }}>
        <div style={{ width: 44, height: 44, borderRadius: 999, background: DS.surface, border: `1px solid ${DS.border}`, display: 'flex', alignItems: 'center', justifyContent: 'center', color: DS.fg3 }}><Icon name="upload" size={20} /></div>
        <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1 }}>Drop files or <span style={{ color: accent }}>browse</span></div>
        <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg4 }}>JPG, PNG, WebP, MP4 · up to 50MB</div>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(150px, 1fr))', gap: 14 }}>
        {filtered.map(m => (
          <div key={m.id} onClick={() => setSel(m)} style={{ borderRadius: DS.rMd, overflow: 'hidden', border: `2px solid ${sel?.id === m.id ? DS.gold : 'transparent'}`, cursor: 'pointer', background: DS.surface, boxShadow: DS.shCard, transition: 'border-color 140ms' }}>
            <div style={{ aspectRatio: '1', background: m.grad, position: 'relative', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
              <Icon name="image" size={22} color="rgba(255,255,255,0.5)" />
              <span style={{ position: 'absolute', top: 7, right: 7, fontFamily: DS.fontMono, fontSize: 9, fontWeight: 700, color: '#fff', background: 'rgba(0,0,0,0.4)', padding: '2px 6px', borderRadius: 4 }}>{m.type}</span>
            </div>
            <div style={{ padding: '8px 10px' }}>
              <div style={{ fontFamily: DS.fontUI, fontSize: 12, fontWeight: 600, color: DS.fg1, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{m.name}</div>
              <div style={{ fontFamily: DS.fontUI, fontSize: 11, color: DS.fg4, marginTop: 1 }}>{m.dims} · {m.size}</div>
            </div>
          </div>
        ))}
      </div>

      {/* Detail drawer */}
      {sel && (
        <Modal open={!!sel} onClose={() => setSel(null)} title={sel.name} width={440}
          footer={<><Btn variant="ghost" icon="trash" style={{ color: DS.red, borderColor: DS.redSoft }}>Delete</Btn><Btn variant="primary" icon="copy">Copy URL</Btn></>}>
          <div style={{ aspectRatio: '16/9', background: sel.grad, borderRadius: DS.rMd, marginBottom: 16, display: 'flex', alignItems: 'center', justifyContent: 'center' }}><Icon name="image" size={32} color="rgba(255,255,255,0.5)" /></div>
          <div style={{ display: 'flex', flexDirection: 'column', gap: 12 }}>
            <Field label="Alt text" value={sel.name.replace('.jpg','').replace('.png','').replace(/-/g,' ')} hint="Describe the image for SEO & accessibility." />
            {[['Dimensions', sel.dims],['File size', sel.size],['Type', sel.type],['Uploaded', 'Jun 2, 2026']].map(([k, v]) => (
              <div key={k} style={{ display: 'flex', justifyContent: 'space-between', fontFamily: DS.fontUI, fontSize: 13 }}><span style={{ color: DS.fg3 }}>{k}</span><span style={{ color: DS.fg1, fontWeight: 600 }}>{v}</span></div>
            ))}
          </div>
        </Modal>
      )}
    </div>
  );
}

/* ── CATEGORIES ────────────────────────────────────────── */
function Categories({ accent }) {
  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 18 }}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', flexWrap: 'wrap', gap: 12 }}>
        <span style={{ fontFamily: DS.fontUI, fontSize: 13.5, color: DS.fg3 }}>{CATEGORIES.length} categories · {CATEGORIES.reduce((a, c) => a + c.posts, 0)} posts organized</span>
        <Btn variant="primary" icon="plus">New category</Btn>
      </div>
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(280px, 1fr))', gap: 14 }}>
        {CATEGORIES.map(c => (
          <Card key={c.slug} hover>
            <div style={{ display: 'flex', alignItems: 'flex-start', gap: 12 }}>
              <div style={{ width: 40, height: 40, borderRadius: DS.rMd, background: `${c.color}1A`, color: c.color, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}><Icon name="folder" size={20} stroke={2} /></div>
              <div style={{ flex: 1, minWidth: 0 }}>
                <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                  <span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>{c.name}</span>
                  <button style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg4, display: 'flex' }}><Icon name="more-horizontal" size={17} /></button>
                </div>
                <div style={{ fontFamily: DS.fontMono, fontSize: 11, color: DS.fg4, marginTop: 2 }}>/{c.slug}</div>
                <div style={{ fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg3, marginTop: 8, lineHeight: 1.5 }}>{c.desc}</div>
                <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginTop: 12 }}>
                  <Badge tone="neutral" dot={false}>{c.posts} posts</Badge>
                  <span style={{ fontFamily: DS.fontUI, fontSize: 12, fontWeight: 600, color: accent, cursor: 'pointer' }}>Edit</span>
                </div>
              </div>
            </div>
          </Card>
        ))}
      </div>
    </div>
  );
}

/* ── TAGS ──────────────────────────────────────────────── */
function Tags({ accent }) {
  const [search, setSearch] = React.useState('');
  const filtered = TAGS.filter(t => t.name.toLowerCase().includes(search.toLowerCase()));
  const max = Math.max(...TAGS.map(t => t.count));
  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 18 }}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', flexWrap: 'wrap', gap: 12 }}>
        <SearchInput value={search} onChange={setSearch} placeholder="Search tags…" width={240} />
        <Btn variant="primary" icon="plus">New tag</Btn>
      </div>
      <Card>
        <div style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 700, color: DS.fg2, marginBottom: 14 }}>Tag Cloud</div>
        <div style={{ display: 'flex', flexWrap: 'wrap', gap: 10 }}>
          {filtered.map(t => {
            const scale = 0.85 + (t.count / max) * 0.7;
            return (
              <span key={t.name} style={{ display: 'inline-flex', alignItems: 'center', gap: 7, padding: '7px 14px', borderRadius: 999, background: '#FBF9F5', border: `1px solid ${DS.border}`, cursor: 'pointer', transition: 'all 140ms' }}
                onMouseEnter={e => { e.currentTarget.style.background = DS.goldSoft; e.currentTarget.style.borderColor = DS.gold; }}
                onMouseLeave={e => { e.currentTarget.style.background = '#FBF9F5'; e.currentTarget.style.borderColor = DS.border; }}>
                <Icon name="tag" size={13} color={DS.fg4} />
                <span style={{ fontFamily: DS.fontUI, fontSize: 12 + scale * 3, fontWeight: 600, color: DS.fg1 }}>{t.name}</span>
                <span style={{ fontFamily: DS.fontMono, fontSize: 11, color: DS.fg4 }}>{t.count}</span>
              </span>
            );
          })}
        </div>
      </Card>
    </div>
  );
}

/* ── COMMENTS ──────────────────────────────────────────── */
function Comments({ accent }) {
  const [filter, setFilter] = React.useState('pending');
  const counts = { all: COMMENTS.length, pending: COMMENTS.filter(c => c.status === 'pending').length, approved: COMMENTS.filter(c => c.status === 'approved').length, spam: COMMENTS.filter(c => c.status === 'spam').length };
  const filtered = filter === 'all' ? COMMENTS : COMMENTS.filter(c => c.status === filter);
  const toneMap = { pending: 'review', approved: 'published', spam: 'decay' };
  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 18 }}>
      <SegTabs tabs={[{value:'pending',label:'Pending',count:counts.pending},{value:'approved',label:'Approved',count:counts.approved},{value:'spam',label:'Spam',count:counts.spam},{value:'all',label:'All',count:counts.all}]} active={filter} onChange={setFilter} />
      <div style={{ display: 'flex', flexDirection: 'column', gap: 12 }}>
        {filtered.map((c, i) => (
          <Card key={i} pad={16}>
            <div style={{ display: 'flex', gap: 13 }}>
              <Avatar name={c.author} size={38} />
              <div style={{ flex: 1, minWidth: 0 }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: 8, flexWrap: 'wrap' }}>
                  <span style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 700, color: DS.fg1 }}>{c.author}</span>
                  <Badge tone={toneMap[c.status]} dot={false}>{c.status}</Badge>
                  <span style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg4 }}>· {c.time}</span>
                </div>
                <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3, marginTop: 2 }}>on <span style={{ color: accent, fontWeight: 600 }}>{c.post}</span></div>
                <p style={{ margin: '10px 0 0', fontFamily: DS.fontUI, fontSize: 13.5, color: DS.fg2, lineHeight: 1.55 }}>{c.text}</p>
                <div style={{ display: 'flex', gap: 8, marginTop: 12 }}>
                  {c.status !== 'approved' && <Btn variant="green" size="sm" icon="check">Approve</Btn>}
                  <Btn variant="soft" size="sm">Reply</Btn>
                  {c.status !== 'spam' && <Btn variant="soft" size="sm" icon="alert-triangle" style={{ color: DS.red }}>Spam</Btn>}
                  <Btn variant="soft" size="sm" icon="trash">Delete</Btn>
                </div>
              </div>
            </div>
          </Card>
        ))}
      </div>
    </div>
  );
}

Object.assign(window, { Calendar, Pages, MediaLibrary, Categories, Tags, Comments });
