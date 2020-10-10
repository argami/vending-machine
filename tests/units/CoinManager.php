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
}
