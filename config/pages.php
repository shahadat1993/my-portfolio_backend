<?php
/*
 | PAGE CONTENT schema — every text, button, image and show/hide switch on every page of the website.
 | Admin → Pages → (page) → (section) edits these. Add a field here and it appears in admin + in the React site's settings.
 */
$T = fn ($k, $l, $d = '', $x = []) => ['key' => $k, 'label' => $l, 'type' => 'text', 'default' => $d] + $x;
$A = fn ($k, $l, $d = '', $x = []) => ['key' => $k, 'label' => $l, 'type' => 'textarea', 'default' => $d] + $x;
$S = fn ($k, $l = 'Show this section on the page', $d = '1') => ['key' => $k, 'label' => $l, 'type' => 'toggle', 'default' => $d];
$I = fn ($k, $l, $h = '') => ['key' => $k, 'label' => $l, 'type' => 'image', 'help' => $h];
$L = fn ($k, $l, $d = [], $h = 'One item per line') => ['key' => $k, 'label' => $l, 'type' => 'list', 'default' => $d, 'help' => $h];
$N = fn ($k, $l, $d = '') => ['key' => $k, 'label' => $l, 'type' => 'number', 'default' => $d];
$LNK = 'Internal: /about, /projects, /contact … or a full https:// URL';
$sec = fn ($label, $fields, $icon = 'bx-layer') => ['label' => $label, 'icon' => $icon, 'fields' => $fields];
$seo = fn ($p) => $sec('SEO (Google & sharing)', [
    $T("{$p}_seo_title", 'SEO title', '', ['help' => 'Leave empty to use the default format. 50–60 characters is ideal.']),
    $A("{$p}_seo_description", 'Meta description', '', ['help' => '150–160 characters. Leave empty to use the default from Site settings → SEO.']),
    $I("{$p}_seo_image", 'Social share image (1200×630)'), $S("{$p}_seo_noindex", 'Hide this page from search engines (noindex)', '0'),
], 'bx-search-alt');
$cta = fn ($p) => $sec('Bottom call-to-action band', [$S("{$p}_cta_show", 'Show the call-to-action band'), ['key' => "{$p}_cta_note", 'label' => '', 'type' => 'note', 'help' => 'The text of this band is shared by all pages: Pages → Shared blocks.']], 'bx-rocket');

$process = [
    ['title' => 'Discover', 'text' => 'We talk through goals, users and constraints, then scope the work into clear phases.'],
    ['title' => 'Design', 'text' => 'Wireframes, a visual direction and motion ideas — agreed before any code is written.'],
    ['title' => 'Build', 'text' => 'API, admin and front end built in small, reviewable steps with regular demos.'],
    ['title' => 'Ship', 'text' => 'Testing, deployment and handover, plus support once the product is live.'],
];
$rows2 = [['key' => 'title', 'label' => 'Title', 'type' => 'text'], ['key' => 'text', 'label' => 'Text', 'type' => 'textarea']];
$tools = ['Laravel', 'React', 'React Native', 'Expo', 'MySQL', 'REST APIs', 'Sanctum', 'Spatie', 'Tailwind', 'Bootstrap', 'GSAP', 'Vite', 'Git', 'Linux'];

return ['pages' => [

'home' => ['label' => 'Home', 'icon' => 'bx-home-circle', 'sections' => [
    'hero' => $sec('Hero (top of the page)', [
        $T('home_hero_kicker', 'Small line above the name', 'A full-stack perspective on the web'),
        $T('home_hero_name', 'Name (big text)', 'Shahadat'), $T('home_hero_accent', 'Coloured italic word after the name', 'Dev'),
        $A('home_hero_text', 'Paragraph under the name', 'I build products, ship full-stack apps and craft interfaces that feel alive.'),
        $T('home_hero_cta', 'Main button text', 'Explore my work'), $T('home_hero_cta_link', 'Main button link', '/projects', ['help' => $LNK]),
        $T('home_hero_link2', 'Second link text', 'Start a conversation ↗'), $T('home_hero_link2_url', 'Second link URL', '/contact', ['help' => $LNK]),
        $S('home_hero_available', 'Show the "available for work" label', '1'), $T('home_hero_available_text', '"Available" text', '● Available for work'),
        $T('home_hero_left_label', 'Left side label', '● 01 / Presence'), $L('home_hero_left_lines', 'Left side lines', ['Engineering', 'Design', 'Motion']),
        $T('home_hero_scroll', 'Bottom-left text', 'Scroll to discover ↓'), $T('home_hero_since', 'Bottom-middle text', 'Building for the web since {since}', ['help' => '{since} = year from Site settings → General']),
        $I('home_hero_photo', 'HERO IMAGE (animated portrait)', 'Your photo. Face on a plain/dark background in portrait ratio works best. The animation stays — only the picture changes.'),
        ['key' => 'home_hero_effect', 'label' => 'Hero image effect', 'type' => 'select', 'options' => ['pixel' => 'Pixel scanlines (reacts to the mouse, explodes on scroll)', 'photo' => 'Clean photo (soft glow, parallax on scroll)'], 'default' => 'pixel'],
        $S('home_hero_scatter', 'Pixel effect: scatter left/right while scrolling', '1'),
    ], 'bx-star'),
    'stats' => $sec('Numbers strip', [
        $S('home_stats_show'),
        $N('stat1_value', 'Stat 1 — number', '30'), $T('stat1_suffix', 'Stat 1 — suffix', '+'), $T('stat1_label', 'Stat 1 — label', 'Projects shipped'),
        $N('stat2_value', 'Stat 2 — number', '5'), $T('stat2_suffix', 'Stat 2 — suffix', 'y'), $T('stat2_label', 'Stat 2 — label', 'Building for the web'),
        $N('stat3_value', 'Stat 3 — number', '12'), $T('stat3_suffix', 'Stat 3 — suffix', '+'), $T('stat3_label', 'Stat 3 — label', 'Clients served'),
        $T('home_stat4_title', 'Fourth box — text', 'The work.'), $T('home_stat4_accent', 'Fourth box — coloured italic text', 'Real impact.'), $T('home_stat4_link', 'Fourth box — link text', 'View projects ↗'),
    ], 'bx-bar-chart-alt-2'),
    'present' => $sec('Intro + Build / Teach / Connect tabs', [
        $S('home_present_show'),
        $T('home_present_label', 'Section label (left)', 'The person behind the work'), $T('home_present_label_right', 'Section label (right)', '3 disciplines, one perspective'),
        $T('home_present_heading', 'Heading', 'Technology is the starting point.'), $T('home_present_accent', 'Heading — coloured italic part', 'People are the point.'),
        $T('home_present_p1', 'First line', 'I connect engineering, design and business.'),
        $A('home_present_p2', 'Paragraph', 'Since {since} I’ve been building and learning across the product, the interface and the server — shipping complete apps for real people.'),
        $T('home_present_link', 'Link text', 'Read my story ↗'), $T('home_present_link_url', 'Link URL', '/about', ['help' => $LNK]),
        ['key' => 'home_tabs', 'label' => 'Tabs (each tab changes the text and the animated image)', 'type' => 'repeater',
            'cols' => [['key' => 'name', 'label' => 'Tab name', 'type' => 'text'], ['key' => 'label', 'label' => 'Small caption', 'type' => 'text'], ['key' => 'heading', 'label' => 'Heading', 'type' => 'text'], ['key' => 'text', 'label' => 'Text', 'type' => 'textarea'], ['key' => 'link', 'label' => 'Link text', 'type' => 'text'], ['key' => 'url', 'label' => 'Link URL', 'type' => 'text']],
            'default' => [
                ['name' => 'Build', 'label' => 'Structure', 'heading' => 'Give an idea structure.', 'text' => 'Products and interfaces that connect real needs to working software.', 'link' => 'Explore the products ↗', 'url' => '/projects'],
                ['name' => 'Teach', 'label' => 'Clarity', 'heading' => 'Make it clear.', 'text' => 'Notes and walkthroughs that help other developers grow.', 'link' => 'Read the notes ↗', 'url' => '/blogs'],
                ['name' => 'Connect', 'label' => 'Connection', 'heading' => 'Build the right thing, together.', 'text' => 'Working closely with founders and teams to ship ideas.', 'link' => 'Start a conversation ↗', 'url' => '/contact']]],
        $T('home_viz_label_0', 'Caption on the animated box (before any tab is clicked)', 'Three disciplines'),
        $I('home_viz_image_0', 'ANIMATED BOX image — default', 'Optional. With an image the box shows your picture (slow zoom) with the dot animation on top. Without it, only the dot animation shows.'),
        $I('home_viz_image_1', 'ANIMATED BOX image — when tab 1 is active'), $I('home_viz_image_2', 'ANIMATED BOX image — when tab 2 is active'), $I('home_viz_image_3', 'ANIMATED BOX image — when tab 3 is active'),
        $S('home_viz_overlay', 'Keep the moving dots / squares / rings on top of the image', '1'),
    ], 'bx-shape-circle'),
    'work' => $sec('Selected work', [
        $S('home_work_show'), $T('home_work_label', 'Section label (left)', 'Selected work'), $T('home_work_label_right', 'Section label (right)', 'Built, tested, put into the world'),
        $T('home_work_heading', 'Heading', 'Ideas are a start.'), $T('home_work_accent', 'Heading — coloured italic part', 'This is the work.'),
        $N('home_work_count', 'How many featured projects to list', '3'), $T('home_work_button', 'Button under the list', 'View all projects ↗'),
    ], 'bx-briefcase'),
    'marquee' => $sec('Scrolling words strip', [
        $S('home_marquee_show'), $L('home_marquee_words', 'Words (empty = use your Skills)', [], 'One word per line. Leave empty to use the names from Skills.'),
    ], 'bx-text'),
    'cta' => $sec('Closing call-to-action', [
        $S('home_cta_show'), $T('home_cta_label', 'Label (left)', 'Let’s make it matter'), $T('home_cta_label_right', 'Label (right)', 'Open for projects'),
        $T('home_cta_heading', 'Heading', 'Something great starts with'), $T('home_cta_accent', 'Heading — coloured italic part', 'a hello.'),
        $T('home_cta_button', 'Button text', 'Let’s connect ↗'), $T('home_cta_link', 'Button link', '/contact', ['help' => $LNK]),
    ], 'bx-rocket'),
    'seo' => $seo('home'),
]],

'about' => ['label' => 'About', 'icon' => 'bx-user', 'sections' => [
    'header' => $sec('Page title', [$T('about_head_kicker', 'Small label', '(About)'), $T('about_head_title', 'Title', 'Hello, I’m'), $T('about_head_accent', 'Coloured italic part', 'Shahadat.')], 'bx-heading'),
    'intro' => $sec('Intro + photo', [
        $S('about_intro_show'),
        $A('about_lead', 'Lead paragraph (large)', 'I’m a full-stack developer who ships whole products — API, admin panel, web and mobile apps — with an eye for motion and detail.'),
        $A('about_p1', 'Paragraph 2', 'I work with Laravel on the back end, React and React Native on the front, and I care about clean architecture, secure roles and interfaces that feel alive.'),
        $A('about_p2', 'Paragraph 3', 'Right now I’m growing into DevOps and cloud so I can take products from idea to infrastructure — and build a small web agency around that craft.'),
        $I('about_photo', 'ABOUT IMAGE (animated 3D tilt card)', 'Your photo. The tilt / glow animation stays — only the picture changes.'),
        $T('about_chip1', 'Floating tag 1', 'Chattogram'), $T('about_chip2', 'Floating tag 2', 'Since 2021'),
        $T('about_fact_based', 'Fact: Based in', 'Chattogram, Bangladesh'), $T('about_fact_focus', 'Fact: Focus', 'Full-stack · Mobile · Motion'),
        $T('about_fact_experience', 'Fact: Experience', '5 years building'), $T('about_fact_status', 'Fact: Status', 'Open for projects'),
    ], 'bx-id-card'),
    'services' => $sec('What I do (list comes from Services)', [$S('about_services_show'), $T('about_services_label', 'Label (left)', 'What I do'), $T('about_services_right', 'Label (right)', 'Four ways I help')], 'bx-layer'),
    'stats' => $sec('Dark numbers band', [$S('about_stats_show'), $N('about_stat4_value', 'Fourth number', '100'), $T('about_stat4_suffix', 'Fourth suffix', '%'), $T('about_stat4_label', 'Fourth label', 'Responsive builds'),
        ['key' => 'about_stats_note', 'label' => '', 'type' => 'note', 'help' => 'The first three numbers come from Pages → Home → Numbers strip.']], 'bx-bar-chart-alt-2'),
    'toolbox' => $sec('Toolbox (skills bars come from Skills)', [$S('about_toolbox_show'), $T('about_toolbox_label', 'Label (left)', 'Toolbox'), $T('about_toolbox_right', 'Label (right)', 'What I use every day'),
        $L('about_tools', 'Tool chips', $tools)], 'bx-bulb'),
    'process' => $sec('How I work (steps)', [$S('about_process_show'), $T('about_process_label', 'Label (left)', 'How I work'), $T('about_process_right', 'Label (right)', 'Four calm steps'),
        ['key' => 'process_steps', 'label' => 'Steps', 'type' => 'repeater', 'cols' => $rows2, 'default' => $process]], 'bx-git-merge'),
    'journey' => $sec('Journey timeline (comes from Journey timeline)', [$S('about_journey_show'), $T('about_journey_label', 'Label (left)', 'Journey'), $T('about_journey_right', 'Label (right)', 'Started with code. Kept asking why.')], 'bx-git-branch'),
    'faq' => $sec('Questions (from FAQs → About)', [$S('about_faq_show'), $T('about_faq_label', 'Label (left)', 'Questions'), $T('about_faq_right', 'Label (right)', 'Good to know')], 'bx-help-circle'),
    'cta' => $cta('about'), 'seo' => $seo('about'),
]],

'projects' => ['label' => 'Projects', 'icon' => 'bx-briefcase', 'sections' => [
    'header' => $sec('Page title + controls', [
        $T('projects_head_kicker', 'Small label', '(Projects) · 3D experience'), $T('projects_head_title', 'Title', 'Selected'), $T('projects_head_accent', 'Coloured italic part', 'work.'),
        $A('projects_lead', 'Intro text', 'Products I’ve designed, built and shipped. Drag the ring, filter by type, search by name — or click a card for the full case study.'),
        $T('projects_search', 'Search placeholder', 'Search projects…'), $T('projects_all', '"All" filter label', 'All'), $T('projects_3d', '3D button label', '3D'), $T('projects_grid', 'Grid button label', 'Grid'),
        $T('projects_open', 'Button under the 3D ring', 'View case study ↗'), $T('projects_empty', 'Text when there are no projects', 'No projects yet.'),
    ], 'bx-heading'),
    'capabilities' => $sec('Capabilities chips', [$S('projects_cap_show'), $T('projects_cap_label', 'Label (left)', 'Capabilities'), $T('projects_cap_right', 'Label (right)', 'What goes into each build'), $L('projects_tools', 'Chips', $tools)], 'bx-chip'),
    'process' => $sec('Process (steps from About → How I work)', [$S('projects_process_show'), $T('projects_process_label', 'Label (left)', 'Process'), $T('projects_process_right', 'Label (right)', 'How a project runs')], 'bx-git-merge'),
    'cta' => $cta('projects'), 'seo' => $seo('projects'),
]],

'blogs' => ['label' => 'Blogs', 'icon' => 'bx-edit', 'sections' => [
    'header' => $sec('Page title + controls', [
        $T('blogs_head_kicker', 'Small label', '(Blogs) · 3D reading list'), $T('blogs_head_title', 'Title', 'Notes &'), $T('blogs_head_accent', 'Coloured italic part', 'writing.'),
        $A('blogs_lead', 'Intro text', 'Short, practical notes on Laravel, React, motion and shipping products. Drag the ring, search, or open an article.'),
        $T('blogs_search', 'Search placeholder', 'Search articles…'), $T('blogs_open', 'Button under the 3D ring', 'Read article ↗'), $T('blogs_empty', 'Text when there are no posts', 'No articles yet.'),
    ], 'bx-heading'),
    'featured' => $sec('Featured article', [$S('blogs_featured_show'), $T('blogs_featured_label', 'Label (left)', 'Featured'), $T('blogs_featured_right', 'Label (right)', 'Start here')], 'bx-star'),
    'list' => $sec('All articles list', [$S('blogs_list_show'), $T('blogs_list_label', 'Label (left)', 'All articles'), $T('blogs_list_right', 'Label (right)', 'Newest first')], 'bx-list-ul'),
    'topics' => $sec('Topics chips', [$S('blogs_topics_show'), $T('blogs_topics_label', 'Label (left)', 'Topics'), $T('blogs_topics_right', 'Label (right)', 'Browse by subject')], 'bx-category'),
    'newsletter' => $sec('Newsletter box', [$S('blogs_newsletter_show'), $T('blogs_newsletter_label', 'Label (left)', 'Newsletter'), $T('blogs_newsletter_right', 'Label (right)', 'No spam, ever'),
        $T('blogs_newsletter_heading', 'Heading', 'New notes,'), $T('blogs_newsletter_accent', 'Heading — coloured italic part', 'straight to your inbox.')], 'bx-bell'),
    'cta' => $cta('blogs'), 'seo' => $seo('blogs'),
]],

'contact' => ['label' => 'Contact', 'icon' => 'bx-envelope', 'sections' => [
    'header' => $sec('Page title', [$T('contact_head_kicker', 'Small label', '(Contact)'), $T('contact_head_title', 'Title', 'Let’s build'), $T('contact_head_accent', 'Coloured italic part', 'together.'),
        $A('contact_lead', 'Intro text', 'Tell me about your idea. I reply within one working day — usually sooner.')], 'bx-heading'),
    'form' => $sec('Contact form', [
        $T('contact_f_name', 'Name placeholder', 'Your name'), $T('contact_f_email', 'E-mail placeholder', 'Email address'),
        $T('contact_f_type_label', 'Project-type label', 'Project type'), $L('contact_types', 'Project-type options', ['Web app', 'Mobile app', 'Admin panel', 'Animation / UI']),
        $T('contact_f_budget_label', 'Budget label', 'Budget'), $L('contact_budgets', 'Budget options', ['Under $500', '$500 – $2k', '$2k – $5k', '$5k+']),
        $T('contact_f_message', 'Message placeholder', 'Tell me about your project'), $T('contact_f_button', 'Send button', 'Send message ↗'), $T('contact_f_sending', 'Button text while sending', 'Sending…'),
        $T('contact_f_success', 'Success message', 'Thanks! Your message has been sent.'),
    ], 'bx-edit-alt'),
    'info' => $sec('Contact details (right column)', [$S('contact_info_show'), $T('contact_info_time', 'Local-time label', '(Local time · {city})'), $T('contact_info_email', 'E-mail label', '(Email)'),
        $T('contact_info_phone', 'Phone label', '(Phone / WhatsApp)'), $T('contact_info_avail', 'Availability label', '(Availability)'),
        ['key' => 'contact_info_note', 'label' => '', 'type' => 'note', 'help' => 'E-mail, phone and availability text come from Site settings → Contact & e-mail. Social links from Social links.']], 'bx-id-card'),
    'steps' => $sec('What happens next', [$S('contact_steps_show'), $T('contact_steps_label', 'Label (left)', 'What happens next'), $T('contact_steps_right', 'Label (right)', 'Four simple steps'),
        ['key' => 'contact_steps', 'label' => 'Steps', 'type' => 'repeater', 'cols' => $rows2, 'default' => [
            ['title' => 'Say hello', 'text' => 'Send a short message about the idea, the timeline and the budget range.'], ['title' => 'Discovery call', 'text' => 'A 30-minute call to understand goals and shape the scope.'],
            ['title' => 'Proposal', 'text' => 'A clear plan with phases, timeline and estimate.'], ['title' => 'Kick-off', 'text' => 'We agree the first milestone and start building.']]]], 'bx-list-ol'),
    'engage' => $sec('Ways to work together', [$S('contact_engage_show'), $T('contact_engage_label', 'Label (left)', 'Ways to work together'), $T('contact_engage_right', 'Label (right)', 'Pick what fits'),
        ['key' => 'contact_engage', 'label' => 'Cards', 'type' => 'repeater', 'cols' => $rows2, 'default' => [
            ['title' => 'Project', 'text' => 'Fixed-scope builds with clear phases — ideal for new products and websites.'], ['title' => 'Retainer', 'text' => 'Ongoing monthly development and maintenance for live products.'],
            ['title' => 'Consulting', 'text' => 'Architecture reviews, code audits and mentoring for your team.']]]], 'bx-handshake'),
    'faq' => $sec('Questions (from FAQs → Contact)', [$S('contact_faq_show'), $T('contact_faq_label', 'Label (left)', 'Questions'), $T('contact_faq_right', 'Label (right)', 'Before you write')], 'bx-help-circle'),
    'cta' => $cta('contact'), 'seo' => $seo('contact'),
]],

'details' => ['label' => 'Detail pages', 'icon' => 'bx-detail', 'sections' => [
    'project' => $sec('Project detail page labels', [
        $T('pd_back', 'Back link', '← All projects'), $T('pd_kicker', 'Small label', '(Case study)'), $T('pd_role', 'Meta: Role', 'Role'), $T('pd_year', 'Meta: Year', 'Year'), $T('pd_status', 'Meta: Status', 'Status'), $T('pd_type', 'Meta: Type', 'Type'),
        $T('pd_overview', 'Section: Overview', 'Overview'), $T('pd_approach', 'Section: Approach', 'Approach'), $T('pd_challenge', 'Column: Challenge', 'Challenge'), $T('pd_solution', 'Column: Solution', 'Solution'), $T('pd_results', 'Column: Results', 'Results'),
        $T('pd_features', 'Section: Key features', 'Key features'), $T('pd_screens', 'Section: Screens', 'Screens'), $T('pd_full', 'Section: Full case study', 'Full case study'), $T('pd_next', 'Next-project label', 'Next project'),
        $T('pd_live', 'Live-site button', 'Live site ↗'), $T('pd_repo', 'Source-code button', 'Source code ↗'),
    ], 'bx-briefcase'),
    'blog' => $sec('Blog detail page labels', [
        $T('bd_back', 'Back link', '← All posts'), $T('bd_toc', 'Table-of-contents title', 'On this page'), $T('bd_copy', 'Copy-link button', 'Copy link'), $T('bd_copied', 'After copying', 'Link copied ✓'),
        $T('bd_related', 'Related label (left)', 'Keep reading'), $T('bd_related_right', 'Related label (right)', 'Related articles'),
        $A('bd_author_bio', 'Author box text', 'Full-stack developer. Writes about Laravel, React, motion and shipping products.'),
    ], 'bx-edit'),
]],

'shared' => ['label' => 'Shared blocks', 'icon' => 'bx-copy', 'sections' => [
    'cta' => $sec('Call-to-action band (About / Projects / Blogs / Contact)', [
        $T('cta_label', 'Label (left)', 'Next step'), $T('cta_label_right', 'Label (right)', 'Open for projects'), $T('cta_heading', 'Heading', 'Have an idea?'), $T('cta_accent', 'Heading — coloured italic part', 'Let’s build it.'),
        $T('cta_button', 'Button text', 'Start a conversation ↗'), $T('cta_link', 'Button link', '/contact', ['help' => $LNK]),
    ], 'bx-rocket'),
]],
]];
