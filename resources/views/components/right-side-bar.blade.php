<aside class="col-md-4 sidebar_right">
							<div class="sidebar-widget animate-box">					
								<div class="widget-title-cover"><h4 class="widget-title"><span>সর্বাধিক পঠিত</span></h4></div>
                                @foreach($populars as $key=>$popular)
								<div class="latest_style_1">  
									<div class="latest_style_1_item">                     
									  <span class="item-count vertical-align">{{$key+1}}.</span>
										<div class="alith_post_title_small">
											<a href="{{$popular->url}}"><strong>{{str_limit($popular->title,42)}}</strong></a>
											<p class="meta"><span>{{post_date($popular->updated_at)}}</span> <span>{{$popular->views_count}} views</span></p>
										</div>                                                  
										<figure class="alith_news_img">
											<a href="{{$popular->url}}"><img src="{{$popular->avatar->sm_url}}" alt=""/></a></figure>
									</div>
                                    @endforeach
								
									
								</div>
							</div> 
                            <!--.sidebar-widget-->
							<div class="sidebar-widget animate-box">
								<div class="widget-title-cover"><h4 class="widget-title"><span>Search</span></h4></div>
								<form action="#" class="search-form" method="get" role="search"> 
									<label> 
										<input type="search" name="s" value="" placeholder="Search …" class="search-field"> 
									</label> 
										<input type="submit" value="Search" class="search-submit">
								</form>
							</div> <!--.sidebar-widget-->
							<div class="sidebar-widget animate-box">					
								<div class="widget-title-cover"><h4 class="widget-title"><span>সর্বাধিক আলোচিত</span></h4></div>
								<div class="latest_style_2">  
                                    @foreach($trendings as $key=>$trend)
                                    @if(!$key)
									<div class="latest_style_2_item_first">							                                                  
										<figure class="alith_post_thumb_big">
											<span class="post_meta_categories_label">{{$trend->categories->pluck('title')->join(',')}}</span>
											<a href="{{$trend->url}}"><img src="{{$trend->avatar->md_url}}" alt=""/></a>
										</figure>
										<h3 class="alith_post_title">
											<a href="{{$trend->url}}"><strong>{{$trend->title}}</strong></a>
										</h3>
									</div>
                                    @else
									<div class="latest_style_2_item">
										<figure class="alith_news_img"><a href="{{$trend->url}}"><img src="{{$trend->avatar->sm_url}}" alt=""/></a></figure>
										<h3 class="alith_post_title"><a href="{{$trend->url}}">{{$trend->title}}</a></h3>
										<div class="post_meta">			
											<span class="meta_date">{{post_date($trend->updated_at)}}</span>
										</div>
									</div>
                                    @endif
                                    @endforeach
									
									
								</div>
							</div> <!--.sidebar-widget-->
							<div class="sidebar-widget animate-box">					
								<div class="widget-title-cover"><h4 class="widget-title"><span>Tags cloud</span></h4></div>
								<div class="alith_tags_all">
									@foreach($tags as $tag)
									<a href="#" class="alith_tagg">{{$tag->title}}</a>
									@endforeach
								</div>
							</div> <!--.sidebar-widget-->
						</aside>