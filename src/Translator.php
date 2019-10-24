<?php

namespace Sashaef\TranslateProvider;

use App\Models\Lang;
use Countable;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\NamespacedItemResolver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Illuminate\Translation\MessageSelector;

class Translator extends NamespacedItemResolver implements TranslatorContract
{
    use Macroable;

    /**
     * The loader implementation.
     *
     * @var Redis
     */
    protected $loader;

    /**
     * The default locale being used by the translator.
     *
     * @var string
     */
    protected $locale;

    /**
     * The type.
     *
     * @var string
     */
    protected $type;

    /**
     * The fallback locale used by the translator.
     *
     * @var string
     */
    protected $fallback;

    /**
     * The message selector.
     *
     * @var \Illuminate\Translation\MessageSelector
     */
    protected $selector;

    /**
     * Create a new translator instance.
     *
     * @param $loader
     * @param  string  $locale
     * @return void
     */
    public function __construct($loader, $locale)
    {
        $this->loader = $loader;
        $this->locale = $locale;
    }

    /**
     * Determine if a translation exists for a given locale.
     *
     * @param  string  $key
     * @param  string|null  $locale
     * @return bool
     */
    public function hasForLocale($key, $locale = null)
    {
        return $this->has($key, $locale, false);
    }

    /**
     * Determine if a translation exists.
     *
     * @param  string  $key
     * @param  string|null  $locale
     * @param  bool  $fallback
     * @return bool
     */
    public function has($key, $locale = null, $fallback = true)
    {
        return $this->get($key, [], $locale, $fallback) !== $key;
    }

    /**
     * Get the translation for a given key.
     *
     * @param  string  $key
     * @param  array   $replace
     * @param  string|null  $locale
     * @return string|array
     */
    public function trans($key, array $replace = [], $locale = null)
    {
        return $this->get($key, $replace, $locale);
    }

    /**
     * Get the translation for the given key.
     *
     * @param  string  $key
     * @param  array   $replace
     * @param  string|null  $locale
     * @param  bool  $fallback
     * @return string|array
     */
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        [$group, $item] = $this->parseKey($key);

        $locales = $fallback ? $this->localeArray($locale) : [$locale ?: $this->locale];

        foreach ($locales as $locale) {
            if (!is_null($line = $this->getLine($this->type, $group, $locale, $item, $replace))) {
                break;
            }
        }

        return $line ?? $key;
    }

    /**
     * Get a translation according to an integer value.
     *
     * @param  string  $key
     * @param  int|array|\Countable  $number
     * @param  array   $replace
     * @param  string|null  $locale
     * @return string
     */
    public function transChoice($key, $number, array $replace = [], $locale = null)
    {
        return $this->choice($key, $number, $replace, $locale);
    }

    /**
     * Get a translation according to an integer value.
     *
     * @param  string  $key
     * @param  int|array|\Countable  $number
     * @param  array   $replace
     * @param  string|null  $locale
     * @return string
     */
    public function choice($key, $number, array $replace = [], $locale = null)
    {
        $line = $this->get(
            $key, $replace, $locale = $this->localeForChoice($locale)
        );

        // If the given "number" is actually an array or countable we will simply count the
        // number of elements in an instance. This allows developers to pass an array of
        // items without having to count it on their end first which gives bad syntax.
        if (is_array($number) || $number instanceof Countable) {
            $number = count($number);
        }

        $replace['count'] = $number;

        return $this->makeReplacements(
            $this->getSelector()->choose($line, $number, $locale), $replace
        );
    }

    /**
     * Get the proper locale for a choice operation.
     *
     * @param  string|null  $locale
     * @return string
     */
    protected function localeForChoice($locale)
    {
        return $locale ?: $this->locale ?: $this->fallback;
    }

    /**
     * Retrieve a language line out the loaded array.
     *
     * @param  string  $type
     * @param  string  $group
     * @param  string  $locale
     * @param  string  $item
     * @param  array   $replace
     * @return string|array|null
     */
    protected function getLine($type, $group, $locale, $item, array $replace)
    {
        $line = $this->loader::get($type.':'.$group.':'.$item.':'.$this->getLangId($locale));

        if (is_string($line)) {
            return $this->makeReplacements($line, $replace);
        } elseif (is_array($line) && count($line) > 0) {
            foreach ($line as $key => $value) {
                $line[$key] = $this->makeReplacements($value, $replace);
            }

            return $line;
        }
    }

    /**
     * Make the place-holder replacements on a line.
     *
     * @param  string  $line
     * @param  array   $replace
     * @return string
     */
    protected function makeReplacements($line, array $replace)
    {
        if (empty($replace)) {
            return $line;
        }

        $replace = $this->sortReplacements($replace);

        foreach ($replace as $key => $value) {
            $line = str_replace(
                [':'.$key, ':'.Str::upper($key), ':'.Str::ucfirst($key)],
                [$value, Str::upper($value), Str::ucfirst($value)],
                $line
            );
        }

        return $line;
    }

    /**
     * Sort the replacements array.
     *
     * @param  array  $replace
     * @return array
     */
    protected function sortReplacements(array $replace)
    {
        return (new Collection($replace))->sortBy(function ($value, $key) {
            return mb_strlen($key) * -1;
        })->all();
    }

    /**
     * Add translation lines to the given locale.
     *
     * @param  array  $lines
     * @param  string  $locale
     * @param  string  $type
     * @return void
     */
    public function addLines(array $lines, $locale)
    {
        foreach ($lines as $key => $value) {
            [$group, $item] = $this->parseKey($key);

            $this->loader::set($this->type.':'.$group.':'.$item.':'.$this->getLangId($locale), $value);
        }
    }

    /**
     * Parse a key into namespace, group, and item.
     *
     * @param  string  $key
     * @return array
     */
    public function parseKey($key)
    {
        $group = explode('.', $key, 2);

        return [$group[0], $key];
    }

    /**
     * Get the array of locales to be checked.
     *
     * @param  string|null  $locale
     * @return array
     */
    protected function localeArray($locale)
    {
        return array_filter([$locale ?: $this->locale, $this->fallback]);
    }

    /**
     * Get the message selector instance.
     *
     * @return \Illuminate\Translation\MessageSelector
     */
    public function getSelector()
    {
        if (! isset($this->selector)) {
            $this->selector = new MessageSelector;
        }

        return $this->selector;
    }

    /**
     * Set the message selector instance.
     *
     * @param  \Illuminate\Translation\MessageSelector  $selector
     * @return void
     */
    public function setSelector(MessageSelector $selector)
    {
        $this->selector = $selector;
    }

    /**
     * Get the language line loader implementation.
     *
     * @return Redis
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Get the default locale being used.
     *
     * @return string
     */
    public function locale()
    {
        return $this->getLocale();
    }

    /**
     * Get the default locale being used.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set the default locale.
     *
     * @param  string  $locale
     * @return void
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Get the fallback locale being used.
     *
     * @return string
     */
    public function getFallback()
    {
        return $this->fallback;
    }

    /**
     * Set the fallback locale being used.
     *
     * @param  string  $fallback
     * @return void
     */
    public function setFallback($fallback)
    {
        $this->fallback = $fallback;
    }

    /**
     * Set the loaded translation groups.
     *
     * @param string $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Bootstrap services.
     *
     * @param  string  $locale
     * @return void
     */
    public function getLangId($locale)
    {
        $langIds = Cache::rememberForever('lang.ids', function () {
            return Lang::query()->where('is_active', true)->get()->pluck('id', 'index');
        });

        return $langIds[$locale] ?? $langIds[$this->fallback];
    }

    /**
     * Get the translation for a given key from the JSON translation files.
     *
     * @param  string  $key
     * @param  array  $replace
     * @param  string|null  $locale
     * @return string|array
     */
    public function getFromJson($key, array $replace = [], $locale = null)
    {
        return $this->get($key, $replace, $locale);
    }
}
