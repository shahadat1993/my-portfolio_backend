@php
  $k = $f['key']; $t = $f['type']; $v = old($k, $values[$k] ?? ($f['default'] ?? ''));
  if ($t === 'list') $v = is_array($v) ? implode("\n", $v) : $v;
@endphp
@if($t === 'note')
  <div class="alert alert-secondary py-2 small mb-0"><i class="bx bx-info-circle me-1"></i>{{ $f['help'] ?? '' }}</div>
@else
  <label class="form-label fw-semibold" for="s_{{ $k }}">{{ $f['label'] }}</label>
  @if($t === 'textarea')<textarea id="s_{{ $k }}" name="{{ $k }}" rows="3" class="form-control">{{ $v }}</textarea>
  @elseif($t === 'list')<textarea id="s_{{ $k }}" name="{{ $k }}" rows="{{ max(3, min(10, substr_count((string) $v, "\n") + 2)) }}" class="form-control" placeholder="One item per line">{{ $v }}</textarea>
  @elseif($t === 'toggle')<div class="form-check form-switch fs-5"><input type="hidden" name="{{ $k }}" value="0"><input class="form-check-input" type="checkbox" role="switch" id="s_{{ $k }}" name="{{ $k }}" value="1" @checked($v === '1' || $v === 1 || $v === true)></div>
  @elseif($t === 'select')<select id="s_{{ $k }}" name="{{ $k }}" class="form-select">@foreach($f['options'] as $ok => $ol)<option value="{{ $ok }}" @selected((string) $v === (string) $ok)>{{ $ol }}</option>@endforeach</select>
  @elseif($t === 'image')
    <div class="upload-box"><div class="preview-wrap">@if($v)<img src="{{ \App\Models\Media::url($v) }}" class="preview" alt="">@else<div class="preview empty"><i class="bx bx-image-add"></i></div>@endif</div>
      <div class="flex-grow-1"><input type="file" name="{{ $k }}" accept="image/*" class="form-control img-input">@if($v)<div class="form-check mt-2"><input class="form-check-input" type="checkbox" name="remove_{{ $k }}" value="1" id="rm_{{ $k }}"><label class="form-check-label" for="rm_{{ $k }}">Remove current image</label></div>@endif</div></div>
  @elseif($t === 'repeater')
    <div class="repeater" data-key="{{ $k }}">
      <div class="rep-rows">@foreach((array) ($values[$k] ?? $f['default'] ?? []) as $i => $row)@include('admin.settings._repeater_row', ['f' => $f, 'i' => $i, 'row' => $row])@endforeach</div>
      <button type="button" class="btn btn-sm btn-outline-primary rep-add"><i class="bx bx-plus"></i> Add row</button>
      <template class="rep-tpl">@include('admin.settings._repeater_row', ['f' => $f, 'i' => '__i__', 'row' => []])</template>
    </div>
  @else<input id="s_{{ $k }}" type="{{ in_array($t, ['number', 'email', 'url']) ? $t : 'text' }}" name="{{ $k }}" value="{{ $v }}" class="form-control">@endif
  @if(!empty($f['help']))<div class="form-text">{{ $f['help'] }}</div>@endif
@endif
