<?php

namespace tests;

use Chess\Board;
use Chess\Events\EventManager;
use Chess\Events\ManagerInterface;
use Chess\Pieces\Pawn;
use Chess\Pieces\Piece;
use Chess\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var ManagerInterface
     */
    protected $events;

    protected function setUp()
    {
        $storage = $this->createMock(StorageInterface::class);
        $storage->method('get')->will($this->returnValue('test'));
        $storage->method('put');
        $storage->method('has')->will($this->returnValue('test'));

        $this->storage = $storage;

        $events = $this->createMock(ManagerInterface::class);
        $events->method('subscribe');
        $events->method('unsubscribe');
        $events->method('notify');

        $this->events = $events;
    }

    public function testEvents()
    {
        $self = $this;
        $pawn = new Pawn('white');

        $eventListener = function ($piece) use ($pawn, $self) {
            $self->assertTrue($piece instanceof Piece, 'Wrong notify data');
            $self->assertEquals($piece, $pawn, 'Wrong notify data');
        };

        $board = new Board($this->storage, new EventManager());
        $board->getEvents()->subscribe(Board::EVENT_ADD_PIECE, $eventListener);
        $board->addPiece($pawn, 'e', 2);
    }

    public function testStorage()
    {
        $saveKey = md5(rand(0, 100));
        $storage = new DummyStorage();
        $board1 = new Board($storage, new EventManager());
        $board2 = new Board($storage, new EventManager());
        $pawn1 = new Pawn('white');

        $board1->addPiece($pawn1, 'e', 2);
        $saveStatus = $board1->save($saveKey);
        $this->assertTrue($saveStatus, 'Saving error');

        $loadStatus = $board2->load($saveKey);
        $this->assertTrue($loadStatus, 'Loading error');
        $pawn2 = $board2->getPiece('e', 2);
        $this->assertEquals($pawn1, $pawn2);
    }
}

class DummyStorage implements StorageInterface
{
    protected $data = [];

    public function get($key)
    {
        return $this->data[$key];
    }

    public function put($key, $data)
    {
        $this->data[$key] = $data;
    }

    public function has($key)
    {
        return isset($this->data[$key]);
    }

}