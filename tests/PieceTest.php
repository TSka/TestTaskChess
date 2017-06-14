<?php

namespace tests;

use Chess\Pieces\Pawn;
use PHPUnit\Framework\TestCase;

class PieceTest extends TestCase
{
    public function testColor()
    {
        $color = 'white';
        $pawn = new Pawn($color);
        $this->assertEquals($pawn->getColor(), $color, 'Wrong piece color');
    }
}