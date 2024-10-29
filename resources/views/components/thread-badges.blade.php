@props(['thread', 'sharePosition' => 'md:ltr:right-0 md:rtl:left-0 bottom-full mb-2'])

@php
  $socialLink = new \SocialLinks\Page([
      'url' => route('threads.show', $thread->slug),
      'title' => $thread->title,
      'text' => $thread->description,
      'image' => $thread->image,
      // 'icon' => $settings['icon'] ?? '',
      // 'twitterUser' => '@twitterUser',
  ]);
@endphp

<div class="border-t dark:border-gray-700 border-b dark:border-gray-700 mt-6 py-1 w-full flex flex-wrap justify-between sm:gap-x-8 gap-y-2 sm:gap-y-0">
  <div class="w-full flex flex-wrap justify-between items-center gap-x-6 gap-y-2 sm:gap-y-0">
    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 sm:gap-y-0">
      <div class="flex flex-wrap items-center gap-x-6 gap-y-2 sm:gap-y-0">
        @if ($thread->flag)
          <svg x-data x-tooltip.raw="{{ __('Flagged') }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
            class="w-5 h-5 text-orange-600">
            <path
              d="M3.5 2.75a.75.75 0 00-1.5 0v14.5a.75.75 0 001.5 0v-4.392l1.657-.348a6.449 6.449 0 014.271.572 7.948 7.948 0 005.965.524l2.078-.64A.75.75 0 0018 12.25v-8.5a.75.75 0 00-.904-.734l-2.38.501a7.25 7.25 0 01-4.186-.363l-.502-.2a8.75 8.75 0 00-5.053-.439l-1.475.31V2.75z" />
          </svg>
        @else
          <span class="inline-flex items-center text-sm">
            <button type="button" wire:click="like" x-data x-tooltip.raw="{{ __('Like') }}"
              class="inline-flex ltr:gap-x-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
              <svg width="1.25rem" height="1.25rem" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke="currentColor" stroke-width="0"/><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/><g id="SVGRepo_iconCarrier">  <path   class="w-5 h-5 rtl:ml-2 scale-y-100" d="M20.9751 12.1852L20.2361 12.0574L20.9751 12.1852ZM20.2696 16.265L19.5306 16.1371L20.2696 16.265ZM6.93776 20.4771L6.19055 20.5417H6.19055L6.93776 20.4771ZM6.1256 11.0844L6.87281 11.0198L6.1256 11.0844ZM13.9949 5.22142L14.7351 5.34269V5.34269L13.9949 5.22142ZM13.3323 9.26598L14.0724 9.38725V9.38725L13.3323 9.26598ZM6.69813 9.67749L6.20854 9.10933H6.20854L6.69813 9.67749ZM8.13687 8.43769L8.62646 9.00585H8.62646L8.13687 8.43769ZM10.518 4.78374L9.79207 4.59542L10.518 4.78374ZM10.9938 2.94989L11.7197 3.13821L11.7197 3.13821L10.9938 2.94989ZM12.6676 2.06435L12.4382 2.77841L12.4382 2.77841L12.6676 2.06435ZM12.8126 2.11093L13.0419 1.39687L13.0419 1.39687L12.8126 2.11093ZM9.86194 6.46262L10.5235 6.81599V6.81599L9.86194 6.46262ZM13.9047 3.24752L13.1787 3.43584V3.43584L13.9047 3.24752ZM11.6742 2.13239L11.3486 1.45675L11.3486 1.45675L11.6742 2.13239ZM20.2361 12.0574L19.5306 16.1371L21.0086 16.3928L21.7142 12.313L20.2361 12.0574ZM13.245 21.25H8.59634V22.75H13.245V21.25ZM7.68497 20.4125L6.87281 11.0198L5.37839 11.149L6.19055 20.5417L7.68497 20.4125ZM19.5306 16.1371C19.0238 19.0677 16.3813 21.25 13.245 21.25V22.75C17.0712 22.75 20.3708 20.081 21.0086 16.3928L19.5306 16.1371ZM13.2548 5.10015L12.5921 9.14472L14.0724 9.38725L14.7351 5.34269L13.2548 5.10015ZM7.18772 10.2456L8.62646 9.00585L7.64728 7.86954L6.20854 9.10933L7.18772 10.2456ZM11.244 4.97206L11.7197 3.13821L10.2678 2.76157L9.79207 4.59542L11.244 4.97206ZM12.4382 2.77841L12.5832 2.82498L13.0419 1.39687L12.897 1.3503L12.4382 2.77841ZM10.5235 6.81599C10.8354 6.23198 11.0777 5.61339 11.244 4.97206L9.79207 4.59542C9.65572 5.12107 9.45698 5.62893 9.20041 6.10924L10.5235 6.81599ZM12.5832 2.82498C12.8896 2.92342 13.1072 3.16009 13.1787 3.43584L14.6306 3.05921C14.4252 2.26719 13.819 1.64648 13.0419 1.39687L12.5832 2.82498ZM11.7197 3.13821C11.7547 3.0032 11.8522 2.87913 11.9998 2.80804L11.3486 1.45675C10.8166 1.71309 10.417 2.18627 10.2678 2.76157L11.7197 3.13821ZM11.9998 2.80804C12.1345 2.74311 12.2931 2.73181 12.4382 2.77841L12.897 1.3503C12.3872 1.18655 11.8312 1.2242 11.3486 1.45675L11.9998 2.80804ZM14.1537 10.9842H19.3348V9.4842H14.1537V10.9842ZM14.7351 5.34269C14.8596 4.58256 14.824 3.80477 14.6306 3.0592L13.1787 3.43584C13.3197 3.97923 13.3456 4.54613 13.2548 5.10016L14.7351 5.34269ZM8.59634 21.25C8.12243 21.25 7.726 20.887 7.68497 20.4125L6.19055 20.5417C6.29851 21.7902 7.34269 22.75 8.59634 22.75V21.25ZM8.62646 9.00585C9.30632 8.42 10.0391 7.72267 10.5235 6.81599L9.20041 6.10924C8.85403 6.75767 8.30249 7.30493 7.64728 7.86954L8.62646 9.00585ZM21.7142 12.313C21.9695 10.8365 20.8341 9.4842 19.3348 9.4842V10.9842C19.9014 10.9842 20.3332 11.4959 20.2361 12.0574L21.7142 12.313ZM12.5921 9.14471C12.4344 10.1076 13.1766 10.9842 14.1537 10.9842V9.4842C14.1038 9.4842 14.0639 9.43901 14.0724 9.38725L12.5921 9.14471ZM6.87281 11.0198C6.84739 10.7258 6.96474 10.4378 7.18772 10.2456L6.20854 9.10933C5.62021 9.61631 5.31148 10.3753 5.37839 11.149L6.87281 11.0198Z" fill="currentColor"/> <path class="w-5 h-5 rtl:ml-2 scale-y-100" opacity="0.5" d="M3.9716 21.4709L3.22439 21.5355L3.9716 21.4709ZM3 10.2344L3.74721 10.1698C3.71261 9.76962 3.36893 9.46776 2.96767 9.48507C2.5664 9.50239 2.25 9.83274 2.25 10.2344L3 10.2344ZM4.71881 21.4063L3.74721 10.1698L2.25279 10.299L3.22439 21.5355L4.71881 21.4063ZM3.75 21.5129V10.2344H2.25V21.5129H3.75ZM3.22439 21.5355C3.2112 21.383 3.33146 21.2502 3.48671 21.2502V22.7502C4.21268 22.7502 4.78122 22.1281 4.71881 21.4063L3.22439 21.5355ZM3.48671 21.2502C3.63292 21.2502 3.75 21.3686 3.75 21.5129H2.25C2.25 22.1954 2.80289 22.7502 3.48671 22.7502V21.2502Z" fill="currentColor" /> </g></svg>
              <span class="text-gray-900 dark:text-gray-300">{{ shortNumber($thread->up_votes) }}</span>
              <span class="sr-only">{{ __('likes') }}</span>
            </button>
          </span>
          <span class="inline-flex items-center text-sm">
            <button type="button" wire:click="dislike" x-data x-tooltip.raw="{{ __('Dislike') }}"
              class="inline-flex ltr:gap-x-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
              <svg width="1.25rem" height="1.25rem" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path class="w-5 h-5 rtl:ml-2 scale-y-100" d="M20.9751 11.8148L20.2361 11.9426L20.9751 11.8148ZM20.2696 7.73505L19.5306 7.86285L20.2696 7.73505ZM6.93776 3.52293L6.19055 3.45832H6.19055L6.93776 3.52293ZM6.1256 12.9156L6.87281 12.9802L6.1256 12.9156ZM13.9949 18.7786L14.7351 18.6573V18.6573L13.9949 18.7786ZM13.3323 14.734L14.0724 14.6128V14.6128L13.3323 14.734ZM6.69813 14.3225L6.20854 14.8907H6.20854L6.69813 14.3225ZM8.13687 15.5623L8.62646 14.9942H8.62646L8.13687 15.5623ZM10.518 19.2163L9.79207 19.4046L10.518 19.2163ZM10.9938 21.0501L11.7197 20.8618L11.7197 20.8618L10.9938 21.0501ZM12.6676 21.9356L12.4382 21.2216L12.4382 21.2216L12.6676 21.9356ZM12.8126 21.8891L13.0419 22.6031L13.0419 22.6031L12.8126 21.8891ZM9.86194 17.5374L10.5235 17.184V17.184L9.86194 17.5374ZM13.9047 20.7525L13.1787 20.5642V20.5642L13.9047 20.7525ZM11.6742 21.8676L11.3486 22.5433L11.3486 22.5433L11.6742 21.8676ZM20.2361 11.9426L19.5306 7.86285L21.0086 7.60724L21.7142 11.687L20.2361 11.9426ZM13.245 2.75H8.59634V1.25H13.245V2.75ZM7.68497 3.58754L6.87281 12.9802L5.37839 12.851L6.19055 3.45832L7.68497 3.58754ZM19.5306 7.86285C19.0238 4.93226 16.3813 2.75 13.245 2.75V1.25C17.0712 1.25 20.3708 3.91895 21.0086 7.60724L19.5306 7.86285ZM13.2548 18.8998L12.5921 14.8553L14.0724 14.6128L14.7351 18.6573L13.2548 18.8998ZM7.18772 13.7544L8.62646 14.9942L7.64728 16.1305L6.20854 14.8907L7.18772 13.7544ZM11.244 19.0279L11.7197 20.8618L10.2678 21.2384L9.79207 19.4046L11.244 19.0279ZM12.4382 21.2216L12.5832 21.175L13.0419 22.6031L12.897 22.6497L12.4382 21.2216ZM10.5235 17.184C10.8354 17.768 11.0777 18.3866 11.244 19.0279L9.79207 19.4046C9.65572 18.8789 9.45698 18.3711 9.20041 17.8908L10.5235 17.184ZM12.5832 21.175C12.8896 21.0766 13.1072 20.8399 13.1787 20.5642L14.6306 20.9408C14.4252 21.7328 13.819 22.3535 13.0419 22.6031L12.5832 21.175ZM11.7197 20.8618C11.7547 20.9968 11.8522 21.1209 11.9998 21.192L11.3486 22.5433C10.8166 22.2869 10.417 21.8137 10.2678 21.2384L11.7197 20.8618ZM11.9998 21.192C12.1345 21.2569 12.2931 21.2682 12.4382 21.2216L12.897 22.6497C12.3872 22.8135 11.8312 22.7758 11.3486 22.5433L11.9998 21.192ZM14.1537 13.0158H19.3348V14.5158H14.1537V13.0158ZM14.7351 18.6573C14.8596 19.4174 14.824 20.1952 14.6306 20.9408L13.1787 20.5642C13.3197 20.0208 13.3456 19.4539 13.2548 18.8998L14.7351 18.6573ZM8.59634 2.75C8.12243 2.75 7.726 3.11302 7.68497 3.58754L6.19055 3.45832C6.29851 2.20975 7.34269 1.25 8.59634 1.25V2.75ZM8.62646 14.9942C9.30632 15.58 10.0391 16.2773 10.5235 17.184L9.20041 17.8908C8.85403 17.2423 8.30249 16.6951 7.64728 16.1305L8.62646 14.9942ZM21.7142 11.687C21.9695 13.1635 20.8341 14.5158 19.3348 14.5158V13.0158C19.9014 13.0158 20.3332 12.5041 20.2361 11.9426L21.7142 11.687ZM12.5921 14.8553C12.4344 13.8924 13.1766 13.0158 14.1537 13.0158V14.5158C14.1038 14.5158 14.0639 14.561 14.0724 14.6128L12.5921 14.8553ZM6.87281 12.9802C6.84739 13.2742 6.96474 13.5622 7.18772 13.7544L6.20854 14.8907C5.62021 14.3837 5.31148 13.6247 5.37839 12.851L6.87281 12.9802Z" fill="currentColor"/>
              <path class="w-5 h-5 rtl:ml-2 scale-y-100" opacity="0.5" d="M3.9716 2.52911L3.22439 2.4645L3.9716 2.52911ZM3 13.7656L3.74721 13.8302C3.71261 14.2304 3.36893 14.5322 2.96767 14.5149C2.5664 14.4976 2.25 14.1673 2.25 13.7656L3 13.7656ZM4.71881 2.59372L3.74721 13.8302L2.25279 13.701L3.22439 2.4645L4.71881 2.59372ZM3.75 2.48709V13.7656H2.25V2.48709H3.75ZM3.22439 2.4645C3.2112 2.61704 3.33146 2.74983 3.48671 2.74983V1.24983C4.21268 1.24983 4.78122 1.87192 4.71881 2.59372L3.22439 2.4645ZM3.48671 2.74983C3.63292 2.74983 3.75 2.63139 3.75 2.48709H2.25C2.25 1.80457 2.80289 1.24983 3.48671 1.24983V2.74983Z" fill="currentColor"/>
              </svg>
              <span class="text-gray-900 dark:text-gray-300">{{ shortNumber($thread->down_votes) }}</span>
              <span class="sr-only">{{ __('dislikes') }}</span>
            </button>
          </span>
        @endif
        <a href="#reply-form" x-data x-tooltip.raw="{{ __('Replies') }}"
          class="inline-flex items-center text-sm">
          <span class="inline-flex ltr:space-x-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
          <svg width="1.25rem" height="1.25rem" viewBox="0 0 1170 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" class="w-5 h-5 rtl:ml-2 scale-y-100" d="M841.134446 1024a36.790489 36.790489 0 0 1-17.590681-4.46167L490.052242 837.487579h-110.627465C173.74912 837.487579 0 656.095108 0 441.45954V373.035081A376.681947 376.681947 0 0 1 379.424777 0.01024h411.424457A376.681947 376.681947 0 0 1 1170.274012 373.035081v68.278174a369.367735 369.367735 0 0 1-292.568503 363.955218V987.428937a36.571063 36.571063 0 0 1-36.571063 36.571063zM379.424777 72.823226A303.539822 303.539822 0 0 0 73.142126 373.035081v68.278174c0 172.139993 143.13914 323.141911 306.282651 323.141912h119.989657a36.900202 36.900202 0 0 1 17.590682 4.46167L804.563383 926.099265v-150.233927a36.571063 36.571063 0 0 1 30.28084-35.839641C994.184344 712.26826 1097.131886 595.058004 1097.131886 441.45954V373.035081a303.539822 303.539822 0 0 0-306.282652-300.358139h-411.424457z" fill="currentColor" /></svg>
            <span class="text-gray-900 dark:text-gray-300">{{ shortNumber($thread->replies_count ?? 0) }}</span>
            <span class="sr-only">{{ __('replies') }}</span>
        </a>
        </span>
        <a href="{{ route('threads.show', $thread->slug) }}" x-data x-tooltip.raw="{{ __('Views') }}"
          class="inline-flex items-center text-sm">
          <span class="inline-flex ltr:space-x-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
              class="w-5 h-5 rtl:ml-2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>

            <span class="text-gray-900 dark:text-gray-300">{{ shortNumber($thread->views) }}</span>
            <span class="sr-only">{{ __('views') }}</span>
          </span>
        </a>
      </div>
      
    <div x-data="{ show: false }" @click.away="show = false" class="relative inline-flex items-center">
      <span class="inline-flex items-center text-sm">
        <button type="button" @click="show = true"
          class="inline-flex ltr:space-x-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
          <svg class="h-5 w-5 rtl:ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path
              d="M13 4.5a2.5 2.5 0 11.702 1.737L6.97 9.604a2.518 2.518 0 010 .792l6.733 3.367a2.5 2.5 0 11-.671 1.341l-6.733-3.367a2.5 2.5 0 110-3.475l6.733-3.366A2.52 2.52 0 0113 4.5z" />
          </svg>
          <span class="text-gray-900 dark:text-gray-300">{{ __('Share') }}</span>
        </button>
      </span>

      <div x-show="show" style="display: none"
        class="absolute {{ $sharePosition }} z-10 w-64 md:w-96 ltr:origin-bottom-left rtl:origin-bottom-right rounded-md bg-white dark:bg-gray-700 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden">
        <div class="grid grid-cols-2 md:grid-cols-3 p-1 gap-1">
          <a href="{{ $socialLink->blogger->shareUrl }}"
            class="block px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
            Blogger
          </a>
          <a href="{{ $socialLink->facebook->shareUrl }}"
            class="block px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
            Facebook
          </a>
          <a href="{{ $socialLink->linkedin->shareUrl }}"
            class="block px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
            LinkedIn
          </a>
          <a href="{{ $socialLink->pinterest->shareUrl }}"
            class="block px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
            Pinterest
          </a>
          <a href="{{ $socialLink->pocket->shareUrl }}"
            class="block px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
            Pocket
          </a>
          <a href="{{ $socialLink->reddit->shareUrl }}"
            class="block px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
            Reddit
          </a>
          {{-- <a href="{{ $socialLink->telegram->shareUrl }}"
            class="block px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
            Telegram
          </a> --}}
          <a href="https://telegram.me/share/url?url={{ rawurlencode(route('threads.show', $thread->slug)) }}&text={{ rawurlencode($thread->description) }}"
            class="block px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
            Telegram
          </a>
          <a href="{{ $socialLink->tumblr->shareUrl }}"
            class="block px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
            Tumblr
          </a>
          <a href="{{ $socialLink->twitter->shareUrl }}"
            class="block px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
            Twitter
          </a>
          <a href="{{ $socialLink->vk->shareUrl }}" class="block px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
            VK
          </a>
          <a href="{{ $socialLink->whatsapp->shareUrl }}"
            class="block px-4 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
            Whatsapp
          </a>
        </div>
      </div>

    </div>


    @if ($thread->lastReply)
        <span class="inline-flex ltr:space-x-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300" x-data
          x-tooltip.raw="{{ __('Last Reply') }}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 rtl:ml-2">
            <path fill-rule="evenodd"
              d="M14.47 2.47a.75.75 0 011.06 0l6 6a.75.75 0 010 1.06l-6 6a.75.75 0 11-1.06-1.06l4.72-4.72H9a5.25 5.25 0 100 10.5h3a.75.75 0 010 1.5H9a6.75 6.75 0 010-13.5h10.19l-4.72-4.72a.75.75 0 010-1.06z"
              clip-rule="evenodd" />
          </svg>
          <span class="text-sm text-gray-700 dark:text-gray-300">
            {{ str(
                __(':user replied :at', [
                    'user' => $thread->lastReply->user
                        ? '<a href="' .
                            route('users.show', $thread->lastReply->user->username) .
                            '" class="hover dark:hover:text-gray-300">' .
                            $thread->lastReply->user->displayName .
                            '</a>'
                        : '',
                    'at' => $thread->lastReply->created_at->diffForHumans(),
                ]),
            )->toHtmlString() }}
            {{-- <a href="#" class="link font-bold">User</a> replied 3 mins ago --}}
          </span>
        </span>
      @endif
    </div>




  </div>
