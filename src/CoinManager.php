<?php declare(strict_types=1);

namespace vending;

class CoinManager
{
    private $coinDrawers = ['0.05' => ['value' => 0.05, 'count' => 0],
                             '0.1' => ['value' => 0.1, 'count' => 0],
                             '0.25' => ['value' => 0.25, 'count' => 0],
                             '1' => ['value' => 1.0, 'count' => 0]];

    
    public function __construct()
    {
        $this->sort();
    }
    
    public function isValid(float $coin):bool
    {
        return array_key_exists((string)$coin, $this->coinDrawers);
    }

    /*
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function getChange(float $changeAmount):array
    {
        $change = [];
        $remaining = $changeAmount;
        foreach ($this->coinDrawers as $key => $coin) {
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
        uasort($this->coinDrawers, function ($left, $right) {
            return $right['value'] <=> $left['value'];
        });
    }
}
