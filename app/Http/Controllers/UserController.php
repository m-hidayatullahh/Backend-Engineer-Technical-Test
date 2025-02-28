<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function findByNik($nik)
{
    $user = User::where('nik', $nik)->first();
    if (!$user) {
        return response()->json(['message' => 'User tidak ditemukan'], 404);
    }
    return response()->json($user);
}

}
