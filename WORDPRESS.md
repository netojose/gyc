# GYC theme – WordPress implementation guide

## 1. What the theme contains

| Area | Blocks | Where they live |
|---|---|---|
| Main page | `gyc/hero`, `gyc/about-us`, `gyc/video`, `gyc/community`, `gyc/event-modal` (congress pop-up) | `templates/front-page.html` |
| Donate page | `gyc/hero`, `gyc/why-give` (gift amounts and donation button), `gyc/gift-options` (other ways to give) | `templates/page-donate.html` (applies to the page with the slug `donate`) |
| FAQ page | `gyc/page-hero` (with search), `gyc/faq`, `gyc/contact-banner` | `templates/page-faq.html` (applies to the page with the slug `faq`) |
| Register page | `gyc/page-hero`, `gyc/registration-options`, `gyc/whats-included`, `gyc/info-cards`, `gyc/call-to-action` (mint style) | `templates/page-register.html` (applies to the page with the slug `register`) |
| About Us page | `gyc/image-hero`, `gyc/vision`, `gyc/mission`, `gyc/goals`, `gyc/committee`, `gyc/contact-banner` | `templates/page-about-us.html` (applies to the page with the slug `about-us`) |
| Contact Us page | `gyc/image-hero`, `gyc/contact` (contact cards, social links and message form) | `templates/page-contact-us.html` (applies to the page with the slug `contact-us`) |
| Header / footer | `gyc/header`, `gyc/footer` | `parts/header.html`, `parts/footer.html` (used by every template: `front-page.html`, `page-about-us.html`, `page-contact-us.html`, `page-donate.html`, `page-faq.html`, `page-register.html`, `single-event.html`, `index.html`, `404.html`) |
| 404 and fallback pages | `gyc/hero` (text-only layout) | `templates/404.html`, and `templates/index.html` for any page without its own template, such as the events archive |
| Event hero | `gyc/event-hero` | Inside each event's own content, one per event |
| Event content | `gyc/topics`, `gyc/agenda`, `gyc/people`, `gyc/pricing-table` | Inside each event's own content |

All blocks are dynamic: `render.php` outputs the HTML and the editor only shows sidebar fields. Each block starts with the text from the designs as its default content.

## 2. Build before deploying

`build/` and `build-site/` are in `.gitignore`, so a fresh checkout has no compiled CSS or JS. Without them WordPress shows `filemtime()` warnings. On every deploy, run:

```bash
npm install
npm run build:blocks   # block editor scripts and the page sidebar panel (editor/page-settings) → build/
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
| Contact Us (`page-contact-us.html`) | http://localhost/gyc-main/contact-us/ |
| Donate (`page-donate.html`) | http://localhost/gyc-main/donate/ |
| FAQ (`page-faq.html`) | http://localhost/gyc-main/faq/ |
| Register (`page-register.html`) | http://localhost/gyc-main/register/ |
| Single event (`single-event.html`) – demo with every event block | http://localhost/gyc-main/event/demo-2027/ |
| Same event by ID | http://localhost/gyc-main/?post_type=event&p=18 (redirects to the address above) |
| Events archive | http://localhost/gyc-main/event/ |
| 404 page | Any address that doesn't exist, e.g. http://localhost/gyc-main/does-not-exist/ |
| Admin | http://localhost/gyc-main/wp-admin/ |

Every event's address is `http://localhost/gyc-main/event/<slug>/`, where the slug is set in the event's settings. `demo-2027` ("Stand Fast 2027 (Demo)", ID 18) is the local sample event: it uses every event block with the copy from the event design and sample speakers and sessions.

## 4. Setting it up in WordPress

1. **Activate the theme** in Appearance → Themes.
2. **Home page:** `front-page.html` is used for the site's home page automatically, whatever Settings → Reading says. No page needs to be created for it.
3. **Home page sections:** go to Appearance → Editor → Templates → Front Page. Click a section and fill in its fields in the right sidebar.
   - The **Hero** block has a **Layout** setting: *Text on the left, photo behind* (the default), *Text only, no photo* (text spans the content width on the cream background), or *Photo only, no text* (a full-width photo). The sidebar shows only the fields the chosen layout uses. With *Photo only*, the Title is still read by screen readers as the page's main heading, so keep it filled in, and give the photo alt text.
   - The **Community** block has two images: the map and the photo collage. The collage is a single image with the photos and the handwritten note already in it. Because the note is part of the picture, put its words in the collage's alt text so screen reader users get them too.
   - The **Event Modal** block is the congress pop-up. It opens over the home page on every visit, including after a reload, and closes with the ×, the outlined button, the Escape key or a click outside it. **To switch it off, open the block's settings and turn off "Show the modal"**, then save; its content is kept for next time. The block's panel title shows whether it is active or disabled. The modal needs JavaScript, so without it visitors simply see the home page.
   - **Event Modal content:** the mint button's link defaults to the events archive (`/event/`); point it to the congress page or the external event site before launch. The button is hidden when its label or link is empty. In the **Notice** line, put `**two stars**` around words to make them bold. Each of the two boxes (Where, When) only appears when its value is filled in.
   - **Event Modal illustration:** none is set yet, so the top shows plain purple with hills. Add one under Background illustration URL. The title is real text placed on top of it, so use artwork without the title drawn in, and keep the left side of the picture calm so the text stays readable.
   - If the Front Page template was already saved in the Site Editor before this block existed, the pop-up won't appear on its own: add **Event Modal** from the block inserter (anywhere in the template), or reset the template (see section 6). The same block can be added to any other template to show the pop-up there too, once per template. It isn't available inside events.
4. **Headers and footers:** go to Appearance → Editor → Patterns → Template parts, then open **Header** or **Footer**. The same header and footer appear on every page, including events.
   - **Dark header and footer:** any page or event can show the header and footer in dark purple. Open it in Pages (or Events), and in the right sidebar under the **Page** tab find **Header and footer → Dark header and footer**, switch it on and save. It only affects that page. Pages start light: the FAQ page uses dark in the design, so switch it on there after creating the page. Events start dark; switch it off on an event to give it the light header and footer.
5. **Donate page:** create a page (Pages → Add new) titled "Donate" with the slug `donate`, and publish it. Its content can stay empty, because `page-donate.html` supplies the layout. Edit the sections in Appearance → Editor → Templates → Page: Donate.
   - **Donating happens on an external page.** The "Donate now" button in the **Make a donation** card (Why Give block → Donation card → Donation page link) is still a placeholder (`#`). Set it to the real donation page before launch. The `#give` anchor jumps to this card.
   - The hero is the same **Hero** block as on the home page. It has no photo yet; add one under Image URL.
   - In **Other ways to give**, each card's link is optional. "Bank transfer" links to the Contact page so people can ask for the bank details.
   - If the page's slug changes, the template no longer applies. Keep the slug as `donate`, or rename the template file to match.
6. **FAQ page:** create a page titled "FAQ" with the slug `faq`, publish it, and edit the sections in Appearance → Editor → Templates → Page: FAQ.
   - In the **FAQ** block, each category opens as its own panel in the sidebar. Questions and categories can be added, removed and renamed there.
   - **Replace the placeholder answers before launch.** Every answer currently says "Answer coming soon." Answers keep line breaks, and links can be added as HTML (`<a href="...">`).
   - The search box is part of the **Page Hero** block ("Show search" setting). It filters the FAQ block on the same page as the visitor types, so turn it on only on pages that have an FAQ block. It needs JavaScript, so without JavaScript it stays hidden and all questions remain visible.
   - The "Contact us" button in the **Contact Banner** links to the Contact page (`/contact-us/`).
   - `gyc/page-hero` is generic, so it can be reused on other inner pages.
7. **Register page:** create a page titled "Register" with the slug `register`, publish it, and edit the sections in Appearance → Editor → Templates → Page: Register.
   - **Price boxes (Registration Options block):** each box has a label, price, **Opens on** date, **Last day** date, and its own button label and link. Point each link to the registration form or ticket page for that price. The date line under the price ("Until Dec 31, 2026", "Jan 1 – Apr 30, 2027") is written automatically from the dates.
   - **Only one box is open at a time.** With **Which box is open** set to **Automatic** (the default), the open box is the first one whose dates include today. It is highlighted in mint and is the only one with a working button. The other boxes show "Opens soon" (not started yet) or "Closed" (ended or overridden); both labels can be edited. A box stays open until the end of its last day. An empty "Opens on" means open from now; an empty "Last day" means no end.
   - The setting can also be forced to **Always: <box>** (for example to close early bird before its date) or to **None – registration closed**. The notice at the top of the block's settings shows which box is open today.
   - **Keep the date ranges back to back without overlapping** (e.g. last day Dec 31, next box opens Jan 1). If they overlap, the earlier box in the list wins.
   - **Check the site timezone** in Settings → General. "Today" is worked out in that timezone, so boxes switch at midnight there. Use Central European Time: in the Timezone dropdown pick a CET city such as **Berlin** (listed under Europe), not a fixed "UTC+1", so summer time is handled. The local site is already set to Europe/Berlin.
   - **Page caching:** the open box is decided when the page is generated. If the live site uses a page cache (a caching plugin or hosting cache), make sure the cache expires at least daily, or clear it on the switch-over dates. Otherwise the old price may stay visible.
   - The "Register now" buttons in the What's Included card and the final mint strip link to `#pricing`, which scrolls to the price boxes, so they never skip the date rule.
   - **Info cards:** the "Contact us" button goes to the Contact page (`/contact-us/`) and "View FAQ" goes to `/faq/`.
8. **About Us page:** create a page titled "About Us" with the slug `about-us`, publish it, and edit the sections in Appearance → Editor → Templates → Page: About Us.
   - **Photos:** none are set yet, so every photo slot shows a grey placeholder. Add photo URLs in the Vision (three photos), Mission (one per card) and Committee (one per member) blocks. The Image Hero can also take an optional background photo.
   - The hero photo sits behind a dark blue overlay and is treated as decoration, so it has no alt text field. Committee photos don't need alt text either, because each person's name is shown right below.
   - **Committee members are placeholders from the design** ("Full name" and "Country" with the eight roles). Replace them with the real committee before launch. Members are shown four per row and can be reordered with Move up / Move down. Email and Instagram are optional and only appear when filled in.
   - **Headings on this page use small caps:** type them in normal case ("Our mission"), not in capitals, so the lowercase letters show as smaller capitals.
   - The "Get involved" button in the mint strip links to `/register/`.
   - The header's "About" menu item links to this page (`/about-us/`). "Community" still jumps to the home page's Community section.
9. **Contact Us page:** create a page titled "Contact us" with the slug `contact-us`, publish it, and edit the sections in Appearance → Editor → Templates → Page: Contact us. The header's "Contact" menu item links to `/contact-us/`.
   - **Where messages go:** the form emails each message to the address in the Contact block's **Message form → Send messages to** field (`info@gyceurope.org` by default). Visitors never see this address. Replying to the email answers the sender directly. Leave the field empty to hide the form.
   - **Email delivery:** the form uses WordPress's own mail sending. Many hosts deliver it poorly or mark it as spam, so install an SMTP plugin (for example WP Mail SMTP) on the live site and send a test message after launch. Locally, XAMPP can't send email, so the form shows "Your message could not be sent".
   - **Spam protection:** a security token, a hidden field that only bots fill in, and a limit of one message per minute from the same visitor. Messages aren't stored on the site, only emailed.
   - **Page caching:** the form's security token expires after about a day. If the live site caches pages, set the cache for this page to expire within 12 hours (or exclude it), otherwise visitors may see "The form expired".
   - **Topics:** edit the topic buttons in **Message form → Topics**, one per line. The chosen topic is added to the email subject.
   - **Social icons** under the cards support `instagram`, `youtube`, `facebook` and `tiktok`. The YouTube and Facebook links are placeholders (`#`); add the real addresses before launch.
10. **Events:** go to Events → Add new.
   - A new event starts with the **Event Hero** block. Its title falls back to the event title when the Title field is empty. For the two-colour title from the design, put "Stand" in **Title – first line** and "Fast" in **Title – second line in mint**. Add the place and dates and, optionally, a background illustration. The numbers row only appears when numbers are filled in.
   - The event sections link to each other: `#schedule` (Program), `#speakers` and `#register` (price boxes). The hero's "Register now" button uses `#register` by default.
   - **Topics** (Our mission): leave an empty line between paragraphs and put `**two stars**` around words to make them bold, like **stand fast** in the design. The cards under it are optional.
   - **People:** main speakers show their role under the name, and clicking one opens their headline and description. Workshop speakers without a photo show their initials.
   - **Pricing table:** a box with a badge (for example "Popular") is highlighted. The button label and the contact email under the boxes are set once for the whole block.
   - Below the hero, add Topics, Agenda, People and Pricing Table. These are the only blocks allowed in events; the list is in `GycEditor::allowed_block_types`.
   - The hero can be used only once per event. If it is deleted, it can be added back from the block inserter.

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
- **Newsletter:** the footer has no newsletter by default. Filling in its title, text or **Form action** adds it as a row below the link columns, and the form itself only appears once **Form action** is filled in. For Mailchimp, use the embedded form's `action` URL and set the field name to `EMAIL`.
- **Header:** the header has the logo, the menu and an optional button. The button is hidden because its label is empty in `parts/header.html`; type a label under Template parts → Header to show it (its link defaults to `/register/`). Social media links live in the footer's Connect column and on the Contact page.
- **Default images:** some defaults point to images on other websites, for example the logo on gyceurope.org. Replace them with Media Library URLs before launch.

## 6. Things to know about the Site Editor

- **Edits go to the database, not the theme files.** Once a template or template part is saved in the Site Editor, later changes to that `.html` file won't show. To pick up the file version again, use **Reset** in the template or part's ⋮ menu.
- **Changing defaults.** Changing a default in `block.json` only affects blocks whose field is still unchanged. It doesn't overwrite content an editor has already saved.
- **Moving template changes between local and live.** Appearance → Editor → ⋮ → Tools → **Export** gives a theme zip that includes the saved template and part changes. The other option is to redo the edits on the live site.
- **Event content is stored with each event,** so it moves with the normal WordPress export and import (Tools → Export).

## 7. Adding a new block

1. Create `blocks/<name>/` with `block.json`, `index.js`, `edit.js`, `save.js` (returns `null`), `render.php`, `view.js`, `style.css`, `style.scss` and `editor.scss`. Copying an existing block such as `blocks/event-hero/` is the quickest start.
2. Add `blocks/<name>` to both `start:blocks` and `build:blocks` in `package.json`.
3. Register it in `GycEditor::register_blocks()`. To make it available in events, also add it to `allowed_block_types`.
4. Keep Alpine expressions in `render.php` free of `>` and `&&`, because WordPress's `wptexturize` corrupts them. For anything more than a line or two, write an `Alpine.data()` component in `assets/js/` and register it in `assets/js/app.js` before `Alpine.start()`, as `assets/js/faq.js` does. Don't use a block's `view.js` for Alpine components: it loads after Alpine has already started.
5. Wrap the section's content in `max-w-content mx-auto px-6 md:px-12` so it lines up with the header and other sections. The width is set once as `--container-content` in `assets/css/app.css`. Headlines use `font-display` (Anton), either in capitals (`uppercase`) or in small caps (`small-caps`, with the text typed in normal case). Anton has a single weight, so don't add `font-bold` or `font-extrabold` to it. Body text, labels and buttons use `font-jakarta`.
6. Use `GycUI::resolve_url()` for links. Pass `false` as the second argument to keep `#anchors` on the current page.
