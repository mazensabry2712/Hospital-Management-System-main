@extends('Dashboard.layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('Admin/assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('title')
    {{ trans('dashboard/insurances.edit_Insurance') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('dashboard/main_sidebar.Service') }}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('dashboard/insurances.Insurance') }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('insurances.update', 'test') }}" method="post">
                        @method('PUT')
                        @csrf

                        {{-- input hidden value => id   --}}
                        <input type="hidden" name="id" value="{{ $insurance->id }}">

                        <div class="row">

                            <div class="col">
                                <label>{{ trans('dashboard/insurances.Company_code') }}</label>
                                <input type="text" name="insurance_code" value="{{ $insurance->insurance_code }}"
                                    class="form-control @error('insurance_code') is-invalid @enderror">
                                @error('insurance_code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col">
                                <label>{{ trans('dashboard/insurances.Company_name') }}</label>
                                <input type="text" name="name" value="{{ $insurance->name }}"
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <br>

                        <div class="row">

                            <div class="col">
                                <label>{{ trans('dashboard/insurances.discount_percentage') }} %</label>
                                <input type="number" name="discount_percentage"
                                    value="{{ $insurance->discount_percentage }}"
                                    class="form-control @error('discount_percentage') is-invalid @enderror">
                                @error('discount_percentage')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col">
                                <label>{{ trans('dashboard/insurances.Insurance_bearing_percentage') }} %</label>
                                <input type="number" name="company_rate" value="{{ $insurance->company_rate }}"
                                    class="form-control @error('company_rate') is-invalid @enderror">
                                @error('company_rate')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col">
                                <label>{{ trans('dashboard/insurances.notes') }}</label>
                                <textarea rows="5" cols="10" class="form-control" name="notes">{{ $insurance->notes }}</textarea>
                            </div>
                        </div>

                        <br>


                        <div class="form-group">
                            <label for="status">{{ trans('dashboard/insurances.activation_status') }}</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="" disabled>--{{ trans('dashboard/doctors.choose') }}--
                                </option>
                                <option value="1"{{ $insurance->status == 1 ? 'selected' : '' }}>
                                    {{ trans('dashboard/doctors.enabled') }}</option>
                                <option value="0"{{ $insurance->status == 0 ? 'selected' : '' }}>
                                    {{ trans('dashboard/doctors.not_enabled') }}</option>
                            </select>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col">
                                <button class="btn btn-success">{{ trans('dashboard/insurances.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('Admin/assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('Admin/assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
