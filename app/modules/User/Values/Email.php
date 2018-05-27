<?php
declare(strict_types=1);

namespace GlagolCloud\Modules\User\Values;

use JsonSerializable;

class Email implements JsonSerializable
{
    /**
     * @var string
     */
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function jsonSerialize()
    {
        return (string) $this;
    }
}