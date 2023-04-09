<x-layout>
<x-slot name="meta">
		<title>কেবি এক্সপ্রেস /{{$category->title}}</title>
		<meta property="og:title" content="{{$category->title}}" />
		<meta property="og:type" content="article" />
		<meta property="og:url" content="{{config('app.url')}}" />
		
	</x-slot>



    <div class="container-fluid">
        <div class="container animate-box fadeInUp animated-fast">
            <div class="row">
                <div class="archive-header">
                    <div class="archive-title">
                        <h2>{{$category->title}}</h2>
                    </div>
                    <div class="archive-description">
                        <p>Auctor est phasellus eget tempor dictumst</p>
                    </div>
                    <div class="bread">
                        <ul class="breadcrumbs" id="breadcrumbs">
                            <li class="item-home"><a title="Home" href="{{route('home')}}" class="bread-link bread-home">হোম পেজ</a></li>
                            <li class="separator separator-home"> /</li>
                            <li class="item-current item-cat"><strong class="bread-current bread-cat">{{$category->title}}</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="transform: none;">
        <div class="container" style="transform: none;">
            <div class="primary margin-15" style="transform: none;">
                <div class="row" style="transform: none;">
                    <div class="col-md-8">
                        <div class="post_list grid-blance">
                            <div class="row">
                                @foreach($posts as $post)
                                <article class="col-md-6 animate-box section_margin fadeInUp animated-fast">
                                    <div class="wrap">
                                        <figure class="alith_news_img">
                                            <span class="post_meta_categories_label">{{$category->title}}</span>
                                            <a href="{{$post->url}}"><img src="{{$post->avatar->md_url}}" alt=""></a>
                                        </figure>
                                    </div>
                                    <h3 class="alith_post_title"><a href="{{$post->url}}">{{$post->title}}</a></h3>
                                    <div class="post_meta">
                                    <x-can-author :author="$post->author" :can="$post->show_author"></x-can-author>
                                       
                                        <span class="meta_date">{{post_date($post->updated_at)}}</span>
                                    </div>
                                    <p class="alith_post_except">{{$post->description}}</p>
                                    <div class="line-space"></div>
                                </article>
                                @endforeach

                            </div>
                        </div>
                        <div class="site-pagination animate-box fadeInUp animated-fast">
                        {{ $posts->onEachSide(10)->links() }}
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