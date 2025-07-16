<?php

namespace App\Actions\Product;

use App\Models\Product;

class ProductCreate
{
    public function handle($requestData)
    {
        $entryArr = [
            'product_name' => $requestData['product_name'],
            'quantity_in_stock' => $requestData['quantity_in_stock'],
            'price_per_item' => $requestData['price_per_item'],
        ];

        Product::create($entryArr);
    }
}