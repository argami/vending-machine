<?php declare(strict_types=1);

namespace tests\units\vending;

use atoum;
use vending\Checkout;
use vending\CoinManager;
use vending\models\Coin;
use vending\models\Coins;
use vending\models\Product;
use vending\models\Products;

/**
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class VendingMachine extends atoum
{
    private $coinManager;
    private $products;

    public function beforeTestMethod($method)
    {
        $coins = new Coins(...[new Coin(0.05, 2),
                                new Coin(0.1, 1),
                                new Coin(0.25, 2),
                                new Coin(1, 5)]);
        $this->coinManager = new \vending\CoinManager($coins);
        $this->products = new Products(new Product('JUICE', 1.0, 10));
    }

    public function testGetInsertedAmountWithoutCoinsInserted()
    {
        $vendingMachine = $this->newTestedInstance($this->coinManager, $this->products);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(0.0);
    }

    public function testInsertValidCoin()
    {
        $vendingMachine = $this->newTestedInstance($this->coinManager, $this->products);
        $this->float($vendingMachine->insertCoin(0.10))->isEqualTo(0.0);
    }

    public function testInsertInvalidCoinShouldReturnTheCoin()
    {
        $vendingMachine = $this->newTestedInstance($this->coinManager, $this->products);
        $this->float($vendingMachine->insertCoin(0.01))->isEqualTo(0.01);
        $this->float($vendingMachine->insertCoin(0.11))->isEqualTo(0.11);
        $this->float($vendingMachine->insertCoin(2.1))->isEqualTo(2.1);
        $this->float($this->testedInstance->getInsertedAmount())
               ->isEqualTo(0.0);
    }

    public function testInsertinValidAndInvalidCoinsShouldUpdateTheTotalInserted()
    {
        $vendingMachine = $this->newTestedInstance($this->coinManager, $this->products);
        $this->float($vendingMachine->insertCoin(0.1))->isEqualTo(0.0);
        $this->float($vendingMachine->insertCoin(0.25))->isEqualTo(0.0);
        $this->float($vendingMachine->insertCoin(2.1))->isEqualTo(2.1);
        $this->float($vendingMachine->insertCoin(1))->isEqualTo(0.0);
        $this->float($vendingMachine->getInsertedAmount())
               ->isEqualTo(1.35);
    }

    public function testReturnCoinsShouldReturnTheAcceptedCoinsAndUpdateInsertedAmount()
    {
        $coins = [0.1, 0.25, 2.1, 1];
        $vendingMachine = $this->newTestedInstance($this->coinManager, $this->products);

        foreach ($coins as $coin) {
            $vendingMachine->insertCoin($coin);
        }

        $this->array($vendingMachine->returnCoins())->isEqualTo([0.1, 0.25, 1]);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(0.0);
    }

    public function testSellProductWithExactMoneyShouldReturnProductAndNoChange()
    {
        $coins = new Coins(...[new Coin(0.05, 10),
                           new Coin(0.1, 10),
                           new Coin(0.25, 10),
                           new Coin(1, 5)]);
                                
        $coinManager = new \vending\CoinManager($coins);
        $products = new Products(new Product('JUICE', 1.0, 10));

        
        $vendingMachine = $this->newTestedInstance($coinManager, $products);
        $vendingMachine->insertCoin(1);

        $this->array($vendingMachine->sellProduct('JUICE'))->isEqualTo(['JUICE', []]);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(0.0);
    }

    public function testSellProductReturnProductAndChange()
    {
        $coins = new Coins(...[new Coin(0.05, 2),
                                new Coin(0.1, 1),
                                new Coin(0.25, 2),
                                new Coin(1, 0)]);
        $coinManager = new \vending\CoinManager($coins);
        $products = new Products(new Product('SODA', 1.5, 1));

        $vendingMachine = $this->newTestedInstance($coinManager, $products);
        $vendingMachine->insertCoin(1.0);
        $vendingMachine->insertCoin(1.0);

        $this->array($vendingMachine->sellProduct('SODA'))->isEqualTo(['SODA', [0.25, 0.25]]);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(0.0);
        $this->integer($coinManager->getCoin(1)->count())->isEqualTo(2);
    }

    public function testSellProductReturnProductAndNoChange()
    {
        $coins = new Coins(...[new Coin(0.05, 0),
                                new Coin(0.1, 0),
                                new Coin(0.25, 0),
                                new Coin(1, 0)]);
        $coinManager = new \vending\CoinManager($coins);
        $products = new Products(new Product('SODA', 1.5, 1));


        $vendingMachine = $this->newTestedInstance($coinManager, $products);
        $vendingMachine->insertCoin(1);
        $vendingMachine->insertCoin(1);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(2.0);

        $this->array($vendingMachine->sellProduct('SODA'))->isEqualTo(['SODA', []]);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(0.0);
    }


    public function testFailSellingIfProductNotAvailable()
    {
        $products = new Products(new Product('SODA', 1.5, 0));

        $vendingMachine = $this->newTestedInstance($this->coinManager, $products);
        $vendingMachine->insertCoin(1);
        $this->exception(fn () => $vendingMachine->sellProduct('SODA'))->hasCode(11);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(1.0);
    }


    public function testFailSellingProductEnoughMoneyInserted()
    {
        $products = new Products(new Product('SODA', 1.5, 1));

        $vendingMachine = $this->newTestedInstance($this->coinManager, $products);
        $vendingMachine->insertCoin(0.25);
        $this->exception(fn () => $vendingMachine->sellProduct('SODA'))->hasCode(10);
        $this->float($vendingMachine->getInsertedAmount())->isEqualTo(0.25);
    }
}
