<?php declare(strict_types=1);

namespace vending\ui\commands;

class ReturnCommand extends BaseCommand
{
    public function execute(...$args):string
    {
        if (count($args) > 0 &&strtoupper($args[0]) == 'COIN') {
            return "RETURN: ". implode(', ', $this->vendingMachine->returnCoins());
        }
        return 'Can only return coins';
    }
}
