<?php declare(strict_types=1);

namespace vending\ui;

class GetCommand extends BaseCommand
{
    public function execute(...$args):string
    {
        if (count($args) > 0) {
            try {
                list($product, $coins) = $this->vendingMachine->sellProduct($args[0]);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
            return "SOLD $product RETURN: ".implode(', ', $coins);
        }
        return '';
    }
}
