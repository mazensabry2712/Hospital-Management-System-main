<?php

namespace App\Http\Livewire;

use App\Models\Doctor;
use App\Models\FundAccount;
use App\Models\Group;
use App\Models\GroupInvoice;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\PatientAccount;
use App\Models\SectionTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class GroupInvoices extends Component
{

    public $InvoiceSaved = false;
    public $InvoiceUpdated = false;
    public $show_table = true;
    public $updateMode = false;
    public $group_invoice_id;
    public $group_id;
    public $catchError;
    public $price = 0;
    public $patient_id, $doctor_id, $section_id, $type;
    public $discount_value = 0;
    public $tax_rate = 0;
    public $tax_value = 0;
    public function render()
    {
        return view('livewire.GroupInvoices.group-invoices', [
            'group_invoices' => Invoice::where('invoice_type', 2)->get(),
            'patients' => Patient::all(),
            'doctors' => Doctor::all(),
            'groups' => Group::all(),
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
        $this->price = Group::where('id', $this->group_id)->first()->total_before_discount;
        $this->discount_value = Group::where('id', $this->group_id)->first()->discount_value;
        $this->tax_rate = Group::where('id', $this->group_id)->first()->tax_rate;
    }


    public function store()
    {
        DB::beginTransaction(); // بدء المعاملة
        try {
            // لو الفاتورة نقدى
            if ($this->type == 1) {
                // لو الفاتورة نقدى وفى حالة التعديل
                if ($this->updateMode) {
                    $group_invoices = Invoice::findorfail($this->group_invoice_id);
                    $group_invoices->update([
                        'type' => $this->type,
                        'invoice_type' => 2,
                        'invoice_date' => now()->toDateString(),
                        'patient_id' => $this->patient_id,
                        'doctor_id' => $this->doctor_id,
                        'section_id' => SectionTranslation::where('name', $this->section_id)->value('section_id'),
                        'group_id' => $this->group_id,
                        'price' => $this->price,
                        'discount_value' => $this->discount_value,
                        'tax_rate' => $this->tax_rate,
                        'tax_value' => ($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100),
                        'total_with_tax' => $this->price - $this->discount_value + (($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100)),
                        'invoice_status' => 1,
                    ]);
                    //هنا جريمه يحاسب عليها
                    // $group_invoices = SingleInvoice::latest()->first();
                    $fundaccount = FundAccount::where('invoice_id', $this->group_invoice_id)->first();
                    $fundaccount->update([
                        'date' => now()->toDateString(),
                        'invoice_id' => $group_invoices->id,
                        'debit' => floatval($group_invoices->total_with_tax),
                        'credit' => 0.00,
                    ]);

                    $this->InvoiceUpdated = true;
                    $this->updateMode = false;
                    $this->show_table = true;
                }
                // لو الفاتورة نقدى وفى حالة الحفظ

                else {

                    $group_invoices = Invoice::create([
                        'type' => $this->type,
                        'invoice_type' => 2,
                        'invoice_date' => now()->toDateString(),
                        'patient_id' => $this->patient_id,
                        'doctor_id' => $this->doctor_id,
                        'section_id' => SectionTranslation::where('name', $this->section_id)->value('section_id'),
                        'group_id' => $this->group_id,
                        'price' => $this->price,
                        'discount_value' => $this->discount_value,
                        'tax_rate' => $this->tax_rate,
                        'tax_value' => ($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100),
                        'total_with_tax' => $this->price - $this->discount_value + (($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100)),
                        'invoice_status' => 1,

                    ]);

                    // $group_invoices = GroupInvoice::latest()->first();
                    FundAccount::create([
                        'date' => now()->toDateString(),
                        'invoice_id' => $group_invoices->id,
                        'debit' => floatval($group_invoices->total_with_tax),
                        'credit' => 0.00,
                    ]);

                    $this->InvoiceSaved = true;
                    $this->updateMode = false;
                    $this->show_table = true;
                }
            }
            // لو الفاتورة اجل

            else {
                // لو الفاتورة اجل وفى حالة التعديل

                if ($this->updateMode) {
                    $group_invoices = Invoice::findorfail($this->group_invoice_id);
                    $group_invoices->update([
                        'type' => $this->type,
                        'invoice_type' => 2,
                        'invoice_date' => now()->toDateString(),
                        'patient_id' => $this->patient_id,
                        'doctor_id' => $this->doctor_id,
                        'section_id' => SectionTranslation::where('name', $this->section_id)->value('section_id'),
                        'group_id' => $this->group_id,
                        'price' => $this->price,
                        'discount_value' => $this->discount_value,
                        'tax_rate' => $this->tax_rate,
                        'tax_value' => ($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100),
                        'total_with_tax' => $this->price - $this->discount_value + (($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100)),
                        'invoice_status' => 1,
                    ]);
                    //هنا جريمه يحاسب عليها
                    // $group_invoices = SingleInvoice::latest()->first();
                    $patientaccount = PatientAccount::where('invoice_id', $this->group_invoice_id)->first();
                    $patientaccount->update([
                        'date' => now()->toDateString(),
                        'invoice_id' => $group_invoices->id,
                        'patient_id' =>  $this->patient_id,
                        'debit' => floatval($group_invoices->total_with_tax),
                        'credit' => 0.00,
                    ]);

                    $this->InvoiceUpdated = true;
                    $this->updateMode = false;
                    $this->show_table = true;
                }
                // لو الفاتورة اجل وفى حالة الحفظ
                else {

                    $group_invoices =  Invoice::create([
                        'type' => $this->type,
                        'invoice_type' => 2,
                        'invoice_date' => now()->toDateString(),
                        'patient_id' => $this->patient_id,
                        'doctor_id' => $this->doctor_id,
                        'section_id' => SectionTranslation::where('name', $this->section_id)->value('section_id'),
                        'group_id' => $this->group_id,
                        'price' => $this->price,
                        'discount_value' => $this->discount_value,
                        'tax_rate' => $this->tax_rate,
                        'tax_value' => ($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100),
                        'total_with_tax' => $this->price - $this->discount_value + (($this->price - $this->discount_value) * (($this->tax_rate ?? 0) / 100)),
                        'invoice_status' => 1,
                    ]);

                    // $group_invoices = SingleInvoice::latest()->first();
                    PatientAccount::create([
                        'date' => now()->toDateString(),
                        'patient_id' =>  $this->patient_id,
                        'invoice_id' => $group_invoices->id,
                        'debit' => floatval($group_invoices->total_with_tax),
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


    public function edit($id)
    {

        $this->show_table = false;
        $this->updateMode = true;
        $group_invoices = Invoice::findorfail($id);
        $this->group_invoice_id = $group_invoices->id;
        $this->patient_id = $group_invoices->patient_id;
        $this->doctor_id = $group_invoices->doctor_id;
        $this->section_id = DB::table('section_translations')->where('id', $group_invoices->section_id)->first()->name;
        $this->group_id = $group_invoices->group_id;
        $this->price = $group_invoices->price;
        $this->discount_value = $group_invoices->discount_value;
        $this->tax_rate = $group_invoices->tax_rate;
        $this->tax_value = $group_invoices->tax_value;
        $this->type = $group_invoices->type;
    }

    public function delete($id)
    {
        $this->group_invoice_id = $id;
    }

    public function destroy()
    {
        Invoice::destroy($this->group_invoice_id);
        return redirect()->to('/group_invoices');
    }

    public function print($id)
    {
        $single_invoice = Invoice::findorfail($id);
        return Redirect::route('print_group_invoices', [
            'invoice_date' => $single_invoice->invoice_date,
            'doctor_id' => $single_invoice->Doctor->name,
            'section_id' => $single_invoice->Section->name,
            'group_id' => $single_invoice->Group->name,
            'type' => $single_invoice->type,
            'price' => $single_invoice->price,
            'discount_value' => $single_invoice->discount_value,
            'tax_rate' => $single_invoice->tax_rate,
            'total_with_tax' => $single_invoice->total_with_tax,
        ]);
    }
}
