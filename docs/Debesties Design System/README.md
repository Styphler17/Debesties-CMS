# Debesties Design System

## Overview

**Debesties** is a Ghanaian music and entertainment blog that specializes in archival coverage of the **Ghana Music Awards (TGMA/VGMA — The Ghana Music Awards / Vodafone Ghana Music Awards)**. The publication is editorially focused on music history, artist milestones, infographics, and awards analysis, with the goal of becoming the authoritative digital record of Ghanaian popular music.

The name "Debesties" blends "the" + "besties" — positioning itself as a fan-first, community-rooted publication with insider warmth and cultural pride.

## Source Materials

> **Note:** No external assets (Figma links, GitHub repos, uploaded brand files) were provided at time of system creation. This design system was built from the brand description and content context alone. If brand files, a codebase, or Figma access become available, link them here and use them to refine the foundations.

- Source: Textual brand + content brief (provided by user)
- No Figma link on file
- No GitHub repository on file
- Platform: WordPress (Custom HTML blocks)

---

## Products / Surfaces

| Surface | Description |
|---|---|
| **Blog (Web)** | Primary editorial surface — articles, timelines, infographics |
| **Infographic Assets** | Standalone shareable graphics for social/pitch decks |

---

## CONTENT FUNDAMENTALS

### Tone & Voice
- **Editorial but celebratory.** Debesties writes with the authority of a music journalist and the passion of a lifelong fan. Think: _Complex_ meets _Ghana Music_ fandom.
- **Culturally specific and proud.** Content leans into Ghanaian identity — genre names (Highlife, Hiplife, Afrobeats, Azonto, Drill), local terminology, and cultural context are never explained away.
- **Accessible.** Sentences are punchy, direct, and scannable. No academic jargon.

### Casing
- **Headline case** for article titles and H1s (e.g., *"The Elite Club: 4 Artists Who Dominated the TGMAs"*)
- **Sentence case** for subheadings and body labels
- Award names use full title form on first mention: *The Ghana Music Awards (TGMA)*; thereafter: *TGMA* or *the awards*

### Pronouns & Address
- **Third-person** for editorial coverage (referring to artists, award bodies, eras)
- **Second-person ("you")** used sparingly in listicles, guides, and CTAs
- No editorial "I" — the publication has a collective editorial voice

### Emoji & Punctuation
- **No emoji in editorial copy** — the content is archival/journalistic; emoji would undercut authority
- Em-dash (—) used for appositions and asides
- Oxford comma used throughout

### Numbers & Data
- Years written as numerals always: *1999, 2026*
- Award counts written in numerals over 10; spelled out below: *twice, three times*
- "Artiste" (not "Artist") when referring to TGMA category — preserves the official award nomenclature

### Examples (Content Snippets)
- *"Black Sherif joins an elite club — only four acts in TGMA history have claimed the Artiste of the Year crown more than once."*
- *"The 2019 edition remains the only year in TGMA history with an annulled award."*
- *"From the Hiplife era of the early 2000s to today's global Afrobeats wave, the TGMA has reflected every seismic shift in Ghanaian music."*

---

## VISUAL FOUNDATIONS

### Colors
Rooted in Ghana's visual and cultural identity: **gold** (achievement, trophies, the Ghana flag), **forest green** (Ghana flag, prestige), **warm ink/earth tones** (editorial authority), and **Ghana red** (flag, energy, accent). See `colors_and_type.css` for all tokens.

- **Primary:** Gold `#E8A800` — awards, highlights, CTAs
- **Accent:** Forest Green `#1A5C2E` — secondary actions, era tags
- **Danger/Alert:** Ghana Red `#B91C1C` — sparingly, for breaking news or special callouts
- **Ink Scale:** Warm near-blacks and tawny neutrals — never pure #000000 or #FFFFFF

### Typography
- **Display:** Playfair Display (serif) — award names, article headlines, hero text. Conveys editorial weight and timelessness.
- **Body:** Outfit (sans-serif) — article body, UI labels, navigation, captions. Modern and highly legible.
- **Mono:** Space Mono — years, statistics, data callouts. Reinforces the archival/record-keeping identity.
- **Scale:** 12px base (captions) → 72px+ (hero display). Line-height 1.4–1.7 for body; 1.1–1.2 for display.
- Both fonts sourced from Google Fonts.

### Backgrounds
- Primary background: Warm off-white `#F8F5F0` — never stark white
- Card surfaces: White `#FFFFFF`
- Hero sections: Deep ink `#1A1410` with gold accents
- Section dividers: Thin 1px warm-gray rules; never heavy borders

### Spacing
- Base unit: 4px
- Common: 4, 8, 12, 16, 24, 32, 48, 64, 96px
- Section padding: 64–96px vertical; 24–48px horizontal

### Corner Radii
- Micro (badges, tags): 4px
- Cards: 12px
- Buttons: 8px
- Pill (special CTAs): 999px

### Shadows
- Cards: `0 2px 8px rgba(26,20,16,0.08)`
- Elevated panels: `0 8px 32px rgba(26,20,16,0.14)`
- No deep drop shadows — the brand is flat-editorial, not material

### Animation
- Easing: `cubic-bezier(0.25, 0, 0, 1)` (smooth deceleration)
- Duration: 200ms for micro-interactions; 350ms for page transitions
- **No bounce.** Fades and slides only — the tone is editorial, not playful.
- Timeline nodes: fade-up on scroll (staggered, 80ms apart)

### Hover & Press States
- **Hover:** Slight background fill or opacity shift (0.08 overlay); no color change on text links — underline appears instead
- **Press:** 96% scale + brief darken (not shadow collapse)
- Gold CTAs: darken 10% on hover, 15% on press

### Borders
- `1px solid` warm-gray borders on cards when on warm-white background
- No borders on cards placed on dark backgrounds (shadow instead)
- Gold left-border accent: **explicitly NOT used** — this is a known design cliché to avoid

### Cards
- Background: White
- Radius: 12px
- Border: `1px solid #EDE8E0`
- Shadow: `0 2px 8px rgba(26,20,16,0.08)`
- Padding: 24px
- Image: 16:9 ratio, top of card, radius 8px top corners only

### Imagery
- **Warm, saturated photography** — Ghana's music scene is vibrant and colorful
- Not desaturated or B&W (that would undercut the celebration)
- No AI-generated imagery; authentic concert/award photography only
- Hero images: full-bleed with a dark gradient overlay (bottom 40%) for text legibility

### Layout Rules
- Max content width: 1200px centered
- Article reading width: 680px max (optimal line length)
- Timeline: single centered column on mobile; alternating left-right on desktop (≥768px)
- Sidebar: 280px fixed width on desktop articles

### Use of Transparency & Blur
- Sticky navigation: `backdrop-filter: blur(12px)` with semi-transparent background (warm white 88% opacity)
- No frosted-glass cards — blur is reserved for nav only

### Iconography
- See **ICONOGRAPHY** section below

---

## ICONOGRAPHY

### Approach
Debesties uses **Lucide Icons** (CDN: `https://unpkg.com/lucide@latest`) — a clean, consistent 24px stroke-based icon set. Stroke width: 1.5px. Color: inherits from context (gold on dark, ink on light).

- No emoji as icons in the UI
- No hand-drawn or custom SVGs in the UI
- No PNG icon sprites
- The TGMA trophy / star motif may be used as a decorative brand element (SVG inline) in infographics only

### Usage
- Navigation icons: 20px, stroke 1.5
- Inline body icons (e.g. calendar, share): 16px, stroke 1.5
- Featured stat icons (e.g. trophy): 32px, stroke 1.5
- CDN: `<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>` + `lucide.createIcons()`

### Icon → Lucide Mapping
| Concept | Lucide Icon |
|---|---|
| Trophy / Award | `trophy` |
| Calendar / Year | `calendar` |
| Music | `music` |
| Share | `share-2` |
| Search | `search` |
| Menu | `menu` |
| Close | `x` |
| Arrow | `arrow-right` |
| Tag / Category | `tag` |
| Star / Winner | `star` |
| External link | `external-link` |
| User / Artist | `user` |

---

## FILE INDEX

```
/
├── README.md                        ← This file (brand overview + all guidelines)
├── SKILL.md                         ← Agent skill definition (Claude Code compatible)
├── colors_and_type.css              ← All CSS custom properties (colors + typography)
├── assets/                          ← Add logos + illustrations here when available
├── preview/                         ← Design System tab cards (16 registered cards)
│   ├── colors-gold.html             Colors → Gold palette
│   ├── colors-ink.html              Colors → Ink/neutral scale
│   ├── colors-accent.html           Colors → Forest green + Ghana red
│   ├── colors-semantic.html         Colors → Semantic tokens
│   ├── type-display.html            Type → Playfair Display specimens
│   ├── type-body.html               Type → Outfit + Space Mono specimens
│   ├── type-scale.html              Type → Full scale Display→Caption
│   ├── spacing-tokens.html          Spacing → 4px-base spacing scale
│   ├── spacing-radius.html          Spacing → Border radii + shadow system
│   ├── comp-buttons.html            Components → Button variants + sizes
│   ├── comp-badges.html             Components → Badges, tags, era chips
│   ├── comp-timeline.html           Components → Timeline node states
│   ├── comp-artist-card.html        Components → Artist + article cards
│   ├── comp-article-card.html       Components → Featured + list cards
│   ├── brand-logo.html              Brand → Wordmark treatments
│   └── brand-infographic.html       Brand → Dark infographic format
└── ui_kits/
    └── debesties/
        ├── README.md                UI kit documentation
        ├── index.html               Interactive blog prototype (homepage + timeline)
        ├── Navigation.jsx           Sticky nav with logo, links, subscribe
        ├── ArticleCard.jsx          FeaturedCard + ArticleCard components
        └── TimelinePage.jsx         Full 1999–2026 TGMA timeline + WINNERS data
│   ├── comp-buttons.html
│   ├── comp-badges.html
│   ├── comp-timeline.html
│   ├── comp-artist-card.html
│   ├── comp-article-card.html
│   ├── brand-logo.html
│   └── brand-infographic.html
└── ui_kits/
    └── debesties/
        ├── README.md
        ├── index.html           ← Interactive blog homepage
        ├── Navigation.jsx
        ├── ArticleCard.jsx
        ├── TimelinePage.jsx
        └── ArtistCard.jsx
```
