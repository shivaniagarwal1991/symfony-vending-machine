<?php

namespace App\Message;

class Message
{
    const USER_ALREADY_EXIST = 'user.already.exist';
    const USER_SUCCESSFULLY_CREATED = 'user.successfully.created';
    const USER_NOT_FOUND = 'user.not.found';
    const USER_UPDATE_USER = 'user.updated';
    const PRODUCT_NOT_FOUND = 'product.not.found';
    const PRODUCT_UPDATED = 'product.update';
    const INSUFFICIENT_PRODUCT_QUANTITY = 'insufficient.product.quantity';
    const INSUFFICIENT_DEPOSIT = 'insufficient.deposit';
}