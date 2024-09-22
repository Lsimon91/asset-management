<?php

namespace App\Cache;

class Cache
{
    private $cachePath;

    public function __construct($cachePath = null)
    {
        $this->cachePath = $cachePath ?? __DIR__ . '/../../storage/cache';
    }

    public function get($key)
    {
        $filename = $this->getCacheFilename($key);
        if (file_exists($filename)) {
            $content = file_get_contents($filename);
            $data = unserialize($content);
            if ($data['expiration'] > time()) {
                return $data['value'];
            }
            unlink($filename);
        }
        return null;
    }

    public function set($key, $value, $minutes = 60)
    {
        $filename = $this->getCacheFilename($key);
        $data = [
            'value' => $value,
            'expiration' => time() + ($minutes * 60),
        ];
        file_put_contents($filename, serialize($data));
    }

    public function forget($key)
    {
        $filename = $this->getCacheFilename($key);
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    private function getCacheFilename($key)
    {
        return $this->cachePath . '/' . md5($key) . '.cache';
    }
}
