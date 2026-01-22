@extends('dashboard.layouts.master')
@section('css')


@endsection

@section('title')
    {{ $section->name }} / {{ trans('dashboard/sections.section_doctors') }}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ $section->name }}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('dashboard/sections.section_doctors') }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">
        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0 text-md-nowrap table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('dashboard/doctors.doctor_name') }}</th>
                                    <th>{{ trans('dashboard/doctors.email') }}</th>
                                    <th>{{ trans('dashboard/doctors.doctor_section_name') }}</th>
                                    <th>{{ trans('dashboard/doctors.doctor_phone') }}</th>
                                    <th>{{ trans('dashboard/doctors.appointment') }}</th>
                                    <th>{{ trans('dashboard/doctors.status') }}</th>
                                    <th>{{ trans('dashboard/doctors.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctors as $doctor)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $doctor->name }}</td>
                                        <td>{{ $doctor->email }}</td>
                                        <td>{{ $doctor->section->name }}</td>
                                        <td>{{ $doctor->phone }}</td>
                                        <td>
                                            {{-- @foreach ($doctor->appointments as $appointment)
                                                {{ $appointment->name }}
                                            @endforeach --}}
                                        </td>
                                        <td>
                                            <div
                                                class="dot-label bg-{{ $doctor->status == 1 ? 'success' : 'danger' }} ml-1">
                                            </div>
                                            {{ $doctor->status == 1 ? trans('dashboard/doctors.enabled') : trans('dashboard/doctors.not_enabled') }}
                                        </td>

                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-outline-primary btn-sm" data-toggle="dropdown"
                                                    type="button">{{ trans('dashboard/doctors.actions') }}<i
                                                        class="fas fa-caret-down mr-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    <a class="dropdown-item"
                                                        href="{{ route('doctors.edit', $doctor->id) }}"><i
                                                            class="text-primary las la-pen"></i>&nbsp;&nbsp;{{ trans('dashboard/doctors.edit_doctors') }}
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#update_password{{ $doctor->id }}"><i
                                                            class="text-primary ti-key"></i>&nbsp;&nbsp;{{ trans('dashboard/doctors.change_password') }}</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#update_status{{ $doctor->id }}"><i
                                                            class="text-warning ti-back-right"></i>&nbsp;&nbsp;{{ trans('dashboard/doctors.edit_status') }}</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#delete{{ $doctor->id }}"><i
                                                            class="text-danger las la-trash"></i>&nbsp;&nbsp;{{ trans('dashboard/doctors.delete_doctors') }}</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('dashboard.doctors.delete')
                                    @include('dashboard.doctors.update_status')
                                    @include('dashboard.doctors.update_password')
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
