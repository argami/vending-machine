<?php declare(strict_types=1);

namespace vending;

# value in cents
const DEFAULT_COINS = ['0.05' => ['value' => 5, 'count' => 0],
                             '0.1' => ['value' => 10, 'count' => 0],
                             '0.25' => ['value' => 25, 'count' => 0],
                             '1' => ['value' => 100, 'count' => 0]];

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
        $remaining = (int)($changeAmount * 100);
        foreach ($this->coinDrawers as $key => &$coin) {
            if ($remaining >= $coin['value'] && $coin['count'] > 0) {
                $ncoins = (int)($remaining  / $coin['value']);
                if ($ncoins > $coin['count']) {
                    $ncoins = $coin['count'];
                }
                $coin['count'] -= $ncoins;
                $remaining -= ($ncoins * $coin['value']);
                array_push($change, ...array_fill(0, $ncoins, $coin['value'] / 100));
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

    public function getCoin(float $coin)
    {
        return $this->coinDrawers[(string)$coin];
    }

    private function sort()
    {
        uasort($this->coinDrawers, function ($left, $right) {
            return $right['value'] <=> $left['value'];
        });
    }
}
