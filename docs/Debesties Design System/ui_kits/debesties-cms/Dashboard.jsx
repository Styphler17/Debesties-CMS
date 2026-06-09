// Debesties CMS — Dashboard View
// Exports to window: Dashboard

function Dashboard({ onNavigate, onNewPost, accent }) {
  const stats = [
    { label: 'Total Posts', value: '248', delta: '+12', deltaDir: 'up', icon: 'file-text', tone: 'gold' },
    { label: 'Published', value: '186', delta: '+8', deltaDir: 'up', icon: 'check', tone: 'green' },
    { label: 'Drafts', value: '34', delta: '+3', deltaDir: 'up', icon: 'edit', tone: 'blue' },
    { label: 'Scheduled', value: '9', delta: null, icon: 'clock', tone: 'ai' },
    { label: 'Total Views', value: '1.24M', delta: '+18%', deltaDir: 'up', icon: 'eye', tone: 'gold' },
    { label: 'Avg. SEO Score', value: '78', delta: '+4', deltaDir: 'up', icon: 'gauge', tone: 'green' },
  ];

  const quickActions = [
    { label: 'Write new post', icon: 'pen-tool', tone: 'gold', action: onNewPost },
    { label: 'Upload media', icon: 'upload', tone: 'blue', action: () => onNavigate('media') },
    { label: 'Review queue', icon: 'list-checks', tone: 'green', action: () => onNavigate('posts'), badge: '2' },
    { label: 'AI Visibility', icon: 'sparkles', tone: 'ai', action: () => onNavigate('ai') },
  ];

  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 20 }}>
      {/* Greeting banner */}
      <Card pad={0} style={{ overflow: 'hidden', border: 'none' }}>
        <div style={{ background: `linear-gradient(115deg, ${DS.fg1} 0%, #2C2118 55%, ${DS.goldDeep} 130%)`, padding: '26px 28px', display: 'flex', justifyContent: 'space-between', alignItems: 'center', gap: 20, flexWrap: 'wrap' }}>
          <div>
            <div style={{ fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 600, color: 'rgba(255,255,255,0.55)', letterSpacing: '0.04em', marginBottom: 6 }}>Tuesday, June 9 · Good morning</div>
            <div style={{ fontFamily: DS.fontDisp, fontSize: 26, fontWeight: 700, color: '#fff', letterSpacing: '-0.01em', lineHeight: 1.15 }}>Welcome back, Ama 👋</div>
            <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, color: 'rgba(255,255,255,0.6)', marginTop: 6 }}>You have <b style={{ color: DS.gold }}>2 posts in review</b> and <b style={{ color: DS.gold }}>3 articles</b> flagged for updates.</div>
          </div>
          <div style={{ display: 'flex', gap: 10 }}>
            <Btn variant="primary" icon="plus" onClick={onNewPost}>New Post</Btn>
            <Btn variant="ghost" icon="calendar" onClick={() => onNavigate('calendar')} style={{ color: '#fff', borderColor: 'rgba(255,255,255,0.25)' }}>Calendar</Btn>
          </div>
        </div>
      </Card>

      {/* Stat grid */}
      <div className="cms-stat-grid" style={{ display: 'grid', gridTemplateColumns: 'repeat(6,1fr)', gap: 14 }}>
        {stats.map(s => <StatCard key={s.label} {...s} />)}
      </div>

      {/* Quick actions */}
      <div className="cms-qa-grid" style={{ display: 'grid', gridTemplateColumns: 'repeat(4,1fr)', gap: 14 }}>
        {quickActions.map(qa => (
          <Card key={qa.label} pad={16} hover onClick={qa.action} style={{ cursor: 'pointer' }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: 13 }}>
              <div style={{ width: 42, height: 42, borderRadius: DS.rMd, flexShrink: 0, display: 'flex', alignItems: 'center', justifyContent: 'center',
                background: qa.tone === 'ai' ? `linear-gradient(125deg,${DS.aiFrom},${DS.aiTo})` : `${{gold:DS.gold,blue:DS.blue,green:DS.green}[qa.tone]}1A`,
                color: qa.tone === 'ai' ? '#fff' : {gold:DS.gold,blue:DS.blue,green:DS.green}[qa.tone] }}>
                <Icon name={qa.icon} size={20} stroke={2} />
              </div>
              <div style={{ flex: 1 }}>
                <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1 }}>{qa.label}</div>
                <div style={{ fontFamily: DS.fontUI, fontSize: 11.5, color: DS.fg4, marginTop: 1 }}>Quick action</div>
              </div>
              {qa.badge && <Badge tone="review" dot={false}>{qa.badge}</Badge>}
              <Icon name="chevron-right" size={16} color={DS.fg4} />
            </div>
          </Card>
        ))}
      </div>

      {/* Main two-column */}
      <div className="cms-dash-cols" style={{ display: 'grid', gridTemplateColumns: '1.6fr 1fr', gap: 20, alignItems: 'start' }}>
        {/* LEFT */}
        <div style={{ display: 'flex', flexDirection: 'column', gap: 20 }}>
          {/* Top articles */}
          <Card pad={0}>
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', padding: '16px 20px', borderBottom: `1px solid ${DS.border}` }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
                <Icon name="flame" size={18} color={DS.gold} stroke={2} />
                <span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Top Articles</span>
                <span style={{ fontFamily: DS.fontUI, fontSize: 11.5, color: DS.fg4, fontWeight: 500 }}>· last 7 days</span>
              </div>
              <button onClick={() => onNavigate('analytics')} style={{ border: 'none', background: 'none', cursor: 'pointer', fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 600, color: accent, display: 'flex', alignItems: 'center', gap: 4 }}>
                View all <Icon name="arrow-right" size={13} stroke={2.2} />
              </button>
            </div>
            <div>
              {TOP_ARTICLES.map((a, i) => (
                <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 14, padding: '13px 20px', borderBottom: i < TOP_ARTICLES.length - 1 ? `1px solid ${DS.border}` : 'none', cursor: 'pointer' }}
                  onMouseEnter={e => e.currentTarget.style.background = '#FBF9F5'} onMouseLeave={e => e.currentTarget.style.background = 'transparent'}>
                  <span style={{ fontFamily: DS.fontMono, fontSize: 13, fontWeight: 700, color: DS.fg4, width: 18 }}>{i + 1}</span>
                  <div style={{ flex: 1, minWidth: 0 }}>
                    <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{a.title}</div>
                    <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3, marginTop: 2 }}>{(a.views/1000).toFixed(1)}K views</div>
                  </div>
                  <Sparkline data={a.trend} color={a.up.startsWith('\u2212') ? DS.red : DS.green} width={72} height={26} />
                  <span style={{ fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 700, color: a.up.startsWith('\u2212') ? DS.red : DS.green, width: 48, textAlign: 'right' }}>{a.up}</span>
                </div>
              ))}
            </div>
          </Card>

          {/* Content needing updates */}
          <Card pad={0}>
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', padding: '16px 20px', borderBottom: `1px solid ${DS.border}` }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
                <Icon name="alert-triangle" size={17} color={DS.red} stroke={2} />
                <span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Content Needing Updates</span>
              </div>
              <Badge tone="decay" dot={false}>{DECAY.length} flagged</Badge>
            </div>
            {DECAY.map((d, i) => (
              <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 14, padding: '13px 20px', borderBottom: i < DECAY.length - 1 ? `1px solid ${DS.border}` : 'none' }}>
                <div style={{ flex: 1, minWidth: 0 }}>
                  <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{d.title}</div>
                  <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3, marginTop: 2 }}>{d.reason} · updated {d.lastUpdate}</div>
                </div>
                <span style={{ fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 700, color: DS.red }}>{d.drop}</span>
                <Btn variant="soft" size="sm" onClick={() => onNavigate('posts')}>Update</Btn>
              </div>
            ))}
          </Card>
        </div>

        {/* RIGHT */}
        <div style={{ display: 'flex', flexDirection: 'column', gap: 20 }}>
          {/* Trending categories */}
          <Card>
            <div style={{ display: 'flex', alignItems: 'center', gap: 8, marginBottom: 16 }}>
              <Icon name="trending-up" size={17} color={DS.green} stroke={2} />
              <span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Trending Categories</span>
            </div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 13 }}>
              {TRENDING_CATS.map(c => (
                <div key={c.name}>
                  <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: 5 }}>
                    <span style={{ fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 600, color: DS.fg2 }}>{c.name}</span>
                    <span style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3 }}>{c.views}</span>
                  </div>
                  <ProgressBar value={c.share} color={c.color} />
                </div>
              ))}
            </div>
          </Card>

          {/* Search traffic */}
          <Card>
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: 14 }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
                <Icon name="search-check" size={17} color={DS.blue} stroke={2} />
                <span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Search Traffic</span>
              </div>
            </div>
            <div style={{ display: 'flex', alignItems: 'baseline', gap: 10, marginBottom: 4 }}>
              <span style={{ fontFamily: DS.fontUI, fontSize: 30, fontWeight: 700, color: DS.fg1, letterSpacing: '-0.02em' }}>21.6K</span>
              <span style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 700, color: DS.green, display: 'inline-flex', alignItems: 'center', gap: 2 }}><Icon name="trending-up" size={14} stroke={2.2} />+14%</span>
            </div>
            <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3, marginBottom: 14 }}>Organic clicks this week</div>
            <div style={{ display: 'flex', alignItems: 'flex-end', gap: 5, height: 56 }}>
              {[40,52,46,64,58,72,68,84,78,92,88,100].map((h, i) => (
                <div key={i} style={{ flex: 1, height: `${h}%`, background: i >= 9 ? DS.blue : `${DS.blue}55`, borderRadius: 3, transition: 'height 400ms ease' }}></div>
              ))}
            </div>
          </Card>

          {/* Recent activity */}
          <Card pad={0}>
            <div style={{ padding: '16px 20px', borderBottom: `1px solid ${DS.border}`, display: 'flex', alignItems: 'center', gap: 8 }}>
              <Icon name="clock" size={17} color={DS.fg3} stroke={2} />
              <span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Recent Activity</span>
            </div>
            <div style={{ padding: '4px 0' }}>
              {ACTIVITY.map((a, i) => (
                <div key={i} style={{ display: 'flex', gap: 11, padding: '10px 20px' }}>
                  {a.who === 'System'
                    ? <div style={{ width: 28, height: 28, borderRadius: 999, background: DS.redSoft, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}><Icon name="alert-triangle" size={14} color={DS.red} stroke={2} /></div>
                    : <Avatar name={a.who} size={28} />}
                  <div style={{ flex: 1, minWidth: 0 }}>
                    <div style={{ fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg2, lineHeight: 1.45 }}>
                      <b style={{ color: DS.fg1, fontWeight: 600 }}>{a.who}</b> {a.action} <span style={{ color: DS.fg1, fontWeight: 500 }}>{a.target.length > 32 ? a.target.slice(0, 32) + '…' : a.target}</span>
                    </div>
                    <div style={{ fontFamily: DS.fontUI, fontSize: 11, color: DS.fg4, marginTop: 1 }}>{a.time}</div>
                  </div>
                </div>
              ))}
            </div>
          </Card>
        </div>
      </div>
    </div>
  );
}

Object.assign(window, { Dashboard });
