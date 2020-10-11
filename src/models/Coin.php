<?php declare(strict_types=1);

namespace vending\models;

use vending\models\generic\GenericItem;

class Coin extends GenericItem
{
    private int $valueInCents = 0;


    public function __construct(float $value, $count = 0)
    {
        $this->valueInCents = (int)($value * 100);
        
        parent::__construct((string)$this->valueInCents, $count, $value);
    }

    public function centsValue():int
    {
        return $this->valueInCents;
    }
}
