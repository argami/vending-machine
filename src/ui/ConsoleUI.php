<?php declare(strict_types=1);

namespace vending\ui;

use vending\ui\BaseCommand;
use vending\ui\output\ConsoleOutput;

final class ConsoleUI extends BaseShell
{
    public function prompt():string
    {
        $insertedAmount = number_format($this->vendingMachine->getInsertedAmount(), 2, '.', ',');
        return " $insertedAmount$ >";
    }

    public function header()
    {
        $productHeader = array_reduce(
            $this->vendingMachine->getProducts()->toArray(),
            function ($initial, $product) {
                return $initial .= " ".$product->hash()."(".$product->count()."): ".(string)$product->getValue();
            },
            ''
        );
        
        return ' PRODUCTS: '.$productHeader;
    }
}
