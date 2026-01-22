<?php

namespace App\Repository\Ambulances;

use App\Interface\Ambulances\AmbulanceRepositoryInterface;
use App\Models\Ambulance;

class AmbulanceRepository implements AmbulanceRepositoryInterface
{

    public function index()
    {
        $ambulances = Ambulance::all();
        return view('dashboard.ambulances.index', compact('ambulances'));
    }
    public function create()
    {
        return view('dashboard.ambulances.add');
    }
    public function edit($id)
    {
        $ambulance = Ambulance::findorfail($id);
        return view('dashboard.ambulances.edit', compact('ambulance'));
    }
    public function store($request)
    {
        // dd($request->all());
        try {
            Ambulance::create($request->all());
            session()->flash('add');
            return redirect()->route('ambulances.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function update($request)
    {
        try {
            $ambulance = Ambulance::findorfail($request->id);
            $ambulance->update($request->all());
            session()->flash('edit');
            return redirect()->route('ambulances.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function destroy($request)
    {
        try {
            $ambulance = Ambulance::findorfail($request->id);
            $ambulance->delete();
            session()->flash('delete');
            return redirect()->route('ambulances.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
