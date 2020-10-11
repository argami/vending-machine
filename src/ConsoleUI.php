<?php declare(strict_types=1);

namespace vending\ui;

use vending\Checkout;
use vending\CoinManager;
use vending\VendingMachine;
use vending\models\Coin;
use vending\models\Coins;
use vending\models\Product;
use vending\models\Products;

class ConsoleUI
{
    private $coinManager;
    private $products;
    private $vendingMachine;
    private $commands = ['RETURN-COIN', 'GET-'];
    
    public function start()
    {
        while (true) {
            $line = readline($this->status());
            $commands = $this->parse($line);
            echo ' -> ' . $this->execute(...$commands) . PHP_EOL . PHP_EOL;
        }
    }

    public function status():string
    {
        $insertedAmount = number_format($this->vendingMachine->getInsertedAmount(), 2, '.', ',');
        return " $insertedAmount$ >";
    }

    public function parse($line): array
    {
        $sanitized = str_replace(' ', '', $line);
        return explode(',', $sanitized);
    }

    public function execute(...$commands):string
    {
        $result = [];
        $invalidCoins = [];
        foreach ($commands as $command) {
            $command = strtoupper($command);
            $spltCommand = explode('-', $command);

            switch ($spltCommand[0]) {
                case 'GET':
                        try {
                            list($product, $coins) = $this->vendingMachine->sellProduct($spltCommand[1]);
                        } catch (\Exception $e) {
                            return $e->getMessage();
                        }
                        return "SOLD $product RETURN: ".implode(', ', $coins);
                    break;
                case 'RETURN':
                    if ($command == 'RETURN-COIN') {
                        return "RETURN: ". implode(', ', $this->vendingMachine->returnCoins());
                    }
                    break;
                default:
                    
              }



            $fltValue = floatval($command);

            
            if ($fltValue != 0) {
                if ($fltValue < 0) {
                    // no negative money in coins
                    $fltValue *= -1;
                }
                $invalid = $this->vendingMachine->insertCoin($fltValue);
                if ($invalid != 0) {
                    $invalidCoins[] = $invalid;
                }
                continue;
            }
        }

        if (count($invalidCoins) > 0) {
            $result[] = "RETURN INVALID COINS: ".implode(', ', $invalidCoins);
        }

        return implode(', ', $result);
    }

    public function setDefaultValues()
    {
        $this->coinManager = new CoinManager(
            new Coins(
                new Coin(0.05, 10),
                new Coin(0.1, 10),
                new Coin(0.25, 10),
                new Coin(1, 10)
            )
        );

        $this->products = new Products(
            new Product('WATER', 0.65, 10),
            new Product('JUICE', 1.00, 10),
            new Product('SODA', 1.50, 10)
        );

        $this->vendingMachine = new VendingMachine($this->coinManager, $this->products);
    }
}
