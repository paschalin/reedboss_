<div>
  <div class="max-w-7xl mx-auto pb-10 sm:px-6 lg:px-8">
    <x-jet-form-section submit="save">
      <x-slot name="title">
        {{ $article_category->id ? __('Edit Article Category') : __('New Article Category') }}
      </x-slot>

      <x-slot name="description">
        <div>{{ __('Please fill the form and save.') }}</div>
        <x-link type="button" class="mt-6" :href="route('articles.categories')">{{ __('List Article Category') }}</x-link>
        <x-link type="button" class="mt-6" :href="route('articles')">{{ __('List Articles') }}</x-link>
      </x-slot>

      <x-slot name="form">

        <!-- Name -->
        <div class="col-span-6 sm:col-span-3">
          <x-ui-input :label="__('Name')" wire:model.defer="article_category.name" />
        </div>

        <!-- Slug -->
        <div class="col-span-6 sm:col-span-3">
          <x-ui-input :label="__('Slug')" wire:model.defer="article_category.slug" />
        </div>

        <!-- Order -->
        <div class="col-span-6 sm:col-span-3">
          <x-ui-input :label="__('Order Number')" wire:model.defer="article_category.order_no" />
        </div>

        <!-- Title -->
        <div class="col-span-6 sm:col-span-3">
          <x-ui-input :label="__('Page Title')" wire:model.defer="article_category.title" />
        </div>

        <!-- Description -->
        <div class="col-span-6">
          <x-textarea :label="__('Meta Description')" wire:model.defer="article_category.description" />
        </div>

        <!-- Parent Category -->
        @if ($mainCategories)
          <div class="col-span-6">
            <x-ui-select :label="__('Parent Category')" :options="$mainCategories" option-value="id" option-label="name"
              wire:model.defer="article_category.article_category_id">
            </x-ui-select>
          </div>
        @endif

        <div class="col-span-6">
          <label for="active" class="inline-flex items-center">
            <x-checkbox id="active" wire:model.defer="article_category.active" />
            <span class="ltr:ml-2 rtl:mr-2 text-sm">{{ __('Active') }}</span>
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
