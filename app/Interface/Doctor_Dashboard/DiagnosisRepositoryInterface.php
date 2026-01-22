<?php

namespace App\Interface\Doctor_Dashboard;

interface DiagnosisRepositoryInterface
{
    public function store($request);

    public function show($id);

    public function addReview($request);
}
