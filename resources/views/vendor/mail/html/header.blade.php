@props(['url', 'settings'])

<tr>
  <td class="header">
    <a href="{{ $url }}" style="display: inline-block;">
      @if ($settings['logo'] ?? null)
        <img src="{{ storage_url($settings['logo']) }}" class="logo" alt="{{ $settings['name'] ?? config('app.name') }}">
      @else
        {{ $slot }}
      @endif
    </a>
  </td>
</tr>
