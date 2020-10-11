<?php declare(strict_types=1);

namespace vending\models;

use vending\models\generic\GenericCollection;

final class Coins extends GenericCollection
{
    public function __construct(Coin ...$coins)
    {
        parent::__construct(...$coins);
    }
}
