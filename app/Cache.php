<?php

class Cache
{
    private $cacheDirectory = __DIR__ . '/../cache';

    private function getCachedFilePath(string $id)
    {
        return $this->cacheDirectory . '/' . $id . '.json';
    }

    public function get(string $id)
    {
        $cacheFile = $this->getCachedFilePath($id);

        if (!file_exists($cacheFile)) {
            return null;
        }

        return file_get_contents($cacheFile);
    }

    public function put(string $id, string $data = null)
    {
        $cacheFile = $this->getCachedFilePath($id);

        $resource = fopen($cacheFile, 'w');

        fwrite($resource, $data);
        fclose($resource);
    }
}