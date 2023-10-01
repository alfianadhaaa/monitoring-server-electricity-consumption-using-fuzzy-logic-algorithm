<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlertModel;
use App\Models\DeviceModel;
use App\Models\ModelDetailSensor;
use App\Models\SensorModel;

define('_TITLE', 'Monitoring');

class Monitoring extends BaseController
{
    protected $sensorModel, $detailSensor, $alertModel, $deviceModel;
    private $emailNotificationSent = false;

    public function __construct()
    {
        $this->sensorModel = new SensorModel();
        $this->detailSensor = new ModelDetailSensor();
        $this->alertModel = new AlertModel();
        $this->deviceModel = new DeviceModel();
    }

    public function index()
    {
        $sensor = $this->sensorModel->get_chart_data()->getResultArray();
        $chartData = $this->detailSensor->get_data();
        $id = $this->deviceModel->getFirstId();
        $status = $this->deviceModel->getStatusByID($id);

        // Menampilkan Alert Checking
        $alert = $this->alertModel->getAlertStatus()->getResultArray();
        if (!empty($alert) && !$this->emailNotificationSent) {
            session()->setFlashdata('danger', 'There are devices to check...!!!');

            // // Panggil fungsi untuk mengirim notifikasi email
            // $this->sendNotificationEmail();

            // // Set flag emailNotificationSent ke true agar notifikasi email hanya dikirim sekali
            // $this->emailNotificationSent = true;
        }

        $labels = array();
        $wattData = array();
        $kwhData = array();
        $voltData = array();

        foreach ($chartData as $data) {
            $labels[] = $data['created_at'];
            $wattData[] = $data['watt'];
            $kwhData[] = $data['kwh'];
            $voltData[] = $data['volt'];
        }

        $data = [
            'title' => _TITLE,
            'sensor' => $sensor,
            'alert' => $alert,
            'time_sensor' => json_encode($labels),
            'wattData' => json_encode($wattData),
            'kwhData' => json_encode($kwhData),
            'voltData' => json_encode($voltData)
        ];
        // dd($data);
        if ($status === 'Offline') {
            return view('content/device-offline', $data);
        } else {
            // Tampilkan view normal jika "Online" atau status tidak valid
            return view('content/monitoring', $data);
        }
        // return view('content/monitoring', $data);
    }


    public function test_query()
    {
        $sensor = $this->sensorModel->get_chart_data()->getResultArray();
        $data = [
            'sensor' => $sensor
        ];

        dd($data);
    }

    public function realTimeChart()
    {
        $chartData = $this->detailSensor->get_data();

        $labels = array();
        $wattData = array();
        $kwhData = array();

        foreach ($chartData as $data) {
            $labels[] = $data['created_at'];
            $wattData[] = $data['watt'];
            $kwhData[] = $data['kwh'];
        }

        $data = [
            'time_sensor' => $labels,
            'wattData' => $wattData,
            'kwhData' => $kwhData
        ];
        // dd($data);
        return json_encode($data);
    }

    public function sendNotificationEmail()
    {
        // Memuat library Email CodeIgniter
        $email = \Config\Services::email();

        // Pengaturan email
        $fromEmail = 'monitoringlistrik03@gmail.com'; // Ganti dengan alamat email pengirim
        $fromName = 'Monitoring Listrik'; // Ganti dengan nama pengirim
        $toEmail = 'monitoringlistrik03@gmail.com'; // Ganti dengan alamat email penerima
        $subject = 'Checking Server'; // Subjek email
        $message = 'There are devices to check...!!!'; // Isi email

        // Mengatur email pengirim
        $email->setFrom($fromEmail, $fromName);

        // Mengatur email penerima
        $email->setTo($toEmail);

        // Mengatur subjek dan isi email
        $email->setSubject($subject);
        $email->setMessage($message);

        // Mengirim email
        if ($email->send()) {
            session()->setFlashdata('success', 'Email Berhasil Terkirim');
        } else {
            echo 'Gagal mengirim email. Error: ' . $email->printDebugger();
        }
    }
}
