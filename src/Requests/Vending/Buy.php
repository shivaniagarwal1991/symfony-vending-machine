<?php

namespace App\Requests\Vending;

use App\Requests\BaseRequest;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class Buy extends BaseRequest
{
    #[Type('integer')]
    #[NotBlank()]
    #[GreaterThan(0)]
    public $quantity;

    #[Type('integer')]
    #[NotBlank()]
    #[GreaterThan(0)]
    public $productId;

    #[Type('integer')]
    #[NotBlank()]
    #[GreaterThan(0)]
    public $buyerId;
}