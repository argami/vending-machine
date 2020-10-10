<?php declare(strict_types=1);

namespace vending;

class VendingMachine
{
    private $coin_manager = null;
    private $inserted_coins = [];


    public function __construct(CoinManager $coin_manager)
    {
        $this->coin_manager = $coin_manager;
    }

    public function getInsertedAmount() : float
    {
        return array_sum($this->inserted_coins);
    }

    # if the denomination of the coin is invalid we return
    # the amount coin
    public function InsertCoin(float $coin) : float
    {
        if ($this->coin_manager->isValid($coin)) {
            $this->inserted_coins[] = $coin;
            return 0.0;
        }

        return $coin;
    }

    public function returnCoins() : array
    {
        $ret = $this->inserted_coins;
        $this->inserted_coins = [];
       
        return $ret;
    }
}
