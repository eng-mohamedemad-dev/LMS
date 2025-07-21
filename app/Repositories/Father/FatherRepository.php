<?php

namespace App\Repositories\Father;

use App\Models\Father;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Father\FatherInterface;

class FatherRepository implements FatherInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function login(array $credentials)
    {
        $father = Father::where('email', $credentials['email'])->first();
        if (!$father || !Hash::check($credentials['password'], $father->password)) {
            return null;
        }
        return $father;
    }

    public function register(array $data)
    {
        return Father::create($data);
    }

    public function checkExistsByPhoneOrEmail($phone, $email)
    {
        return Father::where('phone', $phone)
            ->orWhere('email', $email)
            ->exists();
    }
}
