@extends('seller.mainComponents')

@section('title', 'كل الموظفين')


@section('link_one', 'الموظفين')
@section('link_two', 'تعديل بيانات موظف')

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<div class="container mt-4">
    <!-- Card Title -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="my-0"><i class="fas fa-pen mx-2"></i> تعديل بيانات الموظف رقم: {{ $employee->id }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('seller.employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Seller Details Card Row 1: Two input fields side by side -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="first_name" class="form-label">الاسم</label>
                                <input type="text" class="form-control" name="name" value="{{ $employee->name }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="position" class="form-label">الدور</label>
                                <input type="text" class="form-control" name="position" value="{{ $employee->position }}" required>
                            </div>
                        </div>


                        <!-- Seller Details Card Row 3: Two input fields side by side -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                            <label for="status" class="form-label">الحالة</label>
                            <div class="form-check form-switch form-control">
                                <input class="form-check-input" style="margin-left: -20px;" type="checkbox" id="status" name="status" 
                                    @if ($employee->status == 'active') checked @endif 
                                    onchange="document.getElementById('status_hidden').value = this.checked ? 'active' : 'inactive';">
                                <label class="form-check-label" for="status">
                                    @if ($employee->status == 'active') مفعل @else غير مفعل @endif
                                </label>
                            </div>
                            <!-- Hidden input to store the status value -->
                            <input type="hidden" id="status_hidden" name="status" value="{{ $employee->status }}">
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <a href="{{ route('seller.employees') }}" class="btn btn-outline-secondary">رجوع</a>
                                <button type="submit" class="btn btn-outline-success mx-2">حفظ التعديلات</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection