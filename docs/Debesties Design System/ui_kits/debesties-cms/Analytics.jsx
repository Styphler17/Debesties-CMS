// Debesties CMS — Analytics View
// Exports to window: Analytics

function PageHeader({ title, subtitle, children }) {
  return (
    <div style={{ display: 'flex', alignItems: 'flex-end', justifyContent: 'space-between', gap: 16, flexWrap: 'wrap' }}>
      <div>
        <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, color: DS.fg3 }}>{subtitle}</div>
      </div>
      <div style={{ display: 'flex', gap: 10, alignItems: 'center' }}>{children}</div>
    </div>
  );
}

function BarRow({ label, value, max, color, suffix }) {
  return (
    <div style={{ display: 'flex', alignItems: 'center', gap: 12 }}>
      <span style={{ width: 130, fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg2, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{label}</span>
      <div style={{ flex: 1 }}><ProgressBar value={(value / max) * 100} color={color} height={8} /></div>
      <span style={{ width: 56, textAlign: 'right', fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 600, color: DS.fg1 }}>{suffix}</span>
    </div>
  );
}

function Analytics({ accent }) {
  const [range, setRange] = React.useState('7d');
  const bars = [42,48,46,58,54,68,64,76,72,84,80,92,88,96,100,94,88,82,90,98];

  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 20 }}>
      <PageHeader subtitle="Performance across all published content">
        <SegTabs tabs={[{value:'24h',label:'24h'},{value:'7d',label:'7 days'},{value:'30d',label:'30 days'},{value:'12m',label:'12 mo'}]} active={range} onChange={setRange} size="sm" />
        <Btn variant="soft" icon="external-link" size="md">Export</Btn>
      </PageHeader>

      {/* KPI row */}
      <div className="cms-stat-grid" style={{ display: 'grid', gridTemplateColumns: 'repeat(4,1fr)', gap: 14 }}>
        <StatCard label="Total Views" value="1.24M" delta="+18%" deltaDir="up" icon="eye" tone="gold" />
        <StatCard label="Unique Visitors" value="612K" delta="+11%" deltaDir="up" icon="users" tone="green" />
        <StatCard label="Avg. Time on Page" value="3:42" delta="+0:18" deltaDir="up" icon="clock" tone="blue" />
        <StatCard label="Bounce Rate" value="38%" delta="\u22124%" deltaDir="up" icon="trending-down" tone="ai" />
      </div>

      {/* Main chart */}
      <Card>
        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: 18 }}>
          <div>
            <div style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Traffic Overview</div>
            <div style={{ fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg3, marginTop: 2 }}>Pageviews over time</div>
          </div>
          <div style={{ display: 'flex', gap: 16 }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: 6 }}><span style={{ width: 10, height: 10, borderRadius: 3, background: DS.gold }}></span><span style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3 }}>This period</span></div>
            <div style={{ display: 'flex', alignItems: 'center', gap: 6 }}><span style={{ width: 10, height: 10, borderRadius: 3, background: DS.border }}></span><span style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3 }}>Previous</span></div>
          </div>
        </div>
        <div style={{ display: 'flex', alignItems: 'flex-end', gap: 6, height: 180 }}>
          {bars.map((h, i) => (
            <div key={i} style={{ flex: 1, display: 'flex', flexDirection: 'column', justifyContent: 'flex-end', gap: 0, height: '100%' }}>
              <div style={{ height: `${h}%`, background: i >= 15 ? `linear-gradient(to top, ${DS.gold}, ${DS.gold}cc)` : `${DS.gold}55`, borderRadius: '4px 4px 0 0', transition: 'height 500ms ease', minHeight: 4 }}></div>
            </div>
          ))}
        </div>
        <div style={{ display: 'flex', justifyContent: 'space-between', marginTop: 10, fontFamily: DS.fontMono, fontSize: 10.5, color: DS.fg4 }}>
          {['May 20','May 24','May 28','Jun 1','Jun 5','Jun 9'].map(d => <span key={d}>{d}</span>)}
        </div>
      </Card>

      {/* Two col: top articles + traffic sources */}
      <div className="cms-dash-cols" style={{ display: 'grid', gridTemplateColumns: '1.5fr 1fr', gap: 20, alignItems: 'start' }}>
        <Card pad={0}>
          <div style={{ padding: '16px 20px', borderBottom: `1px solid ${DS.border}`, display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
            <span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Top Articles</span>
            <span style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg4 }}>by pageviews</span>
          </div>
          {TOP_ARTICLES.map((a, i) => (
            <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 14, padding: '13px 20px', borderBottom: i < TOP_ARTICLES.length - 1 ? `1px solid ${DS.border}` : 'none' }}>
              <span style={{ fontFamily: DS.fontMono, fontSize: 13, fontWeight: 700, color: DS.fg4, width: 16 }}>{i + 1}</span>
              <div style={{ flex: 1, minWidth: 0 }}>
                <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{a.title}</div>
                <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3, marginTop: 2 }}>{(a.views/1000).toFixed(1)}K views · 4:12 avg</div>
              </div>
              <Sparkline data={a.trend} color={a.up.startsWith('\u2212') ? DS.red : DS.green} width={70} />
              <span style={{ fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 700, color: a.up.startsWith('\u2212') ? DS.red : DS.green, width: 46, textAlign: 'right' }}>{a.up}</span>
            </div>
          ))}
        </Card>

        <div style={{ display: 'flex', flexDirection: 'column', gap: 20 }}>
          {/* Traffic sources donut-ish */}
          <Card>
            <div style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1, marginBottom: 16 }}>Traffic Sources</div>
            <div style={{ display: 'flex', height: 12, borderRadius: 999, overflow: 'hidden', marginBottom: 18 }}>
              {TRAFFIC_SOURCES.map(s => <div key={s.name} style={{ width: `${s.pct}%`, background: s.color }}></div>)}
            </div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 11 }}>
              {TRAFFIC_SOURCES.map(s => (
                <div key={s.name} style={{ display: 'flex', alignItems: 'center', gap: 10 }}>
                  <span style={{ width: 10, height: 10, borderRadius: 3, background: s.color, flexShrink: 0 }}></span>
                  <span style={{ flex: 1, fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg2 }}>{s.name}</span>
                  <span style={{ fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 700, color: DS.fg1 }}>{s.pct}%</span>
                </div>
              ))}
            </div>
          </Card>
          {/* Author performance */}
          <Card>
            <div style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1, marginBottom: 16 }}>Author Performance</div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 13 }}>
              {[['Ama Boateng', 412, '#E8A800'],['Kwesi Mensah', 318, '#1A8A4B'],['Yaw Owusu', 224, '#2F6BD8'],['Esi Arthur', 156, '#B14FD8']].map(([n, v, c]) => (
                <div key={n} style={{ display: 'flex', alignItems: 'center', gap: 10 }}>
                  <Avatar name={n} size={28} />
                  <span style={{ flex: 1, fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg2 }}>{n}</span>
                  <span style={{ fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 700, color: DS.fg1 }}>{v}K</span>
                </div>
              ))}
            </div>
          </Card>
        </div>
      </div>

      {/* Category performance + search performance */}
      <div className="cms-dash-cols" style={{ display: 'grid', gridTemplateColumns: '1fr 1.5fr', gap: 20, alignItems: 'start' }}>
        <Card>
          <div style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1, marginBottom: 18 }}>Category Performance</div>
          <div style={{ display: 'flex', flexDirection: 'column', gap: 14 }}>
            {TRENDING_CATS.map(c => <BarRow key={c.name} label={c.name} value={c.share} max={38} color={c.color} suffix={c.views} />)}
          </div>
        </Card>
        <Card pad={0}>
          <div style={{ padding: '16px 20px', borderBottom: `1px solid ${DS.border}`, display: 'flex', alignItems: 'center', gap: 8 }}>
            <Icon name="search-check" size={17} color={DS.blue} stroke={2} />
            <span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Search Performance</span>
          </div>
          <div style={{ overflowX: 'auto' }}>
            <table style={{ width: '100%', borderCollapse: 'collapse', minWidth: 460 }}>
              <thead><tr style={{ background: '#FBF9F5' }}>
                {['Query','Pos','Clicks','CTR'].map((h, i) => <th key={h} style={{ padding: '10px 16px', textAlign: i === 0 ? 'left' : 'right', fontFamily: DS.fontUI, fontSize: 11, fontWeight: 700, letterSpacing: '0.05em', textTransform: 'uppercase', color: DS.fg4 }}>{h}</th>)}
              </tr></thead>
              <tbody>
                {SEARCH_QUERIES.map((q, i) => (
                  <tr key={i} style={{ borderTop: `1px solid ${DS.border}` }}>
                    <td style={{ padding: '11px 16px', fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg1, fontWeight: 500 }}>{q.q}</td>
                    <td style={{ padding: '11px 16px', textAlign: 'right' }}><span style={{ fontFamily: DS.fontMono, fontSize: 12, fontWeight: 700, color: q.pos <= 3 ? DS.green : DS.gold, background: q.pos <= 3 ? DS.greenSoft : DS.goldSoft, padding: '2px 8px', borderRadius: 999 }}>#{q.pos}</span></td>
                    <td style={{ padding: '11px 16px', textAlign: 'right', fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 600, color: DS.fg1 }}>{(q.clicks/1000).toFixed(1)}K</td>
                    <td style={{ padding: '11px 16px', textAlign: 'right', fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg2 }}>{q.ctr}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </Card>
      </div>

      {/* Content decay */}
      <Card pad={0}>
        <div style={{ padding: '16px 20px', borderBottom: `1px solid ${DS.border}`, display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
            <Icon name="trending-down" size={17} color={DS.red} stroke={2} />
            <span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Content Decay Alerts</span>
          </div>
          <Badge tone="decay" dot={false}>{DECAY.length} declining</Badge>
        </div>
        {DECAY.map((d, i) => (
          <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 14, padding: '13px 20px', borderBottom: i < DECAY.length - 1 ? `1px solid ${DS.border}` : 'none' }}>
            <div style={{ width: 32, height: 32, borderRadius: 8, background: DS.redSoft, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}><Icon name="trending-down" size={16} color={DS.red} stroke={2} /></div>
            <div style={{ flex: 1, minWidth: 0 }}>
              <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{d.title}</div>
              <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3, marginTop: 2 }}>{d.reason}</div>
            </div>
            <div style={{ textAlign: 'right' }}>
              <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 700, color: DS.red }}>{d.drop}</div>
              <div style={{ fontFamily: DS.fontUI, fontSize: 11, color: DS.fg4 }}>{d.lastUpdate}</div>
            </div>
            <Btn variant="soft" size="sm" icon="refresh">Refresh</Btn>
          </div>
        ))}
      </Card>
    </div>
  );
}

Object.assign(window, { Analytics, PageHeader, BarRow });
