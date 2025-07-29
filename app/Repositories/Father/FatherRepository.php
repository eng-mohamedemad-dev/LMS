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
        $father->firebaseTokens()->updateOrCreate(
            ['token' => $credentials['device_token']],
            ['tokenable_id' => $father->id, 'tokenable_type' => 'father']
        );
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
