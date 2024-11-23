<!DOCTYPE html>
<html lang="ar" dir="rtl">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>LEEN</title>
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet">

      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('homePage/css/bootstrap.min.css') }}">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('homePage/css/style.css') }}">
      <!-- Responsive-->
      <link rel="stylesheet" href="{{ asset('homePage/css/responsive.css') }}">
      <!-- fevicon -->
      <link rel="icon" href="{{ asset('homePage/images/fevicon.png') }}" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="{{ asset('homePage/css/jquery.mCustomScrollbar.min.css' ) }}">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Open+Sans:400,700&display=swap&subset=latin-ext" rel="stylesheet">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="{{ asset('homePage/css/owl.carousel.min.css') }}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

      <!-- Bootstrap Bundle JS -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

      <style>
         body {
             direction: rtl;
             font-family: 'Almarai', sans-serif;
             background-color: #fff;
         }
         .section-title {
             margin-top: 20px;
             font-size: 1.5rem;
             font-weight: bold;
             color: #333;
             margin-bottom: 20px;
         }
     </style>
   </head>
   <body>
      <!-- header section start -->
      <div class="header_section">
         <div class="container-fluid">
            <nav class="navbar justify-content-between">
               <div id="mySidenav" class="sidenav">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                  <a href="{{route('home')}}">الصفحة الرئيسية</a>
                  <a href="#homeServics">خدمات المنزل</a>
                  <a href="#studioServics">خدمات المقر</a>
                  <a href="#gallary">المعرض</a>
                  <a href="#reels">الريلز</a>
                  <a href="#about">عنا</a>
                  <a href="#">تواصل معنا</a>
                        @if (Auth::guard('customer')->check())
                              <a href="{{ route('customer.profile') }}">ملفي الشخصي</a>
                              <a  href="{{ route('customer.logout') }}">تسجيل الخروج</a>
                        @else
                              <a title="تسجيل الدخول" href="{{ route('customer.loginPage') }}">تسجيل الدخول</a>
                        @endif
               </div>
               <span class="toggle_icon float-right d-md-block" onclick="openNav()"><i class="fa fa-bars fa-2x text-dark mt-2"></i></span>
               <a class="logo" href="#"><img style=" height: 70px!important;" src="{{asset('homePage/images/leen logo.png')}}"></a>
               <form class="form-inline ">
                  <div class="login_text">
                    <div>
                        @if (Auth::guard('customer')->check())
                            <ul>
                                <li title="ملفي الشخصي"><a class="btn btn-md signIn_btn" href="{{ route('customer.profile') }}"><i class="fa fa-user mx-1" aria-hidden="true"></i>  ملفي الشخصي</a></li>
                                <li title="تسجيل الخروج"><a class="btn btn-md signIn_btn" href="{{ route('customer.logout') }}"><i class="fa fa-sign-out mx-1" aria-hidden="true"></i>  تسجيل الخروج</a></li>
                            </ul>
                        @else
                            <a title="تسجيل الدخول" href="{{ route('customer.loginPage') }}" class="btn signIn_btn"> <i class="fa fa-sign-in mx-1" aria-hidden="true"></i>  تسجيل الدخول</a>
                        @endif
                    </div>
                  </div>
               </form>
            </nav>
         </div>
      </div>
      <!-- header section end -->
      <!-- banner section start -->
      <div class="banner_section py-5">
         <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-7 text-right">
                           <h1 class="banner_taital">مرحبا بك في <br><span class="text-center">لين</span> </h1>
                           <p class="banner_text">منصة لين هي اول منصة للتجارة الالكترونية في المملكة العربية السعودية , يمكنك الحصول على جميع الخدمات الالكترونية الخاصة بالمنزل والمقر من خلالها</p>
                           <div class="read_bt"><a href="#">احجز الان</a></div>
                        </div>
                        <div class="col-sm-5">
                           <div class="banner_img"><img src="{{asset('homePage/images/banner-img.png')}}"></div>
                        </div>
                     </div>
                  </div>
               </div>
               
               <!-- you can add items here -->
            </div>
         </div>
      </div>
      <!-- banner section end -->

       <!-- about section start -->
       <div class="about_section pt-3" id="about">
         <div class="container">
            <div class="about_section_main">
               <div class="row">
                  <div class="col-md-8">
                     <div class="about_taital_main">
                        <h1 class="about_taital text-right">ماذا تقدم لك لين ؟ </h1>
                        <p class="about_text text-right">لين هي منصة التجارة الالكترونية التي يمكنك الحصول على جميع الخدمات الالكترونية الخاصة بالمنزل والمقر من خلالها ةايضا يمكنك اضافة الخدمات الخاصة لك اذا كنت مقدم خدمة</p>
                        <div class="row">
                           <div class="d-flex justify-content-start my-3 about_list" style="gap: 10px">
                              <ul class="col-md-6 mb-2">
                                 <li class="d-flex"><span>1</span> المساج</li>
                                 <li class=" d-flex"><span>2</span> العلاج</li>
                              </ul>
                              <ul class="col-md-6 mb-2">
                                 <li class="d-flex"><span>3</span> الهدوء</li>
                                 <li class=" d-flex"><span>4</span> الساونا</li>
                              </ul>
                           </div>
                        </div>
                        <div class="readmore_bt"><a href="#">اقرأ المزيد</a></div>
                     </div>
                  </div>
                  <div class="col-md-4 p-3 position-relative" style="background-color: #2f3e3b; top: -45px">
                     <div><img src="{{asset('homePage/images/about-img.png')}}" class="image_3"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- about section end -->

      <!-- Start Offer Section -->
      <div class="offer_section">
         <div class="container mb-4">
            <div class="row">
               <div class="offer_banner">
                  <div class="text col-md-6 d-flex flex-column justify-content-start align-items-start">
                     <h1>نحن نقدم لك كل الخدمات الخاصة بالتجميل التي تريدها</h1>
                     <p class="pt-3">توفر لين كل الخدمات التجميلية سواء في المنزل اوالمقر الخاص بمقدمي الحدمات التجميلية ما الذي تتنظره احجز خدمتك الخاصة الان</p>
                     <div class="readmore_bt"><a href="#">احجز الان</a></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- End Offer Section -->

      <!-- Home Services section start -->
      <div class="product_section layout_padding" style="background-color: #f7f1e5 !important;" id="homeServics" >
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <h1 class="product_taital text-dark">خدمات المنزل</h1>
                  <p class="product_text text-dark">هذه الخدمات تقم في المنزل الخاص بالعميل</p>
               </div>
            </div>
            <div class="product_section_2 layout_padding">
            <div id="servicesCarousel" class="carousel slide" data-bs-ride="carousel">
                  <!-- Carousel Indicators -->
                  <div class="carousel-indicators">
                     @foreach ($homeServices->chunk(4) as $index => $chunk)
                     <button type="button" data-bs-target="#servicesCarousel" data-bs-slide-to="{{ $index }}" 
                           class="{{ $index === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
                     @endforeach
                  </div>

                  <!-- Carousel Inner -->
                  <div class="carousel-inner">
                     @foreach ($homeServices->chunk(4) as $index => $chunk)
                     <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                           <div class="row">
                              @foreach ($chunk as $service)
                              <div class="col-lg-3 col-sm-6">
                                 <div class="product_box bg-white" >
                                       <h4 class="bursh_text">{{ $service->name }}</h4>
                                       <p class="lorem_text">هذه الخدمة خاصة ب: ال{{ $service->gender == 'men' ? 'رجال' : 'نساء' }}</p>
                                       <img src="{{ asset($service->seller->seller_logo) }}" class="image_1">
                                       <div class="btn_main">
                                          <div class="buy_bt col-md-6">
                                             <ul>
                                                   <li><a href="{{ route('homeService.show', $service->id) }}">احجز الان</a></li>
                                             </ul>
                                          </div>
                                          <h3 class="price_text col-md-6">{{ $service->price }} ريال</h3>
                                       </div>
                                 </div>
                              </div>
                              @endforeach
                           </div>
                     </div>
                     @endforeach
                  </div>

                  <!-- Carousel Controls -->
                  <!-- <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#servicesCarousel" data-bs-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#servicesCarousel" data-bs-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="visually-hidden">Next</span>
                  </button> -->
               </div>

               <div class="seemore_bt"><a href="#">اكتشف المزيد</a></div>
            </div>
         </div>
      </div>
      <!-- Home Services section end -->


<!-- Gallery section start -->
<div class="customer_section py-5 my-5" id="gallary">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
               <div class="d-flex align-items-center gap-3 read_bt mb-3 ">
                   <h5 class="mb-0 p-0" style="color: #2f3e3b !important;">المعرض</h5>
               <a href="#" class="signIn">مشاهدة الكل</a>
            </div>
                <h1 class="customer_taital">هنا يمكنك مشاهدة الصور الخاصة بنا</h1>
            </div>
        </div>
        <!-- Gallery -->
         <div class="row">
         <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
            <img
               src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
               class="w-100 shadow-1-strong rounded mb-4"
               alt="Boat on Calm Water"
            />

            <img
               src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain1.webp"
               class="w-100 shadow-1-strong rounded mb-4"
               alt="Wintry Mountain Landscape"
            />
         </div>

         <div class="col-lg-4 mb-4 mb-lg-0">
            <img
               src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain2.webp"
               class="w-100 shadow-1-strong rounded mb-4"
               alt="Mountains in the Clouds"
            />

            <img
               src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
               class="w-100 shadow-1-strong rounded mb-4"
               alt="Boat on Calm Water"
            />
         </div>

         <div class="col-lg-4 mb-4 mb-lg-0">
            <img
               src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(18).webp"
               class="w-100 shadow-1-strong rounded mb-4"
               alt="Waves at Sea"
            />

            <img
               src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain3.webp"
               class="w-100 shadow-1-strong rounded mb-4"
               alt="Yosemite National Park"
            />
         </div>
         </div>
<!-- Gallery -->

        </div>
    </div>
</div>
<!-- Gallery section end -->

      <!-- Studio Services section start -->
      <div class="product_section layout_padding" id="studioServices">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <h1 class="product_taital">خدمات الاستوديو</h1>
                  <p class="product_text">هذه الخدمات تقدم في المقر الخاص بمقدم الخدمة</p>
               </div>
            </div>
            <div class="product_section_2 layout_padding">
            <div id="servicesCarousel" class="carousel slide" data-bs-ride="carousel">
                  <!-- Carousel Indicators -->
                  <div class="carousel-indicators">
                     @foreach ($studioServices->chunk(4) as $index => $chunk)
                     <button type="button" data-bs-target="#servicesCarousel" data-bs-slide-to="{{ $index }}" 
                           class="{{ $index === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
                     @endforeach
                  </div>

                  <!-- Carousel Inner -->
                  <div class="carousel-inner">
                     @foreach ($studioServices->chunk(4) as $index => $chunk)
                     <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                           <div class="row">
                              @foreach ($chunk as $service)
                              <div class="col-lg-3 col-sm-6">
                                 <div class="product_box">
                                       <h4 class="bursh_text">{{ $service->name }}</h4>
                                       <p class="lorem_text">هذه الخدمة خاصة ب: ال{{ $service->gender == 'men' ? 'رجال' : 'نساء' }}</p>
                                       <img src="{{ asset($service->seller->seller_logo) }}" class="image_1">
                                       <div class="btn_main">
                                          <div class="buy_bt col-md-6">
                                             <ul>
                                                   <li><a href="{{ route('studioService.show', $service->id) }}">احجز الان</a></li>
                                             </ul>
                                          </div>
                                          <h3 class="price_text col-md-6">{{ $service->price }} ريال</h3>
                                       </div>
                                 </div>
                              </div>
                              @endforeach
                           </div>
                     </div>
                     @endforeach
                  </div>

                  <!-- Carousel Controls -->
                  <!-- <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#servicesCarousel" data-bs-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#servicesCarousel" data-bs-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="visually-hidden">Next</span>
                  </button> -->
               </div>

               <div class="seemore_bt"><a href="#">اكتشف المزيد</a></div>
            </div>
         </div>
      </div>
      <!-- Studio Services section end -->


<!-- Reels section start -->
<div class="customer_section py-5 my-5" id="reels">
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
            <div class="d-flex align-items-center gap-3 read_bt mb-3 ">
               <h5 class="p-0 m-0" style="color: #2f3e3b !important;">الريلز</h5>
               <a href="#" class="signIn">مشاهدة الكل</a>
            </div>
            <h1 class="customer_taital">هنا يمكنك مشاهدة الريلز الخاصة بالخدمات</h1>
         </div>
      </div>
      <div class="reels-wrapper">
   <div class="reels-container" id="reelsContainer">
      <div class="reels-inner d-flex gap-3" >
         @foreach ($reels->chunk(6) as $chunk)
         <div class="reels-group d-flex gap-3">
            @foreach ($chunk as $reel)
            <div class="reel-item d-flex gap-3">
               <video class="reel-video" autoplay muted loop controls>
                  <source src="{{ asset($reel->reel) }}" type="video/mp4">
                  <source src="{{ asset($reel->reel) }}" type="video/ogg">
                  متصفحك لا يدعم تشغيل الفيديو.
               </video>
               <div class="reel-overlay">
                  <p class="reel-title">{{ $reel->seller->first_name . ' ' . $reel->seller->last_name ?? 'عنوان الفيديو' }}</p>
               </div>
            </div>
            @endforeach
         </div>
         @endforeach
      </div>
   </div>
</div>

   </div>
</div>

<!-- start Modal -->
 <!-- Modal for Full-Screen Reel -->
<div class="modal fade" id="reelModal" tabindex="-1" aria-labelledby="reelModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <video id="modalVideo" class="w-100" controls autoplay>
               <source src="" type="video/mp4">
               <source src="" type="video/ogg">
               متصفحك لا يدعم تشغيل الفيديو.
            </video>
         </div>
      </div>
   </div>
</div>

<!-- End Modal -->
<!-- Reels section end -->


      <!-- footer section start -->
      <div class="footer_section layout_padding">
         <div class="container">
            <div class="contact_section_2">
               <div class="d-flex justify-content-between align-items-center">
                  <div class="col-sm-3">
                     <h3 class="address_text">تواصل معنا</h3>
                     <div class="address_bt">
                        <ul>
                           <li>
                              <a href="#">
                              <i class="fa fa-map-marker" aria-hidden="true"></i><span class="padding_left10"> العنوان : الرياض</span>
                              </a>
                           </li>
                           <li>
                              <a href="#">
                              <i class="fa fa-phone" aria-hidden="true"></i><span class="padding_left10">الهاتف : +01 1234567890</span>
                              </a>
                           </li>
                           <li>
                              <a href="#">
                              <i class="fa fa-envelope" aria-hidden="true"></i><span class="padding_left10">البريد الالكتروني : leen@gmail.com</span>
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>

                  <div class="col-sm-3 text-center">
                     <h3 class="address_text">روابط تهمك</h3>
                     <div class="address_bt">
                        <ul>
                           <li>
                              <a href="#">رابط 1</a>
                           </li>
                           <li>
                              <a href="#">رابط 2</a>
                           </li>
                           <li>
                              <a href="#">رابط 3</a>
                           </li>
                        </ul>
                     </div>
                  </div>

                  <div class="col-sm-3 text-center">
                     <h3 class="address_text">خدمات لين</h3>
                     <div class="address_bt">
                        <ul>
                           <li>
                              <a href="#">اضف خدمتك</a>
                           </li>
                           <li>
                              <a href="#">سجل حسابك</a>
                           </li>
                           <li>
                              <a href="#">تواصل معنا</a>
                           </li>
                        </ul>
                     </div>
                  </div>

                  <div class="col-sm-3 text-center">
                     <h3 class="address_text">تطبيق لين</h3>
                     <div class="d-flex flex-column align-items-center justify-content-center gap-3">
                        <div>
                           <a href="#">
                              <img src="{{asset('homePage/images/appstore.svg')}}" alt="App Store">
                           </a>
                        </div>
                        <div>
                           <a href="#">
                              <img src="{{asset('homePage/images/googleplay.svg')}}" alt="Google Play">
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="social_icon">
               <!-- <ul>
                  <li>
                     <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                  </li>
               </ul> -->
            </div>
         </div>
      </div>
      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <div class="content d-flex justify-content-between align-items-center mb-5">
               <div class="footer_logo1 col-md-4 text-center"><a href="#"><img height="70px" src="{{asset('homePage/images/leen logo2.png')}}"></a></div>
               <div class="col-md-4 text-center"><p class="copyright_text">جميع الحقوق &copy; محفوظة لدي <a href="{{route('home') }}">لين</a></p></div>
               <div class="d-flex gap-3 col-md-4 text-center justify-content-center align-items-center">
                  <p class="text-white m-0">تصميم وتطوير باقة التقنية</p>
                  <img src="https://tptc.com.sa/tptc_logo.png" width="45" height="45" alt="TPTC">
               </div>
            </div>
         </div>
      </div>
      <!-- copyright section end -->
      <!-- Javascript files-->
      <script src="{{asset('homePage/js/jquery.min.js') }}"></script>
      <script src="{{asset('homePage/js/popper.min.js') }}"></script>
      <script src="{{asset('homePage/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{asset('homePage/js/jquery-3.0.0.min.js') }}"></script>
      <script src="{{asset('homePage/js/plugin.js') }}"></script>
      <!-- sidebar -->
      <script src="{{asset('homePage/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
      <script src="{{asset('homePage/js/custom.js') }}"></script>
      <!-- javascript --> 
      <script src="{{asset('homePage/js/owl.carousel.js') }}"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>  
      <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
      <script>
         function openNav() {
           document.getElementById("mySidenav").style.width = "100%";
         }
         
         function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
         }
      </script> 
      <script>
         document.addEventListener('DOMContentLoaded', () => {
    const reels = document.querySelectorAll('.reel-video');
    const modalVideo = document.getElementById('modalVideo');

    reels.forEach(reel => {
        reel.addEventListener('click', function () {
            const videoSrc = this.querySelector('source').getAttribute('src');
            modalVideo.querySelector('source').setAttribute('src', videoSrc);
            modalVideo.load(); // Reload the video with the new source
            const modal = new bootstrap.Modal(document.getElementById('reelModal'));
            modal.show();
        });
    });

    // Stop video when modal closes
    document.getElementById('reelModal').addEventListener('hidden.bs.modal', function () {
        modalVideo.pause();
        modalVideo.currentTime = 0;
    });
});
      </script>
   </body>
</html>
