<?php declare(strict_types=1);

namespace vending\ui;

use vending\Checkout;
use vending\CoinManager;
use vending\VendingMachine;
use vending\models\Coin;
use vending\models\Coins;
use vending\models\Product;
use vending\models\Products;
use vending\ui\BaseCommand;

class ConsoleUI
{
    private $coinManager;
    private $products;
    private $vendingMachine;
   
    public function start()
    {
        echo "\n";
        $this->productsHeader();
        while (true) {
            $line = readline($this->status());
            $commands = $this->parse($line);
            $this->processCommands(...$commands);
        }
    }

    public function status():string
    {
        $insertedAmount = number_format($this->vendingMachine->getInsertedAmount(), 2, '.', ',');
        return " $insertedAmount$ >";
    }

    public function productsHeader()
    {
        $productHeader = array_reduce(
            $this->products->toArray(),
            function ($initial, $product) {
                return $initial .= " ".$product->hash()."(".$product->count()."): ".(string)$product->getValue();
            },
            ''
        );
        
        echo ' PRODUCTS: '.$productHeader . PHP_EOL;
    }

    public function parse($line): array
    {
        $sanitized = trim(str_replace('  ', ' ', $line));
        $commands = [];
        foreach (explode(',', $sanitized) as $part) {
            $commands[] = trim(str_replace('-', ' ', $part));
        }
        return $commands;
    }

    private function processCommands(...$commands)
    {
        foreach ($commands as $fullCommand) {
            $args = explode(' ', $fullCommand);
            $command = array_shift($args);
            
            if ($command) {
                $command = ucfirst(strtolower($command));
                if (is_numeric($command)) {
                    $args = [$command];
                    $command = 'AddCoin';
                }
                $this->execute($command, ...$args);
            }
        }
    }

    private function execute($command, ...$args):string
    {
        $commandInstance = $this->initializeCommand($command);
        if ($commandInstance) {
            $result = $commandInstance->execute(...$args);
            if (!empty($result)) {
                echo ' -> ' . $result . PHP_EOL . PHP_EOL;
            }
        }
        return "Error on introduced request";
    }
    
    
    private function initializeCommand(string $command)
    {
        try {
            $class = new \ReflectionClass('vending\ui\\'.ucfirst($command).'Command');
            return $class->newInstanceArgs([$this->vendingMachine]);
        } catch (\ReflectionException $e) {
            return false;
        }
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
