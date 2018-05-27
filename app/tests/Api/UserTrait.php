<?php
declare(strict_types=1);

namespace Test\Api;

use Faker\Factory;
use GlagolCloud\Modules\User\User;

trait UserTrait
{
    private function newUser(?string $password = null)
    {
        $faker = Factory::create();
        $this->post('/api/sign-up', [
            'email' => "{$faker->userName}@glagol.io",
            'password' => $password ?: $faker->password,
        ]);
    }

    public function findLatestUser(): User
    {
        return User::query()->orderBy('id', 'desc')->first();
    }
}