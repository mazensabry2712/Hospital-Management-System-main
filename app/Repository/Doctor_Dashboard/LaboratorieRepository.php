<?php

namespace App\Repository\Doctor_Dashboard;

use App\Interface\Doctor_Dashboard\LaboratorieRepositoryInterface;
use App\Models\Laboratorie;

class LaboratorieRepository implements LaboratorieRepositoryInterface
{

    public function store($request)
    {
        Laboratorie::create($request->all());
        session()->flash('add');
        return redirect()->back();
    }

    public function update($request, $id)
    {
        $Laboratorie = Laboratorie::findOrFail($id);
        $Laboratorie->update($request->all());
        session()->flash('edit');
        return redirect()->back();
    }

    public function destroy($id)
    {
        Laboratorie::destroy($id);
        session()->flash('delete');
        return redirect()->back();
    }
}
