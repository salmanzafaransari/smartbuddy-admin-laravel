@extends('frontend.default')
@section('style')
<style>
 .pagination {
     gap: 6px;
 }
 .page-item .page-link {
     border-radius: 8px;
     padding: 6px 14px;
     color: #444;
 }
 .page-item.active .page-link {
     background-color: var(--clr-def); /* Indigo shade */
     border-color: var(--clr-def);
     color: #fff;
 }
 .page-item .page-link:hover {
     background-color: #e5e7eb;
 }
 .peg p{
  widht:max-content;
 }
</style>
@endsection
@section('content')
<div class="site-breadcrumb" style="background: url({{ asset('home/assets/img/breadcrumb/breadcrumb.jpg') }})">
    <div class="container">
        <h2 class="breadcrumb-title">Blog</h2>
        <ul class="breadcrumb-menu clearfix">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="active">Blog</li>
        </ul>
    </div>
</div>

<div class="blog-area pos-rel de-padding">
    <div class="container">
        <div class="row ps g-5">
            <!-- Blog List -->
            <div class="col-xl-8">
                <div class="blog-page-wpr">
                    @forelse($blogs as $blog)
                        <div class="blog-page-single mb-5">
                            <div class="blog-pic">
                                <img src="{{ $blog->image }}" 
                                     alt="{{ $blog->title }}" style="width:100%;">
                            </div>
                            <div class="blog-content">
                                <div class="blog-text">
                                    <a href="{{ route('blogSingle', $blog->slug) }}">
                                        <h3>{{ $blog->title }}</h3>
                                    </a>
                                    <p class="mb-0">
                                        {{ Str::limit(strip_tags($blog->content), 150, '...') }}
                                    </p>
                                </div>
                                <div class="blog-user">
                                    <div class="blog-user-info">
                                        <div class="blog-user-bio">
                                            <h4>{{ $blog->author ?? 'Admin' }}</h4>
                                            <span>Author</span>
                                        </div>
                                    </div>
                                    <ul class="blog-mta">
                                        <li><i class="fas fa-calendar-alt"></i> {{ $blog->created_at->format('d M Y') }}</li>
                                    </ul>
                                </div>
                                <div class="red-more text-right mt-30">
                                    <a href="{{ route('blogSingle', $blog->slug) }}" class="btn-4">Read More</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No blogs found.</p>
                    @endforelse

                    
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-xl-4">
                <aside class="sidebar">
                    <!-- Recent Post -->
                    <div class="widget recent-post">
                        <h5 class="work-title">Recent Posts</h5>
                        @foreach($recentPosts as $recent)
                            <div class="recent-post-single">
                                <div class="recent-post-pic">
                                    <img src="{{ $recent->image }}" 
                                         alt="{{ $recent->title }}" style="width:80px; height:80px; object-fit:cover;">
                                </div>
                                <div class="recent-post-bio">
                                    <a href="{{ route('blogSingle', $recent->slug) }}">
                                        <h6>{{ Str::limit($recent->title, 40) }}</h6>
                                    </a>
                                    <span>
                                        <i class="icofont-ui-user"></i>
                                        {{ $recent->created_at->format('d M, Y') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </aside>
            </div>
            <!-- Pagination -->
            <div class="mt-4 peg">
                {{ $blogs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
