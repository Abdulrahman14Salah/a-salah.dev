# a-salah.dev

WordPress theme for [a-salah.dev](https://a-salah.dev): a clean white portfolio for Abdulrahman Salah (WordPress & Laravel developer).

## Setup after activating the theme

1. **Pages**
   - Create a page for the home page and a page for the blog, then set both in **Settings → Reading** ("A static page").
   - About page: edit it and choose the **About** template. The page excerpt becomes the intro line, and the featured image becomes the portrait.
   - Contact page: choose the **Contact** template. The page content becomes the intro text.
2. **Menus**: assign a menu to **Primary Menu** (header) and **Footer Menu** in **Appearance → Menus**.
3. **Theme Options** (**Appearance → Customize → Theme Options**): hero text, email, phone, WhatsApp, GitHub, LinkedIn, footer credit, and the contact form shortcode (for example `[contact-form-7 id="37" title="Contact"]`).
4. **Projects**: add them under **Projects** in the dashboard. The featured image is the screenshot, the excerpt is the one-line summary, and the "Project details" box holds client, service, language, year, live URL and tags. Existing `/project/…` links keep working.

## Structure

- `front-page.php`: home (hero, tools, services, projects, about, latest posts, contact).
- `page-templates/about.php`, `page-templates/contact.php`: page templates.
- `home.php`, `archive.php`, `single.php`: blog.
- `archive-project.php` (`/work/`), `single-project.php`: portfolio.
- `inc/theme/`: Customizer options, the `project` post type, template tags.
- `assets/css/main.css`, `assets/js/main.js`: all styles and the mobile menu. No build step.

Releases are built by `.github/workflows/build-theme.yml` when a GitHub release is published.
