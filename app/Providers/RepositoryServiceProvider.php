<?php

namespace App\Providers;

use App\Interface\Ambulances\AmbulanceRepositoryInterface;
use App\Interface\Dashboard_Laboratorie_Employee\InvoicesRepositoryInterface as Dashboard_Laboratorie_EmployeeInvoicesRepositoryInterface;
use App\Interface\Dashboard_Ray_Employee\InvoicesRepositoryInterface as Dashboard_Ray_EmployeeInvoicesRepositoryInterface;
use App\Interface\Doctor_Dashboard\DiagnosisRepositoryInterface;
use App\Interface\Doctor_Dashboard\InvoicesRepositoryInterface;
use App\Interface\Doctor_Dashboard\LaboratorieRepositoryInterface;
use App\Interface\Doctor_Dashboard\RayRepositoryInterface;
use App\Interface\Doctors\DoctorRepositoryInterface;
use App\Interface\Finance\PaymentRepositoryInterface;
use App\Interface\Finance\ReceiptRepositoryInterface;
use App\Interface\Insurances\InsuranceRepositoryInterface;
use App\Interface\LaboratorieEmployee\LaboratorieEmployeeRepositoryInterface;
use App\Interface\Patients\PatientRepositoryInterface;
use App\Interface\RayEmployee\RayEmployeeRepositoryInterface;
use App\Interface\Sections\SectionRepositoryInterface;
use App\Interface\Services\ServiceRepositoryInterface;

use App\Repository\Ambulances\AmbulanceRepository;
use App\Repository\Dashboard_Laboratorie_Employee\InvoicesRepository as Dashboard_Laboratorie_EmployeeInvoicesRepository;
use App\Repository\Dashboard_Ray_Employee\InvoicesRepository as Dashboard_Ray_EmployeeInvoicesRepository;
use App\Repository\Doctor_Dashboard\DiagnosisRepository;
use App\Repository\doctor_dashboard\InvoicesRepository;
use App\Repository\Doctor_Dashboard\LaboratorieRepository;
use App\Repository\Doctor_Dashboard\RayRepository;
use App\Repository\Doctors\DoctorRepository;
use App\Repository\Finance\PaymentRepository;
use App\Repository\Finance\ReceiptRepository;
use App\Repository\Insurances\InsuranceRepository;
use App\Repository\LaboratorieEmployee\LaboratorieEmployeeRepository;
use App\Repository\Patients\PatientRepository;
use App\Repository\RayEmployee\RayEmployeeRepository;
use App\Repository\Sections\SectionRepository;
use App\Repository\Services\ServiceRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        //Dashboard ADMIN
        $this->app->bind(SectionRepositoryInterface::class, SectionRepository::class);
        $this->app->bind(DoctorRepositoryInterface::class, DoctorRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(InsuranceRepositoryInterface::class, InsuranceRepository::class);
        $this->app->bind(AmbulanceRepositoryInterface::class, AmbulanceRepository::class);
        $this->app->bind(PatientRepositoryInterface::class, PatientRepository::class);
        $this->app->bind(ReceiptRepositoryInterface::class, ReceiptRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);

        //Dashboard DOCTOR
        $this->app->bind(InvoicesRepositoryInterface::class, InvoicesRepository::class);
        $this->app->bind(DiagnosisRepositoryInterface::class, DiagnosisRepository::class);
        $this->app->bind(RayRepositoryInterface::class, RayRepository::class);
        $this->app->bind(LaboratorieRepositoryInterface::class, LaboratorieRepository::class);

        //Dashboard Ray Employee
        $this->app->bind(RayEmployeeRepositoryInterface::class, RayEmployeeRepository::class);
        $this->app->bind(Dashboard_Ray_EmployeeInvoicesRepositoryInterface::class, Dashboard_Ray_EmployeeInvoicesRepository::class);


        // Dashboard Laboratorie
        $this->app->bind(LaboratorieEmployeeRepositoryInterface::class, LaboratorieEmployeeRepository::class);
        $this->app->bind(Dashboard_Laboratorie_EmployeeInvoicesRepositoryInterface::class, Dashboard_Laboratorie_EmployeeInvoicesRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
