<span class="flex items-center gap-2">
  @php
    $settings = site_config();
  @endphp
  @if ($settings['logo'] ?? null)
    <img src="{{ storage_url($settings['logo']) }}" alt="{{ $settings['name'] ?? config('app.name') }}" class="h-5" />
  @else
    <span class="text-2xl font-extrabold">{{ $settings['name'] ?? config('app.name') }}</span>
  @endif
</span>
