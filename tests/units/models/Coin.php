<?php declare(strict_types=1);

namespace tests\units\vending\models;

use atoum;

class Coin extends atoum
{
    public function testConstructorAndUnique()
    {
        $count = rand(20, 100);
        $add = rand($count, 100);
        $remove = rand(0, $add);

        $item = $this->newTestedInstance(0.1, $count);
        $this->integer($item->centsValue())->isEqualTo(10);

        $this->string($item->hash())->isEqualTo('10');
        $this->float($item->getValue())->isEqualTo(0.1);
      
        $item->add($add);
        $this->integer($item->count())->isEqualTo($count + $add);
        $item->remove($remove);
        $this->integer($item->count())->isEqualTo((($count + $add) - $remove));

        $this->boolean($item->equals($this->newTestedInstance(0.1)))->isTrue();
        $this->boolean($item->equals($this->newTestedInstance(1)))->isFalse();
    }

    public function testReturnNearChangeForSpecificAmount()
    {
        $coins = [$this->newTestedInstance(0.05, 5),
                  $this->newTestedInstance(0.1, 10),
                  $this->newTestedInstance(0.25, 10),
                  $this->newTestedInstance(1, 4)];

        $this->array($coins[0]->getChange(0.20))->isEqualTo([0, [0.05, 0.05, 0.05, 0.05]]);
        $this->array($coins[0]->getChange(0.08))->isEqualTo([0.03, [0.05]]);
        $this->array($coins[1]->getChange(0.4))->isEqualTo([0, [0.1, 0.1, 0.1, 0.1]]);
        $this->array($coins[2]->getChange(0.5))->isEqualTo([0, [0.25, 0.25]]);
        $this->array($coins[3]->getChange(5))->isEqualTo([1, [1, 1, 1, 1]]);
    }
}
