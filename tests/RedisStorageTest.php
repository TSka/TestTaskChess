<?php

namespace tests;

use Chess\Exceptions\StorageException;
use Chess\Storage\RedisStorage;
use PHPUnit\Framework\TestCase;
use Predis\Client;
use Predis\Connection\ConnectionException;

class RedisStorageTest extends TestCase
{
    protected function setUp()
    {
        try {
            (new Client())->connect();
        }
        catch (ConnectionException $e) {
            $this->markTestSkipped('Redis is not available');
        }
    }

    public function testStorage()
    {
        $key = sha1(rand(0, 100));
        $data = sha1(rand(0, 100));
        $storage = new RedisStorage();

        $this->assertTrue($storage->put($key, $data));
        $this->assertEquals($storage->get($key), $data);
        $this->assertTrue($storage->remove($key));

        $this->expectException(StorageException::class);
        $storage->get($key);
    }
}