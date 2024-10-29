@props(['id' => 'textarea-body', 'disabled' => false, 'property' => '', 'model' => '', 'key' => ''])
{{-- @php
  try {
      $value = html_entity_decode(json_encode($model));
  } catch (\Exception $e) {
      $value = '';
  }
@endphp --}}

<div wire:ignore key="sdme{{ $key }}" x-data="{
    show: false,
    contents: '',
    simplemde: null,
    toggle() { this.show = !this.show; },
    @if ($settings['allowed_upload'] ?? false) attach(file) {
      {{-- console.log(file, simplemde, this.simplemde); --}}
      if (file && this.simplemde) {
        let formData = new FormData();
        formData.append('file', $refs.photo.files[0]);
        window.axios.post('/upload', formData, {
            headers: { 'Accept': 'application/json', 'Content-Type': 'multipart/form-data' }
        }).then(res => {
          if (['png', 'jpg', 'jpeg', 'gif', 'svg'].includes(res.data.extension)) {
            this.insertString(this.simplemde.codemirror, `![${res.data.name}](${res.data.filename})`);
          } else {
            this.insertString(simplemde.codemirror, `[${res.data.name}](${res.data.filename})`);
          }

          $refs.photo.value = '';
          this.toggle();
        }).catch(console.log);
      }
    },
    insertString(editor, str) {
      let selection = editor.getSelection();
      if (selection.length > 0) {
          editor.replaceSelection(str);
      } else {
        let doc = editor.getDoc();
        let cursor = doc.getCursor();
        let pos = { line: cursor.line, ch: cursor.ch }

        doc.replaceRange(str, pos);
      }
  } @endif
}" x-init="() => {
    var imageFn = (editor) => {
        toggle();
    }

    this.simplemde = simplemde = new SimpleMDE({
        status: false,
        forceSync: false,
        spellChecker: false,
        {{-- hideIcons: ['guide', 'heading'], --}}
        renderingConfig: {
            codeSyntaxHighlighting: true,
        },
        element: document.getElementById('{{ $id }}'),
        toolbar: [
            'heading-2', 'heading-3', 'bold', 'italic', '|', 'quote', 'unordered-list', 'ordered-list', '|', 'link', 'image',
            @if($logged_in_user?->can('uploads')) { name: 'image', className: 'fa fa-cloud-upload', action: imageFn },
            @endif 'code', '|', 'horizontal-rule', 'preview', 'side-by-side', 'fullscreen'
        ]
    });

    this.simplemde.value({{ json_encode($model) }});
    {{-- this.simplemde.codemirror.refresh(); --}}
    {{-- this.simplemde.value({{ str_replace(['&quote;', '"'], "'", json_encode($model)) }}); --}}
    this.simplemde.codemirror.on('change', () => {
        contents = this.simplemde.value();
        $wire.set('{{ $property }}', contents, true);
    });

    window.addEventListener('quoteReply', (event) => {
        let el = document.getElementById('reply-body-field');
        el.blur();
        let value = el.value;
        el.value = '<blockquote>' + event.detail + '</blockquote>\n\n' + value;
        this.simplemde.value(el.value);
        el.dispatchEvent(new Event('change'))
        let enterE = {
            'key': 'Enter',
        };
        el.dispatchEvent(new KeyboardEvent('keypress', enterE));
        el.dispatchEvent(new KeyboardEvent('keydown', enterE));
        el.dispatchEvent(new KeyboardEvent('keyup', enterE));
        setTimeout(() => {
            el.style.height = el.scrollHeight;
            el.scrollTop = el.scrollHeight + 100;
        }, 100);
        el.scrollIntoView();
        el.focus();
        document.getElementById('reply-form-con').scrollIntoView();
        this.simplemde.codemirror.focus();
        this.simplemde.codemirror.setCursor(this.simplemde.codemirror.lineCount(), 0);
    });
}">
  <div class="prose dark:prose-invert max-w-none">
    <textarea x-model="contents" {{ $disabled ? 'disabled' : '' }} id="{{ $id }}" ref="{{ $id }}" style="display: none"></textarea>
  </div>
  @if ($settings['allowed_upload'] ?? false)
    <p class="mt-1 text-sm mb-2 text-gray-500">{{ __('You can drop image or copy and paste here. You can embed the video code too.') }}
  @endif
  </p>

  <div x-show="show" style="display: none" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div @click.away="show = false"
          class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-900 p-4 text-left shadow-xl transition-all sm:w-full sm:max-w-sm">
          <div>
            <div class="flex justify-center rounded-lg border border-dashed border-gray-900/25 dark:border-gray-700 p-6">
              <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd"
                    d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                    clip-rule="evenodd" />
                </svg>
                <div class="mt-2 flex text-sm leading-6">
                  <label for="file-upload" class="relative flex items-center cursor-pointer link">
                    <span>{{ __('Select a file') }}</span>
                    <input id="file-upload" name="file-upload" type="file" class="sr-only" x-ref="photo"
                      x-on:change="attach($refs.photo.files[0]);">
                  </label>
                  <p class="pl-1">{{ __('or drag and drop') }}</p>
                </div>
                <p class="text-xs leading-5 uppercase">
                  {{ str($settings['allowed_files'] ?? 'jpg,jpeg,png,pdf')->replace(',', ', ') . ' ' . __('up to 2MB') }}</p>
              </div>
            </div>
          </div>
          {{-- <div class="mt-5 sm:mt-6">
            <button type="button"
              class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('Upload') }}</button>
          </div> --}}
        </div>
      </div>
    </div>
  </div>
</div>
