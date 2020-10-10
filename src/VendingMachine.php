<?php declare(strict_types=1);

namespace vending;

class VendingMachine
{
    private $valid_coin_denominations = [0.05, 0.10, 0.25, 1];
    private $inserted_coins = [];
    
    public function getInsertedAmount() : float
    {
        return array_sum($this->inserted_coins);
    }

    # if the denomination of the coin is invalid we return
    # the amount coin
    public function InsertCoin(float $coin) : float
    {
        if (in_array($coin, $this->valid_coin_denominations)) {
            $this->inserted_coins[] = $coin;
            return 0.0;
        }

        return $coin;
    }
}
