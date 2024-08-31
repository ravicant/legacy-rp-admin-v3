<?php

namespace App\Helpers;

class CacheFile
{
    private int $ttl;
    private string $path;

    /**
     * @var callable
     */
    private $fetcher;

    /**
     * @var callable
     */
    private $invalidator;

    private Mutex $mutex;

    private array $cache;

    public function __construct(string $name, callable $fetcher, int $ttl = 10, callable $invalidator = null)
    {
        $this->ttl = $ttl;
        $this->path = storage_path('cache/' . $name . '.json');

        $this->fetcher = $fetcher;
        $this->invalidator = $invalidator;

        $this->mutex = new Mutex($name);

        $dir = dirname($this->path);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    private function readFromCache()
    {
        if (isset($this->cache)) return;

        $this->cache = json_decode(file_get_contents($this->path), true);
    }

    private function populate()
    {
        // Read from cache if its still fresh
        $exists = file_exists($this->path);
        $invalid = false;

        if ($exists && $this->invalidator) {
            $this->readFromCache();

            $invalidator = $this->invalidator;

            $invalid = $invalidator($this->cache ?? []);
        }

        if (!$invalid && $exists && time() - filemtime($this->path) < $this->ttl) {
            $this->readFromCache();

            return;
        }

        // Attempt to lock the mutex
        if (!$this->mutex->lock()) {
            // RIP, guess we're getting stale data
            $this->readFromCache();

            return;
        }

        // Fetch fresh data
        try {
            $fetcher = $this->fetcher;

            $this->cache = $fetcher() ?? [];

            file_put_contents($this->path, json_encode($this->cache));
        } catch(\Exception $e) {
            // do nothing :)
        }

        $this->mutex->unlock();
    }

    public function get()
    {
        $this->populate();

        return $this->cache ?? [];
    }
}