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