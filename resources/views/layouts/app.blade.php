<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" dir="{{ $settings['rtl'] == 1 ? 'rtl' : 'ltr' }}">
@props(['showAd' => false])

<head>

<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#026670">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#026670">



<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-V9VJY9ED9G"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-V9VJY9ED9G');
</script>




  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @if ($settings['icon'] ?? null)
    <link rel="icon" href="{{ storage_url($settings['icon']) }}">
  @endif

  <title>
    {{ ($title ?? (trim($settings['title'] ?? '') ?: 'Home')) . ' | ' . ($settings['name'] ?? config('app.name', 'Reedboss')) }}
  </title>
  @if (isset($metaTags))
    {{ $metaTags }}
  @endif
  
  @isset($metaTags)
    <x-slot name="metaTags">{{ $metaTags }}</x-slot>
  @endisset

  <script>
    let mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

    function updateTheme(savedTheme) {
      let theme = window.localStorage.mode || 'system';
      try {
        if (!savedTheme) {
          savedTheme = window.localStorage.mode;
        }
        if (savedTheme == 'dark') {
          theme = 'dark';
          document.documentElement.classList.add('dark');
        } else if (savedTheme == 'light') {
          theme = 'light';
          document.documentElement.classList.remove('dark');
        } else if (mediaQuery.matches) {
          document.documentElement.classList.add('dark');
        } else {
          document.documentElement.classList.remove('dark');
        }
      } catch {
        theme = 'light';
        document.documentElement.classList.remove('dark');
      }
      return theme;
    }

    document.documentElement.setAttribute('data-theme', updateTheme());

    new MutationObserver(([{
      oldValue
    }]) => {
      let newValue = document.documentElement.getAttribute('data-theme');
      window.localStorage.mode = newValue;
      updateTheme(newValue);
    }).observe(document.documentElement, {
      attributeFilter: ['data-theme'],
      attributeOldValue: true
    });

    // window.addEventListener('storage', updateTheme);
    // mediaQuery.addEventListener('change', updateTheme);
    @if ($settings['theme'] ?? null)
      if (!window.localStorage.mode) {
        document.documentElement.classList.add('{{ $settings['theme'] }}');
      }
    @endif
    window.Locale = '{{ app()->getLocale() }}';

  </script>

<script>
  var cards = $(".quiz");
    for(var i = 0; i < cards.length; i++){
        var target = Math.floor(Math.random() * cards.length -1) + 1;
        var target2 = Math.floor(Math.random() * cards.length -1) +1;
        cards.eq(target).before(cards.eq(target2));
    }
</script>


  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

  <!-- Scripts -->
  @wireUiScripts
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Styles -->
  @livewireStyles
  @stack('styles')
  
  <!-- Google adsense -->
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6198454864515777"
     crossorigin="anonymous"></script>
</head>

<body class="h-full min-h-screen font-sans antialiased bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
  <x-jet-banner id="top-banner" />

  <div class="">
    <x-navigation-menu />
    <!-- Top Ad -->
    @if ($showAd && $settings['top_ad_code'] ?? null)
      <div class="flex justify-center mx-auto max-w-7xl sm:px-6 lg:px-8 mt-3">
        {{ str($settings['top_ad_code'])->toHtmlString() }}
      </div>
    @endif




   
    

    
   
    

<!-- trending -->
           <div class="scrollmenuhead">
             <div class="scrollmenu">
              <ul id="listerr">
                  <a href="https://reedboss.com/general"><li>General</li></a>
                  <a href="https://reedboss.com/education"><li>education</li></a>
                  <a href="https://reedboss.com/politics"><li>politics</li></a>
                  <a href="https://reedboss.com/health"><li>health</li></a>
                  <a href="https://reedboss.com/technology"><li>technology</li></a>
                  <a href="https://reedboss.com/relationship"><li>relationship</li></a>
                  <a href="https://reedboss.com/lifestyle"><li>lifestyle</li></a>
                  <a href="https://reedboss.com/music"><li>music</li></a>
                  <a href="https://reedboss.com/videos"><li>videos</li></a>
                  <a href="https://reedboss.com/entertainment"><li>entertainments</li></a>
                  <a href="https://reedboss.com/history"><li>history</li></a>
                  <a href="https://reedboss.com/business"><li>business</li></a>
    </ul>
            </div>
			               </div>
          <!-- trending -->



    <!-- Page Heading -->
    @isset($header)
      <header class="" id="header">
        <div class="max-w-7xl mx-auto pt-8 px-4 sm:px-6 lg:px-8">
          {{ $header }}
        </div>
      </header>
    @endisset

    <!-- Page Content -->
    <main class="reakappbg dark:bg-gray-800 h-full min-h-full">
      <div class="pt-8" x-cloak x-data="{
          mh: 300,
          init() {
              window.addEventListener('DOMContentLoaded', () => {
                  this.mh = document.body.offsetHeight - (document.getElementById('main-nav')?.offsetHeight || 64) - (document.getElementById('footer')?.offsetHeight || 216) - 32;
              });
          }
      }" :style="{ 'min-height': mh + 'px' }">
        {{ $slot }}
      </div>

      <!-- Bottom Ad -->
      @if ($showAd && $settings['bottom_ad_code'] ?? null)
        <div class="bg-gray-100 flex justify-center mx-auto max-w-7xl sm:px-6 lg:px-8 mt-8">
          {{ str($settings['bottom_ad_code'])->toHtmlString() }}
        </div>
      @endif

      <x-footer />
    </main>
  </div>

  <x-notifications zIndex="z-[2500]" />
  <x-dialog blur="sm" align="center" />
  @livewireScripts
  @stack('modals')
  @include('cookie-consent::index')
  @stack('scripts')

  @if (session('error') || session('message') || session('info'))
    <script>
      window.addEventListener('DOMContentLoaded', (event) => {
        const eventNotification = new CustomEvent('wireui:notification', {
          bubbles: true,
          detail: {
            "options": {
              "icon": "{{ session('error') ? 'error' : (session('message') ? 'success' : 'info') }}",
              "title": "{{ session('error') ? 'Error!' : (session('message') ? __('Success!') : __('Info!')) }}",
              "description": "{{ session('error') ?: session('message') ?: session('info') }}"
              // "title": "{{ session('error') ?: session('message') ?: session('info') }}"
            }
          }
        });
        document.dispatchEvent(eventNotification);
      });
    </script>
    @php
      session()->forget('info');
      session()->forget('error');
      session()->forget('message');
    @endphp
  @endif

  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
      document.querySelectorAll('pre').forEach((el) => {
        hljs.highlightElement(el);
      });
    });
  </script>

  @if ($settings['footer_code'] ?? null)
    {{ str($settings['footer_code'])->toHtmlString() }}
  @endif
</body>

</html>
