<?php declare(strict_types=1);

namespace tests\units\vending;

use atoum;

class VendingMachine extends atoum
{
    public function testGetInsertedAmountWithoutCoinsInserted()
    {
        $vendingMachine = $this->newTestedInstance(new \vending\CoinManager());
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(0.0);
    }

    public function testInsertValidCoin()
    {
        $vendingMachine = $this->newTestedInstance(new \vending\CoinManager());
        $this->float($vendingMachine->insertCoin(0.10))->isEqualTo(0.0);
    }

    public function testInsertInvalidCoinShouldReturnTheCoin()
    {
        $vendingMachine = $this->newTestedInstance(new \vending\CoinManager());
        $this->float($vendingMachine->insertCoin(0.01))->isEqualTo(0.01);
        $this->float($vendingMachine->insertCoin(0.11))->isEqualTo(0.11);
        $this->float($vendingMachine->insertCoin(2.1))->isEqualTo(2.1);
        $this->float($this->testedInstance->getInsertedAmount())
               ->isEqualTo(0.0);
    }

    public function testInsertinValidAndInvalidCoinsShouldUpdateTheTotalInserted()
    {
        $vendingMachine = $this->newTestedInstance(new \vending\CoinManager());
        $this->float($vendingMachine->insertCoin(0.1))->isEqualTo(0.0);
        $this->float($vendingMachine->insertCoin(0.25))->isEqualTo(0.0);
        $this->float($vendingMachine->insertCoin(2.1))->isEqualTo(2.1);
        $this->float($vendingMachine->insertCoin(1))->isEqualTo(0.0);
        $this->float($vendingMachine->getInsertedAmount())
               ->isEqualTo(1.35);
    }

    public function testReturnCoinsShouldReturnTheAcceptedCoinsAndUpdateInsertedAmount()
    {
        $coins = [0.1, 0.25, 2.1, 1];
        $vendingMachine = $this->newTestedInstance(new \vending\CoinManager());

        foreach ($coins as $coin) {
            $vendingMachine->insertCoin($coin);
        }

        $this->array($vendingMachine->returnCoins())->isEqualTo([0.1, 0.25, 1]);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(0.0);
    }

    public function testSellProductWithExactMoneyShouldReturnProductAndNoChange()
    {
        $vendingMachine = $this->newTestedInstance(
            new \vending\CoinManager(),
            ['JUICE' => ['value' => 1.00, 'count' => 1]]
        );
        $vendingMachine->insertCoin(1);

        $this->array($vendingMachine->sellProduct('JUICE'))->isEqualTo(['JUICE', []]);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(0.0);
    }

    public function testSellProductReturnProductAndChange()
    {
        $coins = ['0.05' => ['value' => 5, 'count' => 2],
            '0.1' => ['value' => 10, 'count' => 1],
            '0.25' => ['value' => 25, 'count' => 2],
            '1' => ['value' => 100, 'count' => 0]];

        $coinManager = new \vending\CoinManager($coins);
        $vendingMachine = $this->newTestedInstance($coinManager, ['SODA' => ['value' => 1.50, 'count' => 1]]);
        $vendingMachine->insertCoin(1.0);
        $vendingMachine->insertCoin(1.0);

        $this->array($vendingMachine->sellProduct('SODA'))->isEqualTo(['SODA', [0.25, 0.25]]);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(0.0);
        $this->array($coinManager->getCoin(1))->integer['count']->isEqualTo(2);
    }

    public function testSellProductReturnProductAndNoChange()
    {
        $vendingMachine = $this->newTestedInstance(new \vending\CoinManager(), ['SODA' => ['value' => 1.50, 'count' => 1]]);
        $vendingMachine->insertCoin(1);
        $vendingMachine->insertCoin(1);

        $this->array($vendingMachine->sellProduct('SODA'))->isEqualTo(['SODA', []]);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(0.0);
    }


    public function testFailSellingIfProductNotAvailable()
    {
        $vendingMachine = $this->newTestedInstance(new \vending\CoinManager());
        $vendingMachine->insertCoin(1);
        $this->exception(
            function () use ($vendingMachine) {
                $vendingMachine->sellProduct('SODA');
            }
        )->hasCode(11);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(1.0);
    }


    public function testFailSellingProductEnoughMoneyInserted()
    {
        $vendingMachine = $this->newTestedInstance(new \vending\CoinManager(), ['SODA' => ['value' => 1.50, 'count' => 1]]);
        $vendingMachine->insertCoin(0.25);
        $this->exception(
            function () use ($vendingMachine) {
                $vendingMachine->sellProduct('SODA');
            }
        )->hasCode(10);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(0.25);
    }
}
