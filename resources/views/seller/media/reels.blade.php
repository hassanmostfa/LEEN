@extends('seller.mainComponents')

@section('title', 'كل الفيديوهات')

@section('link_one', 'الفيديوهات')
@section('link_two', 'الكل')

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<div class="container mt-2">
    <div class="row">
        <!-- Card for uploading a new reel -->
        <div class="col-md-3 mb-4">
            <div class="card upload-card" style="cursor: pointer; height: 250px" data-bs-toggle="modal" data-bs-target="#uploadReelModal">
                <div class="card-body d-flex justify-content-center align-items-center" style="height: 100%;">
                    <h4 class="text-center">+ إضافة فيديو</h4>
                </div>
            </div>
        </div>

        @foreach($reels as $reel)
            <div class="col-md-2 mb-4">
                <div class="card position-relative">
                    <video controls height="250" class="card-img-top">
                        <source src="{{ asset($reel->reel) }}" type="video/mp4">
                        متصفحك لا يدعم تشغيل الفيديو.
                    </video>

                    <form action="{{route('seller.reels.destroy', $reel->id)}}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <!-- Delete icon overlay -->
                        <button class="btn btn-danger position-absolute top-0 end-0 m-2" 
                                style="border-radius: 50%;" 
                                type="submit"
                                title="حذف الريل"
                                >
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

    </div>
</div>

<!-- Modal for uploading reel -->
<div class="modal fade" id="uploadReelModal" tabindex="-1" aria-labelledby="uploadReelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white text-center">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                <h5 class="modal-title" id="uploadReelModalLabel">تحميل فيديو جديد</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('seller.reels.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="reel_file" class="form-label">اختر فيديو</label>
                        <input type="file" class="form-control" name="reel" id="reel_file" accept="video/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">تحميل</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
