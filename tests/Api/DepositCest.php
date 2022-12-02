<?php

namespace App\Tests\api;

use App\Tests\Support\ApiTester;
use Codeception\Attribute\DataProvider;
use Codeception\Util\HttpCode;
use Faker\Factory;
use Faker\Generator;

class DepositCest
{
    private Generator $faker;

    private ApiTester $apiTester;

    private string $token;

    private string $depositUrl;

    public function _before(ApiTester $I)
    {
        $this->faker = Factory::create();
        $this->apiTester = $I;
        $this->depositUrl = '/deposit';
    }

    #[Before('executePossibleScenarioForWrongDeposit')]
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

    #[DataProvider('generatePossibleScenarioForWrongDeposit')]
    public function executePossibleScenarioForWrongDeposit(\Codeception\Example $example)
    {
        $this->apiTester->amBearerAuthenticated($this->token);
        $t = $this->apiTester->sendPostAsJson(
            $this->depositUrl,
            $example['request']
        );
        $this->expectedValidationError($example['response']['code'], $example['response']['message']);
    }

    public function buyerDepositCoin()
    {
        $this->apiTester->amBearerAuthenticated($this->token);
        $t = $this->apiTester->sendPostAsJson(
            $this->depositUrl,
            [
                'coin' => 5,
                'buyerId' => 3
            ]
        );
        $this->apiTester->seeResponseIsJson();
    }

    protected function generatePossibleScenarioForWrongDeposit(): array
    {
        return [
            [   'request' => ['coin'=> 5],
                'response' => ['code' => HttpCode::BAD_REQUEST, 'message' => 'validation_failed'],
            ],
            [   'request' => ['buyerId'=> 5],
                'response' => ['code' => HttpCode::BAD_REQUEST, 'message' => 'validation_failed'],
            ],
            [   'request' => ['buyerId'=> 5, 'coin' => 13],
                'response' => ['code' => HttpCode::BAD_REQUEST, 'message' => 'validation_failed'],
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