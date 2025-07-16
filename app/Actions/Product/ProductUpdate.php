<?php

namespace App\Actions\Product;

use App\Models\Product;

class ProductUpdate
{
    public function handle($id, $requestData)
    {
        $updateArr = [
            'product_name' => $requestData['product_name'],
            'quantity_in_stock' => $requestData['quantity_in_stock'],
            'price_per_item' => $requestData['price_per_item'],
        ];

        $product = Product::find($id);

        if (! $product) {
            throw new \Exception('Product not found');
        }

        $product->update($updateArr);
    }
}
