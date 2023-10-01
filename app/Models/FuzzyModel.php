<?php

namespace App\Models;

use CodeIgniter\Model;

class FuzzyModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'fuzzy_logic';
    // protected $primaryKey       = 'id';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'v1',
        'v2',
        'v3',
        'a1',
        'a2',
        'a3',
        'defuzzifikasi',
        'status',
        'created_at',
        'updated_at'
    ];

    public function insertLastFuzzyLogicToAlertNotif()
    {
        $builder = $this->db->table('fuzzy_logic');

        $builder->select('*')
            ->where(function ($builder) {
                $builder->whereIn('status', ['Waspada', 'Ancaman', 'Darurat'])
                    ->orderBy('id', 'desc')
                    ->limit(1);
            });

        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            $data = $query->getRowArray();

            $this->db->table('alert_notif')->insert($data);
        }
    }

    public function getLastFuzzyLogicWithStatus()
    {
        return $this
            ->whereIn('status', ['Waspada', 'Ancaman', 'Darurat'])
            ->orderBy('created_at', 'desc') // Ganti 'tanggal' dengan kolom tanggal yang sesuai
            ->limit(1)
            ->get()
            ->getRow();
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
