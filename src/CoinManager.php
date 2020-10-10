<?php declare(strict_types=1);

namespace vending;

const DEFAULT_COINS = ['0.05' => ['value' => 0.05, 'count' => 0],
                             '0.1' => ['value' => 0.1, 'count' => 0],
                             '0.25' => ['value' => 0.25, 'count' => 0],
                             '1' => ['value' => 1.0, 'count' => 0]];

class CoinManager
{
    private $coinDrawers = null;

    
    public function __construct(array $coinValuesCounts = [])
    {
        $this->coinDrawers = empty($coinValuesCounts) ? DEFAULT_COINS : $coinValuesCounts;
        
        $this->sort();
    }
    
    public function isValid(float $coin):bool
    {
        return array_key_exists((string)$coin, $this->coinDrawers);
    }

    public function getChange(float $changeAmount):array
    {
        $change = [];
        $remaining = $changeAmount;
        foreach ($this->coinDrawers as $key => $coin) {
            if ($remaining >= $coin['value'] && $coin['count'] > 0) {
                $ncoins = (int)($remaining / $coin['value']);
                $remaining -= ($ncoins * $coin['value']);
                array_push($change, ...array_fill(0, $ncoins, $coin['value']));
            }
        }
        
        return $change;
    }

    public function any(float $coin): bool
    {
        if ($this->isValid($coin)) {
            return $this->coinDrawers[(string)$coin]['count'] > 0;
        }
        return false;
    }

    private function sort()
    {
        uasort($this->coinDrawers, function ($left, $right) {
            return $right['value'] <=> $left['value'];
        });
    }
}
