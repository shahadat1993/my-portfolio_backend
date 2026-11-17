@extends('admin.layouts.app')
@section('title', 'Site settings')
@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">@csrf
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2 sticky-bar"><div><h4 class="fw-bold mb-0"><i class="bx bx-cog me-2 text-primary"></i>Site settings</h4><small class="text-muted">Logo, menu, footer, floating buttons, SEO, e-mail — changes appear on the website instantly</small></div><button class="btn btn-primary"><i class="bx bx-save me-1"></i> Save settings</button></div>
  <div class="card anim-card"><div class="card-header p-0"><ul class="nav nav-tabs nav-fill" role="tablist">
    @foreach($groups as $gk => $g)<li class="nav-item"><button type="button" class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#tab-{{ $gk }}" id="t-{{ $gk }}"><i class="bx {{ $g['icon'] }} me-1"></i><span class="d-none d-lg-inline">{{ $g['label'] }}</span></button></li>@endforeach</ul></div>
  <div class="card-body tab-content pt-4">
  @foreach($groups as $gk => $g)
    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $gk }}"><div class="row g-3">
      @foreach($g['fields'] as $f)<div class="col-md-{{ in_array($f['type'], ['textarea', 'image', 'list', 'repeater', 'note']) ? 12 : 6 }}">@include('admin.settings._field', ['f' => $f, 'values' => $values])</div>@endforeach
    </div></div>
  @endforeach
  </div></div>
  <div class="text-end mt-4 mb-5"><button class="btn btn-primary btn-lg"><i class="bx bx-save me-1"></i> Save settings</button></div>
</form>
@endsection
@push('scripts')<script>const showTab=()=>{if(location.hash){const t=document.querySelector('#t-'+location.hash.slice(1));t&&new bootstrap.Tab(t).show()}};showTab();addEventListener('hashchange',showTab);</script>@endpush
