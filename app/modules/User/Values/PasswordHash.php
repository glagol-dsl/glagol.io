<?php
declare(strict_types=1);

namespace GlagolCloud\Modules\User\Values;

use Illuminate\Contracts\Hashing\Hasher;

class PasswordHash
{
    /**
     * @var string
     */
    private $hash;

    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    public function checks(PlainPassword $password, Hasher $hasher): bool
    {
        return $hasher->check((string) $password, $this->hash);
    }

    public function __toString(): string
    {
        return $this->hash;
    }
}
