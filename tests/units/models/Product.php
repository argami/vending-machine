<?php declare(strict_types=1);

namespace tests\units\vending\models;

use atoum;

class Product extends atoum
{
    public function testConstructorAndUnique()
    {
        $key = 'PrOdUcT';
        $item = $this->newTestedInstance($key, 1.1);
        $this->string($item->hash())->isEqualTo(strtoupper($key));

        $this->boolean($item->equals($this->newTestedInstance($key, 1.1)))->isTrue();
        $this->boolean($item->equals($this->newTestedInstance($key.'x', 1.1)))->isFalse();
    }
}
