// Debesties CMS — System Views
// Exports: UsersRoles, SeoTools, AiVisibility, Settings, NavBuilder, HomeBuilder, LoadingState, ErrorState

/* ── USERS & ROLES ─────────────────────────────────────── */
function UsersRoles({ accent }) {
  const [tab, setTab] = React.useState('members');
  const statusTone = { active: 'published', invited: 'review' };
  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 18 }}>
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', flexWrap: 'wrap', gap: 12 }}>
        <SegTabs tabs={[{value:'members',label:'Members',count:USERS.length},{value:'roles',label:'Roles & Permissions',count:ROLES.length}]} active={tab} onChange={setTab} />
        <Btn variant="primary" icon="plus">{tab === 'members' ? 'Invite member' : 'New role'}</Btn>
      </div>

      {tab === 'members' && (
        <Card pad={0}>
          <div style={{ overflowX: 'auto' }}>
            <table style={{ width: '100%', borderCollapse: 'collapse', minWidth: 680 }}>
              <thead><tr style={{ background: '#FBF9F5', borderBottom: `1px solid ${DS.border}` }}>
                {['Member','Role','Posts','Status','Last active',''].map((h, i) => <th key={i} style={{ padding: '12px 16px', textAlign: 'left', fontFamily: DS.fontUI, fontSize: 11, fontWeight: 700, letterSpacing: '0.05em', textTransform: 'uppercase', color: DS.fg4 }}>{h}</th>)}
              </tr></thead>
              <tbody>
                {USERS.map((u, i) => {
                  const role = ROLES.find(r => r.name === u.role);
                  return (
                    <tr key={i} style={{ borderBottom: i < USERS.length - 1 ? `1px solid ${DS.border}` : 'none' }}
                      onMouseEnter={e => e.currentTarget.style.background = '#FBF9F5'} onMouseLeave={e => e.currentTarget.style.background = 'transparent'}>
                      <td style={{ padding: '12px 16px' }}>
                        <div style={{ display: 'flex', alignItems: 'center', gap: 11 }}>
                          <Avatar name={u.name} size={36} />
                          <div><div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1 }}>{u.name}</div><div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg4 }}>{u.email}</div></div>
                        </div>
                      </td>
                      <td style={{ padding: '12px 16px' }}><span style={{ display: 'inline-flex', alignItems: 'center', gap: 6, fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 600, color: DS.fg2 }}><span style={{ width: 8, height: 8, borderRadius: 999, background: role?.color || DS.fg4 }}></span>{u.role}</span></td>
                      <td style={{ padding: '12px 16px', fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: DS.fg1 }}>{u.posts}</td>
                      <td style={{ padding: '12px 16px' }}><Badge tone={statusTone[u.status]}>{u.status}</Badge></td>
                      <td style={{ padding: '12px 16px', fontFamily: DS.fontUI, fontSize: 12.5, color: u.last === 'Online now' ? DS.green : DS.fg3, fontWeight: u.last === 'Online now' ? 600 : 400 }}>{u.last}</td>
                      <td style={{ padding: '12px 16px' }}><button style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg4, display: 'flex' }}><Icon name="more-horizontal" size={17} /></button></td>
                    </tr>
                  );
                })}
              </tbody>
            </table>
          </div>
        </Card>
      )}

      {tab === 'roles' && (
        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(300px, 1fr))', gap: 14 }}>
          {ROLES.map(r => (
            <Card key={r.name} hover>
              <div style={{ display: 'flex', alignItems: 'center', gap: 11, marginBottom: 12 }}>
                <div style={{ width: 38, height: 38, borderRadius: DS.rMd, background: `${r.color}1A`, color: r.color, display: 'flex', alignItems: 'center', justifyContent: 'center' }}><Icon name="users" size={18} stroke={2} /></div>
                <div style={{ flex: 1 }}>
                  <div style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>{r.name}</div>
                  <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg4 }}>{r.count} {r.count === 1 ? 'member' : 'members'}</div>
                </div>
              </div>
              <p style={{ margin: '0 0 14px', fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg3, lineHeight: 1.55 }}>{r.perms}</p>
              <Btn variant="soft" size="sm" full icon="settings">Edit permissions</Btn>
            </Card>
          ))}
        </div>
      )}
    </div>
  );
}

/* ── SEO TOOLS ─────────────────────────────────────────── */
function SeoTools({ accent }) {
  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 20 }}>
      <div className="cms-stat-grid" style={{ display: 'grid', gridTemplateColumns: 'repeat(4,1fr)', gap: 14 }}>
        <StatCard label="Avg. SEO Score" value="78" delta="+4" deltaDir="up" icon="gauge" tone="green" />
        <StatCard label="Indexed Pages" value="241" delta="+12" deltaDir="up" icon="globe" tone="blue" />
        <StatCard label="Avg. Position" value="4.2" delta="+0.8" deltaDir="up" icon="trending-up" tone="gold" />
        <StatCard label="Broken Links" value="3" icon="alert-triangle" tone="red" />
      </div>

      <div className="cms-dash-cols" style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20, alignItems: 'start' }}>
        {/* Focus keyword management */}
        <Card pad={0}>
          <div style={{ padding: '16px 20px', borderBottom: `1px solid ${DS.border}`, display: 'flex', alignItems: 'center', gap: 8 }}>
            <Icon name="gauge" size={17} color={DS.green} stroke={2} /><span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Focus Keyword Tracking</span>
          </div>
          {[['artiste of the year ghana', 1, 'up'],['tgma double winners', 2, 'up'],['black sherif awards', 3, 'down'],['ghana music awards history', 6, 'up'],['sarkodie tgma wins', 8, 'down']].map(([kw, pos, dir], i) => (
            <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 12, padding: '12px 20px', borderBottom: i < 4 ? `1px solid ${DS.border}` : 'none' }}>
              <Icon name="search" size={14} color={DS.fg4} />
              <span style={{ flex: 1, fontFamily: DS.fontUI, fontSize: 13, color: DS.fg1 }}>{kw}</span>
              <span style={{ fontFamily: DS.fontMono, fontSize: 12, fontWeight: 700, color: pos <= 3 ? DS.green : DS.gold, background: pos <= 3 ? DS.greenSoft : DS.goldSoft, padding: '2px 9px', borderRadius: 999 }}>#{pos}</span>
              <Icon name={dir === 'up' ? 'trending-up' : 'trending-down'} size={15} color={dir === 'up' ? DS.green : DS.red} stroke={2.2} />
            </div>
          ))}
        </Card>

        {/* Site health checklist */}
        <Card pad={0}>
          <div style={{ padding: '16px 20px', borderBottom: `1px solid ${DS.border}`, display: 'flex', alignItems: 'center', gap: 8 }}>
            <Icon name="list-checks" size={17} color={DS.gold} stroke={2} /><span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Site Health</span>
          </div>
          <div style={{ padding: '8px 20px' }}>
            {[['XML sitemap submitted', true],['robots.txt configured', true],['Schema markup valid', true],['No broken internal links', false],['All images have alt text', false],['Core Web Vitals passing', true],['Mobile-friendly', true],['HTTPS enabled', true]].map(([l, pass], i) => (
              <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 10, padding: '9px 0', borderBottom: i < 7 ? `1px solid ${DS.border}` : 'none' }}>
                <div style={{ width: 20, height: 20, borderRadius: 999, flexShrink: 0, display: 'flex', alignItems: 'center', justifyContent: 'center', background: pass ? DS.greenSoft : DS.redSoft, color: pass ? DS.green : DS.red }}><Icon name={pass ? 'check' : 'x'} size={12} stroke={3} /></div>
                <span style={{ flex: 1, fontFamily: DS.fontUI, fontSize: 13, color: DS.fg2 }}>{l}</span>
                {!pass && <span style={{ fontFamily: DS.fontUI, fontSize: 11.5, fontWeight: 600, color: accent, cursor: 'pointer' }}>Fix</span>}
              </div>
            ))}
          </div>
        </Card>
      </div>

      {/* Internal linking opportunities */}
      <Card pad={0}>
        <div style={{ padding: '16px 20px', borderBottom: `1px solid ${DS.border}`, display: 'flex', alignItems: 'center', gap: 8 }}>
          <Icon name="link" size={17} color={DS.blue} stroke={2} /><span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Internal Linking Opportunities</span>
        </div>
        {[['The Elite Club: 4 Artists…','Sarkodie vs Stonebwoy: The Numbers',3],['Black Sherif\u2019s Second Crown','Every Hiplife Winner That Defined an Era',2],['King Promise\u2019s 2025 Win','Diana Hamilton & The Rise of Gospel',1]].map(([from, to, n], i) => (
          <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 12, padding: '13px 20px', borderBottom: i < 2 ? `1px solid ${DS.border}` : 'none' }}>
            <div style={{ flex: 1, display: 'flex', alignItems: 'center', gap: 10, minWidth: 0 }}>
              <span style={{ fontFamily: DS.fontUI, fontSize: 13, color: DS.fg2, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis', flex: 1 }}>{from}</span>
              <Icon name="arrow-right" size={14} color={DS.fg4} />
              <span style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: DS.fg1, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis', flex: 1 }}>{to}</span>
            </div>
            <Badge tone="ai" dot={false}>{n} {n === 1 ? 'spot' : 'spots'}</Badge>
            <Btn variant="soft" size="sm">Add link</Btn>
          </div>
        ))}
      </Card>
    </div>
  );
}

/* ── AI VISIBILITY ─────────────────────────────────────── */
function AiVisibility({ accent }) {
  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 20 }}>
      {/* Hero */}
      <div style={{ borderRadius: DS.rLg, padding: '26px 28px', background: `linear-gradient(120deg, ${DS.aiFrom} 0%, ${DS.aiTo} 100%)`, display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: 20, flexWrap: 'wrap', position: 'relative', overflow: 'hidden' }}>
        <div style={{ position: 'absolute', top: -30, right: 40, opacity: 0.16 }}><Icon name="sparkles" size={160} color="#fff" /></div>
        <div style={{ position: 'relative' }}>
          <div style={{ display: 'inline-flex', alignItems: 'center', gap: 7, background: 'rgba(255,255,255,0.18)', padding: '4px 12px', borderRadius: 999, marginBottom: 12 }}>
            <Icon name="sparkles" size={13} color="#fff" /><span style={{ fontFamily: DS.fontUI, fontSize: 11.5, fontWeight: 700, color: '#fff', letterSpacing: '0.04em' }}>AI VISIBILITY ENGINE</span>
          </div>
          <div style={{ fontFamily: DS.fontDisp, fontSize: 26, fontWeight: 700, color: '#fff', letterSpacing: '-0.01em' }}>Be the answer AI gives</div>
          <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, color: 'rgba(255,255,255,0.85)', marginTop: 6, maxWidth: 420, lineHeight: 1.5 }}>Track how Debesties appears across ChatGPT, Gemini, Perplexity & Google AI Overviews.</div>
        </div>
        <div style={{ position: 'relative', textAlign: 'center', background: 'rgba(255,255,255,0.14)', borderRadius: DS.rLg, padding: '18px 28px' }}>
          <div style={{ fontFamily: DS.fontUI, fontSize: 44, fontWeight: 800, color: '#fff', lineHeight: 1 }}>72</div>
          <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: 'rgba(255,255,255,0.8)', marginTop: 4 }}>AI Visibility Score</div>
        </div>
      </div>

      {/* Citation tracking per assistant */}
      <div className="cms-stat-grid" style={{ display: 'grid', gridTemplateColumns: 'repeat(4,1fr)', gap: 14 }}>
        {[['ChatGPT', 28, '+6'],['Google AI', 41, '+12'],['Perplexity', 19, '+3'],['Gemini', 14, '\u22122']].map(([name, cites, delta]) => (
          <Card key={name} pad={18}>
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: 12 }}>
              <span style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: DS.fg2 }}>{name}</span>
              <span style={{ fontFamily: DS.fontUI, fontSize: 12, fontWeight: 700, color: delta.startsWith('\u2212') ? DS.red : DS.green }}>{delta}</span>
            </div>
            <div style={{ fontFamily: DS.fontUI, fontSize: 26, fontWeight: 700, color: DS.fg1, lineHeight: 1 }}>{cites}</div>
            <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg4, marginTop: 4 }}>citations this month</div>
          </Card>
        ))}
      </div>

      {/* Most-cited content + optimization queue */}
      <div className="cms-dash-cols" style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20, alignItems: 'start' }}>
        <Card pad={0}>
          <div style={{ padding: '16px 20px', borderBottom: `1px solid ${DS.border}` }}><span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Most-Cited by AI</span></div>
          {[['The Elite Club: 4 Artists…', 34],['Black Sherif\u2019s Second Crown', 21],['Every Hiplife Winner…', 14]].map(([t, n], i) => (
            <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 12, padding: '13px 20px', borderBottom: i < 2 ? `1px solid ${DS.border}` : 'none' }}>
              <div style={{ width: 30, height: 30, borderRadius: 8, background: DS.aiSoft, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}><Icon name="sparkles" size={15} color={DS.aiTo} /></div>
              <span style={{ flex: 1, fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: DS.fg1, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{t}</span>
              <span style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 700, color: DS.aiTo }}>{n}×</span>
            </div>
          ))}
        </Card>
        <Card pad={0}>
          <div style={{ padding: '16px 20px', borderBottom: `1px solid ${DS.border}` }}><span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Optimization Queue</span></div>
          {[['Add Quick Answer block', 'Sarkodie vs Stonebwoy'],['Add FAQ schema', 'How TGMA Voting Works'],['Cite sources inline', '2019 Annulment']].map(([action, post], i) => (
            <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 12, padding: '13px 20px', borderBottom: i < 2 ? `1px solid ${DS.border}` : 'none' }}>
              <div style={{ flex: 1, minWidth: 0 }}>
                <div style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: DS.fg1 }}>{action}</div>
                <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg4, marginTop: 1 }}>{post}</div>
              </div>
              <Btn variant="ai" size="sm" icon="sparkles">Optimize</Btn>
            </div>
          ))}
        </Card>
      </div>
    </div>
  );
}

/* ── SETTINGS ──────────────────────────────────────────── */
function Settings({ accent }) {
  const [section, setSection] = React.useState('general');
  const [toggles, setToggles] = React.useState({ comments: true, ai: true, newsletter: true, maintenance: false, indexing: true });
  const set = (k) => setToggles(t => ({ ...t, [k]: !t[k] }));
  const nav = [['general','General','settings'],['publishing','Publishing','file-text'],['integrations','Integrations','globe'],['advanced','Advanced','database']];
  return (
    <div className="cms-settings" style={{ display: 'grid', gridTemplateColumns: '200px 1fr', gap: 24, alignItems: 'start' }}>
      <div style={{ display: 'flex', flexDirection: 'column', gap: 2 }}>
        {nav.map(([key, label, icon]) => (
          <button key={key} onClick={() => setSection(key)} style={{ display: 'flex', alignItems: 'center', gap: 10, padding: '10px 12px', border: 'none', borderRadius: DS.rMd, cursor: 'pointer', background: section === key ? DS.surface : 'transparent', boxShadow: section === key ? DS.shCard : 'none', fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: section === key ? 600 : 500, color: section === key ? DS.fg1 : DS.fg3, textAlign: 'left' }}>
            <Icon name={icon} size={16} stroke={2} color={section === key ? accent : DS.fg4} />{label}
          </button>
        ))}
      </div>
      <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
        {section === 'general' && (
          <Card>
            <div style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1, marginBottom: 18 }}>Site Identity</div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
              <Field label="Site name" value="Debesties" />
              <Field label="Tagline" value="Ghana's definitive music awards record" />
              <Field label="Site URL" value="https://debesties.com" prefix="🌐" mono />
              <Field label="Default category" value="Awards History" />
            </div>
          </Card>
        )}
        {(section === 'general' || section === 'publishing') && (
          <Card>
            <div style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1, marginBottom: 6 }}>Preferences</div>
            {[['comments','Allow comments','Let readers comment on published posts'],['ai','AI visibility tools','Enable AI answer optimization features'],['newsletter','Newsletter signups','Show subscribe forms on articles'],['indexing','Search engine indexing','Allow Google to index this site'],['maintenance','Maintenance mode','Take the site offline for visitors']].map(([k, label, desc], i, arr) => (
              <div key={k} style={{ display: 'flex', alignItems: 'center', gap: 14, padding: '14px 0', borderBottom: i < arr.length - 1 ? `1px solid ${DS.border}` : 'none' }}>
                <div style={{ flex: 1 }}>
                  <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1 }}>{label}</div>
                  <div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg4, marginTop: 1 }}>{desc}</div>
                </div>
                <Toggle on={toggles[k]} onChange={() => set(k)} />
              </div>
            ))}
          </Card>
        )}
        {section === 'integrations' && (
          <Card>
            <div style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1, marginBottom: 16 }}>Connected Services</div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 10 }}>
              {[['Google Search Console','Connected',true],['Google Analytics 4','Connected',true],['Mailchimp','Connected',true],['Cloudflare CDN','Not connected',false],['X (Twitter) auto-post','Not connected',false]].map(([name, st, on], i) => (
                <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 12, padding: '12px 14px', border: `1px solid ${DS.border}`, borderRadius: DS.rMd }}>
                  <div style={{ width: 34, height: 34, borderRadius: 8, background: on ? DS.greenSoft : '#EFEBE3', display: 'flex', alignItems: 'center', justifyContent: 'center', color: on ? DS.green : DS.fg4 }}><Icon name="globe" size={17} /></div>
                  <div style={{ flex: 1 }}><div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1 }}>{name}</div><div style={{ fontFamily: DS.fontUI, fontSize: 12, color: on ? DS.green : DS.fg4 }}>{st}</div></div>
                  <Btn variant="soft" size="sm">{on ? 'Manage' : 'Connect'}</Btn>
                </div>
              ))}
            </div>
          </Card>
        )}
        {section === 'advanced' && (
          <Card>
            <div style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1, marginBottom: 16 }}>Advanced</div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 14 }}>
              <Field label="Custom CSS" textarea rows={4} value=":root { --accent: #E8A800; }" mono />
              <div style={{ padding: '14px 16px', background: DS.redSoft, borderRadius: DS.rMd, display: 'flex', alignItems: 'center', gap: 12 }}>
                <Icon name="alert-triangle" size={18} color={DS.red} />
                <div style={{ flex: 1 }}><div style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: DS.redDeep }}>Danger zone</div><div style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.red }}>Export or permanently delete all site data.</div></div>
                <Btn variant="danger" size="sm">Export</Btn>
              </div>
            </div>
          </Card>
        )}
        <div style={{ display: 'flex', justifyContent: 'flex-end', gap: 10 }}>
          <Btn variant="soft">Cancel</Btn><Btn variant="primary" icon="save">Save changes</Btn>
        </div>
      </div>
    </div>
  );
}

/* ── NAVIGATION BUILDER ────────────────────────────────── */
function NavBuilder({ accent }) {
  const items = [['Home','/',true],['Awards History','/awards-history',false],['Profiles','/profiles',false],['Analysis','/analysis',false],['About','/about',false]];
  return (
    <div className="cms-dash-cols" style={{ display: 'grid', gridTemplateColumns: '1fr 360px', gap: 20, alignItems: 'start' }}>
      <Card pad={0}>
        <div style={{ padding: '16px 20px', borderBottom: `1px solid ${DS.border}`, display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
          <span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Primary Menu</span>
          <Btn variant="soft" size="sm" icon="plus">Add item</Btn>
        </div>
        <div style={{ padding: 14, display: 'flex', flexDirection: 'column', gap: 8 }}>
          {items.map(([label, url, home], i) => (
            <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 11, padding: '11px 14px', border: `1px solid ${DS.border}`, borderRadius: DS.rMd, background: '#FBF9F5' }}>
              <Icon name="grip" size={16} color={DS.fg4} />
              <Icon name={home ? 'home' : 'file-text'} size={15} color={DS.fg3} />
              <div style={{ flex: 1 }}><div style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1 }}>{label}</div><div style={{ fontFamily: DS.fontMono, fontSize: 11, color: DS.fg4 }}>{url}</div></div>
              <button style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg4, display: 'flex' }}><Icon name="edit" size={15} /></button>
              <button style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg4, display: 'flex' }}><Icon name="trash" size={15} /></button>
            </div>
          ))}
        </div>
      </Card>
      <Card>
        <div style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 700, color: DS.fg2, marginBottom: 14 }}>Live Preview</div>
        <div style={{ borderRadius: DS.rMd, border: `1px solid ${DS.border}`, overflow: 'hidden' }}>
          <div style={{ background: DS.fg1, padding: '14px 16px', display: 'flex', alignItems: 'center', gap: 14, flexWrap: 'wrap' }}>
            <span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: '#fff' }}>debesties</span>
            {items.map(([l]) => <span key={l} style={{ fontFamily: DS.fontUI, fontSize: 12, color: 'rgba(255,255,255,0.7)' }}>{l}</span>)}
          </div>
        </div>
      </Card>
    </div>
  );
}

/* ── HOMEPAGE BUILDER ──────────────────────────────────── */
function HomeBuilder({ accent }) {
  const blocks = [['Hero — Featured Story','star',DS.gold],['Latest Stories Grid','layout-dashboard',DS.blue],['The Elite Club Strip','flame',DS.red],['Trending Categories','folder',DS.green],['Newsletter Signup','message-square',DS.aiTo]];
  return (
    <div className="cms-dash-cols" style={{ display: 'grid', gridTemplateColumns: '1fr 360px', gap: 20, alignItems: 'start' }}>
      <Card pad={0}>
        <div style={{ padding: '16px 20px', borderBottom: `1px solid ${DS.border}`, display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
          <span style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>Page Sections</span>
          <Btn variant="soft" size="sm" icon="plus">Add section</Btn>
        </div>
        <div style={{ padding: 14, display: 'flex', flexDirection: 'column', gap: 8 }}>
          {blocks.map(([label, icon, color], i) => (
            <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 12, padding: '13px 14px', border: `1px solid ${DS.border}`, borderRadius: DS.rMd }}>
              <Icon name="grip" size={16} color={DS.fg4} />
              <div style={{ width: 32, height: 32, borderRadius: 8, background: `${color}1A`, color, display: 'flex', alignItems: 'center', justifyContent: 'center' }}><Icon name={icon} size={16} stroke={2} /></div>
              <span style={{ flex: 1, fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1 }}>{label}</span>
              <Toggle on={true} onChange={() => {}} size="sm" />
              <button style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg4, display: 'flex' }}><Icon name="settings" size={15} /></button>
            </div>
          ))}
        </div>
      </Card>
      <Card>
        <div style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 700, color: DS.fg2, marginBottom: 14 }}>Homepage Preview</div>
        <div style={{ borderRadius: DS.rMd, border: `1px solid ${DS.border}`, overflow: 'hidden', display: 'flex', flexDirection: 'column', gap: 4, padding: 8, background: '#FBF9F5' }}>
          <div style={{ height: 60, borderRadius: 6, background: 'linear-gradient(135deg,#1A1410,#4D3000)' }}></div>
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3,1fr)', gap: 4 }}>{[0,1,2].map(i => <div key={i} style={{ height: 36, borderRadius: 6, background: DS.border }}></div>)}</div>
          <div style={{ height: 44, borderRadius: 6, background: DS.fg1 }}></div>
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(2,1fr)', gap: 4 }}>{[0,1].map(i => <div key={i} style={{ height: 28, borderRadius: 6, background: DS.border }}></div>)}</div>
          <div style={{ height: 32, borderRadius: 6, background: DS.aiSoft }}></div>
        </div>
      </Card>
    </div>
  );
}

/* ── LOADING / ERROR STATES ────────────────────────────── */
function LoadingState() {
  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
      <div className="cms-stat-grid" style={{ display: 'grid', gridTemplateColumns: 'repeat(4,1fr)', gap: 14 }}>
        {[0,1,2,3].map(i => (
          <Card key={i} pad={18}>
            <div className="cms-shimmer" style={{ width: 38, height: 38, borderRadius: 9, marginBottom: 14 }}></div>
            <div className="cms-shimmer" style={{ width: '60%', height: 22, borderRadius: 6, marginBottom: 8 }}></div>
            <div className="cms-shimmer" style={{ width: '40%', height: 12, borderRadius: 6 }}></div>
          </Card>
        ))}
      </div>
      <Card>
        {[0,1,2,3,4].map(i => (
          <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 14, padding: '12px 0', borderBottom: i < 4 ? `1px solid ${DS.border}` : 'none' }}>
            <div className="cms-shimmer" style={{ width: 52, height: 38, borderRadius: 7 }}></div>
            <div style={{ flex: 1 }}><div className="cms-shimmer" style={{ width: '70%', height: 14, borderRadius: 6, marginBottom: 7 }}></div><div className="cms-shimmer" style={{ width: '40%', height: 11, borderRadius: 6 }}></div></div>
            <div className="cms-shimmer" style={{ width: 60, height: 22, borderRadius: 999 }}></div>
          </div>
        ))}
      </Card>
    </div>
  );
}

function ErrorState({ onRetry }) {
  return (
    <Card style={{ minHeight: 400, display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
      <EmptyState icon="alert-triangle" title="Something went wrong" body="We couldn't load this data. Check your connection and try again."
        action={<Btn variant="primary" icon="refresh" onClick={onRetry}>Retry</Btn>} />
    </Card>
  );
}

Object.assign(window, { UsersRoles, SeoTools, AiVisibility, Settings, NavBuilder, HomeBuilder, LoadingState, ErrorState });
