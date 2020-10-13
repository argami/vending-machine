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
                return $initial .= " ".$product->hash()."(".$product->count()."): ".(string)$product->getValue()."\t";
            },
            ''
        );
        
        $this->consoleOutput->writeln(' PRODUCTS: '.$productHeader);
    }

    public function getCoinsInfo()
    {
        $coinsHeader = array_reduce(
            $this->vendingMachine->getCoinManager()->getCoins()->toArray(),
            function ($initial, $coin) {
                return $initial .= " ".(string)$coin->getValue()."(".$coin->count().")\t";
            },
            ''
        );
        
        $this->consoleOutput->writeln(' COINS: '.$coinsHeader);
    }
}
