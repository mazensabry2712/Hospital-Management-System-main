<?php

namespace App\Interface\Doctors;

interface DoctorRepositoryInterface
{
    public function index();
    public function create();
    public function edit($id);
    public function store($request);
    public function update($request);
    public function destroy($request);
    public function update_status($request);
    public function update_password($request);
}
