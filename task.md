# a-salah.dev — SEO & design fixes

Site: https://a-salah.dev (WordPress on Hostinger, LiteSpeed Cache, Rank Math, Site Kit, Contact Form 7)
Theme repo: https://github.com/Abdulrahman14Salah/a-salah.dev
Theme branch with the white redesign: `redesign/white-theme` (2 commits). If it is not on GitHub yet, apply `a-salah-redesign.patch` first with `git am`.

This file has two parts:

- **Part A — Code.** Run in the theme repo with Claude Code.
- **Part B — WordPress dashboard.** Run in the browser (Claude in Chrome), logged in as admin.

Findings behind these tasks, from the audit on 2026-09-28:

- Semrush shows the domain ranking for zero keywords (Egypt and US). Authority Score is 2.
- The site is English only, but Arabic searches have more volume and are easier to rank for. Semrush Egypt, monthly searches (keyword difficulty):
  - تصميم مواقع: 590 (KD 39). In Saudi Arabia it gets 720.
  - تصميم موقع ووردبريس: 110 (KD 25)
  - مبرمج ووردبريس: 90 (KD 26)
  - wordpress developer: 170 (KD 47)
- Services exist only as cards on the home page. There are no service pages to rank.
- Titles start with "Home »". The home page schema is typed Article. The Person schema has no sameAs links.
- The Aawan project page has 16 words, no meta description and an image without alt text.
- Leftover default text: the Privacy Policy description starts with "Suggested text:". The Terms description is "1. Introduction".

---

## Part A — Code (theme repo)

Rules:

- Work on the branch `redesign/white-theme`. Commit each task separately with a clear message.
- Keep the existing conventions. Functions are prefixed `mytheme_`. The text domain is `my-theme`. There is no build step: plain CSS lives in `assets/css/main.css`.
- Escape all output. Run `php -l` on every changed PHP file.
- Test in a local WordPress. SQLite plus the built-in PHP server is enough. Take desktop (1440px) and mobile (390px) screenshots of every page you touch.
- Don't invent content: no fake testimonials, statistics or client names. Where real content is missing, render nothing, or leave a clearly marked placeholder for admins only.

### A1. Arabic / RTL support
Goal: the theme renders correctly in Arabic, so an Arabic version of the site can be added with Polylang.

- Make layouts direction-safe. Replace left/right with logical properties (`margin-inline-start`, `inset-inline-start`, `text-align: start`, `padding-inline`) across `main.css`.
- Check these components specifically:
  - Breadcrumb, `.text-link` arrow, `.post-nav`.
  - `.float-card` positions, `.alignleft`/`.alignright`.
  - Blockquote border, list padding.
- Flip directional icons (the `arrow` icon) in RTL: `[dir="rtl"] .icon-arrow { transform: scaleX(-1) }`. Add a class to the arrow SVG so it can be targeted.
- When `is_rtl()`, enqueue an Arabic font. Use IBM Plex Sans Arabic 400/500/600/700 from Google Fonts. Set `--f-body` and `--f-display` to it under `[dir="rtl"]`. Keep JetBrains Mono for eyebrows only on Latin text; for Arabic, eyebrows use the body font with no uppercase transform and no letter-spacing.
- Make all hard-coded strings in the templates translatable. Most already use `__()` / `esc_html__()`; check `mytheme_services()`, `mytheme_stack()` labels, and the footer.
- Generate `languages/my-theme.pot`.
- Acceptance:
  - With the site language set to Arabic, the home, about, contact, blog, single post and project pages mirror correctly.
  - Nothing overflows horizontally at 390px.
  - Arrows point the right way.

### A2. Service page template
Goal: each service gets its own indexable page.

- Add `page-templates/service.php` ("Template Name: Service"). Sections:
  1. Page hero: breadcrumb, H1 = page title, lead = page excerpt.
  2. Page content from the editor. This is where the long copy goes.
  3. The FAQ lives in the content as core Details blocks. Style `.wp-block-details` as an accordion in `main.css`.
  4. "Related work": up to 3 `project` posts. Filter by a post meta `service_slug` if set, otherwise show the latest 3.
  5. "From the blog": up to 3 posts in a category whose slug matches the page slug, if any exist.
  6. Contact CTA: `template-parts/sections/contact-cta`.
- Link the home page service cards to their pages.
  - Add an optional `url` to each item in `mytheme_services()`, resolved by page slug:
    - `wordpress-website-development`
    - `wordpress-plugin-theme-development`
    - `website-speed-seo`
    - `wordpress-maintenance`
    - `laravel-development`
    - `hosting-domains`
  - When the page exists, the whole card is a link. When it doesn't, the card stays a plain card, as now.
  - Update `template-parts/sections/services.php` for both the grid and list layouts.
- Acceptance: a page using the Service template renders all sections, and the home page cards link to existing service pages only.

### A3. Floating WhatsApp button (mobile and desktop)
- Add a fixed button in `footer.php`, bottom-right (bottom-left in RTL), using `mytheme_whatsapp_url()`. Render it only when a number is set.
- Make it 56×56px, with an accessible label ("Chat on WhatsApp"). Keep it above the footer bottom bar, and away from the cookie/CF7 messages.
- Add a Customizer checkbox to switch it off.

### A4. Testimonials, shown only when real ones exist
- Register a `testimonial` post type:
  - Title = client name.
  - Content = quote.
  - Meta: `role`, `company`, `project_url`.
  - Featured image = avatar or logo.
  - Only if the post type doesn't already exist (same pattern as `project` in `inc/theme/post-types.php`).
- Add a home page section between "Recent projects" and "About", rendered only when at least one testimonial is published.

### A5. Image alt fallbacks
- In `template-parts/cards/project.php`, `cards/post.php` and `single-project.php`, the featured image alt must be the image's own alt text. If that's empty, use the post title (for example "Aawan Website — project screenshot"). Never an empty string for content images.
- The decorative mark SVGs keep `alt=""`.

### A6. Real photo in the hero (optional in the Customizer)
- Add a Customizer image setting "Hero photo". When set, the hero visual shows the photo, cropped with `object-fit: cover` and rounded, instead of the big logo mark. Keep the floating "Core stack" and "Maintained & secured" cards over it.
- Load it with `fetchpriority="high"`, no lazy loading, and explicit width/height.

### A7. Theme updater fixes (`inc/updates/updater.php`)
- Add an `upgrader_source_selection` filter. When this theme is being updated, rename the extracted folder to the installed theme's folder name (`get_template()`). Otherwise an update installs a second copy instead of replacing the theme.
- Remove the `zipball_url` fallback in `resolve_package_url()`. If the release has no matching ZIP asset, offer no update.
- Only send the `Authorization` header for requests to this repo's API URLs (`/repos/Abdulrahman14Salah/a-salah.dev/`), not every `api.github.com` request.
- In `.github/workflows/build-theme.yml`:
  - Bump `softprops/action-gh-release` to `v2`.
  - Add `permissions: contents: write`.
  - Also exclude `README.md`, `task.md` and `*.patch` from the ZIP.

### A8. Verify and hand over
- Run `php -l` on all PHP files.
- Load every template in a local WordPress with `WP_DEBUG` on. There must be no notices from the theme.
- Take screenshots (desktop + mobile, and Arabic RTL for A1).
- Push the branch and open a PR describing each task.

---

## Part B — WordPress dashboard (Claude in Chrome)

Rules:

- Change settings and content only as listed here.
- **Ask the site owner before** you:
  - install, deactivate or delete any plugin
  - publish a new page
  - change robots.txt
- Save new pages as **drafts** unless told otherwise.
- After each Rank Math change, open the page logged out, or view source, and confirm the new title/description/schema is in the HTML. LiteSpeed Cache may need a purge: LiteSpeed Cache → Toolbox → Purge All.

### B1. Rank Math global titles
Rank Math → Titles & Meta:

- **Global Meta:** separator `|`.
- **Homepage.** The home page is a static page, so edit it in the page's Rank Math box (see B2).
- **Posts:** title `%title% | %sitename%`.
- **Pages:** title `%title% | %sitename%`.
- **Projects** (post type `project`): title `%title% | %sitename%`.
- **Categories:** robots **noindex**, keep follow.
- **Tags:** noindex.
- **Authors:** disable author archives, or set noindex. It's a single-author site, so they duplicate the blog.
- **Date archives:** disabled/noindex.

### B2. Titles and descriptions per page
Set these in each page's Rank Math box (Edit → Rank Math → Edit Snippet). Titles ≤ 60 characters, descriptions ≤ 155.

| Page | SEO title | Meta description | Focus keyword |
|---|---|---|---|
| Home `/` | WordPress & Laravel Developer \| Abdulrahman Salah | Abdulrahman Salah designs and builds fast, secure WordPress websites and Laravel apps, with SEO, speed work and ongoing maintenance. | wordpress developer |
| About `/about-abdulrahman/` | About Abdulrahman Salah – WordPress & Laravel Developer | WordPress and Laravel developer building fast, secure, SEO-friendly websites for companies, organizations and public figures. | abdulrahman salah |
| Contact `/contact/` | Contact Abdulrahman Salah \| Get a Website Quote | Tell me about your website idea and get a plan and a quote. Reach me by form, email or WhatsApp. | hire wordpress developer |
| Blog `/blog/` | WordPress & Laravel Blog \| Abdulrahman Salah | Practical articles on WordPress and Laravel: speed, security, SEO, custom themes and plugins. | wordpress blog |
| Aawan `/project/aawan-website/` | Aawan Website – WordPress Project \| Abdulrahman Salah | Arabic corporate website for Aawan public services office, designed and built on WordPress. | — |
| Personal Branding Tips | (keep title) | Practical tips to define your personal brand, stay consistent online, create useful content and network authentically. | personal branding tips |
| Privacy Policy | (keep title) | How a-salah.dev collects, uses and protects your data, including contact form messages and analytics. | — |
| Terms & Conditions | (keep title) | Terms for using a-salah.dev and working with Abdulrahman Salah on website projects. | — |

The home page H1 comes from Appearance → Customize → Theme Options. The H1 needs to contain "WordPress" and "developer", so change it there:

- Hero title: `WordPress & Laravel developer building websites that`
- Hero title (blue part): `load fast and rank well.`

### B3. Schema / knowledge graph
- **Rank Math → Titles & Meta → Local SEO:**
  - Person, name `Abdulrahman Salah`.
  - Logo: a **PNG**, at least 112×112, not the SVG. Upload `logo-abdo-05.png` if it's already in the Media library; otherwise export one from the SVG.
  - Social profiles (sameAs):
    - https://github.com/Abdulrahman14Salah
    - https://www.linkedin.com/in/abdulrahman-salah-hassanein/
- **Home page, Rank Math → Schema tab:** remove the **Article** schema. The home page should carry WebPage (or ProfilePage) about the Person, not an Article.
- **About page:** same, no Article schema.
- **Contact page:** schema type ContactPage if available; otherwise remove Article.
- **Posts:** keep BlogPosting.
- **Projects:** Article is fine, or CreativeWork if available.
- Verify the home page and one post in https://search.google.com/test/rich-results. Report any errors.

### B4. Content clean-up
- **Privacy Policy page:** remove every "Suggested text:" label and all the WordPress default placeholder copy. Replace it with a real short policy. It must cover:
  - what the contact form collects (name, email, subject, message)
  - Google Analytics / Site Kit
  - cookies
  - how to request deletion, via me@a-salah.dev

  Then check Settings → Privacy points to this page.
- **Terms & Conditions:** set the Rank Math description (B2).
- **Aawan project:**
  - Rename it to "Aawan Website", with a capital A.
  - Excerpt: `Arabic corporate website for Aawan public services office`.
  - Featured image alt text: `Aawan Website — homepage screenshot`.
  - Project details box: Client "Aawan public services office", Service "WordPress design & development", Language "Arabic (RTL)", Year: ask the owner. Live URL: ask the owner. Tags "WordPress, RTL".
  - Content: add three headed sections, The brief, What was built and The result, with placeholders in square brackets. **Ask the owner for the real details before publishing the update.**
- **Personal Branding Tips:** set the image alt text if empty.

### B5. Theme Options
Appearance → Customize → Theme Options:

- Confirm the email, phone and WhatsApp (`201121600780`), and the GitHub/LinkedIn URLs.
- Contact form shortcode: `[contact-form-7 id="37" title="Contact"]`. Check the form ID in Contact → Contact Forms.
- Apply the hero title change from B2.
- Page templates: About page → **About** template. Contact page → **Contact** template.
- Menus: assign the Primary and Footer menus if they're not set.

### B6. Plugins and scripts (ask before changing anything)
Report these, and ask the owner before acting:

- **Site Kit → Settings → Sign in with Google:** turn it off if nobody uses Google sign-in on the site. It loads `accounts.google.com/gsi/client` on every page.
- **Site Kit → Analytics:** the page loads two Google tags (`GT-NFBT3Q7X` and `G-4ZZ9NH61V3`). Confirm that isn't double tracking the same property.
- **Plugin "agent-ready-wp-fix-settings-save-memory-fatal":** it loads `webmcp-runtime.js` on the front end. Find out who installed it and whether it's needed. Don't touch it without the owner's OK.

### B7. Service pages (drafts)
Create these pages as **drafts**, with the **Service** template from A2. Each draft needs:

- a slug
- an H1 (the page title)
- an excerpt
- Rank Math title and description (≤ 60 / ≤ 155 characters)
- a focus keyword
- 600–1000 words of content:
  - what's included
  - how the work runs, step by step
  - who it's for
  - 4–6 FAQs as Details blocks
- internal links to the Contact page and to the Aawan project

Pages:

1. `wordpress-website-development`: WordPress Website Design & Development. Keyword: wordpress developer.
2. `wordpress-plugin-theme-development`: Custom WordPress Plugin & Theme Development. Keyword: custom wordpress plugin development.
3. `website-speed-seo`: WordPress Speed Optimization & SEO. Keyword: wordpress speed optimization.
4. `wordpress-maintenance`: WordPress Maintenance & Security. Keyword: wordpress maintenance.
5. `laravel-development`: Laravel Web Application Development. Keyword: laravel developer.
6. `hosting-domains`: Hosting Management & Domain Registration. Keyword: wordpress hosting management.

Rules for the copy:

- Plain, specific language.
- No invented numbers, clients or guarantees.
- Anything that needs a real fact (prices, turnaround times, results) goes in [square brackets] for the owner to fill.

Leave all six as drafts and list them for the owner to review.

### B8. Arabic version (only after A1 ships, and with the owner's OK)
- Install Polylang (ask first). Add languages: English (default) and العربية (`ar`), URL mode `/ar/`.
- Translate as drafts: Home, About, Contact, the six service pages, and the Aawan project.
- Arabic target keywords:
  - الصفحة الرئيسية: مبرمج ووردبريس
  - صفحة تطوير مواقع ووردبريس: تصميم موقع ووردبريس / تصميم مواقع ووردبريس
  - صفحة Laravel: مبرمج لارافيل
- Check that hreflang tags appear on both language versions.

### B9. Indexing
- In Google Search Console (via Site Kit, or search.google.com/search-console):
  - Submit `https://a-salah.dev/sitemap_index.xml`.
  - Request indexing for the home page, About, Contact, and every service page once it's published.
- Purge LiteSpeed Cache after all changes.

### B10. robots.txt (optional, ask first)
`robots.txt` contains `Content-Signal: ai-train=no, search=yes, ai-input=no`. The `ai-input=no` part tells AI assistants and answer engines not to use the site's content in their answers.

Ask the owner whether they want to appear in those answers. If yes, change it to `ai-input=yes`. It's usually set by Hostinger or the CDN, not by WordPress.

---

## Report back
When done, list:

- each task: done / skipped / waiting on the owner
- every page URL you changed or created as a draft
- the Rich Results Test outcome for the home page and one post
- anything you found that isn't in this file
