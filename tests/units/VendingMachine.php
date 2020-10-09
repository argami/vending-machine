<?php declare(strict_types=1);

namespace tests\units\vending;

require_once __DIR__ . '/../../src/VendingMachine.php';

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
}
