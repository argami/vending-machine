<?php declare(strict_types=1);

namespace vending\ui\commands;

class AddCoinCommand extends BaseCommand
{
    public function execute(...$args):string
    {
        if (count($args) > 0 && is_numeric($args[0])) {
            $fvalue = $this->vendingMachine->insertCoin((float)$args[0]);
            if ($fvalue != 0) {
                return 'Invalid Coin to add!  RETURN: '.$fvalue;
            }
        }
        #we should throw error
        return "";
    }
}
