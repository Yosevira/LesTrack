<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\TugasModel;
use App\Models\UserModel; // Pastikan ini sudah ada

class Ortu extends BaseController
{
    public function dashboard()
    {
        // Pastikan user sudah login dan role ortu
        if (session('role') != 'ortu') {
            return redirect()->to('/');
        }

        return view('ortu/dashboard');
    }

    public function jadwal()
    {
        if (session('role') != 'ortu') return redirect()->to('/');

        $jadwalModel = new JadwalModel();
        $tugasModel = new TugasModel();

        $userId = session('user_id');
        $jadwal = $jadwalModel->where('user_id', $userId)->findAll();
        $tugas = $tugasModel->where('user_id', $userId)->findAll();
        $tugasMapel = [];
        foreach ($tugas as $t) {
            if ($t['status'] !== 'selesai') {
                $tugasMapel[strtolower($t['mapel'])] = true;
            }
        }


        return view('ortu/jadwal', [
            'jadwal' => $jadwal,
            'tugasMapel' => $tugasMapel
        ]);
    }

    public function tambahJadwal()
    {
        $jadwalModel = new JadwalModel();
        $userId = session('user_id');

        // Validasi input
        if (!$this->validate([
            'hari' => 'required',
            'mapel' => 'required|min_length[2]',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Hari dan Mapel wajib diisi dan minimal 2 karakter.');
        }
        $hari = $this->request->getPost('hari');
        $mapelInput = trim($this->request->getPost('mapel'));
        $mapelKey = strtolower($mapelInput);

        // Cek duplikat mapel di hari yang sama
        $existing = $jadwalModel->where([
            'user_id' => $userId,
            'hari' => $hari,
            'mapel' => $mapelInput,
       ])->findAll();

        // Periksa apakah ada mapel yang sama (case-insensitive)
        foreach ($existing as $item) {
            if (strtolower($item['mapel']) == $mapelKey) {
                return redirect()->back()->with('error', "Mapel '$mapelInput' sudah ada pada hari $hari.");
            }
        }
            $jadwalModel->save([
            'user_id' => $userId,
            'hari' => $hari,
            'mapel' => $mapelInput
        ]);

        return redirect()->to('/ortu/jadwal');
    }

    public function editJadwalHari($hari)
    {
        $jadwalModel = new JadwalModel();
        $jadwal = $jadwalModel
            ->where('user_id', session('user_id'))
            ->where('hari', $hari)
            ->findAll();

        return view('ortu/edit_jadwal', ['hari' => $hari, 'jadwal' => $jadwal]);
    }

    public function updateJadwal()
    {
        $jadwalModel = new JadwalModel();
        $id = $this->request->getPost('id');
        $mapel = strtolower(trim($this->request->getPost('mapel')));

        $jadwalModel->update($id, ['mapel' => $mapel]);

        return redirect()->to('/ortu/jadwal');
    }

    public function hapusMapel($id)
    {
        $jadwalModel = new JadwalModel();
        $jadwalModel->delete($id);
        return redirect()->back();
    }


    public function tugas()
    {
        if (session('role') != 'ortu') return redirect()->to('/');

        $tugasModel = new TugasModel();
        $tugas = $tugasModel->where('user_id', session('user_id'))->findAll();

        return view('ortu/tugas', ['tugas' => $tugas]);
    }

    public function tambahTugas()
    {
        $tugasModel = new TugasModel();

        $data = [
            'user_id' => session('user_id'),
            'mapel' => $this->request->getPost('mapel'),
            'deadline' => $this->request->getPost('deadline'),
            'keterangan' => $this->request->getPost('keterangan'),
            'status' => 'belum'
        ];

        $tugasModel->save($data);

        return redirect()->to('/ortu/tugas');
    }

    public function hapusTugas($id)
    {
        $tugasModel = new TugasModel();
        $tugasModel->delete($id);
        return redirect()->to('/ortu/tugas');
    }

    public function editTugas($id)
    {
        $tugasModel = new TugasModel();
        $tugas = $tugasModel->find($id);

        if (!$tugas || $tugas['user_id'] != session('user_id')) {
            return redirect()->to('/ortu/tugas');
        }

        return view('ortu/edit_tugas', ['tugas' => $tugas]);
    }

    public function updateTugas($id)
    {
        $tugasModel = new TugasModel();
        // Pastikan Anda mendapatkan data tugas yang akan diupdate terlebih dahulu
        $tugas = $tugasModel->find($id); 
        $filename = $tugas['file'] ?? null; // Jika ada, ambil nama filenya

        $data = [
            'mapel' => $this->request->getPost('mapel'),
            'deadline' => $this->request->getPost('deadline'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        $tugasModel->update($id, $data);

        return redirect()->to('/ortu/tugas');
    }

    public function profil()
    {
        // Pastikan user sudah login dan role ortu
        if (session('role') != 'ortu') {
            return redirect()->to('/');
        }

        $userModel = new UserModel();
        $userId = session('user_id');
        $userData = $userModel->find($userId);

        if (!$userData) {
            return redirect()->to('/ortu/dashboard')->with('error', 'Data profil tidak ditemukan.');
        }

        return view('ortu/profil', ['user' => $userData]);
    }

    public function editProfil() // Fungsi baru untuk menampilkan form edit
    {
        // Pastikan user sudah login dan role ortu
        if (session('role') != 'ortu') {
            return redirect()->to('/');
        }

        $userModel = new UserModel();
        $userId = session('user_id');
        $userData = $userModel->find($userId);

        if (!$userData) {
            return redirect()->to('/ortu/dashboard')->with('error', 'Data profil tidak ditemukan.');
        }

        // Tampilkan form edit profil dengan data yang ada
        return view('ortu/edit_profil', ['user' => $userData]);
    }

    public function updateProfil() // Fungsi baru untuk memproses update data
    {
        // Pastikan user sudah login dan role ortu
        if (session('role') != 'ortu') {
            return redirect()->to('/');
        }

        $userModel = new UserModel();
        $userId = session('user_id');

        // Validasi input
        $rules = [
            'nama_ortu'       => 'required|min_length[3]|max_length[100]',
            'nama_anak'       => 'required|min_length[3]|max_length[100]',
            'kelas'           => 'permit_empty|max_length[50]', // Mengizinkan kosong
            'alamat'          => 'permit_empty|max_length[255]',
            'no_telp'         => 'permit_empty|min_length[10]|max_length[20]|numeric',
            'password'        => 'permit_empty|min_length[8]', // Minimal 8 karakter jika diisi
            'retype_password' => 'matches[password]', // Harus sama dengan field password
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_ortu' => $this->request->getPost('nama_ortu'),
            'nama_anak' => $this->request->getPost('nama_anak'),
            'kelas'     => $this->request->getPost('kelas'),
            'alamat'    => $this->request->getPost('alamat'),
            'no_telp'   => $this->request->getPost('no_telp'),
        ];

        // Hanya update password jika ada input password baru dan tidak kosong
        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            // Hash password baru sebelum disimpan
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $userModel->update($userId, $data);

        return redirect()->to('/ortu/profil')->with('success', 'Profil berhasil diperbarui.');
    }
}