<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Server extends Model
{
    protected $fillable = [
        'name',
        'operatingsystem_id',
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

    public function system()
    {
        return $this->belongsTo(OperatingSystem::class, 'operatingsystem_id', 'id');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
