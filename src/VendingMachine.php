<?php declare(strict_types=1);

namespace vending;

const DEFAULT_PRODUCTS = ['WATER' => ['value' => 0.65, 'count' => 0],
                        'JUICE' => ['value' => 1.00, 'count' => 0],
                        'SODA' => ['value' => 1.50, 'count' => 0]];

use vending\models\Products;
use vending\Checkout;

class VendingMachine
{
    private $coinManager = null;
    private $insertedCoins = [];
    private $products = null;
    private $checkout;


    public function __construct(CoinManager $coinManager, Products $products)
    {
        $this->coinManager = $coinManager;
        $this->products = $products;
        $this->checkout = new Checkout($coinManager, $products);
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
        $product = $this->checkout->sell($productCode, $this->insertedCoins);
        
        # returning the change
        
        return [$product,  $this->returnCoins()];
    }
}
