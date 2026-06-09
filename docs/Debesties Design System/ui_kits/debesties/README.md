# Debesties UI Kit — Blog

Interactive prototype of the Debesties blog — Ghana's definitive TGMA/VGMA music awards publication.

## Design Width
1200px (desktop-first); readable down to ~768px.

## Screens
| Screen | How to access |
|---|---|
| **Homepage** | Default view — hero, article grid, Elite Club strip, newsletter |
| **Timeline** | Click "Read the Full Timeline", any article card, or "Timeline" in nav |

## Components
| File | Exports | Description |
|---|---|---|
| `Navigation.jsx` | `Navigation` | Sticky blur nav with logo, links, subscribe |
| `ArticleCard.jsx` | `FeaturedCard`, `ArticleCard` | Hero card + standard grid card |
| `TimelinePage.jsx` | `TimelinePage`, `WINNERS` | Full 1999–2026 TGMA timeline with era labels |
| `index.html` | — | Main interactive prototype; imports all above |

## Data
`WINNERS` array in `TimelinePage.jsx` contains all 28 award years.  
Double-winner flag: `isDouble: true` on V.I.P (2004, 2011), Sarkodie (2010, 2012), Stonebwoy (2015, 2024), Black Sherif (2023, 2026).  
Annulled year: 2019 — `{ year: 2019, artist: null, annulled: true }`.

## Design Tokens Used
Imports via Google Fonts: Playfair Display, Outfit, Space Mono.  
All colors from `colors_and_type.css` (referenced inline for portability).

## Notes
- No real photography — image placeholders use gradient backgrounds with Lucide icons.
- Designed for WordPress Custom HTML blocks; all CSS is self-contained.
- Components use `Object.assign(window, {...})` pattern for cross-script sharing.
