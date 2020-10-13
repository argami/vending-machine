<?php declare(strict_types=1);

namespace vending\ui;

use vending\ui\BaseCommand;
use vending\ui\output\ConsoleOutput;

class BaseShell
{
    protected $vendingMachine;
    protected $consoleOutput;
    protected $running = true;

    public function __construct(\vending\VendingMachine $vendingMachine)
    {
        $this->consoleOutput = new ConsoleOutput();
        $this->vendingMachine = $vendingMachine;
    }
   
    public function start()
    {
        $this->consoleOutput->writeln('');
        $this->consoleOutput->writeln($this->header());

        while ($this->running) {
            // $this->consoleOutput->write();
            $line = readline($this->prompt());
            $commands = $this->parse($line);
            $this->processCommands(...$commands);
        }
    }

    public function prompt():string
    {
        return ">";
    }

    protected function parse($line): array
    {
        $sanitized = trim(str_replace('  ', ' ', $line));
        $commands = [];
        foreach (explode(',', $sanitized) as $part) {
            $commands[] = trim(str_replace('-', ' ', $part));
        }
        return $commands;
    }

    protected function processCommands(...$commands)
    {
        foreach ($commands as $fullCommand) {
            $args = explode(' ', $fullCommand);
            $command = array_shift($args);
            
            if (strtoupper($command) == 'EXIT') {
                $this->running = false;
                return;
            }

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

    protected function execute($command, ...$args)
    {
        $commandInstance = $this->initializeCommand($command);
        if ($commandInstance) {
            $result = $commandInstance->execute(...$args);
            if (!empty($result)) {
                $this->consoleOutput->writeln(' -> ' . $result . PHP_EOL);
            }
        }
    }
    
    
    protected function initializeCommand(string $command)
    {
        try {
            $class = new \ReflectionClass("vending\\ui\\commands\\{$command}Command");
            return $class->newInstanceArgs([$this->vendingMachine, $this->consoleOutput]);
        } catch (\ReflectionException $e) {
            return false;
        }
    }
}
