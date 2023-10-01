<?php

namespace App\Models;

use CodeIgniter\Model;

class SensorModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sensor';
    protected $primaryKey       = 'id_sensor';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_device',
        'volt',
        'ampere',
        'watt',
        'kWh',
        'time_sensor',
        'updated_at'
    ];

    public function chart_database()
    {
        return $this->db->table('sensor')->get()->getResultArray();
    }

    public function get_chart_data()
    {
        return $this->db->table('sensor')
            ->join('devices', 'devices.id_device=sensor.id_device')
            ->get();
    }

    public function get_data()
    {
        $query = $this->select('ampere, watt, time_sensor');
        $builder = $query->get();
        $chartData = $builder->getResultArray();

        foreach ($chartData as $data) {
            $data['time_sensor'] = date('Y-m-d H:i:s', strtotime($data['time_sensor']));
        }

        return $chartData;
    }

    public function getFirstId()
    {
        return $this->select('id_sensor')->first();
    }


    // public function update_data($id, $value){
    //     $this->db->table('sensor')
    //     ->where('id_device', $id);
    //     ->set('')
    // }

    // public function chart_database()
    // {
    //     return $this->db->get('sensor')->result();
    // }

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'time_sensor';
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
