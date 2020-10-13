<?php declare(strict_types=1);

namespace vending\ui\commands;

use vending\ui\service\ServiceConsole;

class ServiceCommand extends BaseCommand
{
    public function execute(...$args):string
    {
        $console = new ServiceConsole($this->vendingMachine);
        $console->start();

        return '';
    }
}
