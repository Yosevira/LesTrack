<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TugasModel;
use App\Models\AbsensiModel;
use App\Models\JadwalModel;

class Guru extends BaseController
{
    public function dashboard()
    {
        
        if (session('role') != 'guru') {
            return redirect()->to('/');
        }

        $userModel = new UserModel();
        $siswa = $userModel->where('role', 'ortu')->findAll();

        return view('guru/dashboard', ['siswa' => $siswa]);
    }

    
    public function detailSiswa($id)
    {
        if (session('role') != 'guru') return redirect()->to('/');

        $jadwalModel = new JadwalModel();
        $tugasModel = new TugasModel();
        $userModel = new UserModel();

        $jadwal = $jadwalModel->where('user_id', $id)->findAll();
        $tugas = $tugasModel->where('user_id', $id)->findAll();
        $siswa = $userModel->find($id);

        $tugasMapel = [];
        foreach ($tugas as $t) {
            $tugasMapel[strtolower($t['mapel'])] = true;
        }

        return view('guru/jadwal_siswa', [
            'jadwal' => $jadwal,
            'tugasMapel' => $tugasMapel,
            'siswa' => $siswa
        ]);
    }

    public function tugas($userId)
    {
        if (session('role') != 'guru') return redirect()->to('/');

        $tugasModel = new TugasModel();
        $userModel = new UserModel();

        $tugas = $tugasModel->where('user_id', $userId)->findAll();
        $siswa = $userModel->find($userId);

        return view('guru/tugas_siswa', [
            'tugas' => $tugas,
            'siswa' => $siswa
        ]);
    }

    public function updateTugas()
    {
        $tugasModel = new \App\Models\TugasModel();
        $id = $this->request->getPost('id');

        $data = [
            'status' => $this->request->getPost('status')
        ];

        // Validasi & simpan file (hanya gambar)
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (in_array($file->getMimeType(), $allowedTypes)) {
                $newName = $file->getRandomName();
                $file->move('uploads/', $newName);
                $data['file'] = $newName; // pakai 'file', sesuai database
            } else {
                return redirect()->back()->with('error', 'File harus berupa gambar (jpg/png/webp)');
            }

                    if ($file && $file->isValid() && !$file->hasMoved()) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    return redirect()->back()->with('error', 'File harus berupa gambar');
                }

                if ($file->getSize() > 2 * 1024 * 1024) { // 2MB
                    return redirect()->back()->with('error', 'Ukuran file maksimal 2MB');
                }

                $newName = $file->getRandomName();
                $file->move('uploads/', $newName);
                $data['file'] = $newName;
            }

        }

        $tugasModel->update($id, $data);
        return redirect()->back()->with('success', 'Tugas berhasil diperbarui');
    }

   

    
    public function absensi($year = null, $month = null)
    {
        if (session('role') != 'guru') return redirect()->to('/');

        
        $year  = $year ?? date('Y');
        $month = $month ?? date('m');

        $userModel = new UserModel();
        $absensiModel = new AbsensiModel();

        // 1. Ambil semua data siswa
        $siswa = $userModel->where('role', 'ortu')->findAll();

        // 2. Ambil data absensi untuk bulan dan tahun yang dipilih
        $absensi_bulanan = $absensiModel
            ->where('YEAR(tanggal)', $year)
            ->where('MONTH(tanggal)', $month)
            ->findAll();

        // 3. Olah data absensi agar mudah ditampilkan di view
        
        $absensi_terolah = [];
        foreach ($absensi_bulanan as $absen) {
            $day = date('j', strtotime($absen['tanggal'])); 
            $absensi_terolah[$absen['user_id']][$day] = $absen['status'];
        }

        // 4. Siapkan data untuk dikirim ke view
        $data = [
            'siswa' => $siswa,
            'absensi' => $absensi_terolah,
            'year' => $year,
            'month' => $month,
            'nama_bulan' => date('F', mktime(0, 0, 0, $month, 1, $year)), 
            'days_in_month' => cal_days_in_month(CAL_GREGORIAN, $month, $year) 
        ];

        // 5. Hitung data untuk "Ringkasan Hari Ini"
        $today = date('Y-m-d');
        $data['hadir_hari_ini'] = $absensiModel->where('tanggal', $today)->where('status', 'hadir')->countAllResults();
        $data['sakit_hari_ini'] = $absensiModel->where('tanggal', $today)->where('status', 'sakit')->countAllResults();
        
        $data['alpa_hari_ini'] = $absensiModel->where('tanggal', $today)->whereIn('status', ['alpa', 'izin'])->countAllResults();
        $data['total_murid'] = count($siswa);

        // 6. Hitung "Total Pertemuan" dalam sebulan (berdasarkan hari unik yang ada absensinya)
        $total_pertemuan_data = $absensiModel
            ->select('tanggal')
            ->where('YEAR(tanggal)', $year)
            ->where('MONTH(tanggal)', $month)
            ->distinct()
            ->countAllResults();
        $data['total_pertemuan'] = $total_pertemuan_data;

        
        return view('guru/absensi', $data);
    }
    public function simpanAbsensi()
    {
        $absensiModel = new AbsensiModel();
        $tanggal = $this->request->getPost('tanggal');

        foreach ($this->request->getPost('status') as $userId => $status) {
            $absensiModel->save([
                'user_id' => $userId,
                'tanggal' => $tanggal,
                'status' => $status
            ]);
        }

        return redirect()->back()->with('success', 'Absensi berhasil disimpan');
    }
    



    public function simpanAbsensiPopup()
    {
        if (session('role') != 'guru') return redirect()->to('/');

        $absensiModel = new \App\Models\AbsensiModel();
        
        $userId = $this->request->getPost('user_id');
        $tanggal = $this->request->getPost('tanggal');
        $status = $this->request->getPost('status');

       
        $year = date('Y', strtotime($tanggal));
        $month = date('m', strtotime($tanggal));

        
        if (empty($userId) || empty($tanggal) || empty($status)) {
            return redirect()->to('guru/absensi/' . $year . '/' . $month)
                             ->with('error', 'Data yang dikirim tidak lengkap.');
        }

        
        $existing = $absensiModel->where('user_id', $userId)
                                 ->where('tanggal', $tanggal)
                                 ->first();

        if ($status == 'kosong') {
            
            if ($existing) {
                $absensiModel->delete($existing['id']);
            }
        } else {
            
            $data = [
                'user_id' => $userId,
                'tanggal' => $tanggal,
                'status'  => $status,
            ];

            
            if ($existing) {
                $data['id'] = $existing['id'];
            }
            
            $absensiModel->save($data);
        }

       
        return redirect()->to('guru/absensi/' . $year . '/' . $month)
                         ->with('success', 'Absensi berhasil diperbarui.');
    }
    

}