<?php declare(strict_types=1);

namespace tests\units\vending;

use atoum;

class CoinManager extends atoum
{
    public function testReturnTrueIfCoinIsValidDenomination()
    {
        $vm = $this->newTestedInstance;

        $this->boolean($vm->isValid(0.10))->isTrue();
        $this->boolean($vm->isValid(1.0))->isTrue();
        $this->boolean($vm->isValid(0.05))->isTrue();
        $this->boolean($vm->isValid(0.25))->isTrue();
    }

    public function testReturnFalseIfCoinIsInvalidDenomination()
    {
        $vm = $this->newTestedInstance;
        $this->boolean($vm->isValid(2))->isFalse();
    }
}
