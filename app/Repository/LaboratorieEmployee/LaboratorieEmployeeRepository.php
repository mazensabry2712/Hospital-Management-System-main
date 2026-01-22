<?php

namespace App\Repository\LaboratorieEmployee;

use App\Interface\LaboratorieEmployee\LaboratorieEmployeeRepositoryInterface;
use App\Models\LaboratorieEmployee;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class LaboratorieEmployeeRepository implements LaboratorieEmployeeRepositoryInterface
{

    public function index()
    {
        $laboratorie_employees = LaboratorieEmployee::all();
        return view('dashboard.laboratorie_employee.index', compact('laboratorie_employees'));
    }

    public function store($request)
    {
        try {
            LaboratorieEmployee::create($request->all());
            session()->flash('add');
            return back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update($request, $id)
    {
        $ray_employee = LaboratorieEmployee::find($id);
        $ray_employee->update($request->all());
        session()->flash('edit');
        return redirect()->back();
    }

    public function destroy($id)
    {
        LaboratorieEmployee::destroy($id);
        session()->flash('delete');
        return redirect()->back();
    }
    public function update_password($request)
    {
        $laboratorie_employee = LaboratorieEmployee::findorfail($request->id);
        $laboratorie_employee->update([
            'password' => Hash::make($request->password)
        ]);
        session()->flash('edit');
        return redirect()->back();
    }
}
