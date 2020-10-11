<?php declare(strict_types=1);

namespace tests\units\vending\models\generic;

use atoum;

class GenericItem extends atoum
{
    public function testGenericItemSimpleInteface()
    {
        $count = rand(20, 100);
        $add = rand($count, 100);
        $remove = rand(0, $add);

        $item = $this->newTestedInstance('test', $count, 'value');
        $this->string($item->hash())->isEqualTo('test');
        $this->string($item->getValue())->isEqualTo('value');
      
        $item->add($add);
        $this->integer($item->count())->isEqualTo($count + $add);
        $item->remove($remove);
        $this->integer($item->count())->isEqualTo((($count + $add) - $remove));

        $this->boolean($item->equals($this->newTestedInstance('test')))->isTrue();
        $this->boolean($item->equals($this->newTestedInstance('test2')))->isFalse();
    }
}
