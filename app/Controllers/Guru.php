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
        // Cek apakah guru
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

        $userModel = new UserModel();
        $jadwalModel = new JadwalModel();
        $tugasModel = new TugasModel();

        $siswa = $userModel->find($id);
        if (!$siswa || $siswa['role'] != 'ortu') {
            return redirect()->to('/guru/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        $jadwal = $jadwalModel->where('user_id', $id)->findAll();
        $tugas = $tugasModel->where('user_id', $id)->findAll();

        return view('guru/detail_siswa', [
            'siswa' => $siswa,
            'jadwal' => $jadwal,
            'tugas' => $tugas
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
        $tugasModel = new TugasModel();
        $id = $this->request->getPost('id');

        $data = [
            'status' => $this->request->getPost('status')
        ];

        // upload file jika ada
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/', $newName);
            $data['file_bukti'] = $newName;
        }

        $tugasModel->update($id, $data);
        return redirect()->back()->with('success', 'Tugas berhasil diperbarui');
    }

    public function absensi()
    {
        if (session('role') != 'guru') return redirect()->to('/');

        $userModel = new UserModel();
        $siswa = $userModel->where('role', 'ortu')->findAll();

        return view('guru/absensi', ['siswa' => $siswa]);
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

}