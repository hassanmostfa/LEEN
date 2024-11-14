@extends('admin.mainComponents')

@section('title', 'الطلبات الجديدة')


@section('link_one', 'البائعين')
@section('link_two', 'الطلبات الجديدة')


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
                            <i class="fa-solid fa-bell" style="font-size: 25px;"></i>
                            <h4 class="my-0 flex-grow-1" style="font-size: 20px; font-weight: 400;">كل الطلبات الجديدة</h4>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>رقم البائع</th>
                                    <th>اسم البائع</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الهاتف</th>
                                    <th>العلامة التجارية</th>
                                    <th>الحالة</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through the sellers or display a message if none exist -->
                                @forelse ($sellers as $seller)
                                <tr>
                                    <td>{{ $seller->id }}</td>
                                    <td>{{ $seller->first_name }} {{ $seller->last_name }}</td>
                                    <td>{{ $seller->email }}</td>
                                    <td>{{ $seller->phone }}</td>
                                    <td>
                                        @if ($seller->seller_logo)
                                            <img style="width: 50px; height: 50px;" class="rounded-circle" src="{{ asset($seller->seller_logo) }}" alt="Seller Logo">
                                        @else
                                            <span class="badge bg-secondary">لا يوجد صورة</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($seller->status == 'inactive')
                                            <span class="badge bg-danger">محظور</span>
                                        @else
                                            <span class="badge bg-success">نشط</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.sellers.requests.show', $seller->id) }}" class="btn btn-sm btn-outline-success mx-2 border-2" style="font-weight: 600 !important;">عرض</a>
                                    </td>
                                </tr>
                                @empty
                                <!-- Message for no data -->
                                <tr>
                                    <td colspan="7" class="m-0 p-0">
                                        <div class="alert alert-warning text-center m-0 text-bold" style="font-size: 18px;" role="alert">
                                            لا يوجد طلبات جديدة في الوقت الحالي.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection