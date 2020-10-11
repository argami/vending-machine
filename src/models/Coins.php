<?php declare(strict_types=1);

namespace vending\models;

use vending\models\generic\GenericCollection;
use vending\models\generic\interfaces\Changeable;

class Coins extends GenericCollection implements Changeable
{
    public function __construct(Coin ...$coins)
    {
        parent::__construct(...$coins);
    }


    public function getChange(float $changeAmount):array
    {
        $change = [];
        foreach ($this as $coin) {
            $denoChange = [];
            list($changeAmount, $denoChange) = $coin->getChange($changeAmount);
            array_push($change, ...$denoChange);
        }
        
        return $change;
    }

    public function findByValue(float $value)
    {
        $found = $this->items->filter(
            fn ($coin) => $coin->getValue() == $value
        );
        
        return $found->isEmpty() ? null : $found->first();
    }
}
