@php
  $hex = ltrim($accent, '#'); $r = hexdec(substr($hex, 0, 2)); $g = hexdec(substr($hex, 2, 2)); $b = hexdec(substr($hex, 4, 2));
  $on = (0.299 * $r + 0.587 * $g + 0.114 * $b) > 140 ? '#111111' : '#ffffff';
  $names = config('site.platforms');
@endphp
<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>{{ $site }}</title></head>
<body style="margin:0;padding:0;background:#f3f1ec;font-family:Arial,Helvetica,sans-serif;color:#1c1c20">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f3f1ec;padding:28px 12px"><tr><td align="center">
  <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;background:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 8px 30px rgba(0,0,0,.08)">
    <tr><td style="background:#0b0b0e;padding:26px 32px">
      @if($logo)<img src="{{ $logo }}" alt="{{ $site }}" style="max-height:38px;max-width:200px;display:block">
      @else<span style="font-family:Georgia,'Times New Roman',serif;font-size:28px;color:#f1f0ea">{{ $logoText }}<span style="font-style:italic;color:{{ $accent }}"> {{ $logoAccent }}</span></span>@endif
    </td></tr>
    <tr><td style="height:5px;background:{{ $accent }};font-size:0;line-height:0">&nbsp;</td></tr>
    <tr><td style="padding:34px 32px 8px">
      <p style="margin:0 0 6px;font-size:13px;letter-spacing:.14em;text-transform:uppercase;color:#8a8a94">Reply to your message</p>
      <h1 style="margin:0 0 22px;font-family:Georgia,'Times New Roman',serif;font-weight:400;font-size:30px;line-height:1.2;color:#111">Hi {{ $msg->name }},</h1>
      <div style="font-size:16px;line-height:1.75;color:#2b2b31">{!! nl2br(e($body)) !!}</div>
      @if($signature)<div style="margin-top:26px;padding-top:18px;border-top:1px solid #ececf1;font-size:15px;line-height:1.7;color:#2b2b31">{!! nl2br(e($signature)) !!}</div>@endif
      <p style="margin:28px 0 8px"><a href="{{ $site_url }}" style="display:inline-block;background:{{ $accent }};color:{{ $on }};text-decoration:none;font-weight:bold;font-size:14px;padding:13px 26px;border-radius:40px">Visit {{ $site }} ↗</a></p>
    </td></tr>
    <tr><td style="padding:18px 32px 30px">
      <div style="background:#f6f5f1;border-left:4px solid {{ $accent }};border-radius:8px;padding:16px 18px">
        <p style="margin:0 0 8px;font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#8a8a94">Your original message · {{ $msg->created_at->format('d M Y') }}</p>
        <div style="font-size:14px;line-height:1.7;color:#55555e">{!! nl2br(e($msg->message)) !!}</div>
      </div>
    </td></tr>
    <tr><td style="background:#0b0b0e;padding:22px 32px;text-align:center">
      @if($socials->count())<p style="margin:0 0 10px">@foreach($socials as $s)<a href="{{ $s->url }}" style="color:{{ $accent }};text-decoration:none;font-size:13px;margin:0 8px">{{ $s->label ?: ($names[$s->platform] ?? ucfirst($s->platform)) }}</a>@endforeach</p>@endif
      <p style="margin:0;font-size:12px;color:#8a8a94">© {{ date('Y') }} {{ $site }}</p>
    </td></tr>
  </table>
</td></tr></table>
</body></html>
