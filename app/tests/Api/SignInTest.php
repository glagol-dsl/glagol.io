<?php
declare(strict_types=1);
namespace Test\Api;

use Faker\Factory;
use GlagolCloud\Modules\User\User;
use Test\TestCase;

class SignInTest extends TestCase
{
    use UserTrait;

    public function testShouldSuccessfullySignInAndGetAccessToken()
    {
        $password = Factory::create()->password(6);

        $this->newUser($password);
        $user = $this->findLatestUser();

        $this->post('/api/sign-in', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $this->seeStatusCode(200);
    }

    public function testShouldFailWithBadPassword()
    {
        $password = Factory::create()->password(6);

        $this->newUser();
        $user = $this->findLatestUser();

        $this->post('/api/sign-in', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $this->seeStatusCode(401);
    }
}
