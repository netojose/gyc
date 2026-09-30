# GYC theme – WordPress implementation guide

## 1. What the theme contains

| Area | Blocks | Where they live |
|---|---|---|
| Main page | `gyc/hero`, `gyc/about-us`, `gyc/video`, `gyc/community` | `templates/front-page.html` |
| Donate page | `gyc/page-hero`, `gyc/why-give`, `gyc/gift-options`, `gyc/call-to-action` | `templates/page-donate.html` (applies to the page with the slug `donate`) |
| FAQ page | `gyc/page-hero` (with search), `gyc/faq`, `gyc/contact-banner` | `templates/page-faq.html` (applies to the page with the slug `faq`) |
| Register page | `gyc/page-hero`, `gyc/registration-options`, `gyc/whats-included`, `gyc/info-cards`, `gyc/call-to-action` (mint style) | `templates/page-register.html` (applies to the page with the slug `register`) |
| About Us page | `gyc/image-hero`, `gyc/vision`, `gyc/mission`, `gyc/goals`, `gyc/committee`, `gyc/contact-banner` (with eyebrow) | `templates/page-about-us.html` (applies to the page with the slug `about-us`) |
| Header / footer | `gyc/header`, `gyc/footer` | `parts/header.html`, `parts/footer.html` (used by every template: `front-page.html`, `page-about-us.html`, `page-donate.html`, `page-faq.html`, `page-register.html`, `single-event.html`, `index.html`, `404.html`) |
| Event hero | `gyc/event-hero` | Inside each event's own content, one per event |
| Event content | `gyc/topics`, `gyc/agenda`, `gyc/people`, `gyc/pricing-table` | Inside each event's own content |

All blocks are dynamic: `render.php` outputs the HTML and the editor only shows sidebar fields. Each block starts with the text from the designs as its default content.

## 2. Build before deploying

`build/` and `build-site/` are in `.gitignore`, so a fresh checkout has no compiled CSS or JS. Without them WordPress shows `filemtime()` warnings. On every deploy, run:

```bash
npm install
npm run build:blocks   # block editor scripts → build/
npm run build:theme    # Tailwind → build-site/styles.css
npm run build:js       # Alpine → build-site/app.js
```

During development, run `start:blocks`, `start:theme` and `start:js` side by side.

- After adding or changing Tailwind classes in any `render.php`, rebuild the theme CSS, or the new classes won't exist.
- After adding a new block, restart `start:blocks`.

## 3. Local URLs (XAMPP)

| Page | URL |
|---|---|
| Home page (`front-page.html`) | http://localhost/gyc-main/ |
| About Us (`page-about-us.html`) | http://localhost/gyc-main/about-us/ |
| Donate (`page-donate.html`) | http://localhost/gyc-main/donate/ |
| FAQ (`page-faq.html`) | http://localhost/gyc-main/faq/ |
| Register (`page-register.html`) | http://localhost/gyc-main/register/ |
| Single event (`single-event.html`) – demo with every event block | http://localhost/gyc-main/event/demo-2027/ |
| Same event by ID | http://localhost/gyc-main/?post_type=event&p=18 (redirects to the address above) |
| Events archive | http://localhost/gyc-main/event/ |
| 404 page | Any address that doesn't exist, e.g. http://localhost/gyc-main/does-not-exist/ |
| Admin | http://localhost/gyc-main/wp-admin/ |

Every event's address is `http://localhost/gyc-main/event/<slug>/`, where the slug is set in the event's settings. `demo-2027` ("Stand Fast 2027 (Demo)", ID 18) is the local sample event: it uses every event block with dummy content.

## 4. Setting it up in WordPress

1. **Activate the theme** in Appearance → Themes.
2. **Home page:** `front-page.html` is used for the site's home page automatically, whatever Settings → Reading says. No page needs to be created for it.
3. **Home page sections:** go to Appearance → Editor → Templates → Front Page. Click a section and fill in its fields in the right sidebar.
4. **Headers and footers:** go to Appearance → Editor → Patterns → Template parts, then open **Header** or **Footer**. The same header and footer appear on every page, including events.
5. **Donate page:** create a page (Pages → Add new) titled "Donate" with the slug `donate`, and publish it. Its content can stay empty, because `page-donate.html` supplies the layout. Edit the sections in Appearance → Editor → Templates → Page: Donate.
   - The gift cards and the "Donate now" button have placeholder links (`#` and `#give`, which jumps to the gift cards). Replace them with the real donation or payment links before launch.
   - If the page's slug changes, the template no longer applies. Keep the slug as `donate`, or rename the template file to match.
   - `gyc/page-hero` is generic, so it can be reused on other inner pages.
6. **FAQ page:** create a page titled "FAQ" with the slug `faq`, publish it, and edit the sections in Appearance → Editor → Templates → Page: FAQ.
   - In the **FAQ** block, each category opens as its own panel in the sidebar. Questions and categories can be added, removed and renamed there.
   - **Replace the placeholder answers before launch.** Every answer currently says "Answer coming soon." Answers keep line breaks, and links can be added as HTML (`<a href="...">`).
   - The search box is part of the **Page Hero** block ("Show search" setting). It filters the FAQ block on the same page as the visitor types, so turn it on only on pages that have an FAQ block. It needs JavaScript, so without JavaScript it stays hidden and all questions remain visible.
   - The "Contact us" button in the **Contact Banner** links to `#contact`, which is the footer's contact area on the same page. Change it to a contact page or an email address if there is one.
7. **Register page:** create a page titled "Register" with the slug `register`, publish it, and edit the sections in Appearance → Editor → Templates → Page: Register.
   - **Price boxes (Registration Options block):** each box has a label, price, **Opens on** date, **Last day** date, and its own button label and link. Point each link to the registration form or ticket page for that price. The date line under the price ("Until Dec 31, 2026", "Jan 1 – Apr 30, 2027") is written automatically from the dates.
   - **Only one box is open at a time.** With **Which box is open** set to **Automatic** (the default), the open box is the first one whose dates include today. It is highlighted in mint and is the only one with a working button. The other boxes show "Opens soon" (not started yet) or "Closed" (ended or overridden); both labels can be edited. A box stays open until the end of its last day. An empty "Opens on" means open from now; an empty "Last day" means no end.
   - The setting can also be forced to **Always: <box>** (for example to close early bird before its date) or to **None – registration closed**. The notice at the top of the block's settings shows which box is open today.
   - **Keep the date ranges back to back without overlapping** (e.g. last day Dec 31, next box opens Jan 1). If they overlap, the earlier box in the list wins.
   - **Check the site timezone** in Settings → General. "Today" is worked out in that timezone, so boxes switch at midnight there. Use Central European Time: in the Timezone dropdown pick a CET city such as **Berlin** (listed under Europe), not a fixed "UTC+1", so summer time is handled. The local site is already set to Europe/Berlin.
   - **Page caching:** the open box is decided when the page is generated. If the live site uses a page cache (a caching plugin or hosting cache), make sure the cache expires at least daily, or clear it on the switch-over dates. Otherwise the old price may stay visible.
   - The "Register now" buttons in the What's Included card and the final mint strip link to `#pricing`, which scrolls to the price boxes, so they never skip the date rule.
   - **Info cards:** the "Contact us" button goes to the footer's contact area (`#contact`) and "View FAQ" goes to `/faq/`.
8. **About Us page:** create a page titled "About Us" with the slug `about-us`, publish it, and edit the sections in Appearance → Editor → Templates → Page: About Us.
   - **Photos:** none are set yet, so every photo slot shows a purple placeholder. Add photo URLs in the Image Hero (background), Vision (three photos), Mission (one per card) and Committee (one per member) blocks.
   - The hero photo sits behind a purple overlay and is treated as decoration, so it has no alt text field. Committee photos don't need alt text either, because each person's name is shown right below.
   - **Committee members are sample data from the design** (names, roles, emails and Instagram handles). Replace them with the real committee before launch. **Members shown larger** sets how many of the first members appear in the big top row (3 by default); the rest are shown five per row. Members can be reordered with Move up / Move down.
   - The goals are numbered automatically (01, 02, …) in the order they are listed.
   - The "Register now" button in the mint strip links to `/register/`.
   - The header's "About" menu item still points to the home page's About section (`#about-us`). Change it to `/about-us/` under Template parts → Header to link to this page.
9. **Events:** go to Events → Add new.
   - A new event starts with the **Event Hero** block. Its title falls back to the event title when the Title field is empty.
   - Below the hero, add Topics, Agenda, People and Pricing Table. These are the only blocks allowed in events; the list is in `GycEditor::allowed_block_types`.
   - The hero can be used only once per event. If it is deleted, it can be added back from the block inserter.
   - Events created before the hero became a block have no hero. Open each one and add the **Event Hero** block at the top.

## 5. Hints for editing content

- **Images are URL fields.** There is no media picker. Upload the image to the Media Library, then copy its File URL into the field. Always fill in the alt text; leave it empty only for purely decorative images.
- **Links** accept these formats:
  - `https://...` is used as is.
  - `/about` becomes a link on this site, so it survives a domain change.
  - `#about-us` or `#community` jumps to that section. In the header and footer it goes to the home page's section from any page. In the event hero it stays on the current event page, for example `#schedule`.
  - `name@example.com` becomes an email link.
  - A bare `#` is a placeholder that goes nowhere.
- **Copyright:** `{year}` is replaced with the current year.
- **Video:** accepts YouTube or Vimeo page URLs, or a direct `.mp4` URL. The poster image appears until someone presses play.
- **Newsletter:** the form only appears once **Form action** is filled in. For Mailchimp, use the embedded form's `action` URL and set the field name to `EMAIL`.
- **Social icons:** the header supports only `instagram`, `tiktok`, `youtube` and `facebook`.
- **Default images:** some defaults point to images on other websites, for example the logo on gyceurope.org. Replace them with Media Library URLs before launch.

## 6. Things to know about the Site Editor

- **Edits go to the database, not the theme files.** Once a template or template part is saved in the Site Editor, later changes to that `.html` file won't show. To pick up the file version again, use **Reset** in the template or part's ⋮ menu.
- **Changing defaults.** Changing a default in `block.json` only affects blocks whose field is still unchanged. It doesn't overwrite content an editor has already saved.
- **Moving template changes between local and live.** Appearance → Editor → ⋮ → Tools → **Export** gives a theme zip that includes the saved template and part changes. The other option is to redo the edits on the live site.
- **Event content is stored with each event,** so it moves with the normal WordPress export and import (Tools → Export).

## 7. Adding a new block

1. Create `blocks/<name>/` with `block.json`, `index.js`, `edit.js`, `save.js` (returns `null`), `render.php`, `view.js`, `style.css`, `style.scss` and `editor.scss`. Copying an existing block such as `blocks/event-hero/` is the quickest start.
2. Add `blocks/<name>` to both `start:blocks` and `build:blocks` in `package.json`.
3. Add an entry to `vite.config.js`.
4. Register it in `GycEditor::register_blocks()`. To make it available in events, also add it to `allowed_block_types`.
5. Keep Alpine expressions in `render.php` free of `>` and `&&`, because WordPress's `wptexturize` corrupts them. For anything more than a line or two, write an `Alpine.data()` component in `assets/js/` and register it in `assets/js/app.js` before `Alpine.start()`, as `assets/js/faq.js` does. Don't use a block's `view.js` for Alpine components: it loads after Alpine has already started.
6. Use `GycUI::resolve_url()` for links. Pass `false` as the second argument to keep `#anchors` on the current page.
