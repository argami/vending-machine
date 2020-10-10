<?php declare(strict_types=1);

namespace tests\units\vending;

use atoum;

class VendingMachine extends atoum
{
    public function testGetInsertedAmountWithoutCoinsInserted()
    {
        $this
            ->given($this->newTestedInstance)
            ->then
                ->float($this->testedInstance->getInsertedAmount())
                ->isEqualTo(0.0);
    }

    public function testInsertValidCoin()
    {
        $vm = $this->newTestedInstance;
        $this->float($vm->InsertCoin(0.10))->isEqualTo(0.0);
    }

    public function testInsertInvalidCoin()
    {
        $vm = $this->newTestedInstance;
        $this->float($vm->InsertCoin(0.01))->isEqualTo(0.01);
        $this->float($vm->InsertCoin(0.11))->isEqualTo(0.11);
        $this->float($vm->InsertCoin(2.1))->isEqualTo(2.1);
    }
}
