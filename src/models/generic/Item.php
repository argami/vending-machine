<?php declare(strict_types=1);

namespace vending\models\generic;

class GenericItem implements \Ds\Hashable
{
    private $key;
    private $count;
    private $value;

    public function __construct($key, $count = 0, $value = null)
    {
        $this->key = $key;
        $this->count = $count;
        $this->value = $value;
    }

    public function hash()
    {
        return $this->key;
    }

    public function equals($obj): bool
    {
        return $this->key === $obj->key;
    }

    public function add(int $items):int
    {
        $this->count += $items;

        return $items;
    }

    public function remove(int $items):int
    {
        $this->count -= $items;
        
        return $items;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function count():int
    {
        return $this->count;
    }

    public function any(): bool
    {
        return $this->count() > 0;
    }

    public function updateCount(int $count)
    {
        $this->count = $count;
    }
}
