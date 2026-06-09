// Debesties CMS — Mock Data
// Exports to window: POSTS, ACTIVITY, TOP_ARTICLES, CATEGORIES, TAGS, USERS,
//   MEDIA, COMMENTS, TRAFFIC_SOURCES, DECAY, NAV_ITEMS

const NAV_ITEMS = [
  { group: 'Overview', items: [
    { key: 'dashboard', label: 'Dashboard', icon: 'layout-dashboard' },
    { key: 'analytics', label: 'Analytics', icon: 'bar-chart' },
    { key: 'calendar', label: 'Editorial Calendar', icon: 'calendar' },
  ]},
  { group: 'Content', items: [
    { key: 'posts', label: 'Posts', icon: 'file-text', count: 248 },
    { key: 'pages', label: 'Pages', icon: 'book-open', count: 9 },
    { key: 'categories', label: 'Categories', icon: 'folder' },
    { key: 'tags', label: 'Tags', icon: 'tag' },
    { key: 'media', label: 'Media Library', icon: 'image' },
    { key: 'comments', label: 'Comments', icon: 'message-square', count: 12 },
    { key: 'subscribers', label: 'Subscribers', icon: 'send', count: '12.8K' },
  ]},
  { group: 'Optimize', items: [
    { key: 'seo', label: 'SEO Tools', icon: 'search-check' },
    { key: 'ai', label: 'AI Visibility', icon: 'sparkles', badge: 'AI' },
  ]},
  { group: 'Site', items: [
    { key: 'navbuilder', label: 'Navigation Builder', icon: 'list' },
    { key: 'homebuilder', label: 'Homepage Builder', icon: 'home' },
    { key: 'users', label: 'Users & Roles', icon: 'users' },
    { key: 'settings', label: 'Site Settings', icon: 'settings' },
  ]},
];

const POSTS = [
  { id: 1, title: 'The Elite Club: 4 Artists Who Dominated the TGMAs', slug: 'elite-club-tgma-double-winners', status: 'published', author: 'Ama Boateng', category: 'Awards History', tags: ['TGMA','Sarkodie','Stonebwoy'], seo: 92, views: 48200, updated: '2h ago', date: 'May 27, 2026', featured: true, grad: 'linear-gradient(135deg,#1A1410,#4D3000)' },
  { id: 2, title: 'Black Sherif\u2019s Second Crown: Legacy Cemented', slug: 'black-sherif-second-crown', status: 'published', author: 'Kwesi Mensah', category: 'Profiles', tags: ['Black Sherif','Afrobeats'], seo: 88, views: 31400, updated: '5h ago', date: 'May 20, 2026', grad: 'linear-gradient(135deg,#450A0A,#1A1410)' },
  { id: 3, title: 'TGMA 2026: Full Winners List & Analysis', slug: 'tgma-2026-winners-list', status: 'scheduled', author: 'Ama Boateng', category: 'Awards History', tags: ['TGMA 2026'], seo: 71, views: 0, updated: '1d ago', date: 'Jun 12, 2026', grad: 'linear-gradient(135deg,#1A5C2E,#0E381B)' },
  { id: 4, title: 'The 2019 Annulment: What Really Happened?', slug: '2019-tgma-annulment-explained', status: 'review', author: 'Yaw Owusu', category: 'Analysis', tags: ['TGMA','Controversy'], seo: 64, views: 0, updated: '3h ago', date: 'Draft', grad: 'linear-gradient(135deg,#3D3529,#7A4F00)' },
  { id: 5, title: 'King Promise\u2019s 2025 Win: A New Chapter for Highlife', slug: 'king-promise-2025-win', status: 'published', author: 'Kwesi Mensah', category: 'Profiles', tags: ['King Promise','Highlife'], seo: 79, views: 22100, updated: '2d ago', date: 'Mar 3, 2026', grad: 'linear-gradient(135deg,#0E381B,#1A8A4B)' },
  { id: 6, title: 'Sarkodie vs Stonebwoy: The Numbers Behind the Rivalry', slug: 'sarkodie-stonebwoy-stats', status: 'draft', author: 'Yaw Owusu', category: 'Analysis', tags: ['Sarkodie','Stonebwoy','Data'], seo: 41, views: 0, updated: '4d ago', date: 'Draft', grad: 'linear-gradient(135deg,#1A1410,#2C241B)' },
  { id: 7, title: 'Every Hiplife Winner That Defined an Era', slug: 'hiplife-era-tgma-winners', status: 'published', author: 'Ama Boateng', category: 'Awards History', tags: ['Hiplife','VIP','Obour'], seo: 85, views: 18700, updated: '1w ago', date: 'Feb 14, 2026', grad: 'linear-gradient(135deg,#4D3000,#A06C00)' },
  { id: 8, title: 'Diana Hamilton & The Rise of Gospel at the TGMAs', slug: 'diana-hamilton-gospel-tgma', status: 'published', author: 'Esi Arthur', category: 'Profiles', tags: ['Diana Hamilton','Gospel'], seo: 76, views: 14300, updated: '1w ago', date: 'Jan 28, 2026', grad: 'linear-gradient(135deg,#1A5C2E,#22A35A)' },
  { id: 9, title: 'V.I.P: The Group That Started It All', slug: 'vip-group-tgma-legacy', status: 'archived', author: 'Yaw Owusu', category: 'Profiles', tags: ['VIP','Hiplife'], seo: 68, views: 9800, updated: '3w ago', date: 'Jan 8, 2026', grad: 'linear-gradient(135deg,#2C241B,#4D3000)' },
  { id: 10, title: 'How TGMA Voting Actually Works in 2026', slug: 'tgma-voting-explained-2026', status: 'draft', author: 'Esi Arthur', category: 'Explainers', tags: ['TGMA','Voting'], seo: 33, views: 0, updated: '5d ago', date: 'Draft', grad: 'linear-gradient(135deg,#17120D,#3D3529)' },
];

const ACTIVITY = [
  { who: 'Ama Boateng', action: 'published', target: 'The Elite Club: 4 Artists Who Dominated…', time: '2h ago', type: 'published' },
  { who: 'Yaw Owusu', action: 'submitted for review', target: 'The 2019 Annulment: What Really Happened?', time: '3h ago', type: 'review' },
  { who: 'Kwesi Mensah', action: 'updated', target: 'Black Sherif\u2019s Second Crown', time: '5h ago', type: 'draft' },
  { who: 'Esi Arthur', action: 'left a comment on', target: 'How TGMA Voting Actually Works', time: '6h ago', type: 'review' },
  { who: 'Ama Boateng', action: 'scheduled', target: 'TGMA 2026: Full Winners List', time: '1d ago', type: 'scheduled' },
  { who: 'System', action: 'flagged decay on', target: 'V.I.P: The Group That Started It All', time: '1d ago', type: 'decay' },
];

const TOP_ARTICLES = [
  { title: 'The Elite Club: 4 Artists Who Dominated the TGMAs', views: 48200, trend: [12,18,15,22,28,35,48], up: '+34%' },
  { title: 'Black Sherif\u2019s Second Crown: Legacy Cemented', views: 31400, trend: [20,22,19,25,28,30,31], up: '+12%' },
  { title: 'King Promise\u2019s 2025 Win: A New Chapter', views: 22100, trend: [28,26,24,22,20,21,22], up: '\u22125%' },
  { title: 'Every Hiplife Winner That Defined an Era', views: 18700, trend: [10,12,14,15,16,18,18], up: '+22%' },
  { title: 'Diana Hamilton & The Rise of Gospel', views: 14300, trend: [8,9,11,12,13,14,14], up: '+18%' },
];

const TRENDING_CATS = [
  { name: 'Awards History', share: 38, views: '142K', color: '#E8A800' },
  { name: 'Profiles', share: 27, views: '98K', color: '#1A8A4B' },
  { name: 'Analysis', share: 19, views: '71K', color: '#2F6BD8' },
  { name: 'Explainers', share: 11, views: '40K', color: '#B14FD8' },
  { name: 'News', share: 5, views: '19K', color: '#C8372B' },
];

const DECAY = [
  { title: 'V.I.P: The Group That Started It All', drop: '\u221242%', lastUpdate: '3 weeks ago', reason: 'Traffic decline + outdated stats' },
  { title: 'How TGMA Voting Works (2024 edition)', drop: '\u221238%', lastUpdate: '8 months ago', reason: 'Superseded by 2026 rules' },
  { title: 'Top 10 Ghanaian Songs of 2023', drop: '\u221229%', lastUpdate: '14 months ago', reason: 'Seasonal relevance lost' },
];

const CATEGORIES = [
  { name: 'Awards History', slug: 'awards-history', posts: 64, color: '#E8A800', desc: 'TGMA/VGMA winners, records & milestones' },
  { name: 'Profiles', slug: 'profiles', posts: 52, color: '#1A8A4B', desc: 'Artist deep-dives and career retrospectives' },
  { name: 'Analysis', slug: 'analysis', posts: 38, color: '#2F6BD8', desc: 'Data-driven takes on the Ghanaian music scene' },
  { name: 'Explainers', slug: 'explainers', posts: 29, color: '#B14FD8', desc: 'How the industry & awards actually work' },
  { name: 'News', slug: 'news', posts: 41, color: '#C8372B', desc: 'Breaking updates and announcements' },
  { name: 'Interviews', slug: 'interviews', posts: 24, color: '#0E5C30', desc: 'Conversations with artists & industry figures' },
];

const TAGS = [
  { name: 'TGMA', count: 84 }, { name: 'Sarkodie', count: 47 }, { name: 'Stonebwoy', count: 39 },
  { name: 'Black Sherif', count: 31 }, { name: 'Afrobeats', count: 56 }, { name: 'Hiplife', count: 44 },
  { name: 'Highlife', count: 38 }, { name: 'King Promise', count: 22 }, { name: 'VIP', count: 18 },
  { name: 'Gospel', count: 27 }, { name: 'Shatta Wale', count: 33 }, { name: 'Diana Hamilton', count: 14 },
  { name: 'Awards', count: 61 }, { name: 'Data', count: 19 }, { name: 'Controversy', count: 12 },
  { name: 'Azonto', count: 9 }, { name: 'Drill', count: 16 }, { name: 'Kuami Eugene', count: 21 },
];

const USERS = [
  { name: 'Ama Boateng', email: 'ama@debesties.com', role: 'Admin', posts: 86, status: 'active', last: 'Online now' },
  { name: 'Kwesi Mensah', email: 'kwesi@debesties.com', role: 'Editor', posts: 64, status: 'active', last: '20m ago' },
  { name: 'Yaw Owusu', email: 'yaw@debesties.com', role: 'Author', posts: 41, status: 'active', last: '2h ago' },
  { name: 'Esi Arthur', email: 'esi@debesties.com', role: 'Author', posts: 33, status: 'active', last: '5h ago' },
  { name: 'Kojo Asante', email: 'kojo@debesties.com', role: 'SEO Manager', posts: 8, status: 'active', last: '1d ago' },
  { name: 'Nana Adwoa', email: 'nana@debesties.com', role: 'Contributor', posts: 12, status: 'invited', last: 'Pending' },
  { name: 'Fiifi Hayford', email: 'fiifi@debesties.com', role: 'Media Manager', posts: 0, status: 'active', last: '3d ago' },
];

const ROLES = [
  { name: 'Admin', count: 1, color: '#C8372B', perms: 'Full access — settings, users, billing, publishing' },
  { name: 'Editor', count: 2, color: '#E8A800', perms: 'Edit & publish all posts, manage categories' },
  { name: 'Author', count: 4, color: '#1A8A4B', perms: 'Create & publish own posts, upload media' },
  { name: 'Contributor', count: 3, color: '#2F6BD8', perms: 'Write drafts, submit for review (no publish)' },
  { name: 'SEO Manager', count: 1, color: '#B14FD8', perms: 'Edit SEO fields, schema, internal links' },
  { name: 'Media Manager', count: 1, color: '#0E5C30', perms: 'Upload, organize & optimize media library' },
];

const MEDIA = Array.from({ length: 12 }, (_, i) => {
  const grads = ['linear-gradient(135deg,#1A1410,#4D3000)','linear-gradient(135deg,#1A5C2E,#0E381B)','linear-gradient(135deg,#450A0A,#1A1410)','linear-gradient(135deg,#2C241B,#A06C00)','linear-gradient(135deg,#0E381B,#1A8A4B)','linear-gradient(135deg,#3B5BDB,#B14FD8)'];
  const names = ['black-sherif-stage','tgma-trophy','sarkodie-portrait','stonebwoy-live','king-promise-cover','vip-archive','diana-hamilton','studio-session','awards-night','hiplife-vinyl','crowd-accra','backstage'];
  return { id: i+1, name: names[i] + '.jpg', grad: grads[i % grads.length], size: (1.2 + Math.random()*3).toFixed(1) + ' MB', dims: '1920×1080', type: i % 5 === 0 ? 'PNG' : 'JPG' };
});

const COMMENTS = [
  { author: 'MusicFan_GH', avatar: 'M', text: 'V.I.P winning twice is criminally underrated. Great breakdown!', post: 'The Elite Club', time: '1h ago', status: 'pending' },
  { author: 'AccraBeats', avatar: 'A', text: 'You forgot to mention the 2008 nominees though.', post: 'Hiplife Winners', time: '3h ago', status: 'pending' },
  { author: 'KofiListens', avatar: 'K', text: 'Black Sherif deserved both wins no debate.', post: 'Second Crown', time: '5h ago', status: 'approved' },
  { author: 'Spam Bot 9000', avatar: 'S', text: 'Buy cheap followers click here >>>', post: 'TGMA 2026', time: '6h ago', status: 'spam' },
];

const TRAFFIC_SOURCES = [
  { name: 'Organic Search', pct: 54, color: '#1A8A4B' },
  { name: 'Direct', pct: 21, color: '#E8A800' },
  { name: 'Social', pct: 16, color: '#2F6BD8' },
  { name: 'AI Assistants', pct: 6, color: '#B14FD8' },
  { name: 'Referral', pct: 3, color: '#C8372B' },
];

const SEARCH_QUERIES = [
  { q: 'who won artiste of the year ghana', pos: 1, clicks: 8420, imp: 42100, ctr: '20.0%' },
  { q: 'tgma double winners', pos: 2, clicks: 5210, imp: 31800, ctr: '16.4%' },
  { q: 'black sherif awards', pos: 3, clicks: 3940, imp: 28400, ctr: '13.9%' },
  { q: 'sarkodie tgma history', pos: 4, clicks: 2180, imp: 19600, ctr: '11.1%' },
  { q: '2019 vgma annulled', pos: 2, clicks: 1890, imp: 14200, ctr: '13.3%' },
];

const PAGES = [
  { id: 1, title: 'About Debesties', slug: 'about', status: 'published', updated: '2w ago', author: 'Ama Boateng', template: 'Standard', views: 8400, inNav: true },
  { id: 2, title: 'Contact', slug: 'contact', status: 'published', updated: '1mo ago', author: 'Ama Boateng', template: 'Contact form', views: 3200, inNav: true },
  { id: 3, title: 'Editorial Standards', slug: 'editorial-standards', status: 'published', updated: '3w ago', author: 'Kwesi Mensah', template: 'Standard', views: 1900, inNav: false },
  { id: 4, title: 'Advertise With Us', slug: 'advertise', status: 'published', updated: '2mo ago', author: 'Ama Boateng', template: 'Landing', views: 1100, inNav: true },
  { id: 5, title: 'The TGMA Archive', slug: 'tgma-archive', status: 'published', updated: '4d ago', author: 'Yaw Owusu', template: 'Timeline', views: 21400, inNav: true },
  { id: 6, title: 'Privacy Policy', slug: 'privacy-policy', status: 'published', updated: '6mo ago', author: 'Ama Boateng', template: 'Legal', views: 640, inNav: false },
  { id: 7, title: 'Terms of Service', slug: 'terms', status: 'published', updated: '6mo ago', author: 'Ama Boateng', template: 'Legal', views: 410, inNav: false },
  { id: 8, title: 'Meet the Team', slug: 'team', status: 'draft', updated: '5d ago', author: 'Esi Arthur', template: 'Team grid', views: 0, inNav: false },
  { id: 9, title: 'Newsletter Archive', slug: 'newsletter', status: 'scheduled', updated: '1d ago', author: 'Kwesi Mensah', template: 'Standard', views: 0, inNav: false },
];

const SUBSCRIBERS = [
  { id: 1, email: 'kwame.asante@gmail.com', name: 'Kwame Asante', status: 'active', source: 'Article CTA', joined: 'Jun 6, 2026', opens: 94 },
  { id: 2, email: 'abena.o@yahoo.com', name: 'Abena Owusu', status: 'active', source: 'Homepage', joined: 'Jun 5, 2026', opens: 88 },
  { id: 3, email: 'dj.fiifi@outlook.com', name: 'Fiifi Mensah', status: 'active', source: 'Article CTA', joined: 'Jun 3, 2026', opens: 76 },
  { id: 4, email: 'naa.dedei@gmail.com', name: 'Naa Dedei', status: 'pending', source: 'Pop-up', joined: 'Jun 9, 2026', opens: 0 },
  { id: 5, email: 'kojo.b@icloud.com', name: 'Kojo Boateng', status: 'active', source: 'Timeline page', joined: 'May 28, 2026', opens: 62 },
  { id: 6, email: 'ama.serwaa@gmail.com', name: 'Ama Serwaa', status: 'active', source: 'Homepage', joined: 'May 24, 2026', opens: 81 },
  { id: 7, email: 'old.address@hotmail.com', name: 'Yaw Darko', status: 'unsubscribed', source: 'Article CTA', joined: 'Jan 12, 2026', opens: 8 },
  { id: 8, email: 'esi.t@gmail.com', name: 'Esi Tetteh', status: 'active', source: 'Pop-up', joined: 'May 19, 2026', opens: 70 },
  { id: 9, email: 'bounce@deadmail.xyz', name: '—', status: 'bounced', source: 'Import', joined: 'Apr 2, 2026', opens: 0 },
  { id: 10, email: 'nana.akua@gmail.com', name: 'Nana Akua', status: 'active', source: 'Homepage', joined: 'May 11, 2026', opens: 90 },
];

const CAMPAIGNS = [
  { id: 1, subject: 'TGMA 2026: Every Winner, One Page', sent: 'Jun 2, 2026', recipients: 12840, openRate: 58, clickRate: 22, status: 'sent' },
  { id: 2, subject: 'The Elite Club — 4 Artists Who Won Twice', sent: 'May 26, 2026', recipients: 12410, openRate: 64, clickRate: 31, status: 'sent' },
  { id: 3, subject: 'Weekly Digest: Black Sherif’s Second Crown', sent: 'May 19, 2026', recipients: 12180, openRate: 51, clickRate: 18, status: 'sent' },
  { id: 4, subject: 'Mid-Year Music Report (Draft)', sent: 'Scheduled Jun 16', recipients: 0, openRate: 0, clickRate: 0, status: 'scheduled' },
];

// Per-post revision history (used in the editor)
const REVISIONS = [
  { id: 6, author: 'Ama Boateng', time: '2 hours ago', label: 'Current version', words: 1840, change: '+0', current: true },
  { id: 5, author: 'Ama Boateng', time: 'Today, 9:14 AM', label: 'Added FAQ schema block', words: 1840, change: '+120' },
  { id: 4, author: 'Kwesi Mensah', time: 'Yesterday, 4:32 PM', label: 'Editor revisions to intro', words: 1720, change: '+45' },
  { id: 3, author: 'Ama Boateng', time: 'Jun 5, 2026', label: 'Updated 2026 winner stats', words: 1675, change: '+210' },
  { id: 2, author: 'Yaw Owusu', time: 'Jun 3, 2026', label: 'First full draft', words: 1465, change: '+1465' },
  { id: 1, author: 'Ama Boateng', time: 'Jun 2, 2026', label: 'Created post', words: 0, change: '+0' },
];

Object.assign(window, {
  NAV_ITEMS, POSTS, PAGES, SUBSCRIBERS, CAMPAIGNS, REVISIONS, ACTIVITY, TOP_ARTICLES, TRENDING_CATS, DECAY, CATEGORIES, TAGS,
  USERS, ROLES, MEDIA, COMMENTS, TRAFFIC_SOURCES, SEARCH_QUERIES,
});
