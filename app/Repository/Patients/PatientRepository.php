<?php

namespace App\Repository\Patients;

use App\Interface\Patients\PatientRepositoryInterface;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\ReceiptAccount;


class PatientRepository implements PatientRepositoryInterface
{

    public function index()
    {
        $patients = Patient::all();
        return view('dashboard.patients.index', compact('patients'));
    }
    public function create()
    {
        return view('dashboard.patients.add');
    }
    public function edit($id)
    {
        $patient = Patient::findorfail($id);
        return view('dashboard.patients.edit', compact('patient'));
    }
    public function show($id)
    {
        $patient = patient::findorfail($id);
        $invoices = Invoice::where('patient_id', $id)->get();
        $receipt_accounts = ReceiptAccount::where('patient_id', $id)->get();
        $patient_accounts = PatientAccount::where('patient_id', $id)->get();

        return view('dashboard.patients.show', compact('patient', 'invoices', 'receipt_accounts', 'patient_accounts'));
    }
    public function store($request)
    {
        try {
            Patient::create($request->all());
            session()->flash('add');
            return redirect()->route('patients.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function update($request)
    {
        try {
            $patient = Patient::findorfail($request->id);
            $patient->update($request->all());
            session()->flash('edit');
            return redirect()->route('patients.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function destroy($request)
    {
        try {
            $Patient = Patient::findorfail($request->id);
            $Patient->delete();
            session()->flash('delete');
            return redirect()->route('patients.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
