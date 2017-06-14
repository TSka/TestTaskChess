<?php

namespace Chess;

use Chess\Exceptions\Exception;
use Chess\Pieces\Piece;
use Chess\Storage\StorageInterface;

class Board
{
    private $squares = [];

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

    public function save(StorageInterface $storage, $key = 'board')
    {
        $storage->save($key, serialize($this->squares));
    }

    public function load(StorageInterface $storage, $key = 'board')
    {
        $this->squares = unserialize($storage->load($key));
    }
}