<?php

namespace App\Cache;

interface CacheInterface
{
    public function get($key);
    public function set($key, $value, $ttl = null);
    public function delete($key);
    public function clear();
    public function has($key);
}
