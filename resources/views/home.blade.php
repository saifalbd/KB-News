<x-layout>
	<x-slot name="meta">
	<title>কেবি এক্সপ্রেস /সত্যের খোঁজে বদ্ধপরিকর</title>
	</x-slot>
<div class="container-fluid">
				<div class="container animate-box">
					<div class="row">			
						<div class="owl-carousel owl-theme js carausel_slider section_margin" id="slider-small">
                            @foreach($home_tops as $top)
							<div class="item px-2">
								<div class="alith_latest_trading_img_position_relative">
									<figure class="alith_post_thumb">
										<a href="#"><img src="{{$top->avatar->sm_url}}" alt=""/></a>
									</figure>
									<div class="alith_post_title_small">
										<a href="{{$top->url}}"><strong>{{$top->title}}</strong></a>
										<p class="meta"><span>{{post_date($top->updated_at)}}</span> <span>{{$top->views_count}} views</span></p>
									</div>
								</div>
							</div>
                            @endforeach
							
						</div>
					</div>
				</div>
			</div>
<div class="container-fluid">
				<div class="container">
					<div class="primary margin-15">
					<div class="row">
						<div class="col-md-8">
							<div class="owl-carousel owl-theme js section_margin line_hoz animate-box" id="slideshow_face">
                            @foreach($features as $feature)
								<div class="item">
									<figure class="alith_post_thumb_big">
										<span class="post_meta_categories_label">{{$feature->categories->pluck('title')->join(',')}}</span>
										<a href="{{$feature->url}}"><img src="{{$feature->avatar->url}}" alt=""/></a>
									</figure>
									<h3 class="alith_post_title animate-box" data-animate-effect="fadeInUp">
										<a href="{{$feature->url}}">{{$feature->title}}</a>
									</h3>
									<div class="alith_post_content_big">
										<div class="row">
											<div class="col-md-4 col-sm-12">
												<div class="post_meta_center animate-box">
													@if($feature->show_author)
													<p><a href="{{$feature->author->url}}"><img src="{{$feature->author->avatar->md_url}}" alt="author details"/></a></p>
													<p><a href="{{$feature->author->url}}" class="author"><strong>{{$feature->author->name}}</strong></a></p>
													@else
													<p><a><img src="{{asset('storage/author_logo.jpg')}}" alt="author details"/></a></p>
													<p><a class="author"><strong>নিজস্ব প্রতিনিধি</strong></a></p>
													@endif
													<span class="post_meta_date">{{post_date($feature->updated_at)}}</span>
												</div>
											</div>
											<div class="col-md-8 col-sm-12 animate-box">
												<p class="alith_post_except">{{$feature->description}}</p>
											</div>
										</div>
									</div>
								</div>
                                @endforeach
												
							</div>
							<div class="post_list post_list_style_1">
								<div class="alith_heading">
									<h2 class="alith_heading_patern_2">সাম্প্রতিক খবর</h2>
								</div>
                                @foreach($recents as $recent)
								<article class="row section_margin animate-box">
									<div class="col-md-3 animate-box">							
										<figure class="alith_news_img"><a href="{{$recent->url}}"><img src="{{$recent->avatar->md_url}}" alt=""/></a></figure>
									</div>
									<div class="col-md-9 animate-box">
										<h3 class="alith_post_title"><a href="{{$recent->url}}">{{$recent->title}}</a></h3>
										<div class="post_meta">
											<x-can-author :author="$recent->author" :can="$recent->show_author"></x-can-author>
											<span class="meta_categories">
                                                {!!$recent->categories->map(fn($cat)=>'<a href="'.$cat->url.'">'.$cat->title.'</a>')->join(',')!!}
                                              
                                               
                                            </span>
											<span class="meta_date">{{post_date($recent->updated_at)}}</span>
										</div>
									</div>
								</article>
                                @endforeach
								
											
							<div class="site-pagination animate-box">
							{{ $recents->onEachSide(10)->links() }}
							</div>
							</div>
						</div>
						<!--Start Sidebar-->
					<x-right-side-bar></x-right-side-bar>
						<!--End Sidebar-->
					</div>
					</div> <!--.primary-->
				</div>
			</div>
			<x-uper-footer></x-uper-footer>
	
</x-layout>