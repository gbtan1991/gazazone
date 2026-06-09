<?php

namespace App\Models\Platform;

use App\Enums\ClientUserRole;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientUser extends Authenticatable
{
    use HasUuids, Notifiable;

    protected $connection = 'mysql';
    protected $table = 'client_users';

    protected $fillable = [
        'client_id',
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role'     => ClientUserRole::class,
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function isOwner(): bool
    {
        return $this->role === ClientUserRole::Owner;
    }
}
