<?php declare(strict_types=1);

namespace vending\ui\service;

use vending\ui\BaseCommand;
use vending\ui\output\ConsoleOutput;
use vending\ui\BaseShell;

final class ServiceConsole extends BaseShell
{
    public function prompt():string
    {
        return " SERVICE>";
    }

    public function header()
    {
        return '';
    }

    protected function initializeCommand(string $command)
    {
        try {
            $class = new \ReflectionClass("vending\\ui\\service\\commands\\{$command}Command");
            return $class->newInstanceArgs([$this->vendingMachine, $this->consoleOutput]);
        } catch (\ReflectionException $e) {
            return false;
        }
    }
}
