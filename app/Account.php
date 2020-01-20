<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Account extends Model
{
    protected $fillable = [
        'name',
        'server_id',
        'last_sync',
    ];

    protected $casts = [
        'last_sync' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($server) {
                $server->uuid = Str::uuid();
            }
        );
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_accounts')
            ->withTimestamps();
    }

    public function isActivated()
    {
        return $this->last_sync !== null;
    }
}
