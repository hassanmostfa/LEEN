@extends('admin.mainComponents')

@section('title', 'التصنيفات الاساسية')


@section('link_one', 'التصنيفات')
@section('link_two', 'الاساسية')


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
                            <i class="fa-solid fa-clipboard-list" style="font-size: 25px;"></i>
                            <h4 class="my-0 flex-grow-1" style="font-size: 20px; font-weight: 400;">كل التصنيفات</h4>
                        </div>
                        <!-- Button trigger modal -->
                        <div>
                            <button type="button" class="btn btn-sm text-white" style="font-size: 15px; font-weight: 600; border-radius: 5px; border: 2px solid white;" data-toggle="modal" data-target="#exampleModalCenter">
                                <i class="fa-solid fa-plus mx-2"></i>
                                اضافة تصنيف
                            </button>


                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover text-center">
                            <thead class="bg-light">
                                
                                <tr>
                                    <th>صورة التصنيف</th>
                                    <th>رقم التصنيف</th>
                                    <th>اسم التصنيف</th>
                                    <th>عدد التصنيفات الفرعية</th>
                                    <th>اجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example category row, replace with dynamic content -->
                                @foreach ($categories as $category)
                                <tr>
                                    <td><img style="width: 50px; height: 50px;" class="rounded-circle" src="{{asset($category->image)}}" alt="Category Image"></td>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->subCategoriesCount }}</td>
                                    <td>
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-success mx-2 border-2"  style="font-weight: 600 !important;">تعديل</a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-2"  style="font-weight: 600 !important;">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!-- Modal For Add Category -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header p-0 text-center bg-success text-white">
                <h5 class="modal-title text-center p-2 m-0 w-100" style="font-size: 20px; font-weight: 400;" id="exampleModalLongTitle">اضافة تصنيف جديد</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <!-- category Name -->
                    <div class="mb-3">
                        <label for="category_name" style="font-weight: 600; font-size: 18px" class="form-label">اسم التصنيف</label>
                        <input type="text" class="form-control" id="category_name" name="name" placeholder="مثال: الشعر " required>
                    </div>

                    <!-- Category Image -->
                    <div class="mb-3">
                        <label for="category_image" style="font-weight: 600; font-size: 18px" class="form-label">صورة التصنيف</label>
                        <div id="drop-area" class="drop-area">
                        <p>قم بسحب وإفلات صورتك هنا أو <span id="browse-button" class="browse-text">تصفح</span></p>
                            <input type="file" id="category_image" name="image" class="form-control" accept="image/*" style="display: none;">
                            <div id="preview" class="image-preview d-flex justify-content-center align-items-center"></div>
                        </div>
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