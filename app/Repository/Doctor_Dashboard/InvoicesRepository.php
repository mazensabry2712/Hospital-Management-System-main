<?php

namespace App\Repository\doctor_dashboard;

use App\Interface\Doctor_Dashboard\InvoicesRepositoryInterface;
use App\Models\Invoice;
use App\Models\Laboratorie;
use App\Models\Ray;
use Illuminate\Support\Facades\Auth;

class InvoicesRepository implements InvoicesRepositoryInterface
{
    // قائمة الكشوفات تحت الاجراء
    public function index()
    {
        $invoices = Invoice::where('doctor_id',  Auth::user()->id)->where('invoice_status', 1)->get();
        return view('dashboard.doctor.invoices.index', compact('invoices'));
    }

    // قائمة المراجعات
    public function reviewInvoices()
    {
        $invoices = Invoice::where('doctor_id', Auth::user()->id)->where('invoice_status', 2)->get();
        return view('dashboard.doctor.invoices.review_invoices', compact('invoices'));
    }

    // قائمة الفواتير المكتملة
    public function completedInvoices()

    {
        $invoices = Invoice::where('doctor_id', Auth::user()->id)->where('invoice_status', 3)->get();
        return view('dashboard.doctor.invoices.completed_invoices', compact('invoices'));
    }
    //to show rays images
    public function show($id)
    {
        $rays = Ray::findorFail($id);
        return view('dashboard.doctor.invoices.view_rays', compact('rays'));
    }
    //to show Laboratories images
    public function showLaboratorie($id)
    {
        $laboratories = Laboratorie::findorFail($id);
        return view('dashboard.doctor.invoices.view_laboratories', compact('laboratories'));
    }
}
