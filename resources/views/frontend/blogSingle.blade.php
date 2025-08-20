@extends('frontend.default')
@section('title', $blog->title)
@section('description', $blog->meta_description)
@section('og_image', $blog->image)

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection
@section('content')
<div class="site-breadcrumb" style="background: url({{ asset('home/assets/img/breadcrumb/breadcrumb.jpg') }})">
 <div class="container">
   <h2 class="breadcrumb-title">Blog Details</h2>
   <ul class="breadcrumb-menu clearfix">
    <li><a href="/">Home</a></li>
    <li class="active">{{$blog->title}}</li>
   </ul>
 </div>
</div>

<div class="blog-single-area de-padding">
    <div class="container">
        <h2 class="breadcrumb-title text-center">{{$blog->title}}</h2>
        <div class="blog-single-wpr">
            <div class="row ps g-5">
                <div class="col-xl-12">
                    <div class="theme-single blog-single">
                        <div class="theme-pic">
                            <img src="{{$blog->image}}" class="big-pic" alt="thumb">
                        </div>
                        <div class="theme-info">
                            <div class="theme-meta">
                                <div class="theme-meta-left">
                                    <ul>
                                        <li>
                                         <i class="fas fa-user"></i> 
                                         <a href="#">{{$blog->author}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="theme-meta-right">
                                     <a href="#" class="shr-btn">
                                       <i class="icofont-share-alt"></i>
                                       Share
                                     </a>
                                </div>
                            </div>
                            <div class="theme-desc">
                               <h2 class="about-title">{{$blog->title}}</h2>
                               {!! $blog->content !!}
                               <div class="content-tags pb-20">
                                <h5 class="mb-0">Tags</h5>
                                <ul>
                                 <li><a href="#" class="tags-link">Theme</a></li>
                                 <li><a href="#" class="tags-link">Business</a></li>
                                </ul>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                  <div class="widget recent-post mb-5">
                      <h5 class="work-title mb-3">Recent Posts</h5>

                      <!-- Slider main container -->
                      <div class="swiper recentPostSwiper">
                          <div class="swiper-wrapper">
                              @foreach($recentPosts as $post)
                                  <div class="swiper-slide">
                                      <div class="card recent-card shadow-sm border-0 rounded-lg overflow-hidden">
                                          <div class="card-img-top" style="height: 180px; overflow:hidden;">
                                              <a href="{{ route('blogSingle', $post->slug) }}" target="_blank">
                                                  <img src="{{ $post->image ?? asset('home/assets/img/single/d-1.jpg') }}" 
                                                       alt="{{ $post->title }}" 
                                                       style="width:100%; height:100%; object-fit:cover; transition: transform .3s ease-in-out;"
                                                       onmouseover="this.style.transform='scale(1.05)'" 
                                                       onmouseout="this.style.transform='scale(1)'">
                                              </a>
                                          </div>
                                          <div class="card-body p-3">
                                              <a href="{{ route('blogSingle', $post->slug) }}" target="_blank" class="text-decoration-none">
                                                  <h6 class="card-title text-dark fw-bold mb-1">
                                                      {{ \Illuminate\Support\Str::limit($post->title, 50) }}
                                                  </h6>
                                              </a>
                                              <p class="card-text text-muted mb-2" style="font-size: 0.85rem;">
                                                  <i class="icofont-ui-user"></i> {{ $post->created_at->format('d M, Y') }}
                                              </p>
                                              <a href="{{ route('blogSingle', $post->slug) }}" class="btn btn-sm btn-primary">
                                                  Read More
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                              @endforeach
                          </div>

                          <!-- Add Arrows -->
                          <div class="swiper-button-next"></div>
                          <div class="swiper-button-prev"></div>

                          <!-- Add Pagination -->
                          <div class="swiper-pagination"></div>
                      </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
var swiper = new Swiper(".recentPostSwiper", {
  loop: true, // Infinite loop
  slidesPerView: 3,
  spaceBetween: 20,

  autoplay: {
    delay: 3000, // 3s delay
    disableOnInteraction: false,
  },

  speed: 800, // transition speed (ms)
  effect: "slide", // options: 'slide', 'fade', 'cube', 'coverflow', 'flip'

  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },

  breakpoints: {
    0: { slidesPerView: 1 },
    768: { slidesPerView: 2 },
    1200: { slidesPerView: 3 },
  }
});

</script>
@endsection