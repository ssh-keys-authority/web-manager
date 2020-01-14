<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use violuke\RsaSshKeyFingerprint\FingerprintGenerator;
use violuke\RsaSshKeyFingerprint\InvalidInputException;

class KeyValidation implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        try {
            FingerprintGenerator::getFingerprint($value);
        } catch (InvalidInputException $e) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Ключ имеет неверный формат';
    }
}
