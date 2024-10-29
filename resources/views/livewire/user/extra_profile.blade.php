<div>
  <div class="max-w-7xl mx-auto pb-10 sm:px-6 lg:px-8">
    <x-jet-form-section submit="save">
      <x-slot name="title">
        {{ __('Extra Profile Information') }}
      </x-slot>

      <x-slot name="description">
        {{ __('Update your profile information.') }}
      </x-slot>

      <x-slot name="form">

        <!-- Image -->
        <div class="col-span-6">
          <div x-data="{ imageName: null, imagePreview: null }">
            <!-- Image File Input -->
            <input type="file" class="hidden" wire:model="image" x-ref="image"
              x-on:change="
          imageName = $refs.image.files[0].name;
          const reader = new FileReader();
          reader.onload = (e) => {
              imagePreview = e.target.result;
          };
          reader.readAsDataURL($refs.image.files[0]);
        " />

            <x-jet-label for="image" value="{{ __('Profile Cover Image') }}" />

            <!-- Current Image -->
            @if ($meta['image'] ?? null)
              <div class="mt-2" x-show="! imagePreview">
                <img src="{{ storage_url($meta['image']) }}" alt=""
                  class="rounded-md max-h-[300px] w-full h-80 max-w-3xl object-cover">
              </div>
            @endif

            <!-- New Image Preview -->
            <div class="mt-2" x-show="imagePreview" style="display: none;">
              <span class="block rounded-md w-full h-80 max-w-3xl max-h-[300px] bg-cover bg-no-repeat bg-center"
                x-bind:style="'background-image: url(\'' + imagePreview + '\');'">
              </span>
            </div>

            <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.image.click()">
              {{ __('Select A New Image') }}
            </x-jet-secondary-button>

            @if ($meta['image'] ?? null)
              <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteImage">
                {{ __('Remove Image') }}
              </x-jet-secondary-button>
            @endif

            <p class="text-xs mt-2">{{ __('Max. size 1000kb and max dimension of 1600x600px') }}</p>
            <x-jet-input-error for="image" class="mt-2" />
          </div>
        </div>

        <!-- Name -->
        <div class="col-span-6 sm:col-span-3">
          <x-ui-input :label="__('Display Name')" wire:model.defer="meta.display_name" />
        </div>

        <!-- DOB -->
        <div class="col-span-6 sm:col-span-3">
          <x-datetime-picker :label="__('Date of Birth')" without-time="true" wire:model.defer="dob" />
        </div>

        <!-- BIO -->
        <div class="col-span-6">
          <x-textarea :label="__('Bio')" wire:model.defer="meta.bio" />
        </div>

        @if ($settings['signature'] ?? null)
          <!-- Signature -->
          <div class="col-span-6">
            <x-textarea :label="__('Signature')" wire:model.defer="meta.signature" />
          </div>
        @endif

        <!-- Facebook Link -->
        <div class="col-span-6 sm:col-span-3">
          <x-ui-input :label="__('Facebook Link')" wire:model.defer="meta.facebook_link" />
        </div>

        <!-- Instagram Link -->
        <div class="col-span-6 sm:col-span-3">
          <x-ui-input :label="__('Instagram Link')" wire:model.defer="meta.instagram_link" />
        </div>

        <!-- Twitter Link -->
        <div class="col-span-6 sm:col-span-3">
          <x-ui-input :label="__('Twitter Link')" wire:model.defer="meta.twitter_link" />
        </div>

        <!-- LinkedIn Link -->
        <div class="col-span-6 sm:col-span-3">
          <x-ui-input :label="__('LinkedIn Link')" wire:model.defer="meta.linkedin_link" />
        </div>

        <!-- GitHub Link -->
        <div class="col-span-6 sm:col-span-3">
          <x-ui-input :label="__('GitHub Link')" wire:model.defer="meta.github_link" />
        </div>

        <!-- Dribbble Link -->
        <div class="col-span-6 sm:col-span-3">
          <x-ui-input :label="__('Dribbble Link')" wire:model.defer="meta.dribbble_link" />
        </div>

        <!-- Custom Fields -->
        <x-custom-fields model="User" :custom_fields="$custom_fields" :extra_attributes="$user->extra_attributes" />

        <!-- Disable messages -->
        <div class="col-span-6">
          <label for="disable_messages" class="inline-flex items-center">
            <x-checkbox id="disable_messages" wire:model.defer="meta.disable_messages" />
            <span class="ltr:ml-2 rtl:mr-2 text-sm">{{ __('Disable messages') }}</span>
          </label>
        </div>

      </x-slot>

      <x-slot name="actions">
        <x-jet-action-message class="ltr:mr-3 rtl:ml-3" on="saved">
          {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="image">
          {{ __('Save') }}
        </x-jet-button>
      </x-slot>
    </x-jet-form-section>
  </div>
</div>
