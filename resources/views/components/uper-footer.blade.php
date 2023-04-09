<div class="container-fluid">
				<div class="container animate-box">
					<div class="bottom margin-15">
						<div class="row">            
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="sidebar-widget">					
								<div class="widget-title-cover"><h4 class="widget-title"><span>Most comments</span></h4></div>
								<div class="latest_style_3">  
									<div class="latest_style_3_item">                     
									  <span class="item-count vertical-align">1.</span>
										<div class="alith_post_title_small">
											<a href="/single.html"><strong>Frtuitous spluttered unlike ouch vivid blinked far inside</strong></a>
										</div>
									</div>
									<div class="latest_style_3_item">                     
									  <span class="item-count vertical-align">2.</span>
										<div class="alith_post_title_small">
											<a href="/single.html"><strong>Against and lantern where a and gnashed nefarious</strong></a>
										</div>
									</div>
									<div class="latest_style_3_item">                     
									  <span class="item-count vertical-align">3.</span>
										<div class="alith_post_title_small">
											<a href="/single.html"><strong>Ouch oh alas crud unnecessary invaluable some</strong></a>
										</div> 
									</div>
									<div class="latest_style_3_item">                     
									  <span class="item-count vertical-align">4.</span>
										<div class="alith_post_title_small">
											<a href="/single.html"><strong>And far hey much hello and bashful one save less</strong></a>
										</div>
									</div>
								</div>
							</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="sidebar-widget">					
									<div class="widget-title-cover"><h4 class="widget-title"><span>Latest</span></h4></div>
									<div class="latest_style_2">
										@foreach($latests as $post)
										<div class="latest_style_2_item">
											<figure class="alith_news_img"><a href="{{$post->url}}"><img alt="" src="{{$post->avatar->sm_url}}" class="hover_grey"></a></figure>
											<h3 class="alith_post_title"><a href="{{$post->url}}">{{$post->title}}</a></h3>
										</div>
										@endforeach
										
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="sidebar-widget">					
									<div class="widget-title-cover"><h4 class="widget-title"><span>Categories</span></h4></div>
									<ul class="bottom_menu">
										@foreach($categories as $cat)
										<li><a href="{{$cat->url}}" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; {{$cat->title}}</a></li>
										@endforeach
									
									</ul>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
								<div class="sidebar-widget">					
									<div class="widget-title-cover"><h4 class="widget-title"><span>Instagram</span></h4></div>
									<ul class="alith-instagram-grid-widget alith-clr alith-row alith-gap-10">
										<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
											<a class="" target="_blank" href="#">
												<img class="" title="" alt="" src="/assets/images/thumb-square-1.png">
											</a>
										</li>
										<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
											<a class="" target="_blank" href="#">
												<img class="" title="" alt="" src="/assets/images/thumb-square-2.png">
											</a>
										</li>
										<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
											<a class="" target="_blank" href="#">
												<img class="" title="" alt="" src="/assets/images/thumb-square-3.png">
											</a>
										</li>
										<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
											<a class="" target="_blank" href="#">
												<img class="" title="" alt="" src="/assets/images/thumb-square-4.png">
											</a>
										</li>
										<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
											<a class="" target="_blank" href="#">
												<img class="" title="" alt="" src="/assets/images/thumb-square-5.png">
											</a>
										</li>
										<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
											<a class="" target="_blank" href="#">
												<img class="" title="" alt="" src="/assets/images/thumb-square-1.png">
											</a>
										</li>
										<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
											<a class="" target="_blank" href="#">
												<img class="" title="" alt="" src="/assets/images/thumb-square-2.png">
											</a>
										</li>
										<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
											<a class="" target="_blank" href="#">
												<img class="" title="" alt="" src="/assets/images/thumb-square-3.png">
											</a>
										</li>
										<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
											<a class="" target="_blank" href="#">
												<img class="" title="" alt="" src="/assets/images/thumb-square-4.png">
											</a>
										</li>						
									</ul>
								</div>
							</div>
						</div> <!--.row-->
					</div>
				</div>
			</div>