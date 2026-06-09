// Debesties CMS — Subscribers / Newsletter View
// Exports to window: Subscribers

function Subscribers({ accent }) {
  const [tab, setTab] = React.useState('subscribers');
  const [search, setSearch] = React.useState('');
  const [statusFilter, setStatusFilter] = React.useState('all');
  const [sel, setSel] = React.useState([]);

  const statusTone = { active: 'published', pending: 'review', unsubscribed: 'archived', bounced: 'decay' };
  const counts = {
    all: SUBSCRIBERS.length,
    active: SUBSCRIBERS.filter(s => s.status === 'active').length,
    pending: SUBSCRIBERS.filter(s => s.status === 'pending').length,
    unsubscribed: SUBSCRIBERS.filter(s => s.status === 'unsubscribed').length,
  };
  const filtered = SUBSCRIBERS.filter(s => {
    if (statusFilter !== 'all' && s.status !== statusFilter) return false;
    if (search && !s.email.toLowerCase().includes(search.toLowerCase()) && !s.name.toLowerCase().includes(search.toLowerCase())) return false;
    return true;
  });
  const allSel = filtered.length > 0 && filtered.every(s => sel.includes(s.id));
  const toggleAll = () => setSel(allSel ? [] : filtered.map(s => s.id));
  const toggleOne = (id) => setSel(s => s.includes(id) ? s.filter(x => x !== id) : [...s, id]);

  const Check = ({ on, onClick }) => (
    <button onClick={onClick} style={{ width: 18, height: 18, borderRadius: 5, flexShrink: 0, cursor: 'pointer', border: `1.5px solid ${on ? DS.gold : DS.borderSt}`, background: on ? DS.gold : DS.surface, display: 'flex', alignItems: 'center', justifyContent: 'center', padding: 0, transition: 'all 120ms' }}>{on && <Icon name="check" size={12} color="#1A1410" stroke={3} />}</button>
  );

  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 18 }}>
      {/* KPI row */}
      <div className="cms-stat-grid" style={{ display: 'grid', gridTemplateColumns: 'repeat(4,1fr)', gap: 14 }}>
        <StatCard label="Total Subscribers" value="12,840" delta="+412" deltaDir="up" icon="users" tone="gold" />
        <StatCard label="Avg. Open Rate" value="57%" delta="+3%" deltaDir="up" icon="eye" tone="green" />
        <StatCard label="Avg. Click Rate" value="24%" delta="+2%" deltaDir="up" icon="trending-up" tone="blue" />
        <StatCard label="Growth (30d)" value="+8.4%" delta="+1.2%" deltaDir="up" icon="send" tone="ai" />
      </div>

      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: 14, flexWrap: 'wrap' }}>
        <SegTabs tabs={[{ value: 'subscribers', label: 'Subscribers', icon: 'users' }, { value: 'campaigns', label: 'Campaigns', icon: 'send' }]} active={tab} onChange={setTab} />
        <div style={{ display: 'flex', gap: 10, alignItems: 'center' }}>
          {tab === 'subscribers'
            ? <><Btn variant="soft" icon="upload">Import</Btn><Btn variant="primary" icon="plus">Add subscriber</Btn></>
            : <Btn variant="primary" icon="send">New campaign</Btn>}
        </div>
      </div>

      {tab === 'subscribers' && (
        <>
          <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: 12, flexWrap: 'wrap' }}>
            <SegTabs size="sm" tabs={[
              { value: 'all', label: 'All', count: counts.all },
              { value: 'active', label: 'Active', count: counts.active },
              { value: 'pending', label: 'Pending', count: counts.pending },
              { value: 'unsubscribed', label: 'Unsubscribed', count: counts.unsubscribed },
            ]} active={statusFilter} onChange={setStatusFilter} />
            <SearchInput value={search} onChange={setSearch} placeholder="Search email or name…" width={240} />
          </div>

          {sel.length > 0 && (
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', padding: '10px 16px', background: DS.fg1, borderRadius: DS.rMd, animation: 'dsFade 160ms ease' }}>
              <span style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: '#fff' }}>{sel.length} selected</span>
              <div style={{ display: 'flex', gap: 8 }}>
                <Btn variant="ghost" size="sm" icon="send" style={{ color: '#fff', borderColor: 'rgba(255,255,255,0.25)' }}>Email</Btn>
                <Btn variant="ghost" size="sm" icon="tag" style={{ color: '#fff', borderColor: 'rgba(255,255,255,0.25)' }}>Tag</Btn>
                <Btn variant="ghost" size="sm" icon="trash" style={{ color: '#fff', borderColor: 'rgba(255,255,255,0.25)' }}>Remove</Btn>
                <Btn variant="ghost" size="sm" onClick={() => setSel([])} style={{ color: 'rgba(255,255,255,0.6)', borderColor: 'transparent' }}>Clear</Btn>
              </div>
            </div>
          )}

          <Card pad={0}>
            <div style={{ overflowX: 'auto' }}>
              <table style={{ width: '100%', borderCollapse: 'collapse', minWidth: 720 }}>
                <thead>
                  <tr style={{ borderBottom: `1px solid ${DS.border}`, background: '#FBF9F5' }}>
                    <th style={{ padding: '12px 16px', width: 40 }}><Check on={allSel} onClick={toggleAll} /></th>
                    {['Subscriber', 'Status', 'Source', 'Engagement', 'Joined', ''].map((h, i) => (
                      <th key={i} style={{ padding: '12px 14px', textAlign: i === 3 ? 'left' : 'left', fontFamily: DS.fontUI, fontSize: 11, fontWeight: 700, letterSpacing: '0.06em', textTransform: 'uppercase', color: DS.fg4, whiteSpace: 'nowrap' }}>{h}</th>
                    ))}
                  </tr>
                </thead>
                <tbody>
                  {filtered.map(s => {
                    const isSel = sel.includes(s.id);
                    return (
                      <tr key={s.id} style={{ borderBottom: `1px solid ${DS.border}`, background: isSel ? DS.goldSoft + '88' : 'transparent' }}
                        onMouseEnter={e => { if (!isSel) e.currentTarget.style.background = '#FBF9F5'; }} onMouseLeave={e => { if (!isSel) e.currentTarget.style.background = 'transparent'; }}>
                        <td style={{ padding: '12px 16px' }}><Check on={isSel} onClick={() => toggleOne(s.id)} /></td>
                        <td style={{ padding: '12px 14px' }}>
                          <div style={{ display: 'flex', alignItems: 'center', gap: 11 }}>
                            <Avatar name={s.name !== '—' ? s.name : s.email} size={32} />
                            <div style={{ minWidth: 0 }}>
                              <div style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: DS.fg1 }}>{s.email}</div>
                              {s.name !== '—' && <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg4 }}>{s.name}</div>}
                            </div>
                          </div>
                        </td>
                        <td style={{ padding: '12px 14px' }}><Badge tone={statusTone[s.status]}>{s.status}</Badge></td>
                        <td style={{ padding: '12px 14px', fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg2, whiteSpace: 'nowrap' }}>{s.source}</td>
                        <td style={{ padding: '12px 14px' }}>
                          <div style={{ display: 'flex', alignItems: 'center', gap: 9, width: 120 }}>
                            <div style={{ flex: 1 }}><ProgressBar value={s.opens} color={s.opens >= 70 ? DS.green : s.opens >= 40 ? DS.gold : DS.borderSt} height={6} /></div>
                            <span style={{ fontFamily: DS.fontMono, fontSize: 11, fontWeight: 700, color: DS.fg3, width: 30, textAlign: 'right' }}>{s.opens}%</span>
                          </div>
                        </td>
                        <td style={{ padding: '12px 14px', fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3, whiteSpace: 'nowrap' }}>{s.joined}</td>
                        <td style={{ padding: '12px 14px' }}><button style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg4, display: 'flex' }}><Icon name="more-horizontal" size={17} /></button></td>
                      </tr>
                    );
                  })}
                </tbody>
              </table>
            </div>
            {filtered.length === 0 && (
              <EmptyState icon="users" title="No subscribers found" body="Try adjusting your search or status filter."
                action={<Btn variant="soft" onClick={() => { setSearch(''); setStatusFilter('all'); }}>Clear filters</Btn>} />
            )}
          </Card>
        </>
      )}

      {tab === 'campaigns' && (
        <Card pad={0}>
          <div style={{ padding: '16px 20px', borderBottom: `1px solid ${DS.border}` }}>
            <span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Recent Campaigns</span>
          </div>
          {CAMPAIGNS.map((c, i) => (
            <div key={c.id} style={{ display: 'flex', alignItems: 'center', gap: 16, padding: '15px 20px', borderBottom: i < CAMPAIGNS.length - 1 ? `1px solid ${DS.border}` : 'none' }}>
              <div style={{ width: 38, height: 38, borderRadius: DS.rMd, background: c.status === 'sent' ? DS.greenSoft : DS.blueSoft, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                <Icon name={c.status === 'sent' ? 'send' : 'clock'} size={18} color={c.status === 'sent' ? DS.green : DS.blue} stroke={2} />
              </div>
              <div style={{ flex: 1, minWidth: 0 }}>
                <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{c.subject}</div>
                <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg4, marginTop: 2 }}>{c.sent} · {c.recipients ? c.recipients.toLocaleString() + ' recipients' : 'not sent yet'}</div>
              </div>
              {c.status === 'sent' ? (
                <>
                  <div style={{ textAlign: 'center', minWidth: 60 }}>
                    <div style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>{c.openRate}%</div>
                    <div style={{ fontFamily: DS.fontUI, fontSize: 10.5, color: DS.fg4 }}>opens</div>
                  </div>
                  <div style={{ textAlign: 'center', minWidth: 60 }}>
                    <div style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: accent }}>{c.clickRate}%</div>
                    <div style={{ fontFamily: DS.fontUI, fontSize: 10.5, color: DS.fg4 }}>clicks</div>
                  </div>
                </>
              ) : (
                <Badge tone="scheduled">Scheduled</Badge>
              )}
            </div>
          ))}
        </Card>
      )}
    </div>
  );
}

Object.assign(window, { Subscribers });
