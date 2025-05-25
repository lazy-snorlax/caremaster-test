<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Password attribute caster.
     */
    public function password(): Attribute
    {
        return new Attribute(set: fn ($value) => $value ? bcrypt($value) : null);
    }

    /**
     * {@inheritDoc}
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * A user has a role through the assigned roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function role(): HasOneThrough
    {
        return $this->hasOneThrough(Role::class, AssignedRole::class, 'entity_id', 'id', 'id', 'role_id')
            ->where('assigned_roles.entity_type', self::class);
    }

    /**
     * Loads user role abilities.
     *
     * @return self
     */
    public function loadAbilities(): self
    {
        $this->setRelation('abilities', $this->abilities->merge($this->role?->abilities ?? []));
        return $this;
    }
}
