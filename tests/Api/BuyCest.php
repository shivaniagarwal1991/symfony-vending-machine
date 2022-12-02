<?php

namespace App\Tests\api;

use App\Tests\Support\ApiTester;
use Codeception\Attribute\DataProvider;
use Codeception\Util\HttpCode;
use Faker\Factory;
use Faker\Generator;

class BuyCest
{
    private Generator $faker;

    private ApiTester $apiTester;

    private string $token;

    private string $buyUrl;

    public function _before(ApiTester $I)
    {
        $this->faker = Factory::create();
        $this->apiTester = $I;
        $this->buyUrl = '/buy';
    }

    #[Before('executPossibleScenarioForBuyProduct')]
    public function getUserAccessToken()
    {
        $t = $this->apiTester->sendPostAsJson(
            '/login',
            [
                'password' => 'test2',
                'username' => 'test1@gmail.com'
            ]
        );
        $this->apiTester->seeResponseCodeIs(HttpCode::OK);
        $this->apiTester->seeResponseIsJson();
        $this->token = $t['token'];
    }

    #[DataProvider('generatePossibleScenarioForBuyProduct')]
    public function executPossibleScenarioForBuyProduct(\Codeception\Example $example)
    {
        $this->apiTester->amBearerAuthenticated($this->token);
        $t = $this->apiTester->sendPostAsJson(
            $this->buyUrl,
            $example['request']
        );
        $this->expectedValidationError($example['response']['code'], $example['response']['message']);
    }

    protected function generatePossibleScenarioForBuyProduct(): array
    {
        return [
            [   'request' => ['buyerId'=> 5, 'productId'=> 1],
                'response' => ['code' => HttpCode::BAD_REQUEST, 'message' => 'validation_failed'],
            ],
            [   'request' => ['buyerId'=> 5, 'quantity'=> 1],
                'response' => ['code' => HttpCode::BAD_REQUEST, 'message' => 'validation_failed'],
            ],
            [   'request' => ['quantity'=> 5, 'productId'=> 1],
                'response' => ['code' => HttpCode::BAD_REQUEST, 'message' => 'validation_failed'],
            ],
            [   'request' => ['quantity'=> 5, 'productId'=> '1', 'buyer' => 1],
                'response' => ['code' => HttpCode::BAD_REQUEST, 'message' => 'validation_failed'],
            ],
            [   'request' => ['quantity'=> 2, 'productId'=> 1, 'buyerId' => 1],
            'response' => ['code' => HttpCode::NOT_ACCEPTABLE, 'message' => 'insufficient.product.quantity'],
            ],
            [   'request' => ['quantity'=> 2, 'productId'=> 2, 'buyerId' => 1],
                'response' => ['code' => HttpCode::NOT_ACCEPTABLE, 'message' => 'insufficient.deposit'],
            ]
        ];
    }
    private function expectedValidationError(int $code, ?string $message)
    {
        $this->apiTester->seeResponseContainsJson(['code' => $code]);
        $this->apiTester->seeResponseIsJson();
        if(!empty($message)) {
            $this->apiTester->seeResponseContainsJson(['message' => $message]);
        }

    }
}