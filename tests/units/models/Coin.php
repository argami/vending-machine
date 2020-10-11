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
}
