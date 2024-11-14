@extends('admin.mainComponents')

@section('title', 'تعديل تصنيف الاساسي')


@section('link_one', 'التصنيفات')
@section('link_two', 'تعديل تصنيف')


@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

 <!-- Update Form -->
 <form action="{{ route('admin.categories.update', $category->id) }}" class="bg-light p-3 rounded" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3 d-flex align-items-center flex-column">
        <label for="category_image" style="font-weight: 600; font-size: 18px" class="form-label">صورة التصنيف</label>
        <!-- Image Preview -->
        <div class="image-upload-wrapper position-relative mb-2">
            <img id="category_image_preview" src="{{ asset($category->image ?? 'path/to/default-image.jpg') }}" alt="Category Image" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
            <!-- Button to browse files -->
            <button type="button" class="btn btn-success m-0 p-1 btn-sm image-upload-btn" onclick="document.getElementById('category_image').click()"
                style="position: absolute; bottom: 20px; right: 120px; font-size: 12px;">تعديل</button>
            </div>
            
            <!-- Upload New Image (Hidden input) -->
            <input type="file" class="form-control d-none" id="category_image" name="image" onchange="previewImage(event)">
            
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Category Name -->
        <div class="mb-3">
            <label for="category_name" style="font-weight: 600; font-size: 18px" class="form-label">اسم التصنيف</label>
            <input type="text" class="form-control" id="category_name" name="name" value="{{ old('name', $category->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
        <a href="{{ route('admin.categories') }}" class="btn btn-secondary">إلغاء</a>
    </form>
@endsection

