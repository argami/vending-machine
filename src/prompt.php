<?php

require_once './vendor/autoload.php';

use vending\ui\ConsoleUI;
use vending\models\Coins;
use vending\models\Coin;
use vending\models\Product;

function defaultValues()
{
    $coinManager = new vending\CoinManager(
        new Coins(
            new Coin(0.05, 10),
            new Coin(0.1, 10),
            new Coin(0.25, 10),
            new Coin(1, 10)
        )
    );

    $products = new vending\models\Products(
        new Product('WATER', 0.65, 10),
        new Product('JUICE', 1.00, 10),
        new Product('SODA', 1.50, 10)
    );

    return new \vending\VendingMachine($coinManager, $products);
}

$console = new ConsoleUI(defaultValues());
$console->start();
