<?php

namespace App\Controller;

use App\Requests\Product\AddProduct;
use App\Requests\Product\EditProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Interface\IProductService;

/**
 * @Route("/vending-machine/product")
 */
class ProductController extends AbstractController
{
    protected IProductService $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    #[Route('/list', name: 'all_product', methods: 'GET')]

    public function getProduct(): JsonResponse
    {
        return $this->productService->getProduct();
    }

    #[Route('/add', name: 'add_product', methods: 'POST')]

    public function addProduct(AddProduct $productInput): JsonResponse
    {
        return $this->productService->addProduct($productInput);
    }

    #[Route('/update/{id}', name: 'edit_product', methods: 'PUT')]

    public function editProduct(EditProduct $product, int $id): JsonResponse
    {
        return $this->productService->editProduct($id, $product);
    }

    #[Route('/{id}', name: 'delete_product', methods: 'DELETE')]

    public function deleteProduct(int $id): JsonResponse
    {
        return $this->productService->deleteProduct($id);
    }

}