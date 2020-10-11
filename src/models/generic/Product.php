<?php declare(strict_types=1);

namespace vending\models;

use vending\models\generic\GenericItem;

class Product extends GenericItem
{
    public function __construct(string $productName, float $price, $count = 0)
    {
        parent::__construct(strtoupper($productName), $count, $price);
    }
}
