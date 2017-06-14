<?php

namespace Chess\Storage;

interface StorageInterface
{
    public function save($key, $data);

    public function load($key);
}