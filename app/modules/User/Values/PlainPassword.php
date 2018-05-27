<?php
declare(strict_types=1);

namespace GlagolCloud\Modules\User\Values;


use Illuminate\Contracts\Hashing\Hasher;

class PlainPassword
{
    /**
     * @var string
     */
    private $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function toHash(Hasher $hasher): PasswordHash
    {
        return new PasswordHash($hasher->make($this->password));
    }

    public function __toString(): string
    {
        return $this->password;
    }
}