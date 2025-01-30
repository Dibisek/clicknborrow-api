<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/setup', function () {
    $credentials = [
        'email' => 'admin@admin.pl',
        'password' => 'admin'
    ];

    if (!Auth::attempt($credentials)) {
        return 'Wrong credentials';
    } else {
        $user = Auth::user();
        
        $adminToken = $user->createToken('adminToken', ['create', 'update', 'delete', 'book:create']);
        $userToken = $user->createToken('userToken', ['reservation:create', 'reservation:delete', 'bookmark:create', 'bookmark:delete']);

        return [
            'adminToken' => $adminToken->plainTextToken,
            'userToken' => $userToken->plainTextToken
        ];
    }
});