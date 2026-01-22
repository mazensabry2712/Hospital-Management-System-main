<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Interface\Doctors\DoctorRepositoryInterface;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    private $doctors;

    public function __construct(DoctorRepositoryInterface $doctors)
    {
        $this->doctors = $doctors;
    }

    public function index()
    {
        return $this->doctors->index();
    }


    public function create()
    {
        return $this->doctors->create();
    }


    public function store(Request $request)
    {
        return $this->doctors->store($request);
    }

    public function edit($id)
    {
        return $this->doctors->edit($id);
    }


    public function update(Request $request)
    {
        return $this->doctors->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->doctors->destroy($request);
    }

    public function update_status(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|in:0,1',
        ]);
        return $this->doctors->update_status($request);
    }
    public function update_password(Request $request)
    {

        return $this->doctors->update_password($request);
    }
}
