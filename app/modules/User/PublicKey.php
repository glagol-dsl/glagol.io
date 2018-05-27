<?php
declare(strict_types=1);

namespace GlagolCloud\Modules\User;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use phpseclib\Crypt\RSA;

/**
 * @property int id
 * @property DateTimeInterface created_at
 * @property User user
 * @property int user_id
 */
class PublicKey extends Model
{
    protected $table = 'public_keys';
    protected $fillable = ['key', 'user_id'];
    protected $hidden = ['key', 'user_id'];
    public $timestamps = false;

    public static function newFromKeyAndUser(string $key, User $user): self
    {
        $publicKey = new static([
            'key' => self::rsaKeyFromString($key),
            'user_id' => $user->id,
        ]);
        $publicKey->setRelation('user', $user);
        return $publicKey;
    }

    /**
     * @param $publicKey
     * @return RSA
     */
    private static function rsaKeyFromString(string $publicKey): RSA
    {
        $key = new RSA();
        $key->loadKey($publicKey);

        return $key;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setKeyAttribute(RSA $key): void
    {
        $this->attributes['key'] = $key->getPublicKey(RSA::PUBLIC_FORMAT_OPENSSH);
        $this->attributes['fingerprint_old'] = $key->getPublicKeyFingerprint();
        $this->attributes['fingerprint'] = $key->getPublicKeyFingerprint('sha256');
    }

    public function getKeyAttribute(): RSA
    {
        return self::rsaKeyFromString($this->attributes['key']);
    }
}