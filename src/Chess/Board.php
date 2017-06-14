<?php

namespace Chess;

use Chess\Events\ManagerInterface;
use Chess\Exceptions\Exception;
use Chess\Exceptions\StorageException;
use Chess\Pieces\Piece;
use Chess\Storage\StorageInterface;

class Board
{
    const EVENT_ADD_PIECE = 'add_piece';

    private $squares = [];

    private $storage;

    private $events;

    /**
     * Board constructor.
     *
     * @param StorageInterface $storage
     * @param ManagerInterface $events
     */
    public function __construct(StorageInterface $storage, ManagerInterface $events)
    {
        $this->storage = $storage;
        $this->events = $events;
    }

    /**
     * Add piece on board
     *
     * @param Piece $piece
     * @param       $x
     * @param       $y
     *
     * @throws Exception
     */
    public function addPiece(Piece $piece, $x, $y)
    {
        if (!empty($this->squares[$x][$y])) {
            throw new Exception("Square is already occupied");
        }

        $this->events->notify(self::EVENT_ADD_PIECE, $piece);

        $this->squares[$x][$y] = $piece;
    }

    /**
     * Move piece
     *
     * @param $fromX
     * @param $fromY
     * @param $toX
     * @param $toY
     *
     * @throws Exception
     */
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

    /**
     * Remove piece from a board
     * @param $x
     * @param $y
     *
     * @throws Exception
     */
    public function removePiece($x, $y)
    {
        if (empty($this->squares[$x][$y])) {
            throw new Exception("Square is already empty");
        }

        unset($this->squares[$x][$y]);
    }

    /**
     * Get Piece from a board
     *
     * @param $x
     * @param $y
     * @return Piece|null
     */
    public function getPiece($x, $y)
    {
        return isset($this->squares[$x][$y]) ? $this->squares[$x][$y] : null;
    }

    /**
     * Save bboard state
     *
     * @param string $key
     * @return bool
     */
    public function save($key = 'board')
    {
        try {
            $this->storage->put($key, $this->squares);
            return true;
        }
        catch (StorageException $e) {
            return false;
        }
    }

    /**
     * Load board state
     *
     * @param string $key
     * @return bool
     */
    public function load($key = 'board')
    {
        try {
            $this->squares = $this->storage->get($key);
            return true;
        }
        catch (StorageException $e) {
            return false;
        }
    }

    /**
     * @return ManagerInterface
     */
    public function getEvents()
    {
        return $this->events;
    }
}