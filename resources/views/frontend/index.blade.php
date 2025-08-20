@extends('frontend.default')

@section('content')
		<!-- Start Slider
		============================================= -->
		<div id="home" class="hero-section hm-3 auto-height">
			<div class="hero-shape">
				<img src="{{ asset('home/assets/img/header/header-shape.png') }}" alt="thumb">
			</div>
			<div class="hero-section-content hero-sldr owl-carousel owl-theme">
				<div class="hero-single" style="background-image: url({{ asset('home/assets/img/header/hdr1.jpg') }})">
					<div class="container">
						<div class="row">
							<div class="col-xl-8 offset-xl-2">
								 <div class="hero-content text-center">
									<h2 class="hero-title">
										Digital Products
									</h2>
									 <p>
										Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur vel illum qui dolorem eum 
									 </p>
									<div class="hero-btn">
										<a href="contact.html" target="_blank" class="tm-btn">Start Free Trial</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="hero-single" style="background-image: url({{ asset('home/assets/img/header/hdr2.jpg') }})">
					<div class="container">
						<div class="row">
							<div class="col-xl-8 offset-xl-2">
								 <div class="hero-content text-center">
									<h2 class="hero-title">
										Software Landing
									</h2>
									 <p>
										Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur vel illum qui dolorem eum 
									 </p>
									<div class="hero-btn">
										<a href="contact.html" target="_blank" class="tm-btn">Start Free Trial</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Slider -->
		
		<!-- Start Laptop
		============================================= -->
		<div class="lp">
			<div class="container">
				<div class="lp-wpr">
					<div class="lp-pic">
						<img src="{{ asset('home/assets/img/header/laptop.png') }}" alt="thumb">
					</div>
				</div>
			</div>
		</div>
		<!-- End Laptop -->

  		<!-- Start Step
		============================================= -->
		<div id="step" class="step-are pos-rel de-pt">
			<div class="container">
				<div class="row">
					<div class="col-xl-8 offset-xl-2">
						<div class="site-title text-center">
							<h2>STEPS OF OUR WORK</h2>
							<p class="mb-0">
								Outlived no dwelling denoting in peculiar as he believed. Behaviour excellent middleton be as it curiosity departure ourselves very extreme future.
							</p>
						</div>
					</div>
				</div>
				<div class="step-wpr grid-2">
					<div class="step-left grid-2">
						<div class="step-box">
							<div class="step-up">
								<span class="step-ribbon">step 1</span>
								<i class="flaticon-support-1"></i>
							</div>
							<div class="step-content">
								<h5>Research Project</h5>
								<p class="mb-0">
									Bumetimes furnished collected add for resources attention. Norland an minister.
								</p>
							</div>
						</div>
						<div class="step-box">
							<div class="step-up">
								<span class="step-ribbon">step 2</span>
								<i class="flaticon-folder"></i>
							</div>
							<div class="step-content">
								<h5>Collection Data</h5>
								<p class="mb-0">
									Bumetimes furnished collected add for resources attention. Norland an minister.
								</p>
							</div>
						</div>
						<div class="step-box">
							<div class="step-up">
								<span class="step-ribbon">step 3</span>
								<i class="flaticon-shuttle"></i>
							</div>
							<div class="step-content">
								<h5>Start Project</h5>
								<p class="mb-0">
									Bumetimes furnished collected add for resources attention. Norland an minister.
								</p>
							</div>
						</div>
						<div class="step-box">
							<div class="step-up">
								<span class="step-ribbon">step 4</span>
								<i class="flaticon-insurance"></i>
							</div>
							<div class="step-content">
								<h5>Project Result</h5>
								<p class="mb-0">
									Bumetimes furnished collected add for resources attention. Norland an minister.
								</p>
							</div>
						</div>
					</div>
					<div class="step-right">
						<div class="step-right-content">
							<h2 class="counter-title">
								You Are few step away to achieve your goal
							</h2>
							<div class="step-tx mb-40">
								<p class="mb-0">
									Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nemo commodi nisi nesciunt in harum accusantium, alias atque expedita placeat! Necessitatibus illum est vel, quia modi, doloremque adipisci fugiat quaerat?
								</p>
							</div>
							<div class="step-pic">
								<img src="{{ asset('home/assets/img/bg/step-2.svg') }}" alt="thumb">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Step -->
		
		<!-- Start Screenshot
		============================================= -->
		<div id="overview" class="scr-area pos-rel de-padding">
			<div class="scr-shape">
				<img src="{{ asset('home/assets/img/shape/line-shape.png') }}" alt="thumb">
			</div>
			<div class="container">
				<div class="row">
					<div class="col-xl-8 offset-xl-2">
						<div class="site-title text-center">
							<h2>Software Overview</h2>
							<p class="mb-0">
								Outlived no dwelling denoting in peculiar as he believed. Behaviour excellent middleton be as it curiosity departure ourselves very extreme future.
							</p>
						</div>
					</div>
				</div>
				<div class="scr-wpr scr-sldr owl-carousel owl-theme">
					<div class="scr-pic">
						<img src="{{ asset('home/assets/img/dashboard/01.png') }}" alt="thumb">
					</div>
					<div class="scr-pic">
						<img src="{{ asset('home/assets/img/dashboard/02.png') }}" alt="thumb">
					</div>
					<div class="scr-pic">
						<img src="{{ asset('home/assets/img/dashboard/03.png') }}" alt="thumb">
					</div>
				</div>
			</div>
		</div>
		<!-- End Screenshot -->

		
		<!-- Start Review
		============================================= -->
		<div id="feedback" class="rev-area pos-rel de-padding">
			<div class="rev-shape">
				<img src="{{ asset('home/assets/img/shape/shape-2.png') }}" alt="thumb">
			</div>
			<div class="container">
				<div class="row">
					<div class="col-xl-8 offset-xl-2">
						<div class="site-title text-center">
							<h2>Client Feedback</h2>
							<p class="mb-0">
								Outlived no dwelling denoting in peculiar as he believed. Behaviour excellent middleton be as it curiosity departure ourselves very extreme future.
							</p>
						</div>
					</div>
				</div>
				<div class="rev-wpr grid-px-2">
					<div class="rev-left">
						<img src="{{ asset('home/assets/img/choose/review.jpg') }}" alt="thumb">
					</div>
					<div class="rev-right">
						<div class="rev-sldr owl-carousel owl-theme">
							<div class="rev-content">
								<div class="rev-icon">
									<img src="{{ asset('home/assets/img/shape/qoute.png') }}" alt="thumb">
								</div>
								<div class="rev-desc">
									<blockquote>
										For 50 years, WWF has been protecting the future of nature. The world's leading WWF works in 100 countries supported million members.
									</blockquote>
									<div class="rev-bio">
										<div class="rev-pic">
											<img src="{{ asset('home/assets/img/single/user-2-s.png') }}" alt="thumb">
										</div>
										<div class="rev-txt">
											<h4>Devin Hamilton</h4>
											<span>Client</span>
										</div>
									</div>
								</div>
							</div>
							<div class="rev-content">
								<div class="rev-icon">
									<img src="{{ asset('home/assets/img/shape/qoute.png') }}" alt="thumb">
								</div>
								<div class="rev-desc">
									<blockquote>
										For 50 years, WWF has been protecting the future of nature. The world's leading WWF works in 100 countries supported million members.
									</blockquote>
									<div class="rev-bio">
										<div class="rev-pic">
											<img src="{{ asset('home/assets/img/single/user-1-s.png') }}" alt="thumb">
										</div>
										<div class="rev-txt">
											<h4>Lucille Goodwin</h4>
											<span>Client</span>
										</div>
									</div>
								</div>
							</div>
							<div class="rev-content">
								<div class="rev-icon">
									<img src="{{ asset('home/assets/img/shape/qoute.png') }}" alt="thumb">
								</div>
								<div class="rev-desc">
									<blockquote>
										For 50 years, WWF has been protecting the future of nature. The world's leading WWF works in 100 countries supported million members.
									</blockquote>
									<div class="rev-bio">
										<div class="rev-pic">
											<img src="{{ asset('home/assets/img/single/user-3-s.png') }}" alt="thumb">
										</div>
										<div class="rev-txt">
											<h4>Ira Crawford</h4>
											<span>Client</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Review -->
		
		<!-- Start Pricing
		============================================= -->
		<div id="contact" class="pricing-area bg pos-rel de-pt">
			<div class="container">
				<div class="contact-us-wpr">
					<div class="row g-5">
						<div class="col-xl-6 col-lg-6">
							<div class="contact-content">
								<div class="contact-bottom">
									<h2 class="site-heading mb-40">
										We'd love to hear from you
									</h2>
									<div class="addr-box">
										<div class="addr-box-single">
											<div class="addr-icon">
												<i class="flaticon-location"></i>
											</div>
											<div class="addr-desc">
												<h5>Office Address</h5>
												<p class="mb-0">
													3812 Lena Lane City Jackson Mississippi
												</p>
											</div>
										</div>
										<div class="addr-box-single">
											<div class="addr-icon">
												<i class="flaticon-call"></i>
											</div>
											<div class="addr-desc">
												<h5>Phone Number</h5>
												<p class="mb-0">
													601-594-3504
												</p>
											</div>
										</div>
										<div class="addr-box-single">
											<div class="addr-icon">
												<i class="flaticon-envelope"></i>
											</div>
											<div class="addr-desc">
												<h5>Email</h5>
												<p class="mb-0">
													4cfdx9dy9e@temporary-mail.net
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6">
							<form class="contact-form" method="post" action="https://themekar.com/templatebucket/lenda/lenda/assets/mail/contact.php">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control input-style-2" name="fname" placeholder="Your Full Name*">
											<span class="alert alert-error"></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="email" class="form-control input-style-2" name="email" placeholder="Your Email Address*">
											<span class="alert alert-error"></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control input-style-2" name="phone" placeholder="Phone Number">
											<span class="alert alert-error"></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="email" class="form-control input-style-2" name="web" placeholder="Your Wesite Link">
											<span class="alert alert-error"></span>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" class="form-control input-style-2" name="subject" placeholder="Subject...">
											<span class="alert alert-error"></span>
										</div>
									</div>
									<div class="col-md-12">
										<textarea class="form-control input-style-2" name="message" placeholder="Your Message..."></textarea>
										<div class="contact-sub-btn text-center">
											<button type="submit" name="submit" id="submit" class="btn-4">
												Send Message 
												<i class="fas fa-chevron-right"></i>
											</button>
										</div>
										<!-- Alert Message -->
										<div class="alert-notification">
											<div id="message" class="alert-msg"></div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Pricing-->
   <!-- Start Faq
		============================================= -->
		<div class="faq-area bg de-padding">
			
		</div>
		<!-- End Faq -->
@endsection
		
	
		
