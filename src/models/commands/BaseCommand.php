<?php declare(strict_types=1);

namespace vending\ui;

use vending\VendingMachine;
use vending\ui\CommandInterface;

class BaseCommand implements CommandInterface
{
    protected $vendingMachine;
    
    public function __construct(\vending\VendingMachine $vendingMachine)
    {
        $this->vendingMachine = $vendingMachine;
    }

    public function execute(...$args):string
    {
    }
}
