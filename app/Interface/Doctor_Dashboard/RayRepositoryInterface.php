<?php

namespace App\Interface\Doctor_Dashboard;

interface RayRepositoryInterface
{
    public function store($request);

    public function update($request, $id);

    public function destroy($id);
}
