<?php
declare(strict_types=1);
namespace GlagolCloud\Modules\User;

use DateTimeInterface;
use GlagolCloud\Modules\User\Values\Email;
use GlagolCloud\Modules\User\Values\PasswordHash;
use GlagolCloud\Modules\User\Values\PlainPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Hashing\HashManager;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Laravel\Passport\HasApiTokens;

/**
 * @property int id
 * @property Email email
 * @property PasswordHash password
 * @property DateTimeInterface created_at
 * @property DateTimeInterface updated_at
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasApiTokens;

    protected $table = 'users';
    protected $fillable = ['email'];
    protected $hidden = ['password'];

    public static function newUser(Email $email, PlainPassword $password, Hasher $hasher): self
    {
        $user = new static(['email' => $email]);

        $user->setPassword($password, $hasher);

        return $user;
    }

    public function validateForPassportPasswordGrant(string $password): bool
    {
        return $this->password->checks(new PlainPassword($password), app(HashManager::class)->driver());
    }

    public function getEmailAttribute(): Email
    {
        return new Email($this->attributes['email']);
    }

    public function setEmailAttribute(Email $email): void
    {
        $this->attributes['email'] = (string) $email;
    }

    public function getPasswordAttribute(): PasswordHash
    {
        return new PasswordHash($this->attributes['password']);
    }

    public function setPasswordAttribute(PasswordHash $password)
    {
        $this->attributes['password'] = (string) $password;
    }

    private function setPassword(PlainPassword $password, Hasher $hasher)
    {
        $this->password = $password->toHash($hasher);
    }
}
