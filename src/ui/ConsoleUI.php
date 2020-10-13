<?php declare(strict_types=1);

namespace vending\ui;

use vending\ui\BaseCommand;
use vending\ui\output\ConsoleOutput;

final class ConsoleUI
{
    private $vendingMachine;
    private $consoleOutput;

    public function __construct(\vending\VendingMachine $vendingMachine)
    {
        $this->consoleOutput = new ConsoleOutput();
        $this->vendingMachine = $vendingMachine;
    }
   
    public function start()
    {
        $this->consoleOutput->writeln('');
        $this->productsHeader();
        while (true) {
            $this->consoleOutput->write($this->status());
            $line = readline();
            $commands = $this->parse($line);
            $this->processCommands(...$commands);
        }
    }

    public function prompt():string
    {
        $insertedAmount = number_format($this->vendingMachine->getInsertedAmount(), 2, '.', ',');
        return " $insertedAmount$ >";
    }

    public function productsHeader()
    {
        $productHeader = array_reduce(
            $this->vendingMachine->getProducts()->toArray(),
            function ($initial, $product) {
                return $initial .= " ".$product->hash()."(".$product->count()."): ".(string)$product->getValue();
            },
            ''
        );
        
        $this->consoleOutput->writeln(' PRODUCTS: '.$productHeader);
    }

    public function parse($line): array
    {
        $sanitized = trim(str_replace('  ', ' ', $line));
        $commands = [];
        foreach (explode(',', $sanitized) as $part) {
            $commands[] = trim(str_replace('-', ' ', $part));
        }
        return $commands;
    }

    private function processCommands(...$commands)
    {
        foreach ($commands as $fullCommand) {
            $args = explode(' ', $fullCommand);
            $command = array_shift($args);
            
            if ($command) {
                $command = ucfirst(strtolower($command));
                if (is_numeric($command)) {
                    $args = [$command];
                    $command = 'AddCoin';
                }
                $this->execute($command, ...$args);
            }
        }
    }

    private function execute($command, ...$args):string
    {
        $commandInstance = $this->initializeCommand($command);
        if ($commandInstance) {
            $result = $commandInstance->execute(...$args);
            if (!empty($result)) {
                $this->consoleOutput->writeln(' -> ' . $result . PHP_EOL);
            }
        }
        return "Error on introduced request";
    }
    
    
    private function initializeCommand(string $command)
    {
        try {
            $class = new \ReflectionClass('vending\ui\commands\\'.ucfirst($command).'Command');
            return $class->newInstanceArgs([$this->vendingMachine, $this->consoleOutput]);
        } catch (\ReflectionException $e) {
            return false;
        }
    }
}
