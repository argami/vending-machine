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


    public function testReturnNearChangeForSpecificAmount()
    {
        $coinManager = $this->newTestedInstance;
        $this->array($coinManager->getChange(0.05))->isEqualTo([0.05]);
        $this->array($coinManager->getChange(0.1))->isEqualTo([0.1]);
        $this->array($coinManager->getChange(5))->isEqualTo([1, 1, 1, 1, 1]);
        $this->array($coinManager->getChange(0.5))->isEqualTo([0.25, 0.25]);
        // greedyness
        $this->array($coinManager->getChange(0.08))->isEqualTo([0.05]);
    }
}
