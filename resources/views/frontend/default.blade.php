<!doctype html>
<html class="no-js" lang="zxx">
<head>	
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>@yield('title')</title>
	<meta name="description" content="@yield('description')">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

 	<!-- Canonical URL - CRITICAL for SEO to avoid duplicate content -->
	<link rel="canonical" href="@yield('canonical', url()->current())" />

	<!-- Favicon and Apple Touch Icons -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}"> <!-- Important for iOS devices -->

	<!-- Open Graph / Facebook Meta Tags - ESSENTIAL for Social Sharing -->
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="@yield('og_type', 'website')" />
	<meta property="og:title" content="@yield('title')" />
	<meta property="og:description" content="@yield('description')" />
	<meta property="og:url" content="@yield('canonical', url()->current())" />
	<meta property="og:site_name" content="thesmartbuddy.in" /> <!-- Replace with your actual site name -->
	<meta property="og:image" content="@yield('og_image')" /> <!-- Minimum 1200x630px -->
	<meta property="og:image:width" content="1200" />
	<meta property="og:image:height" content="630" />
	<meta property="og:image:type" content="image/jpeg" />

	<!-- Twitter Meta Tags - ESSENTIAL for Twitter Sharing -->
	<meta name="twitter:card" content="summary_large_image"> <!-- Use 'summary_large_image' for large previews -->
	<meta name="twitter:title" content="@yield('title')">
	<meta name="twitter:description" content="@yield('description')">
	<meta name="twitter:image" content="@yield('og_image')">
	<meta name="twitter:site" content="@YourTwitterHandle"> <!-- Replace with your Twitter handle -->

	<!-- Structured Data / JSON-LD - HIGHLY RECOMMENDED for Rich Snippets -->
	<!-- This should be dynamically generated per page. Example for a homepage (Organization) is shown below. -->
	@yield('structured-data')

	<!-- Preload Critical Resources (Performance SEO) -->
	<link rel="preload" href="{{ asset('home/assets/css/bootstrap.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<link rel="preload" href="{{ asset('home/assets/css/fontawesome.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" href="{{ asset('home/assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('home/assets/css/fontawesome.min.css') }}">
	</noscript>

	<!-- Place favicon.ico in the root directory -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
	<!-- ========== Start Stylesheet ========== -->
	<link href="{{ asset('home/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('home/assets/css/fontawesome.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('home/assets/css/magnific-popup.css') }}" rel="stylesheet" />
	<link href="{{ asset('home/assets/css/owl.carousel.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('home/assets/css/owl.theme.default.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('home/assets/css/animate.css') }}" rel="stylesheet" />
	<link href="{{ asset('home/assets/css/themify-icons.css') }}" rel="stylesheet" />
	<link href="{{ asset('home/assets/css/icofont.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('home/assets/css/site-flaticon.css') }}" rel="stylesheet" />
	<link href="{{ asset('home/style.css') }}" rel="stylesheet">
	<link href="{{ asset('home/assets/css/responsive.css') }}" rel="stylesheet" />

  @yield('style')
	<!-- ========== End Stylesheet ========== -->
</head>

<body id="bdy">

 @include('frontend.layout.navbar')
 	<main class="main">
   @yield('content')
  </main>	
 @include('frontend.layout.footer')

 <script src="{{ asset('home/assets/js/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('home/assets/js/popper.min.js') }}"></script>
 <script src="{{ asset('home/assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('home/assets/js/bootstrap-menu.js') }}"></script>
 <script src="{{ asset('home/assets/js/jquery.easing.min.js') }}"></script>
	<script src="{{ asset('home/assets/js/jquery.appear.js') }}"></script>
	<script src="{{ asset('home/assets/js/modernizr.custom.13711.js') }}"></script>
 <script src="{{ asset('home/assets/js/owl.carousel.min.js') }}"></script>
 <script src="{{ asset('home/assets/js/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ asset('home/assets/js/isotope.pkgd.min.js') }}"></script>
 <script src="{{ asset('home/assets/js/imagesloaded.pkgd.min.js') }}"></script>
 <script src="{{ asset('home/assets/js/wow.min.js') }}"></script>
 <script src="{{ asset('home/assets/js/wodry.min.js') }}"></script>
	<script src="{{ asset('home/assets/js/count-to.js') }}"></script>
	<script src="{{ asset('home/assets/js/progress-bar.min.js') }}"></script>
	<script src="{{ asset('home/assets/js/color-option.js') }}"></script>
	<script src="{{ asset('home/assets/js/typed.js') }}"></script>
	<script src="{{ asset('home/assets/js/YTPlayer.min.js') }}"></script>
	<script src="{{ asset('home/assets/js/jquery.mixitup.min.js') }}"></script>
	<script src="{{ asset('home/assets/js/active-class.js') }}"></script>
 <script src="{{ asset('home/assets/js/main.js') }}"></script>
 @yield('script')
	
</body>


</html>


