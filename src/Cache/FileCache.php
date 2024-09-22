<?php

namespace App\Cache;

class FileCache implements CacheInterface
{
    private $cacheDir;

    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    public function get($key)
    {
        $filename = $this->getCacheFilename($key);
        if (file_exists($filename)) {
            $content = file_get_contents($filename);
            $data = unserialize($content);
            if ($data['expiration'] === null || $data['expiration'] > time()) {
                return $data['value'];
            }
            $this->delete($key);
        }
        return null;
    }

    public function set($key, $value, $ttl = null)
    {
        $filename = $this->getCacheFilename($key);
        $data = [
            'value' => $value,
            'expiration' => $ttl ? time() + $ttl : null,
        ];
        file_put_contents($filename, serialize($data));
    }

    public function delete($key)
    {
        $filename = $this->getCacheFilename($key);
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function clear()
    {
        $files = glob($this->cacheDir . '/*.cache');
        foreach ($files as $file) {
            unlink($file);
        }
    }

    public function has($key)
    {
        return $this->get($key) !== null;
    }

    private function getCacheFilename($key)
    {
        return $this->cacheDir . '/' . md5($key) . '.cache';
    }
}
