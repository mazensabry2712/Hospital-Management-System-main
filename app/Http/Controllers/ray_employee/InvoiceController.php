<?php

namespace App\Http\Controllers\ray_employee;

use App\Http\Controllers\Controller;
use App\Interface\Dashboard_Ray_Employee\InvoicesRepositoryInterface;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    private $ray_employee;

    public function __construct(InvoicesRepositoryInterface $ray_employee)
    {
        $this->ray_employee = $ray_employee;
    }

    public function index()
    {
        return $this->ray_employee->index();
    }

    public function completed_invoices()
    {
        return $this->ray_employee->completed_invoices();
    }


    public function edit($id)
    {
        return $this->ray_employee->edit($id);
    }

    public function viewRays($id)
    {
        return $this->ray_employee->view_rays($id);
    }


    public function update(Request $request, $id)
    {
        return $this->ray_employee->update($request, $id);
    }


    public function destroy($id)
    {
        //
    }
}
