<?php declare(strict_types=1);

namespace tests\units\vending\models;

use atoum;

use vending\models\Coin;

class Coins extends atoum
{
    public function testAddingMultipleItemsWithSameKeyShouldOnlyAddFirst()
    {
        $item1 = new Coin(1);
        $item2 = new Coin(1);

        $genericCollection = $this->newTestedInstance($item1, $item2);
        $this->integer($genericCollection->count())->isEqualTo(1);
        $rItem = $genericCollection->first();
        $this->float($rItem->getValue())->isEqualTo(1);
        $this->integer($rItem->count())->isEqualTo(0);

        $item3 = new Coin(0.1);
        $genericCollection->add($item3);
        $this->boolean($genericCollection->last()->equals($item3))->isTrue();
    }

    public function testReturnNearChangeForSpecificAmount()
    {
        $coins = [new Coin(0.05, 2),
                  new Coin(0.1, 1),
                  new Coin(0.25, 2),
                  new Coin(1, 5)];

        $coins = $this->newTestedInstance(...$coins);
        $this->array($coins->getChange(0.05))->isEqualTo([0.05]);
        $this->array($coins->getChange(0.1))->isEqualTo([0.1]);
        $this->array($coins->getChange(5))->isEqualTo([1, 1, 1, 1, 1]);
        $this->array($coins->getChange(0.5))->isEqualTo([0.25, 0.25]);
        // greedyness
        $this->array($coins->getChange(0.08))->isEqualTo([0.05]);
    }

    public function testFindByValue()
    {
        $toFind = new Coin(0.25, 2);
        $coins = [new Coin(0.05, 2),
                  new Coin(0.1, 1),
                  $toFind,
                  new Coin(1, 5)];

        $coins = $this->newTestedInstance(...$coins);
        $this->variable($coins->findByValue(0.25))->isNotNull();
        $this->variable($coins->findByValue(2))->isNull();
    }
}
