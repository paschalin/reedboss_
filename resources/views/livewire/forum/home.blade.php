<div>
  <x-slot name="title">
    {{ $category?->id ? $category->title : $settings['title'] ?? ($settings['name'] ?? config('app.name', 'Simple Forum')) }}
  </x-slot>
  <x-slot name="metaTags">
    <meta name="description" content="{{ $category?->id ? $category->description : $settings['description'] ?? '' }}" />
  </x-slot>

  @once
    @push('scripts')
      <script>
        window.addEventListener('DOMContentLoaded', (event) => {
          Livewire.on('page-changed', () => {
            window.scrollTo({
              top: 0,
              behavior: 'smooth'
            });
          });
          // Livewire.on('thread-deleted', () => {
          //   window.location.reload();
          // });
        });
      </script>
    @endpush
  @endonce

  

  @if ($settings['thread_ad_code'] ?? null)
    <div class="my-6">
      {{ str($settings['thread_ad_code'])->toHtmlString() }}
    </div>
  @endif

  <div class="px-4 sm:px-0">
    <div class="sm:block">
      <nav class="isolate flex rounded-lg shadow">
        <label @class([
            'group relative min-w-0 flex-1 overflow-hidden bg-white dark:bg-gray-900 py-4 px-6 text-sm font-bold text-center focus:z-10 rtl:rounded-r-lg ltr:rounded-l-lg',
            $sorting == 'latest'
                ? 'text-gray-900 dark:text-gray-100 border-b-2 border-primary-500'
                : 'cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700' => true,
        ])>
          <span>{{ __('Latest') }}</span>
          <input type="radio" name="sorting" wire:model="sorting" value="latest" class="sr-only">
        </label>

        <label @class([
            'group relative min-w-0 flex-1 overflow-hidden bg-white dark:bg-gray-900 py-4 px-6 text-sm font-bold text-center focus:z-10',
            $sorting == 'likes'
                ? 'text-gray-900 dark:text-gray-100 border-b-2 border-primary-500'
                : 'cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 border-r border-l dark:border-gray-800' => true,
        ])>
          <span>{{ __('Favorites') }}</span>
          <input type="radio" name="sorting" wire:model="sorting" value="likes" class="sr-only">
        </label>

        <label @class([
            'group relative min-w-0 flex-1 overflow-hidden bg-white dark:bg-gray-900 py-4 px-6 text-sm font-bold text-center focus:z-10 rtl:rounded-l-lg ltr:rounded-r-lg',
            $sorting == 'replies'
                ? 'text-gray-900 dark:text-gray-100 border-b-2 border-primary-500'
                : 'cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700' => true,
        ])>
          <span>{{ __('Trending') }}</span>
          <input type="radio" name="sorting" wire:model="sorting" value="replies" class="sr-only">
        </label>
      </nav>
    </div>
  </div>

  <div class="mt-1">
    <h1 class="sr-only">
      {{ $sorting == 'likes' ? __('Sort by most likes') : ($sorting == 'replies' ? __('Sort by most replies') : __('Recent threads')) }}
    </h1>
    <ul role="list" class="space-y-1">
      @forelse ($threads as $thread)
        <li>
          @livewire('forum.thread-overview', ['settings' => $settings, 'thread' => $thread, 'category' => $category], key($thread->id))
        </li>
      @empty
        @if (
            !$logged_in_user?->roles->where('name', 'super')->first() &&
                $category->view_group &&
                $category->view_group != $logged_in_user?->roles->where('id', $category->view_group)->first()?->id)
          <li>
            <div class="flex items-center justify-center text-2xl font-thin h-32 text-gray-500">
              {{ __('You do not have permissions to view this category.') }}
            </div>
          </li>
        @else
          <li>
            <div class="flex items-center justify-center text-2xl font-thin h-32 text-gray-500">
              {{ __('No thread to display') }}
            </div>
          </li>
        @endif
      @endforelse
    </ul>

    @if ($threads->hasPages())
      <div class="mt-6"></div>
      <div class="w-fulln sm:rounded-lg bg-white dark:bg-gray-900 min-w-full p-6">
        {{ $threads->links() }}
      </div>
    @endif
  </div>

  @if ($settings['thread_ad2_code'] ?? null)
    <div class="mt-6">
      {{ str($settings['thread_ad2_code'])->toHtmlString() }}
    </div>
  @endif
</div>
