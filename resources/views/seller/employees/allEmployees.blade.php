@extends('seller.mainComponents')

@section('title', 'كل الموظفين')


@section('link_one', 'الموظفين')
@section('link_two', 'الكل')

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header py-2 bg-success text-white d-flex align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa-solid fa-users" style="font-size: 25px;"></i>
                    <h4 class="my-0 flex-grow-1" style="font-size: 20px; font-weight: 400;">كل الموظفين</h4>
                </div>
                <div>
                    <button type="button" class="btn btn-sm text-white" style="font-size: 15px; font-weight: 600; border-radius: 5px; border: 2px solid white;" data-toggle="modal" data-target="#exampleModalCenter">
                        <i class="fa-solid fa-plus mx-2"></i>
                        اضافة موظف جديد
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if($employees->isEmpty())
                <div class="alert alert-warning text-center m-0 text-bold" style="font-size: 18px;" role="alert">
                    لا يوجد موظفين حتي الان
                </div>
                @else
                    <table class="table table-bordered table-striped table-hover text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>رقم الموظف</th>
                                <th>اسم الموظف</th>
                                <th>الدور</th>
                                <th>الحالة</th>
                                <th>اجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->id }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->position }}</td>
                                    <td>
                                        @if ($employee->status == 'active')
                                            <span class="badge bg-success">نشط</span>
                                        @else
                                            <span class="badge bg-danger">غير نشط</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('seller.employees.edit', $employee->id) }}" class="btn btn-sm btn-outline-success mx-2 border-2" style="font-weight: 600 !important;">تعديل</a>
                                        <form action="{{ route('seller.employees.destroy', $employee->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-2" style="font-weight: 600 !important;">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>




<!-- Modal For Add Category -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header p-0 text-center bg-success text-white">
                <h5 class="modal-title text-center p-2 m-0 w-100" style="font-size: 20px; font-weight: 400;" id="exampleModalLongTitle"><i class="fa-solid fa-plus me-3 mx-2"></i>اضافة موظف جديد</h5>
            </div>
            <div class="modal-body">
            <form action="{{ route('seller.employees.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <!-- Employee Name -->
                            <div class="mb-3">
                                <label for="name" style="font-weight: 600; font-size: 18px" class="form-label">اسم الموظف</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="مثال: حسن مصطفي" required>
                            </div>

                            <!-- Employee Role -->
                            <div class="mb-3">
                                <label for="position" style="font-weight: 600; font-size: 18px" class="form-label">الدور</label>
                                <input type="text" class="form-control" id="position" name="position" placeholder="مثال: موظف مبيعات" required>
                            </div>


                            <!-- Submit Button -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">اغلاق</button>
                                <button type="submit" class="btn btn-outline-success">حفظ</button>
                            </div>
                        </form>
            </div>
        </div>
    </div>
</div>
@endSection