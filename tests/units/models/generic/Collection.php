<?php declare(strict_types=1);

namespace tests\units\vending\models\generic;

use atoum;
use vending\models\generic\GenericItem;

class GenericCollection extends atoum
{
    public function testAddingMultipleItemsWithSameKeyShouldOnlyAddFirst()
    {
        $item1 = new GenericItem(1, 0, '1');
        $item2 = new GenericItem(1, 1, '2');

        $genericCollection = $this->newTestedInstance($item1, $item2);
        $this->integer($genericCollection->count())->isEqualTo(1);
        $rItem = $genericCollection->first();
        $this->string($rItem->getValue())->isEqualTo('1');
        $this->integer($rItem->count())->isEqualTo(0);

        $item3 = new GenericItem(2, 1, '2');
        $genericCollection->add($item3);
        $this->boolean($genericCollection->last()->equals($item3))->isTrue();
    }
}
