<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailSensor extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sensor_detail';
    // protected $primaryKey       = 'id_sensor';
    // protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_sensor',
        'watt',
        'ampere',
        'volt',
        'kwh',
        'created_at',
        'updated_at'
    ];

    public function get_data()
    {
        $today = date('Y-m-d');

        $query = $this->select('kwh, watt, volt, created_at')
            ->where('DATE(created_at)', $today) // Menambahkan kondisi WHERE untuk memfilter berdasarkan tanggal
            ->groupStart()
            // ->where('MINUTE(created_at)', 0)
            // ->where('SECOND(created_at)', 0)
            // ->where('MINUTE(created_at)', 30)
            ->where('SECOND(created_at)', 1)
            ->groupEnd();

        $builder = $query->get();
        $chartData = $builder->getResultArray();

        foreach ($chartData as $data) {
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($data['created_at']));
        }

        return $chartData;
    }

    public function report($tglAwal, $tglAkhir)
    {
        return $this->join('sensor', 'sensor.id_sensor=sensor_detail.id_sensor')
            ->join('devices', 'devices.id_device=sensor.id_device')
            ->select('sensor_detail.id_sensor, devices.name, devices.ip_address, sensor_detail.watt, sensor_detail.ampere, sensor_detail.volt, sensor_detail.kwh, sensor_detail.created_at')
            ->where('SECOND(sensor_detail.created_at)', 0)
            ->where('date(sensor_detail.created_at) >=', $tglAwal)
            ->where('date(sensor_detail.created_at) <=', $tglAkhir)
            ->get()->getResultArray();
    }

    public function deviceInformation($tglAwal, $tglAkhir)
    {
        return $this->join('sensor', 'sensor.id_sensor=sensor_detail.id_sensor')
            ->join('devices', 'devices.id_device=sensor.id_device')
            ->select('devices.name, devices.ip_address, devices.brand')
            ->where('SECOND(sensor_detail.created_at)', 0)
            ->where('date(sensor_detail.created_at) >=', $tglAwal)
            ->where('date(sensor_detail.created_at) <=', $tglAkhir)
            ->groupBy('devices.id_device')
            ->get()->getResultArray();
    }

    public function getChartReport($tgl)
    {

        $query = $this->select('ampere, watt, volt, kwh, created_at')
            ->where('DATE(created_at)', $tgl) // Menambahkan kondisi WHERE untuk memfilter berdasarkan tanggal
            ->groupStart()
            // ->where('MINUTE(created_at)', 0)
            // ->where('SECOND(created_at)', 0)
            // ->where('MINUTE(created_at)', 30)
            ->where('SECOND(created_at)', 1)
            ->groupEnd();

        $builder = $query->get();
        $chartData = $builder->getResultArray();

        foreach ($chartData as $data) {
            $data['created_at'] = date('H:i', strtotime($data['created_at']));
        }

        return $chartData;
    }

    public function getKwhByDateRange($startDate, $endDate)
    {
        return $this->select('created_at, kwh')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDate)
            ->findAll();
    }

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
