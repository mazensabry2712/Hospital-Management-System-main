<?php

namespace App\Repository\Services;

use App\Interface\Services\ServiceRepositoryInterface;
use App\Models\Section;
use App\Models\Service;

class ServiceRepository implements ServiceRepositoryInterface
{

    public function index()
    {
        $services = Service::all();
        return view('dashboard.Services.index', compact('services'));
    }
    public function store($request)
    {
        try {
            Service::create($request->all());
            session()->flash('add');
            return redirect()->route('services.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function update($request)
    {
        try {
            $service = Service::findOrFail($request->id);
            $service->update($request->all());
            session()->flash('edit');
            return redirect()->route('services.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function destroy($request)
    {
        Service::destroy($request->id);
        session()->flash('delete');
        return redirect()->route('services.index');
    }
}
