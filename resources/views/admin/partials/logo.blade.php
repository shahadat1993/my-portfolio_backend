@php $img = \App\Models\Setting::get('logo_use_image') === '1' ? \App\Models\Media::url(\App\Models\Setting::get('logo_image')) : null; @endphp
@if($img)
  <img src="{{ $img }}" alt="{{ \App\Models\Setting::get('site_name') }}" style="max-height:34px;max-width:160px">
@else
  <i class="bx bxs-bolt-circle text-primary" style="font-size:30px"></i>
  <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ \Illuminate\Support\Str::limit(\App\Models\Setting::get('logo_text', 'Portfolio'), 12, '') }}</span>
@endif
