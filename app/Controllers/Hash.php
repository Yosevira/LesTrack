<?php

namespace App\Controllers;

class Hash extends BaseController
{
    public function index()
    {
        return view('hash_form');
    }

    public function generate()
    {
        $password = $this->request->getPost('password');

        if (!$password) {
            return redirect()->back()->with('error', 'Password tidak boleh kosong.');
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        return view('hash_form', [
            'original' => $password,
            'hash'     => $hash
        ]);
    }
}