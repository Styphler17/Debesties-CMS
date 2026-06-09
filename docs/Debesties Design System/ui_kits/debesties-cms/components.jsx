// Debesties CMS — Design Tokens + Shared Primitives
// Exports to window: DS, Icon, Btn, Badge, Card, StatCard, Avatar, ScoreRing,
//   SegTabs, SearchInput, Toggle, Field, Modal, EmptyState, Spinner, ProgressBar, Sparkline

/* ── TOKENS ─────────────────────────────────────────────── */
const DS = {
  // Surfaces
  bg:        '#F4F1EC',      // app canvas (warm)
  surface:   '#FFFFFF',
  sidebar:   '#17120D',      // charcoal sidebar
  sidebarHi: '#221B14',
  // Ink
  fg1:       '#1A1410',
  fg2:       '#4A4236',
  fg3:       '#7A7163',
  fg4:       '#A89F90',
  inverse:   '#F4F1EC',
  // Brand accents
  gold:      '#E8A800',
  goldSoft:  '#FFF6DD',
  goldDeep:  '#A06C00',
  green:     '#1A8A4B',
  greenSoft: '#E5F5EC',
  greenDeep: '#0E5C30',
  red:       '#C8372B',
  redSoft:   '#FBEAE8',
  redDeep:   '#8F261D',
  blue:      '#2F6BD8',
  blueSoft:  '#E9F0FC',
  // AI gradient (from the debesties logo)
  aiFrom:    '#3B5BDB',
  aiTo:      '#B14FD8',
  aiSoft:    '#F1ECFB',
  // Lines
  border:    '#E7E1D8',
  borderSt:  '#D6CEC1',
  // Type
  fontUI:    "'Outfit', sans-serif",
  fontDisp:  "'Playfair Display', serif",
  fontMono:  "'Space Mono', monospace",
  // Shadow
  shCard:    '0 1px 3px rgba(26,20,16,0.06), 0 1px 2px rgba(26,20,16,0.04)',
  shRaised:  '0 4px 16px rgba(26,20,16,0.10)',
  shPop:     '0 12px 40px rgba(26,20,16,0.18)',
  // Radii
  rSm: 6, rMd: 9, rLg: 14, rXl: 20,
};

/* ── ICON (inline SVG paths, Lucide-style 1.75 stroke) ──── */
const ICON_PATHS = {
  'layout-dashboard': '<rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>',
  'file-text': '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
  'plus': '<path d="M5 12h14"/><path d="M12 5v14"/>',
  'folder': '<path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/>',
  'tag': '<path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/>',
  'image': '<rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>',
  'calendar': '<path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/>',
  'bar-chart': '<line x1="12" x2="12" y1="20" y2="10"/><line x1="18" x2="18" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="16"/>',
  'search-check': '<path d="m8 11 2 2 4-4"/><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
  'sparkles': '<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .962 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.962 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/>',
  'users': '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
  'message-square': '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
  'settings': '<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>',
  'menu': '<line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>',
  'list': '<path d="M3 5h.01"/><path d="M3 12h.01"/><path d="M3 19h.01"/><path d="M8 5h13"/><path d="M8 12h13"/><path d="M8 19h13"/>',
  'home': '<path d="M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/><path d="M9 21V12h6v9"/>',
  'search': '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
  'bell': '<path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/>',
  'chevron-down': '<path d="m6 9 6 6 6-6"/>',
  'chevron-right': '<path d="m9 18 6-6-6-6"/>',
  'chevron-left': '<path d="m15 18-6-6 6-6"/>',
  'arrow-up': '<path d="m5 12 7-7 7 7"/><path d="M12 19V5"/>',
  'arrow-down': '<path d="M12 5v14"/><path d="m19 12-7 7-7-7"/>',
  'arrow-right': '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
  'eye': '<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/>',
  'x': '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
  'check': '<path d="M20 6 9 17l-5-5"/>',
  'more-horizontal': '<circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/>',
  'edit': '<path d="M12 20h9"/><path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"/>',
  'trash': '<path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>',
  'copy': '<rect width="14" height="14" x="8" y="8" rx="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>',
  'clock': '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
  'trending-up': '<path d="M16 7h6v6"/><path d="m22 7-8.5 8.5-5-5L2 17"/>',
  'trending-down': '<path d="M16 17h6v-6"/><path d="m22 17-8.5-8.5-5 5L2 7"/>',
  'alert-triangle': '<path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/>',
  'circle-help': '<circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>',
  'link': '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>',
  'quote': '<path d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"/><path d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"/>',
  'list-checks': '<path d="m3 17 2 2 4-4"/><path d="m3 7 2 2 4-4"/><path d="M13 6h8"/><path d="M13 12h8"/><path d="M13 18h8"/>',
  'book-open': '<path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>',
  'globe': '<circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>',
  'filter': '<polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>',
  'upload': '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m17 8-5-5-5 5"/><path d="M12 3v12"/>',
  'star': '<path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.12 2.12 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.12 2.12 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.12 2.12 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.12 2.12 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.12 2.12 0 0 0 1.597-1.16z"/>',
  'grip': '<circle cx="9" cy="5" r="1"/><circle cx="9" cy="12" r="1"/><circle cx="9" cy="19" r="1"/><circle cx="15" cy="5" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="19" r="1"/>',
  'log-out': '<path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>',
  'external-link': '<path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>',
  'save': '<path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/><path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"/><path d="M7 3v4a1 1 0 0 0 1 1h7"/>',
  'send': '<path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/>',
  'panel-left': '<rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18"/>',
  'database': '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 21 19V5"/><path d="M3 12A9 3 0 0 0 21 12"/>',
  'refresh': '<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/>',
  'flame': '<path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/>',
  'circle': '<circle cx="12" cy="12" r="10"/>',
  'circle-dot': '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3" fill="currentColor"/>',
  'gauge': '<path d="m12 14 4-4"/><path d="M3.34 19a10 10 0 1 1 17.32 0"/>',
  'pen-tool': '<path d="M15.707 21.293a1 1 0 0 1-1.414 0l-1.586-1.586a1 1 0 0 1 0-1.414l5.586-5.586a1 1 0 0 1 1.414 0l1.586 1.586a1 1 0 0 1 0 1.414z"/><path d="m18 13-1.375-6.874a1 1 0 0 0-.746-.776L3.235 2.028a1 1 0 0 0-1.207 1.207L5.35 15.879a1 1 0 0 0 .776.746L13 18"/><path d="m2.3 2.3 7.286 7.286"/><circle cx="11" cy="11" r="2"/>',
};

function Icon({ name, size = 18, color = 'currentColor', stroke = 1.75, style, fill = 'none' }) {
  return (
    <svg width={size} height={size} viewBox="0 0 24 24" fill={fill} stroke={color}
      strokeWidth={stroke} strokeLinecap="round" strokeLinejoin="round"
      style={{ flexShrink: 0, ...style }}
      dangerouslySetInnerHTML={{ __html: ICON_PATHS[name] || '' }} />
  );
}

/* ── BUTTON ─────────────────────────────────────────────── */
function Btn({ children, variant = 'primary', size = 'md', icon, iconRight, onClick, full, disabled, style, title, type }) {
  const [hov, setHov] = React.useState(false);
  const [press, setPress] = React.useState(false);
  const sizes = {
    sm: { padding: '6px 12px', fontSize: 12.5, gap: 6, h: 32, ic: 14 },
    md: { padding: '9px 16px', fontSize: 13.5, gap: 7, h: 38, ic: 16 },
    lg: { padding: '12px 22px', fontSize: 15, gap: 8, h: 46, ic: 18 },
  }[size];
  const variants = {
    primary:  { bg: DS.gold, color: '#1A1410', border: 'transparent', hbg: '#D69B00' },
    dark:     { bg: DS.fg1, color: '#fff', border: 'transparent', hbg: '#2C241B' },
    green:    { bg: DS.green, color: '#fff', border: 'transparent', hbg: DS.greenDeep },
    danger:   { bg: DS.red, color: '#fff', border: 'transparent', hbg: DS.redDeep },
    ghost:    { bg: 'transparent', color: DS.fg2, border: DS.borderSt, hbg: 'rgba(26,20,16,0.04)' },
    soft:     { bg: '#FFFFFF', color: DS.fg1, border: DS.border, hbg: '#FBF9F5' },
    ai:       { bg: `linear-gradient(120deg, ${DS.aiFrom}, ${DS.aiTo})`, color: '#fff', border: 'transparent', hbg: `linear-gradient(120deg, ${DS.aiFrom}, ${DS.aiTo})` },
  }[variant];
  return (
    <button type={type || 'button'} title={title} disabled={disabled}
      onClick={onClick}
      onMouseEnter={() => setHov(true)} onMouseLeave={() => { setHov(false); setPress(false); }}
      onMouseDown={() => setPress(true)} onMouseUp={() => setPress(false)}
      style={{
        display: 'inline-flex', alignItems: 'center', justifyContent: 'center',
        gap: sizes.gap, fontFamily: DS.fontUI, fontSize: sizes.fontSize, fontWeight: 600,
        letterSpacing: '0.01em', padding: sizes.padding, height: sizes.h,
        background: hov && !disabled ? variants.hbg : variants.bg,
        color: variants.color, border: `1.5px solid ${variants.border === 'transparent' ? 'transparent' : variants.border}`,
        borderRadius: DS.rMd, cursor: disabled ? 'not-allowed' : 'pointer',
        opacity: disabled ? 0.5 : 1, width: full ? '100%' : 'auto',
        transform: press ? 'scale(0.97)' : 'scale(1)',
        transition: 'background 140ms, transform 100ms, border-color 140ms, box-shadow 140ms',
        boxShadow: variant === 'ai' && hov ? '0 4px 16px rgba(120,79,224,0.35)' : 'none',
        whiteSpace: 'nowrap', ...style,
      }}>
      {icon && <Icon name={icon} size={sizes.ic} stroke={2} />}
      {children}
      {iconRight && <Icon name={iconRight} size={sizes.ic} stroke={2} />}
    </button>
  );
}

/* ── BADGE ──────────────────────────────────────────────── */
const BADGE_TONES = {
  published: { bg: DS.greenSoft, fg: DS.greenDeep, dot: DS.green },
  draft:     { bg: '#EFEBE3', fg: DS.fg2, dot: DS.fg4 },
  scheduled: { bg: DS.blueSoft, fg: '#1E4FA8', dot: DS.blue },
  review:    { bg: DS.goldSoft, fg: DS.goldDeep, dot: DS.gold },
  archived:  { bg: '#EFEBE3', fg: DS.fg3, dot: DS.fg4 },
  decay:     { bg: DS.redSoft, fg: DS.redDeep, dot: DS.red },
  ai:        { bg: DS.aiSoft, fg: '#6B3FC0', dot: DS.aiTo },
  neutral:   { bg: '#EFEBE3', fg: DS.fg2, dot: DS.fg4 },
};
function Badge({ tone = 'neutral', children, dot = true, style }) {
  const t = BADGE_TONES[tone] || BADGE_TONES.neutral;
  return (
    <span style={{
      display: 'inline-flex', alignItems: 'center', gap: 6,
      fontFamily: DS.fontUI, fontSize: 11.5, fontWeight: 600, letterSpacing: '0.01em',
      background: t.bg, color: t.fg, padding: dot ? '3px 10px 3px 8px' : '3px 10px',
      borderRadius: 999, textTransform: 'capitalize', whiteSpace: 'nowrap', ...style,
    }}>
      {dot && <span style={{ width: 6, height: 6, borderRadius: 999, background: t.dot, flexShrink: 0 }}></span>}
      {children}
    </span>
  );
}

/* ── CARD ───────────────────────────────────────────────── */
function Card({ children, style, pad = 20, onClick, hover }) {
  const [hov, setHov] = React.useState(false);
  return (
    <div onClick={onClick}
      onMouseEnter={() => setHov(true)} onMouseLeave={() => setHov(false)}
      style={{
        background: DS.surface, border: `1px solid ${DS.border}`, borderRadius: DS.rLg,
        padding: pad, boxShadow: hover && hov ? DS.shRaised : DS.shCard,
        transition: 'box-shadow 180ms, transform 180ms',
        transform: hover && hov ? 'translateY(-2px)' : 'none',
        cursor: onClick ? 'pointer' : 'default', ...style,
      }}>
      {children}
    </div>
  );
}

/* ── STAT CARD ──────────────────────────────────────────── */
function StatCard({ label, value, delta, deltaDir, icon, tone = 'gold', spark }) {
  const tones = {
    gold: DS.gold, green: DS.green, blue: DS.blue, red: DS.red, ai: DS.aiTo,
  };
  const c = tones[tone];
  return (
    <Card pad={18} hover>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: 14 }}>
        <div style={{
          width: 38, height: 38, borderRadius: DS.rMd, display: 'flex', alignItems: 'center',
          justifyContent: 'center', background: `${c}1A`, color: c,
        }}>
          <Icon name={icon} size={19} stroke={2} />
        </div>
        {delta != null && (
          <span style={{
            display: 'inline-flex', alignItems: 'center', gap: 3, fontFamily: DS.fontUI,
            fontSize: 12, fontWeight: 700,
            color: deltaDir === 'down' ? DS.red : DS.green,
          }}>
            <Icon name={deltaDir === 'down' ? 'trending-down' : 'trending-up'} size={14} stroke={2.2} />
            {delta}
          </span>
        )}
      </div>
      <div style={{ fontFamily: DS.fontUI, fontSize: 27, fontWeight: 700, color: DS.fg1, lineHeight: 1, letterSpacing: '-0.02em' }}>{value}</div>
      <div style={{ fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg3, marginTop: 6, fontWeight: 500 }}>{label}</div>
    </Card>
  );
}

/* ── AVATAR ─────────────────────────────────────────────── */
const AVA_COLORS = ['#E8A800', '#1A8A4B', '#2F6BD8', '#B14FD8', '#C8372B', '#0E5C30'];
function Avatar({ name, size = 32, src }) {
  const initials = name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
  const color = AVA_COLORS[name.charCodeAt(0) % AVA_COLORS.length];
  return (
    <div style={{
      width: size, height: size, borderRadius: 999, background: src ? 'none' : `${color}22`,
      color, display: 'flex', alignItems: 'center', justifyContent: 'center',
      fontFamily: DS.fontUI, fontSize: size * 0.38, fontWeight: 700, flexShrink: 0,
      border: `1.5px solid ${color}33`, overflow: 'hidden',
    }}>
      {src ? <img src={src} style={{ width: '100%', height: '100%', objectFit: 'cover' }} /> : initials}
    </div>
  );
}

/* ── SCORE RING (SEO score) ─────────────────────────────── */
function ScoreRing({ score, size = 38, stroke = 4, label }) {
  const r = (size - stroke) / 2;
  const circ = 2 * Math.PI * r;
  const color = score >= 80 ? DS.green : score >= 50 ? DS.gold : DS.red;
  return (
    <div style={{ position: 'relative', width: size, height: size, flexShrink: 0 }} title={label}>
      <svg width={size} height={size} style={{ transform: 'rotate(-90deg)' }}>
        <circle cx={size/2} cy={size/2} r={r} fill="none" stroke={DS.border} strokeWidth={stroke} />
        <circle cx={size/2} cy={size/2} r={r} fill="none" stroke={color} strokeWidth={stroke}
          strokeDasharray={circ} strokeDashoffset={circ * (1 - score/100)} strokeLinecap="round"
          style={{ transition: 'stroke-dashoffset 600ms ease' }} />
      </svg>
      <div style={{
        position: 'absolute', inset: 0, display: 'flex', alignItems: 'center', justifyContent: 'center',
        fontFamily: DS.fontUI, fontSize: size * 0.3, fontWeight: 700, color,
      }}>{score}</div>
    </div>
  );
}

/* ── SEGMENTED TABS ─────────────────────────────────────── */
function SegTabs({ tabs, active, onChange, size = 'md' }) {
  const pad = size === 'sm' ? '6px 12px' : '8px 16px';
  const fs = size === 'sm' ? 12.5 : 13.5;
  return (
    <div style={{ display: 'inline-flex', background: '#EDE8DF', borderRadius: DS.rMd, padding: 3, gap: 2 }}>
      {tabs.map(tb => {
        const val = typeof tb === 'string' ? tb : tb.value;
        const lbl = typeof tb === 'string' ? tb : tb.label;
        const on = active === val;
        return (
          <button key={val} onClick={() => onChange(val)} style={{
            fontFamily: DS.fontUI, fontSize: fs, fontWeight: on ? 600 : 500,
            padding: pad, border: 'none', borderRadius: DS.rSm, cursor: 'pointer',
            background: on ? DS.surface : 'transparent', color: on ? DS.fg1 : DS.fg3,
            boxShadow: on ? DS.shCard : 'none', transition: 'all 140ms', whiteSpace: 'nowrap',
            display: 'inline-flex', alignItems: 'center', gap: 6,
          }}>
            {typeof tb === 'object' && tb.icon && <Icon name={tb.icon} size={14} stroke={2} />}
            {lbl}
            {typeof tb === 'object' && tb.count != null && (
              <span style={{ fontSize: 11, fontWeight: 700, color: on ? DS.fg3 : DS.fg4 }}>{tb.count}</span>
            )}
          </button>
        );
      })}
    </div>
  );
}

/* ── SEARCH INPUT ───────────────────────────────────────── */
function SearchInput({ value, onChange, placeholder = 'Search…', width = 260 }) {
  const [foc, setFoc] = React.useState(false);
  return (
    <div style={{
      display: 'flex', alignItems: 'center', gap: 8, width, height: 38,
      background: DS.surface, border: `1.5px solid ${foc ? DS.gold : DS.border}`,
      borderRadius: DS.rMd, padding: '0 12px', transition: 'border-color 140ms',
      boxShadow: foc ? `0 0 0 3px ${DS.gold}22` : 'none',
    }}>
      <Icon name="search" size={16} color={DS.fg4} />
      <input value={value} onChange={e => onChange(e.target.value)} placeholder={placeholder}
        onFocus={() => setFoc(true)} onBlur={() => setFoc(false)}
        style={{ border: 'none', outline: 'none', background: 'none', flex: 1,
          fontFamily: DS.fontUI, fontSize: 13.5, color: DS.fg1, minWidth: 0 }} />
    </div>
  );
}

/* ── TOGGLE ─────────────────────────────────────────────── */
function Toggle({ on, onChange, size = 'md' }) {
  const w = size === 'sm' ? 34 : 42, h = size === 'sm' ? 20 : 24, k = h - 6;
  return (
    <button onClick={() => onChange(!on)} style={{
      width: w, height: h, borderRadius: 999, border: 'none', cursor: 'pointer',
      background: on ? DS.green : DS.borderSt, position: 'relative', transition: 'background 180ms', flexShrink: 0,
    }}>
      <span style={{
        position: 'absolute', top: 3, left: on ? w - k - 3 : 3, width: k, height: k,
        borderRadius: 999, background: '#fff', transition: 'left 180ms', boxShadow: '0 1px 3px rgba(0,0,0,0.2)',
      }}></span>
    </button>
  );
}

/* ── FIELD (label + input/textarea) ─────────────────────── */
function Field({ label, value, onChange, placeholder, type = 'text', textarea, rows = 3, hint, prefix, suffix, mono, counter, max }) {
  const [foc, setFoc] = React.useState(false);
  const base = {
    width: '100%', border: 'none', outline: 'none', background: 'none',
    fontFamily: mono ? DS.fontMono : DS.fontUI, fontSize: 13.5, color: DS.fg1, resize: 'vertical',
    lineHeight: 1.5,
  };
  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 6 }}>
      {label && (
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'baseline' }}>
          <label style={{ fontFamily: DS.fontUI, fontSize: 12.5, fontWeight: 600, color: DS.fg2 }}>{label}</label>
          {counter && <span style={{ fontFamily: DS.fontMono, fontSize: 11, color: (value||'').length > max ? DS.red : DS.fg4 }}>{(value||'').length}/{max}</span>}
        </div>
      )}
      <div style={{
        display: 'flex', alignItems: textarea ? 'flex-start' : 'center', gap: 8,
        border: `1.5px solid ${foc ? DS.gold : DS.border}`, borderRadius: DS.rMd,
        padding: textarea ? '10px 12px' : '0 12px', height: textarea ? 'auto' : 38,
        background: DS.surface, transition: 'border-color 140ms',
        boxShadow: foc ? `0 0 0 3px ${DS.gold}22` : 'none',
      }}>
        {prefix && <span style={{ fontFamily: DS.fontMono, fontSize: 12.5, color: DS.fg4, whiteSpace: 'nowrap' }}>{prefix}</span>}
        {textarea
          ? <textarea value={value} onChange={e => onChange && onChange(e.target.value)} placeholder={placeholder} rows={rows}
              onFocus={() => setFoc(true)} onBlur={() => setFoc(false)} style={base} />
          : <input value={value} onChange={e => onChange && onChange(e.target.value)} placeholder={placeholder} type={type}
              onFocus={() => setFoc(true)} onBlur={() => setFoc(false)} style={base} />}
        {suffix && <span style={{ fontFamily: DS.fontUI, fontSize: 12.5, color: DS.fg4, whiteSpace: 'nowrap' }}>{suffix}</span>}
      </div>
      {hint && <span style={{ fontFamily: DS.fontUI, fontSize: 11.5, color: DS.fg4, lineHeight: 1.4 }}>{hint}</span>}
    </div>
  );
}

/* ── MODAL ──────────────────────────────────────────────── */
function Modal({ open, onClose, title, children, width = 480, footer }) {
  if (!open) return null;
  return (
    <div onClick={onClose} style={{
      position: 'fixed', inset: 0, background: 'rgba(20,16,12,0.45)', backdropFilter: 'blur(3px)',
      zIndex: 1000, display: 'flex', alignItems: 'center', justifyContent: 'center', padding: 24,
      animation: 'dsFade 160ms ease',
    }}>
      <div onClick={e => e.stopPropagation()} style={{
        background: DS.surface, borderRadius: DS.rXl, width, maxWidth: '100%', maxHeight: '88vh',
        overflow: 'hidden', boxShadow: DS.shPop, display: 'flex', flexDirection: 'column',
        animation: 'dsPop 200ms cubic-bezier(0.25,0,0,1)',
      }}>
        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', padding: '18px 22px', borderBottom: `1px solid ${DS.border}` }}>
          <span style={{ fontFamily: DS.fontDisp, fontSize: 19, fontWeight: 700, color: DS.fg1 }}>{title}</span>
          <button onClick={onClose} style={{ border: 'none', background: 'none', cursor: 'pointer', color: DS.fg3, display: 'flex', padding: 4 }}>
            <Icon name="x" size={20} />
          </button>
        </div>
        <div style={{ padding: 22, overflowY: 'auto' }}>{children}</div>
        {footer && <div style={{ display: 'flex', justifyContent: 'flex-end', gap: 10, padding: '16px 22px', borderTop: `1px solid ${DS.border}`, background: '#FBF9F5' }}>{footer}</div>}
      </div>
    </div>
  );
}

/* ── EMPTY STATE ────────────────────────────────────────── */
function EmptyState({ icon = 'file-text', title, body, action }) {
  return (
    <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center', padding: '56px 24px', textAlign: 'center' }}>
      <div style={{ width: 64, height: 64, borderRadius: DS.rLg, background: '#EFEBE3', display: 'flex', alignItems: 'center', justifyContent: 'center', color: DS.fg4, marginBottom: 18 }}>
        <Icon name={icon} size={28} stroke={1.5} />
      </div>
      <div style={{ fontFamily: DS.fontDisp, fontSize: 20, fontWeight: 700, color: DS.fg1, marginBottom: 6 }}>{title}</div>
      <div style={{ fontFamily: DS.fontUI, fontSize: 13.5, color: DS.fg3, maxWidth: 360, lineHeight: 1.6, marginBottom: action ? 20 : 0 }}>{body}</div>
      {action}
    </div>
  );
}

/* ── SPINNER ────────────────────────────────────────────── */
function Spinner({ size = 20, color = DS.gold }) {
  return (
    <div style={{
      width: size, height: size, borderRadius: 999,
      border: `${Math.max(2, size/10)}px solid ${color}33`, borderTopColor: color,
      animation: 'dsSpin 0.7s linear infinite',
    }}></div>
  );
}

/* ── PROGRESS BAR ───────────────────────────────────────── */
function ProgressBar({ value, color = DS.gold, height = 6, bg = DS.border }) {
  return (
    <div style={{ width: '100%', height, borderRadius: 999, background: bg, overflow: 'hidden' }}>
      <div style={{ width: `${Math.min(100, value)}%`, height: '100%', background: color, borderRadius: 999, transition: 'width 600ms ease' }}></div>
    </div>
  );
}

/* ── SPARKLINE ──────────────────────────────────────────── */
function Sparkline({ data, color = DS.gold, width = 90, height = 28, fill = true }) {
  const max = Math.max(...data), min = Math.min(...data);
  const range = max - min || 1;
  const pts = data.map((d, i) => [(i / (data.length - 1)) * width, height - ((d - min) / range) * (height - 4) - 2]);
  const path = pts.map((p, i) => `${i === 0 ? 'M' : 'L'}${p[0].toFixed(1)},${p[1].toFixed(1)}`).join(' ');
  const area = `${path} L${width},${height} L0,${height} Z`;
  const id = 'sg' + Math.random().toString(36).slice(2, 7);
  return (
    <svg width={width} height={height} style={{ display: 'block' }}>
      <defs><linearGradient id={id} x1="0" y1="0" x2="0" y2="1">
        <stop offset="0%" stopColor={color} stopOpacity="0.22" /><stop offset="100%" stopColor={color} stopOpacity="0" />
      </linearGradient></defs>
      {fill && <path d={area} fill={`url(#${id})`} />}
      <path d={path} fill="none" stroke={color} strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
    </svg>
  );
}

Object.assign(window, {
  DS, Icon, Btn, Badge, Card, StatCard, Avatar, ScoreRing, SegTabs,
  SearchInput, Toggle, Field, Modal, EmptyState, Spinner, ProgressBar, Sparkline,
});
