<?php

namespace App\Repository\Doctors;

use App\Interface\Doctors\DoctorRepositoryInterface;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Section;
use App\Traits\UploadImageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorRepository implements DoctorRepositoryInterface
{
    use UploadImageTrait;
    public function index()
    {
        $doctors = Doctor::all();
        return view('dashboard.doctors.index', compact('doctors'));
    }
    public function create()
    {
        $sections = Section::all();
        $appointments = Appointment::all();
        return view('dashboard.doctors.add', compact('sections', 'appointments'));
    }
    public function edit($id)
    {
        $doctor = Doctor::with('appointments')->findorfail($id);
        $sections = Section::all();
        $appointments = Appointment::all();
        return view('dashboard.doctors.edit', compact('doctor', 'sections', 'appointments'));
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            // إنشاء سجل جديد في جدول الأطباء
            $doctor = Doctor::create($request->all());

            // إضافة المواعيد للطبيب (علاقة Many-to-Many)
            $doctor->appointments()->attach($request->appointments);

            if ($request->hasFile('image')) {  // رفع الصورة وربطها بالطبيب
                // $request, $inputName, $folderName, $disk, $imageable_id, $imageable_type
                $this->StoreImage($request, 'image', 'doctors', 'upload_image', $doctor->id, Doctor::class);
            }

            // حفظ جميع العمليات
            DB::commit();

            session()->flash('add');
            return redirect()->route('doctors.index');
        } catch (Exception $e) {
            // في حالة حدوث خطأ، يتم التراجع عن جميع العمليات
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function update($request)
    {
        DB::beginTransaction();
        // dd($request);
        try {
            $request->validate([
                'name'        => 'required|string|max:255',
                'email'       => 'required|email|unique:doctors,email,' . $request->id,
                'phone'       => 'required|string|max:255',
                'section_id'  => 'required|exists:sections,id',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            // جلب الطبيب أو إرسال خطأ 404 إذا لم يكن موجودًا
            $doctor = Doctor::findOrFail($request->id);
            // تحديث بيانات الطبيب باستخدام update() مباشرةً
            $doctor->update([
                'email' => $request->email,
                'section_id' => $request->section_id,
                'phone' => $request->phone,
                'name' => $request->name,
            ]);

            // تحديث المواعيد المرتبطة عبر Pivot Table
            if ($request->has('appointments')) {
                $doctor->appointments()->sync($request->appointments);
            }
            // تحديث الصورة إذا كانت مرفوعة
            if ($request->hasFile('image')) {
                // حذف الصورة القديمة إن وجدت
                if ($doctor->image) {
                    $name = $doctor->image->filename;
                    $this->delete_image('upload_image', "doctors/$name", $doctor->id);
                }
                // رفع الصورة الجديدة وربطها بالطبيب
                $this->StoreImage($request, 'image', 'doctors', 'upload_image', $doctor->id, Doctor::class);
            }
            DB::commit();
            session()->flash('edit');
            return redirect()->route('doctors.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function destroy($request)
    {

        $doctor = Doctor::findorfail($request->id);
        if ($doctor->image != null) {
            $name = $doctor->image->filename;
            $this->delete_image('upload_image', "doctors/$name", $doctor->id);
        }
        $doctor->delete();
        session()->flash('delete');
        return redirect()->route('doctors.index');
    }

    public function update_status($request)
    {

        try {
            $doctor = Doctor::findorfail($request->id);
            $doctor->update([
                'status' => $request->status
            ]);

            session()->flash('edit');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function update_password($request)
    {
        try {
            $doctor = Doctor::findorfail($request->id);
            $doctor->update([
                'password' => Hash::make($request->password)
            ]);

            session()->flash('edit');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
