@extends('Dashboard.layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('dashboard/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('title')
    {{ trans('dashboard/main_sidebar.Insurance') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('dashboard/main_sidebar.Service') }}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('dashboard/main_sidebar.Insurance') }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @include('Dashboard.messages_alert')

    <!-- row -->
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('insurances.create') }}"
                        class="btn btn-primary">{{ trans('dashboard/insurances.Add_Insurance') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap text-center" id="example1">
                            <thead>
                                <tr class="table-secondary">
                                    <th>#</th>
                                    <th>{{ trans('dashboard/insurances.Company_code') }}</th>
                                    <th>{{ trans('dashboard/insurances.Company_name') }}</th>
                                    <th>{{ trans('dashboard/insurances.discount_percentage') }}</th>
                                    <th>{{ trans('dashboard/insurances.Insurance_bearing_percentage') }}</th>
                                    <th>{{ trans('dashboard/insurances.status') }}</th>
                                    <th>{{ trans('dashboard/insurances.notes') }}</th>
                                    <th>{{ trans('dashboard/insurances.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($insurances as $insurance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $insurance->insurance_code }}</td>
                                        <td>{{ $insurance->name }}</td>
                                        <td>{{ $insurance->discount_percentage }}</td>
                                        <td>{{ $insurance->company_rate }}</td>
                                        <td>
                                            <div
                                                class="dot-label bg-{{ $insurance->status == 1 ? 'success' : 'danger' }} ml-1">
                                            </div> {{ $insurance->status == 1 ? 'مفعل' : 'غير مفعل' }}
                                        </td>
                                        <td>{{ $insurance->notes }}</td>
                                        <td>
                                            <a href="{{ route('insurances.edit', $insurance->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                            <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#Deleted{{ $insurance->id }}"><i class="fas fa-trash"></i>
                                            </button>

                                        </td>
                                        @include('dashboard.insurance.delete')
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('dashboard/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
