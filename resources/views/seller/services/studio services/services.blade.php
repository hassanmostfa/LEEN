@extends('seller.mainComponents')

@section('title', 'الخدمات')


@section('link_one', 'خدماتي')
@section('link_two', 'المنزلية')


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
                    <i class="fa-solid fa-shop" style="font-size: 25px;"></i>
                    <h4 class="my-0 flex-grow-1" style="font-size: 20px; font-weight: 400;">كل الخدمات في المقر الخاص بي</h4>
                </div>
            </div>
            <div class="card-body">
                @if($studioServices->isEmpty())
                <div class="alert alert-warning text-center m-0 text-bold" style="font-size: 18px;" role="alert">
                    لا يوجد خدمات حتي الان
                </div>
                @else
                    <table class="table table-bordered table-striped table-hover text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>رقم الخدمة</th>
                                <th>اسم الخدمة</th>
                                <th>نوع العميل</th>
                                <th>التصنيف الرئيسي</th>
                                <th>التصنيف الفرعي</th>
                                <th>السعر</th>
                                <th>نوع الحجز</th>
                                <th>اجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($studioServices as $service)
                                <tr>
                                    <td>{{ $service->id }}</td>
                                    <td>{{ $service->name }}</td>
                                    <td>@if ($service->gender == 'men') رجال @else نساء @endif</td>
                                    <td>{{ $service->category }}</td>
                                    <td>{{ $service->sub_category }}</td>
                                    <td>{{ $service->price }}</td>
                                    <td>
                                        @if ($service->booking_status == 'immediate')
                                            <span class="badge badge-success">فوري</span>
                                        @else
                                            <span class="badge badge-danger">بموعد مسبق</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('seller.studioServices.show', $service->id) }}" class="btn btn-sm btn-outline-success mx-2 border-2" style="font-weight: 600 !important;">عرض</a>
                                        <a href="{{ route('seller.studioServices.edit', $service->id) }}" class="btn btn-sm btn-outline-primary mx-2 border-2" style="font-weight: 600 !important;">تعديل</a>
                                        <form action="{{ route('seller.studioServices.destroy', $service->id) }}" method="POST" class="d-inline">
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


@endsection