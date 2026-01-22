<?php

namespace App\Repository\Sections;

use App\Interface\Sections\SectionRepositoryInterface;
use App\Models\Section;

class SectionRepository implements SectionRepositoryInterface
{

    public function index()
    {
        $sections = Section::all();
        return view('dashboard.sections.index', compact('sections'));
    }
    public function store($request)
    {
        Section::create($request->all());
        session()->flash('add');
        return redirect()->route('sections.index');
    }
    public function show($id)
    {
        $doctors = Section::findOrFail($id)->doctors;
        $section = Section::findOrFail($id);
        return view('dashboard.sections.show_doctors', compact('doctors', 'section'));
    }

    public function update($request)
    {
        $section = Section::findOrFail($request->id);
        $section->update($request->all());
        session()->flash('edit');
        return redirect()->route('sections.index');
    }

    public function destroy($request)
    {
        Section::findOrFail($request->id)->delete();
        session()->flash('delete');
        return redirect()->route('sections.index');
    }
}
