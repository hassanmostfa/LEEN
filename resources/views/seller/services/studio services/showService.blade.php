@extends('seller.mainComponents')

@section('title', 'عرض بيانات خدمة منزلية')


@section('link_one', 'خدماتي')
@section('link_two', 'عرض الخدمة')


@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<div class="container mt-2">
    <div class="row">
        <div class="col-md-12 offset-md-2">
            <div class="card">
                <div class="card-header p-3 text-white bg-success">
                    <h3 class="my-0"> بيانات الخدمة رقم :  {{ $studioService->id}}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Left side: Table for Unit Details -->
                        <div class="col-md-12">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>اسم الخدمة</th>
                                    <td>{{ $studioService->name }}</td>
                                </tr>

                                <tr>
                                    <th>التصنيف الرئيسي</th>
                                    <td>{{ $studioService->category }}</td>
                                </tr>

                                </tr>

                                <tr>
                                    <th>التصنيف الفرعي</th>
                                    <td>{{ $studioService->sub_category }}</td>
                                </tr>


                                <tr>
                                    <th>نوع العميل</th>
                                    <td>{{ $studioService->gender == 'men' ? 'رجال' : 'نساء' }}</td>
                                </tr>

                                <tr>
                                    <th>تفاصيل الخدمة</th>
                                    <td>
                                        <!-- Decode the service details array and display each item in a new line -->
                                        @foreach (json_decode($studioService->service_details) as $detail)
                                            <li>{{ $detail }}</li>
                                        @endforeach
                                    </td>
                                </tr>

                                <tr>
                                    <th>الموظفين</th>
                                    <td>
                                        <!-- Decode the employees array and display each employee in a new line -->
                                        @foreach ($employees as $employee)
                                            <li>{{ $employee }}</li>
                                        @endforeach
                                    </td>
                                </tr>

                                <tr>
                                    <th>السعر</th>
                                    <td>{{ $studioService->price }} ريال سعودي</td>
                                </tr>

                                <tr>
                                    <th>نوع الحجز</th>
                                    <td>
                                        @if ($studioService->booking_status == 'immediate')
                                            <span class="badge bg-success">فوري</span>
                                            @elseif ($studioService->booking_status == 'previous_date')
                                            <span class="badge bg-info">بموعد مسبق</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>هل يوجد خصم؟</th>
                                    <td>
                                        @if ($studioService->discount == 0)
                                            <span class="badge bg-danger">لا</span>
                                        @else
                                            <span class="badge bg-success">نعم</span>
                                        @endif
                                    </td>

                                    @if ($studioService->discount == 1)
                                    <tr>
                                        <th>نسبة الخصم</th>
                                        <td>{{ $studioService->percentage }}%</td>
                                    </tr>
                                    @endif
                                </tr>

                                
                                <tr>
                                    <th>
                                        هل يوجد نقاط ولاء لهذه الخدمة؟
                                    </th>
                                    <td>
                                        @if ($studioService->points > 0)
                                            <span class="badge bg-success">{{ $studioService->points }} نقاط</span>
                                        @else
                                            <span class="badge bg-danger">لا يوجد نقاط ولاء لهذه الخدمة</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                            <div class="d-flex justify-content-start mt-3 gap-2">
                            
                                <a href="{{ route('seller.studioServices') }}" class="btn btn-outline-secondary btn-sm mt-3 border-2"  style="font-weight: 600 !important;">عودة</a>
                                <a href="{{ route('seller.studioServices.edit' , $studioService->id) }}" class="btn btn-outline-success btn-sm mt-3 border-2"  style="font-weight: 600 !important;">تعديل</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection