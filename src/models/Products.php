<?php declare(strict_types=1);

namespace vending\models;

use vending\models\generic\GenericCollection;
use vending\models\Product;

class Products extends GenericCollection
{
    public function __construct(Product ...$products)
    {
        parent::__construct(...$products);
    }
}
