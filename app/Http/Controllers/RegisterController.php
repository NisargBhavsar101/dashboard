<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class RegisterController extends Controller
{
    protected function create(array $data)
{
    $isAdmin = User::count() === 0; // Make the first registered user an admin

    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'is_admin' => $isAdmin,
    ]);
}
}
