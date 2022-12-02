<?php

namespace App\Service\Interface;

use App\Requests\Vending\Buy;
use App\Requests\Vending\Deposit;
use Symfony\Component\HttpFoundation\JsonResponse;

interface IVendingService
{
    /**
     * @param Deposit $deposit
     * @return JsonResponse
     */
    public function deposit(Deposit $deposit): JsonResponse;

    /**
     * @param int $buyerId
     * @return JsonResponse
     */
    public function reset(int $buyerId): JsonResponse;

    /**
     * @param Buy $buyProduct
     * @return JsonResponse
     */
    public function buyProduct(Buy $buyProduct): JsonResponse;

}