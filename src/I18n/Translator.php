<?php

namespace App\I18n;

class Translator
{
    private $translations = [];
    private $locale;

    public function __construct($locale)
    {
        $this->setLocale($locale);
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
        $this->loadTranslations();
    }

    public function translate($key, $params = [])
    {
        $translation = $this->translations[$key] ?? $key;

        foreach ($params as $param => $value) {
            $translation = str_replace(":$param", $value, $translation);
        }

        return $translation;
    }

    private function loadTranslations()
    {
        $file = __DIR__ . "/../../resources/lang/{$this->locale}.php";
        if (file_exists($file)) {
            $this->translations = require $file;
        }
    }
}
