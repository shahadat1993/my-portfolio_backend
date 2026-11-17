@extends('admin.layouts.app')
@section('title', $cfg['label'] . ' page')
@php $paths = ['home' => '/', 'about' => '/about', 'projects' => '/projects', 'blogs' => '/blogs', 'contact' => '/contact']; $front = isset($paths[$page]) ? rtrim(config('site.frontend_url'), '/') . $paths[$page] : null; @endphp
@section('content')
<form method="POST" action="{{ route('admin.pages.update', array_filter([$page, $only])) }}" enctype="multipart/form-data">@csrf
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2 sticky-bar">
    <div><h4 class="fw-bold mb-0"><i class="bx {{ $cfg['icon'] }} me-2 text-primary"></i>{{ $cfg['label'] }} page{{ $only ? ' → ' . $sections[$only]['label'] : '' }}</h4><small class="text-muted">Edit every text, button, image and switch. Saved changes show on the website immediately.</small></div>
    <div class="d-flex gap-2">@if($front)<a href="{{ $front }}" target="_blank" class="btn btn-outline-secondary"><i class="bx bx-link-external"></i> View page</a>@endif<button class="btn btn-primary"><i class="bx bx-save me-1"></i> Save</button></div>
  </div>
  @if(!$only)<div class="mb-3 d-flex flex-wrap gap-2">@foreach($sections as $sk => $sec)<a href="#sec-{{ $sk }}" class="badge bg-label-primary p-2"><i class="bx {{ $sec['icon'] ?? 'bx-layer' }}"></i> {{ $sec['label'] }}</a>@endforeach</div>@endif
  @foreach($sections as $sk => $sec)
    <div class="card mb-4 anim-card" id="sec-{{ $sk }}">
      <div class="card-header d-flex align-items-center"><i class="bx {{ $sec['icon'] ?? 'bx-layer' }} me-2 text-primary fs-4"></i><h5 class="mb-0">{{ $sec['label'] }}</h5></div>
      <div class="card-body"><div class="row g-3">
        @foreach($sec['fields'] as $f)<div class="col-md-{{ in_array($f['type'], ['textarea', 'image', 'list', 'repeater', 'note']) ? 12 : 6 }}">@include('admin.settings._field', ['f' => $f, 'values' => $values])</div>@endforeach
      </div></div>
    </div>
  @endforeach
  <div class="text-end mb-5"><button class="btn btn-primary btn-lg"><i class="bx bx-save me-1"></i> Save</button></div>
</form>
@endsection
