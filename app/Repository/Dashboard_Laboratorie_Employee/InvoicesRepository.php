<?php

namespace App\Repository\Dashboard_Laboratorie_Employee;

use App\Interface\Dashboard_Laboratorie_Employee\InvoicesRepositoryInterface;
use App\Models\Laboratorie;
use App\Traits\UploadImageTrait;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;

class InvoicesRepository implements InvoicesRepositoryInterface
{

    use UploadImageTrait;

    public function index()
    {
        $invoices = Laboratorie::where('case', 0)->get();
        // dd($invoices);
        return view('dashboard.dashboard_LaboratorieEmployee.invoices.index', compact('invoices'));
    }

    public function completed_invoices()
    {
        $invoices = Laboratorie::where('case', 1)->where('employee_id', auth()->user()->id)->get();
        return view('Dashboard.dashboard_LaboratorieEmployee.invoices.completed_invoices', compact('invoices'));
    }

    public function edit($id)
    {
        $invoice = Laboratorie::findorFail($id);
        return view('Dashboard.dashboard_LaboratorieEmployee.invoices.add_diagnosis', compact('invoice'));
    }

    public function update($request, $id)
    {
        DB::beginTransaction(); // بدء المعاملة لضمان عدم فقدان البيانات

        try {
            $invoice = Laboratorie::findOrFail($id);

            $invoice->update([
                'employee_id' => auth()->user()->id,
                'description_employee' => $request->description_employee,
                'case' => 1,
            ]);

            if ($request->hasFile('image')) {
                //Upload images لحفظ العديد من الصور
                // $request, $inputName, $folderName, $disk, $imageable_id, $imageable_type
                $this->StoreImages($request, 'image', 'laboratories', 'upload_image', $invoice->id, Laboratorie::class);
            }

            DB::commit(); // حفظ التغييرات إذا لم تحدث أخطاء
            session()->flash('edit', 'تم تحديث الفاتورة بنجاح');
            return redirect()->route('invoices_laboratorie_employee.index');
        } catch (\Exception $e) {
            DB::rollback(); // إلغاء التغييرات في حالة حدوث خطأ
            return redirect()->back()->withErrors(['error' => 'حدث خطأ أثناء التحديث: ' . $e->getMessage()]);
        }
    }

    public function view_laboratories($id)
    {
        $laboratorie = Laboratorie::findorFail($id);
        return view('Dashboard.dashboard_LaboratorieEmployee.invoices.patient_details', compact('laboratorie'));
    }
}
