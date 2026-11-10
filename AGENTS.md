# OpenCode Prompt: Hope In God Child Initiatives (HGCI) Website

Paste everything below the line into OpenCode (model: DeepSeek V4 Flash). Tip: also save it as `AGENTS.md` in the project root so OpenCode re-reads it every session.

---

## 1. ROLE & GOAL

You are a senior Laravel 12 developer and UI engineer. Build a complete, production-ready website for **Hope In God Child Initiatives (HGCI)**, a child sponsorship and Christian humanitarian aid organization in Uganda. The site must build trust, explain the work clearly, and drive three actions: **Sponsor a child**, **Donate**, and **Get involved / Contact**.

Work in the phases in section 10. Finish and verify one phase before starting the next. Do not invent facts, statistics, names, phone numbers, emails or addresses. Wherever real data is missing, use a clearly marked placeholder such as `[ADD: phone number]` and list every placeholder in `PLACEHOLDERS.md` at the end.

## 2. TECH STACK (fixed)

- PHP 8.3+, **Laravel 12**, Blade templates
- **Tailwind CSS** via Vite (Laravel 12 default). Alpine.js for small interactions (mobile menu, dropdowns, accordions, lightbox). No heavy JS frameworks.
- MySQL (SQLite acceptable for local development)
- Laravel Breeze (Blade) for admin authentication only, no public registration
- Filesystem storage with `php artisan storage:link` for uploads
- Pest or PHPUnit feature tests for key routes and forms
- Follow PSR-12, use Form Request classes for validation, Eloquent relationships, route model binding, resource controllers, and Blade components (`<x-...>`) for reuse. Keep controllers thin.

## 3. ORGANIZATION CONTENT (use this wording as the base copy)

**Who We Are:** Hope In God Child Initiatives (HGCI) is a child sponsorship and Christian Humanitarian Aid Organization that works to transform the lives of orphans and vulnerable groups of people in Uganda. It was founded with an aim to ensure the general welfare and wellbeing of children, including provision of food and other basic necessities. HGCI ensures that all children get quality education and develop into responsible adult citizens of Uganda.

**Vision:** Reach to the Poor of the Poorest.
**Mission:** Transform children's lives living in poverty in Uganda communities.
**Core Values:** Love, Team work, Compassion, Transparency, Excellence.
**Our Niche:** Health, Education, Livelihood.
**Strategic Goal:** To ensure that all children get quality education and develop into responsible adult citizens of the country.

**Strategic Areas of Focus:**
1. Ensuring the general welfare and wellbeing of children, including provision of food and basic necessities.
2. Positively impacting the long-term development of children living in poverty-stricken / underprivileged areas.
3. Establishing quality and competitive Education / Vocational institutions to reduce illiteracy levels and improve welfare among children and society at large.
4. Creating awareness on health, nutrition and sanitation to create a clean and healthy environment for children.
5. Promoting discipline and a sense of responsibility among children as they grow up, and in particular discouraging violence and drug use.

**Our Approach:** HGCI employs a community-based approach in achieving its objectives by promoting active participation of community members in fighting poverty.

**Achievements & Impact (livelihood and relief projects):** 1) Piggery, 2) Cow Rearing, 3) Goat Rearing, 4) `[ADD: fourth project, left blank in the brochure]`, 5) Food Relief.

**Logo:** hexagon made of circles (yellow, red, green, orange) with the letters H G C I, and the wordmark "HOPE IN GOD CHILD INITIATIVES". The logo file will be placed in `public/images/logo.png`; until then use a text wordmark.

## 4. DESIGN INSPIRATION: WATOTO CHURCH (watotochurch.com)

Take inspiration from its **structure and tone**, not its exact look. Do not copy its code, images, text or logo.

Patterns to adapt:
- **Mission-first hero:** one clear vision statement near the top, followed by a row of large quick-link tiles to the main destinations (their row is Leadership, Online, Cell Family, Locations, Generosity). For HGCI use: *About Us, Our Programs, Sponsor a Child, Donate, Contact*.
- **Mega-style navigation** with grouped dropdowns, and a visually distinct **Give/Donate button** pinned at the right end of the nav.
- **Featured block** (their "Current Message Series"). For HGCI this becomes **"Featured Story / Current Project"**, an image plus short text plus a button, editable from the admin panel.
- **"Coming Up" events section** and a **"Life at..." program card grid** with short descriptions and "Learn More" links. For HGCI: *Education, Health & Nutrition, Livelihood (piggery, cow rearing, goat rearing), Food Relief, Child Sponsorship*.
- **Warm, family-oriented headline copy**, e.g. "Every child deserves hope." Keep it short and human.
- **Dedicated sponsor call-to-action band** ("Sponsor a child, change a life") placed mid-page and again before the footer.
- **"Get involved" link grid**, a simple grid of text-button links (Sponsor, Volunteer, Donate, Contact, Prayer request).
- **Rich footer:** about blurb, head office/contact block, social links, quick links, copyright.
- Skip-to-content link and clear section hierarchy.

## 5. VISUAL DESIGN RULES (strict)

### 5.1 NO GRADIENTS, anywhere
- No `bg-gradient-*`, `from-*`, `via-*`, `to-*`, `linear-gradient`, `radial-gradient`, `conic-gradient`, gradient text, gradient borders or gradient buttons.
- Use only **solid flat colors**. Depth comes from spacing, borders, solid color blocks and subtle solid shadows.
- For text over photos, use a **solid semi-transparent overlay** (e.g. `bg-black/50`) or place text on a solid color panel next to the image. Never a gradient fade.
- After building, run a search for `gradient` across `resources/` and `public/` and remove every match.

### 5.2 Color system (taken from the HGCI brochure; define as Tailwind theme tokens in `resources/css/app.css` using `@theme`)
Treat the hex values as starting points and refine them to match the logo once it is available.

| Token | Starting value | Use |
|---|---|---|
| `brand-teal` | `#0F7C89` | Primary: headings, nav, links, primary sections |
| `brand-teal-dark` | `#0A5B65` | Hover/active, footer background |
| `brand-red` | `#D62F2F` | Accent: Donate button, key highlights |
| `brand-yellow` | `#F5B700` | Accent: highlights, badges, sponsor band |
| `brand-orange` | `#F28A1E` | Secondary accent, icons |
| `brand-green` | `#4CAF50` | Success states, "growth/livelihood" accents |
| `ink` | `#1F2933` | Body text |
| `muted` | `#5B6770` | Secondary text |
| `surface` | `#FFFFFF` | Page background |
| `surface-warm` | `#FBF7EE` | Alternate section background (flat cream) |
| `line` | `#E3DED3` | Borders/dividers |

Rules: 60% neutral (white/cream), 30% teal, 10% accents. Red is reserved for the Donate CTA and critical highlights. Never place yellow text on white. All text/background pairs must reach **WCAG AA contrast (4.5:1 body, 3:1 large text)**; verify and adjust tokens if needed.

### 5.3 Typography
- Headings: a friendly, sturdy sans-serif such as **"Poppins"** or **"Nunito"**. Body: **"Inter"** or **"Open Sans"**. Load via Google Fonts (or self-host) with `font-display: swap`.
- Scale: base 16-18px body, line-height 1.6-1.7, headings with clear steps (e.g. 40/32/24/20). Maximum text line width about 65-75 characters.

### 5.4 Layout & components
- Mobile-first, responsive at Tailwind breakpoints. Container max-width 1200px with generous section padding (`py-16`/`py-24`).
- 8px spacing system, consistent rounded corners (`rounded-lg`), solid 1px borders, subtle solid shadows only.
- One clear primary CTA per section. Buttons: solid fill, visible hover and focus ring, minimum 44px tap height.
- Cards: flat white or cream, solid border, image on top, title, short text, "Learn more" link.
- Alternate section backgrounds (white / cream / solid teal with white text) to create rhythm without gradients.
- Use real photography of children and projects once supplied; until then, use neutral solid-color placeholder blocks with `[ADD: photo]` labels. Do not hotlink external stock images.
- Icons: inline SVG (Heroicons or Lucide), single-color.

### 5.5 Design principles to apply
Clear visual hierarchy, consistency, whitespace, proximity and alignment, contrast, F-pattern/Z-pattern scanning, limited palette, accessible touch targets, fast load, content-first, ethical and dignified imagery of children (no exploitative or pity-style presentation; always use consent-based photos).

## 6. SITE MAP & PAGES

Public routes (named routes, Blade views, shared layout `layouts/app.blade.php`):
1. **Home** `/`: hero (vision + 5 quick-link tiles), who we are summary, niche (Health / Education / Livelihood), featured story, programs grid, impact/achievements strip, sponsor CTA band, upcoming events, latest news, get-involved link grid, footer.
2. **About** `/about`: Who We Are, Vision & Mission, Core Values, Strategic Goal, Strategic Areas of Focus, Our Approach, (optional) Team/Leadership (admin-managed).
3. **Programs** `/programs` and `/programs/{slug}`: Education, Health & Nutrition, Livelihood (Piggery, Cow Rearing, Goat Rearing), Food Relief.
4. **Impact / Achievements** `/impact`: the projects with photos, descriptions, and numbers (admin-managed counters, no invented figures).
5. **Sponsor a Child** `/sponsor`: how sponsorship works (steps), what a sponsor's gift provides, FAQ accordion, sponsorship enquiry form.
6. **Donate** `/donate`: ways to give (mobile money, bank transfer details as admin-managed settings, with `[ADD]` placeholders), a donation pledge form that records the pledge (no payment gateway in v1; structure code so one can be added later).
7. **Get Involved** `/get-involved`: volunteer, partner, in-kind giving; volunteer application form.
8. **News / Stories** `/news` and `/news/{slug}`: blog-style posts with pagination.
9. **Events** `/events` and `/events/{slug}`.
10. **Gallery** `/gallery`: albums, responsive grid with Alpine lightbox.
11. **Contact** `/contact`: form, map placeholder, address/phone/email from settings, social links.
12. **Privacy Policy** and **Terms**, plus a friendly **404** page.

Navigation: Home, About (Vision & Values, Our Approach, Team), What We Do (Programs, Impact), Get Involved (Sponsor, Volunteer, Partner), News & Events, Gallery, Contact, plus a red **Donate** button.

## 7. DATA MODEL (migrations, models, factories, seeders)

`users` (admin), `programs`, `projects` (achievements), `posts`, `events`, `gallery_albums`, `gallery_images`, `team_members`, `testimonials`, `faqs`, `sponsorship_enquiries`, `donation_pledges`, `volunteer_applications`, `contact_messages`, `settings` (key/value: contact info, socials, bank/mobile money details, hero text, impact counters).

Seed realistic content from section 3 only. Everything else is a placeholder. Add indexes and foreign keys, soft deletes where useful, and slugs generated from titles.

## 8. ADMIN PANEL (`/admin`, authenticated)

Simple Blade-based CRUD (no heavy packages) for: programs, projects, posts, events, albums/images, team, testimonials, FAQs, settings; list and mark-as-read for messages, enquiries, pledges and volunteer applications; CSV export of enquiries and pledges. Include image upload with validation (mime, max 2 MB), resizing/optimization where possible, and a dashboard with simple counts.

## 9. QUALITY REQUIREMENTS

- **Security:** CSRF, validation on every form, honeypot field plus rate limiting (`throttle`) on public forms, authorization on admin routes, escaped output, no secrets in code.
- **Email:** notifications via Laravel Mail (log driver locally) for new contact messages, sponsorship enquiries and volunteer applications, sent to an admin address from settings.
- **SEO:** unique `<title>` and meta description per page, Open Graph tags, canonical URLs, `sitemap.xml`, `robots.txt`, semantic HTML, JSON-LD `NGO` / `Organization` schema, descriptive alt text.
- **Accessibility:** semantic landmarks, keyboard navigable menus, visible focus states, skip link, labelled form fields, ARIA only where needed, `prefers-reduced-motion` respected.
- **Performance:** lazy-load images with explicit width/height, responsive `srcset` where possible, WebP preferred, no unused JS or CSS, Vite production build passes.
- **Tests:** feature tests for each public page returning 200, form submissions (valid and invalid), admin auth protection.
- **Code quality:** no dead code, no hardcoded repeated markup (extract Blade components such as `x-button`, `x-section-heading`, `x-program-card`, `x-cta-band`, `x-page-hero`).

## 10. WORKFLOW: STRICT PHASES

After each phase, run the relevant commands (`php artisan migrate`, `php artisan test`, `npm run build`), fix errors, then give a 3-5 line summary and continue.

1. **Foundation:** create the Laravel 12 project, configure `.env`, Tailwind theme tokens (section 5.2), fonts, base layout, header/nav, footer, reusable Blade components.
2. **Database & models:** migrations, models, factories, seeders.
3. **Public pages:** build all pages in section 6 using the design rules.
4. **Forms & email:** contact, sponsorship, pledge and volunteer forms with validation, throttling, storage and notifications.
5. **Admin panel:** auth plus CRUD for all content.
6. **Polish:** SEO, accessibility, responsive checks at 360, 768 and 1280px widths, performance, the no-gradient audit.
7. **Tests & handover:** tests passing, `README.md` (setup, seeding, admin login creation, deployment notes for a Digital Ocean/Nginx server), `PLACEHOLDERS.md`.

## 11. DEFINITION OF DONE

- [ ] `php artisan migrate --seed`, `php artisan test` and `npm run build` all succeed.
- [ ] Every page in section 6 loads, is responsive, and uses only flat colors (zero gradients found).
- [ ] All text meets WCAG AA contrast; the site is fully keyboard navigable.
- [ ] Donate and Sponsor CTAs appear in the header, mid-page and footer.
- [ ] All forms validate, store records, and send notifications.
- [ ] No invented facts; all gaps listed in `PLACEHOLDERS.md`.

Start with Phase 1 now. Before writing code, briefly state your plan for the folder structure and the Blade components you will create.
