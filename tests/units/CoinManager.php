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


    public function testReturnFalseIfWeDontHaveCoinsOfDenomination()
    {
        $coinManager = $this->newTestedInstance;
        $this->boolean($coinManager->any(1))->isFalse();
    }

    public function testReturnNearChangeForSpecificAmount()
    {
        $coins = ['0.05' => ['value' => 0.05, 'count' => 2],
                  '0.1' => ['value' => 0.1, 'count' => 1],
                  '0.25' => ['value' => 0.25, 'count' => 2],
                  '1' => ['value' => 1.0, 'count' => 5]];

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
        $coin = ['0.05' => ['value' => 0.05, 'count' => 2]];
        $coinManager = $this->newTestedInstance($coin);
        $this->array($coinManager->getChange(0.15))->isEqualTo([0.05, 0.05]);
        $this->boolean($coinManager->any(0.05))->isFalse();
        $this->array($coinManager->getCoin(0.05))->integer['count']->isEqualTo(0);
    }
}
