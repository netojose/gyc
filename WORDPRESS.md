# GYC theme – WordPress implementation guide

## 1. Pages and blocks

| Page | Local address | Template | Blocks |
|---|---|---|---|
| Home | http://localhost/gyc-main/ | `front-page.html` | `gyc/hero`, `gyc/about-us`, `gyc/video`, `gyc/community`, `gyc/event-modal` (congress pop-up) |
| About Us | http://localhost/gyc-main/about-us/ | `page-about-us.html` | `gyc/image-hero`, `gyc/vision`, `gyc/vision-statement`, `gyc/mission`, `gyc/goals`, `gyc/committee`, `gyc/spirit`, `gyc/contact-banner`, `gyc/focus` |
| Contact Us | http://localhost/gyc-main/contact-us/ | `page-contact-us.html` | `gyc/image-hero`, `gyc/contact` (contact cards, social links, message form) |
| Volunteer | http://localhost/gyc-main/volunteer/ | `page-volunteer.html` | `gyc/image-hero`, `gyc/volunteer` (ways to volunteer, application form) |
| Donate | http://localhost/gyc-main/donate/ | `page-donate.html` | `gyc/hero`, `gyc/why-give` (gift amounts, donation button), `gyc/gift-options` (other ways to give) |
| FAQ | http://localhost/gyc-main/faq/ | `page-faq.html` | `gyc/page-hero` (with search), `gyc/faq`, `gyc/contact-banner` (mint style, as the FAQ is an event page) |
| Participant info | http://localhost/gyc-main/participants-info/ | `page-participants-info.html` | `gyc/info-hero` (with section buttons), `gyc/info-registration`, `gyc/info-minors`, `gyc/info-cards` (Meals), `gyc/info-housing`, `gyc/info-venue` (with Google map), `gyc/info-cards` (Travel), `gyc/info-schedule`, `gyc/info-outreach`, `gyc/info-register-banner` |
| Events overview | http://localhost/gyc-main/events/ (filtered: `?organizer=europe` or `?organizer=focus`) | `page-events.html` | `gyc/image-hero`, `gyc/events-overview` |
| Single event | http://localhost/gyc-main/events/demo/ (or `?post_type=event&p=18`, which redirects there) | `single-event.html` | Stored in each event: `gyc/event-hero` (once), `gyc/countdown`, `gyc/topics`, `gyc/agenda`, `gyc/people`, `gyc/pricing-table` |
| Events archive | http://localhost/gyc-main/events/archive/ | Not built yet (`archive-event.html`); shows "Coming soon" from `index.html` | – |
| 404 and fallback | any missing address, e.g. http://localhost/gyc-main/does-not-exist/ | `404.html`, and `index.html` for pages without their own template | `gyc/hero` (text-only layout) |

- Templates are in `templates/`. The header and footer (`gyc/header`, `gyc/footer`) are in `parts/header.html` and `parts/footer.html` and appear on every page, including events.
- All blocks are dynamic: `render.php` outputs the HTML and the editor only shows sidebar fields. Each block starts with the text from the designs as its default content.
- Admin: http://localhost/gyc-main/wp-admin/

**Demo event** (`demo`, "Stand Fast 2027 (Demo)", ID 18) uses every event block with the copy from the event design. Its program runs Wednesday August 18 to Sunday August 22, with Registration & Welcome on the Wednesday. The hero uses the tagline, place and dates fields (no illustration yet). Its speakers mix filled and empty optional fields (bio, country, talks or workshops, day and time) so every case of the bio pop-up can be tested; Lukas Weber has three workshops, and Sarah Lindqvist's talk is typed without "Speaking on:". The countdown and the hero's register button are set to open on 30 November 2026, 10:00 CET.

## 2. Build before deploying

`build/` and `build-site/` are in `.gitignore`, so a fresh checkout has no compiled CSS or JS, and WordPress shows `filemtime()` warnings until it is built. On every deploy, run:

```bash
npm install
npm run build:blocks   # block editor scripts and the page sidebar panel (editor/page-settings) → build/
npm run build:theme    # Tailwind → build-site/styles.css
npm run build:js       # Alpine → build-site/app.js
```

During development, run `start:blocks`, `start:theme` and `start:js` side by side. Rebuild the theme CSS after adding Tailwind classes to any `render.php` (otherwise the classes don't exist), and restart `start:blocks` after adding a block.

## 3. Setting it up in WordPress

1. **Activate the theme** in Appearance → Themes.
2. **Create each inner page** in Pages → Add new with the slug from the table above (`about-us`, `contact-us`, `volunteer`, `donate`, `faq`, `events`, `participants-info`) and publish it. Its content can stay empty: the template supplies the layout. Edit the sections in Appearance → Editor → Templates → Page: <name>. **Keep the slug**: if it changes, the template no longer applies (or rename the template file to match). The home page needs no page: `front-page.html` is always used, whatever Settings → Reading says.
3. **Header and footer:** Appearance → Editor → Patterns → Template parts → Header or Footer.
4. **After deploying, go to Settings → Permalinks and click Save** (no changes needed), so `/events/archive/` and `/events/<slug>/` work.
5. Work through the **Before launch** checklist in section 7.

### Home page

Appearance → Editor → Templates → Front Page. Click a section and fill in its fields in the right sidebar.

- **Hero layout:** *Text on the left, photo behind* (default), *Text only, no photo* (text spans the content width on the cream background) or *Photo only, no text* (full-width photo). The sidebar shows only the fields the layout uses. With *Photo only*, keep the Title filled in (screen readers read it as the main heading) and give the photo alt text.
- **Community** has two images: the map and the photo collage. The collage is one image with the photos and the handwritten note in it, so put the note's words in its alt text. From 1024px the map takes 5 of 12 columns and the collage 3 (at most 384px), close to the map; on phones and tablets they stack. Until set, each shows a grey "Map" or "Photo collage" box.
- **Event Modal (congress pop-up):** opens once per browser session; closes with the ×, either button, Escape or a click outside. Once closed it stays hidden on reloads and while browsing in that tab, and shows again only in a new tab or after the browser is closed (reloading without closing it shows it again). To test again, use a new tab or private window. The "seen" flag is `gycEventModalSeen` in `sessionStorage` (`assets/js/event-modal.js`). Without JavaScript visitors just see the home page.
  - **Turn it off** with **Show the modal** in its settings, then save; the content is kept, and the panel title shows whether it is active.
  - The mint button links to `/events/` by default; a button is hidden when its label or link is empty. In **Notice**, `**two stars**` make words bold. The Where and When boxes appear only when filled in.
  - **Illustration** (Background illustration URL): until set, plain purple with hills. The title is real text on top, so use artwork without the title drawn in and keep its left side calm.
  - If Front Page was saved in the Site Editor before this block existed, add **Event Modal** from the inserter or reset the template (section 5). It can be added to any other template (once per template), but not inside events.

### Header and footer

- **Footer link columns:** Conference, GYC Europe, GYC Affiliates and Connect; add, remove and rename them under **Link columns**. Below 1280px the logo and description sit above the columns so all four fit in one row; from 1280px side by side.
- **Header button:** hidden because its label is empty in `parts/header.html`; type a label to show it (its link defaults to `#`). Social links live in the footer's Connect column and on the Contact page.
- **Dark header and footer:** per page or event, in the editor's **Page** tab → **Header and footer → Dark header and footer**. Pages start light (switch it on for the FAQ page, which is dark in the design); events start dark.
- **Newsletter:** off by default. Filling in its title, text or **Form action** adds a row below the link columns; the form itself appears only once **Form action** is set. For Mailchimp, use the embedded form's `action` URL and the field name `EMAIL`.

### About Us

- **Section order:** Image Hero, Vision (intro with three photos), Vision Statement ("Our vision"), Mission, Goals, Committee, Spirit of GYC, the aqua "Ready to join us?" strip (Contact Banner), Focus. Don't mix up **Vision** (`gyc/vision`, the intro "…makes Him known") and **Vision Statement** (`gyc/vision-statement`, the dark "Our vision" section).
- **If Page: About Us was saved in the Site Editor** before Vision Statement and Spirit of GYC were added and Focus moved to the end, reset the template (section 5) or make those changes by hand. Run `npm run build:blocks` after pulling.
- **Vision Statement:** text on the left, photo on the right with an aqua outline behind it (down and right). From 1024px it uses the same two halves as the intro, with the photo 24px in from each side so the outline lines up with the intro photos. On phones and tablets the photo is at most 448px wide, centred under the text.
- **Spirit of GYC:** ten points, each with a **Bold start** and **Text** (the rest of the sentence). Add or remove them under **Items**; numbering follows the order. Two columns from 768px.
- **Committee:** four per row, reorder with Move up / Move down. Email and Instagram appear only when filled in. Photos need no alt text (the name is right below).
- **Focus:** the last section, with an aqua "Visit GYC Focus" button (other websites open in a new tab). **Image type**: *Picture* (default) fills a box twice as wide as tall, cropping other shapes; *Logo* shows the whole image centred on a white card. The box appears only once an image URL is set.
- The hero photo sits behind a dark blue overlay and is decorative, so it has no alt text field.
- The header's "About" item links here; "Community" still jumps to the home page's Community section.

### Contact Us

- **Messages** are emailed to **Message form → Send messages to** (`info@gyceurope.org` by default) and never stored. Visitors don't see the address; replying answers the sender. Leave the field empty to hide the form.
- **Topics:** **Message form → Topics**, one per line; the chosen topic is added to the email subject.
- **Social icons** support `instagram`, `youtube`, `facebook` and `tiktok`.
- **Email delivery:** WordPress's own mail is often delivered poorly or marked as spam, so install an SMTP plugin (e.g. WP Mail SMTP) on the live site and send a test message. XAMPP can't send email, so locally the form shows "Your message could not be sent".
- **Spam protection:** a security token, a hidden field only bots fill in, and one message per minute per visitor.
- **Page caching:** the token expires after about a day, so cache this page for at most 12 hours (or exclude it), or visitors may see "The form expired".

### Volunteer

- Not in the header menu yet; add a menu item to `/volunteer/` if it should be.
- **Applications** are emailed to the Volunteer block's **Send applications to** field (if empty, to Settings → General → Administration Email Address) and never stored. Replying answers the applicant.
- **Fields:** full name, email, country, age (12–99), church membership, at least one skill, an optional note about experience, and the agreement checkbox; all but the note are required. Edit the skill buttons in **Skills**, one per line; the chosen skills are listed in the email.
- Email delivery, spam protection and caching work as on the Contact form.
- **Form shortcode** is set to `[gyc_registration_form]`. When the plugin providing it is active, its form replaces the built-in one (the title stays, and the recipient, skills, agreement, button and message fields are not used). Without the plugin, as locally, the built-in form is shown, never the raw shortcode. Clear the field to always use the built-in form.

### Donate

- **Donating happens on an external page,** set in Why Give → Donation card → **Donation page link** (`#give` jumps to this card). The button opens it in a new tab with a diagonal arrow, and the note under it says so; keep that meaning if you reword the note.
- The donation card sits right of the gift amounts from 1024px; below them, centred and at most 512px wide, on smaller screens.
- The hero uses the small-caps style here (section 4) and has no photo yet (Image URL).
- In **Other ways to give**, card links are optional; "Bank transfer" links to the Contact page for the bank details.

### FAQ

- Each FAQ category is its own sidebar panel; questions and categories can be added, removed and renamed. Answers keep line breaks and accept HTML links (`<a href="...">`).
- **Search** is the Page Hero's **Show search** setting. It filters the FAQ block on the same page, so only turn it on there. Without JavaScript it is hidden and all questions show.
- The Contact Banner's "Contact us" links to `/contact-us/`. `gyc/page-hero` can be reused on other inner pages.

### Participant info

- Not in the header menu yet; add a menu item to `/participants-info/` if it should be. The design uses the **dark header and footer**, so switch that on in the page's sidebar.
- **Section buttons:** the hero's eight buttons (**Section buttons** in Info Hero) jump to the sections below and glide there unless the visitor has reduced motion switched on. Each links to `#` plus a section's **Section ID** (`registration`, `under-18`, `meals`, `housing`, `venue`, `travel`, `schedule`, `outreach`). If you change a Section ID, change its button too. Buttons can be added, removed, reordered and given another icon. From 1024px they sit in one row; smaller screens show four per row.
- **Hiding sections:** each section has **Show this section**; its panel title then ends in "(hidden)". Remove or relink its hero button as well.
- **Info Cards** is used twice (Meals, Travel) and can be added again for other topics. Each has a background, three-per-row cards and optional wide cards (two per row) in white, purple or mint. Bullet points are typed one per line.
- **Registration:** the price with a badge (e.g. "Best price") is purple. Prices are shown as typed, so include the € sign. **Button active from (CET)** (30 November 2026, 10:00 by default) keeps "Register now" greyed out with "Opens 30 November 2026, 10:00 CET" under it until then, and switches it on by itself, as on events (see **Registration opening time**). It isn't linked to any event, so set it here too.
- **Housing:** until a hotel photo is set, a grey box with a bed icon is shown. With a **Booking link**, the hotel name links to it.
- **Venue map:** in Google Maps, find the venue, then click **Share → Embed a map → Copy HTML**, and paste it into Info Venue → Venue and map → **Google Maps embed** (the whole `<iframe>` code, or only its `src`). Only Google Maps addresses are embedded; anything else is ignored and the sidebar shows a warning. Without it, no map is shown. **Open in Google Maps** and **Get directions** open in a new tab and search for the venue name and address unless they have their own links.
- **Outreach** (Info Outreach) has three optional parts. Every empty field or part is left out, so it can grow as the plans are confirmed:
  - **Outreach events:** large cards, two per row (a single one fills the width). By default there are the purple *Outreach week* (before the conference) and the white *Outreach Sabbath* (during the conference). Each has a colour, small label, title, dates, place, text, bullet points (one per line), an optional photo and a button. The button can wait for an opening time, like the register buttons. Add more events for other outreach activities.
  - **Projects:** a title, a short text and cards (four per row, as many rows as needed) with an icon, title, text and an optional tag such as "Bring: Your Bible", lined up along the bottom of each row. The cards have no buttons: participants choose their project on the external registration portal, which the **Register for a project** button centred at the end of the section, after the note, links to (Projects panel: label, link and an optional opening time; it opens in a new tab, and an empty label or link hides it).
  - **Adding, changing and removing activities:** Appearance → Editor → Templates → Page: Participant info → click the Outreach section → **Project cards** in the sidebar (outreach events work the same under **Outreach events**). **Add project** adds a card at the end; **Move up / Move down** reorders; **Remove project** deletes it. Save the template afterwards.
  - **Icons:** pick one from **Icon** (None hides it). If none fits, upload your own to the Media Library and paste its File URL into **Own icon image URL**, which replaces the chosen icon. Use a square PNG with a transparent background in dark purple (#2d1b33), at least 96 × 96 px, so it matches the other icons on the mint square (WordPress doesn't accept SVG uploads by default).
  - The eight Sabbath projects have draft descriptions and "Bring:" tags to check. Buttons can jump here with `#outreach-projects` (the Section ID plus `-projects`); "See the projects" does this by default.
  - **Note:** a mint box at the bottom.
  - The copy for the outreach week and the Sabbath intro is a placeholder; the projects come from the design.
- **Register banner** (Info Register Banner): the mint strip at the end with label, title, text and a register button. Like Registration, the button is greyed out until **Button active from (CET)** (30 November 2026, 10:00) and isn't linked to other sections, so set its time and link separately.

### Events overview

- **Cards are entered by hand** in the Events Overview block under **Upcoming events**, so GYC Focus events (on another site) and recurring meetings like United Prayer can sit next to GYC Europe events. Adding an event under Events → Add new does not add a card. Remove events once they are over.
- Each card has an **Organizer** (filter and coloured tag). **Featured** makes a full-width card with two buttons, normally the main conference. **Move up / Move down** changes the order.
- The white **date badge** has two lines (e.g. "Mon" / "18" or "Daily" / "7:00"); leave both empty to hide it. **Online event** adds an "Online" tag.
- Links to other websites open in a new tab with a diagonal arrow.
- The chosen filter is kept in the address (`/events/?organizer=focus`), so it can be linked to. Without JavaScript the filter is hidden and every event shows.
- **Archive:** `/events/archive/` is a separate page, still to be built (`templates/archive-event.html`); until then it shows "Coming soon". Addresses are set in `UI/GycEvent.php` (`has_archive`, `rewrite`). The old `/event/` redirects to the Events page, but old single-event addresses like `/event/demo-2027/` no longer work.

### Events

Go to Events → Add new. Each event's address is `/events/<slug>/`; never use the slug `archive`. Allowed blocks are Event Hero (once; re-add it from the inserter if deleted), Countdown, Topics, Agenda, People and Pricing Table (`GycEditor::allowed_block_types`).

- **Hiding sections:** every section except the hero has a switch that hides it without losing content, and its panel title then ends in "(hidden)": **Show this section** (Countdown, Topics, Pricing table), **Show the program** (Agenda), **Show main speakers** / **Show workshop speakers** (People; with both off the section is hidden). Unneeded sections can also be removed.
- **Section links:** `#schedule` (Program), `#speakers` and `#register` (price boxes). The hero's "Register now" uses `#register` by default. When you hide or remove the Agenda, both speaker groups or the Pricing table, change any hero button that links there.

**Event Hero**
- The title falls back to the event title when empty. For the two-colour title, put "Stand" in **Title – first word in mint** and "Fast" in **Title – second word in ivory** (same line). **Tagline** is an optional italic line with a short mint underline. **Place** and **Dates** show on two lines, dates in mint. The numbers row appears only when filled in.
- **Text is shown as typed:** place, dates and tagline are never capitalised, so type them as they should look (the design uses "KATOWICE, POLAND" and "AUGUST 18–22, 2027"). The small-caps title shows "STAND" at full height, or "Stand" as a large S with smaller capitals.
- **Illustration** (Background illustration URL): stars, mountains and hikers all come from the image; the block adds only the purple background and a light fade on the left. Without one it shows plain purple with hills.
- **Older events** keep place and dates in one line, shown in a **Place and dates (old single line)** field until Place or Dates is filled in. Move the text over and clear it.

**Registration opening time**
- The hero's **First link active from (CET)** and each Events overview card's **Main button / Link active from (CET)** keep that button greyed out and unclickable until the given date and time, with "Opens 30 November 2026, 10:00 CET" under it. Leave it empty to keep the button active.
- Times are always Central European Time (CEST in summer), whatever the site timezone. At that moment the button switches on by itself in the visitor's browser (`assets/js/registration-opens.js`), so cached pages and open tabs need no reload; it uses the visitor's clock.
- The hero and the Countdown share one time: whichever has its field empty uses the other's. The overview cards are not linked to events, so **set the card's time too**.

**Countdown**
- Sits right below the hero (new events get it; add it on older ones). It counts days, hours, minutes and seconds to **Counts down to (CET)**, shows the date, then optional text, two buttons and a small note.
- It appears only while that time is in the future and hides itself when it is reached, even on an open page.
- Without a link, the first button ("Add to calendar") downloads a calendar reminder for the opening time.

**Agenda**
- Each day becomes a left-aligned button above the sessions, wrapping onto more rows (at most three per row on tablets, 768–1023px). The headline defaults to "Five days. One purpose."; match it to the event's length.

**Topics** (Our mission)
- The headline defaults to "Five days to go deeper and stand fast"; adjust it for other lengths. Leave an empty line between paragraphs, and use `**two stars**` for bold (like **stand fast**). The cards are optional.

**People**
- Main speakers are photo cards with name, role and country underneath; their text size follows their number (larger with one or two, smaller with four or more). Workshop speakers are in a box below, with initials when there is no photo; their country shows only in the bio.
- **Speaker fields:** **Photo**, **Name**, **Role** (e.g. "Pastor · Student ministry"), and optionally **Country**, **Description** (the bio) and a list of **talks** (main) or **workshops** (workshop speakers), each with an optional title and **Day and time** (e.g. "Thursday · 10:00"). Titles are shown exactly as typed, so write "Speaking on: …" or "Workshop: …" only if you want that word in front.
- **Bio pop-up:** clicking a main speaker's photo card (not the name) or any workshop speaker opens their bio. A "Tap a speaker to get to know them" hint sits next to the section title when there are main speakers. Each bio shows, in order: "Main speaker" or "Workshop speaker", name, role, country, bio, then one pill per talk or workshop; empty fields are left out.
- **Moving between bios:** previous and next arrows with a counter ("3 / 10"), the ← and → keys, or swiping on phones; main speakers first, then workshop speakers. It closes with the ×, Escape or a click outside, and focus returns to the card that opened it.
- **Speaker links:** each bio has its own address, e.g. `/events/demo/#speaker-lukas-weber`, which opens it straight away. It is made from the name, so **renaming a speaker breaks shared links**; duplicate names get `-2`, `-3`.
- **Older speakers** keep a single **Headline (old field)**, shown in the pop-up until a talk or workshop is added; then clear it.

**Pricing table**
- A box with a badge (e.g. "Popular") is highlighted. The button label and the link under the boxes are set once for the block; the link goes to `/faq/` by default (**Contact link label**, **Contact link**).

## 4. Hints for editing content

- **Typography:** the home page uses all-caps headlines and all-caps, letter-spaced buttons (the Event Modal too). Everywhere else (inner pages, events, header, footer) uses small-caps headlines and pill buttons in normal case, so **type headlines in normal case** ("Our mission"). The Hero block switches by itself: all caps on the home page, small caps on Donate, 404 and fallback pages.
- **Images are URL fields** (no media picker): upload to the Media Library and paste its File URL. Always fill in alt text, except for purely decorative images.
- **Links:**
  - `https://...` is used as is.
  - `/about` links within this site and survives a domain change.
  - `#about-us` jumps to that section; in the header and footer it goes to the home page's section from any page, and in the event hero it stays on the event page (e.g. `#schedule`).
  - `name@example.com` becomes an email link.
  - A bare `#` is a placeholder that goes nowhere.
- **Copyright:** `{year}` becomes the current year.
- **Video:** YouTube or Vimeo page URLs, or a direct `.mp4`. The poster shows until play is pressed. On the home page, **Video URL** is what plays and **Link URL** is where "Watch now" goes (e.g. the YouTube channel).

## 5. Things to know about the Site Editor

- **Edits go to the database, not the theme files.** Once a template or part is saved in the Site Editor, later changes to its `.html` file won't show. Use **Reset** in its ⋮ menu to go back to the file.
- **Defaults** in `block.json` only affect fields an editor hasn't changed.
- **Moving template changes between local and live:** Appearance → Editor → ⋮ → Tools → **Export** gives a theme zip with the saved templates and parts; otherwise redo the edits on the live site.
- **Event content is stored with each event,** so it moves with Tools → Export / Import.

## 6. Adding a new block

1. Create `blocks/<name>/` with `block.json`, `index.js`, `edit.js`, `save.js` (returns `null`), `render.php`, `view.js`, `style.css`, `style.scss` and `editor.scss`; copying `blocks/event-hero/` is the quickest start.
2. Add `blocks/<name>` to `start:blocks` and `build:blocks` in `package.json`.
3. Register it in `GycEditor::register_blocks()`; for events, also add it to `allowed_block_types`.
4. **Alpine:** keep expressions in `render.php` free of `>` and `&&` (`wptexturize` corrupts them). For more than a line or two, write an `Alpine.data()` component in `assets/js/` and register it in `assets/js/app.js` before `Alpine.start()`, like `faq.js`. To pass a list, print it as JSON in `<script type="application/json" x-ref="data">` and read it in `init()`, like `people.js`. Don't put Alpine components in a block's `view.js`: it loads after Alpine has started.
5. **Layout and type:** wrap content in `max-w-content mx-auto px-6 md:px-12` (width set as `--container-content` in `assets/css/app.css`). Headlines use `font-display` (Anton, single weight, so no `font-bold`/`font-extrabold`); everything else uses `font-jakarta`. Use `uppercase` only on home page blocks. Shared styles:
   - Page title (h1): `font-display small-caps text-5xl md:text-7xl leading-none` (event hero: `text-6xl md:text-7xl lg:text-[6.5rem] leading-[0.95]`).
   - Section heading (h2): `font-display small-caps text-4xl md:text-5xl leading-none`.
   - Card heading (h3): `font-display small-caps text-xl leading-tight`.
   - Label above a heading: `font-jakarta text-xs font-bold tracking-[0.25em] uppercase`.
   - Intro text: `font-jakarta text-sm md:text-base leading-relaxed` at 80% opacity; card text: `font-jakarta text-sm leading-relaxed`.
   - Button: `rounded-full px-7 py-3.5 font-jakarta text-sm font-semibold`, with a `h-4 w-4` arrow icon if any.
   - Cards: `rounded-2xl` (`rounded-3xl` for large ones).
6. Use `GycUI::resolve_url()` for links; pass `false` as the second argument to keep `#anchors` on the current page.

## 7. Before launch

Placeholders (`#` or sample content) still to replace:

- [ ] **Registration links** (external registration page): About Us "Get involved" button, footer Conference → "Register", the header button's link (if shown), and each event's price box links.
- [ ] **Donate:** Why Give → **Donation page link**.
- [ ] **Event Modal:** point the mint button to the congress page or external event site, and add the illustration.
- [ ] **Footer:** GYC Affiliates → "GYC Focus UK" link.
- [ ] **Contact:** YouTube and Facebook social links.
- [ ] **Volunteer:** **Send applications to** is a dummy (`volunteer@example.com`).
- [ ] **Events overview:** the GYC Focus cards ("[Focus event name]"), the United Prayer link, the past events' "Watch the sessions" links, and the featured card's "More information" link (points to `/events/demo/`).
- [ ] **Demo event:** the Countdown's Instagram link (second button).
- [ ] **FAQ:** every answer says "Answer coming soon."
- [ ] **About Us:** the committee ("Full name", "Country" with the eight roles) and all photos (Vision ×3, Vision Statement, Mission cards, Committee; Image Hero optional).
- [ ] **Participant info:** every `[…]` placeholder (prices, dates, hotels, venue, travel times), the Google Maps embed, hotel photos, the register button links (`#` in Registration, the Register banner, "Join the outreach week" and "Register for a project"), each outreach project's description, and the Outreach copy.
- [ ] **Home:** both Community images (map and collage) and the video's **Link URL**.
- [ ] **Donate:** hero photo.
- [ ] **Default images** pointing to other websites (e.g. the logo on gyceurope.org): replace with Media Library URLs.
- [ ] **Live site:** install an SMTP plugin and send a test message; set page caching so Contact and Volunteer expire within 12 hours; switch on the dark header and footer on the FAQ page.
