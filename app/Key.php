<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use violuke\RsaSshKeyFingerprint\FingerprintGenerator;
use violuke\RsaSshKeyFingerprint\InvalidInputException;

class Key extends Model
{
    protected $fillable = [
        'name',
        'key',
        'user_id',
    ];

    public function getHashAttribute()
    {
        try {
            return FingerprintGenerator::getFingerprint($this->key);
        } catch (InvalidInputException $e) {
        }

        return '';
    }
}
