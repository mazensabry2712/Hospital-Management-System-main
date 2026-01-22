<?php

namespace App\Repository\Finance;

use App\Interface\Finance\ReceiptRepositoryInterface;
use App\Models\FundAccount;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\ReceiptAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReceiptRepository implements ReceiptRepositoryInterface
{

    public function index()
    {
        $receipts =  ReceiptAccount::all();
        return view('dashboard.receipt.index', compact('receipts'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('Dashboard.Receipt.add', compact('patients'));
    }

    public function show($id)
    {
        $receipt = ReceiptAccount::findorfail($id);
        return view('dashboard.receipt.print', compact('receipt'));
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            // 📝 حفظ بيانات سند القبض (ReceiptAccount)
            $receipt_account = ReceiptAccount::create([
                'date' => now()->toDateString(),
                'patient_id' => $request->patient_id,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
            // 💰 حفظ بيانات الحسابات المالية (FundAccount)
            FundAccount::create([
                'date' => now()->toDateString(),
                'receipt_id' => $receipt_account->id,
                'debit' => $request->amount,
                'credit' => 0.00,
            ]);
            // 🏥 حفظ بيانات حسابات المرضى (PatientAccount)
            PatientAccount::create([
                'date' => now()->toDateString(),
                'patient_id' => $request->patient_id,
                'receipt_id' => $receipt_account->id,
                'debit' => 0.00,
                'credit' => $request->amount,
            ]);
            DB::commit();
            session()->flash('add');
            return redirect()->route('receipt.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function edit($id)
    {
        $receipt_accounts = ReceiptAccount::findorfail($id);
        $patients = Patient::all();
        return view('dashboard.receipt.edit', compact('receipt_accounts', 'patients'));
    }

    public function update($request)
    {
        DB::beginTransaction();

        try {
            // 📝 تحديث بيانات سند القبض (ReceiptAccount)
            $receipt_account = ReceiptAccount::findOrFail($request->id);
            $receipt_account->update([
                'date' => now()->toDateString(),
                'patient_id' => $request->patient_id,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);

            // 💰 تحديث بيانات الحسابات المالية (FundAccount)
            $fund_account = FundAccount::where('receipt_id', $request->id)->firstOrFail();
            $fund_account->update([
                'date' => now()->toDateString(),
                'receipt_id' => $receipt_account->id,
                'debit' => $receipt_account->amount,
                'credit' => 0.00,
            ]);

            // 🏥 تحديث بيانات حسابات المرضى (PatientAccount)
            $patient_account = PatientAccount::where('receipt_id', $request->id)->firstOrFail();
            $patient_account->update([
                'date' => now()->toDateString(),
                'patient_id' => $request->patient_id,
                'receipt_id' => $receipt_account->id,
                'debit' => 0.00,
                'credit' => $receipt_account->amount,
            ]);

            DB::commit();
            session()->flash('edit');
            return redirect()->route('receipt.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            ReceiptAccount::destroy($request->id);
            session()->flash('delete');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
