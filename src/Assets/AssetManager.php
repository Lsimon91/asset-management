<?php

namespace App\Assets;

class AssetManager
{
    private $basePath;
    private $baseUrl;

    public function __construct($basePath, $baseUrl)
    {
        $this->basePath = rtrim($basePath, '/');
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function css($file)
    {
        return $this->asset("css/$file");
    }

    public function js($file)
    {
        return $this->asset("js/$file");
    }

    public function image($file)
    {
        return $this->asset("images/$file");
    }

    private function asset($path)
    {
        $filePath = "$this->basePath/$path";
        $fileUrl = "$this->baseUrl/$path";

        if (!file_exists($filePath)) {
            throw new \Exception("Asset not found: $path");
        }

        $version = filemtime($filePath);
        return "$fileUrl?v=$version";
    }
}
