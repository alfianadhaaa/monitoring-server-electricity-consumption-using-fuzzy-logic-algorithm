<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlertInfoModel;
use App\Models\AlertModel;
use App\Models\DetailAlertModel;
use App\Models\DeviceModel;
use App\Models\ModelDetailSensor;
use Dompdf\Dompdf;

define('_TITLE', 'Alert');

class Alert extends BaseController
{
    protected $alertModel, $deviceModel, $detailAlert, $detailSensor, $alertInfoModel;

    public function __construct()
    {
        $this->alertModel = new AlertModel();
        $this->deviceModel = new DeviceModel();
        $this->detailAlert = new DetailAlertModel();
        $this->detailSensor = new ModelDetailSensor();
        $this->alertInfoModel = new AlertInfoModel();
    }

    public function index($tglAwal = null, $tglAkhir = null)
    {
        $tgl1 = $tglAwal == null ? date('Y-m-01') : $tglAwal;
        $tgl2 = $tglAkhir == null ? date('Y-m-t') : $tglAkhir;
        $alert = $this->alertInfoModel->report($tgl1, $tgl2);

        $data = [
            'title' => _TITLE,
            'alert' => $alert,
            'tanggal' => [
                'tgl_awal' => $tgl1,
                'tgl_akhir' => $tgl2
            ]
        ];
        return view('content/alert/alert', $data);
    }

    public function filter()
    {
        $tglAwal = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');
        return $this->index($tglAwal, $tglAkhir);
    }

    public function exportPDF($tglAwal = null, $tglAkhir = null)
    {
        $tgl1 = $tglAwal == null ? date('Y-m-01') : $tglAwal;
        $tgl2 = $tglAkhir == null ? date('Y-m-t') : $tglAkhir;
        $alert = $this->alertInfoModel->report($tgl1, $tgl2);
        $detail = $this->detailSensor->deviceInformation($tgl1, $tgl2);

        $data = [
            'title' => _TITLE,
            'alert' => $alert,
            'information' => $detail,
            'tglAwal' => $tgl1,
            'tglAkhir' => $tgl2
        ];
        $view = view('content/alert/alert-pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);

        $dompdf->setPaper('A4', 'potrait');

        $dompdf->render();

        $filename = 'alert-report-' . $tgl1 . '-' . $tgl2;
        $dompdf->stream($filename, array('Attachment' => false));
    }

    function checkAlert()
    {
        if ($this->request->isAJAX()) {
            $idAlert =  $this->request->getVar('idAlert');
            $takeData = $this->deviceModel->getDevice($idAlert);

            $data = [
                'idAlert' => $idAlert,
                'device' => $takeData
            ];

            $msg = [
                'data' => view('content/modalAlert', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updateAlert($id)
    {

        $this->alertModel->updateStatus($id);

        session()->setFlashdata('message', 'Alert Successfully Checked');

        return redirect()->to('/');
    }

    function updatedata()
    {

        $id = $this->request->getPost('id');

        $this->alertModel->updateStatus($id);

        $this->alertInfoModel->Save([
            'id_alert' => $this->alertModel->getFirstId(),
            'id_device' => $this->deviceModel->getFirstId(),
            'volt' => $this->request->getPost('volt'),
            'type_alert' => $this->request->getPost('type_alert'),
            'ampere' => $this->request->getPost('ampere'),
            'status' => 'Checked'
        ]);

        session()->setFlashdata('message', 'The Device Has Been Checked');

        return $this->response->setJSON(['success' => 'The Device Has Been Checked']);
    }

    public function updateTypeAlert()
    {
        $data = $this->alertModel->updateStatusFromTypeAlert();
        echo json_encode($data);
    }

    public function insertData()
    {
        $alertData = $this->alertModel->findAll();

        foreach ($alertData as $alert) {
            $data = [
                'id_alert' => $alert['id_alert'],
                'id_device' => $alert['id_device'],
                'type_alert' => $alert['type_alert'],
                'status' => $alert['status'],
            ];

            $this->detailAlert->insert($data);
        }
    }
}
