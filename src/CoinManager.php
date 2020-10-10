<?php declare(strict_types=1);

namespace vending;

class CoinManager
{
    private $coin_drawers = ['0.05' => ['value' => 0.05, 'count' => 0],
                             '0.1' => ['value' => 0.1, 'count' => 0],
                             '0.25' => ['value' => 0.25, 'count' => 0],
                             '1' => ['value' => 1.0, 'count' => 0]];

    
    public function __construct()
    {
        $this->sort();
    }
    
    public function isValid(float $coin):bool
    {
        return array_key_exists((string)$coin, $this->coin_drawers);
    }

    public function getChange(float $changeAmount):array
    {
        $change = [];
        $remaining = $changeAmount;
        foreach ($this->coin_drawers as $key => $coin) {
            if ($remaining >= $coin['value']) {
                $ncoins = (int)($remaining / $coin['value']);
                $remaining -= ($ncoins * $coin['value']);
                array_push($change, ...array_fill(0, $ncoins, $coin['value']));
            }
        }
        
        return $change;
    }

    private function sort()
    {
        uasort($this->coin_drawers, function ($a, $b) {
            return $b['value'] <=> $a['value'];
        });
    }
}
