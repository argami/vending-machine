<?php declare(strict_types=1);

namespace vending\models\generic\interfaces;

interface Changeable
{
    public function getChange(float $changeAmount):array;
}
