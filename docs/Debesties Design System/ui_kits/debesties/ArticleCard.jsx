// Debesties Design System — Article Card Components
// Exports: FeaturedCard, ArticleCard, EliteStrip

const cardStyles = {
  // Featured hero card
  featured: {
    background: '#1A1410',
    borderRadius: 16,
    overflow: 'hidden',
    padding: '48px 52px',
    position: 'relative',
    minHeight: 340,
    display: 'flex',
    flexDirection: 'column',
    justifyContent: 'flex-end',
    cursor: 'pointer',
  },
  featuredBg: {
    position: 'absolute', inset: 0,
    background: 'linear-gradient(135deg, #0D0A07 0%, #1A5C2E22 50%, #E8A80008 100%)',
  },
  featuredContent: { position: 'relative', zIndex: 1, maxWidth: 580 },
  featuredKicker: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 11, fontWeight: 700, letterSpacing: '0.14em',
    textTransform: 'uppercase', color: '#E8A800', marginBottom: 12,
  },
  featuredTitle: {
    fontFamily: "'Playfair Display', serif",
    fontSize: 36, fontWeight: 900, lineHeight: 1.12,
    letterSpacing: '-0.03em', color: '#FFFFFF', marginBottom: 14,
  },
  featuredExcerpt: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 16, color: '#7A7163', lineHeight: 1.6, marginBottom: 24,
  },
  featuredCta: {
    display: 'inline-flex', alignItems: 'center', gap: 8,
    fontFamily: "'Outfit', sans-serif",
    fontSize: 14, fontWeight: 600, color: '#1A1410',
    background: '#E8A800', border: 'none', cursor: 'pointer',
    padding: '11px 22px', borderRadius: 8,
    transition: 'background 150ms',
  },
  featuredMeta: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 12, color: '#5C5448', marginBottom: 20, display: 'flex', gap: 8,
  },
  // Standard card
  card: {
    background: '#FFFFFF',
    borderRadius: 12, border: '1px solid #EDE8E0',
    boxShadow: '0 2px 8px rgba(26,20,16,0.07)',
    overflow: 'hidden', cursor: 'pointer',
    transition: 'box-shadow 200ms, transform 200ms',
    display: 'flex', flexDirection: 'column',
  },
  cardImgWrap: {
    width: '100%', aspectRatio: '16/9',
    background: 'linear-gradient(135deg, #1A1410, #3D3529)',
    display: 'flex', alignItems: 'center', justifyContent: 'center',
    flexShrink: 0,
  },
  cardBody: { padding: '18px 20px', flex: 1, display: 'flex', flexDirection: 'column', gap: 6 },
  cardKicker: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 10, fontWeight: 700, letterSpacing: '0.12em',
    textTransform: 'uppercase', color: '#E8A800',
  },
  cardTitle: {
    fontFamily: "'Playfair Display', serif",
    fontSize: 17, fontWeight: 700, lineHeight: 1.3,
    color: '#1A1410', flex: 1,
  },
  cardExcerpt: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 13, color: '#7A7163', lineHeight: 1.55,
  },
  cardMeta: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 11, color: '#9E9387',
    display: 'flex', gap: 6, marginTop: 6,
  },
};

// Gradient overlays per card type
const cardGradients = [
  'linear-gradient(135deg, #1A5C2E, #0E381B)',
  'linear-gradient(135deg, #1A1410, #4D3000)',
  'linear-gradient(135deg, #450A0A, #1A1410)',
  'linear-gradient(135deg, #051F07, #1A5C2E)',
];

function FeaturedCard({ article, onNavigate }) {
  return (
    <div style={cardStyles.featured} onClick={() => onNavigate && onNavigate('timeline')}>
      <div style={cardStyles.featuredBg}></div>
      {/* Decorative stars */}
      <div style={{position:'absolute',top:32,right:48,opacity:0.12,fontSize:120,color:'#E8A800',lineHeight:1,userSelect:'none',zIndex:0}}>★</div>
      <div style={cardStyles.featuredContent}>
        <div style={cardStyles.featuredKicker}>Cover Story · May 2026</div>
        <h2 style={cardStyles.featuredTitle}>{article.title}</h2>
        <p style={cardStyles.featuredExcerpt}>{article.excerpt}</p>
        <div style={cardStyles.featuredMeta}>
          <span>{article.date}</span><span>·</span><span>{article.readTime}</span>
        </div>
        <button style={cardStyles.featuredCta}>
          Read the Full Timeline
          <i data-lucide="arrow-right" style={{width:15,height:15}}></i>
        </button>
      </div>
    </div>
  );
}

function ArticleCard({ article, index, onNavigate }) {
  const [hov, setHov] = React.useState(false);
  const iconColors = ['#4EC17E', '#FFCA3A', '#FCA5A5', '#8EDAB0'];
  const iconNames = ['trophy', 'music', 'star', 'calendar'];
  return (
    <div
      style={{
        ...cardStyles.card,
        ...(hov ? { boxShadow: '0 8px 32px rgba(26,20,16,0.13)', transform: 'translateY(-2px)' } : {}),
      }}
      onMouseEnter={() => setHov(true)}
      onMouseLeave={() => setHov(false)}
      onClick={() => onNavigate && onNavigate('timeline')}
    >
      <div style={{ ...cardStyles.cardImgWrap, background: cardGradients[index % 4] }}>
        <i data-lucide={iconNames[index % 4]} style={{ width: 28, height: 28, color: iconColors[index % 4] }}></i>
      </div>
      <div style={cardStyles.cardBody}>
        <div style={cardStyles.cardKicker}>{article.kicker}</div>
        <div style={cardStyles.cardTitle}>{article.title}</div>
        <div style={cardStyles.cardExcerpt}>{article.excerpt}</div>
        <div style={cardStyles.cardMeta}>
          <span>{article.date}</span><span>·</span><span>{article.readTime}</span>
        </div>
      </div>
    </div>
  );
}

Object.assign(window, { FeaturedCard, ArticleCard });
