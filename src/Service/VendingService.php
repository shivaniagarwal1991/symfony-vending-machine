<?php

namespace App\Service;

use App\Message\Message;
use App\Repository\ProductRepository;
use App\Requests\Vending\Buy;
use App\Requests\Vending\Deposit;
use App\Response\ResponseBuilder;
use App\Service\Interface\IVendingService;
use App\Service\Interface\IUserService;
use App\Service\Interface\IProductService;
use App\Repository\UserRepository;
use App\Entity\User as UserEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Exception\NotAcceptableException;
use App\Entity\Product as ProductEntity;


class VendingService implements IVendingService
{
    private IUserService $userService;

    private UserRepository $userRepository;

    private IProductService $productService;

    private ProductRepository $productRepository;

    public function __construct(IUserService $userService,
                                UserRepository $userRepository,
                                IProductService $productService,
                                ProductRepository $productRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }

    /**
     * @param Deposit $deposit
     * @return JsonResponse
     */
    public function deposit(Deposit $deposit): JsonResponse
    {
        $userEntity = $this->userService->findUserById($deposit->buyerId);
        $depositAmount = $userEntity->getDeposit() + $deposit->coin;
        return $this->insertUserDeposit($depositAmount, $userEntity);
    }

    /**
     * @param int $buyerId
     * @return JsonResponse
     */
    public function reset(int $buyerId): JsonResponse
    {
        $userEntity = $this->userService->findUserById($buyerId);
        return $this->insertUserDeposit(0, $userEntity);
    }

    /**
     * @param Buy $buyProduct
     * @return JsonResponse
     */
    public function buyProduct(Buy $buyProduct): JsonResponse
    {
       $product =  $this->productService->findProductById($buyProduct->productId);
       $this->isProductQuantityLessThanBuyQuantity($product, $buyProduct);

       $amountToPay = $buyProduct->quantity * $product->getCost();
       $userEntity = $this->userService->findUserById($buyProduct->buyerId);
       $this->isDepositLessThanAmountToPay($amountToPay, $userEntity->getDeposit());

       $remainQuantity = $product->getQuantity() - $buyProduct->quantity;
       $this->updateQuantity($remainQuantity, $product);

       $balanceAmount = $userEntity->getDeposit() - $amountToPay;
       return $this->insertUserDeposit($balanceAmount, $userEntity);

    }

    /**
     * @param ProductEntity $product
     * @param Buy $buyProduct
     * @return void
     */
    private function isProductQuantityLessThanBuyQuantity(ProductEntity $product, Buy $buyProduct): void
    {
        if($product->getQuantity() < $buyProduct->quantity)
        {
            throw new NotAcceptableException(Message::INSUFFICIENT_PRODUCT_QUANTITY);
        }
    }

    /**
     * @param int $amountToPay
     * @param int $deposit
     * @return void
     */
    private function isDepositLessThanAmountToPay(int $amountToPay, int $deposit): void
    {
        if($amountToPay > $deposit)
        {
            throw new NotAcceptableException(Message::INSUFFICIENT_DEPOSIT);
        }
    }

    /**
     * @param int $quantity
     * @param ProductEntity $product
     * @return void
     */
    private function updateQuantity(int $quantity, ProductEntity $product): void
    {
        $product->setQuantity($quantity);
        $product->setUpdatedAt(new \DateTime());
        $this->productRepository->save($product, true);
    }

    /**
     * @param int $deposit
     * @param UserEntity $userEntity
     * @return JsonResponse
     */
    private function insertUserDeposit(int $deposit, UserEntity $userEntity): JsonResponse
    {
        $userEntity->setDeposit($deposit);
        $userEntity->setUpdatedAt(new \DateTime());
        $this->userRepository->save($userEntity, true);
        return ResponseBuilder::Ok('', $this->buildUserResponse($userEntity));
    }

    /**
     * @param UserEntity $user
     * @return array
     */
    private function buildUserResponse(UserEntity $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'deposit' => $user->getDeposit()
        ];
    }
}