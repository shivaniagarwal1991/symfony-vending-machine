<?php

namespace App\Service\Interface;

use App\Entity\Product as ProductEntity;
use App\Requests\Product\AddProduct;
use App\Requests\Product\EditProduct;
use Symfony\Component\HttpFoundation\JsonResponse;

interface IProductService
{
    /**
     * @return JsonResponse
     */
    public function getProduct(): JsonResponse;

    /**
     * @param AddProduct $productInput
     * @return JsonResponse
     */
    public function addProduct(AddProduct $productInput): JsonResponse;

    /**
     * @param int $id
     * @param EditProduct $editProduct
     * @return JsonResponse
     */
    public function editProduct(int $id, EditProduct $editProduct): JsonResponse;

    /**
     * @param int $id
     * @return ProductEntity
     */
    public function findProductById(int $id): ProductEntity;

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteProduct(int $id): JsonResponse;
}