<?php

namespace App\Http\Livewire;

use App\Events\CreateInvoice;
use App\Models\Doctor;
use App\Models\FundAccount;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\SectionTranslation;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class SingleInvoices extends Component
{

    public $InvoiceSaved;
    public $InvoiceUpdated;
    public $show_table = true;
    public $username;
    public $tax_rate = 17;
    public $updateMode = false;
    public $price, $discount_value = 0, $patient_id, $doctor_id, $section_id, $type, $service_id, $single_invoice_id, $catchError;

    // public function mount()
    // {
    //     $this->username = auth()->user()->name;
    // }

    public function render()
    {
        return view('livewire.SingleInvoices.single-invoices', [
            'single_invoices' => Invoice::where('invoice_type', 1)->get(),
            'patients' => Patient::all(),
            'doctors' => Doctor::all(),
            'services' => Service::all(),
            'subtotal' => $Total_after_discount = ((is_numeric($this->price) ? $this->price : 0)) - ((is_numeric($this->discount_value) ? $this->discount_value : 0)),
            'tax_value' => $Total_after_discount * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100)
        ]);
    }
    public function show_form_add()
    {
        $this->show_table = false;
    }

    public function get_section()
    {
        $doctor_id = Doctor::with('section')->where('id', $this->doctor_id)->first();
        $this->section_id = $doctor_id->section->name;
    }

    public function get_price()
    {
        $this->price = Service::where('id', $this->service_id)->first()->price;
    }

    public function edit($id)
    {
        $this->show_table = false;
        $this->updateMode = true;
        $single_invoice = Invoice::findorfail($id);
        $this->single_invoice_id = $single_invoice->id;
        $this->patient_id = $single_invoice->patient_id;
        $this->doctor_id = $single_invoice->doctor_id;
        $this->section_id = DB::table('section_translations')->where('id', $single_invoice->section_id)->first()->name;
        $this->service_id = $single_invoice->service_id;
        $this->price = $single_invoice->price;
        $this->discount_value = $single_invoice->discount_value;
        $this->type = $single_invoice->type;
    }

    public function print($id)
    {
        $single_invoice = Invoice::findorfail($id);

        return Redirect::route('print_single_invoices', [
            'invoice_date' => $single_invoice->invoice_date,
            'doctor_id' => $single_invoice->Doctor->name,
            'section_id' => $single_invoice->Section->name,
            'service_id' => $single_invoice->Service->name,
            'type' => $single_invoice->type,
            'price' => $single_invoice->price,
            'discount_value' => $single_invoice->discount_value,
            'tax_rate' => $single_invoice->tax_rate,
            'total_with_tax' => $single_invoice->total_with_tax,
        ]);
    }

    public function store()
    {
        DB::beginTransaction(); // بدء المعاملة
        try {

            // لو الفاتورة نقدى
            if ($this->type == 1) {
                // لو الفاتورة نقدى وفى حالة التعديل
                if ($this->updateMode) {
                    $single_invoices = Invoice::findorfail($this->single_invoice_id);
                    $single_invoices->update([
                        'type' => $this->type,
                        'invoice_type' => 1,
                        'invoice_date' => now()->toDateString(),
                        'patient_id' => $this->patient_id,
                        'doctor_id' => $this->doctor_id,
                        'section_id' => SectionTranslation::where('name', $this->section_id)->value('section_id'),
                        'service_id' => $this->service_id,
                        'price' => $this->price,
                        'discount_value' => $this->discount_value,
                        'tax_rate' => $this->tax_rate,
                        'tax_value' => ($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100),
                        'total_with_tax' => $this->price - $this->discount_value + (($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100)),
                        'invoice_status' => 1,
                    ]);

                    $fundaccount = FundAccount::where('invoice_id', $this->single_invoice_id)->first();
                    $fundaccount->update([
                        'date' => now()->toDateString(),
                        'invoice_id' => $single_invoices->id,
                        'debit' => floatval($single_invoices->total_with_tax),
                        'credit' => 0.00,
                    ]);

                    $this->InvoiceUpdated = true;
                    $this->updateMode = false;
                    $this->show_table = true;
                }
                // لو الفاتورة نقدى وفى حالة الحفظ

                else {
                    $single_invoices = Invoice::create([
                        'type' => $this->type,
                        'invoice_type' => 1,
                        'invoice_date' => now()->toDateString(),
                        'patient_id' => $this->patient_id,
                        'doctor_id' => $this->doctor_id,
                        'section_id' => SectionTranslation::where('name', $this->section_id)->value('section_id'),
                        'service_id' => $this->service_id,
                        'price' => $this->price,
                        'discount_value' => $this->discount_value,
                        'tax_rate' => $this->tax_rate,
                        'tax_value' => ($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100),
                        'total_with_tax' => $this->price - $this->discount_value + (($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100)),
                        'invoice_status' => 1,

                    ]);

                    FundAccount::create([
                        'date' => now()->toDateString(),
                        'invoice_id' => $single_invoices->id,
                        'debit' => floatval($single_invoices->total_with_tax),
                        'credit' => 0.00,
                    ]);

                    $notifications = new Notification();
                    $notifications->user_id = $this->doctor_id;
                    $notifications->guard = 'doctor';
                    $patient = Patient::find($this->patient_id);
                    $notifications->message = "كشف جديد : " . $patient->name;
                    $notifications->save();


                    $data = [
                        'patient' => $this->patient_id,
                        'invoice_id' => $single_invoices->id,
                        'doctor_id' => $this->doctor_id,
                    ];

                    event(new CreateInvoice($data));

                    $this->InvoiceSaved = true;
                    $this->updateMode = false;
                    $this->show_table = true;
                }
            }
            // لو الفاتورة اجل

            else {
                // لو الفاتورة اجل وفى حالة التعديل

                if ($this->updateMode) {
                    $single_invoices = Invoice::findorfail($this->single_invoice_id);
                    $single_invoices->update([
                        'type' => $this->type,
                        'invoice_type' => 1,
                        'invoice_date' => now()->toDateString(),
                        'patient_id' => $this->patient_id,
                        'doctor_id' => $this->doctor_id,
                        'section_id' => SectionTranslation::where('name', $this->section_id)->value('section_id'),
                        'service_id' => $this->service_id,
                        'price' => $this->price,
                        'discount_value' => $this->discount_value,
                        'tax_rate' => $this->tax_rate,
                        'tax_value' => ($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100),
                        'total_with_tax' => $this->price - $this->discount_value + (($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100)),
                        'invoice_status' => 1,
                    ]);

                    $patientaccount = PatientAccount::where('invoice_id', $this->single_invoice_id)->first();
                    $patientaccount->update([
                        'date' => now()->toDateString(),
                        'invoice_id' => $single_invoices->id,
                        'patient_id' =>  $this->patient_id,
                        'debit' => floatval($single_invoices->total_with_tax),
                        'credit' => 0.00,
                    ]);

                    $this->InvoiceUpdated = true;
                    $this->updateMode = false;
                    $this->show_table = true;
                }
                // لو الفاتورة اجل وفى حالة التعديل
                else {

                    $single_invoices =  Invoice::create([
                        'type' => $this->type,
                        'invoice_type' => 1,
                        'invoice_date' => now()->toDateString(),
                        'patient_id' => $this->patient_id,
                        'doctor_id' => $this->doctor_id,
                        'section_id' => SectionTranslation::where('name', $this->section_id)->value('section_id'),
                        'service_id' => $this->service_id,
                        'price' => $this->price,
                        'discount_value' => $this->discount_value,
                        'tax_rate' => $this->tax_rate,
                        'tax_value' => ($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100),
                        'total_with_tax' => $this->price - $this->discount_value + (($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100)),
                        'invoice_status' => 1,
                    ]);

                    PatientAccount::create([
                        'date' => now()->toDateString(),
                        'invoice_id' => $single_invoices->id,
                        'patient_id' =>  $this->patient_id,
                        'debit' => floatval($single_invoices->total_with_tax),
                        'credit' => 0.00,
                    ]);

                    $this->InvoiceSaved = true;
                    $this->updateMode = false;
                    $this->show_table = true;
                }
            }
            DB::commit(); // حفظ التغييرات في قاعدة البيانات
        } catch (\Exception $e) {
            DB::rollBack();
            $this->catchError = $e->getMessage();
        }
    }

    public function delete($id)
    {

        $this->single_invoice_id = $id;
    }

    public function destroy()
    {
        Invoice::destroy($this->single_invoice_id);
        return redirect()->to('/single_invoices');
    }
}
