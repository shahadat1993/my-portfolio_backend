@extends('admin.layouts.app')
@section('title', 'Message from ' . $m->name)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h4 class="fw-bold mb-0"><i class="bx bx-envelope-open me-2 text-primary"></i>Message</h4><a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary"><i class="bx bx-arrow-back"></i> Back</a></div>
<div class="row g-4"><div class="col-lg-8">
  <div class="card anim-card mb-4"><div class="card-body">
    <div class="d-flex align-items-center mb-4"><span class="avatar-initial rounded-circle bg-label-primary d-flex align-items-center justify-content-center me-3" style="width:52px;height:52px;font-size:20px">{{ strtoupper(substr($m->name, 0, 1)) }}</span><div><h5 class="mb-0">{{ $m->name }}</h5><a href="mailto:{{ $m->email }}">{{ $m->email }}</a></div><div class="ms-auto text-muted small">{{ $m->created_at->format('M d, Y · H:i') }}</div></div>
    <div class="msg-body">{{ $m->message }}</div>
  </div></div>

  <div class="card anim-card mb-4" id="reply"><div class="card-header d-flex align-items-center"><i class="bx bx-reply me-2 text-primary fs-4"></i><h5 class="mb-0">Reply to {{ $m->name }}</h5><span class="ms-auto small text-muted">sent to {{ $m->email }}</span></div>
    <div class="card-body"><form method="POST" action="{{ route('admin.messages.reply', $m) }}" id="replyForm">@csrf
      @if(count($templates))<div class="mb-3"><label class="form-label small text-muted">Quick template</label><select class="form-select" id="tplPick"><option value="">— write your own —</option>@foreach($templates as $i => $t)<option value="{{ $i }}">{{ $t['name'] ?? 'Template ' . ($i + 1) }}</option>@endforeach</select></div>@endif
      <div class="mb-3"><label class="form-label fw-semibold">Subject</label><input name="subject" class="form-control" value="{{ old('subject', 'Re: your message') }}" required></div>
      <div class="mb-3"><label class="form-label fw-semibold">Message</label><textarea name="body" rows="9" class="form-control" required placeholder="Hi {{ $m->name }}, …">{{ old('body') }}</textarea><div class="form-text">Your signature (Site settings → Contact &amp; e-mail) and a copy of their message are added automatically in a branded e-mail layout.</div></div>
      <button class="btn btn-primary"><i class="bx bx-send me-1"></i> Send reply</button>
    </form></div></div>

  @if($m->replies->count())<div class="card anim-card"><div class="card-header"><h5 class="mb-0"><i class="bx bx-history me-2 text-primary"></i>Reply history</h5></div><ul class="list-group list-group-flush">
    @foreach($m->replies as $r)<li class="list-group-item"><div class="d-flex justify-content-between"><strong>{{ $r->subject }}</strong><span class="small text-muted">{{ $r->created_at->format('M d, H:i') }} · {{ $r->user?->name }}</span></div>
      <div class="small text-muted mb-1">to {{ $r->to_email }} · <span class="badge bg-label-{{ $r->sent ? 'success' : 'danger' }}">{{ $r->sent ? 'sent' : 'failed' }}</span></div>
      <div style="white-space:pre-wrap">{{ $r->body }}</div>@if($r->error)<div class="small text-danger mt-1">{{ $r->error }}</div>@endif</li>@endforeach</ul></div>@endif
</div>
<div class="col-lg-4"><div class="card anim-card"><div class="card-body">
  <dl class="mb-3"><dt class="small text-muted">Project type</dt><dd>{{ $m->project_type ?: '—' }}</dd><dt class="small text-muted">Budget</dt><dd>{{ $m->budget ?: '—' }}</dd><dt class="small text-muted">Delivery</dt><dd><span class="badge bg-label-{{ $m->mail_sent ? 'success' : 'secondary' }}">Email {{ $m->mail_sent ? 'sent' : 'not sent' }}</span> <span class="badge bg-label-{{ $m->sheet_synced ? 'success' : 'secondary' }}">Sheet {{ $m->sheet_synced ? 'synced' : 'not synced' }}</span></dd><dt class="small text-muted">IP</dt><dd>{{ $m->ip }}</dd></dl>
  <form method="POST" action="{{ route('admin.messages.update', $m) }}">@csrf @method('PUT')
    <label class="form-label">Status</label><select name="status" class="form-select mb-3">@foreach(['new', 'read', 'replied'] as $s)<option value="{{ $s }}" @selected($m->status === $s)>{{ ucfirst($s) }}</option>@endforeach</select>
    <label class="form-label">Private note</label><textarea name="note" rows="4" class="form-control mb-3" placeholder="Follow-up, quote sent…">{{ $m->note }}</textarea><button class="btn btn-outline-primary w-100">Save</button></form>
</div></div></div></div>
@endsection
@push('scripts')<script>
const TPL = @json($templates), NAME = @json($m->name), f = document.getElementById('replyForm');
document.getElementById('tplPick')?.addEventListener('change', e => { const t = TPL[e.target.value]; if (!t) return; f.subject.value = t.subject || ''; f.body.value = (t.body || '').replaceAll('{name}', NAME); });
</script>@endpush
