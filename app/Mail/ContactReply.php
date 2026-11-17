<?php
namespace App\Mail;

use App\Models\{ContactMessage, Media, Setting, SocialLink, ThemeColor};
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{Address, Content, Envelope};

/** Your reply to a visitor, sent in a branded HTML layout (resources/views/mail/reply.blade.php). */
class ContactReply extends Mailable
{
    public function __construct(public ContactMessage $msg, public string $subjectLine, public string $bodyText) {}

    public function envelope(): Envelope
    {
        $owner = trim(explode(',', (string) Setting::get('contact_email', ''))[0] ?? '');
        return new Envelope(
            subject: $this->subjectLine,
            from: new Address(config('mail.from.address'), (string) Setting::get('reply_from_name', Setting::get('site_name', 'Portfolio'))),
            replyTo: $owner ? [new Address($owner, (string) Setting::get('reply_from_name', 'Portfolio'))] : [],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'mail.reply', with: [
            'body' => $this->bodyText,
            'signature' => (string) Setting::get('reply_signature', ''),
            'site' => (string) Setting::get('site_name', 'Portfolio'),
            'logo' => Setting::get('logo_use_image') === '1' ? Media::url(Setting::get('logo_image')) : null,
            'logoText' => Setting::get('logo_text', 'Portfolio'), 'logoAccent' => Setting::get('logo_accent', ''),
            'accent' => ThemeColor::where('is_default', true)->value('hex') ?: '#ff6a3d',
            'site_url' => Setting::get('seo_canonical_base') ?: config('site.frontend_url'),
            'socials' => SocialLink::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
