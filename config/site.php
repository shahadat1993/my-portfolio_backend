<?php
/*
 | SITE-WIDE settings schema. Every field here appears in Admin → Site settings and (unless 'public' => false)
 | is sent to the React site by GET /api/bootstrap.
 | types: text, textarea, email, url, number, toggle, select, image, list (one per line), repeater (rows), note
 | Page content (home / about / ...) lives in config/pages.php.
 */
$T = fn ($k, $l, $d = '', $x = []) => ['key' => $k, 'label' => $l, 'type' => 'text', 'default' => $d] + $x;
$A = fn ($k, $l, $d = '', $x = []) => ['key' => $k, 'label' => $l, 'type' => 'textarea', 'default' => $d] + $x;
$S = fn ($k, $l, $d = '1', $x = []) => ['key' => $k, 'label' => $l, 'type' => 'toggle', 'default' => $d] + $x;
$I = fn ($k, $l, $h = '') => ['key' => $k, 'label' => $l, 'type' => 'image', 'help' => $h];
$U = fn ($k, $l, $d = '', $x = []) => ['key' => $k, 'label' => $l, 'type' => 'url', 'default' => $d] + $x;

$platforms = ['whatsapp' => 'WhatsApp', 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'github' => 'GitHub', 'x' => 'X / Twitter',
    'youtube' => 'YouTube', 'telegram' => 'Telegram', 'messenger' => 'Messenger', 'tiktok' => 'TikTok', 'behance' => 'Behance', 'dribbble' => 'Dribbble',
    'medium' => 'Medium', 'devto' => 'DEV', 'discord' => 'Discord', 'email' => 'Email', 'phone' => 'Phone', 'link' => 'Website / other'];

$float = [$S('float_enabled', 'Show floating buttons on the website', '1'),
    ['key' => 'float_position', 'label' => 'Position', 'type' => 'select', 'options' => ['left' => 'Bottom left', 'right' => 'Bottom right'], 'default' => 'left']];
foreach ([1, 2, 3] as $n) {
    $float[] = $S("float{$n}_enabled", "Button {$n} — active", $n === 1 ? '1' : '0');
    $float[] = ['key' => "float{$n}_type", 'label' => "Button {$n} — type", 'type' => 'select', 'options' => $platforms, 'default' => ['whatsapp', 'facebook', 'instagram'][$n - 1]];
    $float[] = $T("float{$n}_value", "Button {$n} — number / username / URL", '', ['help' => 'WhatsApp / Phone: number with country code (8801XXXXXXXXX). Others: full URL (https://facebook.com/yourpage). Email: address.']);
    $float[] = $T("float{$n}_label", "Button {$n} — hover text", ['Chat on WhatsApp', 'Message on Facebook', 'Follow on Instagram'][$n - 1]);
}
$float[] = $T('float_wa_message', 'WhatsApp pre-filled message', 'Hi! I found your portfolio and would like to talk.');

return [
    'frontend_url' => trim(explode(',', env('FRONTEND_URL', 'http://localhost:5173'))[0]),
    'platforms' => $platforms,
    'groups' => [
        'general' => ['label' => 'General', 'icon' => 'bx-cog', 'fields' => [
            $T('site_name', 'Site name (used in titles, e-mails, footer)', 'Shahadat Dev'),
            $T('site_tagline', 'Tagline', 'Full-stack developer · Laravel · React'),
            $T('location', 'Location', 'Chattogram, Bangladesh'),
            $T('since_year', 'Building since (year)', '2021'),
        ]],
        'branding' => ['label' => 'Logo & branding', 'icon' => 'bx-badge', 'fields' => [
            $S('logo_use_image', 'Use an IMAGE logo (off = use the text logo)', '0', ['help' => 'Turn ON to show the uploaded logo image everywhere (navbar, menu, footer, admin, e-mails). Turn OFF to show the text logo below.']),
            $T('logo_text', 'Text logo — main word', 'Shahadat'),
            $T('logo_accent', 'Text logo — coloured italic word', 'Dev'),
            $I('logo_image', 'Logo image (for dark backgrounds)', 'PNG/SVG/WebP with transparent background, about 300×80 px.'),
            $I('logo_image_light', 'Logo image for LIGHT theme (optional)', 'If empty the dark-theme logo is used in both themes.'),
            $I('favicon', 'Favicon (browser tab icon)', 'Square PNG, 64×64 or bigger.'),
        ]],
        'nav' => ['label' => 'Navigation', 'icon' => 'bx-menu', 'fields' => [
            $T('nav_home', 'Menu label: Home', 'Home'), $T('nav_about', 'Menu label: About', 'About'), $T('nav_projects', 'Menu label: Projects', 'Projects'),
            $T('nav_blogs', 'Menu label: Blogs', 'Blogs'), $T('nav_contact', 'Menu label: Contact', 'Contact'),
            $S('nav_cta_show', 'Show the call-to-action button in the navbar', '1'),
            $T('nav_cta_label', 'Navbar button text', 'Let’s talk'), $T('nav_cta_link', 'Navbar button link', '/contact', ['help' => '/contact, /projects … or a full https:// URL']),
            $S('nav_search_show', 'Show the search button', '1'),
        ]],
        'footer' => ['label' => 'Footer', 'icon' => 'bx-dock-bottom', 'fields' => [
            $T('footer_big_text', 'Giant word at the bottom', 'Shahadat', ['help' => 'Leave empty to use the logo text.']),
            $A('footer_about', 'Short about text', 'Full-stack developer building fast, animated products with Laravel and React. Let’s make something people remember.'),
            $S('footer_show_newsletter', 'Show newsletter box in the footer', '1'),
            $T('newsletter_title', 'Newsletter title', 'New notes, straight to your inbox.'),
            $T('newsletter_text', 'Newsletter text', 'Short, practical posts on Laravel, React and motion. No spam.'),
            $T('newsletter_placeholder', 'Newsletter input placeholder', 'Your email address'), $T('newsletter_button', 'Newsletter button', 'Subscribe ↗'),
            $T('newsletter_success', 'Message after subscribing', 'You are subscribed. Thank you!'),
            $T('footer_links_title', 'Column title: pages', 'Explore'), $T('footer_social_title', 'Column title: social', 'Follow'), $T('footer_contact_title', 'Column title: contact', 'Say hello'),
            $T('footer_copyright', 'Copyright line', '© {year} {name}', ['help' => 'Use {year} and {name}.']),
            $T('footer_text', 'Middle line', 'Built with intent · always evolving'), $T('footer_text2', 'Right line', 'Chattogram ↗ the world'),
            ['key' => 'footer_hint', 'label' => '', 'type' => 'note', 'help' => 'Social media links are managed in the sidebar → Social links.'],
        ]],
        'floating' => ['label' => 'Floating buttons', 'icon' => 'bx-message-rounded-dots', 'fields' => $float],
        'seo' => ['label' => 'SEO & analytics', 'icon' => 'bx-trending-up', 'fields' => [
            $S('seo_index', 'Allow search engines to index the website', '1', ['help' => 'Turn OFF while the site is under construction (adds noindex + robots Disallow).']),
            $U('seo_canonical_base', 'Website address (canonical URL)', '', ['help' => 'Your real public domain, e.g. https://shahadat.dev — used in sitemap, canonical links and social previews.']),
            $T('seo_title_template', 'Page title format', '{title} — {site}', ['help' => 'Use {title} and {site}.']),
            $A('seo_description', 'Default meta description (150–160 characters)', 'Full-stack developer portfolio — Laravel, React and React Native products, built end to end.'),
            $T('seo_keywords', 'Keywords (comma separated)', 'full-stack developer, Laravel, React, portfolio, web developer Bangladesh'),
            $I('seo_og_image', 'Default social share image (1200×630)', 'Shown when your link is shared on Facebook, LinkedIn, WhatsApp…'),
            $T('seo_twitter', 'X / Twitter handle', '', ['help' => '@yourname']),
            $T('seo_person_name', 'Your full name (structured data)', 'Shahadat'), $T('seo_person_job', 'Job title (structured data)', 'Full-stack developer'),
            $T('seo_verify_google', 'Google Search Console verification code', '', ['help' => 'Only the code from <meta name="google-site-verification" content="CODE">']),
            $T('seo_verify_bing', 'Bing Webmaster verification code', ''),
            $T('analytics_ga', 'Google Analytics 4 ID', '', ['help' => 'G-XXXXXXXXXX']), $T('analytics_gtm', 'Google Tag Manager ID', '', ['help' => 'GTM-XXXXXXX']), $T('analytics_fb_pixel', 'Facebook Pixel ID', ''),
            ['key' => 'seo_hint', 'label' => '', 'type' => 'note', 'help' => 'Each page also has its own SEO title/description: Pages → (page) → SEO. Projects and posts have SEO fields in their edit forms. Sitemap: /sitemap.xml · Robots: /robots.txt on the API domain.'],
        ]],
        'contact' => ['label' => 'Contact & e-mail', 'icon' => 'bx-envelope', 'fields' => [
            $T('contact_email', 'Receive messages at (comma separated)', 'hello@example.com', ['public' => false, 'help' => 'Every contact-form message is e-mailed here (needs MAIL_* in .env).']),
            ['key' => 'public_email', 'label' => 'Public e-mail shown on the site', 'type' => 'email', 'default' => 'hello@example.com'],
            $T('phone', 'Phone / WhatsApp shown on the site', ''), $T('availability_text', 'Availability text', 'Open for new projects'),
            $S('auto_reply', 'Send an automatic confirmation to the visitor', '1', ['public' => false]),
            $T('auto_reply_subject', 'Auto-reply subject', 'Thanks for reaching out!', ['public' => false]),
            $A('auto_reply_body', 'Auto-reply message', "Hi {name},\n\nThanks for your message — I’ve received it and will reply within one working day.\n\n— Shahadat", ['public' => false, 'help' => 'Use {name} for the visitor’s name.']),
            $U('sheet_webhook_url', 'Google Sheet webhook URL (Apps Script)', '', ['public' => false, 'help' => 'Web App URL from docs/google-apps-script.gs. Leave empty to disable.']),
            $T('sheet_secret', 'Google Sheet secret token', '', ['public' => false, 'help' => 'Must match SECRET in the Apps Script.']),
            $T('reply_from_name', 'Name shown on your replies', 'Shahadat', ['public' => false]),
            $A('reply_signature', 'E-mail signature added to every reply', "Best regards,\nShahadat\nFull-stack developer", ['public' => false]),
            ['key' => 'reply_templates', 'label' => 'Quick reply templates (pick one when replying)', 'type' => 'repeater', 'public' => false,
                'cols' => [['key' => 'name', 'label' => 'Template name', 'type' => 'text'], ['key' => 'subject', 'label' => 'Subject', 'type' => 'text'], ['key' => 'body', 'label' => 'Message ({name} = visitor name)', 'type' => 'textarea']],
                'default' => [
                    ['name' => 'Thanks — let’s talk', 'subject' => 'Re: your message', 'body' => "Hi {name},\n\nThank you for contacting me. I’d love to learn more about your project. Could you share your goals, timeline and rough budget? We can also book a 30-minute call."],
                    ['name' => 'Send quote', 'subject' => 'Your project estimate', 'body' => "Hi {name},\n\nThanks for the details. I’ve prepared an outline and estimate for your project — please find the next steps below.\n\n1) …\n2) …"],
                ]],
        ]],
        'appearance' => ['label' => 'Appearance', 'icon' => 'bx-palette', 'fields' => [
            ['key' => 'default_theme', 'label' => 'Default theme for new visitors', 'type' => 'select', 'options' => ['dark' => 'Dark', 'light' => 'Light', 'auto' => 'Follow device'], 'default' => 'dark', 'help' => 'Accent colours are managed in Theme colours.'],
            ['key' => 'default_font', 'label' => 'Default heading font', 'type' => 'select', 'options' => ['serif' => 'Serif (elegant)', 'sans' => 'Sans (modern)'], 'default' => 'serif'],
        ]],
    ],
];
