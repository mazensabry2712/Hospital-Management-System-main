<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Interface\Ambulances\AmbulanceRepositoryInterface;
use Illuminate\Http\Request;

class AmbulanceController extends Controller
{
    private $ambulances;

    public function __construct(AmbulanceRepositoryInterface $ambulances)
    {
        $this->ambulances = $ambulances;
    }

    public function index()
    {
        return $this->ambulances->index();
    }


    public function create()
    {
        return $this->ambulances->create();
    }


    public function store(Request $request)
    {
        return $this->ambulances->store($request);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        return $this->ambulances->edit($id);
    }


    public function update(Request $request)
    {
        return $this->ambulances->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->ambulances->destroy($request);
    }

}
