<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Interface\RayEmployee\RayEmployeeRepositoryInterface;
use Illuminate\Http\Request;

class RayEmployeeController extends Controller
{
    private $employee;

    public function __construct(RayEmployeeRepositoryInterface $employee)
    {
        $this->employee = $employee;
    }


    public function index()
    {
        return $this->employee->index();
    }



    public function store(Request $request)
    {
        return $this->employee->store($request);
    }



    public function update(Request $request, $id)
    {
        return $this->employee->update($request, $id);
    }


    public function destroy($id)
    {
        return $this->employee->destroy($id);
    }
    public function update_password(Request $request)
    {

        return $this->employee->update_password($request);
    }
}
