<?php declare(strict_types=1);

namespace vending;

class CoinManager
{
    private $coin_drawers = ['0.05' => 0, '0.1' => 0, '0.25' => 0, '1' => 0];

    public function isValid(float $coin):bool
    {
        return array_key_exists((string)$coin, $this->coin_drawers);
    }
}
