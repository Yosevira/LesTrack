<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session;


class Auth extends Controller
{
    protected $session;
    protected $userModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->session = session();
        $this->userModel = new UserModel();
    }

    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function doRegister()
    {
        $validation = \Config\Services::validation();
        $data = $this->request->getPost();

        if (!$this->validate([
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'nama_anak' => 'required',
            'nama_ortu' => 'required',
            'role' => 'required|in_list[ortu,guru]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->userModel->save([
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'nama_anak' => $data['nama_anak'] ?? null,
            'nama_ortu' => $data['nama_ortu'],
            'alamat' => $data['alamat'],
            'no_telp' => $data['no_telp'],
            'role' => $data['role']
        ]);

        return redirect()->to('/')->with('message', 'Registrasi berhasil, silakan login');
    }

    public function doLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = $this->userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $this->session->set([
                'user_id' => $user['id'],
                'role' => $user['role'],
                'nama' => $user['nama_anak'] ?? $user['nama_ortu'],
                'isLoggedIn' => true
            ]);

            // Arahkan ke dashboard sesuai role
            return redirect()->to($user['role'] == 'ortu' ? '/ortu/dashboard' : '/guru/dashboard');
        } else {
            return redirect()->back()->with('error', 'Email atau password salah');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/');
    }


    public function buatPassword()
{
    echo password_hash('admin123', PASSWORD_DEFAULT);
}

}