<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\TugasModel;

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
            $tugasMapel[strtolower($t['mapel'])] = true;
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
        $hari = $this->request->getPost('hari');
        $mapel = strtolower(trim($this->request->getPost('mapel'))); // lowercase utk validasi

        // Cek duplikat mapel di hari yang sama
        $existing = $jadwalModel->where([
            'user_id' => $userId,
            'hari' => $hari,
            'mapel' => $mapel
        ])->first();

        if ($existing) {
            return redirect()->back()->with('error', "Mapel '$mapel' sudah ada pada hari $hari.");
        }

        $jadwalModel->save([
            'user_id' => $userId,
            'hari' => $hari,
            'mapel' => $mapel
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
        $filename = $tugas['file'] ?? null;

        $data = [
            'mapel' => $this->request->getPost('mapel'),
            'deadline' => $this->request->getPost('deadline'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        $tugasModel->update($id, $data);


        return redirect()->to('/ortu/tugas');
    }



}