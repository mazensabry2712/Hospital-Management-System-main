<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use App\Interface\Doctor_Dashboard\DiagnosisRepositoryInterface;
use Illuminate\Http\Request;

class DiagnosticController extends Controller
{
    private $diagnosis;

    public function __construct(DiagnosisRepositoryInterface $diagnosis)
    {
        $this->diagnosis = $diagnosis;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        return $this->diagnosis->store($request);
    }

    public function addReview(Request $request)
    {
        return $this->diagnosis->addReview($request);
    }


    public function show($id)
    {
        return $this->diagnosis->show($id);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
