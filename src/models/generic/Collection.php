<?php declare(strict_types=1);

namespace vending\models\generic;

class GenericCollection implements \IteratorAggregate
{
    protected \Ds\Set $items;
    
    public function __construct(\Ds\Hashable ...$items)
    {
        $this->items = new \Ds\Set($items);
        $this->internalSort();
    }

    public function add(\Ds\Hashable ...$values) : void
    {
        $this->items->add(...$values);
        $this->internalSort();
    }
    
    public function count() : int
    {
        return $this->items->count();
    }

    public function first() : \Ds\Hashable
    {
        return $this->items->first();
    }

    public function last() : \Ds\Hashable
    {
        return $this->items->last();
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->items->toArray());
    }

    private function internalSort()
    {
        $this->items->sort(function ($a, $b) {
            return $b->getValue() <=> $a->getValue();
        });
    }
}
