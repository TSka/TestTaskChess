<?php

namespace Chess\Pieces;

abstract class Piece
{
    private $color;

    /**
     * Piece constructor.
     *
     * @param $color
     */
    public function __construct($color)
    {
        $this->color = $color;
    }

    /**
     * Get piece color
     *
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }
}