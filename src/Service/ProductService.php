<?php

namespace App\Service;

use App\Adapter\ProductAdapter;
use App\Exception\NotFoundException;
use App\Repository\ProductRepository;
use App\Requests\Product\AddProduct;
use App\Requests\Product\EditProduct;
use App\Response\ResponseBuilder;
use App\Service\Interface\IProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Interface\IUserService;
use App\Message\Message;
use App\Entity\Product as ProductEntity;

class ProductService implements IProductService
{
    private ProductRepository $productRepository;

    private IUserService $userService;

    public function __construct(ProductRepository $productRepository, IUserService $userService )
    {
        $this->userService = $userService;
        $this->productRepository = $productRepository;
    }

    /**
     * @return JsonResponse
     */
    public function getProduct(): JsonResponse
    {
        $products = $this->productRepository->findActiveProduct();
        if(empty($products)) {
            throw new NotFoundException(Message::PRODUCT_NOT_FOUND);
        }
        return ResponseBuilder::Ok('', array_map('self::buildProductResponse', $products));
    }

    /**
     * @param AddProduct $productInput
     * @return JsonResponse
     */
    public function addProduct(AddProduct $productInput): JsonResponse
    {
        $this->userService->findUserById($productInput->sellerId);
        $product =  ProductAdapter::adapt( $this->productRepository, $productInput);
        return ResponseBuilder::created($this->buildProductResponse($product));
    }

    /**
     * @param int $id
     * @param EditProduct $editProduct
     * @return JsonResponse
     */
    public function editProduct(int $id, EditProduct $editProduct): JsonResponse
    {
        $product = $this->findProductById($id);
        $product->setQuantity($editProduct->quantity);
        $product->setCost($editProduct->cost);
        $product->setUpdatedAt(new \DateTime());
        $this->productRepository->save($product, true);
        return ResponseBuilder::ok(Message::PRODUCT_UPDATED);
    }

    /**
     * @param int $id
     * @return ProductEntity
     */
    public function findProductById(int $id): ProductEntity
    {
        $product = $this->productRepository->findProductById($id);
        if(empty($product)) {
            throw new NotFoundException(Message::PRODUCT_NOT_FOUND);
        }
        return $product;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteProduct(int $id): JsonResponse
    {
        $product = $this->findProductById($id);
        $this->productRepository->remove($product, true);
        return ResponseBuilder::noContent();
    }

    /**
     * @param ProductEntity $product
     * @return array
     */
    private function buildProductResponse(ProductEntity $product): array
    {
        return [
            'id' => $product->getId(),
            'cost' => $product->getCost(),
            'quantity' => $product->getQuantity(),
            'name' => $product->getName(),
            'sellerId' => $product->getSellerId(),
        ];
    }
}