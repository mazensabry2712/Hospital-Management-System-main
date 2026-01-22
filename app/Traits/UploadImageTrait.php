<?php

namespace App\Traits;

use App\Models\Image as ModelsImage;
use Illuminate\Support\Facades\Storage;
// use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\Facades\Image;
use Intervention\Image\Facades\Image as InterventionImage;

use Illuminate\Http\Request;

trait UploadImageTrait
{
    // to save only one images
    public function StoreImage(Request $request, $inputname, $foldername, $disk, $imageable_id, $imageable_type)
    {

        if ($request->hasFile($inputname)) {

            // التحقق من صحة الملف
            if (!$request->file($inputname)->isValid()) {
                return redirect()->back()->withErrors(['error' => 'Invalid Image!'])->withInput();
            }

            $photo = $request->file($inputname);
            $filename = $photo->hashName();
            // $name = \Str::slug($request->input('name')) . '_' . time();
            // $filename = $name . '.' . $photo->getClientOriginalExtension();

            // معالجة الصورة باستخدام Intervention Image
            $image = InterventionImage::make($photo)->resize(300, 300)->encode(); // ضبط الحجم إلى 300

            // حفظ الصورة في التخزين المحدد (مثلاً storage/app/public)
            Storage::disk($disk)->put("$foldername/$filename", $image->stream());

            // حفظ معلومات الصورة في قاعدة البيانات
            $Image = new ModelsImage();
            $Image->filename = $filename;
            $Image->imageable_id = $imageable_id;
            $Image->imageable_type = $imageable_type;
            $Image->save();
        }
        return null;
    }
    // to save many images
    public function StoreImages(Request $request, $inputname, $foldername, $disk, $imageable_id, $imageable_type)
    {
        if ($request->hasFile($inputname)) {

            foreach ($request->file($inputname) as $photo) {

                // التحقق من صحة الملف
                if (!$photo->isValid()) {
                    return redirect()->back()->withErrors(['error' => 'Invalid Image!'])->withInput();
                }

                $filename = $photo->hashName();

                // معالجة الصورة باستخدام Intervention Image
                $image = InterventionImage::make($photo)->resize(300, 300)->encode();

                // حفظ الصورة في التخزين المحدد
                Storage::disk($disk)->put("$foldername/$filename", $image->stream());

                // حفظ معلومات الصورة في قاعدة البيانات
                ModelsImage::create([
                    'filename' => $filename,
                    'imageable_id' => $imageable_id,
                    'imageable_type' => $imageable_type,
                ]);
            }
        }
    }

    public function delete_image($disk, $path, $id)
    {
        // delete from server
        Storage::disk($disk)->delete($path);
        // delete from database
        ModelsImage::where('imageable_id', $id)->delete();
    }
}
