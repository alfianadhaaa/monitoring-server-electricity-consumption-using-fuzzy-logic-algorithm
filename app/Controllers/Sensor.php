<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DeviceModel;
use App\Models\ModelDetailSensor;
use App\Models\SensorModel;
use App\Models\ServerModel;

class Sensor extends BaseController
{
    protected $sensorModel;
    protected $detailSensor, $deviceModel;

    function __construct()
    {
        $this->sensorModel = new SensorModel();
        $this->detailSensor = new ModelDetailSensor();
        $this->deviceModel = new DeviceModel();
    }

    public function index()
    {
        //
        return "Sensor Controller";
    }

    public function construct_api($ip, $id)
    {

        $url = "http://$ip/sensor/$id";

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Add any additional cURL options as needed

        // Send the request
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            // Handle the error appropriately
        }

        // Close cURL
        curl_close($curl);

        // Process the response as needed
        // ...

        // Return a response or display it
        return $response;
    }

    public function get_data_sensor($ip_parameter, $type_parameter)
    {
        $id = "";

        $id_device = $this->deviceModel->getFirstId();

        try {
            if ($type_parameter == "voltage") {
                $id = "athom_smart_plug_v2_voltage";
            } else if ($type_parameter == "current") {
                $id = "athom_smart_plug_v2_current";
            } else if ($type_parameter == "watt") {
                $id = "athom_smart_plug_v2_energy";
            } else if ($type_parameter == "kwh") {
                $id = "athom_smart_plug_v2_total_daily_energy";
            }

            $data = $this->construct_api($ip_parameter, $id);
            $decoded = json_decode($data);

            $value = $decoded->state;

            $id_sensor = $this->sensorModel->getFirstId();

            if ($type_parameter == "voltage") {
                $data = [
                    "volt" => $value
                ];
            } else if ($type_parameter == "current") {
                $data = [
                    "ampere" => $value
                ];
            } else if ($type_parameter == "watt") {
                $data = [
                    "watt" => $value
                ];
            } else if ($type_parameter == "kwh") {
                $data = [
                    "kWh" => $value
                ];
            }

            $this->sensorModel->update($id_sensor, $data);

            echo $decoded->id;
            echo $decoded->state;
            $this->deviceModel->set('status', 'Online')->where('id_device', $id_device)->update();
        } catch (\Throwable $th) {
            // exit($th->getMessage());
            $this->deviceModel->set('status', 'Offline')->where('id_device', $id_device)->update();
            session()->setFlashdata('warning', 'Your Device is Offline');
        }
    }

    public function testChart()
    {
        $chartData = $this->sensorModel->get_data();

        $labels = array();
        $wattData = array();
        $ampereData = array();

        foreach ($chartData as $data) {
            // $data =[
            //     'time_sensor' => $labels[],
            //     'watt' => $wattData[],
            //     'ampere' => $ampereData[]
            // ];
            $labels[] = $data['time_sensor'];
            $wattData[] = $data['watt'];
            $ampereData[] = $data['ampere'];
        }

        $data = [
            'time_sensor' => json_encode($labels),
            'wattData' => json_encode($wattData),
            'ampereData' => json_encode($ampereData)
        ];
        // $data['time_sensor'] = json_encode($labels);
        // $data['wattData'] = json_encode($wattData);
        // $data['ampereData'] = json_encode($ampereData);

        // dd($data);
        return view('test', $data);
    }

    public function testChart2()
    {
        $chartData = $this->detailSensor->get_data();

        $labels = array();
        $wattData = array();
        $ampereData = array();

        foreach ($chartData as $data) {
            // $data =[
            //     'time_sensor' => $labels[],
            //     'watt' => $wattData[],
            //     'ampere' => $ampereData[]
            // ];
            $labels[] = $data['created_at'];
            $wattData[] = $data['watt'];
            $ampereData[] = $data['ampere'];
        }

        $data = [
            'time_sensor' => json_encode($labels),
            'wattData' => json_encode($wattData),
            'ampereData' => json_encode($ampereData)
        ];
        // $data['time_sensor'] = json_encode($labels);
        // $data['wattData'] = json_encode($wattData);
        // $data['ampereData'] = json_encode($ampereData);

        // dd($data);
        return view('test', $data);
    }

    public function insertData()
    {
        // // Mendapatkan waktu saat ini
        // $currentMinute = date('i');
        // $currentSecond = date('s');

        // // Memeriksa apakah waktu saat ini adalah menit ke 30 detik 0-1 atau menit 00 detik 0-1
        // if (($currentMinute === '30' && $currentSecond >= 0 && $currentSecond <= 1) || ($currentMinute === '00' && $currentSecond >= 0 && $currentSecond <= 1)) {
        // Mendapatkan data dari tabel sensor
        $sensorData = $this->sensorModel->findAll();

        // Memasukkan data ke tabel sensor_detail
        foreach ($sensorData as $sensor) {
            $data = [
                'id_sensor' => $sensor['id_sensor'],
                'watt' => $sensor['watt'],
                'ampere' => $sensor['ampere'],
                'volt' => $sensor['volt'],
                'kwh' => $sensor['kWh'],
            ];

            $this->detailSensor->insert($data);
            // $result = $this->detailSensor->insert($data);
            // echo json_encode($result);
        }

        // echo 'Data inserted successfully.';
        // }
        // else {
        //     echo 'No data inserted.';
        // }
        // dd($data);
    }
}
