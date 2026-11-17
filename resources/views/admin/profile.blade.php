@extends('admin.layouts.app')
@section('title', 'My profile')
@section('content')
<h4 class="fw-bold mb-4"><i class="bx bx-user me-2 text-primary"></i>My profile</h4>
<div class="card anim-card" style="max-width:720px"><div class="card-body"><form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">@csrf
  <div class="d-flex align-items-center gap-4 mb-4 pb-3 border-bottom">
    <img src="{{ $user->avatar_url }}" id="avPrev" alt="" class="rounded-circle" style="width:96px;height:96px;object-fit:cover;box-shadow:0 6px 20px rgba(0,0,0,.15)">
    <div class="flex-grow-1"><label class="form-label fw-semibold">Profile photo</label><input type="file" name="avatar" accept="image/*" class="form-control" onchange="document.getElementById('avPrev').src=URL.createObjectURL(this.files[0])">
      @if($user->avatar)<div class="form-check mt-2"><input class="form-check-input" type="checkbox" name="remove_avatar" value="1" id="rmav"><label class="form-check-label" for="rmav">Remove photo</label></div>@endif
      <div class="form-text">Shown in the top-right corner of the dashboard. JPG/PNG up to 4 MB.</div></div>
  </div>
  <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name', $user->name) }}" required></div>
  <div class="mb-3"><label class="form-label">Email (login)</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required></div>
  <hr><p class="text-muted small">Leave blank to keep your current password.</p>
  <div class="mb-3"><label class="form-label">Current password</label><input type="password" name="current_password" class="form-control"></div>
  <div class="row"><div class="col-md-6 mb-3"><label class="form-label">New password</label><input type="password" name="password" class="form-control"></div><div class="col-md-6 mb-3"><label class="form-label">Confirm</label><input type="password" name="password_confirmation" class="form-control"></div></div>
  <button class="btn btn-primary"><i class="bx bx-save me-1"></i> Update profile</button></form></div></div>
@endsection
