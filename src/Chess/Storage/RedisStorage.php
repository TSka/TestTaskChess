<?php

namespace Chess\Storage;

use Predis\Client as RedisClient;

class RedisStorage implements StorageInterface
{
    private $client;

    public function __construct($parameters = [])
    {
        $this->client = new RedisClient($parameters);
    }

    public function get($key)
    {
        return $this->client->get($key);
    }

    public function put($key, $data)
    {
        return $this->client->set($key, $data);
    }

    public function has($key)
    {
        return $this->client->exists($key);
    }
}