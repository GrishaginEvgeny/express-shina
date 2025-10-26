<?php

namespace App\Helper;

use App\Entity\Product;
use App\Service\Cart\s;

class AmountCalculatorHelper
{
    /** @param Product[] $products */
    public static function calculate(array $products)
    {
        $amount = 0;
        foreach ($products as $product) {
            $amount += $product->getPrice();
        }

        return $amount;
    }
}
