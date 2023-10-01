<?php

namespace App\Models;

use CodeIgniter\Model;

class AlertInfoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'alert_notif';
    // protected $primaryKey       = 'id';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_alert',
        'id_device',
        'volt',
        'ampere',
        'type_alert',
        'status',
        'time_alert',
        'updated_at'
    ];

    public function report($tglAwal, $tglAkhir)
    {
        return $this
            ->select('volt, ampere, type_alert, status, time_alert')
            ->where('date(time_alert) >=', $tglAwal)
            ->where('date(time_alert) <=', $tglAkhir)
            ->get()->getResultArray();
    }

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'time_alert';
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
