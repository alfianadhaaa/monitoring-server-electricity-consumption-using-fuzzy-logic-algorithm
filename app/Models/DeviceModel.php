<?php

namespace App\Models;

use CodeIgniter\Model;

class DeviceModel extends Model
{

    protected $DBGroup          = 'default';
    protected $table            = 'devices';
    protected $primaryKey       = 'id_device';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'brand', 'ip_address', 'status'];

    public function getDevice($id)
    {
        return $this->where('devices.id_device', $id)
            ->join('sensor', 'sensor.id_device=devices.id_device')
            ->join('alert', 'alert.id_device=devices.id_device')
            ->first();
    }

    public function editDevice($id)
    {
        return $this->select('*')
            ->where('devices.id_device', $id)
            ->first();
    }

    public function getDeviceSensor()
    {
        return $this
            ->join('sensor', 'sensor.id_device=devices.id_device')
            ->first();
    }

    public function totalDevices()
    {
        return $this->db->table('devices')->countAll();
    }

    public function getFirstId()
    {
        return $this->select('id_device')->first();
    }

    public function totalOnline()
    {
        return $this->where('status', 'Online')
            ->countAllResults();
    }

    public function getStatusByID($id)
    {
        return $this->where('id_device', $id)->first()['status'];
    }


    // Dates
    protected $useTimestamps = false;
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
