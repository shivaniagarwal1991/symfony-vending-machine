<?php

namespace App\Adapter;

use App\Entity\Product as ProductEntity;
use App\Requests\Product\AddProduct;
use App\Repository\ProductRepository;

class ProductAdapter
{

    public static function adapt(ProductRepository $productRepository,
                                 AddProduct $product) : ProductEntity
    {
        $dateTime = new \DateTime();
        $productEntity = new ProductEntity();
        $productEntity->setName($product->name);
        $productEntity->setCost($product->cost);
        $productEntity->setQuantity($product->quantity);
        $productEntity->setSellerId($product->sellerId);
        $productEntity->setStatus(ProductEntity::STATUS_ACTIVE);
        $productEntity->setCreatedAt($dateTime);
        $productEntity->setUpdatedAt($dateTime);
        $productRepository->save($productEntity, true);
        return $productEntity;
    }

}