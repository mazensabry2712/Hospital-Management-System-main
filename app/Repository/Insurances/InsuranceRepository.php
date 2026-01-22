<?php

namespace App\Repository\Insurances;

use App\Interface\Insurances\InsuranceRepositoryInterface;
use App\Models\Insurance;

class InsuranceRepository implements InsuranceRepositoryInterface
{

    public function index()
    {
        $insurances = Insurance::all();
        return view('dashboard.insurance.index', compact('insurances'));
    }
    public function create()
    {
        return view('dashboard.insurance.add');
    }
    public function edit($id)
    {
        $insurance = Insurance::findorfail($id);
        return view('dashboard.insurance.edit', compact('insurance'));
    }
    public function store($request)
    {
        try {
            Insurance::create($request->all());
            session()->flash('add');
            return redirect()->route('insurances.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function update($request)
    {
        try {
            $insurance = Insurance::findorfail($request->id);
            $insurance->update($request->all());
            session()->flash('edit');
            return redirect()->route('insurances.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function destroy($request)
    {
        $insurance = Insurance::findorfail($request->id);
        $insurance->delete();
        session()->flash('delete');
        return redirect()->route('insurances.index');
    }
}
