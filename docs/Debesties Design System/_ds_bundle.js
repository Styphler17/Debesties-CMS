/* @ds-bundle: {"format":3,"namespace":"DebestiesDesignSystem_d5215c","components":[],"sourceHashes":{"ui_kits/debesties-cms/Analytics.jsx":"cf7c45458fd1","ui_kits/debesties-cms/AppShell.jsx":"6952432327a4","ui_kits/debesties-cms/ContentViews.jsx":"983d73502b92","ui_kits/debesties-cms/Dashboard.jsx":"77128081adf7","ui_kits/debesties-cms/PostEditor.jsx":"8f80b20b669b","ui_kits/debesties-cms/PostsList.jsx":"e9aab3ba001c","ui_kits/debesties-cms/Subscribers.jsx":"786382d3462b","ui_kits/debesties-cms/SystemViews.jsx":"68569e1390e1","ui_kits/debesties-cms/components.jsx":"5cbb33ec88cb","ui_kits/debesties-cms/data.jsx":"c6a09d514a82","ui_kits/debesties-cms/tweaks-panel.jsx":"6591467622ed","ui_kits/debesties/ArticleCard.jsx":"7b09d905fff3","ui_kits/debesties/Navigation.jsx":"2bfb3b8a0b87","ui_kits/debesties/TimelinePage.jsx":"f57e3b249ac1"},"inlinedExternals":[],"unexposedExports":[]} */

(() => {

const __ds_ns = (window.DebestiesDesignSystem_d5215c = window.DebestiesDesignSystem_d5215c || {});

const __ds_scope = {};

(__ds_ns.__errors = __ds_ns.__errors || []);

// ui_kits/debesties-cms/Analytics.jsx
try { (() => {
// Debesties CMS — Analytics View
// Exports to window: Analytics

function PageHeader({
  title,
  subtitle,
  children
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'flex-end',
      justifyContent: 'space-between',
      gap: 16,
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      color: DS.fg3
    }
  }, subtitle)), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 10,
      alignItems: 'center'
    }
  }, children));
}
function BarRow({
  label,
  value,
  max,
  color,
  suffix
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 12
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 130,
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg2,
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis'
    }
  }, label), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement(ProgressBar, {
    value: value / max * 100,
    color: color,
    height: 8
  })), /*#__PURE__*/React.createElement("span", {
    style: {
      width: 56,
      textAlign: 'right',
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 600,
      color: DS.fg1
    }
  }, suffix));
}
function Analytics({
  accent
}) {
  const [range, setRange] = React.useState('7d');
  const bars = [42, 48, 46, 58, 54, 68, 64, 76, 72, 84, 80, 92, 88, 96, 100, 94, 88, 82, 90, 98];
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 20
    }
  }, /*#__PURE__*/React.createElement(PageHeader, {
    subtitle: "Performance across all published content"
  }, /*#__PURE__*/React.createElement(SegTabs, {
    tabs: [{
      value: '24h',
      label: '24h'
    }, {
      value: '7d',
      label: '7 days'
    }, {
      value: '30d',
      label: '30 days'
    }, {
      value: '12m',
      label: '12 mo'
    }],
    active: range,
    onChange: setRange,
    size: "sm"
  }), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    icon: "external-link",
    size: "md"
  }, "Export")), /*#__PURE__*/React.createElement("div", {
    className: "cms-stat-grid",
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(4,1fr)',
      gap: 14
    }
  }, /*#__PURE__*/React.createElement(StatCard, {
    label: "Total Views",
    value: "1.24M",
    delta: "+18%",
    deltaDir: "up",
    icon: "eye",
    tone: "gold"
  }), /*#__PURE__*/React.createElement(StatCard, {
    label: "Unique Visitors",
    value: "612K",
    delta: "+11%",
    deltaDir: "up",
    icon: "users",
    tone: "green"
  }), /*#__PURE__*/React.createElement(StatCard, {
    label: "Avg. Time on Page",
    value: "3:42",
    delta: "+0:18",
    deltaDir: "up",
    icon: "clock",
    tone: "blue"
  }), /*#__PURE__*/React.createElement(StatCard, {
    label: "Bounce Rate",
    value: "38%",
    delta: "\\u22124%",
    deltaDir: "up",
    icon: "trending-down",
    tone: "ai"
  })), /*#__PURE__*/React.createElement(Card, null, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      marginBottom: 18
    }
  }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Traffic Overview"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg3,
      marginTop: 2
    }
  }, "Pageviews over time")), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 16
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 6
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 10,
      height: 10,
      borderRadius: 3,
      background: DS.gold
    }
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg3
    }
  }, "This period")), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 6
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 10,
      height: 10,
      borderRadius: 3,
      background: DS.border
    }
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg3
    }
  }, "Previous")))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'flex-end',
      gap: 6,
      height: 180
    }
  }, bars.map((h, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      flex: 1,
      display: 'flex',
      flexDirection: 'column',
      justifyContent: 'flex-end',
      gap: 0,
      height: '100%'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      height: `${h}%`,
      background: i >= 15 ? `linear-gradient(to top, ${DS.gold}, ${DS.gold}cc)` : `${DS.gold}55`,
      borderRadius: '4px 4px 0 0',
      transition: 'height 500ms ease',
      minHeight: 4
    }
  })))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'space-between',
      marginTop: 10,
      fontFamily: DS.fontMono,
      fontSize: 10.5,
      color: DS.fg4
    }
  }, ['May 20', 'May 24', 'May 28', 'Jun 1', 'Jun 5', 'Jun 9'].map(d => /*#__PURE__*/React.createElement("span", {
    key: d
  }, d)))), /*#__PURE__*/React.createElement("div", {
    className: "cms-dash-cols",
    style: {
      display: 'grid',
      gridTemplateColumns: '1.5fr 1fr',
      gap: 20,
      alignItems: 'start'
    }
  }, /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Top Articles"), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg4
    }
  }, "by pageviews")), TOP_ARTICLES.map((a, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 14,
      padding: '13px 20px',
      borderBottom: i < TOP_ARTICLES.length - 1 ? `1px solid ${DS.border}` : 'none'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontMono,
      fontSize: 13,
      fontWeight: 700,
      color: DS.fg4,
      width: 16
    }
  }, i + 1), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1,
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis'
    }
  }, a.title), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg3,
      marginTop: 2
    }
  }, (a.views / 1000).toFixed(1), "K views \xB7 4:12 avg")), /*#__PURE__*/React.createElement(Sparkline, {
    data: a.trend,
    color: a.up.startsWith('\u2212') ? DS.red : DS.green,
    width: 70
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 700,
      color: a.up.startsWith('\u2212') ? DS.red : DS.green,
      width: 46,
      textAlign: 'right'
    }
  }, a.up)))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 20
    }
  }, /*#__PURE__*/React.createElement(Card, null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1,
      marginBottom: 16
    }
  }, "Traffic Sources"), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      height: 12,
      borderRadius: 999,
      overflow: 'hidden',
      marginBottom: 18
    }
  }, TRAFFIC_SOURCES.map(s => /*#__PURE__*/React.createElement("div", {
    key: s.name,
    style: {
      width: `${s.pct}%`,
      background: s.color
    }
  }))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 11
    }
  }, TRAFFIC_SOURCES.map(s => /*#__PURE__*/React.createElement("div", {
    key: s.name,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 10
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 10,
      height: 10,
      borderRadius: 3,
      background: s.color,
      flexShrink: 0
    }
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      flex: 1,
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg2
    }
  }, s.name), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 700,
      color: DS.fg1
    }
  }, s.pct, "%"))))), /*#__PURE__*/React.createElement(Card, null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1,
      marginBottom: 16
    }
  }, "Author Performance"), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 13
    }
  }, [['Ama Boateng', 412, '#E8A800'], ['Kwesi Mensah', 318, '#1A8A4B'], ['Yaw Owusu', 224, '#2F6BD8'], ['Esi Arthur', 156, '#B14FD8']].map(([n, v, c]) => /*#__PURE__*/React.createElement("div", {
    key: n,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 10
    }
  }, /*#__PURE__*/React.createElement(Avatar, {
    name: n,
    size: 28
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      flex: 1,
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg2
    }
  }, n), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 700,
      color: DS.fg1
    }
  }, v, "K"))))))), /*#__PURE__*/React.createElement("div", {
    className: "cms-dash-cols",
    style: {
      display: 'grid',
      gridTemplateColumns: '1fr 1.5fr',
      gap: 20,
      alignItems: 'start'
    }
  }, /*#__PURE__*/React.createElement(Card, null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1,
      marginBottom: 18
    }
  }, "Category Performance"), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 14
    }
  }, TRENDING_CATS.map(c => /*#__PURE__*/React.createElement(BarRow, {
    key: c.name,
    label: c.name,
    value: c.share,
    max: 38,
    color: c.color,
    suffix: c.views
  })))), /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`,
      display: 'flex',
      alignItems: 'center',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "search-check",
    size: 17,
    color: DS.blue,
    stroke: 2
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Search Performance")), /*#__PURE__*/React.createElement("div", {
    style: {
      overflowX: 'auto'
    }
  }, /*#__PURE__*/React.createElement("table", {
    style: {
      width: '100%',
      borderCollapse: 'collapse',
      minWidth: 460
    }
  }, /*#__PURE__*/React.createElement("thead", null, /*#__PURE__*/React.createElement("tr", {
    style: {
      background: '#FBF9F5'
    }
  }, ['Query', 'Pos', 'Clicks', 'CTR'].map((h, i) => /*#__PURE__*/React.createElement("th", {
    key: h,
    style: {
      padding: '10px 16px',
      textAlign: i === 0 ? 'left' : 'right',
      fontFamily: DS.fontUI,
      fontSize: 11,
      fontWeight: 700,
      letterSpacing: '0.05em',
      textTransform: 'uppercase',
      color: DS.fg4
    }
  }, h)))), /*#__PURE__*/React.createElement("tbody", null, SEARCH_QUERIES.map((q, i) => /*#__PURE__*/React.createElement("tr", {
    key: i,
    style: {
      borderTop: `1px solid ${DS.border}`
    }
  }, /*#__PURE__*/React.createElement("td", {
    style: {
      padding: '11px 16px',
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg1,
      fontWeight: 500
    }
  }, q.q), /*#__PURE__*/React.createElement("td", {
    style: {
      padding: '11px 16px',
      textAlign: 'right'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontMono,
      fontSize: 12,
      fontWeight: 700,
      color: q.pos <= 3 ? DS.green : DS.gold,
      background: q.pos <= 3 ? DS.greenSoft : DS.goldSoft,
      padding: '2px 8px',
      borderRadius: 999
    }
  }, "#", q.pos)), /*#__PURE__*/React.createElement("td", {
    style: {
      padding: '11px 16px',
      textAlign: 'right',
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 600,
      color: DS.fg1
    }
  }, (q.clicks / 1000).toFixed(1), "K"), /*#__PURE__*/React.createElement("td", {
    style: {
      padding: '11px 16px',
      textAlign: 'right',
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg2
    }
  }, q.ctr)))))))), /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "trending-down",
    size: 17,
    color: DS.red,
    stroke: 2
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Content Decay Alerts")), /*#__PURE__*/React.createElement(Badge, {
    tone: "decay",
    dot: false
  }, DECAY.length, " declining")), DECAY.map((d, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 14,
      padding: '13px 20px',
      borderBottom: i < DECAY.length - 1 ? `1px solid ${DS.border}` : 'none'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 32,
      height: 32,
      borderRadius: 8,
      background: DS.redSoft,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      flexShrink: 0
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "trending-down",
    size: 16,
    color: DS.red,
    stroke: 2
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1,
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis'
    }
  }, d.title), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg3,
      marginTop: 2
    }
  }, d.reason)), /*#__PURE__*/React.createElement("div", {
    style: {
      textAlign: 'right'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 700,
      color: DS.red
    }
  }, d.drop), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11,
      color: DS.fg4
    }
  }, d.lastUpdate)), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    icon: "refresh"
  }, "Refresh")))));
}
Object.assign(window, {
  Analytics,
  PageHeader,
  BarRow
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties-cms/Analytics.jsx", error: String((e && e.message) || e) }); }

// ui_kits/debesties-cms/AppShell.jsx
try { (() => {
// Debesties CMS — App Shell (Sidebar + Topbar)
// Exports to window: Sidebar, Topbar

function Sidebar({
  active,
  onNavigate,
  collapsed,
  mobileOpen,
  onCloseMobile,
  accent
}) {
  const width = collapsed ? 72 : 248;
  return /*#__PURE__*/React.createElement(React.Fragment, null, mobileOpen && /*#__PURE__*/React.createElement("div", {
    onClick: onCloseMobile,
    style: {
      position: 'fixed',
      inset: 0,
      background: 'rgba(20,16,12,0.5)',
      zIndex: 90,
      display: 'none',
      animation: 'dsFade 160ms ease'
    },
    className: "cms-mobile-backdrop"
  }), /*#__PURE__*/React.createElement("aside", {
    className: `cms-sidebar ${mobileOpen ? 'cms-mobile-open' : ''}`,
    style: {
      width,
      background: DS.sidebar,
      height: '100vh',
      position: 'sticky',
      top: 0,
      display: 'flex',
      flexDirection: 'column',
      flexShrink: 0,
      transition: 'width 200ms cubic-bezier(0.25,0,0,1)',
      zIndex: 95,
      borderRight: '1px solid rgba(255,255,255,0.06)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      height: 64,
      display: 'flex',
      alignItems: 'center',
      gap: 10,
      padding: collapsed ? '0 16px' : '0 20px',
      flexShrink: 0,
      borderBottom: '1px solid rgba(255,255,255,0.06)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 36,
      height: 36,
      borderRadius: 9,
      flexShrink: 0,
      background: `linear-gradient(125deg, ${DS.aiFrom}, ${DS.aiTo})`,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      fontFamily: DS.fontUI,
      fontWeight: 800,
      fontSize: 19,
      color: '#fff',
      boxShadow: '0 2px 10px rgba(120,79,224,0.4)'
    }
  }, "d"), !collapsed && /*#__PURE__*/React.createElement("div", {
    style: {
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontWeight: 700,
      fontSize: 16,
      color: '#fff',
      letterSpacing: '-0.01em',
      lineHeight: 1.1
    }
  }, "debesties"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 10.5,
      color: 'rgba(255,255,255,0.4)',
      letterSpacing: '0.08em',
      textTransform: 'uppercase',
      fontWeight: 600
    }
  }, "Studio"))), /*#__PURE__*/React.createElement("nav", {
    style: {
      flex: 1,
      overflowY: 'auto',
      padding: '14px 12px',
      display: 'flex',
      flexDirection: 'column',
      gap: 4
    },
    className: "cms-nav-scroll"
  }, NAV_ITEMS.map(group => /*#__PURE__*/React.createElement("div", {
    key: group.group,
    style: {
      marginBottom: 10
    }
  }, !collapsed && /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 10.5,
      fontWeight: 700,
      letterSpacing: '0.1em',
      textTransform: 'uppercase',
      color: 'rgba(255,255,255,0.32)',
      padding: '6px 10px 4px'
    }
  }, group.group), group.items.map(item => {
    const on = active === item.key;
    return /*#__PURE__*/React.createElement("button", {
      key: item.key,
      onClick: () => {
        onNavigate(item.key);
        onCloseMobile && onCloseMobile();
      },
      title: collapsed ? item.label : undefined,
      style: {
        display: 'flex',
        alignItems: 'center',
        gap: 11,
        width: '100%',
        padding: collapsed ? '10px' : '9px 10px',
        justifyContent: collapsed ? 'center' : 'flex-start',
        border: 'none',
        borderRadius: DS.rMd,
        cursor: 'pointer',
        marginBottom: 1,
        background: on ? 'rgba(232,168,0,0.14)' : 'transparent',
        color: on ? accent : 'rgba(255,255,255,0.66)',
        fontFamily: DS.fontUI,
        fontSize: 13.5,
        fontWeight: on ? 600 : 500,
        transition: 'background 140ms, color 140ms',
        position: 'relative'
      },
      onMouseEnter: e => {
        if (!on) {
          e.currentTarget.style.background = 'rgba(255,255,255,0.05)';
          e.currentTarget.style.color = 'rgba(255,255,255,0.92)';
        }
      },
      onMouseLeave: e => {
        if (!on) {
          e.currentTarget.style.background = 'transparent';
          e.currentTarget.style.color = 'rgba(255,255,255,0.66)';
        }
      }
    }, on && !collapsed && /*#__PURE__*/React.createElement("span", {
      style: {
        position: 'absolute',
        left: -12,
        top: 8,
        bottom: 8,
        width: 3,
        borderRadius: 999,
        background: accent
      }
    }), /*#__PURE__*/React.createElement(Icon, {
      name: item.icon,
      size: 18,
      stroke: 2
    }), !collapsed && /*#__PURE__*/React.createElement("span", {
      style: {
        flex: 1,
        textAlign: 'left'
      }
    }, item.label), !collapsed && item.count != null && /*#__PURE__*/React.createElement("span", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 11,
        fontWeight: 700,
        color: on ? accent : 'rgba(255,255,255,0.4)',
        background: 'rgba(255,255,255,0.06)',
        padding: '1px 7px',
        borderRadius: 999
      }
    }, item.count), !collapsed && item.badge && /*#__PURE__*/React.createElement("span", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 9.5,
        fontWeight: 800,
        letterSpacing: '0.05em',
        color: '#fff',
        background: `linear-gradient(120deg,${DS.aiFrom},${DS.aiTo})`,
        padding: '2px 6px',
        borderRadius: 999
      }
    }, item.badge));
  })))), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: 12,
      borderTop: '1px solid rgba(255,255,255,0.06)',
      flexShrink: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 10,
      padding: collapsed ? 0 : '8px 8px',
      justifyContent: collapsed ? 'center' : 'flex-start',
      borderRadius: DS.rMd,
      cursor: 'pointer'
    },
    onMouseEnter: e => e.currentTarget.style.background = 'rgba(255,255,255,0.05)',
    onMouseLeave: e => e.currentTarget.style.background = 'transparent'
  }, /*#__PURE__*/React.createElement(Avatar, {
    name: "Ama Boateng",
    size: 34
  }), !collapsed && /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 600,
      color: '#fff',
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis'
    }
  }, "Ama Boateng"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11,
      color: 'rgba(255,255,255,0.4)'
    }
  }, "Admin")), !collapsed && /*#__PURE__*/React.createElement(Icon, {
    name: "chevron-down",
    size: 15,
    color: "rgba(255,255,255,0.4)"
  })))));
}
function Topbar({
  title,
  onToggleSidebar,
  onMobileMenu,
  onNewPost,
  accent
}) {
  const [notifOpen, setNotifOpen] = React.useState(false);
  return /*#__PURE__*/React.createElement("header", {
    style: {
      height: 64,
      background: 'rgba(244,241,236,0.85)',
      backdropFilter: 'blur(12px)',
      WebkitBackdropFilter: 'blur(12px)',
      borderBottom: `1px solid ${DS.border}`,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      padding: '0 24px',
      gap: 16,
      position: 'sticky',
      top: 0,
      zIndex: 80,
      flexShrink: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 12,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("button", {
    onClick: onToggleSidebar,
    className: "cms-desktop-only",
    style: {
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      color: DS.fg3,
      display: 'flex',
      padding: 6,
      borderRadius: 8
    },
    title: "Toggle sidebar"
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "panel-left",
    size: 20
  })), /*#__PURE__*/React.createElement("button", {
    onClick: onMobileMenu,
    className: "cms-mobile-only",
    style: {
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      color: DS.fg2,
      display: 'none',
      padding: 6
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "menu",
    size: 22
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("h1", {
    style: {
      fontFamily: DS.fontDisp,
      fontSize: 21,
      fontWeight: 700,
      color: DS.fg1,
      margin: 0,
      letterSpacing: '-0.01em',
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis'
    }
  }, title))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 10
    }
  }, /*#__PURE__*/React.createElement("div", {
    className: "cms-search-hide"
  }, /*#__PURE__*/React.createElement(SearchInput, {
    value: "",
    onChange: () => {},
    placeholder: "Search posts, media\u2026",
    width: 240
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement("button", {
    onClick: () => setNotifOpen(o => !o),
    style: {
      border: `1.5px solid ${DS.border}`,
      background: DS.surface,
      cursor: 'pointer',
      color: DS.fg2,
      display: 'flex',
      padding: 9,
      borderRadius: DS.rMd,
      position: 'relative'
    },
    title: "Notifications"
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "bell",
    size: 18
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      top: 6,
      right: 7,
      width: 7,
      height: 7,
      borderRadius: 999,
      background: DS.red,
      border: '1.5px solid ' + DS.surface
    }
  })), notifOpen && /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      top: 48,
      right: 0,
      width: 300,
      background: DS.surface,
      borderRadius: DS.rLg,
      boxShadow: DS.shPop,
      border: `1px solid ${DS.border}`,
      zIndex: 100,
      overflow: 'hidden',
      animation: 'dsPop 180ms ease'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '12px 16px',
      borderBottom: `1px solid ${DS.border}`,
      fontFamily: DS.fontUI,
      fontWeight: 700,
      fontSize: 13.5,
      color: DS.fg1
    }
  }, "Notifications"), [{
    t: 'Yaw submitted a post for review',
    s: '3h ago',
    tone: 'review'
  }, {
    t: 'V.I.P article flagged for content decay',
    s: '1d ago',
    tone: 'decay'
  }, {
    t: '12 new comments awaiting moderation',
    s: '1d ago',
    tone: 'neutral'
  }].map((n, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      padding: '11px 16px',
      borderBottom: i < 2 ? `1px solid ${DS.border}` : 'none',
      display: 'flex',
      gap: 10,
      cursor: 'pointer'
    },
    onMouseEnter: e => e.currentTarget.style.background = '#FBF9F5',
    onMouseLeave: e => e.currentTarget.style.background = 'transparent'
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 7,
      height: 7,
      borderRadius: 999,
      background: BADGE_TONES[n.tone].dot,
      marginTop: 5,
      flexShrink: 0
    }
  }), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg1,
      lineHeight: 1.4
    }
  }, n.t), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11,
      color: DS.fg4,
      marginTop: 2
    }
  }, n.s)))))), /*#__PURE__*/React.createElement("div", {
    className: "cms-newpost-hide"
  }, /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    icon: "plus",
    onClick: onNewPost
  }, "New Post"))));
}
Object.assign(window, {
  Sidebar,
  Topbar
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties-cms/AppShell.jsx", error: String((e && e.message) || e) }); }

// ui_kits/debesties-cms/ContentViews.jsx
try { (() => {
// Debesties CMS — Editorial Calendar + Content Views
// Exports to window: Calendar, Pages, MediaLibrary, Categories, Tags, Comments

/* ── PAGES ─────────────────────────────────────────────── */
function Pages({
  onEditPost,
  onNewPost,
  accent
}) {
  const [search, setSearch] = React.useState('');
  const [statusFilter, setStatusFilter] = React.useState('all');
  const [nav, setNav] = React.useState(() => Object.fromEntries(PAGES.map(p => [p.id, p.inNav])));
  const [menuOpen, setMenuOpen] = React.useState(null);
  const counts = {
    all: PAGES.length,
    published: PAGES.filter(p => p.status === 'published').length,
    draft: PAGES.filter(p => p.status === 'draft').length,
    scheduled: PAGES.filter(p => p.status === 'scheduled').length
  };
  const filtered = PAGES.filter(p => {
    if (statusFilter !== 'all' && p.status !== statusFilter) return false;
    if (search && !p.title.toLowerCase().includes(search.toLowerCase())) return false;
    return true;
  });
  const tplTone = {
    Standard: '#7A7163',
    Legal: '#7A7163',
    'Contact form': '#2F6BD8',
    Landing: '#E8A800',
    Timeline: '#1A8A4B',
    'Team grid': '#B14FD8'
  };
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 16
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: 14,
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement(SegTabs, {
    tabs: [{
      value: 'all',
      label: 'All',
      count: counts.all
    }, {
      value: 'published',
      label: 'Published',
      count: counts.published
    }, {
      value: 'draft',
      label: 'Drafts',
      count: counts.draft
    }, {
      value: 'scheduled',
      label: 'Scheduled',
      count: counts.scheduled
    }],
    active: statusFilter,
    onChange: setStatusFilter
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 10,
      alignItems: 'center',
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement(SearchInput, {
    value: search,
    onChange: setSearch,
    placeholder: "Search pages\u2026",
    width: 220
  }), /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    icon: "plus",
    onClick: onNewPost
  }, "New Page"))), /*#__PURE__*/React.createElement(Card, {
    pad: 0,
    style: {
      overflow: 'visible'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      overflowX: 'auto'
    }
  }, /*#__PURE__*/React.createElement("table", {
    style: {
      width: '100%',
      borderCollapse: 'collapse',
      minWidth: 760
    }
  }, /*#__PURE__*/React.createElement("thead", null, /*#__PURE__*/React.createElement("tr", {
    style: {
      borderBottom: `1px solid ${DS.border}`,
      background: '#FBF9F5'
    }
  }, ['Page', 'Status', 'Template', 'In Menu', 'Views', 'Updated', ''].map((h, i) => /*#__PURE__*/React.createElement("th", {
    key: i,
    style: {
      padding: '12px 16px',
      textAlign: i === 4 ? 'right' : 'left',
      fontFamily: DS.fontUI,
      fontSize: 11,
      fontWeight: 700,
      letterSpacing: '0.06em',
      textTransform: 'uppercase',
      color: DS.fg4,
      whiteSpace: 'nowrap'
    }
  }, h)))), /*#__PURE__*/React.createElement("tbody", null, filtered.map(p => /*#__PURE__*/React.createElement("tr", {
    key: p.id,
    style: {
      borderBottom: `1px solid ${DS.border}`
    },
    onMouseEnter: e => e.currentTarget.style.background = '#FBF9F5',
    onMouseLeave: e => e.currentTarget.style.background = 'transparent'
  }, /*#__PURE__*/React.createElement("td", {
    style: {
      padding: '12px 16px'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 12,
      cursor: 'pointer',
      maxWidth: 340
    },
    onClick: () => onEditPost && onEditPost(null)
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 34,
      height: 34,
      borderRadius: 8,
      background: '#EFEBE3',
      flexShrink: 0,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      color: DS.fg3
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "book-open",
    size: 16,
    stroke: 2
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1,
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis'
    }
  }, p.title), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontMono,
      fontSize: 11,
      color: DS.fg4,
      marginTop: 2
    }
  }, "debesties.com/", p.slug)))), /*#__PURE__*/React.createElement("td", {
    style: {
      padding: '12px 16px'
    }
  }, /*#__PURE__*/React.createElement(Badge, {
    tone: p.status
  }, p.status)), /*#__PURE__*/React.createElement("td", {
    style: {
      padding: '12px 16px'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 6,
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg2,
      whiteSpace: 'nowrap'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 7,
      height: 7,
      borderRadius: 999,
      background: tplTone[p.template] || DS.fg4
    }
  }), p.template)), /*#__PURE__*/React.createElement("td", {
    style: {
      padding: '12px 16px'
    }
  }, /*#__PURE__*/React.createElement(Toggle, {
    on: nav[p.id],
    onChange: () => setNav(n => ({
      ...n,
      [p.id]: !n[p.id]
    })),
    size: "sm"
  })), /*#__PURE__*/React.createElement("td", {
    style: {
      padding: '12px 16px',
      textAlign: 'right',
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 600,
      color: p.views ? DS.fg1 : DS.fg4
    }
  }, p.views ? p.views >= 1000 ? (p.views / 1000).toFixed(1) + 'K' : p.views : '—'), /*#__PURE__*/React.createElement("td", {
    style: {
      padding: '12px 16px',
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg3,
      whiteSpace: 'nowrap'
    }
  }, p.updated), /*#__PURE__*/React.createElement("td", {
    style: {
      padding: '12px 16px',
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement("button", {
    onClick: () => setMenuOpen(menuOpen === p.id ? null : p.id),
    style: {
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      color: DS.fg3,
      padding: 5,
      borderRadius: 6,
      display: 'flex'
    },
    onMouseEnter: e => e.currentTarget.style.background = '#EFEBE3',
    onMouseLeave: e => e.currentTarget.style.background = 'transparent'
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "more-horizontal",
    size: 18
  })), menuOpen === p.id && /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
    onClick: () => setMenuOpen(null),
    style: {
      position: 'fixed',
      inset: 0,
      zIndex: 40
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      top: 36,
      right: 14,
      width: 160,
      background: DS.surface,
      borderRadius: DS.rMd,
      boxShadow: DS.shPop,
      border: `1px solid ${DS.border}`,
      zIndex: 50,
      padding: 5,
      animation: 'dsPop 150ms ease'
    }
  }, [{
    l: 'Edit',
    i: 'edit',
    a: () => onEditPost && onEditPost(null)
  }, {
    l: 'View live',
    i: 'external-link'
  }, {
    l: 'Duplicate',
    i: 'copy'
  }, {
    l: 'Delete',
    i: 'trash',
    danger: true
  }].map(m => /*#__PURE__*/React.createElement("button", {
    key: m.l,
    onClick: () => {
      m.a && m.a();
      setMenuOpen(null);
    },
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 9,
      width: '100%',
      textAlign: 'left',
      padding: '8px 10px',
      border: 'none',
      background: 'transparent',
      borderRadius: 6,
      cursor: 'pointer',
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 500,
      color: m.danger ? DS.red : DS.fg1
    },
    onMouseEnter: e => e.currentTarget.style.background = m.danger ? DS.redSoft : '#FBF9F5',
    onMouseLeave: e => e.currentTarget.style.background = 'transparent'
  }, /*#__PURE__*/React.createElement(Icon, {
    name: m.i,
    size: 15,
    stroke: 2
  }), m.l)))))))))), filtered.length === 0 && /*#__PURE__*/React.createElement(EmptyState, {
    icon: "book-open",
    title: "No pages found",
    body: "Static pages like About, Contact, and Privacy Policy live here \u2014 separate from your blog posts.",
    action: /*#__PURE__*/React.createElement(Btn, {
      variant: "soft",
      onClick: () => {
        setSearch('');
        setStatusFilter('all');
      }
    }, "Clear filters")
  })));
}

/* ── EDITORIAL CALENDAR ────────────────────────────────── */
function Calendar({
  onEditPost,
  accent
}) {
  const [view, setView] = React.useState('month');
  // June 2026 starts on Monday
  const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
  const sched = {
    3: [{
      t: 'Highlife Roots Explainer',
      tone: 'draft',
      a: 'Esi'
    }],
    9: [{
      t: 'Weekly TGMA Recap',
      tone: 'published',
      a: 'Ama'
    }],
    12: [{
      t: 'TGMA 2026: Full Winners List',
      tone: 'scheduled',
      a: 'Ama'
    }, {
      t: 'Sarkodie Feature',
      tone: 'review',
      a: 'Yaw'
    }],
    16: [{
      t: 'Stonebwoy Cover Story',
      tone: 'draft',
      a: 'Kwesi'
    }],
    19: [{
      t: 'Mid-Year Music Report',
      tone: 'scheduled',
      a: 'Ama'
    }],
    23: [{
      t: 'Black Sherif Interview',
      tone: 'review',
      a: 'Yaw'
    }],
    26: [{
      t: 'Afrobeats vs Drill Debate',
      tone: 'draft',
      a: 'Esi'
    }],
    30: [{
      t: 'June Wrap-up',
      tone: 'scheduled',
      a: 'Kwesi'
    }]
  };
  const firstDay = 0; // Monday index for June 1, 2026 (Mon)
  const daysInMonth = 30;
  const cells = [];
  for (let i = 0; i < firstDay; i++) cells.push(null);
  for (let d = 1; d <= daysInMonth; d++) cells.push(d);
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 18
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      flexWrap: 'wrap',
      gap: 12
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 12
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 4
    }
  }, /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    icon: "chevron-left",
    style: {
      padding: '6px 10px'
    }
  }, ''), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    iconRight: "chevron-right",
    style: {
      padding: '6px 10px'
    }
  }, '')), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontDisp,
      fontSize: 20,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "June 2026"), /*#__PURE__*/React.createElement(Btn, {
    variant: "ghost",
    size: "sm"
  }, "Today")), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 10,
      alignItems: 'center'
    }
  }, /*#__PURE__*/React.createElement(SegTabs, {
    tabs: [{
      value: 'month',
      label: 'Month'
    }, {
      value: 'week',
      label: 'Week'
    }, {
      value: 'list',
      label: 'List'
    }],
    active: view,
    onChange: setView,
    size: "sm"
  }), /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    size: "md",
    icon: "plus"
  }, "Schedule"))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 16,
      flexWrap: 'wrap'
    }
  }, [['Draft', 'draft'], ['In Review', 'review'], ['Scheduled', 'scheduled'], ['Published', 'published']].map(([l, tone]) => /*#__PURE__*/React.createElement("div", {
    key: l,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 6
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 9,
      height: 9,
      borderRadius: 3,
      background: BADGE_TONES[tone].dot
    }
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg3
    }
  }, l)))), /*#__PURE__*/React.createElement(Card, {
    pad: 0,
    style: {
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(7,1fr)',
      borderBottom: `1px solid ${DS.border}`,
      background: '#FBF9F5'
    }
  }, days.map(d => /*#__PURE__*/React.createElement("div", {
    key: d,
    style: {
      padding: '11px 14px',
      fontFamily: DS.fontUI,
      fontSize: 11.5,
      fontWeight: 700,
      letterSpacing: '0.05em',
      textTransform: 'uppercase',
      color: DS.fg4,
      textAlign: 'left'
    }
  }, d))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(7,1fr)'
    }
  }, cells.map((d, i) => {
    const events = d ? sched[d] || [] : [];
    const isToday = d === 9;
    return /*#__PURE__*/React.createElement("div", {
      key: i,
      style: {
        minHeight: 116,
        borderRight: (i + 1) % 7 !== 0 ? `1px solid ${DS.border}` : 'none',
        borderBottom: `1px solid ${DS.border}`,
        padding: 8,
        background: d ? isToday ? DS.goldSoft + '66' : DS.surface : '#FBF9F5',
        display: 'flex',
        flexDirection: 'column',
        gap: 5
      }
    }, d && /*#__PURE__*/React.createElement("div", {
      style: {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between'
      }
    }, /*#__PURE__*/React.createElement("span", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 12.5,
        fontWeight: isToday ? 700 : 500,
        color: isToday ? DS.goldDeep : DS.fg3,
        width: 22,
        height: 22,
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        borderRadius: 999,
        background: isToday ? DS.gold : 'transparent'
      }
    }, d)), events.map((e, j) => /*#__PURE__*/React.createElement("div", {
      key: j,
      onClick: () => onEditPost && onEditPost(null),
      style: {
        cursor: 'pointer',
        padding: '5px 7px',
        borderRadius: 6,
        background: BADGE_TONES[e.tone].bg,
        borderLeft: `2.5px solid ${BADGE_TONES[e.tone].dot}`
      }
    }, /*#__PURE__*/React.createElement("div", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 11,
        fontWeight: 600,
        color: BADGE_TONES[e.tone].fg,
        lineHeight: 1.25,
        overflow: 'hidden',
        textOverflow: 'ellipsis',
        display: '-webkit-box',
        WebkitLineClamp: 2,
        WebkitBoxOrient: 'vertical'
      }
    }, e.t))));
  }))));
}

/* ── MEDIA LIBRARY ─────────────────────────────────────── */
function MediaLibrary({
  accent
}) {
  const [sel, setSel] = React.useState(null);
  const [search, setSearch] = React.useState('');
  const filtered = MEDIA.filter(m => m.name.toLowerCase().includes(search.toLowerCase()));
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 18
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: 12,
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 10,
      alignItems: 'center'
    }
  }, /*#__PURE__*/React.createElement(SearchInput, {
    value: search,
    onChange: setSearch,
    placeholder: "Search media\u2026",
    width: 240
  }), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    icon: "filter",
    iconRight: "chevron-down"
  }, "All types")), /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    icon: "upload"
  }, "Upload media")), /*#__PURE__*/React.createElement("div", {
    style: {
      border: `2px dashed ${DS.borderSt}`,
      borderRadius: DS.rLg,
      padding: '28px',
      display: 'flex',
      flexDirection: 'column',
      alignItems: 'center',
      gap: 8,
      background: '#FBF9F5',
      cursor: 'pointer'
    },
    onMouseEnter: e => {
      e.currentTarget.style.borderColor = DS.gold;
      e.currentTarget.style.background = DS.goldSoft + '55';
    },
    onMouseLeave: e => {
      e.currentTarget.style.borderColor = DS.borderSt;
      e.currentTarget.style.background = '#FBF9F5';
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 44,
      height: 44,
      borderRadius: 999,
      background: DS.surface,
      border: `1px solid ${DS.border}`,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      color: DS.fg3
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "upload",
    size: 20
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1
    }
  }, "Drop files or ", /*#__PURE__*/React.createElement("span", {
    style: {
      color: accent
    }
  }, "browse")), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg4
    }
  }, "JPG, PNG, WebP, MP4 \xB7 up to 50MB")), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fill, minmax(150px, 1fr))',
      gap: 14
    }
  }, filtered.map(m => /*#__PURE__*/React.createElement("div", {
    key: m.id,
    onClick: () => setSel(m),
    style: {
      borderRadius: DS.rMd,
      overflow: 'hidden',
      border: `2px solid ${sel?.id === m.id ? DS.gold : 'transparent'}`,
      cursor: 'pointer',
      background: DS.surface,
      boxShadow: DS.shCard,
      transition: 'border-color 140ms'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      aspectRatio: '1',
      background: m.grad,
      position: 'relative',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "image",
    size: 22,
    color: "rgba(255,255,255,0.5)"
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      top: 7,
      right: 7,
      fontFamily: DS.fontMono,
      fontSize: 9,
      fontWeight: 700,
      color: '#fff',
      background: 'rgba(0,0,0,0.4)',
      padding: '2px 6px',
      borderRadius: 4
    }
  }, m.type)), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '8px 10px'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      fontWeight: 600,
      color: DS.fg1,
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis'
    }
  }, m.name), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11,
      color: DS.fg4,
      marginTop: 1
    }
  }, m.dims, " \xB7 ", m.size))))), sel && /*#__PURE__*/React.createElement(Modal, {
    open: !!sel,
    onClose: () => setSel(null),
    title: sel.name,
    width: 440,
    footer: /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement(Btn, {
      variant: "ghost",
      icon: "trash",
      style: {
        color: DS.red,
        borderColor: DS.redSoft
      }
    }, "Delete"), /*#__PURE__*/React.createElement(Btn, {
      variant: "primary",
      icon: "copy"
    }, "Copy URL"))
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      aspectRatio: '16/9',
      background: sel.grad,
      borderRadius: DS.rMd,
      marginBottom: 16,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "image",
    size: 32,
    color: "rgba(255,255,255,0.5)"
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 12
    }
  }, /*#__PURE__*/React.createElement(Field, {
    label: "Alt text",
    value: sel.name.replace('.jpg', '').replace('.png', '').replace(/-/g, ' '),
    hint: "Describe the image for SEO & accessibility."
  }), [['Dimensions', sel.dims], ['File size', sel.size], ['Type', sel.type], ['Uploaded', 'Jun 2, 2026']].map(([k, v]) => /*#__PURE__*/React.createElement("div", {
    key: k,
    style: {
      display: 'flex',
      justifyContent: 'space-between',
      fontFamily: DS.fontUI,
      fontSize: 13
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      color: DS.fg3
    }
  }, k), /*#__PURE__*/React.createElement("span", {
    style: {
      color: DS.fg1,
      fontWeight: 600
    }
  }, v))))));
}

/* ── CATEGORIES ────────────────────────────────────────── */
function Categories({
  accent
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 18
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'space-between',
      alignItems: 'center',
      flexWrap: 'wrap',
      gap: 12
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      color: DS.fg3
    }
  }, CATEGORIES.length, " categories \xB7 ", CATEGORIES.reduce((a, c) => a + c.posts, 0), " posts organized"), /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    icon: "plus"
  }, "New category")), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fill, minmax(280px, 1fr))',
      gap: 14
    }
  }, CATEGORIES.map(c => /*#__PURE__*/React.createElement(Card, {
    key: c.slug,
    hover: true
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'flex-start',
      gap: 12
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 40,
      height: 40,
      borderRadius: DS.rMd,
      background: `${c.color}1A`,
      color: c.color,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      flexShrink: 0
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "folder",
    size: 20,
    stroke: 2
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, c.name), /*#__PURE__*/React.createElement("button", {
    style: {
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      color: DS.fg4,
      display: 'flex'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "more-horizontal",
    size: 17
  }))), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontMono,
      fontSize: 11,
      color: DS.fg4,
      marginTop: 2
    }
  }, "/", c.slug), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg3,
      marginTop: 8,
      lineHeight: 1.5
    }
  }, c.desc), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      marginTop: 12
    }
  }, /*#__PURE__*/React.createElement(Badge, {
    tone: "neutral",
    dot: false
  }, c.posts, " posts"), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      fontWeight: 600,
      color: accent,
      cursor: 'pointer'
    }
  }, "Edit"))))))));
}

/* ── TAGS ──────────────────────────────────────────────── */
function Tags({
  accent
}) {
  const [search, setSearch] = React.useState('');
  const filtered = TAGS.filter(t => t.name.toLowerCase().includes(search.toLowerCase()));
  const max = Math.max(...TAGS.map(t => t.count));
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 18
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'space-between',
      alignItems: 'center',
      flexWrap: 'wrap',
      gap: 12
    }
  }, /*#__PURE__*/React.createElement(SearchInput, {
    value: search,
    onChange: setSearch,
    placeholder: "Search tags\u2026",
    width: 240
  }), /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    icon: "plus"
  }, "New tag")), /*#__PURE__*/React.createElement(Card, null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 700,
      color: DS.fg2,
      marginBottom: 14
    }
  }, "Tag Cloud"), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexWrap: 'wrap',
      gap: 10
    }
  }, filtered.map(t => {
    const scale = 0.85 + t.count / max * 0.7;
    return /*#__PURE__*/React.createElement("span", {
      key: t.name,
      style: {
        display: 'inline-flex',
        alignItems: 'center',
        gap: 7,
        padding: '7px 14px',
        borderRadius: 999,
        background: '#FBF9F5',
        border: `1px solid ${DS.border}`,
        cursor: 'pointer',
        transition: 'all 140ms'
      },
      onMouseEnter: e => {
        e.currentTarget.style.background = DS.goldSoft;
        e.currentTarget.style.borderColor = DS.gold;
      },
      onMouseLeave: e => {
        e.currentTarget.style.background = '#FBF9F5';
        e.currentTarget.style.borderColor = DS.border;
      }
    }, /*#__PURE__*/React.createElement(Icon, {
      name: "tag",
      size: 13,
      color: DS.fg4
    }), /*#__PURE__*/React.createElement("span", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 12 + scale * 3,
        fontWeight: 600,
        color: DS.fg1
      }
    }, t.name), /*#__PURE__*/React.createElement("span", {
      style: {
        fontFamily: DS.fontMono,
        fontSize: 11,
        color: DS.fg4
      }
    }, t.count));
  }))));
}

/* ── COMMENTS ──────────────────────────────────────────── */
function Comments({
  accent
}) {
  const [filter, setFilter] = React.useState('pending');
  const counts = {
    all: COMMENTS.length,
    pending: COMMENTS.filter(c => c.status === 'pending').length,
    approved: COMMENTS.filter(c => c.status === 'approved').length,
    spam: COMMENTS.filter(c => c.status === 'spam').length
  };
  const filtered = filter === 'all' ? COMMENTS : COMMENTS.filter(c => c.status === filter);
  const toneMap = {
    pending: 'review',
    approved: 'published',
    spam: 'decay'
  };
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 18
    }
  }, /*#__PURE__*/React.createElement(SegTabs, {
    tabs: [{
      value: 'pending',
      label: 'Pending',
      count: counts.pending
    }, {
      value: 'approved',
      label: 'Approved',
      count: counts.approved
    }, {
      value: 'spam',
      label: 'Spam',
      count: counts.spam
    }, {
      value: 'all',
      label: 'All',
      count: counts.all
    }],
    active: filter,
    onChange: setFilter
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 12
    }
  }, filtered.map((c, i) => /*#__PURE__*/React.createElement(Card, {
    key: i,
    pad: 16
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 13
    }
  }, /*#__PURE__*/React.createElement(Avatar, {
    name: c.author,
    size: 38
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8,
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 700,
      color: DS.fg1
    }
  }, c.author), /*#__PURE__*/React.createElement(Badge, {
    tone: toneMap[c.status],
    dot: false
  }, c.status), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg4
    }
  }, "\xB7 ", c.time)), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg3,
      marginTop: 2
    }
  }, "on ", /*#__PURE__*/React.createElement("span", {
    style: {
      color: accent,
      fontWeight: 600
    }
  }, c.post)), /*#__PURE__*/React.createElement("p", {
    style: {
      margin: '10px 0 0',
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      color: DS.fg2,
      lineHeight: 1.55
    }
  }, c.text), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 8,
      marginTop: 12
    }
  }, c.status !== 'approved' && /*#__PURE__*/React.createElement(Btn, {
    variant: "green",
    size: "sm",
    icon: "check"
  }, "Approve"), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm"
  }, "Reply"), c.status !== 'spam' && /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    icon: "alert-triangle",
    style: {
      color: DS.red
    }
  }, "Spam"), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    icon: "trash"
  }, "Delete"))))))));
}
Object.assign(window, {
  Calendar,
  Pages,
  MediaLibrary,
  Categories,
  Tags,
  Comments
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties-cms/ContentViews.jsx", error: String((e && e.message) || e) }); }

// ui_kits/debesties-cms/Dashboard.jsx
try { (() => {
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
// Debesties CMS — Dashboard View
// Exports to window: Dashboard

function Dashboard({
  onNavigate,
  onNewPost,
  accent
}) {
  const stats = [{
    label: 'Total Posts',
    value: '248',
    delta: '+12',
    deltaDir: 'up',
    icon: 'file-text',
    tone: 'gold'
  }, {
    label: 'Published',
    value: '186',
    delta: '+8',
    deltaDir: 'up',
    icon: 'check',
    tone: 'green'
  }, {
    label: 'Drafts',
    value: '34',
    delta: '+3',
    deltaDir: 'up',
    icon: 'edit',
    tone: 'blue'
  }, {
    label: 'Scheduled',
    value: '9',
    delta: null,
    icon: 'clock',
    tone: 'ai'
  }, {
    label: 'Total Views',
    value: '1.24M',
    delta: '+18%',
    deltaDir: 'up',
    icon: 'eye',
    tone: 'gold'
  }, {
    label: 'Avg. SEO Score',
    value: '78',
    delta: '+4',
    deltaDir: 'up',
    icon: 'gauge',
    tone: 'green'
  }];
  const quickActions = [{
    label: 'Write new post',
    icon: 'pen-tool',
    tone: 'gold',
    action: onNewPost
  }, {
    label: 'Upload media',
    icon: 'upload',
    tone: 'blue',
    action: () => onNavigate('media')
  }, {
    label: 'Review queue',
    icon: 'list-checks',
    tone: 'green',
    action: () => onNavigate('posts'),
    badge: '2'
  }, {
    label: 'AI Visibility',
    icon: 'sparkles',
    tone: 'ai',
    action: () => onNavigate('ai')
  }];
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 20
    }
  }, /*#__PURE__*/React.createElement(Card, {
    pad: 0,
    style: {
      overflow: 'hidden',
      border: 'none'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      background: `linear-gradient(115deg, ${DS.fg1} 0%, #2C2118 55%, ${DS.goldDeep} 130%)`,
      padding: '26px 28px',
      display: 'flex',
      justifyContent: 'space-between',
      alignItems: 'center',
      gap: 20,
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 600,
      color: 'rgba(255,255,255,0.55)',
      letterSpacing: '0.04em',
      marginBottom: 6
    }
  }, "Tuesday, June 9 \xB7 Good morning"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontDisp,
      fontSize: 26,
      fontWeight: 700,
      color: '#fff',
      letterSpacing: '-0.01em',
      lineHeight: 1.15
    }
  }, "Welcome back, Ama \uD83D\uDC4B"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      color: 'rgba(255,255,255,0.6)',
      marginTop: 6
    }
  }, "You have ", /*#__PURE__*/React.createElement("b", {
    style: {
      color: DS.gold
    }
  }, "2 posts in review"), " and ", /*#__PURE__*/React.createElement("b", {
    style: {
      color: DS.gold
    }
  }, "3 articles"), " flagged for updates.")), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 10
    }
  }, /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    icon: "plus",
    onClick: onNewPost
  }, "New Post"), /*#__PURE__*/React.createElement(Btn, {
    variant: "ghost",
    icon: "calendar",
    onClick: () => onNavigate('calendar'),
    style: {
      color: '#fff',
      borderColor: 'rgba(255,255,255,0.25)'
    }
  }, "Calendar")))), /*#__PURE__*/React.createElement("div", {
    className: "cms-stat-grid",
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(6,1fr)',
      gap: 14
    }
  }, stats.map(s => /*#__PURE__*/React.createElement(StatCard, _extends({
    key: s.label
  }, s)))), /*#__PURE__*/React.createElement("div", {
    className: "cms-qa-grid",
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(4,1fr)',
      gap: 14
    }
  }, quickActions.map(qa => /*#__PURE__*/React.createElement(Card, {
    key: qa.label,
    pad: 16,
    hover: true,
    onClick: qa.action,
    style: {
      cursor: 'pointer'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 13
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 42,
      height: 42,
      borderRadius: DS.rMd,
      flexShrink: 0,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      background: qa.tone === 'ai' ? `linear-gradient(125deg,${DS.aiFrom},${DS.aiTo})` : `${{
        gold: DS.gold,
        blue: DS.blue,
        green: DS.green
      }[qa.tone]}1A`,
      color: qa.tone === 'ai' ? '#fff' : {
        gold: DS.gold,
        blue: DS.blue,
        green: DS.green
      }[qa.tone]
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: qa.icon,
    size: 20,
    stroke: 2
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1
    }
  }, qa.label), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11.5,
      color: DS.fg4,
      marginTop: 1
    }
  }, "Quick action")), qa.badge && /*#__PURE__*/React.createElement(Badge, {
    tone: "review",
    dot: false
  }, qa.badge), /*#__PURE__*/React.createElement(Icon, {
    name: "chevron-right",
    size: 16,
    color: DS.fg4
  }))))), /*#__PURE__*/React.createElement("div", {
    className: "cms-dash-cols",
    style: {
      display: 'grid',
      gridTemplateColumns: '1.6fr 1fr',
      gap: 20,
      alignItems: 'start'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 20
    }
  }, /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "flame",
    size: 18,
    color: DS.gold,
    stroke: 2
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Top Articles"), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11.5,
      color: DS.fg4,
      fontWeight: 500
    }
  }, "\xB7 last 7 days")), /*#__PURE__*/React.createElement("button", {
    onClick: () => onNavigate('analytics'),
    style: {
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 600,
      color: accent,
      display: 'flex',
      alignItems: 'center',
      gap: 4
    }
  }, "View all ", /*#__PURE__*/React.createElement(Icon, {
    name: "arrow-right",
    size: 13,
    stroke: 2.2
  }))), /*#__PURE__*/React.createElement("div", null, TOP_ARTICLES.map((a, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 14,
      padding: '13px 20px',
      borderBottom: i < TOP_ARTICLES.length - 1 ? `1px solid ${DS.border}` : 'none',
      cursor: 'pointer'
    },
    onMouseEnter: e => e.currentTarget.style.background = '#FBF9F5',
    onMouseLeave: e => e.currentTarget.style.background = 'transparent'
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontMono,
      fontSize: 13,
      fontWeight: 700,
      color: DS.fg4,
      width: 18
    }
  }, i + 1), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1,
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis'
    }
  }, a.title), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg3,
      marginTop: 2
    }
  }, (a.views / 1000).toFixed(1), "K views")), /*#__PURE__*/React.createElement(Sparkline, {
    data: a.trend,
    color: a.up.startsWith('\u2212') ? DS.red : DS.green,
    width: 72,
    height: 26
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 700,
      color: a.up.startsWith('\u2212') ? DS.red : DS.green,
      width: 48,
      textAlign: 'right'
    }
  }, a.up))))), /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "alert-triangle",
    size: 17,
    color: DS.red,
    stroke: 2
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Content Needing Updates")), /*#__PURE__*/React.createElement(Badge, {
    tone: "decay",
    dot: false
  }, DECAY.length, " flagged")), DECAY.map((d, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 14,
      padding: '13px 20px',
      borderBottom: i < DECAY.length - 1 ? `1px solid ${DS.border}` : 'none'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1,
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis'
    }
  }, d.title), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg3,
      marginTop: 2
    }
  }, d.reason, " \xB7 updated ", d.lastUpdate)), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 700,
      color: DS.red
    }
  }, d.drop), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    onClick: () => onNavigate('posts')
  }, "Update"))))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 20
    }
  }, /*#__PURE__*/React.createElement(Card, null, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8,
      marginBottom: 16
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "trending-up",
    size: 17,
    color: DS.green,
    stroke: 2
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Trending Categories")), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 13
    }
  }, TRENDING_CATS.map(c => /*#__PURE__*/React.createElement("div", {
    key: c.name
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'space-between',
      marginBottom: 5
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 600,
      color: DS.fg2
    }
  }, c.name), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg3
    }
  }, c.views)), /*#__PURE__*/React.createElement(ProgressBar, {
    value: c.share,
    color: c.color
  }))))), /*#__PURE__*/React.createElement(Card, null, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      marginBottom: 14
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "search-check",
    size: 17,
    color: DS.blue,
    stroke: 2
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Search Traffic"))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'baseline',
      gap: 10,
      marginBottom: 4
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 30,
      fontWeight: 700,
      color: DS.fg1,
      letterSpacing: '-0.02em'
    }
  }, "21.6K"), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 700,
      color: DS.green,
      display: 'inline-flex',
      alignItems: 'center',
      gap: 2
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "trending-up",
    size: 14,
    stroke: 2.2
  }), "+14%")), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg3,
      marginBottom: 14
    }
  }, "Organic clicks this week"), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'flex-end',
      gap: 5,
      height: 56
    }
  }, [40, 52, 46, 64, 58, 72, 68, 84, 78, 92, 88, 100].map((h, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      flex: 1,
      height: `${h}%`,
      background: i >= 9 ? DS.blue : `${DS.blue}55`,
      borderRadius: 3,
      transition: 'height 400ms ease'
    }
  })))), /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`,
      display: 'flex',
      alignItems: 'center',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "clock",
    size: 17,
    color: DS.fg3,
    stroke: 2
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Recent Activity")), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '4px 0'
    }
  }, ACTIVITY.map((a, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      gap: 11,
      padding: '10px 20px'
    }
  }, a.who === 'System' ? /*#__PURE__*/React.createElement("div", {
    style: {
      width: 28,
      height: 28,
      borderRadius: 999,
      background: DS.redSoft,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      flexShrink: 0
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "alert-triangle",
    size: 14,
    color: DS.red,
    stroke: 2
  })) : /*#__PURE__*/React.createElement(Avatar, {
    name: a.who,
    size: 28
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg2,
      lineHeight: 1.45
    }
  }, /*#__PURE__*/React.createElement("b", {
    style: {
      color: DS.fg1,
      fontWeight: 600
    }
  }, a.who), " ", a.action, " ", /*#__PURE__*/React.createElement("span", {
    style: {
      color: DS.fg1,
      fontWeight: 500
    }
  }, a.target.length > 32 ? a.target.slice(0, 32) + '…' : a.target)), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11,
      color: DS.fg4,
      marginTop: 1
    }
  }, a.time)))))))));
}
Object.assign(window, {
  Dashboard
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties-cms/Dashboard.jsx", error: String((e && e.message) || e) }); }

// ui_kits/debesties-cms/PostEditor.jsx
try { (() => {
// Debesties CMS — Post Editor
// Exports to window: PostEditor

/* ── Small building blocks ─────────────────────────────── */
function EditorBlock({
  icon,
  title,
  desc,
  color,
  children,
  action
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      border: `1px solid ${DS.border}`,
      borderRadius: DS.rLg,
      background: DS.surface,
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 11,
      padding: '14px 18px',
      borderBottom: `1px solid ${DS.border}`,
      background: '#FBF9F5'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 30,
      height: 30,
      borderRadius: 8,
      background: `${color}1A`,
      color,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      flexShrink: 0
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: icon,
    size: 16,
    stroke: 2
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 14,
      fontWeight: 700,
      color: DS.fg1
    }
  }, title), desc && /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11.5,
      color: DS.fg4,
      marginTop: 1
    }
  }, desc)), action), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: 18
    }
  }, children));
}
function RailSection({
  title,
  children,
  action
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      borderBottom: `1px solid ${DS.border}`,
      padding: '16px 18px'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      marginBottom: 12
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      fontWeight: 700,
      letterSpacing: '0.06em',
      textTransform: 'uppercase',
      color: DS.fg3
    }
  }, title), action), children);
}
function PostEditor({
  post,
  onBack,
  accent
}) {
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
  const autoSlug = t => t.toLowerCase().replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-').slice(0, 60);
  React.useEffect(() => {
    if (isNew && title && !slug) setSlug(autoSlug(title));
  }, [title]);
  const addTag = () => {
    if (tagInput.trim() && !tags.includes(tagInput.trim())) {
      setTags([...tags, tagInput.trim()]);
      setTagInput('');
    }
  };
  const cats = ['Awards History', 'Profiles', 'Analysis', 'Explainers', 'News', 'Interviews'];
  const tabs = [{
    value: 'content',
    label: 'Content',
    icon: 'pen-tool'
  }, {
    value: 'seo',
    label: 'SEO',
    icon: 'search-check'
  }, {
    value: 'ai',
    label: 'AI Visibility',
    icon: 'sparkles'
  }];
  const doSave = () => {
    setSaved(true);
    setTimeout(() => setSaved(false), 1800);
  };
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      minHeight: '100%',
      margin: -24
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      padding: '14px 24px',
      borderBottom: `1px solid ${DS.border}`,
      background: 'rgba(244,241,236,0.9)',
      backdropFilter: 'blur(10px)',
      position: 'sticky',
      top: 64,
      zIndex: 60,
      gap: 16,
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 14,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    icon: "chevron-left",
    onClick: onBack
  }, "Posts"), /*#__PURE__*/React.createElement("div", {
    style: {
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 14.5,
      fontWeight: 700,
      color: DS.fg1,
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis',
      maxWidth: 360
    }
  }, title || 'Untitled post'), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8,
      marginTop: 2
    }
  }, /*#__PURE__*/React.createElement(Badge, {
    tone: status
  }, status === 'review' ? 'In Review' : status), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11.5,
      color: saved ? DS.green : DS.fg4,
      display: 'inline-flex',
      alignItems: 'center',
      gap: 4
    }
  }, saved ? /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement(Icon, {
    name: "check",
    size: 12,
    stroke: 2.5
  }), "Saved") : 'Autosaved 2m ago')))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(Btn, {
    variant: "ghost",
    size: "md",
    icon: "clock",
    onClick: () => setShowRevisions(true),
    title: "Revision history"
  }, "History"), /*#__PURE__*/React.createElement(Btn, {
    variant: "ghost",
    size: "md",
    icon: "eye"
  }, "Preview"), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "md",
    icon: "save",
    onClick: doSave
  }, "Save draft"), /*#__PURE__*/React.createElement(Btn, {
    variant: "ghost",
    size: "md",
    icon: "clock",
    onClick: () => setShowSchedule(true)
  }, "Schedule"), /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    size: "md",
    icon: "send",
    onClick: () => setStatus('published')
  }, "Publish"))), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '14px 24px 0',
      display: 'flex',
      justifyContent: 'center',
      borderBottom: `1px solid ${DS.border}`
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      paddingBottom: 14
    }
  }, /*#__PURE__*/React.createElement(SegTabs, {
    tabs: tabs,
    active: tab,
    onChange: setTab
  }))), /*#__PURE__*/React.createElement("div", {
    className: "cms-editor-cols",
    style: {
      display: 'grid',
      gridTemplateColumns: 'minmax(0,1fr) 320px',
      flex: 1,
      alignItems: 'start'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '28px 32px',
      maxWidth: 760,
      margin: '0 auto',
      width: '100%',
      display: 'flex',
      flexDirection: 'column',
      gap: 22
    }
  }, tab === 'content' && /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("textarea", {
    value: title,
    onChange: e => setTitle(e.target.value),
    placeholder: "Post title\u2026",
    rows: 1,
    style: {
      width: '100%',
      border: 'none',
      outline: 'none',
      background: 'none',
      resize: 'none',
      fontFamily: DS.fontDisp,
      fontSize: 34,
      fontWeight: 800,
      color: DS.fg1,
      lineHeight: 1.15,
      letterSpacing: '-0.02em',
      overflow: 'hidden'
    },
    onInput: e => {
      e.target.style.height = 'auto';
      e.target.style.height = e.target.scrollHeight + 'px';
    }
  }), /*#__PURE__*/React.createElement("input", {
    value: subtitle,
    onChange: e => setSubtitle(e.target.value),
    placeholder: "Add a subtitle or deck\u2026",
    style: {
      width: '100%',
      border: 'none',
      outline: 'none',
      background: 'none',
      fontFamily: DS.fontUI,
      fontSize: 17,
      fontWeight: 400,
      color: DS.fg3,
      marginTop: 8,
      lineHeight: 1.4
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 7,
      marginTop: 12,
      fontFamily: DS.fontMono,
      fontSize: 12,
      color: DS.fg4
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "link",
    size: 13
  }), "debesties.com/", /*#__PURE__*/React.createElement("input", {
    value: slug,
    onChange: e => setSlug(e.target.value),
    placeholder: "post-slug",
    style: {
      border: 'none',
      outline: 'none',
      background: 'none',
      fontFamily: DS.fontMono,
      fontSize: 12,
      color: accent,
      fontWeight: 600,
      flex: 1,
      minWidth: 0
    }
  }))), /*#__PURE__*/React.createElement("div", {
    style: {
      border: `1px solid ${DS.border}`,
      borderRadius: DS.rLg,
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 2,
      padding: '8px 10px',
      borderBottom: `1px solid ${DS.border}`,
      background: '#FBF9F5',
      flexWrap: 'wrap'
    }
  }, ['B', 'I', 'U'].map(b => /*#__PURE__*/React.createElement("button", {
    key: b,
    style: {
      width: 30,
      height: 30,
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      borderRadius: 6,
      fontFamily: 'Georgia, serif',
      fontSize: 14,
      fontWeight: b === 'B' ? 700 : 400,
      fontStyle: b === 'I' ? 'italic' : 'normal',
      textDecoration: b === 'U' ? 'underline' : 'none',
      color: DS.fg2
    },
    onMouseEnter: e => e.currentTarget.style.background = '#EFEBE3',
    onMouseLeave: e => e.currentTarget.style.background = 'none'
  }, b)), /*#__PURE__*/React.createElement("span", {
    style: {
      width: 1,
      height: 18,
      background: DS.border,
      margin: '0 6px'
    }
  }), [['H1', 'book-open'], ['Quote', 'quote'], ['List', 'list'], ['Link', 'link'], ['Image', 'image']].map(([l, ic]) => /*#__PURE__*/React.createElement("button", {
    key: l,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 5,
      height: 30,
      padding: '0 9px',
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      borderRadius: 6,
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 500,
      color: DS.fg2
    },
    onMouseEnter: e => e.currentTarget.style.background = '#EFEBE3',
    onMouseLeave: e => e.currentTarget.style.background = 'none'
  }, /*#__PURE__*/React.createElement(Icon, {
    name: ic,
    size: 14,
    stroke: 2
  }), l))), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '18px 20px',
      minHeight: 200,
      fontFamily: DS.fontUI,
      fontSize: 15,
      lineHeight: 1.7,
      color: DS.fg2
    }
  }, isNew ? /*#__PURE__*/React.createElement("span", {
    style: {
      color: DS.fg4
    }
  }, "Start writing your story\u2026 Type ", /*#__PURE__*/React.createElement("b", {
    style: {
      color: accent
    }
  }, "/"), " to insert a block (Quick Answer, Key Facts, FAQ, Sources).") : /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("p", {
    style: {
      margin: '0 0 16px'
    }
  }, "In 27 years of the Ghana Music Awards, the ", /*#__PURE__*/React.createElement("b", null, "Artiste of the Year"), " crown has changed hands more often than not. But a rare few have managed to win it twice \u2014 joining what fans now call ", /*#__PURE__*/React.createElement("i", null, "The Elite Club"), "."), /*#__PURE__*/React.createElement("p", {
    style: {
      margin: 0
    }
  }, "From V.I.P's Hiplife dominance to Black Sherif's Afrobeats-era surge, these four acts span every major shift in Ghanaian popular music\u2026")))), /*#__PURE__*/React.createElement(EditorBlock, {
    icon: "circle-dot",
    title: "Quick Answer",
    desc: "Surfaces in Google & AI answer boxes",
    color: DS.gold
  }, /*#__PURE__*/React.createElement(Field, {
    textarea: true,
    value: quickAnswer,
    onChange: setQuickAnswer,
    rows: 2,
    placeholder: "Write a concise 1\u20132 sentence answer to the core question\u2026",
    counter: true,
    max: 300
  })), /*#__PURE__*/React.createElement(EditorBlock, {
    icon: "list-checks",
    title: "Key Facts",
    desc: "Scannable bullet facts",
    color: DS.green,
    action: /*#__PURE__*/React.createElement(Btn, {
      variant: "soft",
      size: "sm",
      icon: "plus"
    }, "Add fact")
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 8
    }
  }, ['First double winner: V.I.P (2004, 2011)', 'Most recent: Black Sherif (2023, 2026)', 'Only annulled year: 2019', 'Total unique winners: 24'].map((f, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 10,
      padding: '9px 12px',
      background: '#FBF9F5',
      borderRadius: 8,
      border: `1px solid ${DS.border}`
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "grip",
    size: 15,
    color: DS.fg4
  }), /*#__PURE__*/React.createElement(Icon, {
    name: "check",
    size: 15,
    color: DS.green,
    stroke: 2.5
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      flex: 1,
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      color: DS.fg1
    }
  }, f), /*#__PURE__*/React.createElement("button", {
    style: {
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      color: DS.fg4,
      display: 'flex'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "x",
    size: 15
  })))))), /*#__PURE__*/React.createElement(EditorBlock, {
    icon: "circle-help",
    title: "FAQ Builder",
    desc: "Generates FAQPage schema automatically",
    color: DS.blue,
    action: /*#__PURE__*/React.createElement(Btn, {
      variant: "soft",
      size: "sm",
      icon: "plus"
    }, "Add question")
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 10
    }
  }, [['Who has won TGMA Artiste of the Year twice?', 'V.I.P, Sarkodie, Stonebwoy, and Black Sherif.'], ['Why was the 2019 award annulled?', 'The board annulled the category citing voting irregularities.']].map((qa, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      border: `1px solid ${DS.border}`,
      borderRadius: 9,
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 9,
      padding: '10px 12px',
      background: '#FBF9F5'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "grip",
    size: 14,
    color: DS.fg4
  }), /*#__PURE__*/React.createElement(Icon, {
    name: "chevron-down",
    size: 15,
    color: DS.fg3
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      flex: 1,
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1
    }
  }, qa[0]), /*#__PURE__*/React.createElement("button", {
    style: {
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      color: DS.fg4,
      display: 'flex'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "trash",
    size: 14
  }))), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '10px 12px 10px 35px',
      fontFamily: DS.fontUI,
      fontSize: 13,
      color: DS.fg2,
      lineHeight: 1.5
    }
  }, qa[1]))))), /*#__PURE__*/React.createElement(EditorBlock, {
    icon: "book-open",
    title: "Sources & Citations",
    desc: "Builds trust signals for E-E-A-T",
    color: DS.aiTo,
    action: /*#__PURE__*/React.createElement(Btn, {
      variant: "soft",
      size: "sm",
      icon: "plus"
    }, "Add source")
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 8
    }
  }, [['Ghana Music Awards — Official Winners Archive', 'ghanamusicawards.com'], ['Citi Newsroom — TGMA 2026 Recap', 'citinewsroom.com']].map((s, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 11,
      padding: '10px 12px',
      background: '#FBF9F5',
      borderRadius: 8,
      border: `1px solid ${DS.border}`
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontMono,
      fontSize: 12,
      fontWeight: 700,
      color: DS.fg4
    }
  }, "[", i + 1, "]"), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 600,
      color: DS.fg1
    }
  }, s[0]), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontMono,
      fontSize: 11,
      color: DS.blue
    }
  }, s[1])), /*#__PURE__*/React.createElement(Icon, {
    name: "external-link",
    size: 14,
    color: DS.fg4
  })))))), tab === 'seo' && /*#__PURE__*/React.createElement(SeoTab, {
    focusKw,
    setFocusKw,
    seoTitle,
    setSeoTitle,
    metaDesc,
    setMetaDesc,
    intent,
    setIntent,
    schema,
    setSchema,
    slug,
    title,
    seoScore,
    accent
  }), tab === 'ai' && /*#__PURE__*/React.createElement(AiTab, {
    quickAnswer,
    title,
    accent
  })), /*#__PURE__*/React.createElement("aside", {
    className: "cms-editor-rail",
    style: {
      borderLeft: `1px solid ${DS.border}`,
      background: DS.surface,
      position: 'sticky',
      top: 129,
      alignSelf: 'stretch',
      minHeight: 'calc(100vh - 129px)'
    }
  }, /*#__PURE__*/React.createElement(RailSection, {
    title: "Publish"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 10
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      color: DS.fg3
    }
  }, "Status"), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement(Badge, {
    tone: status
  }, status === 'review' ? 'In Review' : status))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      color: DS.fg3
    }
  }, "Visibility"), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 600,
      color: DS.fg1
    }
  }, "Public")), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      color: DS.fg3
    }
  }, "Publish date"), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 600,
      color: DS.fg1
    }
  }, post?.date && post.date !== 'Draft' ? post.date : 'Immediately')), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 0,
      marginTop: 6
    }
  }, ['Draft', 'Review', 'Schedule', 'Publish'].map((st, i) => {
    const order = ['draft', 'review', 'scheduled', 'published'];
    const cur = order.indexOf(status);
    const done = i <= cur;
    return /*#__PURE__*/React.createElement(React.Fragment, {
      key: st
    }, /*#__PURE__*/React.createElement("div", {
      style: {
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'center',
        gap: 4
      }
    }, /*#__PURE__*/React.createElement("div", {
      style: {
        width: 22,
        height: 22,
        borderRadius: 999,
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        background: done ? DS.green : '#EFEBE3',
        color: done ? '#fff' : DS.fg4,
        fontFamily: DS.fontUI,
        fontSize: 10,
        fontWeight: 700
      }
    }, done ? /*#__PURE__*/React.createElement(Icon, {
      name: "check",
      size: 12,
      stroke: 3
    }) : i + 1), /*#__PURE__*/React.createElement("span", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 9.5,
        color: done ? DS.fg2 : DS.fg4,
        fontWeight: 600
      }
    }, st)), i < 3 && /*#__PURE__*/React.createElement("div", {
      style: {
        flex: 1,
        height: 2,
        background: i < cur ? DS.green : DS.border,
        marginBottom: 16
      }
    }));
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 8,
      marginTop: 4
    }
  }, /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    full: true,
    onClick: () => setStatus('review')
  }, "Submit review"), /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    size: "sm",
    full: true,
    icon: "send",
    onClick: () => setStatus('published')
  }, "Publish")))), /*#__PURE__*/React.createElement(RailSection, {
    title: "SEO Health",
    action: /*#__PURE__*/React.createElement("span", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 11.5,
        fontWeight: 600,
        color: accent,
        cursor: 'pointer'
      },
      onClick: () => setTab('seo')
    }, "Open SEO")
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 14
    }
  }, /*#__PURE__*/React.createElement(ScoreRing, {
    score: seoScore,
    size: 52,
    stroke: 5
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 600,
      color: DS.fg1
    }
  }, seoScore >= 80 ? 'Great' : seoScore >= 50 ? 'Needs work' : 'Poor'), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11.5,
      color: DS.fg3,
      marginTop: 2
    }
  }, "3 of 8 checks need attention")))), /*#__PURE__*/React.createElement(RailSection, {
    title: "Featured Image"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      borderRadius: DS.rMd,
      overflow: 'hidden',
      border: `1px solid ${DS.border}`
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      aspectRatio: '16/9',
      background: post?.grad || 'linear-gradient(135deg,#1A1410,#4D3000)',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "image",
    size: 26,
    color: "rgba(255,255,255,0.55)"
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      inset: 0,
      display: 'flex',
      alignItems: 'flex-end',
      padding: 8,
      opacity: 0,
      transition: 'opacity 160ms'
    },
    onMouseEnter: e => e.currentTarget.style.opacity = 1,
    onMouseLeave: e => e.currentTarget.style.opacity = 0
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 6,
      padding: 8
    }
  }, /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    icon: "upload",
    full: true
  }, "Replace")))), /*#__PURE__*/React.createElement(RailSection, {
    title: "Category"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement("button", {
    onClick: () => setCatOpen(o => !o),
    style: {
      width: '100%',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      padding: '9px 12px',
      border: `1.5px solid ${DS.border}`,
      borderRadius: DS.rMd,
      background: DS.surface,
      cursor: 'pointer',
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 500,
      color: DS.fg1
    }
  }, category, /*#__PURE__*/React.createElement(Icon, {
    name: "chevron-down",
    size: 15,
    color: DS.fg4
  })), catOpen && /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      top: 42,
      left: 0,
      right: 0,
      background: DS.surface,
      borderRadius: DS.rMd,
      boxShadow: DS.shPop,
      border: `1px solid ${DS.border}`,
      zIndex: 50,
      padding: 5,
      animation: 'dsPop 150ms ease'
    }
  }, cats.map(c => /*#__PURE__*/React.createElement("button", {
    key: c,
    onClick: () => {
      setCategory(c);
      setCatOpen(false);
    },
    style: {
      display: 'block',
      width: '100%',
      textAlign: 'left',
      padding: '8px 10px',
      border: 'none',
      background: category === c ? DS.goldSoft : 'transparent',
      borderRadius: 6,
      cursor: 'pointer',
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: category === c ? 600 : 500,
      color: DS.fg1
    }
  }, c))))), /*#__PURE__*/React.createElement(RailSection, {
    title: "Tags"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexWrap: 'wrap',
      gap: 6,
      marginBottom: 10
    }
  }, tags.map(t => /*#__PURE__*/React.createElement("span", {
    key: t,
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 5,
      background: '#EFEBE3',
      color: DS.fg2,
      fontFamily: DS.fontUI,
      fontSize: 12,
      fontWeight: 500,
      padding: '4px 8px 4px 10px',
      borderRadius: 999
    }
  }, t, /*#__PURE__*/React.createElement("button", {
    onClick: () => setTags(tags.filter(x => x !== t)),
    style: {
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      color: DS.fg4,
      display: 'flex',
      padding: 0
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "x",
    size: 12,
    stroke: 2.5
  }))))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 6,
      border: `1.5px solid ${DS.border}`,
      borderRadius: DS.rMd,
      padding: '0 10px',
      height: 36
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "tag",
    size: 14,
    color: DS.fg4
  }), /*#__PURE__*/React.createElement("input", {
    value: tagInput,
    onChange: e => setTagInput(e.target.value),
    onKeyDown: e => e.key === 'Enter' && addTag(),
    placeholder: "Add tag + Enter",
    style: {
      flex: 1,
      border: 'none',
      outline: 'none',
      background: 'none',
      fontFamily: DS.fontUI,
      fontSize: 13,
      color: DS.fg1,
      minWidth: 0
    }
  }))), /*#__PURE__*/React.createElement(RailSection, {
    title: "Related Posts",
    action: /*#__PURE__*/React.createElement(Btn, {
      variant: "soft",
      size: "sm",
      icon: "plus"
    }, "Add")
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 8
    }
  }, POSTS.slice(1, 3).map(p => /*#__PURE__*/React.createElement("div", {
    key: p.id,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 9
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 36,
      height: 28,
      borderRadius: 6,
      background: p.grad,
      flexShrink: 0
    }
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      flex: 1,
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg2,
      lineHeight: 1.3,
      display: '-webkit-box',
      WebkitLineClamp: 2,
      WebkitBoxOrient: 'vertical',
      overflow: 'hidden'
    }
  }, p.title))))), /*#__PURE__*/React.createElement(RailSection, {
    title: "Internal Link Suggestions"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 8
    }
  }, [['Sarkodie', 'sarkodie-stonebwoy-stats'], ['Hiplife era', 'hiplife-era-tgma-winners']].map((s, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 9,
      padding: '8px 10px',
      background: DS.blueSoft,
      borderRadius: 8
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "link",
    size: 14,
    color: DS.blue
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      flex: 1,
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg2
    }
  }, "Link ", /*#__PURE__*/React.createElement("b", null, "\"", s[0], "\"")), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    style: {
      height: 26,
      padding: '0 10px',
      fontSize: 11.5
    }
  }, "Add"))))))), /*#__PURE__*/React.createElement(Modal, {
    open: showSchedule,
    onClose: () => setShowSchedule(false),
    title: "Schedule Post",
    width: 420,
    footer: /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement(Btn, {
      variant: "soft",
      onClick: () => setShowSchedule(false)
    }, "Cancel"), /*#__PURE__*/React.createElement(Btn, {
      variant: "primary",
      icon: "clock",
      onClick: () => {
        setStatus('scheduled');
        setShowSchedule(false);
      }
    }, "Schedule"))
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 16
    }
  }, /*#__PURE__*/React.createElement(Field, {
    label: "Publish date",
    value: "June 12, 2026"
  }), /*#__PURE__*/React.createElement(Field, {
    label: "Time (GMT)",
    value: "08:00 AM"
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 10,
      padding: '12px 14px',
      background: DS.blueSoft,
      borderRadius: DS.rMd
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "globe",
    size: 16,
    color: DS.blue
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg2
    }
  }, "Will auto-publish & ping Google for indexing.")))), /*#__PURE__*/React.createElement(Modal, {
    open: showRevisions,
    onClose: () => setShowRevisions(false),
    title: "Revision History",
    width: 540,
    footer: /*#__PURE__*/React.createElement(Btn, {
      variant: "soft",
      onClick: () => setShowRevisions(false)
    }, "Close")
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      left: 15,
      top: 6,
      bottom: 6,
      width: 2,
      background: DS.border
    }
  }), REVISIONS.map((r, i) => /*#__PURE__*/React.createElement("div", {
    key: r.id,
    style: {
      display: 'flex',
      gap: 14,
      paddingBottom: i < REVISIONS.length - 1 ? 18 : 0,
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 32,
      height: 32,
      borderRadius: 999,
      flexShrink: 0,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      zIndex: 1,
      background: r.current ? DS.gold : DS.surface,
      border: `2px solid ${r.current ? DS.gold : DS.borderSt}`,
      color: r.current ? '#1A1410' : DS.fg4
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: r.current ? 'circle-dot' : 'circle',
    size: 14,
    stroke: 2
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0,
      paddingTop: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8,
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1
    }
  }, r.label), r.current && /*#__PURE__*/React.createElement(Badge, {
    tone: "published",
    dot: false
  }, "Current")), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8,
      marginTop: 4
    }
  }, /*#__PURE__*/React.createElement(Avatar, {
    name: r.author,
    size: 20
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg3
    }
  }, r.author, " \xB7 ", r.time)), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 12,
      marginTop: 8
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontMono,
      fontSize: 11,
      color: DS.fg4
    }
  }, r.words.toLocaleString(), " words"), r.change !== '+0' && /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontMono,
      fontSize: 11,
      fontWeight: 700,
      color: DS.green
    }
  }, r.change, " words"), !r.current && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 6,
      marginLeft: 'auto'
    }
  }, /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    style: {
      height: 28,
      padding: '0 11px',
      fontSize: 11.5
    }
  }, "Compare"), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    icon: "refresh",
    style: {
      height: 28,
      padding: '0 11px',
      fontSize: 11.5
    }
  }, "Restore")))))))));
}

/* ── SEO TAB ───────────────────────────────────────────── */
function SeoTab({
  focusKw,
  setFocusKw,
  seoTitle,
  setSeoTitle,
  metaDesc,
  setMetaDesc,
  intent,
  setIntent,
  schema,
  setSchema,
  slug,
  title,
  seoScore,
  accent
}) {
  const checks = [{
    label: 'Focus keyword in title',
    pass: true
  }, {
    label: 'Focus keyword in first paragraph',
    pass: true
  }, {
    label: 'Meta description 120–160 chars',
    pass: metaDesc.length >= 120 && metaDesc.length <= 160
  }, {
    label: 'SEO title under 60 chars',
    pass: seoTitle.length > 0 && seoTitle.length <= 60
  }, {
    label: 'At least 3 internal links',
    pass: false
  }, {
    label: 'Image alt text set',
    pass: false
  }, {
    label: 'FAQ schema present',
    pass: true
  }, {
    label: 'Slug is concise',
    pass: slug.length <= 60
  }];
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 22
    }
  }, /*#__PURE__*/React.createElement(EditorBlock, {
    icon: "gauge",
    title: "Focus Keyword & Intent",
    color: DS.green
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 14
    }
  }, /*#__PURE__*/React.createElement(Field, {
    label: "Focus keyword",
    value: focusKw,
    onChange: setFocusKw,
    placeholder: "e.g. artiste of the year winners",
    prefix: "\uD83D\uDD0D"
  }), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("label", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 600,
      color: DS.fg2,
      display: 'block',
      marginBottom: 8
    }
  }, "Search intent"), /*#__PURE__*/React.createElement(SegTabs, {
    tabs: ['Informational', 'Navigational', 'Commercial', 'Transactional'],
    active: intent,
    onChange: setIntent,
    size: "sm"
  })))), /*#__PURE__*/React.createElement(EditorBlock, {
    icon: "search-check",
    title: "Search Appearance",
    color: DS.blue
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 14
    }
  }, /*#__PURE__*/React.createElement(Field, {
    label: "SEO title",
    value: seoTitle,
    onChange: setSeoTitle,
    counter: true,
    max: 60,
    hint: "Appears as the clickable headline in Google results."
  }), /*#__PURE__*/React.createElement(Field, {
    label: "Meta description",
    value: metaDesc,
    onChange: setMetaDesc,
    textarea: true,
    rows: 3,
    counter: true,
    max: 160
  }), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11.5,
      fontWeight: 700,
      letterSpacing: '0.05em',
      textTransform: 'uppercase',
      color: DS.fg4,
      marginBottom: 8
    }
  }, "Google Preview"), /*#__PURE__*/React.createElement("div", {
    style: {
      border: `1px solid ${DS.border}`,
      borderRadius: DS.rMd,
      padding: '14px 16px',
      background: '#fff'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8,
      marginBottom: 7
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 26,
      height: 26,
      borderRadius: 999,
      background: `linear-gradient(125deg,${DS.aiFrom},${DS.aiTo})`,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      fontFamily: DS.fontUI,
      fontWeight: 800,
      fontSize: 13,
      color: '#fff'
    }
  }, "d"), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'arial, sans-serif',
      fontSize: 13,
      color: '#202124'
    }
  }, "Debesties"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'arial, sans-serif',
      fontSize: 12,
      color: '#5f6368'
    }
  }, "https://debesties.com \u203A ", slug || 'post-slug'))), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'arial, sans-serif',
      fontSize: 19,
      color: '#1a0dab',
      lineHeight: 1.3,
      marginBottom: 3
    }
  }, seoTitle || title || 'Your SEO title appears here'), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'arial, sans-serif',
      fontSize: 13.5,
      color: '#4d5156',
      lineHeight: 1.5
    }
  }, metaDesc || 'Your meta description preview will appear here as searchers would see it on Google.'))))), /*#__PURE__*/React.createElement(EditorBlock, {
    icon: "database",
    title: "Schema & Structured Data",
    color: DS.aiTo
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexWrap: 'wrap',
      gap: 8
    }
  }, ['Article', 'NewsArticle', 'FAQPage', 'Review', 'Person', 'MusicEvent'].map(s => /*#__PURE__*/React.createElement("button", {
    key: s,
    onClick: () => setSchema(s),
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 600,
      padding: '7px 14px',
      borderRadius: 999,
      cursor: 'pointer',
      border: `1.5px solid ${schema === s ? DS.aiTo : DS.border}`,
      background: schema === s ? DS.aiSoft : DS.surface,
      color: schema === s ? '#6B3FC0' : DS.fg2
    }
  }, s)))), /*#__PURE__*/React.createElement(EditorBlock, {
    icon: "list-checks",
    title: "SEO Checklist",
    color: DS.gold,
    action: /*#__PURE__*/React.createElement(ScoreRing, {
      score: seoScore,
      size: 38,
      stroke: 4
    })
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 4
    }
  }, checks.map((c, i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 10,
      padding: '8px 4px'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 20,
      height: 20,
      borderRadius: 999,
      flexShrink: 0,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      background: c.pass ? DS.greenSoft : DS.redSoft,
      color: c.pass ? DS.green : DS.red
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: c.pass ? 'check' : 'x',
    size: 12,
    stroke: 3
  })), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      color: c.pass ? DS.fg2 : DS.fg1,
      fontWeight: c.pass ? 400 : 600
    }
  }, c.label), !c.pass && /*#__PURE__*/React.createElement("span", {
    style: {
      marginLeft: 'auto',
      fontFamily: DS.fontUI,
      fontSize: 11.5,
      fontWeight: 600,
      color: accent,
      cursor: 'pointer'
    }
  }, "Fix"))))));
}

/* ── AI VISIBILITY TAB ─────────────────────────────────── */
function AiTab({
  quickAnswer,
  title,
  accent
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 22
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      borderRadius: DS.rLg,
      padding: '20px 22px',
      background: `linear-gradient(120deg, ${DS.aiFrom}12, ${DS.aiTo}18)`,
      border: `1px solid ${DS.aiTo}33`,
      display: 'flex',
      alignItems: 'center',
      gap: 16
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 44,
      height: 44,
      borderRadius: DS.rMd,
      background: `linear-gradient(125deg,${DS.aiFrom},${DS.aiTo})`,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      flexShrink: 0,
      boxShadow: '0 4px 14px rgba(120,79,224,0.3)'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "sparkles",
    size: 22,
    color: "#fff",
    stroke: 2
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "AI Answer Optimization"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg3,
      marginTop: 2
    }
  }, "Optimize how this post appears in ChatGPT, Gemini, Perplexity & Google AI Overviews.")), /*#__PURE__*/React.createElement("div", {
    style: {
      textAlign: 'center'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 24,
      fontWeight: 700,
      color: '#6B3FC0',
      lineHeight: 1
    }
  }, "72"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 10.5,
      color: DS.fg4,
      marginTop: 2
    }
  }, "AI score"))), /*#__PURE__*/React.createElement(EditorBlock, {
    icon: "sparkles",
    title: "AI Answer Preview",
    desc: "How an assistant would cite this article",
    color: DS.aiTo
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      background: '#FBF9F5',
      borderRadius: DS.rMd,
      padding: '16px 18px',
      border: `1px solid ${DS.border}`
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8,
      marginBottom: 12
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 22,
      height: 22,
      borderRadius: 999,
      background: `linear-gradient(125deg,${DS.aiFrom},${DS.aiTo})`,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "sparkles",
    size: 12,
    color: "#fff"
  })), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      fontWeight: 600,
      color: DS.fg3
    }
  }, "Assistant response")), /*#__PURE__*/React.createElement("p", {
    style: {
      margin: 0,
      fontFamily: DS.fontUI,
      fontSize: 14,
      color: DS.fg1,
      lineHeight: 1.65
    }
  }, quickAnswer || 'Four artists have won the TGMA Artiste of the Year award twice.', " ", /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 3,
      background: DS.aiSoft,
      color: '#6B3FC0',
      fontFamily: DS.fontUI,
      fontSize: 11,
      fontWeight: 600,
      padding: '1px 7px',
      borderRadius: 999,
      verticalAlign: 'middle'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "book-open",
    size: 10
  }), "debesties.com")))), /*#__PURE__*/React.createElement(EditorBlock, {
    icon: "globe",
    title: "Entity Summary",
    desc: "Key entities AI models extract from this post",
    color: DS.blue
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexWrap: 'wrap',
      gap: 8
    }
  }, [['V.I.P', 'Music Group'], ['Sarkodie', 'Person'], ['Stonebwoy', 'Person'], ['Black Sherif', 'Person'], ['Ghana Music Awards', 'Event'], ['Artiste of the Year', 'Award']].map(([e, t], i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 7,
      padding: '6px 12px',
      background: '#FBF9F5',
      border: `1px solid ${DS.border}`,
      borderRadius: 999
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 7,
      height: 7,
      borderRadius: 999,
      background: DS.blue
    }
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 600,
      color: DS.fg1
    }
  }, e), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11,
      color: DS.fg4
    }
  }, t))))), /*#__PURE__*/React.createElement(EditorBlock, {
    icon: "list-checks",
    title: "Direct Answer Optimization",
    color: DS.green
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 4
    }
  }, [['Quick Answer block present', true], ['Question-style H2 headings', true], ['Concise definitions (under 50 words)', true], ['Structured lists & tables', false], ['Sources cited inline', true]].map(([l, pass], i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 10,
      padding: '8px 4px'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 20,
      height: 20,
      borderRadius: 999,
      flexShrink: 0,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      background: pass ? DS.greenSoft : DS.redSoft,
      color: pass ? DS.green : DS.red
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: pass ? 'check' : 'x',
    size: 12,
    stroke: 3
  })), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      color: DS.fg2
    }
  }, l), !pass && /*#__PURE__*/React.createElement("span", {
    style: {
      marginLeft: 'auto',
      fontFamily: DS.fontUI,
      fontSize: 11.5,
      fontWeight: 600,
      color: accent,
      cursor: 'pointer'
    }
  }, "Fix"))))));
}
Object.assign(window, {
  PostEditor
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties-cms/PostEditor.jsx", error: String((e && e.message) || e) }); }

// ui_kits/debesties-cms/PostsList.jsx
try { (() => {
// Debesties CMS — Posts List View
// Exports to window: PostsList

function PostsList({
  onNavigate,
  onEditPost,
  onNewPost,
  accent
}) {
  const [search, setSearch] = React.useState('');
  const [statusFilter, setStatusFilter] = React.useState('all');
  const [selected, setSelected] = React.useState([]);
  const [menuOpen, setMenuOpen] = React.useState(null);
  const [catFilter, setCatFilter] = React.useState('All categories');
  const [catOpen, setCatOpen] = React.useState(false);
  const counts = {
    all: POSTS.length,
    published: POSTS.filter(p => p.status === 'published').length,
    draft: POSTS.filter(p => p.status === 'draft').length,
    review: POSTS.filter(p => p.status === 'review').length,
    scheduled: POSTS.filter(p => p.status === 'scheduled').length
  };
  const filtered = POSTS.filter(p => {
    if (statusFilter !== 'all' && p.status !== statusFilter) return false;
    if (catFilter !== 'All categories' && p.category !== catFilter) return false;
    if (search && !p.title.toLowerCase().includes(search.toLowerCase()) && !p.author.toLowerCase().includes(search.toLowerCase())) return false;
    return true;
  });
  const allSel = filtered.length > 0 && filtered.every(p => selected.includes(p.id));
  const toggleAll = () => setSelected(allSel ? [] : filtered.map(p => p.id));
  const toggleOne = id => setSelected(s => s.includes(id) ? s.filter(x => x !== id) : [...s, id]);
  const cats = ['All categories', ...Array.from(new Set(POSTS.map(p => p.category)))];
  const Check = ({
    on,
    onClick
  }) => /*#__PURE__*/React.createElement("button", {
    onClick: onClick,
    style: {
      width: 18,
      height: 18,
      borderRadius: 5,
      flexShrink: 0,
      cursor: 'pointer',
      border: `1.5px solid ${on ? DS.gold : DS.borderSt}`,
      background: on ? DS.gold : DS.surface,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      padding: 0,
      transition: 'all 120ms'
    }
  }, on && /*#__PURE__*/React.createElement(Icon, {
    name: "check",
    size: 12,
    color: "#1A1410",
    stroke: 3
  }));
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 16
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: 14,
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement(SegTabs, {
    tabs: [{
      value: 'all',
      label: 'All',
      count: counts.all
    }, {
      value: 'published',
      label: 'Published',
      count: counts.published
    }, {
      value: 'draft',
      label: 'Drafts',
      count: counts.draft
    }, {
      value: 'review',
      label: 'In Review',
      count: counts.review
    }, {
      value: 'scheduled',
      label: 'Scheduled',
      count: counts.scheduled
    }],
    active: statusFilter,
    onChange: setStatusFilter
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 10,
      alignItems: 'center',
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement(SearchInput, {
    value: search,
    onChange: setSearch,
    placeholder: "Search title or author\u2026",
    width: 240
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    icon: "filter",
    iconRight: "chevron-down",
    onClick: () => setCatOpen(o => !o)
  }, catFilter === 'All categories' ? 'Category' : catFilter), catOpen && /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      top: 44,
      right: 0,
      width: 200,
      background: DS.surface,
      borderRadius: DS.rMd,
      boxShadow: DS.shPop,
      border: `1px solid ${DS.border}`,
      zIndex: 50,
      padding: 6,
      animation: 'dsPop 160ms ease'
    }
  }, cats.map(c => /*#__PURE__*/React.createElement("button", {
    key: c,
    onClick: () => {
      setCatFilter(c);
      setCatOpen(false);
    },
    style: {
      display: 'block',
      width: '100%',
      textAlign: 'left',
      padding: '8px 10px',
      border: 'none',
      background: catFilter === c ? DS.goldSoft : 'transparent',
      borderRadius: 6,
      cursor: 'pointer',
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: catFilter === c ? 600 : 500,
      color: DS.fg1
    },
    onMouseEnter: e => {
      if (catFilter !== c) e.currentTarget.style.background = '#FBF9F5';
    },
    onMouseLeave: e => {
      if (catFilter !== c) e.currentTarget.style.background = 'transparent';
    }
  }, c)))), /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    icon: "plus",
    onClick: onNewPost
  }, "New Post"))), selected.length > 0 && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      padding: '10px 16px',
      background: DS.fg1,
      borderRadius: DS.rMd,
      animation: 'dsFade 160ms ease'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 600,
      color: '#fff'
    }
  }, selected.length, " selected"), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(Btn, {
    variant: "ghost",
    size: "sm",
    icon: "check",
    style: {
      color: '#fff',
      borderColor: 'rgba(255,255,255,0.25)'
    }
  }, "Publish"), /*#__PURE__*/React.createElement(Btn, {
    variant: "ghost",
    size: "sm",
    icon: "tag",
    style: {
      color: '#fff',
      borderColor: 'rgba(255,255,255,0.25)'
    }
  }, "Add tag"), /*#__PURE__*/React.createElement(Btn, {
    variant: "ghost",
    size: "sm",
    icon: "trash",
    style: {
      color: '#fff',
      borderColor: 'rgba(255,255,255,0.25)'
    }
  }, "Delete"), /*#__PURE__*/React.createElement(Btn, {
    variant: "ghost",
    size: "sm",
    onClick: () => setSelected([]),
    style: {
      color: 'rgba(255,255,255,0.6)',
      borderColor: 'transparent'
    }
  }, "Clear"))), /*#__PURE__*/React.createElement(Card, {
    pad: 0,
    style: {
      overflow: 'visible'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      overflowX: 'auto'
    }
  }, /*#__PURE__*/React.createElement("table", {
    style: {
      width: '100%',
      borderCollapse: 'collapse',
      minWidth: 880
    }
  }, /*#__PURE__*/React.createElement("thead", null, /*#__PURE__*/React.createElement("tr", {
    style: {
      borderBottom: `1px solid ${DS.border}`,
      background: '#FBF9F5'
    }
  }, /*#__PURE__*/React.createElement("th", {
    style: {
      padding: '12px 16px',
      width: 40
    }
  }, /*#__PURE__*/React.createElement(Check, {
    on: allSel,
    onClick: toggleAll
  })), ['Article', 'Status', 'Author', 'Category', 'SEO', 'Views', 'Updated', ''].map((h, i) => /*#__PURE__*/React.createElement("th", {
    key: i,
    style: {
      padding: '12px 14px',
      textAlign: i >= 4 && i <= 5 ? 'right' : 'left',
      fontFamily: DS.fontUI,
      fontSize: 11,
      fontWeight: 700,
      letterSpacing: '0.06em',
      textTransform: 'uppercase',
      color: DS.fg4,
      whiteSpace: 'nowrap'
    }
  }, h)))), /*#__PURE__*/React.createElement("tbody", null, filtered.map(p => {
    const sel = selected.includes(p.id);
    return /*#__PURE__*/React.createElement("tr", {
      key: p.id,
      style: {
        borderBottom: `1px solid ${DS.border}`,
        background: sel ? DS.goldSoft + '88' : 'transparent',
        transition: 'background 120ms'
      },
      onMouseEnter: e => {
        if (!sel) e.currentTarget.style.background = '#FBF9F5';
      },
      onMouseLeave: e => {
        if (!sel) e.currentTarget.style.background = 'transparent';
      }
    }, /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 16px'
      }
    }, /*#__PURE__*/React.createElement(Check, {
      on: sel,
      onClick: () => toggleOne(p.id)
    })), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px'
      }
    }, /*#__PURE__*/React.createElement("div", {
      style: {
        display: 'flex',
        alignItems: 'center',
        gap: 12,
        cursor: 'pointer',
        maxWidth: 360
      },
      onClick: () => onEditPost(p)
    }, /*#__PURE__*/React.createElement("div", {
      style: {
        width: 52,
        height: 38,
        borderRadius: 7,
        background: p.grad,
        flexShrink: 0,
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        position: 'relative'
      }
    }, p.featured && /*#__PURE__*/React.createElement("span", {
      style: {
        position: 'absolute',
        top: -5,
        right: -5,
        width: 18,
        height: 18,
        borderRadius: 999,
        background: DS.gold,
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center'
      }
    }, /*#__PURE__*/React.createElement(Icon, {
      name: "star",
      size: 10,
      color: "#1A1410",
      fill: "#1A1410"
    })), /*#__PURE__*/React.createElement(Icon, {
      name: "image",
      size: 15,
      color: "rgba(255,255,255,0.5)"
    })), /*#__PURE__*/React.createElement("div", {
      style: {
        minWidth: 0
      }
    }, /*#__PURE__*/React.createElement("div", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 13.5,
        fontWeight: 600,
        color: DS.fg1,
        lineHeight: 1.3,
        overflow: 'hidden',
        textOverflow: 'ellipsis',
        display: '-webkit-box',
        WebkitLineClamp: 1,
        WebkitBoxOrient: 'vertical'
      }
    }, p.title), /*#__PURE__*/React.createElement("div", {
      style: {
        fontFamily: DS.fontMono,
        fontSize: 11,
        color: DS.fg4,
        marginTop: 2,
        whiteSpace: 'nowrap',
        overflow: 'hidden',
        textOverflow: 'ellipsis'
      }
    }, "/", p.slug)))), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px'
      }
    }, /*#__PURE__*/React.createElement(Badge, {
      tone: p.status
    }, p.status === 'review' ? 'In Review' : p.status)), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px'
      }
    }, /*#__PURE__*/React.createElement("div", {
      style: {
        display: 'flex',
        alignItems: 'center',
        gap: 8
      }
    }, /*#__PURE__*/React.createElement(Avatar, {
      name: p.author,
      size: 26
    }), /*#__PURE__*/React.createElement("span", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 12.5,
        color: DS.fg2,
        whiteSpace: 'nowrap'
      }
    }, p.author))), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px'
      }
    }, /*#__PURE__*/React.createElement("span", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 12.5,
        color: DS.fg2,
        whiteSpace: 'nowrap'
      }
    }, p.category)), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px'
      }
    }, /*#__PURE__*/React.createElement("div", {
      style: {
        display: 'flex',
        justifyContent: 'flex-end'
      }
    }, /*#__PURE__*/React.createElement(ScoreRing, {
      score: p.seo,
      size: 34,
      stroke: 3.5,
      label: `SEO score ${p.seo}`
    }))), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px',
        textAlign: 'right',
        fontFamily: DS.fontUI,
        fontSize: 13,
        fontWeight: 600,
        color: p.views ? DS.fg1 : DS.fg4,
        whiteSpace: 'nowrap'
      }
    }, p.views ? p.views >= 1000 ? (p.views / 1000).toFixed(1) + 'K' : p.views : '—'), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px',
        fontFamily: DS.fontUI,
        fontSize: 12,
        color: DS.fg3,
        whiteSpace: 'nowrap'
      }
    }, p.updated), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px',
        position: 'relative'
      }
    }, /*#__PURE__*/React.createElement("button", {
      onClick: () => setMenuOpen(menuOpen === p.id ? null : p.id),
      style: {
        border: 'none',
        background: 'none',
        cursor: 'pointer',
        color: DS.fg3,
        padding: 5,
        borderRadius: 6,
        display: 'flex'
      },
      onMouseEnter: e => e.currentTarget.style.background = '#EFEBE3',
      onMouseLeave: e => e.currentTarget.style.background = 'transparent'
    }, /*#__PURE__*/React.createElement(Icon, {
      name: "more-horizontal",
      size: 18
    })), menuOpen === p.id && /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
      onClick: () => setMenuOpen(null),
      style: {
        position: 'fixed',
        inset: 0,
        zIndex: 40
      }
    }), /*#__PURE__*/React.createElement("div", {
      style: {
        position: 'absolute',
        top: 36,
        right: 14,
        width: 168,
        background: DS.surface,
        borderRadius: DS.rMd,
        boxShadow: DS.shPop,
        border: `1px solid ${DS.border}`,
        zIndex: 50,
        padding: 5,
        animation: 'dsPop 150ms ease'
      }
    }, [{
      l: 'Edit',
      i: 'edit',
      a: () => onEditPost(p)
    }, {
      l: 'View live',
      i: 'external-link'
    }, {
      l: 'Duplicate',
      i: 'copy'
    }, {
      l: 'Delete',
      i: 'trash',
      danger: true
    }].map(m => /*#__PURE__*/React.createElement("button", {
      key: m.l,
      onClick: () => {
        m.a && m.a();
        setMenuOpen(null);
      },
      style: {
        display: 'flex',
        alignItems: 'center',
        gap: 9,
        width: '100%',
        textAlign: 'left',
        padding: '8px 10px',
        border: 'none',
        background: 'transparent',
        borderRadius: 6,
        cursor: 'pointer',
        fontFamily: DS.fontUI,
        fontSize: 13,
        fontWeight: 500,
        color: m.danger ? DS.red : DS.fg1
      },
      onMouseEnter: e => e.currentTarget.style.background = m.danger ? DS.redSoft : '#FBF9F5',
      onMouseLeave: e => e.currentTarget.style.background = 'transparent'
    }, /*#__PURE__*/React.createElement(Icon, {
      name: m.i,
      size: 15,
      stroke: 2
    }), m.l))))));
  })))), filtered.length === 0 && /*#__PURE__*/React.createElement(EmptyState, {
    icon: "search",
    title: "No posts found",
    body: "Try adjusting your search or filters to find what you're looking for.",
    action: /*#__PURE__*/React.createElement(Btn, {
      variant: "soft",
      onClick: () => {
        setSearch('');
        setStatusFilter('all');
        setCatFilter('All categories');
      }
    }, "Clear filters")
  }), filtered.length > 0 && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      padding: '14px 20px',
      borderTop: `1px solid ${DS.border}`
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg3
    }
  }, "Showing ", /*#__PURE__*/React.createElement("b", {
    style: {
      color: DS.fg1
    }
  }, filtered.length), " of ", POSTS.length, " posts"), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 6
    }
  }, /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    icon: "chevron-left",
    disabled: true
  }, "Prev"), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    iconRight: "chevron-right"
  }, "Next")))));
}
Object.assign(window, {
  PostsList
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties-cms/PostsList.jsx", error: String((e && e.message) || e) }); }

// ui_kits/debesties-cms/Subscribers.jsx
try { (() => {
// Debesties CMS — Subscribers / Newsletter View
// Exports to window: Subscribers

function Subscribers({
  accent
}) {
  const [tab, setTab] = React.useState('subscribers');
  const [search, setSearch] = React.useState('');
  const [statusFilter, setStatusFilter] = React.useState('all');
  const [sel, setSel] = React.useState([]);
  const statusTone = {
    active: 'published',
    pending: 'review',
    unsubscribed: 'archived',
    bounced: 'decay'
  };
  const counts = {
    all: SUBSCRIBERS.length,
    active: SUBSCRIBERS.filter(s => s.status === 'active').length,
    pending: SUBSCRIBERS.filter(s => s.status === 'pending').length,
    unsubscribed: SUBSCRIBERS.filter(s => s.status === 'unsubscribed').length
  };
  const filtered = SUBSCRIBERS.filter(s => {
    if (statusFilter !== 'all' && s.status !== statusFilter) return false;
    if (search && !s.email.toLowerCase().includes(search.toLowerCase()) && !s.name.toLowerCase().includes(search.toLowerCase())) return false;
    return true;
  });
  const allSel = filtered.length > 0 && filtered.every(s => sel.includes(s.id));
  const toggleAll = () => setSel(allSel ? [] : filtered.map(s => s.id));
  const toggleOne = id => setSel(s => s.includes(id) ? s.filter(x => x !== id) : [...s, id]);
  const Check = ({
    on,
    onClick
  }) => /*#__PURE__*/React.createElement("button", {
    onClick: onClick,
    style: {
      width: 18,
      height: 18,
      borderRadius: 5,
      flexShrink: 0,
      cursor: 'pointer',
      border: `1.5px solid ${on ? DS.gold : DS.borderSt}`,
      background: on ? DS.gold : DS.surface,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      padding: 0,
      transition: 'all 120ms'
    }
  }, on && /*#__PURE__*/React.createElement(Icon, {
    name: "check",
    size: 12,
    color: "#1A1410",
    stroke: 3
  }));
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 18
    }
  }, /*#__PURE__*/React.createElement("div", {
    className: "cms-stat-grid",
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(4,1fr)',
      gap: 14
    }
  }, /*#__PURE__*/React.createElement(StatCard, {
    label: "Total Subscribers",
    value: "12,840",
    delta: "+412",
    deltaDir: "up",
    icon: "users",
    tone: "gold"
  }), /*#__PURE__*/React.createElement(StatCard, {
    label: "Avg. Open Rate",
    value: "57%",
    delta: "+3%",
    deltaDir: "up",
    icon: "eye",
    tone: "green"
  }), /*#__PURE__*/React.createElement(StatCard, {
    label: "Avg. Click Rate",
    value: "24%",
    delta: "+2%",
    deltaDir: "up",
    icon: "trending-up",
    tone: "blue"
  }), /*#__PURE__*/React.createElement(StatCard, {
    label: "Growth (30d)",
    value: "+8.4%",
    delta: "+1.2%",
    deltaDir: "up",
    icon: "send",
    tone: "ai"
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: 14,
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement(SegTabs, {
    tabs: [{
      value: 'subscribers',
      label: 'Subscribers',
      icon: 'users'
    }, {
      value: 'campaigns',
      label: 'Campaigns',
      icon: 'send'
    }],
    active: tab,
    onChange: setTab
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 10,
      alignItems: 'center'
    }
  }, tab === 'subscribers' ? /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    icon: "upload"
  }, "Import"), /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    icon: "plus"
  }, "Add subscriber")) : /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    icon: "send"
  }, "New campaign"))), tab === 'subscribers' && /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: 12,
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement(SegTabs, {
    size: "sm",
    tabs: [{
      value: 'all',
      label: 'All',
      count: counts.all
    }, {
      value: 'active',
      label: 'Active',
      count: counts.active
    }, {
      value: 'pending',
      label: 'Pending',
      count: counts.pending
    }, {
      value: 'unsubscribed',
      label: 'Unsubscribed',
      count: counts.unsubscribed
    }],
    active: statusFilter,
    onChange: setStatusFilter
  }), /*#__PURE__*/React.createElement(SearchInput, {
    value: search,
    onChange: setSearch,
    placeholder: "Search email or name\u2026",
    width: 240
  })), sel.length > 0 && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      padding: '10px 16px',
      background: DS.fg1,
      borderRadius: DS.rMd,
      animation: 'dsFade 160ms ease'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 600,
      color: '#fff'
    }
  }, sel.length, " selected"), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(Btn, {
    variant: "ghost",
    size: "sm",
    icon: "send",
    style: {
      color: '#fff',
      borderColor: 'rgba(255,255,255,0.25)'
    }
  }, "Email"), /*#__PURE__*/React.createElement(Btn, {
    variant: "ghost",
    size: "sm",
    icon: "tag",
    style: {
      color: '#fff',
      borderColor: 'rgba(255,255,255,0.25)'
    }
  }, "Tag"), /*#__PURE__*/React.createElement(Btn, {
    variant: "ghost",
    size: "sm",
    icon: "trash",
    style: {
      color: '#fff',
      borderColor: 'rgba(255,255,255,0.25)'
    }
  }, "Remove"), /*#__PURE__*/React.createElement(Btn, {
    variant: "ghost",
    size: "sm",
    onClick: () => setSel([]),
    style: {
      color: 'rgba(255,255,255,0.6)',
      borderColor: 'transparent'
    }
  }, "Clear"))), /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      overflowX: 'auto'
    }
  }, /*#__PURE__*/React.createElement("table", {
    style: {
      width: '100%',
      borderCollapse: 'collapse',
      minWidth: 720
    }
  }, /*#__PURE__*/React.createElement("thead", null, /*#__PURE__*/React.createElement("tr", {
    style: {
      borderBottom: `1px solid ${DS.border}`,
      background: '#FBF9F5'
    }
  }, /*#__PURE__*/React.createElement("th", {
    style: {
      padding: '12px 16px',
      width: 40
    }
  }, /*#__PURE__*/React.createElement(Check, {
    on: allSel,
    onClick: toggleAll
  })), ['Subscriber', 'Status', 'Source', 'Engagement', 'Joined', ''].map((h, i) => /*#__PURE__*/React.createElement("th", {
    key: i,
    style: {
      padding: '12px 14px',
      textAlign: i === 3 ? 'left' : 'left',
      fontFamily: DS.fontUI,
      fontSize: 11,
      fontWeight: 700,
      letterSpacing: '0.06em',
      textTransform: 'uppercase',
      color: DS.fg4,
      whiteSpace: 'nowrap'
    }
  }, h)))), /*#__PURE__*/React.createElement("tbody", null, filtered.map(s => {
    const isSel = sel.includes(s.id);
    return /*#__PURE__*/React.createElement("tr", {
      key: s.id,
      style: {
        borderBottom: `1px solid ${DS.border}`,
        background: isSel ? DS.goldSoft + '88' : 'transparent'
      },
      onMouseEnter: e => {
        if (!isSel) e.currentTarget.style.background = '#FBF9F5';
      },
      onMouseLeave: e => {
        if (!isSel) e.currentTarget.style.background = 'transparent';
      }
    }, /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 16px'
      }
    }, /*#__PURE__*/React.createElement(Check, {
      on: isSel,
      onClick: () => toggleOne(s.id)
    })), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px'
      }
    }, /*#__PURE__*/React.createElement("div", {
      style: {
        display: 'flex',
        alignItems: 'center',
        gap: 11
      }
    }, /*#__PURE__*/React.createElement(Avatar, {
      name: s.name !== '—' ? s.name : s.email,
      size: 32
    }), /*#__PURE__*/React.createElement("div", {
      style: {
        minWidth: 0
      }
    }, /*#__PURE__*/React.createElement("div", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 13,
        fontWeight: 600,
        color: DS.fg1
      }
    }, s.email), s.name !== '—' && /*#__PURE__*/React.createElement("div", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 12,
        color: DS.fg4
      }
    }, s.name)))), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px'
      }
    }, /*#__PURE__*/React.createElement(Badge, {
      tone: statusTone[s.status]
    }, s.status)), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px',
        fontFamily: DS.fontUI,
        fontSize: 12.5,
        color: DS.fg2,
        whiteSpace: 'nowrap'
      }
    }, s.source), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px'
      }
    }, /*#__PURE__*/React.createElement("div", {
      style: {
        display: 'flex',
        alignItems: 'center',
        gap: 9,
        width: 120
      }
    }, /*#__PURE__*/React.createElement("div", {
      style: {
        flex: 1
      }
    }, /*#__PURE__*/React.createElement(ProgressBar, {
      value: s.opens,
      color: s.opens >= 70 ? DS.green : s.opens >= 40 ? DS.gold : DS.borderSt,
      height: 6
    })), /*#__PURE__*/React.createElement("span", {
      style: {
        fontFamily: DS.fontMono,
        fontSize: 11,
        fontWeight: 700,
        color: DS.fg3,
        width: 30,
        textAlign: 'right'
      }
    }, s.opens, "%"))), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px',
        fontFamily: DS.fontUI,
        fontSize: 12,
        color: DS.fg3,
        whiteSpace: 'nowrap'
      }
    }, s.joined), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 14px'
      }
    }, /*#__PURE__*/React.createElement("button", {
      style: {
        border: 'none',
        background: 'none',
        cursor: 'pointer',
        color: DS.fg4,
        display: 'flex'
      }
    }, /*#__PURE__*/React.createElement(Icon, {
      name: "more-horizontal",
      size: 17
    }))));
  })))), filtered.length === 0 && /*#__PURE__*/React.createElement(EmptyState, {
    icon: "users",
    title: "No subscribers found",
    body: "Try adjusting your search or status filter.",
    action: /*#__PURE__*/React.createElement(Btn, {
      variant: "soft",
      onClick: () => {
        setSearch('');
        setStatusFilter('all');
      }
    }, "Clear filters")
  }))), tab === 'campaigns' && /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Recent Campaigns")), CAMPAIGNS.map((c, i) => /*#__PURE__*/React.createElement("div", {
    key: c.id,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 16,
      padding: '15px 20px',
      borderBottom: i < CAMPAIGNS.length - 1 ? `1px solid ${DS.border}` : 'none'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 38,
      height: 38,
      borderRadius: DS.rMd,
      background: c.status === 'sent' ? DS.greenSoft : DS.blueSoft,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      flexShrink: 0
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: c.status === 'sent' ? 'send' : 'clock',
    size: 18,
    color: c.status === 'sent' ? DS.green : DS.blue,
    stroke: 2
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1,
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis'
    }
  }, c.subject), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg4,
      marginTop: 2
    }
  }, c.sent, " \xB7 ", c.recipients ? c.recipients.toLocaleString() + ' recipients' : 'not sent yet')), c.status === 'sent' ? /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
    style: {
      textAlign: 'center',
      minWidth: 60
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, c.openRate, "%"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 10.5,
      color: DS.fg4
    }
  }, "opens")), /*#__PURE__*/React.createElement("div", {
    style: {
      textAlign: 'center',
      minWidth: 60
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: accent
    }
  }, c.clickRate, "%"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 10.5,
      color: DS.fg4
    }
  }, "clicks"))) : /*#__PURE__*/React.createElement(Badge, {
    tone: "scheduled"
  }, "Scheduled")))));
}
Object.assign(window, {
  Subscribers
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties-cms/Subscribers.jsx", error: String((e && e.message) || e) }); }

// ui_kits/debesties-cms/SystemViews.jsx
try { (() => {
// Debesties CMS — System Views
// Exports: UsersRoles, SeoTools, AiVisibility, Settings, NavBuilder, HomeBuilder, LoadingState, ErrorState

/* ── USERS & ROLES ─────────────────────────────────────── */
function UsersRoles({
  accent
}) {
  const [tab, setTab] = React.useState('members');
  const statusTone = {
    active: 'published',
    invited: 'review'
  };
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 18
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      flexWrap: 'wrap',
      gap: 12
    }
  }, /*#__PURE__*/React.createElement(SegTabs, {
    tabs: [{
      value: 'members',
      label: 'Members',
      count: USERS.length
    }, {
      value: 'roles',
      label: 'Roles & Permissions',
      count: ROLES.length
    }],
    active: tab,
    onChange: setTab
  }), /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    icon: "plus"
  }, tab === 'members' ? 'Invite member' : 'New role')), tab === 'members' && /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      overflowX: 'auto'
    }
  }, /*#__PURE__*/React.createElement("table", {
    style: {
      width: '100%',
      borderCollapse: 'collapse',
      minWidth: 680
    }
  }, /*#__PURE__*/React.createElement("thead", null, /*#__PURE__*/React.createElement("tr", {
    style: {
      background: '#FBF9F5',
      borderBottom: `1px solid ${DS.border}`
    }
  }, ['Member', 'Role', 'Posts', 'Status', 'Last active', ''].map((h, i) => /*#__PURE__*/React.createElement("th", {
    key: i,
    style: {
      padding: '12px 16px',
      textAlign: 'left',
      fontFamily: DS.fontUI,
      fontSize: 11,
      fontWeight: 700,
      letterSpacing: '0.05em',
      textTransform: 'uppercase',
      color: DS.fg4
    }
  }, h)))), /*#__PURE__*/React.createElement("tbody", null, USERS.map((u, i) => {
    const role = ROLES.find(r => r.name === u.role);
    return /*#__PURE__*/React.createElement("tr", {
      key: i,
      style: {
        borderBottom: i < USERS.length - 1 ? `1px solid ${DS.border}` : 'none'
      },
      onMouseEnter: e => e.currentTarget.style.background = '#FBF9F5',
      onMouseLeave: e => e.currentTarget.style.background = 'transparent'
    }, /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 16px'
      }
    }, /*#__PURE__*/React.createElement("div", {
      style: {
        display: 'flex',
        alignItems: 'center',
        gap: 11
      }
    }, /*#__PURE__*/React.createElement(Avatar, {
      name: u.name,
      size: 36
    }), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 13.5,
        fontWeight: 600,
        color: DS.fg1
      }
    }, u.name), /*#__PURE__*/React.createElement("div", {
      style: {
        fontFamily: DS.fontUI,
        fontSize: 12,
        color: DS.fg4
      }
    }, u.email)))), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 16px'
      }
    }, /*#__PURE__*/React.createElement("span", {
      style: {
        display: 'inline-flex',
        alignItems: 'center',
        gap: 6,
        fontFamily: DS.fontUI,
        fontSize: 12.5,
        fontWeight: 600,
        color: DS.fg2
      }
    }, /*#__PURE__*/React.createElement("span", {
      style: {
        width: 8,
        height: 8,
        borderRadius: 999,
        background: role?.color || DS.fg4
      }
    }), u.role)), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 16px',
        fontFamily: DS.fontUI,
        fontSize: 13,
        fontWeight: 600,
        color: DS.fg1
      }
    }, u.posts), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 16px'
      }
    }, /*#__PURE__*/React.createElement(Badge, {
      tone: statusTone[u.status]
    }, u.status)), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 16px',
        fontFamily: DS.fontUI,
        fontSize: 12.5,
        color: u.last === 'Online now' ? DS.green : DS.fg3,
        fontWeight: u.last === 'Online now' ? 600 : 400
      }
    }, u.last), /*#__PURE__*/React.createElement("td", {
      style: {
        padding: '12px 16px'
      }
    }, /*#__PURE__*/React.createElement("button", {
      style: {
        border: 'none',
        background: 'none',
        cursor: 'pointer',
        color: DS.fg4,
        display: 'flex'
      }
    }, /*#__PURE__*/React.createElement(Icon, {
      name: "more-horizontal",
      size: 17
    }))));
  }))))), tab === 'roles' && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fill, minmax(300px, 1fr))',
      gap: 14
    }
  }, ROLES.map(r => /*#__PURE__*/React.createElement(Card, {
    key: r.name,
    hover: true
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 11,
      marginBottom: 12
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 38,
      height: 38,
      borderRadius: DS.rMd,
      background: `${r.color}1A`,
      color: r.color,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "users",
    size: 18,
    stroke: 2
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, r.name), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg4
    }
  }, r.count, " ", r.count === 1 ? 'member' : 'members'))), /*#__PURE__*/React.createElement("p", {
    style: {
      margin: '0 0 14px',
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg3,
      lineHeight: 1.55
    }
  }, r.perms), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    full: true,
    icon: "settings"
  }, "Edit permissions")))));
}

/* ── SEO TOOLS ─────────────────────────────────────────── */
function SeoTools({
  accent
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 20
    }
  }, /*#__PURE__*/React.createElement("div", {
    className: "cms-stat-grid",
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(4,1fr)',
      gap: 14
    }
  }, /*#__PURE__*/React.createElement(StatCard, {
    label: "Avg. SEO Score",
    value: "78",
    delta: "+4",
    deltaDir: "up",
    icon: "gauge",
    tone: "green"
  }), /*#__PURE__*/React.createElement(StatCard, {
    label: "Indexed Pages",
    value: "241",
    delta: "+12",
    deltaDir: "up",
    icon: "globe",
    tone: "blue"
  }), /*#__PURE__*/React.createElement(StatCard, {
    label: "Avg. Position",
    value: "4.2",
    delta: "+0.8",
    deltaDir: "up",
    icon: "trending-up",
    tone: "gold"
  }), /*#__PURE__*/React.createElement(StatCard, {
    label: "Broken Links",
    value: "3",
    icon: "alert-triangle",
    tone: "red"
  })), /*#__PURE__*/React.createElement("div", {
    className: "cms-dash-cols",
    style: {
      display: 'grid',
      gridTemplateColumns: '1fr 1fr',
      gap: 20,
      alignItems: 'start'
    }
  }, /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`,
      display: 'flex',
      alignItems: 'center',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "gauge",
    size: 17,
    color: DS.green,
    stroke: 2
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Focus Keyword Tracking")), [['artiste of the year ghana', 1, 'up'], ['tgma double winners', 2, 'up'], ['black sherif awards', 3, 'down'], ['ghana music awards history', 6, 'up'], ['sarkodie tgma wins', 8, 'down']].map(([kw, pos, dir], i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 12,
      padding: '12px 20px',
      borderBottom: i < 4 ? `1px solid ${DS.border}` : 'none'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "search",
    size: 14,
    color: DS.fg4
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      flex: 1,
      fontFamily: DS.fontUI,
      fontSize: 13,
      color: DS.fg1
    }
  }, kw), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontMono,
      fontSize: 12,
      fontWeight: 700,
      color: pos <= 3 ? DS.green : DS.gold,
      background: pos <= 3 ? DS.greenSoft : DS.goldSoft,
      padding: '2px 9px',
      borderRadius: 999
    }
  }, "#", pos), /*#__PURE__*/React.createElement(Icon, {
    name: dir === 'up' ? 'trending-up' : 'trending-down',
    size: 15,
    color: dir === 'up' ? DS.green : DS.red,
    stroke: 2.2
  })))), /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`,
      display: 'flex',
      alignItems: 'center',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "list-checks",
    size: 17,
    color: DS.gold,
    stroke: 2
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Site Health")), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '8px 20px'
    }
  }, [['XML sitemap submitted', true], ['robots.txt configured', true], ['Schema markup valid', true], ['No broken internal links', false], ['All images have alt text', false], ['Core Web Vitals passing', true], ['Mobile-friendly', true], ['HTTPS enabled', true]].map(([l, pass], i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 10,
      padding: '9px 0',
      borderBottom: i < 7 ? `1px solid ${DS.border}` : 'none'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 20,
      height: 20,
      borderRadius: 999,
      flexShrink: 0,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      background: pass ? DS.greenSoft : DS.redSoft,
      color: pass ? DS.green : DS.red
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: pass ? 'check' : 'x',
    size: 12,
    stroke: 3
  })), /*#__PURE__*/React.createElement("span", {
    style: {
      flex: 1,
      fontFamily: DS.fontUI,
      fontSize: 13,
      color: DS.fg2
    }
  }, l), !pass && /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11.5,
      fontWeight: 600,
      color: accent,
      cursor: 'pointer'
    }
  }, "Fix")))))), /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`,
      display: 'flex',
      alignItems: 'center',
      gap: 8
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "link",
    size: 17,
    color: DS.blue,
    stroke: 2
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Internal Linking Opportunities")), [['The Elite Club: 4 Artists…', 'Sarkodie vs Stonebwoy: The Numbers', 3], ['Black Sherif\u2019s Second Crown', 'Every Hiplife Winner That Defined an Era', 2], ['King Promise\u2019s 2025 Win', 'Diana Hamilton & The Rise of Gospel', 1]].map(([from, to, n], i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 12,
      padding: '13px 20px',
      borderBottom: i < 2 ? `1px solid ${DS.border}` : 'none'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      display: 'flex',
      alignItems: 'center',
      gap: 10,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      color: DS.fg2,
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis',
      flex: 1
    }
  }, from), /*#__PURE__*/React.createElement(Icon, {
    name: "arrow-right",
    size: 14,
    color: DS.fg4
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 600,
      color: DS.fg1,
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis',
      flex: 1
    }
  }, to)), /*#__PURE__*/React.createElement(Badge, {
    tone: "ai",
    dot: false
  }, n, " ", n === 1 ? 'spot' : 'spots'), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm"
  }, "Add link")))));
}

/* ── AI VISIBILITY ─────────────────────────────────────── */
function AiVisibility({
  accent
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 20
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      borderRadius: DS.rLg,
      padding: '26px 28px',
      background: `linear-gradient(120deg, ${DS.aiFrom} 0%, ${DS.aiTo} 100%)`,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: 20,
      flexWrap: 'wrap',
      position: 'relative',
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      top: -30,
      right: 40,
      opacity: 0.16
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "sparkles",
    size: 160,
    color: "#fff"
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 7,
      background: 'rgba(255,255,255,0.18)',
      padding: '4px 12px',
      borderRadius: 999,
      marginBottom: 12
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "sparkles",
    size: 13,
    color: "#fff"
  }), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11.5,
      fontWeight: 700,
      color: '#fff',
      letterSpacing: '0.04em'
    }
  }, "AI VISIBILITY ENGINE")), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontDisp,
      fontSize: 26,
      fontWeight: 700,
      color: '#fff',
      letterSpacing: '-0.01em'
    }
  }, "Be the answer AI gives"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      color: 'rgba(255,255,255,0.85)',
      marginTop: 6,
      maxWidth: 420,
      lineHeight: 1.5
    }
  }, "Track how Debesties appears across ChatGPT, Gemini, Perplexity & Google AI Overviews.")), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      textAlign: 'center',
      background: 'rgba(255,255,255,0.14)',
      borderRadius: DS.rLg,
      padding: '18px 28px'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 44,
      fontWeight: 800,
      color: '#fff',
      lineHeight: 1
    }
  }, "72"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: 'rgba(255,255,255,0.8)',
      marginTop: 4
    }
  }, "AI Visibility Score"))), /*#__PURE__*/React.createElement("div", {
    className: "cms-stat-grid",
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(4,1fr)',
      gap: 14
    }
  }, [['ChatGPT', 28, '+6'], ['Google AI', 41, '+12'], ['Perplexity', 19, '+3'], ['Gemini', 14, '\u22122']].map(([name, cites, delta]) => /*#__PURE__*/React.createElement(Card, {
    key: name,
    pad: 18
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      marginBottom: 12
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 600,
      color: DS.fg2
    }
  }, name), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      fontWeight: 700,
      color: delta.startsWith('\u2212') ? DS.red : DS.green
    }
  }, delta)), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 26,
      fontWeight: 700,
      color: DS.fg1,
      lineHeight: 1
    }
  }, cites), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg4,
      marginTop: 4
    }
  }, "citations this month")))), /*#__PURE__*/React.createElement("div", {
    className: "cms-dash-cols",
    style: {
      display: 'grid',
      gridTemplateColumns: '1fr 1fr',
      gap: 20,
      alignItems: 'start'
    }
  }, /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Most-Cited by AI")), [['The Elite Club: 4 Artists…', 34], ['Black Sherif\u2019s Second Crown', 21], ['Every Hiplife Winner…', 14]].map(([t, n], i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 12,
      padding: '13px 20px',
      borderBottom: i < 2 ? `1px solid ${DS.border}` : 'none'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 30,
      height: 30,
      borderRadius: 8,
      background: DS.aiSoft,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      flexShrink: 0
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "sparkles",
    size: 15,
    color: DS.aiTo
  })), /*#__PURE__*/React.createElement("span", {
    style: {
      flex: 1,
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 600,
      color: DS.fg1,
      whiteSpace: 'nowrap',
      overflow: 'hidden',
      textOverflow: 'ellipsis'
    }
  }, t), /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 700,
      color: DS.aiTo
    }
  }, n, "\xD7")))), /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Optimization Queue")), [['Add Quick Answer block', 'Sarkodie vs Stonebwoy'], ['Add FAQ schema', 'How TGMA Voting Works'], ['Cite sources inline', '2019 Annulment']].map(([action, post], i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 12,
      padding: '13px 20px',
      borderBottom: i < 2 ? `1px solid ${DS.border}` : 'none'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1,
      minWidth: 0
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 600,
      color: DS.fg1
    }
  }, action), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg4,
      marginTop: 1
    }
  }, post)), /*#__PURE__*/React.createElement(Btn, {
    variant: "ai",
    size: "sm",
    icon: "sparkles"
  }, "Optimize"))))));
}

/* ── SETTINGS ──────────────────────────────────────────── */
function Settings({
  accent
}) {
  const [section, setSection] = React.useState('general');
  const [toggles, setToggles] = React.useState({
    comments: true,
    ai: true,
    newsletter: true,
    maintenance: false,
    indexing: true
  });
  const set = k => setToggles(t => ({
    ...t,
    [k]: !t[k]
  }));
  const nav = [['general', 'General', 'settings'], ['publishing', 'Publishing', 'file-text'], ['integrations', 'Integrations', 'globe'], ['advanced', 'Advanced', 'database']];
  return /*#__PURE__*/React.createElement("div", {
    className: "cms-settings",
    style: {
      display: 'grid',
      gridTemplateColumns: '200px 1fr',
      gap: 24,
      alignItems: 'start'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 2
    }
  }, nav.map(([key, label, icon]) => /*#__PURE__*/React.createElement("button", {
    key: key,
    onClick: () => setSection(key),
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 10,
      padding: '10px 12px',
      border: 'none',
      borderRadius: DS.rMd,
      cursor: 'pointer',
      background: section === key ? DS.surface : 'transparent',
      boxShadow: section === key ? DS.shCard : 'none',
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: section === key ? 600 : 500,
      color: section === key ? DS.fg1 : DS.fg3,
      textAlign: 'left'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: icon,
    size: 16,
    stroke: 2,
    color: section === key ? accent : DS.fg4
  }), label))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 16
    }
  }, section === 'general' && /*#__PURE__*/React.createElement(Card, null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1,
      marginBottom: 18
    }
  }, "Site Identity"), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 16
    }
  }, /*#__PURE__*/React.createElement(Field, {
    label: "Site name",
    value: "Debesties"
  }), /*#__PURE__*/React.createElement(Field, {
    label: "Tagline",
    value: "Ghana's definitive music awards record"
  }), /*#__PURE__*/React.createElement(Field, {
    label: "Site URL",
    value: "https://debesties.com",
    prefix: "\uD83C\uDF10",
    mono: true
  }), /*#__PURE__*/React.createElement(Field, {
    label: "Default category",
    value: "Awards History"
  }))), (section === 'general' || section === 'publishing') && /*#__PURE__*/React.createElement(Card, null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1,
      marginBottom: 6
    }
  }, "Preferences"), [['comments', 'Allow comments', 'Let readers comment on published posts'], ['ai', 'AI visibility tools', 'Enable AI answer optimization features'], ['newsletter', 'Newsletter signups', 'Show subscribe forms on articles'], ['indexing', 'Search engine indexing', 'Allow Google to index this site'], ['maintenance', 'Maintenance mode', 'Take the site offline for visitors']].map(([k, label, desc], i, arr) => /*#__PURE__*/React.createElement("div", {
    key: k,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 14,
      padding: '14px 0',
      borderBottom: i < arr.length - 1 ? `1px solid ${DS.border}` : 'none'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1
    }
  }, label), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.fg4,
      marginTop: 1
    }
  }, desc)), /*#__PURE__*/React.createElement(Toggle, {
    on: toggles[k],
    onChange: () => set(k)
  })))), section === 'integrations' && /*#__PURE__*/React.createElement(Card, null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1,
      marginBottom: 16
    }
  }, "Connected Services"), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 10
    }
  }, [['Google Search Console', 'Connected', true], ['Google Analytics 4', 'Connected', true], ['Mailchimp', 'Connected', true], ['Cloudflare CDN', 'Not connected', false], ['X (Twitter) auto-post', 'Not connected', false]].map(([name, st, on], i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 12,
      padding: '12px 14px',
      border: `1px solid ${DS.border}`,
      borderRadius: DS.rMd
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 34,
      height: 34,
      borderRadius: 8,
      background: on ? DS.greenSoft : '#EFEBE3',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      color: on ? DS.green : DS.fg4
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "globe",
    size: 17
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1
    }
  }, name), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: on ? DS.green : DS.fg4
    }
  }, st)), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm"
  }, on ? 'Manage' : 'Connect'))))), section === 'advanced' && /*#__PURE__*/React.createElement(Card, null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1,
      marginBottom: 16
    }
  }, "Advanced"), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 14
    }
  }, /*#__PURE__*/React.createElement(Field, {
    label: "Custom CSS",
    textarea: true,
    rows: 4,
    value: ":root { --accent: #E8A800; }",
    mono: true
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '14px 16px',
      background: DS.redSoft,
      borderRadius: DS.rMd,
      display: 'flex',
      alignItems: 'center',
      gap: 12
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "alert-triangle",
    size: 18,
    color: DS.red
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 600,
      color: DS.redDeep
    }
  }, "Danger zone"), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: DS.red
    }
  }, "Export or permanently delete all site data.")), /*#__PURE__*/React.createElement(Btn, {
    variant: "danger",
    size: "sm"
  }, "Export")))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'flex-end',
      gap: 10
    }
  }, /*#__PURE__*/React.createElement(Btn, {
    variant: "soft"
  }, "Cancel"), /*#__PURE__*/React.createElement(Btn, {
    variant: "primary",
    icon: "save"
  }, "Save changes"))));
}

/* ── NAVIGATION BUILDER ────────────────────────────────── */
function NavBuilder({
  accent
}) {
  const items = [['Home', '/', true], ['Awards History', '/awards-history', false], ['Profiles', '/profiles', false], ['Analysis', '/analysis', false], ['About', '/about', false]];
  return /*#__PURE__*/React.createElement("div", {
    className: "cms-dash-cols",
    style: {
      display: 'grid',
      gridTemplateColumns: '1fr 360px',
      gap: 20,
      alignItems: 'start'
    }
  }, /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Primary Menu"), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    icon: "plus"
  }, "Add item")), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: 14,
      display: 'flex',
      flexDirection: 'column',
      gap: 8
    }
  }, items.map(([label, url, home], i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 11,
      padding: '11px 14px',
      border: `1px solid ${DS.border}`,
      borderRadius: DS.rMd,
      background: '#FBF9F5'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "grip",
    size: 16,
    color: DS.fg4
  }), /*#__PURE__*/React.createElement(Icon, {
    name: home ? 'home' : 'file-text',
    size: 15,
    color: DS.fg3
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1
    }
  }, label), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontMono,
      fontSize: 11,
      color: DS.fg4
    }
  }, url)), /*#__PURE__*/React.createElement("button", {
    style: {
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      color: DS.fg4,
      display: 'flex'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "edit",
    size: 15
  })), /*#__PURE__*/React.createElement("button", {
    style: {
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      color: DS.fg4,
      display: 'flex'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "trash",
    size: 15
  })))))), /*#__PURE__*/React.createElement(Card, null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 700,
      color: DS.fg2,
      marginBottom: 14
    }
  }, "Live Preview"), /*#__PURE__*/React.createElement("div", {
    style: {
      borderRadius: DS.rMd,
      border: `1px solid ${DS.border}`,
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      background: DS.fg1,
      padding: '14px 16px',
      display: 'flex',
      alignItems: 'center',
      gap: 14,
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: '#fff'
    }
  }, "debesties"), items.map(([l]) => /*#__PURE__*/React.createElement("span", {
    key: l,
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12,
      color: 'rgba(255,255,255,0.7)'
    }
  }, l))))));
}

/* ── HOMEPAGE BUILDER ──────────────────────────────────── */
function HomeBuilder({
  accent
}) {
  const blocks = [['Hero — Featured Story', 'star', DS.gold], ['Latest Stories Grid', 'layout-dashboard', DS.blue], ['The Elite Club Strip', 'flame', DS.red], ['Trending Categories', 'folder', DS.green], ['Newsletter Signup', 'message-square', DS.aiTo]];
  return /*#__PURE__*/React.createElement("div", {
    className: "cms-dash-cols",
    style: {
      display: 'grid',
      gridTemplateColumns: '1fr 360px',
      gap: 20,
      alignItems: 'start'
    }
  }, /*#__PURE__*/React.createElement(Card, {
    pad: 0
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '16px 20px',
      borderBottom: `1px solid ${DS.border}`,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 15,
      fontWeight: 700,
      color: DS.fg1
    }
  }, "Page Sections"), /*#__PURE__*/React.createElement(Btn, {
    variant: "soft",
    size: "sm",
    icon: "plus"
  }, "Add section")), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: 14,
      display: 'flex',
      flexDirection: 'column',
      gap: 8
    }
  }, blocks.map(([label, icon, color], i) => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 12,
      padding: '13px 14px',
      border: `1px solid ${DS.border}`,
      borderRadius: DS.rMd
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "grip",
    size: 16,
    color: DS.fg4
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      width: 32,
      height: 32,
      borderRadius: 8,
      background: `${color}1A`,
      color,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: icon,
    size: 16,
    stroke: 2
  })), /*#__PURE__*/React.createElement("span", {
    style: {
      flex: 1,
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      fontWeight: 600,
      color: DS.fg1
    }
  }, label), /*#__PURE__*/React.createElement(Toggle, {
    on: true,
    onChange: () => {},
    size: "sm"
  }), /*#__PURE__*/React.createElement("button", {
    style: {
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      color: DS.fg4,
      display: 'flex'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "settings",
    size: 15
  })))))), /*#__PURE__*/React.createElement(Card, null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13,
      fontWeight: 700,
      color: DS.fg2,
      marginBottom: 14
    }
  }, "Homepage Preview"), /*#__PURE__*/React.createElement("div", {
    style: {
      borderRadius: DS.rMd,
      border: `1px solid ${DS.border}`,
      overflow: 'hidden',
      display: 'flex',
      flexDirection: 'column',
      gap: 4,
      padding: 8,
      background: '#FBF9F5'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      height: 60,
      borderRadius: 6,
      background: 'linear-gradient(135deg,#1A1410,#4D3000)'
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(3,1fr)',
      gap: 4
    }
  }, [0, 1, 2].map(i => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      height: 36,
      borderRadius: 6,
      background: DS.border
    }
  }))), /*#__PURE__*/React.createElement("div", {
    style: {
      height: 44,
      borderRadius: 6,
      background: DS.fg1
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(2,1fr)',
      gap: 4
    }
  }, [0, 1].map(i => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      height: 28,
      borderRadius: 6,
      background: DS.border
    }
  }))), /*#__PURE__*/React.createElement("div", {
    style: {
      height: 32,
      borderRadius: 6,
      background: DS.aiSoft
    }
  }))));
}

/* ── LOADING / ERROR STATES ────────────────────────────── */
function LoadingState() {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 16
    }
  }, /*#__PURE__*/React.createElement("div", {
    className: "cms-stat-grid",
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(4,1fr)',
      gap: 14
    }
  }, [0, 1, 2, 3].map(i => /*#__PURE__*/React.createElement(Card, {
    key: i,
    pad: 18
  }, /*#__PURE__*/React.createElement("div", {
    className: "cms-shimmer",
    style: {
      width: 38,
      height: 38,
      borderRadius: 9,
      marginBottom: 14
    }
  }), /*#__PURE__*/React.createElement("div", {
    className: "cms-shimmer",
    style: {
      width: '60%',
      height: 22,
      borderRadius: 6,
      marginBottom: 8
    }
  }), /*#__PURE__*/React.createElement("div", {
    className: "cms-shimmer",
    style: {
      width: '40%',
      height: 12,
      borderRadius: 6
    }
  })))), /*#__PURE__*/React.createElement(Card, null, [0, 1, 2, 3, 4].map(i => /*#__PURE__*/React.createElement("div", {
    key: i,
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 14,
      padding: '12px 0',
      borderBottom: i < 4 ? `1px solid ${DS.border}` : 'none'
    }
  }, /*#__PURE__*/React.createElement("div", {
    className: "cms-shimmer",
    style: {
      width: 52,
      height: 38,
      borderRadius: 7
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      flex: 1
    }
  }, /*#__PURE__*/React.createElement("div", {
    className: "cms-shimmer",
    style: {
      width: '70%',
      height: 14,
      borderRadius: 6,
      marginBottom: 7
    }
  }), /*#__PURE__*/React.createElement("div", {
    className: "cms-shimmer",
    style: {
      width: '40%',
      height: 11,
      borderRadius: 6
    }
  })), /*#__PURE__*/React.createElement("div", {
    className: "cms-shimmer",
    style: {
      width: 60,
      height: 22,
      borderRadius: 999
    }
  })))));
}
function ErrorState({
  onRetry
}) {
  return /*#__PURE__*/React.createElement(Card, {
    style: {
      minHeight: 400,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center'
    }
  }, /*#__PURE__*/React.createElement(EmptyState, {
    icon: "alert-triangle",
    title: "Something went wrong",
    body: "We couldn't load this data. Check your connection and try again.",
    action: /*#__PURE__*/React.createElement(Btn, {
      variant: "primary",
      icon: "refresh",
      onClick: onRetry
    }, "Retry")
  }));
}
Object.assign(window, {
  UsersRoles,
  SeoTools,
  AiVisibility,
  Settings,
  NavBuilder,
  HomeBuilder,
  LoadingState,
  ErrorState
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties-cms/SystemViews.jsx", error: String((e && e.message) || e) }); }

// ui_kits/debesties-cms/components.jsx
try { (() => {
// Debesties CMS — Design Tokens + Shared Primitives
// Exports to window: DS, Icon, Btn, Badge, Card, StatCard, Avatar, ScoreRing,
//   SegTabs, SearchInput, Toggle, Field, Modal, EmptyState, Spinner, ProgressBar, Sparkline

/* ── TOKENS ─────────────────────────────────────────────── */
const DS = {
  // Surfaces
  bg: '#F4F1EC',
  // app canvas (warm)
  surface: '#FFFFFF',
  sidebar: '#17120D',
  // charcoal sidebar
  sidebarHi: '#221B14',
  // Ink
  fg1: '#1A1410',
  fg2: '#4A4236',
  fg3: '#7A7163',
  fg4: '#A89F90',
  inverse: '#F4F1EC',
  // Brand accents
  gold: '#E8A800',
  goldSoft: '#FFF6DD',
  goldDeep: '#A06C00',
  green: '#1A8A4B',
  greenSoft: '#E5F5EC',
  greenDeep: '#0E5C30',
  red: '#C8372B',
  redSoft: '#FBEAE8',
  redDeep: '#8F261D',
  blue: '#2F6BD8',
  blueSoft: '#E9F0FC',
  // AI gradient (from the debesties logo)
  aiFrom: '#3B5BDB',
  aiTo: '#B14FD8',
  aiSoft: '#F1ECFB',
  // Lines
  border: '#E7E1D8',
  borderSt: '#D6CEC1',
  // Type
  fontUI: "'Outfit', sans-serif",
  fontDisp: "'Playfair Display', serif",
  fontMono: "'Space Mono', monospace",
  // Shadow
  shCard: '0 1px 3px rgba(26,20,16,0.06), 0 1px 2px rgba(26,20,16,0.04)',
  shRaised: '0 4px 16px rgba(26,20,16,0.10)',
  shPop: '0 12px 40px rgba(26,20,16,0.18)',
  // Radii
  rSm: 6,
  rMd: 9,
  rLg: 14,
  rXl: 20
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
  'pen-tool': '<path d="M15.707 21.293a1 1 0 0 1-1.414 0l-1.586-1.586a1 1 0 0 1 0-1.414l5.586-5.586a1 1 0 0 1 1.414 0l1.586 1.586a1 1 0 0 1 0 1.414z"/><path d="m18 13-1.375-6.874a1 1 0 0 0-.746-.776L3.235 2.028a1 1 0 0 0-1.207 1.207L5.35 15.879a1 1 0 0 0 .776.746L13 18"/><path d="m2.3 2.3 7.286 7.286"/><circle cx="11" cy="11" r="2"/>'
};
function Icon({
  name,
  size = 18,
  color = 'currentColor',
  stroke = 1.75,
  style,
  fill = 'none'
}) {
  return /*#__PURE__*/React.createElement("svg", {
    width: size,
    height: size,
    viewBox: "0 0 24 24",
    fill: fill,
    stroke: color,
    strokeWidth: stroke,
    strokeLinecap: "round",
    strokeLinejoin: "round",
    style: {
      flexShrink: 0,
      ...style
    },
    dangerouslySetInnerHTML: {
      __html: ICON_PATHS[name] || ''
    }
  });
}

/* ── BUTTON ─────────────────────────────────────────────── */
function Btn({
  children,
  variant = 'primary',
  size = 'md',
  icon,
  iconRight,
  onClick,
  full,
  disabled,
  style,
  title,
  type
}) {
  const [hov, setHov] = React.useState(false);
  const [press, setPress] = React.useState(false);
  const sizes = {
    sm: {
      padding: '6px 12px',
      fontSize: 12.5,
      gap: 6,
      h: 32,
      ic: 14
    },
    md: {
      padding: '9px 16px',
      fontSize: 13.5,
      gap: 7,
      h: 38,
      ic: 16
    },
    lg: {
      padding: '12px 22px',
      fontSize: 15,
      gap: 8,
      h: 46,
      ic: 18
    }
  }[size];
  const variants = {
    primary: {
      bg: DS.gold,
      color: '#1A1410',
      border: 'transparent',
      hbg: '#D69B00'
    },
    dark: {
      bg: DS.fg1,
      color: '#fff',
      border: 'transparent',
      hbg: '#2C241B'
    },
    green: {
      bg: DS.green,
      color: '#fff',
      border: 'transparent',
      hbg: DS.greenDeep
    },
    danger: {
      bg: DS.red,
      color: '#fff',
      border: 'transparent',
      hbg: DS.redDeep
    },
    ghost: {
      bg: 'transparent',
      color: DS.fg2,
      border: DS.borderSt,
      hbg: 'rgba(26,20,16,0.04)'
    },
    soft: {
      bg: '#FFFFFF',
      color: DS.fg1,
      border: DS.border,
      hbg: '#FBF9F5'
    },
    ai: {
      bg: `linear-gradient(120deg, ${DS.aiFrom}, ${DS.aiTo})`,
      color: '#fff',
      border: 'transparent',
      hbg: `linear-gradient(120deg, ${DS.aiFrom}, ${DS.aiTo})`
    }
  }[variant];
  return /*#__PURE__*/React.createElement("button", {
    type: type || 'button',
    title: title,
    disabled: disabled,
    onClick: onClick,
    onMouseEnter: () => setHov(true),
    onMouseLeave: () => {
      setHov(false);
      setPress(false);
    },
    onMouseDown: () => setPress(true),
    onMouseUp: () => setPress(false),
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      justifyContent: 'center',
      gap: sizes.gap,
      fontFamily: DS.fontUI,
      fontSize: sizes.fontSize,
      fontWeight: 600,
      letterSpacing: '0.01em',
      padding: sizes.padding,
      height: sizes.h,
      background: hov && !disabled ? variants.hbg : variants.bg,
      color: variants.color,
      border: `1.5px solid ${variants.border === 'transparent' ? 'transparent' : variants.border}`,
      borderRadius: DS.rMd,
      cursor: disabled ? 'not-allowed' : 'pointer',
      opacity: disabled ? 0.5 : 1,
      width: full ? '100%' : 'auto',
      transform: press ? 'scale(0.97)' : 'scale(1)',
      transition: 'background 140ms, transform 100ms, border-color 140ms, box-shadow 140ms',
      boxShadow: variant === 'ai' && hov ? '0 4px 16px rgba(120,79,224,0.35)' : 'none',
      whiteSpace: 'nowrap',
      ...style
    }
  }, icon && /*#__PURE__*/React.createElement(Icon, {
    name: icon,
    size: sizes.ic,
    stroke: 2
  }), children, iconRight && /*#__PURE__*/React.createElement(Icon, {
    name: iconRight,
    size: sizes.ic,
    stroke: 2
  }));
}

/* ── BADGE ──────────────────────────────────────────────── */
const BADGE_TONES = {
  published: {
    bg: DS.greenSoft,
    fg: DS.greenDeep,
    dot: DS.green
  },
  draft: {
    bg: '#EFEBE3',
    fg: DS.fg2,
    dot: DS.fg4
  },
  scheduled: {
    bg: DS.blueSoft,
    fg: '#1E4FA8',
    dot: DS.blue
  },
  review: {
    bg: DS.goldSoft,
    fg: DS.goldDeep,
    dot: DS.gold
  },
  archived: {
    bg: '#EFEBE3',
    fg: DS.fg3,
    dot: DS.fg4
  },
  decay: {
    bg: DS.redSoft,
    fg: DS.redDeep,
    dot: DS.red
  },
  ai: {
    bg: DS.aiSoft,
    fg: '#6B3FC0',
    dot: DS.aiTo
  },
  neutral: {
    bg: '#EFEBE3',
    fg: DS.fg2,
    dot: DS.fg4
  }
};
function Badge({
  tone = 'neutral',
  children,
  dot = true,
  style
}) {
  const t = BADGE_TONES[tone] || BADGE_TONES.neutral;
  return /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 6,
      fontFamily: DS.fontUI,
      fontSize: 11.5,
      fontWeight: 600,
      letterSpacing: '0.01em',
      background: t.bg,
      color: t.fg,
      padding: dot ? '3px 10px 3px 8px' : '3px 10px',
      borderRadius: 999,
      textTransform: 'capitalize',
      whiteSpace: 'nowrap',
      ...style
    }
  }, dot && /*#__PURE__*/React.createElement("span", {
    style: {
      width: 6,
      height: 6,
      borderRadius: 999,
      background: t.dot,
      flexShrink: 0
    }
  }), children);
}

/* ── CARD ───────────────────────────────────────────────── */
function Card({
  children,
  style,
  pad = 20,
  onClick,
  hover
}) {
  const [hov, setHov] = React.useState(false);
  return /*#__PURE__*/React.createElement("div", {
    onClick: onClick,
    onMouseEnter: () => setHov(true),
    onMouseLeave: () => setHov(false),
    style: {
      background: DS.surface,
      border: `1px solid ${DS.border}`,
      borderRadius: DS.rLg,
      padding: pad,
      boxShadow: hover && hov ? DS.shRaised : DS.shCard,
      transition: 'box-shadow 180ms, transform 180ms',
      transform: hover && hov ? 'translateY(-2px)' : 'none',
      cursor: onClick ? 'pointer' : 'default',
      ...style
    }
  }, children);
}

/* ── STAT CARD ──────────────────────────────────────────── */
function StatCard({
  label,
  value,
  delta,
  deltaDir,
  icon,
  tone = 'gold',
  spark
}) {
  const tones = {
    gold: DS.gold,
    green: DS.green,
    blue: DS.blue,
    red: DS.red,
    ai: DS.aiTo
  };
  const c = tones[tone];
  return /*#__PURE__*/React.createElement(Card, {
    pad: 18,
    hover: true
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'space-between',
      alignItems: 'flex-start',
      marginBottom: 14
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 38,
      height: 38,
      borderRadius: DS.rMd,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      background: `${c}1A`,
      color: c
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: icon,
    size: 19,
    stroke: 2
  })), delta != null && /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 3,
      fontFamily: DS.fontUI,
      fontSize: 12,
      fontWeight: 700,
      color: deltaDir === 'down' ? DS.red : DS.green
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: deltaDir === 'down' ? 'trending-down' : 'trending-up',
    size: 14,
    stroke: 2.2
  }), delta)), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 27,
      fontWeight: 700,
      color: DS.fg1,
      lineHeight: 1,
      letterSpacing: '-0.02em'
    }
  }, value), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg3,
      marginTop: 6,
      fontWeight: 500
    }
  }, label));
}

/* ── AVATAR ─────────────────────────────────────────────── */
const AVA_COLORS = ['#E8A800', '#1A8A4B', '#2F6BD8', '#B14FD8', '#C8372B', '#0E5C30'];
function Avatar({
  name,
  size = 32,
  src
}) {
  const initials = name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
  const color = AVA_COLORS[name.charCodeAt(0) % AVA_COLORS.length];
  return /*#__PURE__*/React.createElement("div", {
    style: {
      width: size,
      height: size,
      borderRadius: 999,
      background: src ? 'none' : `${color}22`,
      color,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      fontFamily: DS.fontUI,
      fontSize: size * 0.38,
      fontWeight: 700,
      flexShrink: 0,
      border: `1.5px solid ${color}33`,
      overflow: 'hidden'
    }
  }, src ? /*#__PURE__*/React.createElement("img", {
    src: src,
    style: {
      width: '100%',
      height: '100%',
      objectFit: 'cover'
    }
  }) : initials);
}

/* ── SCORE RING (SEO score) ─────────────────────────────── */
function ScoreRing({
  score,
  size = 38,
  stroke = 4,
  label
}) {
  const r = (size - stroke) / 2;
  const circ = 2 * Math.PI * r;
  const color = score >= 80 ? DS.green : score >= 50 ? DS.gold : DS.red;
  return /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      width: size,
      height: size,
      flexShrink: 0
    },
    title: label
  }, /*#__PURE__*/React.createElement("svg", {
    width: size,
    height: size,
    style: {
      transform: 'rotate(-90deg)'
    }
  }, /*#__PURE__*/React.createElement("circle", {
    cx: size / 2,
    cy: size / 2,
    r: r,
    fill: "none",
    stroke: DS.border,
    strokeWidth: stroke
  }), /*#__PURE__*/React.createElement("circle", {
    cx: size / 2,
    cy: size / 2,
    r: r,
    fill: "none",
    stroke: color,
    strokeWidth: stroke,
    strokeDasharray: circ,
    strokeDashoffset: circ * (1 - score / 100),
    strokeLinecap: "round",
    style: {
      transition: 'stroke-dashoffset 600ms ease'
    }
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      inset: 0,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      fontFamily: DS.fontUI,
      fontSize: size * 0.3,
      fontWeight: 700,
      color
    }
  }, score));
}

/* ── SEGMENTED TABS ─────────────────────────────────────── */
function SegTabs({
  tabs,
  active,
  onChange,
  size = 'md'
}) {
  const pad = size === 'sm' ? '6px 12px' : '8px 16px';
  const fs = size === 'sm' ? 12.5 : 13.5;
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'inline-flex',
      background: '#EDE8DF',
      borderRadius: DS.rMd,
      padding: 3,
      gap: 2
    }
  }, tabs.map(tb => {
    const val = typeof tb === 'string' ? tb : tb.value;
    const lbl = typeof tb === 'string' ? tb : tb.label;
    const on = active === val;
    return /*#__PURE__*/React.createElement("button", {
      key: val,
      onClick: () => onChange(val),
      style: {
        fontFamily: DS.fontUI,
        fontSize: fs,
        fontWeight: on ? 600 : 500,
        padding: pad,
        border: 'none',
        borderRadius: DS.rSm,
        cursor: 'pointer',
        background: on ? DS.surface : 'transparent',
        color: on ? DS.fg1 : DS.fg3,
        boxShadow: on ? DS.shCard : 'none',
        transition: 'all 140ms',
        whiteSpace: 'nowrap',
        display: 'inline-flex',
        alignItems: 'center',
        gap: 6
      }
    }, typeof tb === 'object' && tb.icon && /*#__PURE__*/React.createElement(Icon, {
      name: tb.icon,
      size: 14,
      stroke: 2
    }), lbl, typeof tb === 'object' && tb.count != null && /*#__PURE__*/React.createElement("span", {
      style: {
        fontSize: 11,
        fontWeight: 700,
        color: on ? DS.fg3 : DS.fg4
      }
    }, tb.count));
  }));
}

/* ── SEARCH INPUT ───────────────────────────────────────── */
function SearchInput({
  value,
  onChange,
  placeholder = 'Search…',
  width = 260
}) {
  const [foc, setFoc] = React.useState(false);
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 8,
      width,
      height: 38,
      background: DS.surface,
      border: `1.5px solid ${foc ? DS.gold : DS.border}`,
      borderRadius: DS.rMd,
      padding: '0 12px',
      transition: 'border-color 140ms',
      boxShadow: foc ? `0 0 0 3px ${DS.gold}22` : 'none'
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "search",
    size: 16,
    color: DS.fg4
  }), /*#__PURE__*/React.createElement("input", {
    value: value,
    onChange: e => onChange(e.target.value),
    placeholder: placeholder,
    onFocus: () => setFoc(true),
    onBlur: () => setFoc(false),
    style: {
      border: 'none',
      outline: 'none',
      background: 'none',
      flex: 1,
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      color: DS.fg1,
      minWidth: 0
    }
  }));
}

/* ── TOGGLE ─────────────────────────────────────────────── */
function Toggle({
  on,
  onChange,
  size = 'md'
}) {
  const w = size === 'sm' ? 34 : 42,
    h = size === 'sm' ? 20 : 24,
    k = h - 6;
  return /*#__PURE__*/React.createElement("button", {
    onClick: () => onChange(!on),
    style: {
      width: w,
      height: h,
      borderRadius: 999,
      border: 'none',
      cursor: 'pointer',
      background: on ? DS.green : DS.borderSt,
      position: 'relative',
      transition: 'background 180ms',
      flexShrink: 0
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      position: 'absolute',
      top: 3,
      left: on ? w - k - 3 : 3,
      width: k,
      height: k,
      borderRadius: 999,
      background: '#fff',
      transition: 'left 180ms',
      boxShadow: '0 1px 3px rgba(0,0,0,0.2)'
    }
  }));
}

/* ── FIELD (label + input/textarea) ─────────────────────── */
function Field({
  label,
  value,
  onChange,
  placeholder,
  type = 'text',
  textarea,
  rows = 3,
  hint,
  prefix,
  suffix,
  mono,
  counter,
  max
}) {
  const [foc, setFoc] = React.useState(false);
  const base = {
    width: '100%',
    border: 'none',
    outline: 'none',
    background: 'none',
    fontFamily: mono ? DS.fontMono : DS.fontUI,
    fontSize: 13.5,
    color: DS.fg1,
    resize: 'vertical',
    lineHeight: 1.5
  };
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      gap: 6
    }
  }, label && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'space-between',
      alignItems: 'baseline'
    }
  }, /*#__PURE__*/React.createElement("label", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      fontWeight: 600,
      color: DS.fg2
    }
  }, label), counter && /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontMono,
      fontSize: 11,
      color: (value || '').length > max ? DS.red : DS.fg4
    }
  }, (value || '').length, "/", max)), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: textarea ? 'flex-start' : 'center',
      gap: 8,
      border: `1.5px solid ${foc ? DS.gold : DS.border}`,
      borderRadius: DS.rMd,
      padding: textarea ? '10px 12px' : '0 12px',
      height: textarea ? 'auto' : 38,
      background: DS.surface,
      transition: 'border-color 140ms',
      boxShadow: foc ? `0 0 0 3px ${DS.gold}22` : 'none'
    }
  }, prefix && /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontMono,
      fontSize: 12.5,
      color: DS.fg4,
      whiteSpace: 'nowrap'
    }
  }, prefix), textarea ? /*#__PURE__*/React.createElement("textarea", {
    value: value,
    onChange: e => onChange && onChange(e.target.value),
    placeholder: placeholder,
    rows: rows,
    onFocus: () => setFoc(true),
    onBlur: () => setFoc(false),
    style: base
  }) : /*#__PURE__*/React.createElement("input", {
    value: value,
    onChange: e => onChange && onChange(e.target.value),
    placeholder: placeholder,
    type: type,
    onFocus: () => setFoc(true),
    onBlur: () => setFoc(false),
    style: base
  }), suffix && /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 12.5,
      color: DS.fg4,
      whiteSpace: 'nowrap'
    }
  }, suffix)), hint && /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 11.5,
      color: DS.fg4,
      lineHeight: 1.4
    }
  }, hint));
}

/* ── MODAL ──────────────────────────────────────────────── */
function Modal({
  open,
  onClose,
  title,
  children,
  width = 480,
  footer
}) {
  if (!open) return null;
  return /*#__PURE__*/React.createElement("div", {
    onClick: onClose,
    style: {
      position: 'fixed',
      inset: 0,
      background: 'rgba(20,16,12,0.45)',
      backdropFilter: 'blur(3px)',
      zIndex: 1000,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      padding: 24,
      animation: 'dsFade 160ms ease'
    }
  }, /*#__PURE__*/React.createElement("div", {
    onClick: e => e.stopPropagation(),
    style: {
      background: DS.surface,
      borderRadius: DS.rXl,
      width,
      maxWidth: '100%',
      maxHeight: '88vh',
      overflow: 'hidden',
      boxShadow: DS.shPop,
      display: 'flex',
      flexDirection: 'column',
      animation: 'dsPop 200ms cubic-bezier(0.25,0,0,1)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'space-between',
      padding: '18px 22px',
      borderBottom: `1px solid ${DS.border}`
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: DS.fontDisp,
      fontSize: 19,
      fontWeight: 700,
      color: DS.fg1
    }
  }, title), /*#__PURE__*/React.createElement("button", {
    onClick: onClose,
    style: {
      border: 'none',
      background: 'none',
      cursor: 'pointer',
      color: DS.fg3,
      display: 'flex',
      padding: 4
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: "x",
    size: 20
  }))), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: 22,
      overflowY: 'auto'
    }
  }, children), footer && /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'flex-end',
      gap: 10,
      padding: '16px 22px',
      borderTop: `1px solid ${DS.border}`,
      background: '#FBF9F5'
    }
  }, footer)));
}

/* ── EMPTY STATE ────────────────────────────────────────── */
function EmptyState({
  icon = 'file-text',
  title,
  body,
  action
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexDirection: 'column',
      alignItems: 'center',
      justifyContent: 'center',
      padding: '56px 24px',
      textAlign: 'center'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: 64,
      height: 64,
      borderRadius: DS.rLg,
      background: '#EFEBE3',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      color: DS.fg4,
      marginBottom: 18
    }
  }, /*#__PURE__*/React.createElement(Icon, {
    name: icon,
    size: 28,
    stroke: 1.5
  })), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontDisp,
      fontSize: 20,
      fontWeight: 700,
      color: DS.fg1,
      marginBottom: 6
    }
  }, title), /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: DS.fontUI,
      fontSize: 13.5,
      color: DS.fg3,
      maxWidth: 360,
      lineHeight: 1.6,
      marginBottom: action ? 20 : 0
    }
  }, body), action);
}

/* ── SPINNER ────────────────────────────────────────────── */
function Spinner({
  size = 20,
  color = DS.gold
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      width: size,
      height: size,
      borderRadius: 999,
      border: `${Math.max(2, size / 10)}px solid ${color}33`,
      borderTopColor: color,
      animation: 'dsSpin 0.7s linear infinite'
    }
  });
}

/* ── PROGRESS BAR ───────────────────────────────────────── */
function ProgressBar({
  value,
  color = DS.gold,
  height = 6,
  bg = DS.border
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      width: '100%',
      height,
      borderRadius: 999,
      background: bg,
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      width: `${Math.min(100, value)}%`,
      height: '100%',
      background: color,
      borderRadius: 999,
      transition: 'width 600ms ease'
    }
  }));
}

/* ── SPARKLINE ──────────────────────────────────────────── */
function Sparkline({
  data,
  color = DS.gold,
  width = 90,
  height = 28,
  fill = true
}) {
  const max = Math.max(...data),
    min = Math.min(...data);
  const range = max - min || 1;
  const pts = data.map((d, i) => [i / (data.length - 1) * width, height - (d - min) / range * (height - 4) - 2]);
  const path = pts.map((p, i) => `${i === 0 ? 'M' : 'L'}${p[0].toFixed(1)},${p[1].toFixed(1)}`).join(' ');
  const area = `${path} L${width},${height} L0,${height} Z`;
  const id = 'sg' + Math.random().toString(36).slice(2, 7);
  return /*#__PURE__*/React.createElement("svg", {
    width: width,
    height: height,
    style: {
      display: 'block'
    }
  }, /*#__PURE__*/React.createElement("defs", null, /*#__PURE__*/React.createElement("linearGradient", {
    id: id,
    x1: "0",
    y1: "0",
    x2: "0",
    y2: "1"
  }, /*#__PURE__*/React.createElement("stop", {
    offset: "0%",
    stopColor: color,
    stopOpacity: "0.22"
  }), /*#__PURE__*/React.createElement("stop", {
    offset: "100%",
    stopColor: color,
    stopOpacity: "0"
  }))), fill && /*#__PURE__*/React.createElement("path", {
    d: area,
    fill: `url(#${id})`
  }), /*#__PURE__*/React.createElement("path", {
    d: path,
    fill: "none",
    stroke: color,
    strokeWidth: "2",
    strokeLinecap: "round",
    strokeLinejoin: "round"
  }));
}
Object.assign(window, {
  DS,
  Icon,
  Btn,
  Badge,
  Card,
  StatCard,
  Avatar,
  ScoreRing,
  SegTabs,
  SearchInput,
  Toggle,
  Field,
  Modal,
  EmptyState,
  Spinner,
  ProgressBar,
  Sparkline
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties-cms/components.jsx", error: String((e && e.message) || e) }); }

// ui_kits/debesties-cms/data.jsx
try { (() => {
// Debesties CMS — Mock Data
// Exports to window: POSTS, ACTIVITY, TOP_ARTICLES, CATEGORIES, TAGS, USERS,
//   MEDIA, COMMENTS, TRAFFIC_SOURCES, DECAY, NAV_ITEMS

const NAV_ITEMS = [{
  group: 'Overview',
  items: [{
    key: 'dashboard',
    label: 'Dashboard',
    icon: 'layout-dashboard'
  }, {
    key: 'analytics',
    label: 'Analytics',
    icon: 'bar-chart'
  }, {
    key: 'calendar',
    label: 'Editorial Calendar',
    icon: 'calendar'
  }]
}, {
  group: 'Content',
  items: [{
    key: 'posts',
    label: 'Posts',
    icon: 'file-text',
    count: 248
  }, {
    key: 'pages',
    label: 'Pages',
    icon: 'book-open',
    count: 9
  }, {
    key: 'categories',
    label: 'Categories',
    icon: 'folder'
  }, {
    key: 'tags',
    label: 'Tags',
    icon: 'tag'
  }, {
    key: 'media',
    label: 'Media Library',
    icon: 'image'
  }, {
    key: 'comments',
    label: 'Comments',
    icon: 'message-square',
    count: 12
  }, {
    key: 'subscribers',
    label: 'Subscribers',
    icon: 'send',
    count: '12.8K'
  }]
}, {
  group: 'Optimize',
  items: [{
    key: 'seo',
    label: 'SEO Tools',
    icon: 'search-check'
  }, {
    key: 'ai',
    label: 'AI Visibility',
    icon: 'sparkles',
    badge: 'AI'
  }]
}, {
  group: 'Site',
  items: [{
    key: 'navbuilder',
    label: 'Navigation Builder',
    icon: 'list'
  }, {
    key: 'homebuilder',
    label: 'Homepage Builder',
    icon: 'home'
  }, {
    key: 'users',
    label: 'Users & Roles',
    icon: 'users'
  }, {
    key: 'settings',
    label: 'Site Settings',
    icon: 'settings'
  }]
}];
const POSTS = [{
  id: 1,
  title: 'The Elite Club: 4 Artists Who Dominated the TGMAs',
  slug: 'elite-club-tgma-double-winners',
  status: 'published',
  author: 'Ama Boateng',
  category: 'Awards History',
  tags: ['TGMA', 'Sarkodie', 'Stonebwoy'],
  seo: 92,
  views: 48200,
  updated: '2h ago',
  date: 'May 27, 2026',
  featured: true,
  grad: 'linear-gradient(135deg,#1A1410,#4D3000)'
}, {
  id: 2,
  title: 'Black Sherif\u2019s Second Crown: Legacy Cemented',
  slug: 'black-sherif-second-crown',
  status: 'published',
  author: 'Kwesi Mensah',
  category: 'Profiles',
  tags: ['Black Sherif', 'Afrobeats'],
  seo: 88,
  views: 31400,
  updated: '5h ago',
  date: 'May 20, 2026',
  grad: 'linear-gradient(135deg,#450A0A,#1A1410)'
}, {
  id: 3,
  title: 'TGMA 2026: Full Winners List & Analysis',
  slug: 'tgma-2026-winners-list',
  status: 'scheduled',
  author: 'Ama Boateng',
  category: 'Awards History',
  tags: ['TGMA 2026'],
  seo: 71,
  views: 0,
  updated: '1d ago',
  date: 'Jun 12, 2026',
  grad: 'linear-gradient(135deg,#1A5C2E,#0E381B)'
}, {
  id: 4,
  title: 'The 2019 Annulment: What Really Happened?',
  slug: '2019-tgma-annulment-explained',
  status: 'review',
  author: 'Yaw Owusu',
  category: 'Analysis',
  tags: ['TGMA', 'Controversy'],
  seo: 64,
  views: 0,
  updated: '3h ago',
  date: 'Draft',
  grad: 'linear-gradient(135deg,#3D3529,#7A4F00)'
}, {
  id: 5,
  title: 'King Promise\u2019s 2025 Win: A New Chapter for Highlife',
  slug: 'king-promise-2025-win',
  status: 'published',
  author: 'Kwesi Mensah',
  category: 'Profiles',
  tags: ['King Promise', 'Highlife'],
  seo: 79,
  views: 22100,
  updated: '2d ago',
  date: 'Mar 3, 2026',
  grad: 'linear-gradient(135deg,#0E381B,#1A8A4B)'
}, {
  id: 6,
  title: 'Sarkodie vs Stonebwoy: The Numbers Behind the Rivalry',
  slug: 'sarkodie-stonebwoy-stats',
  status: 'draft',
  author: 'Yaw Owusu',
  category: 'Analysis',
  tags: ['Sarkodie', 'Stonebwoy', 'Data'],
  seo: 41,
  views: 0,
  updated: '4d ago',
  date: 'Draft',
  grad: 'linear-gradient(135deg,#1A1410,#2C241B)'
}, {
  id: 7,
  title: 'Every Hiplife Winner That Defined an Era',
  slug: 'hiplife-era-tgma-winners',
  status: 'published',
  author: 'Ama Boateng',
  category: 'Awards History',
  tags: ['Hiplife', 'VIP', 'Obour'],
  seo: 85,
  views: 18700,
  updated: '1w ago',
  date: 'Feb 14, 2026',
  grad: 'linear-gradient(135deg,#4D3000,#A06C00)'
}, {
  id: 8,
  title: 'Diana Hamilton & The Rise of Gospel at the TGMAs',
  slug: 'diana-hamilton-gospel-tgma',
  status: 'published',
  author: 'Esi Arthur',
  category: 'Profiles',
  tags: ['Diana Hamilton', 'Gospel'],
  seo: 76,
  views: 14300,
  updated: '1w ago',
  date: 'Jan 28, 2026',
  grad: 'linear-gradient(135deg,#1A5C2E,#22A35A)'
}, {
  id: 9,
  title: 'V.I.P: The Group That Started It All',
  slug: 'vip-group-tgma-legacy',
  status: 'archived',
  author: 'Yaw Owusu',
  category: 'Profiles',
  tags: ['VIP', 'Hiplife'],
  seo: 68,
  views: 9800,
  updated: '3w ago',
  date: 'Jan 8, 2026',
  grad: 'linear-gradient(135deg,#2C241B,#4D3000)'
}, {
  id: 10,
  title: 'How TGMA Voting Actually Works in 2026',
  slug: 'tgma-voting-explained-2026',
  status: 'draft',
  author: 'Esi Arthur',
  category: 'Explainers',
  tags: ['TGMA', 'Voting'],
  seo: 33,
  views: 0,
  updated: '5d ago',
  date: 'Draft',
  grad: 'linear-gradient(135deg,#17120D,#3D3529)'
}];
const ACTIVITY = [{
  who: 'Ama Boateng',
  action: 'published',
  target: 'The Elite Club: 4 Artists Who Dominated…',
  time: '2h ago',
  type: 'published'
}, {
  who: 'Yaw Owusu',
  action: 'submitted for review',
  target: 'The 2019 Annulment: What Really Happened?',
  time: '3h ago',
  type: 'review'
}, {
  who: 'Kwesi Mensah',
  action: 'updated',
  target: 'Black Sherif\u2019s Second Crown',
  time: '5h ago',
  type: 'draft'
}, {
  who: 'Esi Arthur',
  action: 'left a comment on',
  target: 'How TGMA Voting Actually Works',
  time: '6h ago',
  type: 'review'
}, {
  who: 'Ama Boateng',
  action: 'scheduled',
  target: 'TGMA 2026: Full Winners List',
  time: '1d ago',
  type: 'scheduled'
}, {
  who: 'System',
  action: 'flagged decay on',
  target: 'V.I.P: The Group That Started It All',
  time: '1d ago',
  type: 'decay'
}];
const TOP_ARTICLES = [{
  title: 'The Elite Club: 4 Artists Who Dominated the TGMAs',
  views: 48200,
  trend: [12, 18, 15, 22, 28, 35, 48],
  up: '+34%'
}, {
  title: 'Black Sherif\u2019s Second Crown: Legacy Cemented',
  views: 31400,
  trend: [20, 22, 19, 25, 28, 30, 31],
  up: '+12%'
}, {
  title: 'King Promise\u2019s 2025 Win: A New Chapter',
  views: 22100,
  trend: [28, 26, 24, 22, 20, 21, 22],
  up: '\u22125%'
}, {
  title: 'Every Hiplife Winner That Defined an Era',
  views: 18700,
  trend: [10, 12, 14, 15, 16, 18, 18],
  up: '+22%'
}, {
  title: 'Diana Hamilton & The Rise of Gospel',
  views: 14300,
  trend: [8, 9, 11, 12, 13, 14, 14],
  up: '+18%'
}];
const TRENDING_CATS = [{
  name: 'Awards History',
  share: 38,
  views: '142K',
  color: '#E8A800'
}, {
  name: 'Profiles',
  share: 27,
  views: '98K',
  color: '#1A8A4B'
}, {
  name: 'Analysis',
  share: 19,
  views: '71K',
  color: '#2F6BD8'
}, {
  name: 'Explainers',
  share: 11,
  views: '40K',
  color: '#B14FD8'
}, {
  name: 'News',
  share: 5,
  views: '19K',
  color: '#C8372B'
}];
const DECAY = [{
  title: 'V.I.P: The Group That Started It All',
  drop: '\u221242%',
  lastUpdate: '3 weeks ago',
  reason: 'Traffic decline + outdated stats'
}, {
  title: 'How TGMA Voting Works (2024 edition)',
  drop: '\u221238%',
  lastUpdate: '8 months ago',
  reason: 'Superseded by 2026 rules'
}, {
  title: 'Top 10 Ghanaian Songs of 2023',
  drop: '\u221229%',
  lastUpdate: '14 months ago',
  reason: 'Seasonal relevance lost'
}];
const CATEGORIES = [{
  name: 'Awards History',
  slug: 'awards-history',
  posts: 64,
  color: '#E8A800',
  desc: 'TGMA/VGMA winners, records & milestones'
}, {
  name: 'Profiles',
  slug: 'profiles',
  posts: 52,
  color: '#1A8A4B',
  desc: 'Artist deep-dives and career retrospectives'
}, {
  name: 'Analysis',
  slug: 'analysis',
  posts: 38,
  color: '#2F6BD8',
  desc: 'Data-driven takes on the Ghanaian music scene'
}, {
  name: 'Explainers',
  slug: 'explainers',
  posts: 29,
  color: '#B14FD8',
  desc: 'How the industry & awards actually work'
}, {
  name: 'News',
  slug: 'news',
  posts: 41,
  color: '#C8372B',
  desc: 'Breaking updates and announcements'
}, {
  name: 'Interviews',
  slug: 'interviews',
  posts: 24,
  color: '#0E5C30',
  desc: 'Conversations with artists & industry figures'
}];
const TAGS = [{
  name: 'TGMA',
  count: 84
}, {
  name: 'Sarkodie',
  count: 47
}, {
  name: 'Stonebwoy',
  count: 39
}, {
  name: 'Black Sherif',
  count: 31
}, {
  name: 'Afrobeats',
  count: 56
}, {
  name: 'Hiplife',
  count: 44
}, {
  name: 'Highlife',
  count: 38
}, {
  name: 'King Promise',
  count: 22
}, {
  name: 'VIP',
  count: 18
}, {
  name: 'Gospel',
  count: 27
}, {
  name: 'Shatta Wale',
  count: 33
}, {
  name: 'Diana Hamilton',
  count: 14
}, {
  name: 'Awards',
  count: 61
}, {
  name: 'Data',
  count: 19
}, {
  name: 'Controversy',
  count: 12
}, {
  name: 'Azonto',
  count: 9
}, {
  name: 'Drill',
  count: 16
}, {
  name: 'Kuami Eugene',
  count: 21
}];
const USERS = [{
  name: 'Ama Boateng',
  email: 'ama@debesties.com',
  role: 'Admin',
  posts: 86,
  status: 'active',
  last: 'Online now'
}, {
  name: 'Kwesi Mensah',
  email: 'kwesi@debesties.com',
  role: 'Editor',
  posts: 64,
  status: 'active',
  last: '20m ago'
}, {
  name: 'Yaw Owusu',
  email: 'yaw@debesties.com',
  role: 'Author',
  posts: 41,
  status: 'active',
  last: '2h ago'
}, {
  name: 'Esi Arthur',
  email: 'esi@debesties.com',
  role: 'Author',
  posts: 33,
  status: 'active',
  last: '5h ago'
}, {
  name: 'Kojo Asante',
  email: 'kojo@debesties.com',
  role: 'SEO Manager',
  posts: 8,
  status: 'active',
  last: '1d ago'
}, {
  name: 'Nana Adwoa',
  email: 'nana@debesties.com',
  role: 'Contributor',
  posts: 12,
  status: 'invited',
  last: 'Pending'
}, {
  name: 'Fiifi Hayford',
  email: 'fiifi@debesties.com',
  role: 'Media Manager',
  posts: 0,
  status: 'active',
  last: '3d ago'
}];
const ROLES = [{
  name: 'Admin',
  count: 1,
  color: '#C8372B',
  perms: 'Full access — settings, users, billing, publishing'
}, {
  name: 'Editor',
  count: 2,
  color: '#E8A800',
  perms: 'Edit & publish all posts, manage categories'
}, {
  name: 'Author',
  count: 4,
  color: '#1A8A4B',
  perms: 'Create & publish own posts, upload media'
}, {
  name: 'Contributor',
  count: 3,
  color: '#2F6BD8',
  perms: 'Write drafts, submit for review (no publish)'
}, {
  name: 'SEO Manager',
  count: 1,
  color: '#B14FD8',
  perms: 'Edit SEO fields, schema, internal links'
}, {
  name: 'Media Manager',
  count: 1,
  color: '#0E5C30',
  perms: 'Upload, organize & optimize media library'
}];
const MEDIA = Array.from({
  length: 12
}, (_, i) => {
  const grads = ['linear-gradient(135deg,#1A1410,#4D3000)', 'linear-gradient(135deg,#1A5C2E,#0E381B)', 'linear-gradient(135deg,#450A0A,#1A1410)', 'linear-gradient(135deg,#2C241B,#A06C00)', 'linear-gradient(135deg,#0E381B,#1A8A4B)', 'linear-gradient(135deg,#3B5BDB,#B14FD8)'];
  const names = ['black-sherif-stage', 'tgma-trophy', 'sarkodie-portrait', 'stonebwoy-live', 'king-promise-cover', 'vip-archive', 'diana-hamilton', 'studio-session', 'awards-night', 'hiplife-vinyl', 'crowd-accra', 'backstage'];
  return {
    id: i + 1,
    name: names[i] + '.jpg',
    grad: grads[i % grads.length],
    size: (1.2 + Math.random() * 3).toFixed(1) + ' MB',
    dims: '1920×1080',
    type: i % 5 === 0 ? 'PNG' : 'JPG'
  };
});
const COMMENTS = [{
  author: 'MusicFan_GH',
  avatar: 'M',
  text: 'V.I.P winning twice is criminally underrated. Great breakdown!',
  post: 'The Elite Club',
  time: '1h ago',
  status: 'pending'
}, {
  author: 'AccraBeats',
  avatar: 'A',
  text: 'You forgot to mention the 2008 nominees though.',
  post: 'Hiplife Winners',
  time: '3h ago',
  status: 'pending'
}, {
  author: 'KofiListens',
  avatar: 'K',
  text: 'Black Sherif deserved both wins no debate.',
  post: 'Second Crown',
  time: '5h ago',
  status: 'approved'
}, {
  author: 'Spam Bot 9000',
  avatar: 'S',
  text: 'Buy cheap followers click here >>>',
  post: 'TGMA 2026',
  time: '6h ago',
  status: 'spam'
}];
const TRAFFIC_SOURCES = [{
  name: 'Organic Search',
  pct: 54,
  color: '#1A8A4B'
}, {
  name: 'Direct',
  pct: 21,
  color: '#E8A800'
}, {
  name: 'Social',
  pct: 16,
  color: '#2F6BD8'
}, {
  name: 'AI Assistants',
  pct: 6,
  color: '#B14FD8'
}, {
  name: 'Referral',
  pct: 3,
  color: '#C8372B'
}];
const SEARCH_QUERIES = [{
  q: 'who won artiste of the year ghana',
  pos: 1,
  clicks: 8420,
  imp: 42100,
  ctr: '20.0%'
}, {
  q: 'tgma double winners',
  pos: 2,
  clicks: 5210,
  imp: 31800,
  ctr: '16.4%'
}, {
  q: 'black sherif awards',
  pos: 3,
  clicks: 3940,
  imp: 28400,
  ctr: '13.9%'
}, {
  q: 'sarkodie tgma history',
  pos: 4,
  clicks: 2180,
  imp: 19600,
  ctr: '11.1%'
}, {
  q: '2019 vgma annulled',
  pos: 2,
  clicks: 1890,
  imp: 14200,
  ctr: '13.3%'
}];
const PAGES = [{
  id: 1,
  title: 'About Debesties',
  slug: 'about',
  status: 'published',
  updated: '2w ago',
  author: 'Ama Boateng',
  template: 'Standard',
  views: 8400,
  inNav: true
}, {
  id: 2,
  title: 'Contact',
  slug: 'contact',
  status: 'published',
  updated: '1mo ago',
  author: 'Ama Boateng',
  template: 'Contact form',
  views: 3200,
  inNav: true
}, {
  id: 3,
  title: 'Editorial Standards',
  slug: 'editorial-standards',
  status: 'published',
  updated: '3w ago',
  author: 'Kwesi Mensah',
  template: 'Standard',
  views: 1900,
  inNav: false
}, {
  id: 4,
  title: 'Advertise With Us',
  slug: 'advertise',
  status: 'published',
  updated: '2mo ago',
  author: 'Ama Boateng',
  template: 'Landing',
  views: 1100,
  inNav: true
}, {
  id: 5,
  title: 'The TGMA Archive',
  slug: 'tgma-archive',
  status: 'published',
  updated: '4d ago',
  author: 'Yaw Owusu',
  template: 'Timeline',
  views: 21400,
  inNav: true
}, {
  id: 6,
  title: 'Privacy Policy',
  slug: 'privacy-policy',
  status: 'published',
  updated: '6mo ago',
  author: 'Ama Boateng',
  template: 'Legal',
  views: 640,
  inNav: false
}, {
  id: 7,
  title: 'Terms of Service',
  slug: 'terms',
  status: 'published',
  updated: '6mo ago',
  author: 'Ama Boateng',
  template: 'Legal',
  views: 410,
  inNav: false
}, {
  id: 8,
  title: 'Meet the Team',
  slug: 'team',
  status: 'draft',
  updated: '5d ago',
  author: 'Esi Arthur',
  template: 'Team grid',
  views: 0,
  inNav: false
}, {
  id: 9,
  title: 'Newsletter Archive',
  slug: 'newsletter',
  status: 'scheduled',
  updated: '1d ago',
  author: 'Kwesi Mensah',
  template: 'Standard',
  views: 0,
  inNav: false
}];
const SUBSCRIBERS = [{
  id: 1,
  email: 'kwame.asante@gmail.com',
  name: 'Kwame Asante',
  status: 'active',
  source: 'Article CTA',
  joined: 'Jun 6, 2026',
  opens: 94
}, {
  id: 2,
  email: 'abena.o@yahoo.com',
  name: 'Abena Owusu',
  status: 'active',
  source: 'Homepage',
  joined: 'Jun 5, 2026',
  opens: 88
}, {
  id: 3,
  email: 'dj.fiifi@outlook.com',
  name: 'Fiifi Mensah',
  status: 'active',
  source: 'Article CTA',
  joined: 'Jun 3, 2026',
  opens: 76
}, {
  id: 4,
  email: 'naa.dedei@gmail.com',
  name: 'Naa Dedei',
  status: 'pending',
  source: 'Pop-up',
  joined: 'Jun 9, 2026',
  opens: 0
}, {
  id: 5,
  email: 'kojo.b@icloud.com',
  name: 'Kojo Boateng',
  status: 'active',
  source: 'Timeline page',
  joined: 'May 28, 2026',
  opens: 62
}, {
  id: 6,
  email: 'ama.serwaa@gmail.com',
  name: 'Ama Serwaa',
  status: 'active',
  source: 'Homepage',
  joined: 'May 24, 2026',
  opens: 81
}, {
  id: 7,
  email: 'old.address@hotmail.com',
  name: 'Yaw Darko',
  status: 'unsubscribed',
  source: 'Article CTA',
  joined: 'Jan 12, 2026',
  opens: 8
}, {
  id: 8,
  email: 'esi.t@gmail.com',
  name: 'Esi Tetteh',
  status: 'active',
  source: 'Pop-up',
  joined: 'May 19, 2026',
  opens: 70
}, {
  id: 9,
  email: 'bounce@deadmail.xyz',
  name: '—',
  status: 'bounced',
  source: 'Import',
  joined: 'Apr 2, 2026',
  opens: 0
}, {
  id: 10,
  email: 'nana.akua@gmail.com',
  name: 'Nana Akua',
  status: 'active',
  source: 'Homepage',
  joined: 'May 11, 2026',
  opens: 90
}];
const CAMPAIGNS = [{
  id: 1,
  subject: 'TGMA 2026: Every Winner, One Page',
  sent: 'Jun 2, 2026',
  recipients: 12840,
  openRate: 58,
  clickRate: 22,
  status: 'sent'
}, {
  id: 2,
  subject: 'The Elite Club — 4 Artists Who Won Twice',
  sent: 'May 26, 2026',
  recipients: 12410,
  openRate: 64,
  clickRate: 31,
  status: 'sent'
}, {
  id: 3,
  subject: 'Weekly Digest: Black Sherif’s Second Crown',
  sent: 'May 19, 2026',
  recipients: 12180,
  openRate: 51,
  clickRate: 18,
  status: 'sent'
}, {
  id: 4,
  subject: 'Mid-Year Music Report (Draft)',
  sent: 'Scheduled Jun 16',
  recipients: 0,
  openRate: 0,
  clickRate: 0,
  status: 'scheduled'
}];

// Per-post revision history (used in the editor)
const REVISIONS = [{
  id: 6,
  author: 'Ama Boateng',
  time: '2 hours ago',
  label: 'Current version',
  words: 1840,
  change: '+0',
  current: true
}, {
  id: 5,
  author: 'Ama Boateng',
  time: 'Today, 9:14 AM',
  label: 'Added FAQ schema block',
  words: 1840,
  change: '+120'
}, {
  id: 4,
  author: 'Kwesi Mensah',
  time: 'Yesterday, 4:32 PM',
  label: 'Editor revisions to intro',
  words: 1720,
  change: '+45'
}, {
  id: 3,
  author: 'Ama Boateng',
  time: 'Jun 5, 2026',
  label: 'Updated 2026 winner stats',
  words: 1675,
  change: '+210'
}, {
  id: 2,
  author: 'Yaw Owusu',
  time: 'Jun 3, 2026',
  label: 'First full draft',
  words: 1465,
  change: '+1465'
}, {
  id: 1,
  author: 'Ama Boateng',
  time: 'Jun 2, 2026',
  label: 'Created post',
  words: 0,
  change: '+0'
}];
Object.assign(window, {
  NAV_ITEMS,
  POSTS,
  PAGES,
  SUBSCRIBERS,
  CAMPAIGNS,
  REVISIONS,
  ACTIVITY,
  TOP_ARTICLES,
  TRENDING_CATS,
  DECAY,
  CATEGORIES,
  TAGS,
  USERS,
  ROLES,
  MEDIA,
  COMMENTS,
  TRAFFIC_SOURCES,
  SEARCH_QUERIES
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties-cms/data.jsx", error: String((e && e.message) || e) }); }

// ui_kits/debesties-cms/tweaks-panel.jsx
try { (() => {
// @ds-adherence-ignore -- omelette starter scaffold (raw elements/hex/px by design)

/* BEGIN USAGE */
// tweaks-panel.jsx
// Reusable Tweaks shell + form-control helpers.
// Exports (to window): useTweaks, TweaksPanel, TweakSection, TweakRow, TweakSlider,
//   TweakToggle, TweakRadio, TweakSelect, TweakText, TweakNumber, TweakColor, TweakButton.
//
// Owns the host protocol (listens for __activate_edit_mode / __deactivate_edit_mode,
// posts __edit_mode_available / __edit_mode_set_keys / __edit_mode_dismissed) so
// individual prototypes don't re-roll it. Ships a consistent set of controls so you
// don't hand-draw <input type="range">, segmented radios, steppers, etc.
//
// Usage (in an HTML file that loads React + Babel):
//
//   const TWEAK_DEFAULTS = /*EDITMODE-BEGIN*/{
//     "primaryColor": "#D97757",
//     "palette": ["#D97757", "#29261b", "#f6f4ef"],
//     "fontSize": 16,
//     "density": "regular",
//     "dark": false
//   }/*EDITMODE-END*/;
//
//   function App() {
//     const [t, setTweak] = useTweaks(TWEAK_DEFAULTS);
//     return (
//       <div style={{ fontSize: t.fontSize, color: t.primaryColor }}>
//         Hello
//         <TweaksPanel>
//           <TweakSection label="Typography" />
//           <TweakSlider label="Font size" value={t.fontSize} min={10} max={32} unit="px"
//                        onChange={(v) => setTweak('fontSize', v)} />
//           <TweakRadio  label="Density" value={t.density}
//                        options={['compact', 'regular', 'comfy']}
//                        onChange={(v) => setTweak('density', v)} />
//           <TweakSection label="Theme" />
//           <TweakColor  label="Primary" value={t.primaryColor}
//                        options={['#D97757', '#2A6FDB', '#1F8A5B', '#7A5AE0']}
//                        onChange={(v) => setTweak('primaryColor', v)} />
//           <TweakColor  label="Palette" value={t.palette}
//                        options={[['#D97757', '#29261b', '#f6f4ef'],
//                                  ['#475569', '#0f172a', '#f1f5f9']]}
//                        onChange={(v) => setTweak('palette', v)} />
//           <TweakToggle label="Dark mode" value={t.dark}
//                        onChange={(v) => setTweak('dark', v)} />
//         </TweaksPanel>
//       </div>
//     );
//   }
//
// TweakRadio is the segmented control for 2–3 short options (auto-falls-back to
// TweakSelect past ~16/~10 chars per label); reach for TweakSelect directly when
// options are many or long. For color tweaks always curate 3-4 options rather than
// a free picker; an option can also be a whole 2–5 color palette (the stored value
// is the array). The Tweak* controls are a floor, not a ceiling — build custom
// controls inside the panel if a tweak calls for UI they don't cover.
/* END USAGE */
// ─────────────────────────────────────────────────────────────────────────────

const __TWEAKS_STYLE = `
  .twk-panel{position:fixed;right:16px;bottom:16px;z-index:2147483646;width:280px;
    max-height:calc(100vh - 32px);display:flex;flex-direction:column;
    transform:scale(var(--dc-inv-zoom,1));transform-origin:bottom right;
    background:rgba(250,249,247,.78);color:#29261b;
    -webkit-backdrop-filter:blur(24px) saturate(160%);backdrop-filter:blur(24px) saturate(160%);
    border:.5px solid rgba(255,255,255,.6);border-radius:14px;
    box-shadow:0 1px 0 rgba(255,255,255,.5) inset,0 12px 40px rgba(0,0,0,.18);
    font:11.5px/1.4 ui-sans-serif,system-ui,-apple-system,sans-serif;overflow:hidden}
  .twk-hd{display:flex;align-items:center;justify-content:space-between;
    padding:10px 8px 10px 14px;cursor:move;user-select:none}
  .twk-hd b{font-size:12px;font-weight:600;letter-spacing:.01em}
  .twk-x{appearance:none;border:0;background:transparent;color:rgba(41,38,27,.55);
    width:22px;height:22px;border-radius:6px;cursor:default;font-size:13px;line-height:1}
  .twk-x:hover{background:rgba(0,0,0,.06);color:#29261b}
  .twk-body{padding:2px 14px 14px;display:flex;flex-direction:column;gap:10px;
    overflow-y:auto;overflow-x:hidden;min-height:0;
    scrollbar-width:thin;scrollbar-color:rgba(0,0,0,.15) transparent}
  .twk-body::-webkit-scrollbar{width:8px}
  .twk-body::-webkit-scrollbar-track{background:transparent;margin:2px}
  .twk-body::-webkit-scrollbar-thumb{background:rgba(0,0,0,.15);border-radius:4px;
    border:2px solid transparent;background-clip:content-box}
  .twk-body::-webkit-scrollbar-thumb:hover{background:rgba(0,0,0,.25);
    border:2px solid transparent;background-clip:content-box}
  .twk-row{display:flex;flex-direction:column;gap:5px}
  .twk-row-h{flex-direction:row;align-items:center;justify-content:space-between;gap:10px}
  .twk-lbl{display:flex;justify-content:space-between;align-items:baseline;
    color:rgba(41,38,27,.72)}
  .twk-lbl>span:first-child{font-weight:500}
  .twk-val{color:rgba(41,38,27,.5);font-variant-numeric:tabular-nums}

  .twk-sect{font-size:10px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;
    color:rgba(41,38,27,.45);padding:10px 0 0}
  .twk-sect:first-child{padding-top:0}

  .twk-field{appearance:none;box-sizing:border-box;width:100%;min-width:0;height:26px;padding:0 8px;
    border:.5px solid rgba(0,0,0,.1);border-radius:7px;
    background:rgba(255,255,255,.6);color:inherit;font:inherit;outline:none}
  .twk-field:focus{border-color:rgba(0,0,0,.25);background:rgba(255,255,255,.85)}
  select.twk-field{padding-right:22px;
    background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'><path fill='rgba(0,0,0,.5)' d='M0 0h10L5 6z'/></svg>");
    background-repeat:no-repeat;background-position:right 8px center}

  .twk-slider{appearance:none;-webkit-appearance:none;width:100%;height:4px;margin:6px 0;
    border-radius:999px;background:rgba(0,0,0,.12);outline:none}
  .twk-slider::-webkit-slider-thumb{-webkit-appearance:none;appearance:none;
    width:14px;height:14px;border-radius:50%;background:#fff;
    border:.5px solid rgba(0,0,0,.12);box-shadow:0 1px 3px rgba(0,0,0,.2);cursor:default}
  .twk-slider::-moz-range-thumb{width:14px;height:14px;border-radius:50%;
    background:#fff;border:.5px solid rgba(0,0,0,.12);box-shadow:0 1px 3px rgba(0,0,0,.2);cursor:default}

  .twk-seg{position:relative;display:flex;padding:2px;border-radius:8px;
    background:rgba(0,0,0,.06);user-select:none}
  .twk-seg-thumb{position:absolute;top:2px;bottom:2px;border-radius:6px;
    background:rgba(255,255,255,.9);box-shadow:0 1px 2px rgba(0,0,0,.12);
    transition:left .15s cubic-bezier(.3,.7,.4,1),width .15s}
  .twk-seg.dragging .twk-seg-thumb{transition:none}
  .twk-seg button{appearance:none;position:relative;z-index:1;flex:1;border:0;
    background:transparent;color:inherit;font:inherit;font-weight:500;min-height:22px;
    border-radius:6px;cursor:default;padding:4px 6px;line-height:1.2;
    overflow-wrap:anywhere}

  .twk-toggle{position:relative;width:32px;height:18px;border:0;border-radius:999px;
    background:rgba(0,0,0,.15);transition:background .15s;cursor:default;padding:0}
  .twk-toggle[data-on="1"]{background:#34c759}
  .twk-toggle i{position:absolute;top:2px;left:2px;width:14px;height:14px;border-radius:50%;
    background:#fff;box-shadow:0 1px 2px rgba(0,0,0,.25);transition:transform .15s}
  .twk-toggle[data-on="1"] i{transform:translateX(14px)}

  .twk-num{display:flex;align-items:center;box-sizing:border-box;min-width:0;height:26px;padding:0 0 0 8px;
    border:.5px solid rgba(0,0,0,.1);border-radius:7px;background:rgba(255,255,255,.6)}
  .twk-num-lbl{font-weight:500;color:rgba(41,38,27,.6);cursor:ew-resize;
    user-select:none;padding-right:8px}
  .twk-num input{flex:1;min-width:0;height:100%;border:0;background:transparent;
    font:inherit;font-variant-numeric:tabular-nums;text-align:right;padding:0 8px 0 0;
    outline:none;color:inherit;-moz-appearance:textfield}
  .twk-num input::-webkit-inner-spin-button,.twk-num input::-webkit-outer-spin-button{
    -webkit-appearance:none;margin:0}
  .twk-num-unit{padding-right:8px;color:rgba(41,38,27,.45)}

  .twk-btn{appearance:none;height:26px;padding:0 12px;border:0;border-radius:7px;
    background:rgba(0,0,0,.78);color:#fff;font:inherit;font-weight:500;cursor:default}
  .twk-btn:hover{background:rgba(0,0,0,.88)}
  .twk-btn.secondary{background:rgba(0,0,0,.06);color:inherit}
  .twk-btn.secondary:hover{background:rgba(0,0,0,.1)}

  .twk-swatch{appearance:none;-webkit-appearance:none;width:56px;height:22px;
    border:.5px solid rgba(0,0,0,.1);border-radius:6px;padding:0;cursor:default;
    background:transparent;flex-shrink:0}
  .twk-swatch::-webkit-color-swatch-wrapper{padding:0}
  .twk-swatch::-webkit-color-swatch{border:0;border-radius:5.5px}
  .twk-swatch::-moz-color-swatch{border:0;border-radius:5.5px}

  .twk-chips{display:flex;gap:6px}
  .twk-chip{position:relative;appearance:none;flex:1;min-width:0;height:46px;
    padding:0;border:0;border-radius:6px;overflow:hidden;cursor:default;
    box-shadow:0 0 0 .5px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.06);
    transition:transform .12s cubic-bezier(.3,.7,.4,1),box-shadow .12s}
  .twk-chip:hover{transform:translateY(-1px);
    box-shadow:0 0 0 .5px rgba(0,0,0,.18),0 4px 10px rgba(0,0,0,.12)}
  .twk-chip[data-on="1"]{box-shadow:0 0 0 1.5px rgba(0,0,0,.85),
    0 2px 6px rgba(0,0,0,.15)}
  .twk-chip>span{position:absolute;top:0;bottom:0;right:0;width:34%;
    display:flex;flex-direction:column;box-shadow:-1px 0 0 rgba(0,0,0,.1)}
  .twk-chip>span>i{flex:1;box-shadow:0 -1px 0 rgba(0,0,0,.1)}
  .twk-chip>span>i:first-child{box-shadow:none}
  .twk-chip svg{position:absolute;top:6px;left:6px;width:13px;height:13px;
    filter:drop-shadow(0 1px 1px rgba(0,0,0,.3))}
`;

// ── useTweaks ───────────────────────────────────────────────────────────────
// Single source of truth for tweak values. setTweak persists via the host
// (__edit_mode_set_keys → host rewrites the EDITMODE block on disk).
function useTweaks(defaults) {
  const [values, setValues] = React.useState(defaults);
  // Accepts either setTweak('key', value) or setTweak({ key: value, ... }) so a
  // useState-style call doesn't write a "[object Object]" key into the persisted
  // JSON block.
  const setTweak = React.useCallback((keyOrEdits, val) => {
    const edits = typeof keyOrEdits === 'object' && keyOrEdits !== null ? keyOrEdits : {
      [keyOrEdits]: val
    };
    setValues(prev => ({
      ...prev,
      ...edits
    }));
    window.parent.postMessage({
      type: '__edit_mode_set_keys',
      edits
    }, '*');
    // Same-window signal so in-page listeners (deck-stage rail thumbnails)
    // can react — the parent message only reaches the host, not peers.
    window.dispatchEvent(new CustomEvent('tweakchange', {
      detail: edits
    }));
  }, []);
  return [values, setTweak];
}

// ── TweaksPanel ─────────────────────────────────────────────────────────────
// Floating shell. Registers the protocol listener BEFORE announcing
// availability — if the announce ran first, the host's activate could land
// before our handler exists and the toolbar toggle would silently no-op.
// The close button posts __edit_mode_dismissed so the host's toolbar toggle
// flips off in lockstep; the host echoes __deactivate_edit_mode back which
// is what actually hides the panel.
function TweaksPanel({
  title = 'Tweaks',
  children
}) {
  const [open, setOpen] = React.useState(false);
  const dragRef = React.useRef(null);
  const offsetRef = React.useRef({
    x: 16,
    y: 16
  });
  const PAD = 16;
  const clampToViewport = React.useCallback(() => {
    const panel = dragRef.current;
    if (!panel) return;
    const w = panel.offsetWidth,
      h = panel.offsetHeight;
    const maxRight = Math.max(PAD, window.innerWidth - w - PAD);
    const maxBottom = Math.max(PAD, window.innerHeight - h - PAD);
    offsetRef.current = {
      x: Math.min(maxRight, Math.max(PAD, offsetRef.current.x)),
      y: Math.min(maxBottom, Math.max(PAD, offsetRef.current.y))
    };
    panel.style.right = offsetRef.current.x + 'px';
    panel.style.bottom = offsetRef.current.y + 'px';
  }, []);
  React.useEffect(() => {
    if (!open) return;
    clampToViewport();
    if (typeof ResizeObserver === 'undefined') {
      window.addEventListener('resize', clampToViewport);
      return () => window.removeEventListener('resize', clampToViewport);
    }
    const ro = new ResizeObserver(clampToViewport);
    ro.observe(document.documentElement);
    return () => ro.disconnect();
  }, [open, clampToViewport]);
  React.useEffect(() => {
    const onMsg = e => {
      const t = e?.data?.type;
      if (t === '__activate_edit_mode') setOpen(true);else if (t === '__deactivate_edit_mode') setOpen(false);
    };
    window.addEventListener('message', onMsg);
    window.parent.postMessage({
      type: '__edit_mode_available'
    }, '*');
    return () => window.removeEventListener('message', onMsg);
  }, []);
  const dismiss = () => {
    setOpen(false);
    window.parent.postMessage({
      type: '__edit_mode_dismissed'
    }, '*');
  };
  const onDragStart = e => {
    const panel = dragRef.current;
    if (!panel) return;
    const r = panel.getBoundingClientRect();
    const sx = e.clientX,
      sy = e.clientY;
    const startRight = window.innerWidth - r.right;
    const startBottom = window.innerHeight - r.bottom;
    const move = ev => {
      offsetRef.current = {
        x: startRight - (ev.clientX - sx),
        y: startBottom - (ev.clientY - sy)
      };
      clampToViewport();
    };
    const up = () => {
      window.removeEventListener('mousemove', move);
      window.removeEventListener('mouseup', up);
    };
    window.addEventListener('mousemove', move);
    window.addEventListener('mouseup', up);
  };
  if (!open) return null;
  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("style", null, __TWEAKS_STYLE), /*#__PURE__*/React.createElement("div", {
    ref: dragRef,
    className: "twk-panel",
    "data-omelette-chrome": "",
    style: {
      right: offsetRef.current.x,
      bottom: offsetRef.current.y
    }
  }, /*#__PURE__*/React.createElement("div", {
    className: "twk-hd",
    onMouseDown: onDragStart
  }, /*#__PURE__*/React.createElement("b", null, title), /*#__PURE__*/React.createElement("button", {
    className: "twk-x",
    "aria-label": "Close tweaks",
    onMouseDown: e => e.stopPropagation(),
    onClick: dismiss
  }, "\u2715")), /*#__PURE__*/React.createElement("div", {
    className: "twk-body"
  }, children)));
}

// ── Layout helpers ──────────────────────────────────────────────────────────

function TweakSection({
  label,
  children
}) {
  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("div", {
    className: "twk-sect"
  }, label), children);
}
function TweakRow({
  label,
  value,
  children,
  inline = false
}) {
  return /*#__PURE__*/React.createElement("div", {
    className: inline ? 'twk-row twk-row-h' : 'twk-row'
  }, /*#__PURE__*/React.createElement("div", {
    className: "twk-lbl"
  }, /*#__PURE__*/React.createElement("span", null, label), value != null && /*#__PURE__*/React.createElement("span", {
    className: "twk-val"
  }, value)), children);
}

// ── Controls ────────────────────────────────────────────────────────────────

function TweakSlider({
  label,
  value,
  min = 0,
  max = 100,
  step = 1,
  unit = '',
  onChange
}) {
  return /*#__PURE__*/React.createElement(TweakRow, {
    label: label,
    value: `${value}${unit}`
  }, /*#__PURE__*/React.createElement("input", {
    type: "range",
    className: "twk-slider",
    min: min,
    max: max,
    step: step,
    value: value,
    onChange: e => onChange(Number(e.target.value))
  }));
}
function TweakToggle({
  label,
  value,
  onChange
}) {
  return /*#__PURE__*/React.createElement("div", {
    className: "twk-row twk-row-h"
  }, /*#__PURE__*/React.createElement("div", {
    className: "twk-lbl"
  }, /*#__PURE__*/React.createElement("span", null, label)), /*#__PURE__*/React.createElement("button", {
    type: "button",
    className: "twk-toggle",
    "data-on": value ? '1' : '0',
    role: "switch",
    "aria-checked": !!value,
    onClick: () => onChange(!value)
  }, /*#__PURE__*/React.createElement("i", null)));
}
function TweakRadio({
  label,
  value,
  options,
  onChange
}) {
  const trackRef = React.useRef(null);
  const [dragging, setDragging] = React.useState(false);
  // The active value is read by pointer-move handlers attached for the lifetime
  // of a drag — ref it so a stale closure doesn't fire onChange for every move.
  const valueRef = React.useRef(value);
  valueRef.current = value;

  // Segments wrap mid-word once per-segment width runs out. The track is
  // ~248px (280 panel − 28 body pad − 4 seg pad), each button loses 12px
  // to its own padding, and 11.5px system-ui averages ~6.3px/char — so 2
  // options fit ~16 chars each, 3 fit ~10. Past that (or >3 options), fall
  // back to a dropdown rather than wrap.
  const labelLen = o => String(typeof o === 'object' ? o.label : o).length;
  const maxLen = options.reduce((m, o) => Math.max(m, labelLen(o)), 0);
  const fitsAsSegments = maxLen <= ({
    2: 16,
    3: 10
  }[options.length] ?? 0);
  if (!fitsAsSegments) {
    // <select> emits strings — map back to the original option value so the
    // fallback stays type-preserving (numbers, booleans) like the segment path.
    const resolve = s => {
      const m = options.find(o => String(typeof o === 'object' ? o.value : o) === s);
      return m === undefined ? s : typeof m === 'object' ? m.value : m;
    };
    return /*#__PURE__*/React.createElement(TweakSelect, {
      label: label,
      value: value,
      options: options,
      onChange: s => onChange(resolve(s))
    });
  }
  const opts = options.map(o => typeof o === 'object' ? o : {
    value: o,
    label: o
  });
  const idx = Math.max(0, opts.findIndex(o => o.value === value));
  const n = opts.length;
  const segAt = clientX => {
    const r = trackRef.current.getBoundingClientRect();
    const inner = r.width - 4;
    const i = Math.floor((clientX - r.left - 2) / inner * n);
    return opts[Math.max(0, Math.min(n - 1, i))].value;
  };
  const onPointerDown = e => {
    setDragging(true);
    const v0 = segAt(e.clientX);
    if (v0 !== valueRef.current) onChange(v0);
    const move = ev => {
      if (!trackRef.current) return;
      const v = segAt(ev.clientX);
      if (v !== valueRef.current) onChange(v);
    };
    const up = () => {
      setDragging(false);
      window.removeEventListener('pointermove', move);
      window.removeEventListener('pointerup', up);
    };
    window.addEventListener('pointermove', move);
    window.addEventListener('pointerup', up);
  };
  return /*#__PURE__*/React.createElement(TweakRow, {
    label: label
  }, /*#__PURE__*/React.createElement("div", {
    ref: trackRef,
    role: "radiogroup",
    onPointerDown: onPointerDown,
    className: dragging ? 'twk-seg dragging' : 'twk-seg'
  }, /*#__PURE__*/React.createElement("div", {
    className: "twk-seg-thumb",
    style: {
      left: `calc(2px + ${idx} * (100% - 4px) / ${n})`,
      width: `calc((100% - 4px) / ${n})`
    }
  }), opts.map(o => /*#__PURE__*/React.createElement("button", {
    key: o.value,
    type: "button",
    role: "radio",
    "aria-checked": o.value === value
  }, o.label))));
}
function TweakSelect({
  label,
  value,
  options,
  onChange
}) {
  return /*#__PURE__*/React.createElement(TweakRow, {
    label: label
  }, /*#__PURE__*/React.createElement("select", {
    className: "twk-field",
    value: value,
    onChange: e => onChange(e.target.value)
  }, options.map(o => {
    const v = typeof o === 'object' ? o.value : o;
    const l = typeof o === 'object' ? o.label : o;
    return /*#__PURE__*/React.createElement("option", {
      key: v,
      value: v
    }, l);
  })));
}
function TweakText({
  label,
  value,
  placeholder,
  onChange
}) {
  return /*#__PURE__*/React.createElement(TweakRow, {
    label: label
  }, /*#__PURE__*/React.createElement("input", {
    className: "twk-field",
    type: "text",
    value: value,
    placeholder: placeholder,
    onChange: e => onChange(e.target.value)
  }));
}
function TweakNumber({
  label,
  value,
  min,
  max,
  step = 1,
  unit = '',
  onChange
}) {
  const clamp = n => {
    if (min != null && n < min) return min;
    if (max != null && n > max) return max;
    return n;
  };
  const startRef = React.useRef({
    x: 0,
    val: 0
  });
  const onScrubStart = e => {
    e.preventDefault();
    startRef.current = {
      x: e.clientX,
      val: value
    };
    const decimals = (String(step).split('.')[1] || '').length;
    const move = ev => {
      const dx = ev.clientX - startRef.current.x;
      const raw = startRef.current.val + dx * step;
      const snapped = Math.round(raw / step) * step;
      onChange(clamp(Number(snapped.toFixed(decimals))));
    };
    const up = () => {
      window.removeEventListener('pointermove', move);
      window.removeEventListener('pointerup', up);
    };
    window.addEventListener('pointermove', move);
    window.addEventListener('pointerup', up);
  };
  return /*#__PURE__*/React.createElement("div", {
    className: "twk-num"
  }, /*#__PURE__*/React.createElement("span", {
    className: "twk-num-lbl",
    onPointerDown: onScrubStart
  }, label), /*#__PURE__*/React.createElement("input", {
    type: "number",
    value: value,
    min: min,
    max: max,
    step: step,
    onChange: e => onChange(clamp(Number(e.target.value)))
  }), unit && /*#__PURE__*/React.createElement("span", {
    className: "twk-num-unit"
  }, unit));
}

// Relative-luminance contrast pick — checkmarks drawn over a swatch need to
// read on both #111 and #fafafa without per-option configuration. Hex input
// only (#rgb / #rrggbb); named or rgb()/hsl() colors fall through to "light".
function __twkIsLight(hex) {
  const h = String(hex).replace('#', '');
  const x = h.length === 3 ? h.replace(/./g, c => c + c) : h.padEnd(6, '0');
  const n = parseInt(x.slice(0, 6), 16);
  if (Number.isNaN(n)) return true;
  const r = n >> 16 & 255,
    g = n >> 8 & 255,
    b = n & 255;
  return r * 299 + g * 587 + b * 114 > 148000;
}
const __TwkCheck = ({
  light
}) => /*#__PURE__*/React.createElement("svg", {
  viewBox: "0 0 14 14",
  "aria-hidden": "true"
}, /*#__PURE__*/React.createElement("path", {
  d: "M3 7.2 5.8 10 11 4.2",
  fill: "none",
  strokeWidth: "2.2",
  strokeLinecap: "round",
  strokeLinejoin: "round",
  stroke: light ? 'rgba(0,0,0,.78)' : '#fff'
}));

// TweakColor — curated color/palette picker. Each option is either a single
// hex string or an array of 1-5 hex strings; the card adapts — a lone color
// renders solid, a palette renders colors[0] as the hero (left ~2/3) with the
// rest stacked in a sharp column on the right. onChange emits the
// option in the shape it was passed (string stays string, array stays array).
// Without options it falls back to the native color input for back-compat.
function TweakColor({
  label,
  value,
  options,
  onChange
}) {
  if (!options || !options.length) {
    return /*#__PURE__*/React.createElement("div", {
      className: "twk-row twk-row-h"
    }, /*#__PURE__*/React.createElement("div", {
      className: "twk-lbl"
    }, /*#__PURE__*/React.createElement("span", null, label)), /*#__PURE__*/React.createElement("input", {
      type: "color",
      className: "twk-swatch",
      value: value,
      onChange: e => onChange(e.target.value)
    }));
  }
  // Native <input type=color> emits lowercase hex per the HTML spec, so
  // compare case-insensitively. String() guards JSON.stringify(undefined),
  // which returns the primitive undefined (no .toLowerCase).
  const key = o => String(JSON.stringify(o)).toLowerCase();
  const cur = key(value);
  return /*#__PURE__*/React.createElement(TweakRow, {
    label: label
  }, /*#__PURE__*/React.createElement("div", {
    className: "twk-chips",
    role: "radiogroup"
  }, options.map((o, i) => {
    const colors = Array.isArray(o) ? o : [o];
    const [hero, ...rest] = colors;
    const sup = rest.slice(0, 4);
    const on = key(o) === cur;
    return /*#__PURE__*/React.createElement("button", {
      key: i,
      type: "button",
      className: "twk-chip",
      role: "radio",
      "aria-checked": on,
      "data-on": on ? '1' : '0',
      "aria-label": colors.join(', '),
      title: colors.join(' · '),
      style: {
        background: hero
      },
      onClick: () => onChange(o)
    }, sup.length > 0 && /*#__PURE__*/React.createElement("span", null, sup.map((c, j) => /*#__PURE__*/React.createElement("i", {
      key: j,
      style: {
        background: c
      }
    }))), on && /*#__PURE__*/React.createElement(__TwkCheck, {
      light: __twkIsLight(hero)
    }));
  })));
}
function TweakButton({
  label,
  onClick,
  secondary = false
}) {
  return /*#__PURE__*/React.createElement("button", {
    type: "button",
    className: secondary ? 'twk-btn secondary' : 'twk-btn',
    onClick: onClick
  }, label);
}
Object.assign(window, {
  useTweaks,
  TweaksPanel,
  TweakSection,
  TweakRow,
  TweakSlider,
  TweakToggle,
  TweakRadio,
  TweakSelect,
  TweakText,
  TweakNumber,
  TweakColor,
  TweakButton
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties-cms/tweaks-panel.jsx", error: String((e && e.message) || e) }); }

// ui_kits/debesties/ArticleCard.jsx
try { (() => {
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
    cursor: 'pointer'
  },
  featuredBg: {
    position: 'absolute',
    inset: 0,
    background: 'linear-gradient(135deg, #0D0A07 0%, #1A5C2E22 50%, #E8A80008 100%)'
  },
  featuredContent: {
    position: 'relative',
    zIndex: 1,
    maxWidth: 580
  },
  featuredKicker: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 11,
    fontWeight: 700,
    letterSpacing: '0.14em',
    textTransform: 'uppercase',
    color: '#E8A800',
    marginBottom: 12
  },
  featuredTitle: {
    fontFamily: "'Playfair Display', serif",
    fontSize: 36,
    fontWeight: 900,
    lineHeight: 1.12,
    letterSpacing: '-0.03em',
    color: '#FFFFFF',
    marginBottom: 14
  },
  featuredExcerpt: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 16,
    color: '#7A7163',
    lineHeight: 1.6,
    marginBottom: 24
  },
  featuredCta: {
    display: 'inline-flex',
    alignItems: 'center',
    gap: 8,
    fontFamily: "'Outfit', sans-serif",
    fontSize: 14,
    fontWeight: 600,
    color: '#1A1410',
    background: '#E8A800',
    border: 'none',
    cursor: 'pointer',
    padding: '11px 22px',
    borderRadius: 8,
    transition: 'background 150ms'
  },
  featuredMeta: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 12,
    color: '#5C5448',
    marginBottom: 20,
    display: 'flex',
    gap: 8
  },
  // Standard card
  card: {
    background: '#FFFFFF',
    borderRadius: 12,
    border: '1px solid #EDE8E0',
    boxShadow: '0 2px 8px rgba(26,20,16,0.07)',
    overflow: 'hidden',
    cursor: 'pointer',
    transition: 'box-shadow 200ms, transform 200ms',
    display: 'flex',
    flexDirection: 'column'
  },
  cardImgWrap: {
    width: '100%',
    aspectRatio: '16/9',
    background: 'linear-gradient(135deg, #1A1410, #3D3529)',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    flexShrink: 0
  },
  cardBody: {
    padding: '18px 20px',
    flex: 1,
    display: 'flex',
    flexDirection: 'column',
    gap: 6
  },
  cardKicker: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 10,
    fontWeight: 700,
    letterSpacing: '0.12em',
    textTransform: 'uppercase',
    color: '#E8A800'
  },
  cardTitle: {
    fontFamily: "'Playfair Display', serif",
    fontSize: 17,
    fontWeight: 700,
    lineHeight: 1.3,
    color: '#1A1410',
    flex: 1
  },
  cardExcerpt: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 13,
    color: '#7A7163',
    lineHeight: 1.55
  },
  cardMeta: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 11,
    color: '#9E9387',
    display: 'flex',
    gap: 6,
    marginTop: 6
  }
};

// Gradient overlays per card type
const cardGradients = ['linear-gradient(135deg, #1A5C2E, #0E381B)', 'linear-gradient(135deg, #1A1410, #4D3000)', 'linear-gradient(135deg, #450A0A, #1A1410)', 'linear-gradient(135deg, #051F07, #1A5C2E)'];
function FeaturedCard({
  article,
  onNavigate
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: cardStyles.featured,
    onClick: () => onNavigate && onNavigate('timeline')
  }, /*#__PURE__*/React.createElement("div", {
    style: cardStyles.featuredBg
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      top: 32,
      right: 48,
      opacity: 0.12,
      fontSize: 120,
      color: '#E8A800',
      lineHeight: 1,
      userSelect: 'none',
      zIndex: 0
    }
  }, "\u2605"), /*#__PURE__*/React.createElement("div", {
    style: cardStyles.featuredContent
  }, /*#__PURE__*/React.createElement("div", {
    style: cardStyles.featuredKicker
  }, "Cover Story \xB7 May 2026"), /*#__PURE__*/React.createElement("h2", {
    style: cardStyles.featuredTitle
  }, article.title), /*#__PURE__*/React.createElement("p", {
    style: cardStyles.featuredExcerpt
  }, article.excerpt), /*#__PURE__*/React.createElement("div", {
    style: cardStyles.featuredMeta
  }, /*#__PURE__*/React.createElement("span", null, article.date), /*#__PURE__*/React.createElement("span", null, "\xB7"), /*#__PURE__*/React.createElement("span", null, article.readTime)), /*#__PURE__*/React.createElement("button", {
    style: cardStyles.featuredCta
  }, "Read the Full Timeline", /*#__PURE__*/React.createElement("i", {
    "data-lucide": "arrow-right",
    style: {
      width: 15,
      height: 15
    }
  }))));
}
function ArticleCard({
  article,
  index,
  onNavigate
}) {
  const [hov, setHov] = React.useState(false);
  const iconColors = ['#4EC17E', '#FFCA3A', '#FCA5A5', '#8EDAB0'];
  const iconNames = ['trophy', 'music', 'star', 'calendar'];
  return /*#__PURE__*/React.createElement("div", {
    style: {
      ...cardStyles.card,
      ...(hov ? {
        boxShadow: '0 8px 32px rgba(26,20,16,0.13)',
        transform: 'translateY(-2px)'
      } : {})
    },
    onMouseEnter: () => setHov(true),
    onMouseLeave: () => setHov(false),
    onClick: () => onNavigate && onNavigate('timeline')
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      ...cardStyles.cardImgWrap,
      background: cardGradients[index % 4]
    }
  }, /*#__PURE__*/React.createElement("i", {
    "data-lucide": iconNames[index % 4],
    style: {
      width: 28,
      height: 28,
      color: iconColors[index % 4]
    }
  })), /*#__PURE__*/React.createElement("div", {
    style: cardStyles.cardBody
  }, /*#__PURE__*/React.createElement("div", {
    style: cardStyles.cardKicker
  }, article.kicker), /*#__PURE__*/React.createElement("div", {
    style: cardStyles.cardTitle
  }, article.title), /*#__PURE__*/React.createElement("div", {
    style: cardStyles.cardExcerpt
  }, article.excerpt), /*#__PURE__*/React.createElement("div", {
    style: cardStyles.cardMeta
  }, /*#__PURE__*/React.createElement("span", null, article.date), /*#__PURE__*/React.createElement("span", null, "\xB7"), /*#__PURE__*/React.createElement("span", null, article.readTime))));
}
Object.assign(window, {
  FeaturedCard,
  ArticleCard
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties/ArticleCard.jsx", error: String((e && e.message) || e) }); }

// ui_kits/debesties/Navigation.jsx
try { (() => {
// Debesties Design System — Navigation Component
// Export: Navigation

const navStyles = {
  root: {
    position: 'sticky',
    top: 0,
    zIndex: 100,
    backdropFilter: 'blur(12px)',
    WebkitBackdropFilter: 'blur(12px)',
    background: 'rgba(248,245,240,0.92)',
    borderBottom: '1px solid #EDE8E0'
  },
  inner: {
    maxWidth: 1200,
    margin: '0 auto',
    padding: '0 32px',
    height: 62,
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'space-between',
    gap: 24
  },
  logo: {
    fontFamily: "'Playfair Display', serif",
    fontSize: 26,
    cursor: 'pointer',
    display: 'flex',
    alignItems: 'baseline',
    textDecoration: 'none',
    flexShrink: 0
  },
  logoDe: {
    fontWeight: 900,
    color: '#1A1410',
    letterSpacing: '-0.03em'
  },
  logoBesties: {
    fontWeight: 700,
    fontStyle: 'italic',
    color: '#E8A800',
    letterSpacing: '-0.02em'
  },
  links: {
    display: 'flex',
    gap: 0,
    alignItems: 'center',
    listStyle: 'none',
    margin: 0,
    padding: 0
  },
  link: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 14,
    fontWeight: 500,
    color: '#5C5448',
    cursor: 'pointer',
    padding: '8px 16px',
    borderRadius: 6,
    transition: 'color 150ms, background 150ms',
    userSelect: 'none'
  },
  linkActive: {
    color: '#E8A800',
    fontWeight: 600
  },
  linkHover: {
    background: 'rgba(26,20,16,0.05)'
  },
  right: {
    display: 'flex',
    gap: 10,
    alignItems: 'center',
    flexShrink: 0
  },
  subscribe: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 13,
    fontWeight: 600,
    background: '#E8A800',
    color: '#1A1410',
    border: 'none',
    cursor: 'pointer',
    padding: '8px 20px',
    borderRadius: 8,
    transition: 'background 150ms'
  },
  searchBtn: {
    background: 'none',
    border: '1.5px solid #EDE8E0',
    cursor: 'pointer',
    borderRadius: 8,
    width: 36,
    height: 36,
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    color: '#7A7163'
  }
};
function Navigation({
  page,
  onNavigate
}) {
  const [hovered, setHovered] = React.useState(null);
  const links = [{
    key: 'home',
    label: 'Home'
  }, {
    key: 'timeline',
    label: 'Timeline'
  }, {
    key: 'artists',
    label: 'Artists'
  }, {
    key: 'analysis',
    label: 'Analysis'
  }];
  return /*#__PURE__*/React.createElement("nav", {
    style: navStyles.root
  }, /*#__PURE__*/React.createElement("div", {
    style: navStyles.inner
  }, /*#__PURE__*/React.createElement("div", {
    style: navStyles.logo,
    onClick: () => onNavigate('home')
  }, /*#__PURE__*/React.createElement("span", {
    style: navStyles.logoDe
  }, "De"), /*#__PURE__*/React.createElement("span", {
    style: navStyles.logoBesties
  }, "besties")), /*#__PURE__*/React.createElement("ul", {
    style: navStyles.links
  }, links.map(({
    key,
    label
  }) => /*#__PURE__*/React.createElement("li", {
    key: key
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      ...navStyles.link,
      ...(page === key ? navStyles.linkActive : {}),
      ...(hovered === key ? navStyles.linkHover : {})
    },
    onClick: () => onNavigate(key),
    onMouseEnter: () => setHovered(key),
    onMouseLeave: () => setHovered(null)
  }, label)))), /*#__PURE__*/React.createElement("div", {
    style: navStyles.right
  }, /*#__PURE__*/React.createElement("button", {
    style: navStyles.searchBtn,
    title: "Search"
  }, /*#__PURE__*/React.createElement("i", {
    "data-lucide": "search",
    style: {
      width: 16,
      height: 16
    }
  })), /*#__PURE__*/React.createElement("button", {
    style: navStyles.subscribe
  }, "Subscribe"))));
}
Object.assign(window, {
  Navigation
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties/Navigation.jsx", error: String((e && e.message) || e) }); }

// ui_kits/debesties/TimelinePage.jsx
try { (() => {
// Debesties Design System — Timeline Page Component
// Export: TimelinePage, WINNERS

const WINNERS = [{
  year: 2026,
  artist: 'Black Sherif',
  isDouble: true
}, {
  year: 2025,
  artist: 'King Promise',
  isDouble: false
}, {
  year: 2024,
  artist: 'Stonebwoy',
  isDouble: true
}, {
  year: 2023,
  artist: 'Black Sherif',
  isDouble: false
}, {
  year: 2022,
  artist: 'KiDi',
  isDouble: false
}, {
  year: 2021,
  artist: 'Diana Hamilton',
  isDouble: false
}, {
  year: 2020,
  artist: 'Kuami Eugene',
  isDouble: false
}, {
  year: 2019,
  artist: null,
  annulled: true
}, {
  year: 2018,
  artist: 'Ebony',
  isDouble: false
}, {
  year: 2017,
  artist: 'Joe Mettle',
  isDouble: false
}, {
  year: 2016,
  artist: 'E.L',
  isDouble: false
}, {
  year: 2015,
  artist: 'Stonebwoy',
  isDouble: false
}, {
  year: 2014,
  artist: 'Shatta Wale',
  isDouble: false
}, {
  year: 2013,
  artist: 'R2Bees',
  isDouble: false
}, {
  year: 2012,
  artist: 'Sarkodie',
  isDouble: true
}, {
  year: 2011,
  artist: 'V.I.P',
  isDouble: true
}, {
  year: 2010,
  artist: 'Sarkodie',
  isDouble: false
}, {
  year: 2009,
  artist: 'Okyeame Kwame',
  isDouble: false
}, {
  year: 2008,
  artist: 'Kwaw Kese',
  isDouble: false
}, {
  year: 2007,
  artist: 'Samini',
  isDouble: false
}, {
  year: 2006,
  artist: 'Ofori Amponsah',
  isDouble: false
}, {
  year: 2005,
  artist: 'Obour',
  isDouble: false
}, {
  year: 2004,
  artist: 'V.I.P',
  isDouble: false
}, {
  year: 2003,
  artist: 'Kontihene',
  isDouble: false
}, {
  year: 2002,
  artist: 'Lord Kenya',
  isDouble: false
}, {
  year: 2001,
  artist: 'Kojo Antwi',
  isDouble: false
}, {
  year: 2000,
  artist: 'Daddy Lumba',
  isDouble: false
}, {
  year: 1999,
  artist: 'Akyeame',
  isDouble: false
}];
const ERAS = [{
  label: 'Afrobeats Era',
  years: [2020, 2026],
  color: '#0E381B',
  text: '#8EDAB0'
}, {
  label: 'Gospel & Contemporary',
  years: [2017, 2019],
  color: '#4D3000',
  text: '#FFE085'
}, {
  label: 'Highlife Revival',
  years: [2010, 2016],
  color: '#3D3529',
  text: '#D9D0C4'
}, {
  label: 'Hiplife Era',
  years: [1999, 2009],
  color: '#1A1410',
  text: '#BDB5A6'
}];
function getEra(year) {
  return ERAS.find(e => year >= e.years[0] && year <= e.years[1]);
}
const tlStyles = {
  page: {
    background: '#F8F5F0',
    minHeight: '100vh',
    paddingBottom: 80
  },
  hero: {
    background: '#1A1410',
    padding: '52px 32px 48px',
    textAlign: 'center',
    position: 'relative',
    overflow: 'hidden'
  },
  heroBg: {
    position: 'absolute',
    inset: 0,
    background: 'radial-gradient(ellipse at 50% 0%, rgba(232,168,0,0.12) 0%, transparent 70%)'
  },
  heroKicker: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 11,
    fontWeight: 700,
    letterSpacing: '0.16em',
    textTransform: 'uppercase',
    color: '#E8A800',
    marginBottom: 12,
    position: 'relative'
  },
  heroTitle: {
    fontFamily: "'Playfair Display', serif",
    fontSize: 42,
    fontWeight: 900,
    lineHeight: 1.1,
    letterSpacing: '-0.03em',
    color: '#FFFFFF',
    marginBottom: 12,
    position: 'relative'
  },
  heroSub: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 16,
    color: '#5C5448',
    maxWidth: 520,
    margin: '0 auto',
    lineHeight: 1.6,
    position: 'relative'
  },
  stats: {
    display: 'flex',
    justifyContent: 'center',
    gap: 48,
    padding: '24px 32px',
    background: '#1A1410',
    borderTop: '1px solid rgba(255,255,255,0.06)',
    position: 'relative'
  },
  stat: {
    textAlign: 'center'
  },
  statNum: {
    fontFamily: "'Space Mono', monospace",
    fontSize: 28,
    fontWeight: 700,
    color: '#E8A800',
    lineHeight: 1
  },
  statLabel: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 11,
    color: '#5C5448',
    marginTop: 4,
    letterSpacing: '0.04em'
  },
  body: {
    maxWidth: 680,
    margin: '0 auto',
    padding: '48px 24px 0'
  },
  eraLabel: {
    display: 'flex',
    alignItems: 'center',
    gap: 12,
    marginBottom: 20
  },
  eraChip: {
    fontFamily: "'Outfit', sans-serif",
    fontSize: 11,
    fontWeight: 700,
    letterSpacing: '0.08em',
    textTransform: 'uppercase',
    padding: '4px 12px',
    borderRadius: 9999
  },
  eraLine: {
    flex: 1,
    height: 1,
    background: '#EDE8E0'
  },
  // Timeline
  timeline: {
    position: 'relative'
  },
  timelineTrack: {
    position: 'absolute',
    left: 20,
    top: 0,
    bottom: 0,
    width: 2,
    background: 'linear-gradient(to bottom, #E8A800 0%, #EDE8E0 60%, transparent 100%)',
    borderRadius: 2
  },
  tItem: {
    display: 'flex',
    gap: 20,
    alignItems: 'flex-start',
    paddingBottom: 22,
    paddingLeft: 4
  },
  tNode: {
    width: 36,
    height: 36,
    borderRadius: '50%',
    flexShrink: 0,
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    position: 'relative',
    zIndex: 1,
    marginTop: 0
  },
  tNodeDefault: {
    background: 'white',
    border: '2px solid #EDE8E0'
  },
  tNodeWinner: {
    background: '#FFFAED',
    border: '2.5px solid #E8A800'
  },
  tNodeDouble: {
    background: '#E8A800',
    border: '2.5px solid #E8A800',
    boxShadow: '0 0 0 5px rgba(232,168,0,0.15)'
  },
  tNodeAnnulled: {
    background: '#FEF2F2',
    border: '2px solid #FCA5A5'
  },
  tContent: {
    flex: 1,
    paddingTop: 6
  },
  tYear: {
    fontFamily: "'Space Mono', monospace",
    fontSize: 11,
    fontWeight: 700,
    color: '#E8A800',
    letterSpacing: '0.06em',
    marginBottom: 1
  },
  tYearMuted: {
    color: '#BDB5A6'
  },
  tArtist: {
    fontFamily: "'Playfair Display', serif",
    fontSize: 19,
    fontWeight: 700,
    color: '#1A1410',
    lineHeight: 1.25
  },
  tArtistMuted: {
    color: '#9E9387',
    fontStyle: 'italic'
  },
  tBadge: {
    display: 'inline-flex',
    alignItems: 'center',
    gap: 4,
    fontFamily: "'Outfit', sans-serif",
    fontSize: 9,
    fontWeight: 700,
    letterSpacing: '0.09em',
    textTransform: 'uppercase',
    background: '#E8A800',
    color: '#1A1410',
    padding: '2px 7px',
    borderRadius: 3,
    marginLeft: 9,
    verticalAlign: 'middle'
  },
  tAnnulledBadge: {
    display: 'inline-flex',
    alignItems: 'center',
    fontFamily: "'Outfit', sans-serif",
    fontSize: 9,
    fontWeight: 700,
    letterSpacing: '0.09em',
    textTransform: 'uppercase',
    background: '#FEE2E2',
    color: '#7F1D1D',
    padding: '2px 7px',
    borderRadius: 3,
    marginLeft: 6,
    verticalAlign: 'middle'
  }
};
function TimelineItem({
  item
}) {
  const isAnnulled = item.annulled;
  const nodeStyle = isAnnulled ? tlStyles.tNodeAnnulled : item.isDouble ? tlStyles.tNodeDouble : tlStyles.tNodeWinner;
  return /*#__PURE__*/React.createElement("div", {
    style: tlStyles.tItem
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      ...tlStyles.tNode,
      ...nodeStyle
    }
  }, item.isDouble && !isAnnulled && /*#__PURE__*/React.createElement("svg", {
    width: "14",
    height: "14",
    viewBox: "0 0 24 24",
    fill: "#1A1410",
    stroke: "none"
  }, /*#__PURE__*/React.createElement("path", {
    d: "M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
  })), !item.isDouble && !isAnnulled && /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: "'Space Mono',monospace",
      fontSize: 10,
      fontWeight: 700,
      color: '#E8A800'
    }
  }, String(item.year).slice(2)), isAnnulled && /*#__PURE__*/React.createElement("svg", {
    width: "13",
    height: "13",
    viewBox: "0 0 24 24",
    fill: "none",
    stroke: "#B91C1C",
    strokeWidth: "2.5",
    strokeLinecap: "round"
  }, /*#__PURE__*/React.createElement("line", {
    x1: "18",
    y1: "6",
    x2: "6",
    y2: "18"
  }), /*#__PURE__*/React.createElement("line", {
    x1: "6",
    y1: "6",
    x2: "18",
    y2: "18"
  }))), /*#__PURE__*/React.createElement("div", {
    style: tlStyles.tContent
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      ...tlStyles.tYear,
      ...(isAnnulled ? tlStyles.tYearMuted : {})
    }
  }, item.year), /*#__PURE__*/React.createElement("div", {
    style: isAnnulled ? tlStyles.tArtistMuted : tlStyles.tArtist
  }, isAnnulled ? /*#__PURE__*/React.createElement(React.Fragment, null, "\u2014 ", /*#__PURE__*/React.createElement("span", {
    style: tlStyles.tAnnulledBadge
  }, "Annulled")) : /*#__PURE__*/React.createElement(React.Fragment, null, item.artist, item.isDouble && /*#__PURE__*/React.createElement("span", {
    style: tlStyles.tBadge
  }, "\u2605\u2605 2\xD7 Champ")))));
}
function TimelinePage({
  onNavigate
}) {
  let lastEra = null;
  const items = [];
  WINNERS.forEach((item, i) => {
    const era = getEra(item.year);
    if (era && era.label !== lastEra) {
      lastEra = era.label;
      items.push({
        type: 'era',
        era,
        key: `era-${i}`
      });
    }
    items.push({
      type: 'item',
      item,
      key: item.year
    });
  });
  return /*#__PURE__*/React.createElement("div", {
    style: tlStyles.page
  }, /*#__PURE__*/React.createElement("div", {
    style: tlStyles.hero
  }, /*#__PURE__*/React.createElement("div", {
    style: tlStyles.heroBg
  }), /*#__PURE__*/React.createElement("div", {
    style: tlStyles.heroKicker
  }, "Ghana Music Awards \xB7 Artiste of the Year"), /*#__PURE__*/React.createElement("h1", {
    style: tlStyles.heroTitle
  }, "The Complete History", /*#__PURE__*/React.createElement("br", null), "1999 \u2014 2026"), /*#__PURE__*/React.createElement("p", {
    style: tlStyles.heroSub
  }, "Every winner across 27 years of Ghana's most prestigious music award \u2014 including the 4 artists who conquered it twice.")), /*#__PURE__*/React.createElement("div", {
    style: tlStyles.stats
  }, [{
    num: '28',
    label: 'Years of Awards'
  }, {
    num: '24',
    label: 'Unique Winners'
  }, {
    num: '4',
    label: '2× Champions'
  }, {
    num: '1',
    label: 'Annulled Year'
  }].map(s => /*#__PURE__*/React.createElement("div", {
    key: s.label,
    style: tlStyles.stat
  }, /*#__PURE__*/React.createElement("div", {
    style: tlStyles.statNum
  }, s.num), /*#__PURE__*/React.createElement("div", {
    style: tlStyles.statLabel
  }, s.label)))), /*#__PURE__*/React.createElement("div", {
    style: tlStyles.body
  }, /*#__PURE__*/React.createElement("div", {
    style: tlStyles.timeline
  }, /*#__PURE__*/React.createElement("div", {
    style: tlStyles.timelineTrack
  }), items.map(entry => {
    if (entry.type === 'era') {
      const {
        era
      } = entry;
      return /*#__PURE__*/React.createElement("div", {
        key: entry.key,
        style: {
          ...tlStyles.eraLabel,
          paddingLeft: 56
        }
      }, /*#__PURE__*/React.createElement("span", {
        style: {
          ...tlStyles.eraChip,
          background: era.color,
          color: era.text
        }
      }, era.label), /*#__PURE__*/React.createElement("div", {
        style: tlStyles.eraLine
      }));
    }
    return /*#__PURE__*/React.createElement(TimelineItem, {
      key: entry.key,
      item: entry.item
    });
  }))));
}
Object.assign(window, {
  TimelinePage,
  WINNERS
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/debesties/TimelinePage.jsx", error: String((e && e.message) || e) }); }

})();
