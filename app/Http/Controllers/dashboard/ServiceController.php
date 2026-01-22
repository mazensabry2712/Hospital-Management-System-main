<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Interface\Services\ServiceRepositoryInterface;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private $services;

    public function __construct(ServiceRepositoryInterface $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        return $this->services->index();
    }
    public function store(Request $request)
    {
        return $this->services->store($request);
    }
    public function update(Request $request)
    {
        return $this->services->update($request);
    }
    public function destroy(Request $request)
    {
        return $this->services->destroy($request);
    }
}
