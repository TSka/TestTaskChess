<?php

namespace Chess\Storage;

use Chess\Exceptions\StorageException;

class FileStorage implements StorageInterface
{
    private $directory;

    public function __construct($directory = 'storage')
    {
        $this->directory = $directory;
    }

    public function get($key)
    {
        if (!$this->has($key)) {
            throw new StorageException("Save state does not exist");
        }

        return unserialize(file_get_contents($this->path($key)));
    }

    public function put($key, $data)
    {
        return file_put_contents($this->path($key), serialize($data)) !== false ? true : false;
    }

    public function has($key)
    {
        return is_file($this->path($key));
    }

    public function remove($key)
    {
        return unlink($this->path($key));
    }


    /**
     * Get the full path for the given key.
     *
     * @param  string  $key
     * @return string
     */
    private function path($key)
    {
        return $this->directory.'/'.sha1($key);
    }
}