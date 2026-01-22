<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Interface\Insurances\InsuranceRepositoryInterface;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    private $insurances;

    public function __construct(InsuranceRepositoryInterface $insurances)
    {
        $this->insurances = $insurances;
    }
    public function index()
    {
        return $this->insurances->index();
    }


    public function create()
    {
        return $this->insurances->create();
    }


    public function store(Request $request)
    {
        return $this->insurances->store($request);
    }


    public function show($id)
    {
        //
    }


    public function edit($id) {
        return $this->insurances->edit($id);
    }


    public function update(Request $request)
    {
        return $this->insurances->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->insurances->destroy($request);
    }
}
