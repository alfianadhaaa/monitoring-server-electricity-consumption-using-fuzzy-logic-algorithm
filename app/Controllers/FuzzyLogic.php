<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlertModel;
use App\Models\SensorModel;
use App\Models\FuzzyModel;

class FuzzyLogic extends BaseController
{
    protected $fuzzyModel, $sensorModel, $alertModel;

    public function __construct()
    {
        $this->fuzzyModel = new FuzzyModel();
        $this->sensorModel = new SensorModel();
        $this->alertModel = new AlertModel();
    }

    public function index()
    {

        $dataSensor = $this->sensorModel->findAll();

        foreach ($dataSensor as $s) {
            $inputVolt = $s['volt']; // Nilai volt yang ingin dinilai
            $inputAmpere = $s['ampere']; // Nilai ampere yang ingin dinilai
        }

        $VxA = $inputAmpere * $inputVolt;

        // Derajat keanggotaan Volt
        $voltRendah = $this->derajatKeanggotaanVoltRendah($inputVolt);
        $voltSedang = $this->derajatKeanggotaanVoltSedang($inputVolt);
        $voltTinggi = $this->derajatKeanggotaanVoltTinggi($inputVolt);


        // Derajat keanggotaan Ampere
        $ampereRendah = $this->derajatKeanggotaanAmpereRendah($inputAmpere);
        $ampereSedang = $this->derajatKeanggotaanAmpereSedang($inputAmpere);
        $ampereTinggi = $this->derajatKeanggotaanAmpereTinggi($inputAmpere);

        $voltXampere = ($voltRendah * $VxA) + ($voltSedang * $VxA) + ($voltTinggi * $VxA) + ($ampereRendah * $VxA) + ($ampereSedang * $VxA) + ($ampereTinggi * $VxA);

        $hasil = ($voltRendah) + ($voltSedang) + ($voltTinggi) + ($ampereRendah) + ($ampereSedang) + ($ampereTinggi);

        $countAll = $voltRendah + $voltSedang + $voltTinggi + $ampereRendah + $ampereSedang + $ampereTinggi;

        $fuzzifikasi = round($voltXampere / $countAll, 2);
        $fuzzifikasiBobot = $hasil / $countAll;

        $alert = $this->resultAlert($fuzzifikasi);

        // insert into fuzzy database
        $data = [
            'v1' => $voltRendah,
            'v2' => $voltSedang,
            'v3' => $voltTinggi,
            'a1' => $ampereRendah,
            'a2' => $ampereSedang,
            'a3' => $ampereTinggi,
            'defuzzifikasi' => $fuzzifikasi,
            'status' => $alert
        ];

        $result = $this->fuzzyModel->insert($data);
        // Update kolom type_alert di tabel alert jika $alert adalah "waspada", "ancaman", atau "darurat"
        $getID = $this->alertModel->getFirstId();
        if ($alert === 'Waspada' || $alert === 'Ancaman' || $alert === 'Darurat') {
            $this->alertModel->where('id_alert', $getID) // Sesuaikan dengan kondisi update yang sesuai
                ->set('type_alert', $alert)
                ->set('status', 'non_checked')
                ->update();
        }
        echo json_encode($result);
    }

    private function derajatKeanggotaanVoltRendah($volt)
    {
        if ($volt >= 200 && $volt <= 210) {
            return round(($volt - 200) / (210 - 200), 1);
        } elseif ($volt > 210 && $volt <= 220) {
            return round((220 - $volt) / (220 - 210), 1);
        } else {
            return 0;
        }
    }

    private function derajatKeanggotaanVoltSedang($volt)
    {
        if ($volt >= 220 && $volt <= 230) {
            return round(($volt - 220) / (230 - 220), 1);
        } elseif ($volt > 230 && $volt <= 240) {
            return round((240 - $volt) / (240 - 230), 1);
        } else {
            return 0;
        }
    }

    private function derajatKeanggotaanVoltTinggi($volt)
    {
        if ($volt >= 230) {
            return 1;
        } elseif ($volt > 240) {
            return round(($volt - 240) / (240 - 230), 1);
        } else {
            return 0;
        }
    }

    private function derajatKeanggotaanAmpereRendah($ampere)
    {
        if ($ampere >= 0 && $ampere <= 3) {
            return round(($ampere - 0) / (3 - 0), 1);
        } elseif ($ampere > 3 && $ampere <= 5) {
            return round((5 - $ampere) / (5 - 3), 1);
        } else {
            return 0;
        }
    }

    private function derajatKeanggotaanAmpereSedang($ampere)
    {
        if ($ampere >= 4 && $ampere <= 7) {
            return round(($ampere - 4) / (7 - 4), 1);
        } elseif ($ampere > 7 && $ampere <= 10) {
            return round((10 - $ampere) / (10 - 7), 1);
        } else {
            return 0;
        }
    }

    private function derajatKeanggotaanAmpereTinggi($ampere)
    {
        if ($ampere > 8) {
            return 1;
        } elseif ($ampere > 10) {
            return round(($ampere - 10) / (14 - 10), 1);
        } else {
            return 0;
        }
    }

    private function resultAlert($defuzzification)
    {
        if ($defuzzification >= 1000 && $defuzzification <= 1400) {
            return "Waspada";
        } elseif ($defuzzification > 1400 && $defuzzification <= 2000) {
            return "Ancaman";
        } elseif ($defuzzification > 2000) {
            return "Darurat";
        } else {
            return "Normal";
        }
    }

    public function updateAlertType()
    {
        $getID = $this->alertModel->getFirstId();
        // Ambil data terakhir pada kolom 'status' di tabel 'fuzzy_logic'
        $query = $this->fuzzyModel
            ->select('status')
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->get();

        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            $status = $row->status;

            $result = [
                'type_alert' => $status,
                'status' => 'non_checked'
            ];
            // Perbarui data pada kolom 'type_alert' di tabel 'alert'
            $this->alertModel
                ->update($getID, $result);
        }
    }
}
