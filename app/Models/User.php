<?php

namespace App\Models;

use App\Enums\ClientUserRole;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable;

    protected $fillable = [
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

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'assigned_to');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'assigned_to');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'assigned_to');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function pipelineActivities(): HasMany
    {
        return $this->hasMany(PipelineActivity::class, 'user_id');
    }

    public function taskComments(): HasMany
    {
        return $this->hasMany(TaskComment::class, 'user_id');
    }

    public function isOwner(): bool
    {
        return $this->role === ClientUserRole::Owner;
    }
}
