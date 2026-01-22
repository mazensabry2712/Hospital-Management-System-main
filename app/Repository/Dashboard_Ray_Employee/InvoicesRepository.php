<?php

namespace App\Repository\Dashboard_Ray_Employee;

use App\Interface\Dashboard_Ray_Employee\InvoicesRepositoryInterface;
use App\Models\Ray;
use App\Traits\UploadImageTrait;
use Illuminate\Support\Facades\DB;

class InvoicesRepository implements InvoicesRepositoryInterface
{
    use UploadImageTrait;

    public function index()
    {
        $invoices = Ray::where('case', 0)->get();
        return view('dashboard.dashboard_ray_employee.invoices.index', compact('invoices'));
    }

    public function completed_invoices()
    {
        $invoices = Ray::where('case', 1)->where('employee_id', auth()->user()->id)->get();
        return view('Dashboard.dashboard_ray_employee.invoices.completed_invoices', compact('invoices'));
    }

    public function edit($id)
    {
        $invoice = Ray::findorFail($id);
        return view('Dashboard.dashboard_ray_employee.invoices.add_diagnosis', compact('invoice'));
    }

    public function update($request, $id)
    {
        DB::beginTransaction(); // بدء المعاملة لضمان عدم فقدان البيانات

        try {
            $invoice = Ray::findOrFail($id);

            $invoice->update([
                'employee_id' => auth()->user()->id,
                'description_employee' => $request->description_employee,
                'case' => 1,
            ]);

            if ($request->hasFile('image')) {
                //Upload images لحفظ العديد من الصور
                // $request, $inputName, $folderName, $disk, $imageable_id, $imageable_type
                $this->StoreImages($request, 'image', 'rays', 'upload_image', $invoice->id, Ray::class);
            }

            DB::commit(); // حفظ التغييرات إذا لم تحدث أخطاء
            session()->flash('edit', 'تم تحديث الفاتورة بنجاح');
            return redirect()->route('invoices_ray_employee.index');
        } catch (\Exception $e) {
            DB::rollback(); // إلغاء التغييرات في حالة حدوث خطأ
            return redirect()->back()->withErrors(['error' => 'حدث خطأ أثناء التحديث: ' . $e->getMessage()]);
        }
    }


    public function view_rays($id)
    {
        $rays = Ray::findorFail($id);
        return view('Dashboard.dashboard_ray_employee.invoices.patient_details', compact('rays'));
    }
}
