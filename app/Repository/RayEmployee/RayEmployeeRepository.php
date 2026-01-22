<?php

namespace App\Repository\RayEmployee;

use App\Interface\RayEmployee\RayEmployeeRepositoryInterface;
use App\Models\RayEmployee;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class RayEmployeeRepository implements RayEmployeeRepositoryInterface
{

    public function index()
    {
        $ray_employees = RayEmployee::all();
        return view('dashboard.ray_employee.index', compact('ray_employees'));
    }

    public function store($request)
    {
        RayEmployee::create($request->all());
        session()->flash('add');
        return back();
    }

    public function update($request, $id)
    {
        $ray_employee = RayEmployee::findorfail($id);
        $ray_employee->update($request->all());
        session()->flash('edit');
        return redirect()->back();
    }

    public function destroy($id)
    {
        RayEmployee::destroy($id);
        session()->flash('delete');
        return redirect()->back();
    }



    public function update_password($request)
    {
        $rayemployee = RayEmployee::findorfail($request->id);
        $rayemployee->update([
            'password' => Hash::make($request->password)
        ]);
        session()->flash('edit');
        return redirect()->back();
    }
}
