<x-app-layout>
  <div class="sm:max-w-md mx-auto">
    <x-errors />
  </div>

  <x-jet-authentication-card class="-mb-32">
    <div class="mb-4">
      {{ __('Please login to access your account.') }}
    </div>

    @if (session('status'))
      <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <input type="hidden" name="back_to" value="{{ url()->previous() }}">

      <div>
        <x-ui-input :label="__('Username/Email')" name="email" id="username" :value="old('email')" autofocus />
      </div>

      <div class="mt-4">
        <x-inputs.password :label="__('Password')" name="password" id="password" />
      </div>

      <div class="block mt-4">
        <label for="remember_me" class="inline-flex items-center">
          <x-checkbox id="remember_me" name="remember" />
          <span class="ltr:ml-2 rtl:mr-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>
      </div>

      @if ($settings['captcha'] ?? null)
        @if ($settings['captcha_provider'] == 'recaptcha')
          {!! NoCaptcha::renderJs() !!}
          <div class="mt-4 flex w-full items-center justify-around">
            {!! NoCaptcha::display(['data-theme' => 'auto']) !!}
          </div>
          @if ($errors->has('g-recaptcha-response'))
            <div class="text-center text-sm text-red-500">
              {{ $errors->first('g-recaptcha-response') }}
            </div>
          @endif
        @elseif ($settings['captcha_provider'] == 'trunstile')
          @push('scripts')
            <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>
          @endpush
          <div class="cf-turnstile mt-4" data-sitekey="{{ config('captcha.sitekey') }}"></div>
        @elseif ($settings['captcha_provider'] == 'local')
          <div class="mt-3 p-2 sm:flex w-full items-center justify-between gap-y-2 gap-x-4 rounded-md bg-gray-100 dark:bg-gray-950">
            <div class="mx-auto flex items-center justify-center">
              <img src="{{ captcha_src() }}" alt="" class="shadow rounded-md" />
              {{-- {{ str(captcha_img())->toHtmlString() }} --}}
            </div>
            <div class="-mt-1 max-w-[160px] mx-auto">
              <x-ui-input label="" name="captcha" id="captcha" autocomplete="off" />
            </div>
          </div>
        @endif
      @endif

      <div class="flex items-center justify-end mt-4">
        @if (Route::has('password.request'))
          <a class="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200"
            href="{{ route('password.request') }}">
            {{ __('Forgot your password?') }}
          </a>
        @endif

        <x-jet-button class="ltr:ml-4 rtl:mr-4" id="login-button">
          {{ __('Log in') }}
        </x-jet-button>
      </div>
    </form>

    @if (
        ($settings['facebook_login'] ?? null) ||
            ($settings['twitter_login'] ?? null) ||
            ($settings['github_login'] ?? null) ||
            ($settings['google_login'] ?? null))
      <div class="flex flex-wrap items-center justify-start gap-x-6 mt-6 mb-2 rounded-md px-4 py-3 bg-gray-100 dark:bg-gray-800">
        @if ($settings['facebook_login'] ?? null)
          <a href="{{ route('social.login', 'facebook') }}" class="hover:text-gray-900 dark:hover:text-gray-100">
            <span class="sr-only">Facebook</span>
            <svg class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd"
                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                clip-rule="evenodd" />
            </svg>
          </a>
        @endif

        @if ($settings['github_login'] ?? null)
          <a href="{{ route('social.login', 'github') }}" class="hover:text-gray-900 dark:hover:text-gray-100">
            <span class="sr-only">GitHub</span>
            <svg class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd"
                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                clip-rule="evenodd" />
            </svg>
          </a>
        @endif

        @if ($settings['google_login'] ?? null)
          <a href="{{ route('social.login', 'google') }}" class="flex hover:text-gray-900 dark:hover:text-gray-100">
            <span class="sr-only">Google</span>
            <svg class="h-5 w-5" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M30.0014 16.3109C30.0014 15.1598 29.9061 14.3198 29.6998 13.4487H16.2871V18.6442H24.1601C24.0014 19.9354 23.1442 21.8798 21.2394 23.1864L21.2127 23.3604L25.4536 26.58L25.7474 26.6087C28.4458 24.1665 30.0014 20.5731 30.0014 16.3109Z" fill="#4285F4"/>
<path d="M16.2863 29.9998C20.1434 29.9998 23.3814 28.7553 25.7466 26.6086L21.2386 23.1863C20.0323 24.0108 18.4132 24.5863 16.2863 24.5863C12.5086 24.5863 9.30225 22.1441 8.15929 18.7686L7.99176 18.7825L3.58208 22.127L3.52441 22.2841C5.87359 26.8574 10.699 29.9998 16.2863 29.9998Z" fill="#34A853"/>
<path d="M8.15964 18.769C7.85806 17.8979 7.68352 16.9645 7.68352 16.0001C7.68352 15.0356 7.85806 14.1023 8.14377 13.2312L8.13578 13.0456L3.67083 9.64746L3.52475 9.71556C2.55654 11.6134 2.00098 13.7445 2.00098 16.0001C2.00098 18.2556 2.55654 20.3867 3.52475 22.2845L8.15964 18.769Z" fill="#FBBC05"/>
<path d="M16.2864 7.4133C18.9689 7.4133 20.7784 8.54885 21.8102 9.4978L25.8419 5.64C23.3658 3.38445 20.1435 2 16.2864 2C10.699 2 5.8736 5.1422 3.52441 9.71549L8.14345 13.2311C9.30229 9.85555 12.5086 7.4133 16.2864 7.4133Z" fill="#EB4335"/>
</svg>
<p class="pl-2">{{ __('Sign in with Google') }}</p>
          </a>
        @endif

        @if ($settings['twitter_login'] ?? null)
          <a href="{{ route('social.login', 'twitter') }}" class="hover:text-gray-900 dark:hover:text-gray-100">
            <span class="sr-only">Twitter</span>
            <svg class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path
                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
            </svg>
          </a>
        @endif
      </div>
    @endif

    @if (demo())
      <div x-data="{
          loginAs(user) {
              document.getElementById('username').value = user;
              document.getElementById('password').value = 123456;
              document.getElementById('login-button').click();
          }
      }" class="mt-6 bg-gray-50 dark:bg-gray-950 rounded-md p-4">
        <h4 class="font-bold text-center">Demo Accounts</h4>
        <div class="mt-4 grid grid-cols-2 gap-x-2 gap-y-1">
          <button @click="loginAs('super')" class="px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-900">Login as Super
            Admin</button>
          <button @click="loginAs('admin')" class="px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-900">Login as
            Admin</button>
          <button @click="loginAs('user1')" class="px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-900">Login as Member
            One</button>
          <button @click="loginAs('user2')" class="px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-900">Login as Member
            Two</button>
        </div>
      </div>
    @endif
  </x-jet-authentication-card>
</x-app-layout>
