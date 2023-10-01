<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DeviceModel;

define('_TITLE', 'Devices');

class Device extends BaseController
{

    protected $deviceModel;

    function __construct()
    {
        $this->deviceModel = new DeviceModel();
    }

    public function index()
    {
        $devices = $this->deviceModel->findAll();

        $data = [
            'title' => _TITLE,
            'devices' => $devices
        ];
        // dd($data);
        return view('content/device', $data);
    }

    public function create()
    {
        $data = [
            'title' => _TITLE
        ];
        return view('content/create', $data);
    }

    public function save()
    {
        $this->deviceModel->save([
            'name' => $this->request->getVar('name'),
            'brand' => $this->request->getVar('brand'),
            'ip_address' => $this->request->getVar('ip_address')
        ]);

        session()->setFlashdata('message', 'Successfully Added Data');

        // return redirect()->to(view('content/device'));
        return redirect()->to('/device');
    }

    public function delete($id)
    {
        $this->deviceModel->delete($id);
        session()->setFlashdata('message', 'Successfully Deleted Data');
        return redirect()->to('/device');
    }

    public function edit($id)
    {
        $data = [
            'title' => _TITLE,
            'device' => $this->deviceModel->editDevice($id)
        ];
        // dd($data);
        return view('content/device/edit', $data);
    }

    public function update($id)
    {
        $this->deviceModel->save([
            'id_device' => $id,
            'name' => $this->request->getVar('name'),
            'brand' => $this->request->getVar('brand'),
            'ip_address' => $this->request->getVar('ip_address')
        ]);

        session()->setFlashdata('message', 'Data Successfully Changed');

        // return redirect()->to(view('content/device'));
        return redirect()->to('/device');
    }
}
