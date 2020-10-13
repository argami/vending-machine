<?php declare(strict_types=1);

namespace vending\ui\commands;

use vending\VendingMachine;

interface CommandInterface
{
    public function __construct(\vending\VendingMachine $vendingMachine);
    public function execute(...$args):string;
}
