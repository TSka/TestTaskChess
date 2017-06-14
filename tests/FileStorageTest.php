<?php

namespace tests;

use Chess\Exceptions\StorageException;
use Chess\Storage\FileStorage;
use PHPUnit\Framework\TestCase;

class FileStorageTest extends TestCase
{
    public function testStorage()
    {
        $key = sha1(rand(0, 100));
        $data = sha1(rand(0, 100));
        $storage = new FileStorage(sys_get_temp_dir());

        $this->assertTrue($storage->put($key, $data));
        $this->assertEquals($storage->get($key), $data);
        $this->assertTrue($storage->remove($key));

        $this->expectException(StorageException::class);
        $storage->get($key);
    }
}