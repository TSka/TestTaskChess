<?php

namespace Chess\Storage;

use Chess\Exceptions\Exception;

class FileStorage implements StorageInterface
{
    private $directory;

    public function __construct($directory = 'storage')
    {
        $this->directory = $directory;
    }

    public function get($key)
    {
        if (!file_exists($this->path($key))) {
            throw new Exception('Save state is not exist');
        }

        return file_get_contents($this->path($key));
    }

    public function put($key, $data)
    {
        file_put_contents($this->path($key), $data);
    }

    public function has($key)
    {
        return is_file($this->path($key));
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