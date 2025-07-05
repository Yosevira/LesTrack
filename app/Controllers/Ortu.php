<?php

namespace App\Controllers;
use App\Models\AbsensiModel;
use App\Models\JadwalModel;
use App\Models\TugasModel;
use App\Models\UserModel; 

class Ortu extends BaseController
{
    public function dashboard()
    {
        // 1. Cek apakah pengguna adalah orang tua
        if (session('role') != 'ortu') {
            return redirect()->to('/');
        }

        $userId = session('user_id'); 
        $tugasModel = new TugasModel();
        $absensiModel = new AbsensiModel();

        // 2. Ambil data untuk "Pemberitahuan Tugas"
        
        $tugas = $tugasModel->where('user_id', $userId)
                             ->where('status !=', 'selesai') 
                             ->orderBy('deadline', 'ASC')
                             ->findAll();

        // 3. Ambil data untuk "Status Kehadiran Hari Ini"
        $today = date('Y-m-d');
        $kehadiran_hari_ini = $absensiModel->where('user_id', $userId)
                                           ->where('tanggal', $today)
                                           ->first();

        // 4. Ambil data untuk "Kehadiran Minggu Ini" (Senin - Jumat)
        $day_of_week = date('N'); 
        $start_of_week = date('Y-m-d', strtotime('-' . ($day_of_week - 1) . ' days'));
        $end_of_week = date('Y-m-d', strtotime('+' . (5 - $day_of_week) . ' days'));

        $kehadiran_mingguan_raw = $absensiModel->where('user_id', $userId)
                                              ->where('tanggal >=', $start_of_week)
                                              ->where('tanggal <=', $end_of_week)
                                              ->findAll();
        
        
        $kehadiran_minggu_ini = [];
        foreach ($kehadiran_mingguan_raw as $absen) {
            $hari = date('N', strtotime($absen['tanggal'])); 
            $kehadiran_minggu_ini[$hari] = $absen['status'];
        }

        // 5. Kirim semua data ke view
        $data = [
            'tugas' => $tugas,
            'kehadiran_hari_ini' => $kehadiran_hari_ini,
            'kehadiran_minggu_ini' => $kehadiran_minggu_ini,
        ];

        
        return view('ortu/dashboard', $data);
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

        $validation = \Config\Services::validation();

        $rules = [
            'hari' => [
                'label' => 'Hari',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus dipilih.'
                ]
            ],
            'mapel' => [
                'label' => 'Mapel',
                'rules' => 'required|min_length[2]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'min_length' => '{field} minimal 2 karakter.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $hari = $this->request->getPost('hari');
        $mapelInput = trim($this->request->getPost('mapel'));
        $mapelKey = strtolower(trim($this->request->getPost('mapel')));

        $existing = $jadwalModel->where([
            'user_id' => $userId,
            'hari' => $hari,
            'mapel' => $mapelInput,
        ])->findAll();

        foreach ($existing as $item) {
    if (strtolower($item['mapel']) == $mapelKey) {
        return redirect()->back()->withInput()->with('error', ['mapel' => "Mapel '$mapelInput' sudah ada pada hari $hari."]);
    }
}

        $jadwalModel->save([
            'user_id' => $userId,
            'hari' => $hari,
            'mapel' => $mapelInput
        ]);

        return redirect()->to('/ortu/jadwal')->with('success', 'Jadwal berhasil ditambahkan.');
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

    public function detailTugas($id)
    {
        $tugasModel = new \App\Models\TugasModel();
        $tugas = $tugasModel->find($id);

        if (!$tugas || $tugas['user_id'] != session('user_id')) {
            return redirect()->to('/ortu/tugas');
        }

        return view('ortu/detail_tugas', ['tugas' => $tugas]);
    }


    public function tambahTugas()
    {
        $validation = \Config\Services::validation();

        // Aturan validasi dan pesan error per field
        $rules = [
            'mapel' => [
                'label' => 'Mapel',
                'rules' => 'required|min_length[2]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'min_length' => '{field} minimal 2 karakter.'
                ]
            ],
            'deadline' => [
                'label' => 'Deadline',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                    'valid_date' => '{field} tidak valid.'
                ]
            ],
            'keterangan' => [
                'label' => 'Keterangan',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                    'min_length' => '{field} minimal 5 karakter.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $tugasModel = new \App\Models\TugasModel();

        $data = [
            'user_id' => session('user_id'),
            'mapel' => $this->request->getPost('mapel'),
            'deadline' => $this->request->getPost('deadline'),
            'keterangan' => $this->request->getPost('keterangan'),
            'status' => 'belum'
        ];

        $tugasModel->save($data);

        return redirect()->to('/ortu/tugas')->with('success', 'Tugas berhasil ditambahkan.');
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
        
        $tugas = $tugasModel->find($id); 
        $filename = $tugas['file'] ?? null; 

        $data = [
            'mapel' => $this->request->getPost('mapel'),
            'deadline' => $this->request->getPost('deadline'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        $tugasModel->update($id, $data);

        return redirect()->to('/ortu/tugas')->with('success', 'Tugas berhasil diubah.');
    }

    public function profil()
    {
        
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

    public function editProfil() 
    {
        
        if (session('role') != 'ortu') {
            return redirect()->to('/');
        }

        $userModel = new UserModel();
        $userId = session('user_id');
        $userData = $userModel->find($userId);

        if (!$userData) {
            return redirect()->to('/ortu/dashboard')->with('error', 'Data profil tidak ditemukan.');
        }

        
        return view('ortu/edit_profil', ['user' => $userData]);
    }

    public function updateProfil() 
    {
        
        if (session('role') != 'ortu') {
            return redirect()->to('/');
        }

        $userModel = new UserModel();
        $userId = session('user_id');

        
        $rules = [
            'nama_ortu'       => 'required|min_length[3]|max_length[100]',
            'nama_anak'       => 'required|min_length[3]|max_length[100]',
            'kelas'           => 'permit_empty|max_length[50]', 
            'alamat'          => 'permit_empty|max_length[255]',
            'no_telp'         => 'permit_empty|min_length[10]|max_length[20]|numeric',
            'password'        => 'permit_empty|min_length[8]', 
            'retype_password' => 'matches[password]', 
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

        
        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $userModel->update($userId, $data);

        return redirect()->to('/ortu/profil')->with('success', 'Profil berhasil diperbarui.');
    }
}