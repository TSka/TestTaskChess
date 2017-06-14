<?php

namespace Chess\Storage;

interface StorageInterface
{
    /**
     * Get data for the giving key
     *
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * Put data
     *
     * @param $key
     * @param $data
     */
    public function put($key, $data);

    /**
     * Check if exist data for the giving key
     *
     * @param $key
     * @return mixed
     */
    public function has($key);
}