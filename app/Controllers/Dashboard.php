<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlertModel;
use App\Models\SensorModel;
use App\Models\DeviceModel;
use App\Models\ModelDetailSensor;

define('_TITLE', 'Dashboard');

class Dashboard extends BaseController
{
    // Total Device, Total Online, Total Alert
    protected $sensorModel;
    protected $alertModel;
    protected $modelDevice, $detailSensorModel;

    public function __construct()
    {
        $this->sensorModel = new SensorModel();
        $this->alertModel = new AlertModel();
        $this->modelDevice = new DeviceModel();
        $this->detailSensorModel = new ModelDetailSensor();
    }

    public function index()
    {
        $sensor = $this->sensorModel->get_chart_data()->getResultArray();
        $device = $this->modelDevice->findAll();
        $alert = $this->alertModel->getAlertStatus()->getResultArray();

        $data = [
            'title' => _TITLE,
            'totalDevices' => $this->modelDevice->totalDevices(),
            'totalAlerts' => $this->alertModel->totalAlerts(),
            'status' => $this->modelDevice->totalOnline(),
            'sensor' => $sensor,
            'alerts' => $alert,
            'device' => $device
        ];
        if (!empty($alert)) {
            session()->setFlashdata('danger', 'There are devices to check...!!!');
        }
        $this->chartDashboard();
        return view('content/dashboard', $data);
    }

    public function monitoring()
    {
        return view('content/monitoring');
    }

    public function device()
    {
        return view('content/device');
    }

    public function tesChart()
    {
        $dataChart = $this->sensorModel->chart_database();
        $data["data"] = json_encode($dataChart);
        return view('test', $data);
    }

    public function chart_data()
    {
        $data = $this->sensorModel->chart_database();
        echo json_encode($data);
    }

    public function showAlert($id)
    {
        $model_data = $this->modelDevice->getDevice($id);

        $data = [
            'device' => $model_data,
        ];
        return view('content/modal', $data);
    }

    public function chartDashboard()
    {
        $endDate = date('Y-m-d', strtotime('yesterday'));
        $startDate = date('Y-m-d', strtotime('-7 days', strtotime($endDate)));

        $data = $this->detailSensorModel->getKwhByDateRange($startDate, $endDate);

        $kwhDifferences = [];
        $labels = [];

        $previousKwh = null;
        $maxKwh = null;
        $minKwh = null;

        foreach ($data as $row) {
            $tanggal = date('d', strtotime($row['created_at']));
            $kwh = $row['kwh'];

            if ($previousKwh !== null) {
                if ($kwh > $maxKwh || $maxKwh === null) {
                    $maxKwh = $kwh;
                }

                if ($kwh < $minKwh || $minKwh === null) {
                    $minKwh = $kwh;
                }

                if (date('d', strtotime($previousKwh['created_at'])) !== $tanggal) {
                    $kwhDifference = round(($maxKwh - $minKwh), 3);
                    $kwhDifferences[] = $kwhDifference;
                    $labels[] = date('d', strtotime($previousKwh['created_at']));
                    $maxKwh = null;
                    $minKwh = null;
                }
            }

            $previousKwh = $row;
        }

        $kwhDifference = round(($maxKwh - $minKwh), 3);
        $kwhDifferences[] = $kwhDifference;
        $labels[] = date('d', strtotime($previousKwh['created_at']));

        $chartData = [
            'labels' => $labels,
            'kwh' => $kwhDifferences,
        ];
        return view('test', $chartData);
    }
}
