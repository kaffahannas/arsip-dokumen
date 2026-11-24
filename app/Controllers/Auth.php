<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    public function index(): string
    {
        return view('auth/login', [
            'title' => 'Login',
        ]);
    }

    public function login(): RedirectResponse
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        $messages = [
            'email' => [
                'required'    => 'Email wajib diisi.',
                'valid_email' => 'Format email tidak valid.',
            ],
            'password' => [
                'required' => 'Password wajib diisi.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->to(base_url('login'))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email    = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        $user = model(UserModel::class)->where('email', $email)->first();

        if ($user === null || ! password_verify($password, $user['password'])) {
            return redirect()->to(base_url('login'))
                ->withInput()
                ->with('error', 'Email atau password salah.');
        }

        $session = session();
        $session->regenerate();
        $session->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id'],
            'user_name'  => $user['name'],
            'user_email' => $user['email'],
        ]);

        return redirect()->to(base_url('archives'))
            ->with('success', 'Selamat datang, ' . $user['name'] . '.');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to(base_url('login'))
            ->with('success', 'Anda telah logout.');
    }
}
