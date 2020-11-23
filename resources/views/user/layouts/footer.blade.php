<footer class="footer-area section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-3  col-md-12">
                <div class="single-footer-widget">
                  @if (isset($categories) && !$categories->isEmpty())
                    <h6>{{ __('footer.category')}}</h6>
                    <ul class="footer-nav">
                    @foreach ($categories as $categories)
                        @if (!$categories->posts()->count()==0)
                            <li><a href="{{ route('category',['locale'=>app()->getLocale(),'category'=>$categories->slug]) }}">{{ $categories->name }}</a></li>
                        @endif    
                    @endforeach
                    </ul>
                    @endif  
                </div>
            </div>
            <div class="col-lg-3  col-md-12">
                <div class="single-footer-widget">
                  @if (isset($popular_posts) && !$popular_posts->isEmpty())
                    <h6>{{ __('footer.toppost')}}</h6>
                    <ul class="footer-nav">
                        @foreach ($popular_posts as $popular_posts)
                            <li><a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$popular_posts->slug]) }}">{{ $popular_posts->title }}</a></li>
                        @endforeach
                    </ul>
                    @endif  
                </div>
            </div>
            {{-- <div class="col-lg-6  col-md-12">
                <div class="single-footer-widget newsletter">
                    <h6>Newsletter</h6>
                    <p>You can trust us. we only send promo offers, not a single spam.</p>
                    <div id="mc_embed_signup">
                        <form target="_blank" novalidate="true" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="form-inline">

                            <div class="form-group row" style="width: 100%">
                                <div class="col-lg-8 col-md-12">
                                    <input name="EMAIL" placeholder="Enter Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '" required="" type="email">
                                    <div style="position: absolute; left: -5000px;">
                                        <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
                                    </div>
                                </div> 
                            
                                <div class="col-lg-4 col-md-12">
                                    <button class="nw-btn primary-btn">Subscribe<span class="lnr lnr-arrow-right"></span></button>
                                </div> 
                            </div>		
                            <div class="info"></div>
                        </form>
                    </div>		
                </div>
            </div> --}}
            {{-- <div class="col-lg-3  col-md-12">
                <div class="single-footer-widget mail-chimp">
                    <h6 class="mb-20">Instragram Feed</h6>
                    <ul class="instafeed d-flex flex-wrap">
                        <li><img src="{{ asset('user/img/i1.jpg') }}" alt=""></li>
                        <li><img src="{{ asset('user/img/i2.jpg') }}" alt=""></li>
                        <li><img src="{{ asset('user/img/i3.jpg') }}" alt=""></li>
                        <li><img src="{{ asset('user/img/i4.jpg') }}" alt=""></li>
                        <li><img src="{{ asset('user/img/i5.jpg') }}" alt=""></li>
                        <li><img src="{{ asset('user/img/i6.jpg') }}" alt=""></li>
                        <li><img src="{{ asset('user/img/i7.jpg') }}" alt=""></li>
                        <li><img src="{{ asset('user/img/i8.jpg') }}" alt=""></li>
                    </ul>
                </div>
            </div> --}}
        </div>

        <div class="row footer-bottom d-flex justify-content-between">
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            <p class="col-lg-8 col-sm-12 footer-text">Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved </a></p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            <div class="col-lg-4 col-sm-12 footer-social">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-dribbble"></i></a>
                <a href="#"><i class="fa fa-behance"></i></a>
            </div>
        </div>
    </div>
</footer>
<!-- End footer Area -->		

<script src="{{ asset('user/js/vendor/jquery-2.2.4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="{{ asset('user/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('user/js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('user/js/parallax.min.js') }}"></script>			
<script src="{{ asset('user/js/owl.carousel.min.js') }}"></script>		
<script src="{{ asset('user/js/jquery.magnific-popup.min.js') }}"></script>				
<script src="{{ asset('user/js/jquery.sticky.js') }}"></script>
<script src="{{ asset('user/js/main.js') }}"></script>	
@section('footer')
    
@show