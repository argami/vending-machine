<?php declare(strict_types=1);

namespace vending\ui\output;

class ConsoleOutput implements OutputInterface
{
    public function write(string $message)
    {
        print($message);
    }

    public function writeln(string $message)
    {
        $this->write($message . PHP_EOL);
    }
}
