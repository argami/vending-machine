<?php declare(strict_types=1);

namespace vending\ui\service\commands;

use vending\ui\commands\BaseCommand;

class UpdateCommand extends BaseCommand
{
    public function execute(...$args):string
    {
        if (count($args) < 3 || in_array(strtoupper($args[1]), ['COIN', 'PRODUCT'])) {
            return 'USE: Update [product|coin] amount';
        }

        switch (strtoupper($args[0])) {
            case 'COIN':
                $this->updateCoin($args[1], (int)$args[2]);
                break;
            
            case 'PRODUCT':
                $this->updateProduct($args[1], (int)$args[2]);
                break;
        }

        return "";
    }

    private function updateCoin($coin, int $amount)
    {
        $coinManager = $this->vendingMachine->getCoinManager();
        $coin = $coinManager->getCoin((float)$coin);
        if ($coin) {
            $coin->updateCount($amount);
        }
    }

    private function updateProduct($product, int $amount)
    {
        $product = $this->vendingMachine->getProducts()->find($product);

        if ($product) {
            $product->updateCount($amount);
        }
    }
}
