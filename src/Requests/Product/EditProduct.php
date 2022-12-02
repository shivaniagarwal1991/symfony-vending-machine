<?php

namespace App\Requests\Product;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\DivisibleBy;
use Symfony\Component\Validator\Constraints\GreaterThan;
use App\Requests\BaseRequest;

class EditProduct extends BaseRequest
{
    #[NotBlank([])]
    #[Type('integer')]
    #[GreaterThan(0)]
    public $quantity;

    #[NotBlank()]
    #[Type('integer')]
    #[GreaterThan(0)]
    #[DivisibleBy(5)]
    public $cost;

}