<div>
  <div class="max-w-7xl mx-auto pb-10 sm:px-6 lg:px-8">
    <x-jet-form-section submit="save">
      <x-slot name="title">
        {{ __('Application Settings') }}
      </x-slot>

      <x-slot name="description">
        <div class="">
          <div>
            {{ __('Update your application settings.') }}
          </div>
          <div class="mt-6 flex flex-wrap gap-4">
            @if (!request()->routeIs('settings.general'))
              <x-link type="button" :href="route('settings.general')">{{ __('General') }}</x-link>
            @endif
            @if (!request()->routeIs('settings.forum'))
              <x-link type="button" :href="route('settings.forum')">{{ __('Forum') }}</x-link>
            @endif
            @if (!request()->routeIs('settings.ad'))
              <x-link type="button" :href="route('settings.ad')">{{ __('Ads & Analytics') }}</x-link>
            @endif
            @if (!request()->routeIs('settings.social.auth'))
              <x-link type="button" :href="route('settings.social.auth')">{{ __('Social Auth') }}</x-link>
            @endif
            @if (!request()->routeIs('settings.social.links'))
              <x-link type="button" :href="route('settings.social.links')">{{ __('Social Links') }}</x-link>
            @endif
            @if (!request()->routeIs('policies.edit'))
              <x-link type="button" :href="route('policies.edit')">{{ __('Policies') }}</x-link>
            @endif
          </div>
        </div>
      </x-slot>

      <x-slot name="form">
        <div class="col-span-6">
          <h4 class="mb-3 font-bold">{{ __('Ads & Analytics') }}</h4>

          <div class="grid grid-cols-1 sm:grid-cols-6 gap-6">
            <!-- Top Ad Code -->
            <div class="col-span-6">
              <x-textarea :label="__('Top Ad Code')" wire:model.defer="settings.top_ad_code" />
            </div>
            <!-- Sidebar Ad Code -->
            <div class="col-span-6">
              <x-textarea :label="__('Sidebar Ad Code')" wire:model.defer="settings.sidebar_ad_code" />
            </div>
            <!-- Sidebar Ad2 Code -->
            <div class="col-span-6">
              <x-textarea :label="__('Sidebar Ad2 Code')" wire:model.defer="settings.sidebar_ad2_code" />
            </div>
            <!-- Threads Ad Code -->
            <div class="col-span-6">
              <x-textarea :label="__('Threads Ad Code')" wire:model.defer="settings.thread_ad_code" />
            </div>
            <!-- Threads Ad2 Code -->
            <div class="col-span-6">
              <x-textarea :label="__('Threads Ad2 Code')" wire:model.defer="settings.thread_ad2_code" />
            </div>
            <!-- Bottom Ad Code -->
            <div class="col-span-6">
              <x-textarea :label="__('Bottom Ad Code')" wire:model.defer="settings.bottom_ad_code" />
            </div>
            <!-- Footer Code -->
            <div class="col-span-6">
              <x-textarea :label="__('Footer Code')" wire:model.defer="settings.footer_code" />
            </div>
          </div>
        </div>
      </x-slot>

      <x-slot name="actions">
        <x-jet-action-message class="ltr:mr-3 rtl:ml-3" on="saved">
          {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="logo">
          {{ __('Save') }}
        </x-jet-button>
      </x-slot>
    </x-jet-form-section>
  </div>
</div>
