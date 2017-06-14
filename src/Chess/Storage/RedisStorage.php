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
        if (!$this->has($key)) {
            throw new StorageException("Save state does not exist");
        }

        return unserialize($this->client->get($key));
    }

    public function put($key, $data)
    {
        return $this->client->set($key, serialize($data));
    }

    public function has($key)
    {
        return $this->client->exists($key);
    }

    public function remove($key)
    {
        return $this->client->del($key);
    }
}