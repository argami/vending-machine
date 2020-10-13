<?php declare(strict_types=1);

namespace vending\ui\service\commands;

use vending\ui\commands\BaseCommand;

class InfoCommand extends BaseCommand
{
    public function execute(...$args):string
    {
        $this->getProductsInfo();
        $this->getCoinsInfo();
        return "";
    }

    public function getProductsInfo()
    {
        $productHeader = array_reduce(
            $this->vendingMachine->getProducts()->toArray(),
            function ($initial, $product) {
                return $initial .= str_pad(" ".$product->hash().": ".$product->count()."\t", 15, ' ', STR_PAD_LEFT);
            },
            ''
        );
        
        $this->consoleOutput->writeln(" PRODUCTS: $productHeader");
    }

    public function getCoinsInfo()
    {
        $coinsHeader = array_reduce(
            $this->vendingMachine->getCoinManager()->getCoins()->toArray(),
            function ($initial, $coin) {
                return $initial .= str_pad(" ".(string)$coin->getValue().": ".$coin->count()."\t", 15, ' ', STR_PAD_LEFT);
            },
            ''
        );
        
        $this->consoleOutput->writeln("    COINS: $coinsHeader");
    }
}
