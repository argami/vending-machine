<?php declare(strict_types=1);

namespace vending\ui\output;

interface OutputInterface
{
    public function write(string $message);
    public function writeln(string $message);
}
