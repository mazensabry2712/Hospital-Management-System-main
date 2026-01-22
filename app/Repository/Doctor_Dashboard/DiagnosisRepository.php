<?php

namespace App\Repository\Doctor_Dashboard;

use App\Interface\doctor_dashboard\DiagnosisRepositoryInterface;
use App\Models\Diagnostic;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class DiagnosisRepository implements DiagnosisRepositoryInterface
{
    public function store($request)
    {

        DB::beginTransaction();

        try {
            // تحديث حالة الفاتورة
            $invoice_status = Invoice::findorfail($request->invoice_id);
            $invoice_status->update(['invoice_status' => 3,]);

            // إنشاء التشخيص
            Diagnostic::create([
                'date' => now()->toDateString(),
                'diagnosis' => $request->diagnosis,
                'medicine' => $request->medicine,
                'invoice_id' => $request->invoice_id,
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
            ]);

            DB::commit();

            // Flash message
            session()->flash('add', 'تمت إضافة التشخيص بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $patient_records = Diagnostic::where('patient_id', $id)->get();
        return view('Dashboard.Doctor.invoices.patient_record', compact('patient_records'));
    }

    public function addReview($request)
    {
        DB::beginTransaction();
        try {

            // تحديث حالة الفاتورة
            $invoice_status = Invoice::findorfail($request->invoice_id);
            $invoice_status->update(['invoice_status' => 2,]);

            // إنشاء التشخيص
            Diagnostic::create([
                'date' => now()->toDateString(),
                'review_date' => $request->review_date,
                'diagnosis' => $request->diagnosis,
                'medicine' => $request->medicine,
                'invoice_id' => $request->invoice_id,
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
            ]);

            DB::commit();
            session()->flash('add');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    // public function invoice_status($invoice_id,$id_status){
    //     $invoice_status = Invoice::findorFail($invoice_id);
    //     $invoice_status->update([
    //         'invoice_status'=>$id_status
    //     ]);
    // }
}
