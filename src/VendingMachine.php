<?php declare(strict_types=1);

namespace vending;

const DEFAULT_PRODUCTS = ['WATER' => ['value' => 0.65, 'count' => 0],
                        'JUICE' => ['value' => 1.00, 'count' => 0],
                        'SODA' => ['value' => 1.50, 'count' => 0]];

use vending\models\Products;

class VendingMachine
{
    private $coinManager = null;
    private $insertedCoins = [];
    private $products = null;


    public function __construct(CoinManager $coinManager, array $products = null)
    {
        $this->coinManager = $coinManager;
        $this->products = $products ?? DEFAULT_PRODUCTS;
    }

    public function getInsertedAmount() : float
    {
        return array_sum($this->insertedCoins);
    }

    # if the denomination of the coin is invalid we return
    # the amount coin
    public function insertCoin(float $coin) : float
    {
        if ($this->coinManager->isValid($coin)) {
            $this->insertedCoins[] = $coin;
            return 0.0;
        }

        return $coin;
    }

    public function returnCoins() : array
    {
        $ret = $this->insertedCoins;
        $this->insertedCoins = [];
       
        return $ret;
    }

    public function sellProduct(string $productCode) : array
    {
        $product = $this->products[strtoupper($productCode)];

        if ($product['count'] == 0) {
            throw new \Exception("Product $productCode not available", 11);
        }
        $productPrice = $product['value'];
        $changeAmount = $this->getInsertedAmount() - $productPrice;
        if ($changeAmount >= 0) {
            $change = $this->coinManager->getChange($changeAmount);
            
            $this->productSold($productCode);
            $this->paymentToVault();
            
            return [$productCode, $change];
        }
        throw new \Exception("$productCode price: $productPrice. Add:".($changeAmount * -1), 10);
    }

    private function productSold(string $productCode)
    {
        $this->products[strtoupper($productCode)]['count'] -= 1;
    }
}
