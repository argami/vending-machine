<?php declare(strict_types=1);

namespace tests\units\vending;

use atoum;
use vending\CoinManager;
use vending\models\Coin;
use vending\models\Coins;
use vending\models\Product;
use vending\models\Products;

class Checkout extends atoum
{
    private $coinManager;
    private $products;
    
    public function beforeTestMethod($method)
    {
        $coins = new Coins(...[new Coin(0.05, 10),
                                new Coin(0.1, 10),
                                new Coin(0.25, 10),
                                new Coin(1, 5)]);
                                
        $this->coinManager = new \vending\CoinManager($coins);

        $items = [new Product('WATER', 0.65, 10),
                new Product('JUICE', 1.00, 10),
                new Product('SODA', 1.50, 10)];
        
        $this->products = new Products(...$items);
    }
     
    public function testConstructor()
    {
        $checkout = $this->newTestedInstance($this->coinManager, $this->products);

        $this->object($checkout)->isInstanceOf('vending\Checkout');
    }

    public function testSellProductWithExactMoneyShouldReturnProductAndNoChange()
    {
        $checkout = $this->newTestedInstance($this->coinManager, $this->products);
        $money = [1];
        $this->string($checkout->sell('JUICE', $money))->isEqualTo('JUICE');
        $this->array($money)->isEqualTo([]);
    }

    public function testSellProductReturnProductAndChange()
    {
        $coins = new Coins(...[new Coin(0.05, 2),
                                new Coin(0.1, 1),
                                new Coin(0.25, 2),
                                new Coin(1, 0)]);
        $coinManager = new \vending\CoinManager($coins);

        $checkout = $this->newTestedInstance($this->coinManager, $this->products);

        $products = new Products(new Product('SODA', 1.50, 1));

        $insertedMoney = [1.0, 1.0];

        $this->string($checkout->sell('SODA', $insertedMoney))->isEqualTo('SODA');
        $this->array($insertedMoney)->isEqualTo([0.25, 0.25]);
    }

    public function testSellProductReturnProductAndNoChange()
    {
        $coins = new Coins(...[new Coin(0.05, 0),
                                new Coin(0.1, 0),
                                new Coin(0.25, 0),
                                new Coin(1, 0)]);
        $coinManager = new \vending\CoinManager($coins);

        $products = new Products(new Product('SODA', 1.50, 1));
        
        $checkout = $this->newTestedInstance($coinManager, $products);
        $insertedMoney = [1.0, 1.0];

        $this->string($checkout->sell('SODA', $insertedMoney))->isEqualTo('SODA');
        $this->array($insertedMoney)->isEqualTo([]);
    }


    public function testFailSellingIfProductNotAvailable()
    {
        $coins = new Coins(...[new Coin(0.05, 0),
                                new Coin(0.1, 0),
                                new Coin(0.25, 0),
                                new Coin(1, 0)]);
        $coinManager = new \vending\CoinManager($coins);

        $products = new Products(new Product('SODA', 1.50, 0));
        
        $checkout = $this->newTestedInstance($coinManager, $products);
        
        $insertedMoney = [1.0];
        
        
        $this->exception(fn () => $checkout->sell('SODA', $insertedMoney))->hasCode(11);
        $this->array($insertedMoney)->isEqualTo([1.0]);
    }


    public function testFailSellingProductEnoughMoneyInserted()
    {
        $coins = new Coins(...[new Coin(0.05, 0),
                                new Coin(0.1, 0),
                                new Coin(0.25, 0),
                                new Coin(1, 0)]);
        $coinManager = new \vending\CoinManager($coins);

        $products = new Products(new Product('SODA', 1.50, 1));
        
        $checkout = $this->newTestedInstance($coinManager, $products);
        
        $insertedMoney = [];
        
        
        $this->exception(fn () => $checkout->sell('SODA', $insertedMoney))->hasCode(10);
        $this->array($insertedMoney)->isEqualTo([]);
    }
}
