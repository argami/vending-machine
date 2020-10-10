<?php declare(strict_types=1);

namespace tests\units\vending;

use atoum;

class VendingMachine extends atoum
{
    public function testGetInsertedAmountWithoutCoinsInserted()
    {
        $vm = $this->newTestedInstance(new \vending\CoinManager());
        $this->float($vm->getInsertedAmount())->isEqualTo(0.0);
    }

    public function testInsertValidCoin()
    {
        $vm = $this->newTestedInstance(new \vending\CoinManager());
        $this->float($vm->InsertCoin(0.10))->isEqualTo(0.0);
    }

    public function testInsertInvalidCoinShouldReturnTheCoin()
    {
        $vm = $this->newTestedInstance(new \vending\CoinManager());
        $this->float($vm->InsertCoin(0.01))->isEqualTo(0.01);
        $this->float($vm->InsertCoin(0.11))->isEqualTo(0.11);
        $this->float($vm->InsertCoin(2.1))->isEqualTo(2.1);
        $this->float($this->testedInstance->getInsertedAmount())
               ->isEqualTo(0.0);
    }

    public function testInsertinValidAndInvalidCoinsShouldUpdateTheTotalInserted()
    {
        $vm = $this->newTestedInstance(new \vending\CoinManager());
        $this->float($vm->InsertCoin(0.1))->isEqualTo(0.0);
        $this->float($vm->InsertCoin(0.25))->isEqualTo(0.0);
        $this->float($vm->InsertCoin(2.1))->isEqualTo(2.1);
        $this->float($vm->InsertCoin(1))->isEqualTo(0.0);
        $this->float($vm->getInsertedAmount())
               ->isEqualTo(1.35);
    }

    public function testReturnCoinsShouldReturnTheAcceptedCoinsAndUpdateInsertedAmount()
    {
        $coins = [0.1, 0.25, 2.1, 1];
        $vm = $this->newTestedInstance(new \vending\CoinManager());

        foreach ($coins as $coin) {
            $vm->InsertCoin($coin);
        }

        $this->array($vm->returnCoins())->isEqualTo([0.1, 0.25, 1]);
        $this->float($vm->getInsertedAmount())->isEqualTo(0.0);
    }
}
