<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\DivisibleBy;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Email;

class AddProduct extends BaseRequest
{
    #[NotBlank([])]
    #[Email([])]
    protected $email;

    #[NotBlank()]
    protected $name;

    #[Type('integer')]
    #[NotBlank()]
    #[DivisibleBy(5)]
    protected $cost;

    #[Type('integer')]
    #[NotBlank()]
    #[GreaterThan(0)]
    protected $quantity;

    #[Type('integer')]
    #[NotBlank()]
    #[Choice([5, 10, 20, 50, 100])]
    protected $coin;

}