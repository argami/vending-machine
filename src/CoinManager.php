<?php declare(strict_types=1);

namespace vending;

class CoinManager
{
    private $coinDrawers = null;

    
    public function __construct($coins)
    {
        $this->coinDrawers = $coins;
    }
    
    public function isValid(float $coin):bool
    {
        return $this->getCoin($coin) != null;
    }

    public function getChange(float $changeAmount):array
    {
        return $this->coinDrawers->getChange($changeAmount);
    }

    public function any(float $coin): bool
    {
        if ($this->isValid($coin)) {
            return $this->getCoin($coin)->count() > 0;
        }
        return false;
    }

    public function getCoin(float $coin)
    {
        return $this->coinDrawers->findByValue($coin);
    }

    public function add(...$coins)
    {
        foreach ($coins as $coinCode) {
            if (!$this->isValid($coinCode)) {
                // In the vending machine coins should be validated on
                // inserting we should never reach here
                throw new \Exception("Invalid Coin", 50);
            }
        
            $coin = $this->getCoin($coinCode);
            $coin->add(1);
        }


        return true;
    }
}
