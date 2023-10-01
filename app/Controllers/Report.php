<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DeviceModel;
use App\Models\ModelDetailSensor;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

define('_TITLE', 'Report');

class Report extends BaseController
{
    protected $deviceModel, $detailSensor;

    public function __construct()
    {
        $this->deviceModel = new DeviceModel();
        $this->detailSensor = new ModelDetailSensor();
    }

    public function index($tglAwal = null, $tglAkhir = null)
    {
        // $idDevice = $this->deviceModel->getFirstId();
        // $takeData = $this->deviceModel->getDevice($idDevice);
        $tgl1 = $tglAwal == null ? date('Y-m-01') : $tglAwal;
        $tgl2 = $tglAkhir == null ? date('Y-m-t') : $tglAkhir;

        $dataReport = $this->detailSensor->report($tgl1, $tgl2);
        $data = [
            'title' => 'monitoring',
            'device' => $dataReport,
            'tanggal' => [
                'tgl_awal' => $tgl1,
                'tgl_akhir' => $tgl2
            ]
        ];
        // dd($data);
        return view('content/report/report', $data);
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
        $report = $this->detailSensor->report($tgl1, $tgl2);
        $detail = $this->detailSensor->deviceInformation($tgl1, $tgl2);

        $data = [
            'title' => _TITLE,
            'device' => $report,
            'information' => $detail,
            'tglAwal' => $tgl1,
            'tglAkhir' => $tgl2
        ];
        // dd($data);
        $view = view('content/report/view-pdf', $data);

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'potrait');

        // Render the HTML as PDF
        $dompdf->render();

        $filename = 'monitoring-report-' . $tgl1 . 's/d' . $tgl2;
        // Output the generated PDF to Browser
        $dompdf->stream($filename, array('Attachment' => false));
    }

    public function exportExcel($tglAwal = null, $tglAkhir = null)
    {
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'No');
        $activeWorksheet->setCellValue('B1', 'Ampere');
        $activeWorksheet->setCellValue('C1', 'Volt');
        $activeWorksheet->setCellValue('D1', 'Watt');
        $activeWorksheet->setCellValue('E1', 'kWh');
        $activeWorksheet->setCellValue('F1', 'Time');

        $row = 2;
        $tgl1 = $tglAwal == null ? date('Y-m-01') : $tglAwal;
        $tgl2 = $tglAkhir == null ? date('Y-m-t') : $tglAkhir;
        $filename = 'monitoring-report-' . $tgl1 . 's/d' . $tgl2 . '.xlsx';
        $report = $this->detailSensor->report($tgl1, $tgl2);
        foreach ($report as $key => $data) {
            $activeWorksheet->setCellValue('A' . $row, $key + 1)
                ->setCellValue('B' . $row, $data['ampere'])
                ->setCellValue('C' . $row, $data['volt'])
                ->setCellValue('D' . $row, $data['watt'])
                ->setCellValue('E' . $row, $data['kwh'])
                ->setCellValue('F' . $row, $data['created_at']);
            $row++;
        };

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control-: max-age=0');

        $writer->save('php://output');
    }

    public function chart($tgl = null)
    {
        $tgl = $tgl == null ? date('d-m-Y') : $tgl;
        $chartData = $this->detailSensor->getChartReport($tgl);
        $device = $this->deviceModel->findAll();

        // $detail = $this->detailSensor->deviceInformation($tgl1, $tgl2);

        $labels = array();
        $kwhData = array();
        $wattData = array();
        $ampereData = array();
        $voltData = array();

        foreach ($chartData as $data) {
            $labels[] = $data['created_at'];
            $kwhData[] = $data['kwh'];
            $wattData[] = $data['watt'];
            $ampereData[] = $data['ampere'];
            $voltData[] = $data['volt'];
        }

        $data = [
            'title' => 'Chart',
            'device' => $device,
            'tanggal' => $tgl,
            'time_sensor' => json_encode($labels),
            'kwhData' => json_encode($kwhData),
            'ampereData' => json_encode($ampereData),
            'voltData' => json_encode($voltData),
            'wattData' => json_encode($wattData),
        ];
        // dd($data);
        return view('content/report/chart-report', $data);
    }

    public function filterChart()
    {
        $tgl = $this->request->getVar('tgl');
        return $this->chart($tgl);
    }
}
