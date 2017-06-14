[![Build Status](https://travis-ci.org/TSka/TestTaskChess.svg?branch=master)](https://travis-ci.org/TSka/TestTaskChess)

# Test Task Chess

```php
$fileStorage = new \Chess\Storage\RedisStorage();
$eventManager = new \Chess\Events\EventManager();

$board = new \Chess\Board($fileStorage, $eventManager);

$board->getEvents()->subscribe(\Chess\Board::EVENT_ADD_PIECE, function ($piece) {
    if ($piece instanceof \Chess\Pieces\Rook) {
        echo $piece->getColor() . ' rook added';
    }
});

$board->addPiece(new \Chess\Pieces\Pawn('white'), 'e', 2);
$board->addPiece(new \Chess\Pieces\Rook('black'), 'h', 8); // black rook added
$board->movePiece('e', 2, 'e', 4);
$board->save('test_task');
$board->removePiece('e', 4);
$board->load('test_task');
```