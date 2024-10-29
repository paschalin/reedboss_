@props(['categories', 'index' => 0])

@php
  $append = '';
  if ($index) {
      for ($i = 0; $i < $index; $i++) {
          $append .= '&nbsp;&nbsp;&nbsp;';
      }
      $append .= '&nbsp;⇢&nbsp;';
  }
@endphp

@foreach ($categories as $sc)
  @if ($logged_in_user?->hasRole('super'))
    <option value="{{ $sc->id }}">
      {{ str($append)->toHtmlString() }} {{ $sc->name }}
    </option>
  @else
    <option value="{{ $sc->create_group ? '' : $sc->id }}"{{ $sc->create_group ? ' disabled' : '' }}>
      {{ str($append)->toHtmlString() }} {{ $sc->name }}
    </option>
  @endif
  @if ($sc->children)
    {{-- <optgroup label="{{ $sc->name }}"> --}}
    <x-options :categories="$sc->children" :index="$index + 1" />
    {{-- </optgroup> --}}
  @endif
@endforeach
