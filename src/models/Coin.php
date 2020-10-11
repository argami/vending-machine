<?php declare(strict_types=1);

namespace vending\models;

use vending\models\generic\GenericItem;

class Coin extends GenericItem
{
    private int $valueInCents = 0;

    public function __construct(float $value, $count = 0)
    {
        $this->valueInCents = $this->toCents($value);
        
        parent::__construct((string)$this->valueInCents, $count, $value);
    }

    public function centsValue():int
    {
        return $this->valueInCents;
    }

    public function getChange(float $changeAmount):array
    {
        $remaining = $this->toCents($changeAmount);
        $ncoins = 0;
        if ($this->canChange($remaining)) {
            $ncoins = $this->removeMax($remaining  / $this->valueInCents);
        }

        $remaining -= ($ncoins * $this->valueInCents);
        return [$remaining / 100, $this->toArray($ncoins)];
    }

    private function toArray(int $coinAmount)
    {
        $coins = [];
        
        array_push($coins, ...array_fill(0, $coinAmount, $this->getValue()));
        
        return $coins;
    }
    
    private function toCents(float $amount)
    {
        return (int)($amount * 100);
    }
    
    private function canChange($valueToChange): bool
    {
        return ($valueToChange >= $this->valueInCents && $this->count() > 0);
    }
    
    private function removeMax($ncoins): int
    {
        return $this->remove($ncoins > $this->count() ? $this->count() : $ncoins);
    }
}
