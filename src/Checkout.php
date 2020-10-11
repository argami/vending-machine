<?php declare(strict_types=1);

namespace vending;

use vending\models\Products;

class Checkout
{
    private $coinManager = null;
    private $products = null;

    public function __construct(CoinManager $coinManager, Products $products)
    {
        $this->coinManager = $coinManager;
        $this->products = $products;
    }

    public function sell(string $productCode, array &$money)
    {
        $product = $this->products->find($productCode);
        if (!$product->any()) {
            throw new \Exception("Product $productCode not available", 11);
        }

        $changeAmount = array_sum($money) - $product->getValue();
        if ($changeAmount >= 0) {
            $product->remove(1);
            $this->paymentToVault($money, $changeAmount);
            
            return $productCode;
        }
        throw new \Exception("$productCode price: {$product->getValue()}. Add:".($changeAmount * -1), 10);
    }

    private function canSell($product):bool
    {
        return $product && $product->any();
    }

    private function paymentToVault(array &$insertedCoins, float $changeAmount)
    {
        $this->coinManager->add(...$insertedCoins);
        $insertedCoins = $this->coinManager->getChange($changeAmount);
    }
}
