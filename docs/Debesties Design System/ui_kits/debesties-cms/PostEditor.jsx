// Debesties CMS — Post Editor
// Exports to window: PostEditor

/* ── Small building blocks ─────────────────────────────── */
function EditorBlock({ icon, title, desc, color, children, action }) {
  return (
    <div style={{ border: `1px solid ${DS.border}`, borderRadius: DS.rLg, background: DS.surface, overflow: 'hidden' }}>
      <div style={{ display: 'flex', alignItems: 'center', gap: 11, padding: '14px 18px', borderBottom: `1px solid ${DS.border}`, background: '#FBF9F5' }}>
        <div style={{ width: 30, height: 30, borderRadius: 8, background: `${color}1A`, color, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
          <Icon name={icon} size={16} stroke={2} />
        </div>
        <div style={{ flex: 1 }}>
          <div style={{ fontFamily: DS.fontUI, fontSize: 14, fontWeight: 700, color: DS.fg1 }}>{title}</div>
          {desc && <div style={{ fontFamily: DS.fontUI, fontSize: 11.5, color: DS.fg4, marginTop: 1 }}>{desc}</div>}
        </div>
        {action}
      </div>
      <div style={{ padding: 18 }}>{children}</div>
    </div>
  );
}

function RailSection({ title, children, action }) {
  return (
    <div style={{ borderBottom: `1px solid ${DS.border}`, padding: '16px 18px' }}>
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: 12 }}>
        <span style={{ fontFamily: DS.fontUI, fontSize: 12, fontWeight: 700, letterSpacing: '0.06em', textTransform: 'uppercase', color: DS.fg3 }}>{title}</span>
        {action}
      </div>
      {children}
    </div>
  );
}

function PostEditor({ post, onBack, accent }) {
  const isNew = !post;
  const [tab, setTab] = React.useState('content');
  const [title, setTitle] = React.useState(post?.title || '');
  const [slug, setSlug] = React.useState(post?.slug || '');
  const [subtitle, setSubtitle] = React.useState(isNew ? '' : 'The four artists who turned a single win into a dynasty.');
  const [status, setStatus] = React.useState(post?.status || 'draft');
  const [category, setCategory] = React.useState(post?.category || 'Awards History');
  const [catOpen, setCatOpen] = React.useState(false);
  const [tags, setTags] = React.useState(post?.tags || ['TGMA']);
  const [tagInput, setTagInput] = React.useState('');
  const [focusKw, setFocusKw] = React.useState(isNew ? '' : 'artiste of the year double winners');
  const [seoTitle, setSeoTitle] = React.useState(isNew ? '' : 'TGMA Double Winners: The 4-Artist Elite Club (1999–2026)');
  const [metaDesc, setMetaDesc] = React.useState(isNew ? '' : 'Only four acts have won Ghana\u2019s Artiste of the Year twice. Meet V.I.P, Sarkodie, Stonebwoy & Black Sherif — and the eras that made them.');
  const [intent, setIntent] = React.useState('Informational');
  const [schema, setSchema] = React.useState('Article');
  const [quickAnswer, setQuickAnswer] = React.useState(isNew ? '' : 'Four artists have won the TGMA Artiste of the Year award twice: V.I.P, Sarkodie, Stonebwoy, and Black Sherif.');
  const [showSchedule, setShowSchedule] = React.useState(false);
  const [showRevisions, setShowRevisions] = React.useState(false);
  const [saved, setSaved] = React.useState(false);

  const seoScore = post?.seo ?? 58;

  const autoSlug = (t) => t.toLowerCase().replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-').slice(0, 60);
  React.useEffect(() => { if (isNew && title && !slug) setSlug(autoSlug(title)); }, [title]);

  const addTag = () => { if (tagInput.trim() && !tags.includes(tagInput.trim())) { setTags([...tags, tagInput.trim()]); setTagInput(''); } };

  const cats = ['Awards History', 'Profiles', 'Analysis', 'Explainers', 'News', 'Interviews'];

  const tabs = [
    { value: 'content', label: 'Content', icon: 'pen-tool' },
    { value: 'seo', label: 'SEO', icon: 'search-check' },
    { value: 'ai', label: 'AI Visibility', icon: 'sparkles' },
  ];

  const doSave = () => { setSaved(true); setTimeout(() => setSaved(false), 1800); };

  return (
    <div style={{ display: 'flex', flexDirection: 'column', minHeight: '100%', margin: -24 }}>
      {/* Editor topbar */}
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', padding: '14px 24px', borderBottom: `1px solid ${DS.border}`, background: 'rgba(244,241,236,0.9)', backdropFilter: 'blur(10px)', position: 'sticky', top: 64, zIndex: 60, gap: 16, flexWrap: 'wrap' }}>
        <div style={{ display: 'flex', alignItems: 'center', gap: 14, minWidth: 0 }}>
          <Btn variant="soft" size="sm" icon="chevron-left" onClick={onBack}>Posts</Btn>
          <div style={{ minWidth: 0 }}>
            <div style={{ fontFamily: DS.fontUI, fontSize: 14.5, fontWeight: 700, color: DS.fg1, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis', maxWidth: 360 }}>{title || 'Untitled post'}</div>
            <div style={{ display: 'flex', alignItems: 'center', gap: 8, marginTop: 2 }}>
              <Badge tone={status}>{status === 'review' ? 'In Review' : status}</Badge>
              <span style={{ fontFamily: DS.fontUI, fontSize: 11.5, color: saved ? DS.green : DS.fg4, display: 'inline-flex', alignItems: 'center', gap: 4 }}>
                {saved ? <><Icon name="check" size={12} stroke={2.5} />Saved</> : 'Autosaved 2m ago'}
              </span>
            </div>
          </div>
        </div>
        <div style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
          <Btn variant="ghost" size="md" icon="clock" onClick={() => setShowRevisions(true)} title="Revision history">History</Btn>
          <Btn variant="ghost" size="md" icon="eye">Preview</Btn>
          <Btn variant="soft" size="md" icon="save" onClick={doSave}>Save draft</Btn>
          <Btn variant="ghost" size="md" icon="clock" onClick={() => setShowSchedule(true)}>Schedule</Btn>
          <Btn variant="primary" size="md" icon="send" onClick={() => setStatus('published')}>Publish</Btn>
        </div>
      </div>

      {/* Tabs */}
      <div style={{ padding: '14px 24px 0', display: 'flex', justifyContent: 'center', borderBottom: `1px solid ${DS.border}` }}>
        <div style={{ paddingBottom: 14 }}>
          <SegTabs tabs={tabs} active={tab} onChange={setTab} />
        </div>
      </div>

      {/* Body: editor + rail */}
      <div className="cms-editor-cols" style={{ display: 'grid', gridTemplateColumns: 'minmax(0,1fr) 320px', flex: 1, alignItems: 'start' }}>
        {/* MAIN COLUMN */}
        <div style={{ padding: '28px 32px', maxWidth: 760, margin: '0 auto', width: '100%', display: 'flex', flexDirection: 'column', gap: 22 }}>
          {tab === 'content' && (
            <>
              {/* Title + subtitle inline */}
              <div>
                <textarea value={title} onChange={e => setTitle(e.target.value)} placeholder="Post title…" rows={1}
                  style={{ width: '100%', border: 'none', outline: 'none', background: 'none', resize: 'none', fontFamily: DS.fontDisp, fontSize: 34, fontWeight: 800, color: DS.fg1, lineHeight: 1.15, letterSpacing: '-0.02em', overflow: 'hidden' }}
                  onInput={e => { e.target.style.height = 'auto'; e.target.style.height = e.target.scrollHeight + 'px'; }} />
                <input value={subtitle} onChange={e => setSubtitle(e.target.value)} placeholder="Add a subtitle or deck…"
                  style={{ width: '100%', border: 'none', outline: 'none', background: 'none', fontFamily: DS.fontUI, fontSize: 17, fontWeight: 400, color: DS.fg3, marginTop: 8, lineHeight: 1.4 }} />
                <div style={{ display: 'flex', alignItems: 'center', gap: 7, marginTop: 12, fontFamily: DS.fontMono, fontSize: 12, color: DS.fg4 }}>
                  <Icon name="link" size={13} />debesties.com/<input value={slug} onChange={e => setSlug(e.target.value)} placeholder="post-slug" style={{ border: 'none', outline: 'none', background: 'none', fontFamily: DS.fontMono, fontSize: 12, color: accent, fontWeight: 600, flex: 1, minWidth: 0 }} />
                </div>
              </div>

              {/* Body editor toolbar + content */}
              <div style={{ border: `1px solid ${DS.border}`, borderRadius: DS.rLg, overflow: 'hidden' }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: 2, padding: '8px 10px', borderBottom: `1px solid ${DS.border}`, background: '#FBF9F5', flexWrap: 'wrap' }}>
                  {['B', 'I', 'U'].map(b => <button key={b} style={{ width: 30, height: 30, border: 'none', background: 'none', cursor: 'pointer', borderRadius: 6, fontFamily: 'Georgia, serif', fontSize: 14, fontWeight: b === 'B' ? 700 : 400, fontStyle: b === 'I' ? 'italic' : 'normal', textDecoration: b === 'U' ? 'underline' : 'none', color: DS.fg2 }} onMouseEnter={e => e.currentTarget.style.background = '#EFEBE3'} onMouseLeave={e => e.currentTarget.style.background = 'none'}>{b}</button>)}
                  <span style={{ width: 1, height: 18, background: DS.border, margin: '0 6px' }}></span>
                  {[['H1','book-open'],['Quote','quote'],['List','list'],['Link','link'],['Image','image']].map(([l, ic]) => <button key={l} style={{ display: 'flex', alignItems: 'center', gap: 5, height: 30, padding: '0 9px', border: 'none', background: 'none', cursor: 'pointer', borderRadius: 6, fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 500, color: DS.fg2 }} onMouseEnter={e => e.currentTarget.style.background = '#EFEBE3'} onMouseLeave={e => e.currentTarget.style.background = 'none'}><Icon name={ic} size={14} stroke={2} />{l}</button>)}
                </div>
                <div style={{ padding: '18px 20px', minHeight: 200, fontFamily: DS.fontUI, fontSize: 15, lineHeight: 1.7, color: DS.fg2 }}>
                  {isNew ? (
                    <span style={{ color: DS.fg4 }}>Start writing your story… Type <b style={{ color: accent }}>/</b> to insert a block (Quick Answer, Key Facts, FAQ, Sources).</span>
                  ) : (
                    <>
                      <p style={{ margin: '0 0 16px' }}>In 27 years of the Ghana Music Awards, the <b>Artiste of the Year</b> crown has changed hands more often than not. But a rare few have managed to win it twice — joining what fans now call <i>The Elite Club</i>.</p>
                      <p style={{ margin: 0 }}>From V.I.P's Hiplife dominance to Black Sherif's Afrobeats-era surge, these four acts span every major shift in Ghanaian popular music…</p>
                    </>
                  )}
                </div>
              </div>

              {/* Quick Answer block */}
              <EditorBlock icon="circle-dot" title="Quick Answer" desc="Surfaces in Google & AI answer boxes" color={DS.gold}>
                <Field textarea value={quickAnswer} onChange={setQuickAnswer} rows={2} placeholder="Write a concise 1–2 sentence answer to the core question…" counter max={300} />
              </EditorBlock>

              {/* Key Facts block */}
              <EditorBlock icon="list-checks" title="Key Facts" desc="Scannable bullet facts" color={DS.green}
                action={<Btn variant="soft" size="sm" icon="plus">Add fact</Btn>}>
                <div style={{ display: 'flex', flexDirection: 'column', gap: 8 }}>
                  {['First double winner: V.I.P (2004, 2011)','Most recent: Black Sherif (2023, 2026)','Only annulled year: 2019','Total unique winners: 24'].map((f, i) => (
                    <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 10, padding: '9px 12px', background: '#FBF9F5', borderRadius: 8, border: `1px solid ${DS.border}` }}>
                      <Icon name="grip" size={15} color={DS.fg4} />
                      <Icon name="check" size={15} color={DS.green} stroke={2.5} />
                      <span style={{ flex: 1, fontFamily: DS.fontUI, fontSize: 13.5, color: DS.fg1 }}>{f}</span>
                      <button style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg4, display: 'flex' }}><Icon name="x" size={15} /></button>
                    </div>
                  ))}
                </div>
              </EditorBlock>

              {/* FAQ builder */}
              <EditorBlock icon="circle-help" title="FAQ Builder" desc="Generates FAQPage schema automatically" color={DS.blue}
                action={<Btn variant="soft" size="sm" icon="plus">Add question</Btn>}>
                <div style={{ display: 'flex', flexDirection: 'column', gap: 10 }}>
                  {[['Who has won TGMA Artiste of the Year twice?','V.I.P, Sarkodie, Stonebwoy, and Black Sherif.'],['Why was the 2019 award annulled?','The board annulled the category citing voting irregularities.']].map((qa, i) => (
                    <div key={i} style={{ border: `1px solid ${DS.border}`, borderRadius: 9, overflow: 'hidden' }}>
                      <div style={{ display: 'flex', alignItems: 'center', gap: 9, padding: '10px 12px', background: '#FBF9F5' }}>
                        <Icon name="grip" size={14} color={DS.fg4} />
                        <Icon name="chevron-down" size={15} color={DS.fg3} />
                        <span style={{ flex: 1, fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1 }}>{qa[0]}</span>
                        <button style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg4, display: 'flex' }}><Icon name="trash" size={14} /></button>
                      </div>
                      <div style={{ padding: '10px 12px 10px 35px', fontFamily: DS.fontUI, fontSize: 13, color: DS.fg2, lineHeight: 1.5 }}>{qa[1]}</div>
                    </div>
                  ))}
                </div>
              </EditorBlock>

              {/* Sources / citations */}
              <EditorBlock icon="book-open" title="Sources & Citations" desc="Builds trust signals for E-E-A-T" color={DS.aiTo}
                action={<Btn variant="soft" size="sm" icon="plus">Add source</Btn>}>
                <div style={{ display: 'flex', flexDirection: 'column', gap: 8 }}>
                  {[['Ghana Music Awards — Official Winners Archive','ghanamusicawards.com'],['Citi Newsroom — TGMA 2026 Recap','citinewsroom.com']].map((s, i) => (
                    <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 11, padding: '10px 12px', background: '#FBF9F5', borderRadius: 8, border: `1px solid ${DS.border}` }}>
                      <span style={{ fontFamily: DS.fontMono, fontSize: 12, fontWeight: 700, color: DS.fg4 }}>[{i + 1}]</span>
                      <div style={{ flex: 1, minWidth: 0 }}>
                        <div style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: DS.fg1 }}>{s[0]}</div>
                        <div style={{ fontFamily: DS.fontMono, fontSize: 11, color: DS.blue }}>{s[1]}</div>
                      </div>
                      <Icon name="external-link" size={14} color={DS.fg4} />
                    </div>
                  ))}
                </div>
              </EditorBlock>
            </>
          )}

          {tab === 'seo' && <SeoTab {...{ focusKw, setFocusKw, seoTitle, setSeoTitle, metaDesc, setMetaDesc, intent, setIntent, schema, setSchema, slug, title, seoScore, accent }} />}
          {tab === 'ai' && <AiTab {...{ quickAnswer, title, accent }} />}
        </div>

        {/* RIGHT RAIL */}
        <aside className="cms-editor-rail" style={{ borderLeft: `1px solid ${DS.border}`, background: DS.surface, position: 'sticky', top: 129, alignSelf: 'stretch', minHeight: 'calc(100vh - 129px)' }}>
          {/* Publish box */}
          <RailSection title="Publish">
            <div style={{ display: 'flex', flexDirection: 'column', gap: 10 }}>
              <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                <span style={{ fontFamily: DS.fontUI, fontSize: 13, color: DS.fg3 }}>Status</span>
                <div style={{ position: 'relative' }}>
                  <Badge tone={status}>{status === 'review' ? 'In Review' : status}</Badge>
                </div>
              </div>
              <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                <span style={{ fontFamily: DS.fontUI, fontSize: 13, color: DS.fg3 }}>Visibility</span>
                <span style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: DS.fg1 }}>Public</span>
              </div>
              <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                <span style={{ fontFamily: DS.fontUI, fontSize: 13, color: DS.fg3 }}>Publish date</span>
                <span style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: DS.fg1 }}>{post?.date && post.date !== 'Draft' ? post.date : 'Immediately'}</span>
              </div>
              {/* Workflow stepper */}
              <div style={{ display: 'flex', alignItems: 'center', gap: 0, marginTop: 6 }}>
                {['Draft', 'Review', 'Schedule', 'Publish'].map((st, i) => {
                  const order = ['draft', 'review', 'scheduled', 'published'];
                  const cur = order.indexOf(status);
                  const done = i <= cur;
                  return (
                    <React.Fragment key={st}>
                      <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'center', gap: 4 }}>
                        <div style={{ width: 22, height: 22, borderRadius: 999, display: 'flex', alignItems: 'center', justifyContent: 'center', background: done ? DS.green : '#EFEBE3', color: done ? '#fff' : DS.fg4, fontFamily: DS.fontUI, fontSize: 10, fontWeight: 700 }}>
                          {done ? <Icon name="check" size={12} stroke={3} /> : i + 1}
                        </div>
                        <span style={{ fontFamily: DS.fontUI, fontSize: 9.5, color: done ? DS.fg2 : DS.fg4, fontWeight: 600 }}>{st}</span>
                      </div>
                      {i < 3 && <div style={{ flex: 1, height: 2, background: i < cur ? DS.green : DS.border, marginBottom: 16 }}></div>}
                    </React.Fragment>
                  );
                })}
              </div>
              <div style={{ display: 'flex', gap: 8, marginTop: 4 }}>
                <Btn variant="soft" size="sm" full onClick={() => setStatus('review')}>Submit review</Btn>
                <Btn variant="primary" size="sm" full icon="send" onClick={() => setStatus('published')}>Publish</Btn>
              </div>
            </div>
          </RailSection>

          {/* SEO score mini */}
          <RailSection title="SEO Health" action={<span style={{ fontFamily: DS.fontUI, fontSize: 11.5, fontWeight: 600, color: accent, cursor: 'pointer' }} onClick={() => setTab('seo')}>Open SEO</span>}>
            <div style={{ display: 'flex', alignItems: 'center', gap: 14 }}>
              <ScoreRing score={seoScore} size={52} stroke={5} />
              <div style={{ flex: 1 }}>
                <div style={{ fontFamily: DS.fontUI, fontSize: 13, fontWeight: 600, color: DS.fg1 }}>{seoScore >= 80 ? 'Great' : seoScore >= 50 ? 'Needs work' : 'Poor'}</div>
                <div style={{ fontFamily: DS.fontUI, fontSize: 11.5, color: DS.fg3, marginTop: 2 }}>3 of 8 checks need attention</div>
              </div>
            </div>
          </RailSection>

          {/* Featured image */}
          <RailSection title="Featured Image">
            <div style={{ borderRadius: DS.rMd, overflow: 'hidden', border: `1px solid ${DS.border}` }}>
              <div style={{ aspectRatio: '16/9', background: post?.grad || 'linear-gradient(135deg,#1A1410,#4D3000)', display: 'flex', alignItems: 'center', justifyContent: 'center', position: 'relative' }}>
                <Icon name="image" size={26} color="rgba(255,255,255,0.55)" />
                <div style={{ position: 'absolute', inset: 0, display: 'flex', alignItems: 'flex-end', padding: 8, opacity: 0, transition: 'opacity 160ms' }}
                  onMouseEnter={e => e.currentTarget.style.opacity = 1} onMouseLeave={e => e.currentTarget.style.opacity = 0}>
                </div>
              </div>
              <div style={{ display: 'flex', gap: 6, padding: 8 }}>
                <Btn variant="soft" size="sm" icon="upload" full>Replace</Btn>
              </div>
            </div>
          </RailSection>

          {/* Category */}
          <RailSection title="Category">
            <div style={{ position: 'relative' }}>
              <button onClick={() => setCatOpen(o => !o)} style={{ width: '100%', display: 'flex', alignItems: 'center', justifyContent: 'space-between', padding: '9px 12px', border: `1.5px solid ${DS.border}`, borderRadius: DS.rMd, background: DS.surface, cursor: 'pointer', fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 500, color: DS.fg1 }}>
                {category}<Icon name="chevron-down" size={15} color={DS.fg4} />
              </button>
              {catOpen && (
                <div style={{ position: 'absolute', top: 42, left: 0, right: 0, background: DS.surface, borderRadius: DS.rMd, boxShadow: DS.shPop, border: `1px solid ${DS.border}`, zIndex: 50, padding: 5, animation: 'dsPop 150ms ease' }}>
                  {cats.map(c => (
                    <button key={c} onClick={() => { setCategory(c); setCatOpen(false); }} style={{ display: 'block', width: '100%', textAlign: 'left', padding: '8px 10px', border: 'none', background: category === c ? DS.goldSoft : 'transparent', borderRadius: 6, cursor: 'pointer', fontFamily: DS.fontUI, fontSize: 13, fontWeight: category === c ? 600 : 500, color: DS.fg1 }}>{c}</button>
                  ))}
                </div>
              )}
            </div>
          </RailSection>

          {/* Tags */}
          <RailSection title="Tags">
            <div style={{ display: 'flex', flexWrap: 'wrap', gap: 6, marginBottom: 10 }}>
              {tags.map(t => (
                <span key={t} style={{ display: 'inline-flex', alignItems: 'center', gap: 5, background: '#EFEBE3', color: DS.fg2, fontFamily: DS.fontUI, fontSize: 12, fontWeight: 500, padding: '4px 8px 4px 10px', borderRadius: 999 }}>
                  {t}<button onClick={() => setTags(tags.filter(x => x !== t))} style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg4, display: 'flex', padding: 0 }}><Icon name="x" size={12} stroke={2.5} /></button>
                </span>
              ))}
            </div>
            <div style={{ display: 'flex', alignItems: 'center', gap: 6, border: `1.5px solid ${DS.border}`, borderRadius: DS.rMd, padding: '0 10px', height: 36 }}>
              <Icon name="tag" size={14} color={DS.fg4} />
              <input value={tagInput} onChange={e => setTagInput(e.target.value)} onKeyDown={e => e.key === 'Enter' && addTag()} placeholder="Add tag + Enter" style={{ flex: 1, border: 'none', outline: 'none', background: 'none', fontFamily: DS.fontUI, fontSize: 13, color: DS.fg1, minWidth: 0 }} />
            </div>
          </RailSection>

          {/* Related posts */}
          <RailSection title="Related Posts" action={<Btn variant="soft" size="sm" icon="plus">Add</Btn>}>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 8 }}>
              {POSTS.slice(1, 3).map(p => (
                <div key={p.id} style={{ display: 'flex', alignItems: 'center', gap: 9 }}>
                  <div style={{ width: 36, height: 28, borderRadius: 6, background: p.grad, flexShrink: 0 }}></div>
                  <span style={{ flex: 1, fontFamily: DS.fontUI, fontSize: 12, color: DS.fg2, lineHeight: 1.3, display: '-webkit-box', WebkitLineClamp: 2, WebkitBoxOrient: 'vertical', overflow: 'hidden' }}>{p.title}</span>
                </div>
              ))}
            </div>
          </RailSection>

          {/* Internal links suggestions */}
          <RailSection title="Internal Link Suggestions">
            <div style={{ display: 'flex', flexDirection: 'column', gap: 8 }}>
              {[['Sarkodie', 'sarkodie-stonebwoy-stats'],['Hiplife era', 'hiplife-era-tgma-winners']].map((s, i) => (
                <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 9, padding: '8px 10px', background: DS.blueSoft, borderRadius: 8 }}>
                  <Icon name="link" size={14} color={DS.blue} />
                  <span style={{ flex: 1, fontFamily: DS.fontUI, fontSize: 12, color: DS.fg2 }}>Link <b>"{s[0]}"</b></span>
                  <Btn variant="soft" size="sm" style={{ height: 26, padding: '0 10px', fontSize: 11.5 }}>Add</Btn>
                </div>
              ))}
            </div>
          </RailSection>
        </aside>
      </div>

      {/* Schedule modal */}
      <Modal open={showSchedule} onClose={() => setShowSchedule(false)} title="Schedule Post" width={420}
        footer={<><Btn variant="soft" onClick={() => setShowSchedule(false)}>Cancel</Btn><Btn variant="primary" icon="clock" onClick={() => { setStatus('scheduled'); setShowSchedule(false); }}>Schedule</Btn></>}>
        <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
          <Field label="Publish date" value="June 12, 2026" />
          <Field label="Time (GMT)" value="08:00 AM" />
          <div style={{ display: 'flex', alignItems: 'center', gap: 10, padding: '12px 14px', background: DS.blueSoft, borderRadius: DS.rMd }}>
            <Icon name="globe" size={16} color={DS.blue} />
            <span style={{ fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg2 }}>Will auto-publish & ping Google for indexing.</span>
          </div>
        </div>
      </Modal>

      {/* Revision history modal */}
      <Modal open={showRevisions} onClose={() => setShowRevisions(false)} title="Revision History" width={540}
        footer={<Btn variant="soft" onClick={() => setShowRevisions(false)}>Close</Btn>}>
        <div style={{ position: 'relative' }}>
          <div style={{ position: 'absolute', left: 15, top: 6, bottom: 6, width: 2, background: DS.border }}></div>
          {REVISIONS.map((r, i) => (
            <div key={r.id} style={{ display: 'flex', gap: 14, paddingBottom: i < REVISIONS.length - 1 ? 18 : 0, position: 'relative' }}>
              <div style={{ width: 32, height: 32, borderRadius: 999, flexShrink: 0, display: 'flex', alignItems: 'center', justifyContent: 'center', zIndex: 1, background: r.current ? DS.gold : DS.surface, border: `2px solid ${r.current ? DS.gold : DS.borderSt}`, color: r.current ? '#1A1410' : DS.fg4 }}>
                <Icon name={r.current ? 'circle-dot' : 'circle'} size={14} stroke={2} />
              </div>
              <div style={{ flex: 1, minWidth: 0, paddingTop: 1 }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: 8, flexWrap: 'wrap' }}>
                  <span style={{ fontFamily: DS.fontUI, fontSize: 13.5, fontWeight: 600, color: DS.fg1 }}>{r.label}</span>
                  {r.current && <Badge tone="published" dot={false}>Current</Badge>}
                </div>
                <div style={{ display: 'flex', alignItems: 'center', gap: 8, marginTop: 4 }}>
                  <Avatar name={r.author} size={20} />
                  <span style={{ fontFamily: DS.fontUI, fontSize: 12, color: DS.fg3 }}>{r.author} · {r.time}</span>
                </div>
                <div style={{ display: 'flex', alignItems: 'center', gap: 12, marginTop: 8 }}>
                  <span style={{ fontFamily: DS.fontMono, fontSize: 11, color: DS.fg4 }}>{r.words.toLocaleString()} words</span>
                  {r.change !== '+0' && <span style={{ fontFamily: DS.fontMono, fontSize: 11, fontWeight: 700, color: DS.green }}>{r.change} words</span>}
                  {!r.current && (
                    <div style={{ display: 'flex', gap: 6, marginLeft: 'auto' }}>
                      <Btn variant="soft" size="sm" style={{ height: 28, padding: '0 11px', fontSize: 11.5 }}>Compare</Btn>
                      <Btn variant="soft" size="sm" icon="refresh" style={{ height: 28, padding: '0 11px', fontSize: 11.5 }}>Restore</Btn>
                    </div>
                  )}
                </div>
              </div>
            </div>
          ))}
        </div>
      </Modal>
    </div>
  );
}

/* ── SEO TAB ───────────────────────────────────────────── */
function SeoTab({ focusKw, setFocusKw, seoTitle, setSeoTitle, metaDesc, setMetaDesc, intent, setIntent, schema, setSchema, slug, title, seoScore, accent }) {
  const checks = [
    { label: 'Focus keyword in title', pass: true },
    { label: 'Focus keyword in first paragraph', pass: true },
    { label: 'Meta description 120–160 chars', pass: metaDesc.length >= 120 && metaDesc.length <= 160 },
    { label: 'SEO title under 60 chars', pass: seoTitle.length > 0 && seoTitle.length <= 60 },
    { label: 'At least 3 internal links', pass: false },
    { label: 'Image alt text set', pass: false },
    { label: 'FAQ schema present', pass: true },
    { label: 'Slug is concise', pass: slug.length <= 60 },
  ];
  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 22 }}>
      <EditorBlock icon="gauge" title="Focus Keyword & Intent" color={DS.green}>
        <div style={{ display: 'flex', flexDirection: 'column', gap: 14 }}>
          <Field label="Focus keyword" value={focusKw} onChange={setFocusKw} placeholder="e.g. artiste of the year winners" prefix="🔍" />
          <div>
            <label style={{ fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 600, color: DS.fg2, display: 'block', marginBottom: 8 }}>Search intent</label>
            <SegTabs tabs={['Informational', 'Navigational', 'Commercial', 'Transactional']} active={intent} onChange={setIntent} size="sm" />
          </div>
        </div>
      </EditorBlock>

      <EditorBlock icon="search-check" title="Search Appearance" color={DS.blue}>
        <div style={{ display: 'flex', flexDirection: 'column', gap: 14 }}>
          <Field label="SEO title" value={seoTitle} onChange={setSeoTitle} counter max={60} hint="Appears as the clickable headline in Google results." />
          <Field label="Meta description" value={metaDesc} onChange={setMetaDesc} textarea rows={3} counter max={160} />
          {/* Google preview */}
          <div>
            <div style={{ fontFamily: DS.fontUI, fontSize: 11.5, fontWeight: 700, letterSpacing: '0.05em', textTransform: 'uppercase', color: DS.fg4, marginBottom: 8 }}>Google Preview</div>
            <div style={{ border: `1px solid ${DS.border}`, borderRadius: DS.rMd, padding: '14px 16px', background: '#fff' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: 8, marginBottom: 7 }}>
                <div style={{ width: 26, height: 26, borderRadius: 999, background: `linear-gradient(125deg,${DS.aiFrom},${DS.aiTo})`, display: 'flex', alignItems: 'center', justifyContent: 'center', fontFamily: DS.fontUI, fontWeight: 800, fontSize: 13, color: '#fff' }}>d</div>
                <div><div style={{ fontFamily: 'arial, sans-serif', fontSize: 13, color: '#202124' }}>Debesties</div><div style={{ fontFamily: 'arial, sans-serif', fontSize: 12, color: '#5f6368' }}>https://debesties.com › {slug || 'post-slug'}</div></div>
              </div>
              <div style={{ fontFamily: 'arial, sans-serif', fontSize: 19, color: '#1a0dab', lineHeight: 1.3, marginBottom: 3 }}>{seoTitle || title || 'Your SEO title appears here'}</div>
              <div style={{ fontFamily: 'arial, sans-serif', fontSize: 13.5, color: '#4d5156', lineHeight: 1.5 }}>{metaDesc || 'Your meta description preview will appear here as searchers would see it on Google.'}</div>
            </div>
          </div>
        </div>
      </EditorBlock>

      <EditorBlock icon="database" title="Schema & Structured Data" color={DS.aiTo}>
        <div style={{ display: 'flex', flexWrap: 'wrap', gap: 8 }}>
          {['Article', 'NewsArticle', 'FAQPage', 'Review', 'Person', 'MusicEvent'].map(s => (
            <button key={s} onClick={() => setSchema(s)} style={{ fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 600, padding: '7px 14px', borderRadius: 999, cursor: 'pointer', border: `1.5px solid ${schema === s ? DS.aiTo : DS.border}`, background: schema === s ? DS.aiSoft : DS.surface, color: schema === s ? '#6B3FC0' : DS.fg2 }}>{s}</button>
          ))}
        </div>
      </EditorBlock>

      <EditorBlock icon="list-checks" title="SEO Checklist" color={DS.gold}
        action={<ScoreRing score={seoScore} size={38} stroke={4} />}>
        <div style={{ display: 'flex', flexDirection: 'column', gap: 4 }}>
          {checks.map((c, i) => (
            <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 10, padding: '8px 4px' }}>
              <div style={{ width: 20, height: 20, borderRadius: 999, flexShrink: 0, display: 'flex', alignItems: 'center', justifyContent: 'center', background: c.pass ? DS.greenSoft : DS.redSoft, color: c.pass ? DS.green : DS.red }}>
                <Icon name={c.pass ? 'check' : 'x'} size={12} stroke={3} />
              </div>
              <span style={{ fontFamily: DS.fontUI, fontSize: 13.5, color: c.pass ? DS.fg2 : DS.fg1, fontWeight: c.pass ? 400 : 600 }}>{c.label}</span>
              {!c.pass && <span style={{ marginLeft: 'auto', fontFamily: DS.fontUI, fontSize: 11.5, fontWeight: 600, color: accent, cursor: 'pointer' }}>Fix</span>}
            </div>
          ))}
        </div>
      </EditorBlock>
    </div>
  );
}

/* ── AI VISIBILITY TAB ─────────────────────────────────── */
function AiTab({ quickAnswer, title, accent }) {
  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 22 }}>
      {/* AI hero */}
      <div style={{ borderRadius: DS.rLg, padding: '20px 22px', background: `linear-gradient(120deg, ${DS.aiFrom}12, ${DS.aiTo}18)`, border: `1px solid ${DS.aiTo}33`, display: 'flex', alignItems: 'center', gap: 16 }}>
        <div style={{ width: 44, height: 44, borderRadius: DS.rMd, background: `linear-gradient(125deg,${DS.aiFrom},${DS.aiTo})`, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0, boxShadow: '0 4px 14px rgba(120,79,224,0.3)' }}>
          <Icon name="sparkles" size={22} color="#fff" stroke={2} />
        </div>
        <div style={{ flex: 1 }}>
          <div style={{ fontFamily: DS.fontUI, fontSize: 15, fontWeight: 700, color: DS.fg1 }}>AI Answer Optimization</div>
          <div style={{ fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg3, marginTop: 2 }}>Optimize how this post appears in ChatGPT, Gemini, Perplexity & Google AI Overviews.</div>
        </div>
        <div style={{ textAlign: 'center' }}>
          <div style={{ fontFamily: DS.fontUI, fontSize: 24, fontWeight: 700, color: '#6B3FC0', lineHeight: 1 }}>72</div>
          <div style={{ fontFamily: DS.fontUI, fontSize: 10.5, color: DS.fg4, marginTop: 2 }}>AI score</div>
        </div>
      </div>

      {/* AI answer preview */}
      <EditorBlock icon="sparkles" title="AI Answer Preview" desc="How an assistant would cite this article" color={DS.aiTo}>
        <div style={{ background: '#FBF9F5', borderRadius: DS.rMd, padding: '16px 18px', border: `1px solid ${DS.border}` }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: 8, marginBottom: 12 }}>
            <div style={{ width: 22, height: 22, borderRadius: 999, background: `linear-gradient(125deg,${DS.aiFrom},${DS.aiTo})`, display: 'flex', alignItems: 'center', justifyContent: 'center' }}><Icon name="sparkles" size={12} color="#fff" /></div>
            <span style={{ fontFamily: DS.fontUI, fontSize: 12, fontWeight: 600, color: DS.fg3 }}>Assistant response</span>
          </div>
          <p style={{ margin: 0, fontFamily: DS.fontUI, fontSize: 14, color: DS.fg1, lineHeight: 1.65 }}>
            {quickAnswer || 'Four artists have won the TGMA Artiste of the Year award twice.'} <span style={{ display: 'inline-flex', alignItems: 'center', gap: 3, background: DS.aiSoft, color: '#6B3FC0', fontFamily: DS.fontUI, fontSize: 11, fontWeight: 600, padding: '1px 7px', borderRadius: 999, verticalAlign: 'middle' }}><Icon name="book-open" size={10} />debesties.com</span>
          </p>
        </div>
      </EditorBlock>

      {/* Entity summary */}
      <EditorBlock icon="globe" title="Entity Summary" desc="Key entities AI models extract from this post" color={DS.blue}>
        <div style={{ display: 'flex', flexWrap: 'wrap', gap: 8 }}>
          {[['V.I.P', 'Music Group'],['Sarkodie', 'Person'],['Stonebwoy', 'Person'],['Black Sherif', 'Person'],['Ghana Music Awards', 'Event'],['Artiste of the Year', 'Award']].map(([e, t], i) => (
            <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 7, padding: '6px 12px', background: '#FBF9F5', border: `1px solid ${DS.border}`, borderRadius: 999 }}>
              <span style={{ width: 7, height: 7, borderRadius: 999, background: DS.blue }}></span>
              <span style={{ fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 600, color: DS.fg1 }}>{e}</span>
              <span style={{ fontFamily: DS.fontUI, fontSize: 11, color: DS.fg4 }}>{t}</span>
            </div>
          ))}
        </div>
      </EditorBlock>

      {/* Direct answer optimization checklist */}
      <EditorBlock icon="list-checks" title="Direct Answer Optimization" color={DS.green}>
        <div style={{ display: 'flex', flexDirection: 'column', gap: 4 }}>
          {[['Quick Answer block present', true],['Question-style H2 headings', true],['Concise definitions (under 50 words)', true],['Structured lists & tables', false],['Sources cited inline', true]].map(([l, pass], i) => (
            <div key={i} style={{ display: 'flex', alignItems: 'center', gap: 10, padding: '8px 4px' }}>
              <div style={{ width: 20, height: 20, borderRadius: 999, flexShrink: 0, display: 'flex', alignItems: 'center', justifyContent: 'center', background: pass ? DS.greenSoft : DS.redSoft, color: pass ? DS.green : DS.red }}>
                <Icon name={pass ? 'check' : 'x'} size={12} stroke={3} />
              </div>
              <span style={{ fontFamily: DS.fontUI, fontSize: 13.5, color: DS.fg2 }}>{l}</span>
              {!pass && <span style={{ marginLeft: 'auto', fontFamily: DS.fontUI, fontSize: 11.5, fontWeight: 600, color: accent, cursor: 'pointer' }}>Fix</span>}
            </div>
          ))}
        </div>
      </EditorBlock>
    </div>
  );
}

Object.assign(window, { PostEditor });
