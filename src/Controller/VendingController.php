<?php

namespace App\Controller;

use App\Requests\Vending\Deposit;
use App\Requests\Vending\Buy;
use App\Service\Interface\IVendingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/vending-machine")
 */
class VendingController extends AbstractController
{
    protected IVendingService $vendingService;

    public function __construct(IVendingService $vendingService)
    {
        $this->vendingService = $vendingService;
    }

    #[Route('/deposit', name: 'deposit_coin', methods: 'POST')]

    public function deposit(Deposit $deposit): JsonResponse
    {
        return $this->vendingService->deposit($deposit);
    }

    #[Route('/buy', name: 'buy_product', methods: 'POST')]

    public function buyProduct(Buy $buyProduct): JsonResponse
    {
        return $this->vendingService->buyProduct($buyProduct);
    }

    #[Route('/reset/{id}', name: 'reset_deposit', methods: 'PUT')]

    public function reset(int $id): JsonResponse
    {
        return $this->vendingService->reset($id);
    }
}