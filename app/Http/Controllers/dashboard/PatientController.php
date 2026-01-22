<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Interface\Patients\PatientRepositoryInterface;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private $patients;

    public function __construct(PatientRepositoryInterface $patients)
    {
        $this->patients = $patients;
    }

    public function index()
    {
        return $this->patients->index();
    }


    public function create()
    {
        return $this->patients->create();
    }


    public function store(Request $request)
    {
        return $this->patients->store($request);
    }


    public function show($id)
    {
        return $this->patients->show($id);
    }


    public function edit($id)
    {
        return $this->patients->edit($id);
    }


    public function update(Request $request)
    {
        return $this->patients->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->patients->destroy($request);
    }
}
