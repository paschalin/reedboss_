<div class="js-cookie-consent cookie-consent fixed bottom-20 md:bottom-0 inset-x-0 pb-2">
  <div class="max-w-7xl mx-auto px-6">
    <div class="p-2 rounded-lg bg-yellow-100">
      <div class="block md:flex md:items-center md:justify-between md:flex-wrap md:gap-3">
        <div class="w-0 flex-1 items-center inline">
          <p class="ml-3 text-black cookie-consent__message">
            {!! trans('cookie-consent::texts.message') !!}
          </p>
        </div>
        <div class="mt-2 flex-shrink-0 w-full md:mt-0 sm:w-auto flex justify-end">
          <button
            class="js-cookie-consent-agree cookie-consent__agree cursor-pointer flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-yellow-800 bg-yellow-400 hover:bg-yellow-300">
            {{ trans('cookie-consent::texts.agree') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
