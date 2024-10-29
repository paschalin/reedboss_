<x-mail::layout>
  @php
    $settings = site_config();
  @endphp

  {{-- Header --}}
  <x-slot:header>
    <x-mail::header :url="config('app.url')" :settings="$settings">
      <a href="{{ url('/') }}" style="display: inline-block;">
        @if ($settings['logo'] ?? null)
          <img src="{{ storage_url($settings['logo']) }}" class="logo" alt="{{ $settings['name'] ?? config('app.name') }}">
        @else
          {{ $settings['name'] ?? config('app.name') }}
        @endif
      </a>
    </x-mail::header>
  </x-slot:header>

  {{-- Body --}}
  {{ $slot }}

  {{-- Subcopy --}}
  @isset($subcopy)
    <x-slot:subcopy>
      <x-mail::subcopy>
        {{ $subcopy }}
      </x-mail::subcopy>
    </x-slot:subcopy>
  @endisset

  {{-- Footer --}}
  <x-slot:footer>
    <x-mail::footer>
      © {{ date('Y') }} {{ $settings['name'] ?? config('app.name') }}. @lang('All rights reserved.')
    </x-mail::footer>
  </x-slot:footer>
</x-mail::layout>
