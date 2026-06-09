// Debesties Design System — Navigation Component
// Export: Navigation

const navStyles = {
  root: {
    position: 'sticky', top: 0, zIndex: 100,
    backdropFilter: 'blur(12px)',
    WebkitBackdropFilter: 'blur(12px)',
    background: 'rgba(248,245,240,0.92)',
    borderBottom: '1px solid #EDE8E0',
  },
  inner: {
    maxWidth: 1200, margin: '0 auto',
    padding: '0 32px', height: 62,
    display: 'flex', alignItems: 'center',
    justifyContent: 'space-between', gap: 24,
  },
  logo: {
    fontFamily: "'Playfair Display', serif",
    fontSize: 26, cursor: 'pointer',
    display: 'flex', alignItems: 'baseline',
    textDecoration: 'none', flexShrink: 0,
  },
  logoDe:      { fontWeight: 900, color: '#1A1410', letterSpacing: '-0.03em' },
  logoBesties: { fontWeight: 700, fontStyle: 'italic', color: '#E8A800', letterSpacing: '-0.02em' },
  links: {
    display: 'flex', gap: 0, alignItems: 'center',
    listStyle: 'none', margin: 0, padding: 0,
  },
  link: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 14, fontWeight: 500,
    color: '#5C5448', cursor: 'pointer',
    padding: '8px 16px', borderRadius: 6,
    transition: 'color 150ms, background 150ms',
    userSelect: 'none',
  },
  linkActive: { color: '#E8A800', fontWeight: 600 },
  linkHover:  { background: 'rgba(26,20,16,0.05)' },
  right: { display: 'flex', gap: 10, alignItems: 'center', flexShrink: 0 },
  subscribe: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 13, fontWeight: 600,
    background: '#E8A800', color: '#1A1410',
    border: 'none', cursor: 'pointer',
    padding: '8px 20px', borderRadius: 8,
    transition: 'background 150ms',
  },
  searchBtn: {
    background: 'none', border: '1.5px solid #EDE8E0',
    cursor: 'pointer', borderRadius: 8,
    width: 36, height: 36,
    display: 'flex', alignItems: 'center', justifyContent: 'center',
    color: '#7A7163',
  },
};

function Navigation({ page, onNavigate }) {
  const [hovered, setHovered] = React.useState(null);
  const links = [
    { key: 'home',     label: 'Home' },
    { key: 'timeline', label: 'Timeline' },
    { key: 'artists',  label: 'Artists' },
    { key: 'analysis', label: 'Analysis' },
  ];
  return (
    <nav style={navStyles.root}>
      <div style={navStyles.inner}>
        <div style={navStyles.logo} onClick={() => onNavigate('home')}>
          <span style={navStyles.logoDe}>De</span>
          <span style={navStyles.logoBesties}>besties</span>
        </div>
        <ul style={navStyles.links}>
          {links.map(({ key, label }) => (
            <li key={key}>
              <span
                style={{
                  ...navStyles.link,
                  ...(page === key ? navStyles.linkActive : {}),
                  ...(hovered === key ? navStyles.linkHover : {}),
                }}
                onClick={() => onNavigate(key)}
                onMouseEnter={() => setHovered(key)}
                onMouseLeave={() => setHovered(null)}
              >{label}</span>
            </li>
          ))}
        </ul>
        <div style={navStyles.right}>
          <button style={navStyles.searchBtn} title="Search">
            <i data-lucide="search" style={{width:16,height:16}}></i>
          </button>
          <button style={navStyles.subscribe}>Subscribe</button>
        </div>
      </div>
    </nav>
  );
}

Object.assign(window, { Navigation });
