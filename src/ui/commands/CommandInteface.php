<?php declare(strict_types=1);

namespace vending\ui\commands;

use vending\VendingMachine;
use vending\ui\output\OutputInterface;

interface CommandInterface
{
    public function __construct(VendingMachine $vendingMachine, OutputInterface $consoleOutput);
    public function execute(...$args):string;
}
