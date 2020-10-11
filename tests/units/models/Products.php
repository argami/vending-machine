<?php declare(strict_types=1);

namespace tests\units\vending\models;

use atoum;
use vending\models\Product;

class Products extends atoum
{
    public function testAddingMultipleItemsWithSameKeyShouldOnlyAddFirst()
    {
        $item1 = new Product('PrOdUcT', 1.1);
        $item2 = new Product('pRoDuCt', 1.1);

        $genericCollection = $this->newTestedInstance($item1, $item2);
        $this->integer($genericCollection->count())->isEqualTo(1);
        $rItem = $genericCollection->first();
        $this->float($rItem->getValue())->isEqualTo(1.1);
        $this->integer($rItem->count())->isEqualTo(0);
    }
}
