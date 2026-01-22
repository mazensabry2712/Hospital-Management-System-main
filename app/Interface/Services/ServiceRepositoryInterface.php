<?php

namespace App\Interface\Services;

interface ServiceRepositoryInterface
{
    public function index();
    public function store($request);
    public function update($request);
    public function destroy($request);
}
