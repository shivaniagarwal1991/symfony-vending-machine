<?php

namespace App\Requests\Vending;

use App\Requests\BaseRequest;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class Deposit extends BaseRequest
{
    #[Type('integer')]
    #[NotBlank()]
    #[Choice([5, 10, 20, 50, 100])]
    public $coin;

    #[Type('integer')]
    #[NotBlank()]
    #[GreaterThan(0)]
    public $buyerId;
}