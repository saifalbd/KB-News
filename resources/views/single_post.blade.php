<x-layout>
	<x-slot name="meta">
		<title>কেবি এক্সপ্রেস /{{$post->title}}</title>
		<meta property="og:title" content="{{$post->title}}" />
		<meta property="og:description" content="{{$post->description}}">
		<meta property="og:type" content="article" />
		<meta property="og:url" content="{{$post->url}}" />
		<meta property="og:image" content="{{$post->avatar->sm_url}}" />
	</x-slot>

	<div class="container-fluid">
		<div class="container animate-box">
			<div class="row">
				<div class="post-header">
					<div class="bread">
						<ul class="breadcrumbs" id="breadcrumbs">
							<li class="item-home"><a title="Home" href="{{route('home')}}" class="bread-link bread-home">হোম পেজ</a></li>
							<li class="separator separator-home"> /</li>
							<li class="item-current item-cat"><a title="Home" href="{{$category->url}}" class="bread-link bread-home">{{$category->title}}</a></li>
							<li class="separator separator-home"> /</li>
							<li class="item-current item-cat"><strong class="bread-current bread-cat">{{str_limit($post->title,20)}}</strong></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="container">
			<div class="primary margin-15">
				<div class="row">
					<div class="col-md-8">
						<article class="section_margin">
							<figure class="alith_news_img animate-box"><a href="../../html/hewo/single.html"><img src="{{$post->avatar->url}}" alt="" /></a></figure>
							<div class="post-content">
								<div class="single-header">
									<h3 class="alith_post_title">{{$post->title}}</h3>
									<div class="post_meta">
									<x-can-author :author="$post->author" :can="$post->show_author"></x-can-author>
										<span class="meta_categories">
											{!!$post->categories->map(fn($cat)=>'<a href="'.$cat->url.'">'.$cat->title.'</a>')->join(',')!!}
										</span>
										<span class="meta_date">{{post_date($post->updated_at)}}</span>
									</div>
								</div>
								<div class="single-content animate-box">
									<p class="alith_post_except animate-box">{{$post->description}}</p>
									<div class="dropcap column-2 animate-box">
										{!!$post->body!!}
									</div>
									<div class="post-tags">
										<div class="post-tags-inner">
										@foreach($post->tags as $tag)
											<a rel="tag" href="{{$tag->url}}">#{{$tag->title}}</a>
											@endforeach
											
										</div>
									</div>
									<div class="post-share">
										<ul>
											<li title="Share" class="facebook"><a  href="https://www.facebook.com/sharer.php?u={{$post->url}}" target="_blank"
   rel="noopener"><i class="fa fa-facebook"></i></a></li>
											<li title="Share" class="twitter"><a href="https://twitter.com/intent/tweet?url={{$post->url}}"><i class="fa fa-twitter"></i></a></li>
											<li title="Share" class="twitter"><a href="https://api.whatsapp.com/send?text={{$post->url}}"><i class="fa fa-whatsapp"></i></a></li>
											<li title="Share" class="instagram"><a href=""><i class="fa fa-instagram"></i></a></li>
										</ul>
									</div>
									@if($post->show_author)
									<div class="post-author section_margin_40">
										<figure><a href="{{$post->author->url}}"><img style="width:100px;" src="{{$post->author->avatar->sm_url}}"></a></figure>
										<div class="post-author-info">
											<h3><a href="{{$post->author->url}}">{{$post->author->name}}</a></h3>
											<p>Ouch oh alas crud unnecessary invaluable some goodness opposite hello since audacious far barring and absurdly much boa</p>
											<ul>
												<li><a href=""><i class="fa fa-facebook"></i></a></li>
												<li><a href=""><i class="fa fa-twitter"></i></a></li>
												<li><a href=""><i class="fa fa-google-plus"></i></a></li>
											</ul>
										</div>

									</div>
									@endif
									<div class="post-related section_margin_40">
										<div class="row">
											<div class="col-md-6">
												<div class="sidebar-widget">
													<div class="widget-title-cover">
														<h4 class="widget-title"><span>প্রাসঙ্গিক খবর</span></h4>
													</div>
													<div class="latest_style_3">
														@foreach($relevantNews as $key=>$relevant)
														<div class="latest_style_3_item">
															<span class="item-count vertical-align">{{$key+1}}.</span>
															<div class="alith_post_title_small">
																<a href="{{$relevant->url}}"><strong>{{$relevant->title}}</strong></a>
															</div>
														</div>
														@endforeach
														
														
														
													</div>
												</div>
											</div> <!--post-related-->
											<div class="col-md-6">
												<div class="post-navigation">
													<div class="latest_style_2">
														@if($prevPost)
														<h5><span>Preview Post</span></h5>
														<div class="latest_style_2_item">
															<figure class="alith_news_img"><a href="{{$prevPost->url}}"><img class="hover_grey" src="{{$prevPost->avatar->sm_url}}" alt=""></a></figure>
															<h3 class="alith_post_title"><a href="{{$prevPost->url}}">{{$prevPost->title}}</a></h3>
														</div>
														@endif
														@if($nextPost)
														<h5><span>Next Post</span></h5>
														<div class="latest_style_2_item">
														<figure class="alith_news_img"><a href="{{$nextPost->url}}"><img class="hover_grey" src="{{$nextPost->avatar->sm_url}}" alt=""></a></figure>
															<h3 class="alith_post_title"><a href="{{$nextPost->url}}">{{$nextPost->title}}</a></h3>
														</div>
														@endif
													</div>
												</div>
											</div>
										</div>
									</div> <!--post-related and navigation-->
								</div> <!--single content-->
								<div class="single-comment">
									<section id="comments">
										<h4 class="single-comment-title">Comments</h4>
										<div class="comments-inner clr">
											<div class="comments-title">
												<p>There are 3 comments for this article</p>
											</div>
											<ol class="commentlist">
												<li id="li-comment-4">
													<article class="comment even thread-even depth-1 clr" id="comment-4">
														<div class="comment-author vcard"> <img width="60" height="60" src="../../html/hewo/assets/images/post-author-avatar.jpg" alt=""></div>
														<div class="comment-details clr ">
															<header class="comment-meta"> <strong class="fn"> Steven Jobs </strong> <span class="comment-date">July 4, 2017 7:25 am </span></header>
															<div class="comment-content entry clr">
																<p>dived wound factual legitimately delightful goodness fit rat some lopsidedly far when.</p>
															</div>
															<div class="reply comment-reply-link-div"> <a aria-label="Reply to spadmin" href="#respond" class="comment-reply-link" rel="nofollow">Reply</a></div>
														</div>
													</article>
													<ul class="children">
														<li id="li-comment-6">
															<article class="comment odd alt depth-2 clr" id="comment-6">
																<div class="comment-author vcard"><img width="60" height="60" src="../../html/hewo/assets/images/post-author-avatar.jpg" alt=""></div>
																<div class="comment-details clr ">
																	<header class="comment-meta"> <strong class="fn"> Jim Calist </strong> <span class="comment-date">July 16, 2017 1:29 am </span></header>
																	<div class="comment-content entry clr">
																		<p>Slung alongside jeepers hypnotic legitimately some iguana this agreeably triumphant pointedly far</p>
																	</div>
																	<div class="reply comment-reply-link-div"><a aria-label="Reply to spadmin" href="#respond" class="comment-reply-link" rel="nofollow">Reply</a></div>
																</div>
															</article>
														</li>
													</ul>
												</li>
												<li id="li-comment-5">
													<article class="comment even thread-odd thread-alt depth-1 clr" id="comment-5">
														<div class="comment-author vcard"> <img width="60" height="60" src="../../html/hewo/assets/images/post-author-avatar.jpg" alt=""></div>
														<div class="comment-details clr ">
															<header class="comment-meta"> <strong class="fn"> Steven Jobs </strong> <span class="comment-date">July 4, 2017 7:25 am </span></header>
															<div class="comment-content entry clr">
																<p>jeepers unscrupulous anteater attentive noiseless put less greyhound prior stiff ferret unbearably cracked oh.</p>
															</div>
															<div class="reply comment-reply-link-div"><a aria-label="Reply to spadmin" href="#respond" class="comment-reply-link" rel="nofollow">Reply</a></div>
														</div>
													</article>
												</li>
												<li id="li-comment-85">
													<article class="comment byuser comment-author-spadmin bypostauthor odd alt thread-even depth-1 clr" id="comment-85">
														<div class="comment-author vcard"><img width="60" height="60" src="../../html/hewo/assets/images/post-author-avatar.jpg" alt=""></div>
														<div class="comment-details clr ">
															<header class="comment-meta"> <strong class="fn"> Steven Jobs <span class="author-badge"></span> </strong> <span class="comment-date">May 10, 2018 2:41 am </span></header>
															<div class="comment-content entry clr">
																<p>So sparing more goose caribou wailed went conveniently burned the the the and that save that adroit gosh and sparing armadillo grew some overtook that magnificently that</p>
															</div>
															<div class="reply comment-reply-link-div"><a aria-label="Reply to spadmin" href="#respond" class="comment-reply-link" rel="nofollow">Reply</a></div>
														</div>
													</article>
												</li>
												<li id="li-comment-86">
													<article class="comment byuser comment-author-spadmin bypostauthor even thread-odd thread-alt depth-1 clr" id="comment-86">
														<div class="comment-author vcard"><img width="60" height="60" src="../../html/hewo/assets/images/post-author-avatar.jpg" alt=""></div>
														<div class="comment-details clr ">
															<header class="comment-meta"> <strong class="fn"> Steven Jobs <span class="author-badge"></span> </strong> <span class="comment-date">May 10, 2018 2:42 am </span></header>
															<div class="comment-content entry clr">
																<p>Circuitous gull and messily squirrel on that banally assenting nobly some much rakishly goodness that the darn abject hello left because unaccountably spluttered unlike a aurally since contritely thanks</p>
															</div>
															<div class="reply comment-reply-link-div"><a aria-label="Reply to spadmin" href="#respond" class="comment-reply-link" rel="nofollow">Reply</a></div>
														</div>
													</article>
												</li>
											</ol> <!--comment list-->
											<nav role="navigation" class="comment-navigation clr">
												<div class="nav-previous span_1_of_2 col col-1"></div>
												<div class="nav-next span_1_of_2 col"> <a href="#comments">Newer Comments →</a></div>
											</nav> <!--comment nav-->
											<div class="comment-respond" id="respond">
												<h3 class="comment-reply-title" id="reply-title">Leave a Reply <small><a href="#respond" id="cancel-comment-reply-link" rel="nofollow"><i class="fa fa-times"></i></a></small></h3>
												<form novalidate="" class="comment-form" id="commentform" method="post" action="">
													<p class="comment-notes"><span id="email-notes">Your email address will not be published.</span></p>
													<div class="row">
														<div class="comment-form-author col-sm-12 col-md-6"> <label for="author">Name (optional)</label> <input type="text" size="30" value="" placeholder="Your name *" name="author" id="author"></div>
														<div class="comment-form-email col-sm-12 col-md-6"> <label for="email">Email (optional)</label> <input type="email" size="30" value="" placeholder="Email *" name="email" id="email"></div>
													</div>
													<p class="comment-form-comment"><label for="comment">Comment</label><textarea aria-required="true" placeholder="Your Comment" rows="8" cols="45" name="comment" id="comment"></textarea></p>
													<p class="form-submit"><input type="submit" value="Post Comment" class="submit" id="submit" name="submit"> <input type="hidden" id="comment_post_ID" value="80" name="comment_post_ID"> <input type="hidden" value="0" id="comment_parent" name="comment_parent"></p>
												</form>
											</div> <!--comment form-->
										</div>
									</section>
								</div>
							</div>
						</article>
						<div class="single-more-articles single-disable-inview">
							<h4><span>You might be interested in</span></h4>
							<span class="single-more-articles-close-button"><i class="fa fa-times" aria-hidden="true"></i></span>
							<div class="latest_style_2">
								<div class="latest_style_2_item">
									<figure class="alith_news_img"><a href="../../html/hewo/single.html"><img class="hover_grey" src="../../html/hewo/assets/images/thumb-square-1.png" alt=""></a></figure>
									<h3 class="alith_post_title"><a href="../../html/hewo/single.html">Magna aliqua ut enim ad minim veniam</a></h3>
								</div>
								<div class="latest_style_2_item">
									<figure class="alith_news_img"><a href="../../html/hewo/single.html"><img class="hover_grey" src="../../html/hewo/assets/images/thumb-square-2.png" alt=""></a></figure>
									<h3 class="alith_post_title"><a href="../../html/hewo/single.html">Magna aliqua ut enim ad minim veniam</a></h3>
								</div>
							</div>
						</div> <!--end single more articles-->
					</div>
					<!--Start Sidebar-->
					<x-right-side-bar></x-right-side-bar>
					<!--End Sidebar-->
				</div>
			</div> <!--.primary-->
		</div>
	</div>

</x-layout>