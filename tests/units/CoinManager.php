<?php declare(strict_types=1);

namespace tests\units\vending;

use atoum;
use vending\models\Coin;
use vending\models\Coins;

class CoinManager extends atoum
{
    private $coins;

    public function beforeTestMethod($method)
    {
        $this->coins = new Coins(...[new Coin(0.05, 2),
                                new Coin(0.1, 1),
                                new Coin(0.25, 2),
                                new Coin(1, 5)]);
    }
    
    public function testReturnTrueIfCoinIsValidDenomination()
    {
        $coinManager = $this->newTestedInstance($this->coins);

        $this->boolean($coinManager->isValid(0.1))->isTrue();
        $this->boolean($coinManager->isValid(1.0))->isTrue();
        $this->boolean($coinManager->isValid(0.05))->isTrue();
        $this->boolean($coinManager->isValid(0.25))->isTrue();
    }

    public function testReturnFalseIfCoinIsInvalidDenomination()
    {
        $coinManager = $this->newTestedInstance($this->coins);
        $this->boolean($coinManager->isValid(2))->isFalse();
    }

    public function testAddShouldUpdateTheCoinNumber()
    {
        $coinMock = new \mock\vending\models\Coin(1);
        $coinsMock = new Coins($coinMock);
        $coinManager = $this->newTestedInstance($coinsMock);

        $this->if($coinManager->add(1))
             ->then
             ->mock($coinMock)->call('add')->once();
    }

    public function testAddThrowErrorOnInvalidCoin()
    {
        $coinManager = $this->newTestedInstance(new Coins());
        $this->exception(
            function () use ($coinManager) {
                $coinManager->add(0.50);
            }
        )->hasCode(50);
    }

    public function testReturnFalseIfWeDontHaveCoinsOfDenomination()
    {
        $coinManager = $this->newTestedInstance($this->coins);
        $this->boolean($coinManager->any(7))->isFalse();
    }
    
    public function testReturnTrueIfWeHaveCoinsOfDenomination()
    {
        $coinManager = $this->newTestedInstance($this->coins);
        $this->boolean($coinManager->any(0.05))->isTrue();
    }
    
    public function testCoinsGetChangeItsCalled()
    {
        $coinMock = new \mock\vending\models\Coins;
        $coinManager = $this->newTestedInstance($coinMock);

        $this->if($coinManager->getChange(1))
             ->then
             ->mock($coinMock)->call('getChange')->once();
    }
}
