<?php

namespace App\Tests\api;

use App\Tests\Support\ApiTester;
use Codeception\Attribute\DataProvider;
use Codeception\Util\HttpCode;
use Faker\Factory;
use Faker\Generator;

class UserCest
{
    private Generator $faker;
    private ApiTester $apiTester;
    private string $addUserUri;
    private string $token;

    public function _before(ApiTester $I)
    {
        $this->faker = Factory::create();
        $this->apiTester = $I;
        $this->addUserUri = '/user/add';
    }

    #[DataProvider('createUserPossibleError')]
    public function tryToCreateAllPossibleError(\Codeception\Example $example)
    {
        $this->apiTester->sendPostAsJson(
            $this->addUserUri,
            $example['request']
        );
        $this->expectedValidationError($example['response']['code'], $example['response']['message']);
    }

    protected function createUserPossibleError(): array
    {
        return [
            [   'request' => ['password'=> 'test', 'role' => 'buyer', 'email' => 'test'],
                'response' => ['code' => HttpCode::BAD_REQUEST, 'message' => 'validation_failed'],
            ],
            [   'request' => ['password'=> 'test', 'role' => 'buyer', 'emails' => 'test'],
                'response' => ['code' => HttpCode::BAD_REQUEST, 'message' => 'validation_failed'],
            ],
            [   'request' => [ 'role' => 'buyer', 'emails' => 'test'],
                'response' => ['code' => HttpCode::BAD_REQUEST, 'message' => 'validation_failed'],
            ],
            [   'request' => ['password'=> 'test', 'emails' => 'test'],
                'response' => ['code' => HttpCode::BAD_REQUEST, 'message' => 'validation_failed'],
            ],
            [   'request' => ['role'=> 'buyer', 'password' => 'test'],
                'response' => ['code' => HttpCode::BAD_REQUEST, 'message' => 'validation_failed'],
            ],
            [   'request' => ['role'=> 'buyer', 'password' => 'test', 'email' => 'test@gmail.com'],
                'response' => ['code' => HttpCode::CONFLICT, 'message' => 'user.already.exist'],
            ]
        ];
    }

    #[Before('updateUserPassword')]
    public function getUserAccessToken() {
        $t = $this->apiTester->sendPostAsJson(
            '/login',
            [
                'password'    => 'test2',
                'username' => 'test@gmail.com'
            ]
        );
        $this->apiTester->seeResponseCodeIs(HttpCode::OK);
        $this->apiTester->seeResponseIsJson();
        $this->token  = $t['token'];
    }


    public function updateUserPassword() {
        $this->apiTester->amBearerAuthenticated($this->token);
        $this->apiTester->sendPutAsJson(
            '/user/update/3',
            [
                'password'    => 'test2',
                'email' => 'test@gmail.com'
            ]
        );
        $this->expectedValidationError(HttpCode::OK, 'user.updated');

    }

    #[DataProvider('generateNewUser')]
    public function createNewUser(\Codeception\Example $example) {
        $this->apiTester->sendPutAsJson(
            $this->addUserUri,
            $example['request']
        );
        $this->apiTester->seeResponseIsJson();
    }

    protected function generateNewUser(): array
    {
        return [
            [   'request' => ['password'=> 'test', 'role' => 'buyer', 'email' => 'test342@gamil.com'],
                'response' => ['code' => HttpCode::OK],
            ],
            [   'request' => ['password'=> 'test', 'role' => 'seller', 'emails' => ''],
                'response' => ['code' => HttpCode::OK],
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