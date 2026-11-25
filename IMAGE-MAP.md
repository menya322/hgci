# HGCI Image Map

How every image slot in the HGCI Laravel site is resolved, and which real photos still need supplying.
**No code changes are described here; this is the reference for dropping files in.**

- Updated: 13 November 2026
- Views scanned: 93 Blade files (`resources/views/**/*.blade.php`)
- Files under `public/images/`: 40 (1 profile, 25 gallery, 5 program, 1 project, 1 hero, 4 home, 1 impact, 1 story, 1 social card)

---

## 1. How images are actually served

There are **four** mechanisms in this project. Knowing which one a slot uses tells you where a file must go.

| Mechanism | Used by | Real location on disk | Public URL |
|---|---|---|---|
| Admin upload (`Storage::disk('public')`) | programs, projects, posts, events, team | `storage/app/public/{programs,projects,posts,events,team}/` | `/storage/{path}` |
| Bundled fallback (`App\Support\ContentImages`) | program, project, story, event and team photos | `public/images/programs/`, `projects/`, `posts/`, `events/` | `/images/...` |
| Gallery upload / seeded gallery | gallery albums and images | `public/images/gallery/...` | `/images/gallery/...` |
| Static asset | logo, hero, home strips, impact, contact photos and the social card | `public/images/...` | `/images/...` |

`public/storage` exists, so the `public` disk is linked.

### Social previews

`partials/seo.blade.php` emits the title, meta description, canonical link and the Open Graph / Twitter
tags for every page. `og:image` defaults to `public/images/og/og-default.jpg`. Stories and events publish
their own combined photo through `ContentImages::shareImage()`, which returns null while the slot is still
a placeholder — the default card is kept in that case, so no page advertises a file that is not on disk.
Dimensions come from `ImageSource::dimensions()`, which reads the real pixels and skips a file that is
missing or is not a readable image.

### The content photo rule

`App\Support\ContentImages` decides what a card or detail page shows, in this order:

1. **Uploaded image wins.** If the record has an image column set (`programs.image`, `projects.image`, `posts.featured_image`, `events.image`, `team_members.photo`), that file on the `public` disk is rendered. This is what an admin upload writes.
2. **Bundled photo next.** If there is no upload, the photo at the bundled path for that slug (or, for stories, that category) is used — but only if the file actually exists on disk.
3. **Placeholder last.** If neither exists, the slot renders the flat `[ADD: … photo]` placeholder. Never a broken image, never a broken path.

Because step 2 checks the file with `ImageSource::url()`, you can **drop a correctly named file into `public/images/programs/`, `projects/`, `posts/` or `events/` and it appears immediately** — no code change, no reseed. The `[ADD: … photo]` label only shows while that file is genuinely absent.

| Helper | Keys used | Bundled photo comes from |
|---|---|---|
| `program($program)` | program slug | `public/images/programs/{slug}.jpg` |
| `project($project)` | project slug | `public/images/projects/{slug}.jpg` |
| `post($post)` | post **category** | `public/images/posts/featured-story.jpg` (education), gallery health and livelihood photos |
| `event($event)` | event slug | gallery community and sponsorship photos |
| `teamMember($member)` | none | no bundled photo — the placeholder shows until a photo is uploaded |

Alt text follows the same honesty rule: a real photo gets a real description, and an empty slot gets "Photo of … to be added." instead of a description of a picture that is not there.

> **Important:** putting a file at `public/images/posts/foo.jpg` will **not** make it appear in a
> `posts.featured_image` slot. That field must contain a path on the `public` disk (for example
> `posts/foo.jpg`). Uploaded content images are a separate mechanism from the bundled fallbacks.

---

## 2. Slot inventory

Legend for **Owner**:

- **DB upload + fallback** — admin-editable, with a bundled photo used when nothing is uploaded.
- **DB upload** — editable in the admin panel, stored on the `public` disk.
- **DB + static seed** — a database record, but seeded from a file under `public/images/`.
- **Static** — a file committed to `public/images/`, not editable in the admin panel.

### 2.1 Global (every page)

| # | Slot | Rendered in | Path | Recommended pixels | Ratio | Owner |
|---|---|---|---|---|---|---|
| G1 | Site logo | `components/logo.blade.php` | `public/images/logo.png` | 512 × 128 (PNG, transparency) | 4:1 | Static |
| G2 | Default social-share image | `partials/seo.blade.php` (included from `layouts/app.blade.php` `<head>`) | `public/images/og/og-default.jpg` | 1200 × 630 | 1.91:1 | Static |
| G3 | Page social-share image (stories, events) | `partials/share-image.blade.php`, read by `partials/seo.blade.php` | resolved by `ContentImages::post()` / `::event()` | any landscape crop; 1200 × 630 ideal | 1.91:1 | DB upload + fallback |
| G4 | Favicon | Browser tab | `public/favicon.ico` | 32 × 32 and 48 × 48 | 1:1 | Static |

`logo.png` is missing, so the inline SVG hexagon wordmark is used. `public/favicon.ico` exists but is 0 bytes.

`og-default.jpg` is a 1200 × 630 crop of `hero/home-hero.jpg` (194 KB), so it uses the same consented
photograph rather than introducing a new one. Every page emits `og:image`, `og:image:width`,
`og:image:height`, `og:image:alt`, `twitter:card`, `twitter:image` and `twitter:image:alt`; the defaults
are on all pages, and stories and events override them with their own combined photo. A story or event
whose slot is still a placeholder keeps the default card rather than advertising a file that is not there,
and the width/height tags are read from the file itself.

### 2.2 Home (`home.blade.php`)

| # | Slot | Rendered in | Path | Recommended pixels | Ratio | Owner |
|---|---|---|---|---|---|---|
| H1 | Hero photo | `home.blade.php` via `<x-hero-image>` | `public/images/hero/home-hero.jpg` | 1600 × 900 | 16:9 | Static |
| H2 | Featured story image | `home.blade.php` via `<x-responsive-image>` | `posts/featured_image` → `public/images/posts/featured-story.jpg` fallback | 1200 × 900 | 4:3 | DB upload + fallback |
| H3 | Program cards (3 shown) | `components/program-card.blade.php` | `ContentImages::program()` → `public/images/programs/{slug}.jpg` | 800 × 500 (3:2 source crops well) | 16:10 | DB upload + fallback |
| H4 | Latest news cards | `components/post-card.blade.php` | `posts.featured_image` | 1600 × 1000 | 16:10 | DB upload |
| H5 | Upcoming event cards | `components/event-card.blade.php` | no image slot — date block plus text | — | — | — |
| H6 | Impact strip photo | `home.blade.php` | `public/images/home/impact.jpg` | 800 × 600 | 4:3 | Static |
| H7 | Niche thumbnails (Health, Education) | `home.blade.php` | `public/images/home/niche-health.jpg`, `niche-education.jpg` | 400 × 400 | 1:1 | Static |
| H8 | Sponsor band photo | `home.blade.php` via `<x-cta-band>` | `public/images/home/sponsor.jpg` | 480 × 640 | 3:4 | Static |

### 2.3 About (`about.blade.php`)

| # | Slot | Rendered in | Path | Recommended pixels | Ratio | Owner |
|---|---|---|---|---|---|---|
| A1 | Team member photo | `about.blade.php` via `ContentImages::teamMember()` | `team_members.photo` | 800 × 600 | 4:3 | DB upload + placeholder |
| A1b | Team empty-state photo | `about.blade.php` | `public/images/gallery/community-care/hgci-team-in-community.jpeg` | 810 × 1080 | 4:3 | Static |
| A2 | HGCI profile spread | `about.blade.php`, `home.blade.php` | `public/images/about/hgci-profile.jpeg` | 1080 × 810 for a clean 4:3 crop | 4:3 | Static |

No `TeamMember` records are seeded, so About shows the team empty state, which is paired with a real
team photo. Once records exist, each card shows the uploaded photo and an `[ADD: team photo]` placeholder
when a member has none.

### 2.4 Programs (`programs/index.blade.php`, `programs/show.blade.php`)

| # | Slot | Rendered in | Path | Recommended pixels | Ratio | Owner |
|---|---|---|---|---|---|---|
| P1 | Program cards (list, home, "other programs") | `components/program-card.blade.php` | `ContentImages::program()` → `public/images/programs/{slug}.jpg` | 800 × 500 | 16:10 | DB upload + fallback |
| P2 | Program detail image | `programs/show.blade.php` | same source as P1 | 800 × 500 | 4:3 | DB upload + fallback |
| P3 | Related project cards | `components/project-card.blade.php` | `ContentImages::project()` → `public/images/projects/{slug}.jpg` | 800 × 600 | 16:10 | DB upload + fallback |

Seeded program slugs: `education`, `health-nutrition`, `livelihood`, `food-relief`, `child-sponsorship`.
One 3:2-ish source per slug serves both P1 (16:10) and P2 (4:3) without visible cropping.

### 2.5 Impact (`impact.blade.php`)

| # | Slot | Rendered in | Path | Recommended pixels | Ratio | Owner |
|---|---|---|---|---|---|---|
| I1 | Project feature image | `components/project-feature.blade.php` | `ContentImages::project()` → `public/images/projects/{slug}.jpg` | 800 × 600 | 4:3 | DB upload + fallback |
| I2 | Fourth project card | `impact.blade.php` | `public/images/projects/fourth-project.jpg` | 800 × 600 | 4:3 | Static |
| I3 | "How we work" photo | `impact.blade.php` | `public/images/impact/community.jpg` | 1080 × 810 | 4:3 | Static |

Seeded project slugs: `piggery`, `cow-rearing`, `goat-rearing`, `food-relief-project`.

### 2.6 News (`news/index.blade.php`, `news/show.blade.php`)

| # | Slot | Rendered in | Path | Recommended pixels | Ratio | Owner |
|---|---|---|---|---|---|---|
| N1 | News card image | `components/post-card.blade.php` | `ContentImages::post()` → `posts.featured_image`, else a category photo | 1600 × 1000 | 16:10 | DB upload + fallback |
| N2 | News article image | `news/show.blade.php` | same source as N1 | 1600 × 900 | 16:9 | DB upload + fallback |

The bundled photo is chosen by post **category**: `education` uses `images/posts/featured-story.jpg`,
`health` uses a gallery hygiene photo, and `livelihood` uses the livelihood program photo. A story in any
other category shows a labelled placeholder rather than an unrelated photograph.

### 2.7 Events (`events/index.blade.php`, `events/show.blade.php`)

| # | Slot | Rendered in | Path | Recommended pixels | Ratio | Owner |
|---|---|---|---|---|---|---|
| E1 | Event card image | `components/event-card.blade.php` | `ContentImages::event()` → `events.image`, else a bundled photo | 1600 × 900 | 16:9 | DB upload + fallback |
| E2 | Event detail image | `events/show.blade.php` | same source as E1 | 1600 × 900 | 16:9 | DB upload + fallback |

Event cards now lead with the photo; the date block, time, location and summary sit beneath it.

### 2.8 Gallery (`gallery/index.blade.php`, `gallery/show.blade.php`)

| # | Slot | Rendered in | Path | Recommended pixels | Ratio | Owner |
|---|---|---|---|---|---|---|
| GA1 | Album cover | `components/album-card.blade.php` | `public/images/gallery/{album-slug}/cover.jpg` | 1200 × 900 | 4:3 | DB + static seed |
| GA2 | Gallery grid photo | `components/gallery-grid.blade.php` | `public/images/gallery/{album-slug}/{photo}.jpg` | 1200 × 900 | 4:3 | DB + static seed |
| GA3 | Lightbox large photo | `components/gallery-grid.blade.php` | same file as GA2 | long edge ≥ 1600 | natural | DB + static seed |

Admin gallery uploads go to `public/images/gallery/uploads/{album-id}/`.

The grid is one column on mobile, two at `sm` and three at `lg`. Every thumbnail lazy-loads inside a 4:3
frame with explicit `width`/`height`, and each card shows its caption in a visible footer strip — not only
on hover, so captions are readable on touch devices and by screen readers. Selecting a card opens the Alpine
lightbox with arrow-key navigation, Escape to close and focus returned to the thumbnail that opened it.
Photos whose file has been deleted are filtered out of both the grid and the album photo count.

### 2.9 Contact (`contact.blade.php`)

| # | Slot | Rendered in | Path | Recommended pixels | Ratio | Owner |
|---|---|---|---|---|---|---|
| C1 | Contact feature photo | `contact.blade.php` | `public/images/gallery/community-care/community-home-visit.jpeg` | 1080 × 810 | 4:3 | Static |
| C2 | Map placeholder | `contact.blade.php` | 16:9 panel with icon and text | 1600 × 900 | 16:9 | Static (optional) |

C1 now renders through `<x-responsive-image>` with a reservation frame, but it still points at a gallery
file by path, so renaming that gallery photo would break the Contact page.

### 2.10 Sponsor, Donate, Get Involved

| # | Slot | Rendered in | Path | Recommended pixels | Ratio | Owner |
|---|---|---|---|---|---|---|
| S1 | Sponsor "how it works" photo | `sponsor.blade.php` | `public/images/programs/child-sponsorship.jpg` | 800 × 500 | 4:3 | Static |
| S2 | Sponsor closing band photo | `sponsor.blade.php` → `<x-cta-band>` | `public/images/home/sponsor.jpg` | 480 × 640 | 3:4 | Static |
| V1 | Volunteering photo | `get-involved.blade.php` | `public/images/gallery/clothing-essentials/sorting-donated-clothes.jpeg` | 1080 × 720 | 4:3 | Static |
| V2 | Get Involved closing band photo | `get-involved.blade.php` → `<x-cta-band>` | `public/images/gallery/community-care/community-home-visit.jpeg` | 1080 × 810 | 3:4 | Static |

Donate still uses solid-colour icon cards, step numbers and a CTA band, with no photo slot.

### 2.11 Admin panel

| # | Slot | Rendered in | Path | Owner |
|---|---|---|---|---|
| AD1 | Current-image preview in upload forms | `components/admin/image-input.blade.php` | previews whatever is in the DB field | DB upload |

Upload validation caps files at 2 MB.

---

## 3. Missing files

### 3.1 Required to clear a visible placeholder

- [ ] `public/images/projects/piggery.jpg` — `[ADD: piggery photo]` on Impact and the Livelihood program page
- [ ] `public/images/projects/cow-rearing.jpg` — `[ADD: cow rearing photo]`
- [ ] `public/images/projects/goat-rearing.jpg` — `[ADD: goat rearing photo]`
- [ ] `public/images/projects/fourth-project.jpg` — `[ADD: project photo]` on Impact
- [ ] `public/images/logo.png` — SVG hexagon fallback in use
- [ ] `public/favicon.ico` — present but 0 bytes

### 3.2 Optional photography

- [ ] Team member photos — uploaded through the admin panel once team records are created
- [ ] `public/images/contact/map-placeholder.png` — text panel in use
- [ ] A dedicated contact photo — the page currently reuses a gallery file
- [ ] A purpose-shot social card — `public/images/og/og-default.jpg` is a crop of the hero photo

### 3.3 Directories that do not exist yet

`public/images/contact/`, `public/images/team/`.

---

## 4. Existing assets (already in `public/images/`)

### 4.1 Content photography

| File | Pixels | Ratio | Used by |
|---|---|---|---|
| `hero/home-hero.jpg` | 1600 × 900 | 16:9 | Home hero |
| `about/hgci-profile.jpeg` | 1080 × 764 | 1.41:1 | Home and About profile spread |
| `home/impact.jpg` | 800 × 600 | 4:3 | Home impact strip |
| `home/sponsor.jpg` | 480 × 640 | 3:4 | Home sponsor band |
| `home/niche-health.jpg` | 400 × 400 | 1:1 | Home niche list |
| `home/niche-education.jpg` | 400 × 400 | 1:1 | Home niche list |
| `impact/community.jpg` | 1080 × 810 | 4:3 | Impact "How we work" |
| `posts/featured-story.jpg` | 1200 × 900 | 4:3 | Featured story fallback |
| `programs/education.jpg` | 800 × 500 | 8:5 | Education program |
| `programs/health-nutrition.jpg` | 800 × 500 | 8:5 | Health & Nutrition program |
| `programs/livelihood.jpg` | 1080 × 810 | 4:3 | Livelihood program |
| `programs/food-relief.jpg` | 800 × 500 | 8:5 | Food Relief program |
| `programs/child-sponsorship.jpg` | 800 × 500 | 8:5 | Child Sponsorship program |
| `projects/food-relief.jpg` | 800 × 600 | 4:3 | Food Relief project |
| `og/og-default.jpg` | 1200 × 630 | 1.91:1 | Default `og:image` / `twitter:image` on every page without its own photo (194 KB) |

### 4.2 Gallery (25 files, all referenced by `GallerySeeder`)

| Album / file | Pixels | Ratio | Grid crop at 4:3 |
|---|---|---|---|
| `clothing-essentials/boys-with-new-clothes.jpeg` | 768 × 1024 | 3:4 portrait | Heavy crop |
| `clothing-essentials/children-choosing-clothes.jpeg` | 1080 × 720 | 3:2 | Good |
| `clothing-essentials/clothing-distribution.jpeg` | 1080 × 720 | 3:2 | Good |
| `clothing-essentials/handing-out-clothes.jpeg` | 768 × 1024 | 3:4 portrait | Heavy crop |
| `clothing-essentials/school-clothing-distribution.jpeg` | 1600 × 1066 | 3:2 | Good |
| `clothing-essentials/sorting-donated-clothes.jpeg` | 1080 × 720 | 3:2 | Good |
| `community-care/community-home-visit.jpeg` | 1080 × 810 | 4:3 | Exact fit — also on Contact |
| `community-care/encouraging-a-child.jpeg` | 810 × 1080 | 3:4 portrait | Heavy crop |
| `community-care/hgci-team-in-community.jpeg` | 810 × 1080 | 3:4 portrait | Heavy crop |
| `community-care/sitting-with-family.jpeg` | 1080 × 810 | 4:3 | Exact fit |
| `community-care/staff-visiting-children.jpeg` | 960 × 1280 | 3:4 portrait | Heavy crop |
| `community-care/staff-with-family.jpeg` | 1080 × 810 | 4:3 | Exact fit — also the Livelihood program photo |
| `education-school-support/clothing-support-at-school.jpeg` | 1600 × 1066 | 3:2 | Good |
| `education-school-support/school-hygiene-distribution.jpeg` | 1600 × 1066 | 3:2 | Good |
| `education-school-support/school-support-gathering.jpeg` | 1600 × 1066 | 3:2 | Good |
| `education-school-support/students-with-hygiene-supplies.jpeg` | 1600 × 1066 | 3:2 | Good |
| `food-relief/family-receiving-food-parcel.jpeg` | 576 × 1024 | 9:16 portrait | Heavy crop |
| `food-relief/food-parcel-for-household.jpeg` | 576 × 1024 | 9:16 portrait | Heavy crop |
| `food-relief/food-relief-home-visit.jpeg` | 810 × 1080 | 3:4 portrait | Heavy crop |
| `food-relief/relief-items-ready-for-distribution.jpeg` | 768 × 1024 | 3:4 portrait | Heavy crop |
| `food-relief/sharing-bread-with-children.jpeg` | 960 × 1280 | 3:4 portrait | Heavy crop |
| `health-hygiene/children-at-water-point.jpeg` | 607 × 1080 | 9:16 portrait | Heavy crop |
| `health-hygiene/sanitary-pads-in-classroom.jpeg` | 1600 × 1066 | 3:2 | Good |
| `health-hygiene/students-with-sanitary-supplies.jpeg` | 1600 × 1066 | 3:2 | Good |
| `health-hygiene/unloading-hygiene-supplies.jpeg` | 1600 × 1066 | 3:2 | Good |

Eleven of the 25 photos are portrait and crop heavily in the 4:3 grid (the lightbox shows them uncropped).

### 4.3 Uploads currently on the public disk

No leftover uploads remain. A stray test image from an earlier session had been attached to the
`add-story-livelihood-update` seeded story; it was removed so that story uses its bundled photo.

---

## 5. Known gaps

1. `public/images/logo.png` is missing and the inline SVG fallback does the work.
2. `public/favicon.ico` is 0 bytes.
3. The Contact page reuses a gallery path instead of using a dedicated contact photo or admin field.
4. Gallery cards force a 4:3 crop; 11 of the 25 seeded photos are portrait.
5. The three livestock projects (piggery, cow rearing, goat rearing) have **no photography at all** — only the placeholder path is reserved.
6. No settings key exists for hero or brand imagery, so changing those is an asset change, not an admin action.
7. Sponsor, Get Involved and Contact photos are static assets, not admin-editable fields.
8. The default social card is a crop of the home hero rather than a purpose-shot image, and it is served as JPEG. WebP would be smaller once a real card is designed.

---

## 6. Counts at a glance

| Category | Slots | Photos present | Missing |
|---|---|---|---|
| Global / brand | 4 | 1 (`og-default.jpg`; `favicon.ico` is 0 bytes) | logo + favicon + purpose-shot card |
| Home | 8 | 6 | 1 required (`logo` aside) + 1 optional |
| About | 3 | 2 (profile + empty-state team photo) | team member photos once records exist |
| Programs | 3 | 5 of 5 program photos | 0 |
| Impact / projects | 3 | 2 (food relief project, community) | 3 livestock + 1 fourth-project |
| News | 2 | 3 category photos | 0 (placeholders only for other categories) |
| Events | 2 | 2 bundled photos | 0 (placeholder for other events) |
| Gallery | 3 | 25 photos + 5 covers | 0 |
| Contact | 2 | 1 | 1 dedicated copy + 1 optional |
| Sponsor / Get involved | 4 | 4 | 0 |
| Donate | 0 | — | — |

**Minimum required to clear every visible `[ADD: … photo]`:** 3 livestock photos (`piggery`, `cow-rearing`, `goat-rearing`), 1 fourth-project photo, and 1 logo. Story, event, team and supporting-page photography is complete for the seeded content.
