<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServerUser extends Model
{
    protected $fillable = [
        'name',
        'server_id'
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
}
