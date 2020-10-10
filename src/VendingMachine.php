<?php declare(strict_types=1);

namespace vending;

class VendingMachine
{
    private $coinManager = null;
    private $insertedCoins = [];


    public function __construct(CoinManager $coinManager)
    {
        $this->coinManager = $coinManager;
    }

    public function getInsertedAmount() : float
    {
        return array_sum($this->insertedCoins);
    }

    # if the denomination of the coin is invalid we return
    # the amount coin
    public function insertCoin(float $coin) : float
    {
        if ($this->coinManager->isValid($coin)) {
            $this->insertedCoins[] = $coin;
            return 0.0;
        }

        return $coin;
    }

    public function returnCoins() : array
    {
        $ret = $this->insertedCoins;
        $this->insertedCoins = [];
       
        return $ret;
    }
}
