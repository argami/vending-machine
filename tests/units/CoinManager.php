<?php declare(strict_types=1);

namespace tests\units\vending;

use atoum;

class CoinManager extends atoum
{
    public function testReturnTrueIfCoinIsValidDenomination()
    {
        $coinManager = $this->newTestedInstance;

        $this->boolean($coinManager->isValid(0.10))->isTrue();
        $this->boolean($coinManager->isValid(1.0))->isTrue();
        $this->boolean($coinManager->isValid(0.05))->isTrue();
        $this->boolean($coinManager->isValid(0.25))->isTrue();
    }

    public function testReturnFalseIfCoinIsInvalidDenomination()
    {
        $coinManager = $this->newTestedInstance;
        $this->boolean($coinManager->isValid(2))->isFalse();
    }

    public function testAddShouldUpdateTheCoinNumber()
    {
        $coinManager = $this->newTestedInstance;
        foreach (\vending\DEFAULT_COINS as $coin => $value) {
            $this->boolean($coinManager->add($value['value']/100))->isTrue();
            $this->array($coinManager->getCoin($value['value']/100))->integer['count']->isEqualTo(1);
        }
    }

    public function testAddThrowErrorOnInvalidCoin()
    {
        $coinManager = $this->newTestedInstance;
        $this->exception(
            function () use ($coinManager) {
                $coinManager->add(0.50);
            }
        )->hasCode(50);
    }

    public function testReturnFalseIfWeDontHaveCoinsOfDenomination()
    {
        $coin = ['0.05' => ['value' => 5, 'count' => 2]];
        $coinManager = $this->newTestedInstance($coin);
        $this->boolean($coinManager->any(1))->isFalse();
    }
    
    public function testReturnTrueIfWeHaveCoinsOfDenomination()
    {
        $coin = ['0.05' => ['value' => 5, 'count' => 2]];
        $coinManager = $this->newTestedInstance($coin);
        $this->boolean($coinManager->any(0.05))->isTrue();
    }
    
    public function testReturnNearChangeForSpecificAmount()
    {
        $coins = ['0.05' => ['value' => 5, 'count' => 2],
                  '0.1' => ['value' => 10, 'count' => 1],
                  '0.25' => ['value' => 25, 'count' => 2],
                  '1' => ['value' => 100, 'count' => 5]];

        $coinManager = $this->newTestedInstance($coins);
        $this->array($coinManager->getChange(0.05))->isEqualTo([0.05]);
        $this->array($coinManager->getChange(0.1))->isEqualTo([0.1]);
        $this->array($coinManager->getChange(5))->isEqualTo([1, 1, 1, 1, 1]);
        $this->array($coinManager->getChange(0.5))->isEqualTo([0.25, 0.25]);
        // greedyness
        $this->array($coinManager->getChange(0.08))->isEqualTo([0.05]);
    }

    public function testCoinCountShouldDropToZero()
    {
        $coin = ['0.05' => ['value' => 5, 'count' => 2]];
        $coinManager = $this->newTestedInstance($coin);
        $this->array($coinManager->getChange(0.15))->isEqualTo([0.05, 0.05]);
        $this->boolean($coinManager->any(0.05))->isFalse();
        $this->array($coinManager->getCoin(0.05))->integer['count']->isEqualTo(0);
    }

    public function testTestingChangeAndCoinStock()
    {
        $coins = ['0.05' => ['value' => 5, 'count' => 10],
            '0.1' => ['value' => 10, 'count' => 5],
            '0.25' => ['value' => 25, 'count' => 4],
            '1' => ['value' => 100, 'count' => 5]];

        $coinManager = $this->newTestedInstance($coins);
        $this->array($coinManager->getChange(0.50))->isEqualTo([0.25, 0.25]);
        $this->array($coinManager->getChange(0.35))->isEqualTo([0.25, 0.10]);
        $this->array($coinManager->getChange(3.35))->isEqualTo([1, 1, 1, 0.25, 0.10]);
        $this->array($coinManager->getChange(0.25))->isEqualTo([0.10, 0.10, 0.05]);
        $this->array($coinManager->getChange(2.35))->isEqualTo([1, 1, 0.10, 0.05, 0.05, 0.05, 0.05, 0.05]);
        # greedy b. not returning all the money
        $this->array($coinManager->getChange(1))->isEqualTo([0.05, 0.05, 0.05, 0.05]);
        $this->array($coinManager->getChange(1))->isEqualTo([]);
    }
}
