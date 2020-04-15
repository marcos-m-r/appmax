<?php

namespace App\Repositories;
 
use App\Model\Product;

class ProductRepository {

    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function findFirst($id)
    {
        return $this->product->where('id', $id)->where('status', Product::STATUS_ACTIVE)->first();
    }

    public function findAll()
    {
        return $this->product->where('status', Product::STATUS_ACTIVE)->get();
    }
}