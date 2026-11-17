<div class="rep-row">
  <div class="row g-2 flex-grow-1">
    @foreach($f['cols'] as $c)
      <div class="col-md-{{ $c['type'] === 'textarea' ? 12 : 6 }}">
        <label class="form-label small text-muted mb-1">{{ $c['label'] }}</label>
        @if($c['type'] === 'textarea')<textarea name="{{ $f['key'] }}[{{ $i }}][{{ $c['key'] }}]" rows="2" class="form-control form-control-sm">{{ $row[$c['key']] ?? '' }}</textarea>
        @else<input type="text" name="{{ $f['key'] }}[{{ $i }}][{{ $c['key'] }}]" value="{{ $row[$c['key']] ?? '' }}" class="form-control form-control-sm">@endif
      </div>
    @endforeach
  </div>
  <div class="rep-tools d-flex flex-column gap-1 ms-2">
    <button type="button" class="btn btn-sm btn-icon btn-outline-secondary rep-up" title="Move up"><i class="bx bx-up-arrow-alt"></i></button>
    <button type="button" class="btn btn-sm btn-icon btn-outline-secondary rep-down" title="Move down"><i class="bx bx-down-arrow-alt"></i></button>
    <button type="button" class="btn btn-sm btn-icon btn-outline-danger rep-del" title="Remove"><i class="bx bx-trash"></i></button>
  </div>
</div>
