@extends('seller.mainComponents')

@section('title', 'كل الصور')


@section('link_one', 'الصور')
@section('link_two', 'الكل')

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<div class="container mt-2">
    <div class="row">
        <!-- Card for uploading a new image -->
        <div class="col-md-3 mb-4">
            <div class="card upload-card" style="cursor: pointer; height: 250px" data-bs-toggle="modal" data-bs-target="#uploadImageModal">
                <div class="card-body d-flex justify-content-center align-items-center" style="height: 100%;">
                    <h4 class="text-center">+ اضافة صورة  </h4>
                </div>
            </div>
        </div>

        <!-- Display each image as a card -->
        @foreach($images as $image)
            <div class="col-md-3 mb-4">
                <div class="card position-relative">
                    <img src="{{ asset($image->image) }}" height="250" class="card-img-top" alt="Seller Image">
                    
                    <form action="{{route('seller.images.destroy', $image->id)}}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <!-- Delete icon overlay -->
                        <button class="btn btn-danger position-absolute top-0 end-0 m-2" 
                                style="border-radius: 50%;" 
                                type="submit"
                                title="حذف الصورة"
                                >
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
    </div>
</div>

<!-- Modal for uploading image -->
<div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white text-center">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title" id="uploadImageModalLabel">اضافة صورة جديدة</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('seller.images.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="image_file" class="form-label">اختر صورة</label>
                        <input type="file" class="form-control" name="image" id="image_file" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">تحميل</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection