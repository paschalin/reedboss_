<x-slot name="metaTags">
  <meta name="description" content="{{ __('Listing Forum Categories') }}" />
</x-slot>

<div class="bg-white dark:bg-gray-900 sm:rounded-lg shadow relative isolate">
  <svg
    class="absolute inset-0 -z-10 opacity-50 h-full w-full stroke-gray-200 dark:stroke-gray-700 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
    aria-hidden="true">
    <defs>
      <pattern id="83fd4e5a-9d52-42fc-97b6-718e5d7ee527" width="200" height="200" x="50%" y="-64" patternUnits="userSpaceOnUse">
        <path d="M100 200V.5M.5 .5H200" fill="none" />
      </pattern>
    </defs>
    <svg x="50%" y="-64" class="overflow-visible fill-gray-50 dark:fill-gray-900">
      <path d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M299.5 800h201v201h-201Z" stroke-width="0" />
    </svg>
    <rect width="100%" height="100%" stroke-width="0" fill="url(#83fd4e5a-9d52-42fc-97b6-718e5d7ee527)" />
  </svg>
  <div class="p-6">
    <h2 class="text-2xl font-bold leading-10 tracking-tight text-gray-900 dark:text-gray-100">
      {{ __('Categories') }}
    </h2>
    <p class="mt-0 text-base leading-normal">
      {{ __('Please choose any category below') }}
    </p>
    <div class="mt-8">
      <div class="flex flex-col gap-y-12 sm:gap-x-6 divide-y dark:divide-gray-700">
        <div class="-m-6 p-6 block even:bg-gray-50 dark:odd:bg-gray-900 odd:bg-white dark:even:bg-gray-950 rounded-md overflow-hidden">
          <x-multi-menus :menus="$categoriesMenu" route="threads" :mobile="true" :show="true" />
        </div>
      </div>
    </div>
  </div>

</div>
