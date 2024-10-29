<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Setting;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use Actions;
    use WithFileUploads;

    public $icon;

    public $logo;

    public $captcha;

    public $settings;

    public $version;

    public $languages;

    protected function rules()
    {
        return [
            'icon' => 'nullable|image|max:200|dimensions:min_width=24,max_width=250,ratio=1/1',
            'logo' => 'nullable|image|max:1000|dimensions:max_width=600,max_height=150',

            'settings.name'                => 'required',
            'settings.mode'                => 'required',
            'settings.per_page'            => 'required',
            'settings.title'               => 'required',
            'settings.description'         => 'required',
            'settings.contact_email'       => 'required',
            'settings.language'            => 'required',
            'settings.theme'               => 'nullable',
            'settings.rtl'                 => 'nullable',
            'settings.sticky_sidebar'      => 'nullable',
            'settings.member_page'         => 'nullable',
            'settings.allowed_upload'      => 'nullable',
            'settings.allowed_files'       => 'nullable',
            'settings.search_length'       => 'nullable',
            'settings.search_backdrop'     => 'nullable',
            'settings.articles'            => 'nullable',
            'settings.knowledgebase'       => 'nullable',
            'settings.faqs'                => 'nullable',
            'settings.articles_index'      => 'nullable',
            'settings.faqs_index'          => 'nullable',
            'settings.knowledgebase_index' => 'nullable',
            'settings.contact'             => 'nullable',
            'settings.contact_page'        => 'nullable|string',
            'settings.extra_terms_name'    => 'nullable|string',
            'settings.extra_terms_link'    => 'nullable|string',
            'settings.captcha'             => 'nullable|boolean',
            'settings.captcha_provider'    => ['nullable', 'in:local,recaptcha,trunstile', Rule::requiredIf(fn () => $this->settings['captcha'])],
            'settings.captcha_site_key'    => ['nullable', Rule::requiredIf(fn () => $this->settings['captcha'])],
            'settings.captcha_secret_key'  => ['nullable', Rule::requiredIf(fn () => $this->settings['captcha'])],
        ];
    }

    public function deleteIcon()
    {
        Storage::disk('site')->delete($this->settings['icon']);
        Setting::updateOrCreate(['tec_key' => 'icon'], ['tec_value' => null]);
        $this->settings['icon'] = null;
        cache()->forget('forum_settings');

        return to_route('settings.general')->with('message', __('Icon has been deleted.'));
    }

    public function deleteLogo()
    {
        Storage::disk('site')->delete($this->settings['logo']);
        Setting::updateOrCreate(['tec_key' => 'logo'], ['tec_value' => null]);
        $this->settings['logo'] = null;
        cache()->forget('forum_settings');

        return to_route('settings.general')->with('message', __('Logo has been deleted.'));
    }

    public function mount()
    {
        if (auth()->user()->cant('settings')) {
            return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
        }

        $settings = site_config();
        $this->settings = [
            'icon'                => $settings['icon'] ?? '',
            'logo'                => $settings['logo'] ?? '',
            'name'                => $settings['name'] ?? '',
            'mode'                => $settings['mode'] ?? '',
            'per_page'            => $settings['per_page'] ?? '',
            'title'               => $settings['title'] ?? '',
            'description'         => $settings['description'] ?? '',
            'contact_email'       => $settings['contact_email'] ?? '',
            'language'            => $settings['language'] ?? '',
            'theme'               => $settings['theme'] ?? '',
            'rtl'                 => $settings['rtl'] ?? '',
            'sticky_sidebar'      => $settings['sticky_sidebar'] ?? '',
            'member_page'         => $settings['member_page'] ?? '',
            'allowed_upload'      => $settings['allowed_upload'] ?? '',
            'allowed_files'       => $settings['allowed_files'] ?? '',
            'search_length'       => $settings['search_length'] ?? '',
            'search_backdrop'     => $settings['search_backdrop'] ?? '',
            'articles'            => 1 == ($settings['articles'] ?? null),
            'knowledgebase'       => 1 == ($settings['knowledgebase'] ?? null),
            'faqs'                => 1 == ($settings['faqs'] ?? null),
            'articles_index'      => 1 == ($settings['articles_index'] ?? null),
            'faqs_index'          => 1 == ($settings['faqs_index'] ?? null),
            'knowledgebase_index' => 1 == ($settings['knowledgebase_index'] ?? null),
            'contact'             => 1 == ($settings['contact'] ?? null),
            'contact_page'        => $settings['contact_page'] ?? '',
            'extra_terms_name'    => $settings['extra_terms_name'] ?? '',
            'extra_terms_link'    => $settings['extra_terms_link'] ?? '',
            'captcha'             => $settings['captcha'] ?? 0,
            'captcha_provider'    => $settings['captcha_provider'] ?? '',
            'captcha_site_key'    => $settings['captcha_site_key'] ?? '',
            'captcha_secret_key'  => $settings['captcha_secret_key'] ?? '',
        ];

        $langFiles = json_decode(file_get_contents(lang_path('languages.json')), true);
        $this->languages = $langFiles['available'];
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $this->version = $composer['version'];
    }

    public function render()
    {
        return view('livewire.admin.settings.index')->layoutData(['title' => __('Application Settings')]);
    }

    public function save()
    {
        $this->validate();

        if (demo()) {
            unset($this->settings['captcha_provider'], $this->settings['captcha_site_key'], $this->settings['captcha_secret_key']);
        }

        if ($this->logo) {
            $this->settings['logo'] = $this->logo->store('images', 'site');
        }
        if ($this->icon) {
            $this->settings['icon'] = $this->icon->store('images', 'site');
        }
        foreach ($this->settings as $key => $value) {
            Setting::updateOrCreate(['tec_key' => $key], ['tec_value' => $value]);
        }
        cache()->forget('forum_settings');

        return to_route('settings.general')->with('message', __('Settings has been successfully saved.'));
    }

    public function sitemap()
    {
        SitemapGenerator::create(url('/'))->writeToFile(public_path('sitemap.xml'));
        $this->emitSelf('sitemapGenerated');
        $this->dispatchBrowserEvent('sitemap-completed');
        $this->notification()->success(
            $title = __('Saved!'),
            $description = __('Sitemap has been successfully saved.')
        );
    }

    protected function validationAttributes()
    {
        return [
            'settings.name'                => __('name'),
            'settings.mode'                => __('mode'),
            'settings.per_page'            => __('rows per page'),
            'settings.title'               => __('title'),
            'settings.description'         => __('description'),
            'settings.contact_email'       => __('contact email'),
            'settings.language'            => __('language'),
            'settings.theme'               => __('theme'),
            'settings.rtl'                 => __('rtl'),
            'settings.sticky_sidebar'      => __('sticky sidebar'),
            'settings.member_page'         => __('member page'),
            'settings.allowed_upload'      => __('allow upload'),
            'settings.allowed_files'       => __('allowed files'),
            'settings.search_length'       => __('search length'),
            'settings.search_backdrop'     => __('search backdrop'),
            'settings.articles'            => __('articles'),
            'settings.knowledgebase'       => __('knowledge base'),
            'settings.faqs'                => __('faqs'),
            'settings.articles_index'      => __('articles index'),
            'settings.faqs_index'          => __('faqs index'),
            'settings.knowledgebase_index' => __('knowledgebase index'),
            'settings.contact'             => __('contact'),
            'settings.contact_page'        => __('contact page'),
            'settings.extra_terms_name'    => __('extra terms name'),
            'settings.extra_terms_link'    => __('extra terms link'),
            'settings.captcha'             => __('captcha'),
            'settings.captcha_provider'    => __('captcha provider'),
            'settings.captcha_site_key'    => __('captcha site key'),
            'settings.captcha_secret_key'  => __('captcha secret key'),
        ];
    }
}
