<?php declare(strict_types=1);

namespace vending\ui\commands;

use vending\VendingMachine;
use vending\ui\output\OutputInterface;

class BaseCommand implements CommandInterface
{
    protected $vendingMachine;
    protected $consoleOutput;
    
    public function __construct(VendingMachine $vendingMachine, OutputInterface $consoleOutput)
    {
        $this->vendingMachine = $vendingMachine;
        $this->consoleOutput = $consoleOutput;
    }

    public function execute(...$args):string
    {
    }
}
