<?php

namespace App\Repository\Doctor_Dashboard;

use App\Interface\doctor_dashboard\RayRepositoryInterface;
use App\Models\Ray;

class RayRepository implements RayRepositoryInterface
{

    public function store($request)
    {
        Ray::create($request->all());
        session()->flash('add');
        return redirect()->back();
    }

    public function update($request, $id)
    {
        $Ray = Ray::findOrFail($id);
        $Ray->update($request->all());
        session()->flash('edit');
        return redirect()->back();
    }

    public function destroy($id)
    {
        Ray::destroy($id);
        session()->flash('delete');
        return redirect()->back();
    }
}
