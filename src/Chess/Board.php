<?php

namespace Chess;

use Chess\Exceptions\Exception;
use Chess\Exceptions\StorageException;
use Chess\Pieces\Piece;
use Chess\Storage\StorageInterface;

class Board
{
    private $squares = [];

    private $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function addPiece(Piece $piece, $x, $y)
    {
        if (!empty($this->squares[$x][$y])) {
            throw new Exception("Square is already occupied");
        }

        $this->squares[$x][$y] = $piece;
    }

    public function movePiece($fromX, $fromY, $toX, $toY)
    {
        if (empty($this->squares[$fromX][$fromY])) {
            throw new Exception("Square is empty");
        }

        if (!empty($this->squares[$toX][$toY])) {
            throw new Exception("Square is already occupied");
        }

        $this->squares[$toX][$toY] = $this->squares[$fromX][$fromY];
        unset($this->squares[$fromX][$fromY]);
    }

    public function removePiece($x, $y)
    {
        if (empty($this->squares[$x][$y])) {
            throw new Exception("Square is already empty");
        }

        unset($this->squares[$x][$y]);
    }

    public function save($key = 'board')
    {
        $this->storage->put($key, serialize($this->squares));
    }

    public function load($key = 'board')
    {
        $this->squares = unserialize($this->storage->get($key));
    }
}