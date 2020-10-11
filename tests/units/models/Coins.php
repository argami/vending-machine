<?php declare(strict_types=1);

namespace tests\units\vending\models;

use atoum;

use vending\models\Coin;

class Coins extends atoum
{
    public function testAddingMultipleItemsWithSameKeyShouldOnlyAddFirst()
    {
        $item1 = new Coin(0.1);
        $item2 = new Coin(0.1);

        $genericCollection = $this->newTestedInstance($item1, $item2);
        $this->integer($genericCollection->count())->isEqualTo(1);
        $rItem = $genericCollection->first();
        $this->float($rItem->getValue())->isEqualTo(0.1);
        $this->integer($rItem->count())->isEqualTo(0);

        $item3 = new Coin(1);
        $genericCollection->add($item3);
        $this->boolean($genericCollection->last()->equals($item3))->isTrue();
    }
}
