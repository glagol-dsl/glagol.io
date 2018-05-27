<?php
declare(strict_types=1);
namespace Test\Api;

use Faker\Factory;
use GlagolCloud\Modules\User\User;
use Test\TestCase;

class SignUpTest extends TestCase
{
    public function testShouldFailFormValidations()
    {
        $this->post('/api/sign-up');
        $this->seeStatusCode(422);

        $faker = Factory::create();
        $this->post('/api/sign-up', [
            'email' => $faker->userName,
            'password' => $faker->password,
        ]);
        $this->seeStatusCode(422);

        $this->post('/api/sign-up', [
            'email' => $faker->email,
            'password' => $faker->password(2, 4),
        ]);
        $this->seeStatusCode(422);
    }

    public function testShouldSuccessfullySignUpANewUser()
    {
        $faker = Factory::create();
        $this->post('/api/sign-up', [
            'email' => "{$faker->userName}@glagol.io",
            'password' => $faker->password(6),
        ]);

        $this->seeStatusCode(201);

        $this->assertCount(1, User::query()->get());
    }

    public function testShouldFailSignUpOnDuplicatedUser()
    {
        $faker = Factory::create();
        $email = "{$faker->userName}@glagol.io";

        $this->post('/api/sign-up', [
            'email' => $email,
            'password' => $faker->password,
        ]);

        $this->seeStatusCode(201);

        $this->post('/api/sign-up', [
            'email' => $email,
            'password' => $faker->password,
        ]);

        $this->seeStatusCode(422);


        $this->assertCount(1, User::query()->get());
    }
}
