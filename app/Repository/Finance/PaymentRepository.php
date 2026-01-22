<?php


namespace App\Repository\Finance;

use App\Interface\Finance\PaymentRepositoryInterface;
use App\Models\FundAccount;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\PaymentAccount;
use Illuminate\Support\Facades\DB;

class PaymentRepository implements PaymentRepositoryInterface
{

    public function index()
    {
        $payments =  PaymentAccount::all();
        return view('dashboard.payment.index', compact('payments'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('dashboard.payment.add', compact('patients'));
    }

    public function show($id)
    {
        $payment_account = PaymentAccount::findorfail($id);
        return view('dashboard.payment.print', compact('payment_account'));
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            // إنشاء الحساب المالي للدفع
            $payment_accounts = PaymentAccount::create([
                'date' => now()->toDateString(),
                'patient_id' => $request->patient_id,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);

            // إنشاء الحساب المالي الرئيسي
            FundAccount::create([
                'date' => now()->toDateString(),
                'payment_id' => $payment_accounts->id,
                'credit' => $payment_accounts->amount,
                'debit' => 0.00,
            ]);

            // إنشاء حساب المريض
            PatientAccount::create([
                'date' => now()->toDateString(),
                'patient_id' => $request->patient_id,
                'payment_id' => $payment_accounts->id,
                'debit' => $payment_accounts->amount,
                'credit' => 0.00,
            ]);

            DB::commit();
            session()->flash('add');
            return redirect()->route('payment.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $payment_accounts = PaymentAccount::findorfail($id);
        $patients = Patient::all();
        return view('dashboard.payment.edit', compact('payment_accounts', 'patients'));
    }

    public function update($request)
    {
        DB::beginTransaction();

        try {
            // Update PaymentAccount
            $payment_accounts = PaymentAccount::findOrFail($request->id);
            $payment_accounts->update([
                'date' => now()->toDateString(),
                'patient_id' => $request->patient_id,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);

            // Update FundAccount if exists
            $fundAccount = FundAccount::where('payment_id', $payment_accounts->id)->first();
            if ($fundAccount) {
                $fundAccount->update([
                    'date' => now()->toDateString(),
                    'payment_id' => $payment_accounts->id,
                    'credit' => $payment_accounts->amount,
                    'debit' => 0.00,
                ]);
            }

            // Update PatientAccount if exists
            $patientAccount = PatientAccount::where('payment_id', $payment_accounts->id)->first();
            if ($patientAccount) {
                $patientAccount->update([
                    'date' => now()->toDateString(),
                    'patient_id' => $request->patient_id,
                    'payment_id' => $payment_accounts->id,
                    'debit' => $request->amount,
                    'credit' => 0.00,
                ]);
            }

            DB::commit();
            session()->flash('edit');
            return redirect()->route('payment.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            PaymentAccount::destroy($request->id);
            session()->flash('delete');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
