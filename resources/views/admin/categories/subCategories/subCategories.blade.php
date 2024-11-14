@extends('admin.mainComponents')

@section('title', 'التصنيفات الفرعية')


@section('link_one', 'التصنيفات')
@section('link_two', 'الفرعية')


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
                            <i class="fa-solid fa-layer-group" style="font-size: 25px;"></i>
                            <h4 class="my-0 flex-grow-1" style="font-size: 20px; font-weight: 400;">كل التصنيفات الفرعية</h4>
                        </div>
                        <!-- Button trigger modal -->
                        <div>
                            <button type="button" class="btn btn-sm text-white" style="font-size: 15px; font-weight: 600; border-radius: 5px; border: 2px solid white;" data-toggle="modal" data-target="#exampleModalCenter">
                                <i class="fa-solid fa-plus mx-2"></i>
                                اضافة تصنيف فرعي
                            </button>


                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover text-center">
                            <thead class="bg-light">
                                
                                <tr>
                                    <th>صورة التصنيف الفرعي</th>
                                    <th>رقم التصنيف الفرعي</th>
                                    <th>اسم التصنيف الفرعي</th>
                                    <th>التصنيف الاساسي</th>
                                    <th>اجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example category row, replace with dynamic content -->
                                @foreach ($subCategories as $subCategory)
                                <tr>
                                    <td><img style="width: 50px; height: 50px;" class="rounded-circle" src="{{asset($subCategory->image)}}" alt="subCategory Image"></td>
                                    <td>{{ $subCategory->id }}</td>
                                    <td>{{ $subCategory->name }}</td>
                                    <td>{{ $subCategory->category->name }}</td>
                                    <td>
                                        <a href="{{route('admin.subCategories.edit', $subCategory->id)}}" class="btn btn-sm btn-outline-success mx-2 border-2"  style="font-weight: 600 !important;">تعديل</a>
                                        <form action="{{ route('admin.subCategories.destroy', $subCategory->id) }}" method="POST" class="d-inline">
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



<!-- Modal For Add Subcategory -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header p-0 text-center bg-success text-white">
                <h5 class="modal-title text-center p-2 m-0 w-100" style="font-size: 20px; font-weight: 400;" id="exampleModalLongTitle">اضافة تصنيف فرعي جديد</h5>
            </div>
            <div class="modal-body">
            <form action="{{ route('admin.subCategories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Category Dropdown -->
                <div class="form-group">
                    <label for="category"style="font-weight: 600; font-size: 18px">اسم التصنيف الرئيسي</label>
                    <select name="category_id" id="category" class="form-control">
                        <option value="" disabled selected>اختر</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Subcategory Dropdown -->
                <div class="form-group">
                    <label for="subcategory" style="font-weight: 600 ; font-size: 18px;">اسم التصنيف الفرعي</label>
                    <input type="text" class="form-control" id="subcategory" name="name" placeholder="ادخل اسم التصنيف الفرعي" required>
                </div>

                 <!-- Category Image -->
                 <div class="mb-3">
                    <label for="category_image" style="font-weight: 600; font-size: 18px" class="form-label">صورة التصنيف الفرعي</label>
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