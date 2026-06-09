// Debesties Design System — Timeline Page Component
// Export: TimelinePage, WINNERS

const WINNERS = [
  { year: 2026, artist: 'Black Sherif',    isDouble: true },
  { year: 2025, artist: 'King Promise',    isDouble: false },
  { year: 2024, artist: 'Stonebwoy',       isDouble: true },
  { year: 2023, artist: 'Black Sherif',    isDouble: false },
  { year: 2022, artist: 'KiDi',            isDouble: false },
  { year: 2021, artist: 'Diana Hamilton',  isDouble: false },
  { year: 2020, artist: 'Kuami Eugene',    isDouble: false },
  { year: 2019, artist: null,              annulled: true },
  { year: 2018, artist: 'Ebony',           isDouble: false },
  { year: 2017, artist: 'Joe Mettle',      isDouble: false },
  { year: 2016, artist: 'E.L',             isDouble: false },
  { year: 2015, artist: 'Stonebwoy',       isDouble: false },
  { year: 2014, artist: 'Shatta Wale',     isDouble: false },
  { year: 2013, artist: 'R2Bees',          isDouble: false },
  { year: 2012, artist: 'Sarkodie',        isDouble: true },
  { year: 2011, artist: 'V.I.P',          isDouble: true },
  { year: 2010, artist: 'Sarkodie',        isDouble: false },
  { year: 2009, artist: 'Okyeame Kwame',   isDouble: false },
  { year: 2008, artist: 'Kwaw Kese',       isDouble: false },
  { year: 2007, artist: 'Samini',          isDouble: false },
  { year: 2006, artist: 'Ofori Amponsah',  isDouble: false },
  { year: 2005, artist: 'Obour',           isDouble: false },
  { year: 2004, artist: 'V.I.P',          isDouble: false },
  { year: 2003, artist: 'Kontihene',       isDouble: false },
  { year: 2002, artist: 'Lord Kenya',      isDouble: false },
  { year: 2001, artist: 'Kojo Antwi',      isDouble: false },
  { year: 2000, artist: 'Daddy Lumba',     isDouble: false },
  { year: 1999, artist: 'Akyeame',         isDouble: false },
];

const ERAS = [
  { label: 'Afrobeats Era', years: [2020, 2026], color: '#0E381B', text: '#8EDAB0' },
  { label: 'Gospel & Contemporary', years: [2017, 2019], color: '#4D3000', text: '#FFE085' },
  { label: 'Highlife Revival', years: [2010, 2016], color: '#3D3529', text: '#D9D0C4' },
  { label: 'Hiplife Era', years: [1999, 2009], color: '#1A1410', text: '#BDB5A6' },
];

function getEra(year) {
  return ERAS.find(e => year >= e.years[0] && year <= e.years[1]);
}

const tlStyles = {
  page: { background: '#F8F5F0', minHeight: '100vh', paddingBottom: 80 },
  hero: {
    background: '#1A1410', padding: '52px 32px 48px',
    textAlign: 'center', position: 'relative', overflow: 'hidden',
  },
  heroBg: {
    position: 'absolute', inset: 0,
    background: 'radial-gradient(ellipse at 50% 0%, rgba(232,168,0,0.12) 0%, transparent 70%)',
  },
  heroKicker: {
    fontFamily: "'Outfit', sans-serif", fontSize: 11, fontWeight: 700,
    letterSpacing: '0.16em', textTransform: 'uppercase',
    color: '#E8A800', marginBottom: 12, position: 'relative',
  },
  heroTitle: {
    fontFamily: "'Playfair Display', serif", fontSize: 42, fontWeight: 900,
    lineHeight: 1.1, letterSpacing: '-0.03em', color: '#FFFFFF',
    marginBottom: 12, position: 'relative',
  },
  heroSub: {
    fontFamily: "'Outfit', sans-serif", fontSize: 16, color: '#5C5448',
    maxWidth: 520, margin: '0 auto', lineHeight: 1.6, position: 'relative',
  },
  stats: {
    display: 'flex', justifyContent: 'center', gap: 48,
    padding: '24px 32px', background: '#1A1410',
    borderTop: '1px solid rgba(255,255,255,0.06)',
    position: 'relative',
  },
  stat: { textAlign: 'center' },
  statNum: {
    fontFamily: "'Space Mono', monospace", fontSize: 28, fontWeight: 700,
    color: '#E8A800', lineHeight: 1,
  },
  statLabel: {
    fontFamily: "'Outfit', sans-serif", fontSize: 11, color: '#5C5448',
    marginTop: 4, letterSpacing: '0.04em',
  },
  body: { maxWidth: 680, margin: '0 auto', padding: '48px 24px 0' },
  eraLabel: {
    display: 'flex', alignItems: 'center', gap: 12, marginBottom: 20,
  },
  eraChip: {
    fontFamily: "'Outfit', sans-serif", fontSize: 11, fontWeight: 700,
    letterSpacing: '0.08em', textTransform: 'uppercase',
    padding: '4px 12px', borderRadius: 9999,
  },
  eraLine: { flex: 1, height: 1, background: '#EDE8E0' },
  // Timeline
  timeline: { position: 'relative' },
  timelineTrack: {
    position: 'absolute', left: 20, top: 0, bottom: 0,
    width: 2, background: 'linear-gradient(to bottom, #E8A800 0%, #EDE8E0 60%, transparent 100%)',
    borderRadius: 2,
  },
  tItem: {
    display: 'flex', gap: 20, alignItems: 'flex-start',
    paddingBottom: 22, paddingLeft: 4,
  },
  tNode: {
    width: 36, height: 36, borderRadius: '50%', flexShrink: 0,
    display: 'flex', alignItems: 'center', justifyContent: 'center',
    position: 'relative', zIndex: 1, marginTop: 0,
  },
  tNodeDefault: { background: 'white', border: '2px solid #EDE8E0' },
  tNodeWinner:  { background: '#FFFAED', border: '2.5px solid #E8A800' },
  tNodeDouble:  { background: '#E8A800', border: '2.5px solid #E8A800', boxShadow: '0 0 0 5px rgba(232,168,0,0.15)' },
  tNodeAnnulled:{ background: '#FEF2F2', border: '2px solid #FCA5A5' },
  tContent: { flex: 1, paddingTop: 6 },
  tYear: {
    fontFamily: "'Space Mono', monospace", fontSize: 11, fontWeight: 700,
    color: '#E8A800', letterSpacing: '0.06em', marginBottom: 1,
  },
  tYearMuted: { color: '#BDB5A6' },
  tArtist: {
    fontFamily: "'Playfair Display', serif", fontSize: 19, fontWeight: 700,
    color: '#1A1410', lineHeight: 1.25,
  },
  tArtistMuted: { color: '#9E9387', fontStyle: 'italic' },
  tBadge: {
    display: 'inline-flex', alignItems: 'center', gap: 4,
    fontFamily: "'Outfit', sans-serif", fontSize: 9, fontWeight: 700,
    letterSpacing: '0.09em', textTransform: 'uppercase',
    background: '#E8A800', color: '#1A1410',
    padding: '2px 7px', borderRadius: 3, marginLeft: 9,
    verticalAlign: 'middle',
  },
  tAnnulledBadge: {
    display: 'inline-flex', alignItems: 'center',
    fontFamily: "'Outfit', sans-serif", fontSize: 9, fontWeight: 700,
    letterSpacing: '0.09em', textTransform: 'uppercase',
    background: '#FEE2E2', color: '#7F1D1D',
    padding: '2px 7px', borderRadius: 3, marginLeft: 6,
    verticalAlign: 'middle',
  },
};

function TimelineItem({ item }) {
  const isAnnulled = item.annulled;
  const nodeStyle = isAnnulled
    ? tlStyles.tNodeAnnulled
    : item.isDouble ? tlStyles.tNodeDouble
    : tlStyles.tNodeWinner;

  return (
    <div style={tlStyles.tItem}>
      <div style={{ ...tlStyles.tNode, ...nodeStyle }}>
        {item.isDouble && !isAnnulled && (
          <svg width="14" height="14" viewBox="0 0 24 24" fill="#1A1410" stroke="none">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
          </svg>
        )}
        {!item.isDouble && !isAnnulled && (
          <span style={{fontFamily:"'Space Mono',monospace",fontSize:10,fontWeight:700,color:'#E8A800'}}>
            {String(item.year).slice(2)}
          </span>
        )}
        {isAnnulled && (
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#B91C1C" strokeWidth="2.5" strokeLinecap="round">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        )}
      </div>
      <div style={tlStyles.tContent}>
        <div style={{ ...tlStyles.tYear, ...(isAnnulled ? tlStyles.tYearMuted : {}) }}>
          {item.year}
        </div>
        <div style={isAnnulled ? tlStyles.tArtistMuted : tlStyles.tArtist}>
          {isAnnulled ? (
            <>— <span style={tlStyles.tAnnulledBadge}>Annulled</span></>
          ) : (
            <>
              {item.artist}
              {item.isDouble && <span style={tlStyles.tBadge}>★★ 2× Champ</span>}
            </>
          )}
        </div>
      </div>
    </div>
  );
}

function TimelinePage({ onNavigate }) {
  let lastEra = null;
  const items = [];

  WINNERS.forEach((item, i) => {
    const era = getEra(item.year);
    if (era && era.label !== lastEra) {
      lastEra = era.label;
      items.push({ type: 'era', era, key: `era-${i}` });
    }
    items.push({ type: 'item', item, key: item.year });
  });

  return (
    <div style={tlStyles.page}>
      {/* Hero */}
      <div style={tlStyles.hero}>
        <div style={tlStyles.heroBg}></div>
        <div style={tlStyles.heroKicker}>Ghana Music Awards · Artiste of the Year</div>
        <h1 style={tlStyles.heroTitle}>The Complete History<br/>1999 — 2026</h1>
        <p style={tlStyles.heroSub}>
          Every winner across 27 years of Ghana's most prestigious music award — including the 4 artists who conquered it twice.
        </p>
      </div>
      {/* Stats bar */}
      <div style={tlStyles.stats}>
        {[
          { num: '28', label: 'Years of Awards' },
          { num: '24', label: 'Unique Winners' },
          { num: '4', label: '2× Champions' },
          { num: '1', label: 'Annulled Year' },
        ].map(s => (
          <div key={s.label} style={tlStyles.stat}>
            <div style={tlStyles.statNum}>{s.num}</div>
            <div style={tlStyles.statLabel}>{s.label}</div>
          </div>
        ))}
      </div>
      {/* Timeline body */}
      <div style={tlStyles.body}>
        <div style={tlStyles.timeline}>
          <div style={tlStyles.timelineTrack}></div>
          {items.map(entry => {
            if (entry.type === 'era') {
              const { era } = entry;
              return (
                <div key={entry.key} style={{ ...tlStyles.eraLabel, paddingLeft: 56 }}>
                  <span style={{ ...tlStyles.eraChip, background: era.color, color: era.text }}>
                    {era.label}
                  </span>
                  <div style={tlStyles.eraLine}></div>
                </div>
              );
            }
            return <TimelineItem key={entry.key} item={entry.item} />;
          })}
        </div>
      </div>
    </div>
  );
}

Object.assign(window, { TimelinePage, WINNERS });
