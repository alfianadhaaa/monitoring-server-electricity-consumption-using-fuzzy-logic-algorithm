<?php

namespace App\Models;

use CodeIgniter\Model;

class AlertModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'alert';
    protected $primaryKey       = 'id_alert';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_device', 'type_alert', 'time_alert', 'status'];

    public function getAlertStatus()
    {
        return $this->db->table('alert')
            ->join('devices', 'devices.id_device=alert.id_device')
            ->where('alert.status', 'non_checked')
            ->get();
    }

    public function get_data()
    {
        return $this->db->table('alert')
            ->where('status', 'non_checked')
            ->get();
    }

    public function updateStatus($id)
    {
        $data = [
            'type_alert' => 'Normal',
            'status' => 'checked'
        ];
        return $this->set($data)
            ->where('id_alert', $id)
            ->update();
    }

    public function updateStatusFromTypeAlert()
    {
        $typeAlerts = ['Waspada', 'Ancaman', 'Darurat'];

        // Update kolom status di tabel alert
        return $this->whereIn('type_alert', $typeAlerts)
            // Menambahkan klausa where untuk memastikan status bukan 'non_checked'
            ->where('status !=', 'non_checked')
            ->set('status', 'non_checked')
            ->update();
    }

    public function updateTypeAlert($data)
    {
        return $this->set('type_alert', $data)->update();
    }

    public function getDataAlertDevice()
    {
        return $this->join('devices', 'devices.id_device=alert.id_device')->first();
    }

    public function totalAlerts()
    {
        return $this
            ->where('status', 'non_checked')
            ->countAllResults();
    }

    public function getFirstId()
    {
        return $this->select('id_alert')->first();
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
