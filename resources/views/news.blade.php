<x-layout>
    <x-slot name="meta">
        <title>কেবি এক্সপ্রেস</title>
        <meta property="og:title" content="news" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{config('app.url')}}" />

    </x-slot>



    <div class="container-fluid">
        <div class="container animate-box fadeInUp animated-fast">
            <div class="row">
                <div class="archive-header">
                    <div class="archive-title">
                        
                        <h2>সাম্প্রতিক খবর</h2>
                    </div>
                    <div class="archive-description">
                        <p>Auctor est phasellus eget tempor dictumst</p>
                    </div>
                    <div class="bread">
                        <ul class="breadcrumbs" id="breadcrumbs">
                            <li class="item-home"><a title="Home" href="{{route('home')}}" class="bread-link bread-home">হোম পেজ</a></li>
                            <li class="separator separator-home"> /</li>
                            <li class="item-current item-cat"><strong class="bread-current bread-cat">সাম্প্রতিক খবর</strong></li>
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
                        <div class="post_list post_list_style_1">
                            @foreach($posts as $key=>$post)
                            <article class="row section_margin animate-box fadeInUp animated-fast">
                                <div class="col-md-6 animate-box fadeInUp animated-fast">
                                    <figure class="alith_news_img"><a href="{{$post->url}}"><img src="{{$post->avatar->md_url}}" alt=""></a></figure>
                                </div>
                                <div class="col-md-6 animate-box fadeInUp animated-fast">
                                    <h3 class="alith_post_title"><a href="{{$post->url}}">{{$post->title}}</a></h3>
                                    <div class="post_meta">
                                    <x-can-author :author="$post->author" :can="$post->show_author"></x-can-author>
                                        <span class="meta_categories">{!!$post->categories->map(fn($cat)=>'<a href="'.$cat->url.'">'.$cat->title.'</a>')->join(',')!!}</span>
                                        <span class="meta_date">{{post_date($post->updated_at)}}</span>
                                    </div>
                                    <p class="alith_post_except">{{$post->description}}</p>
                                    <a href="{{$post->url}}" class="read_more">Read More</a>
                                </div>
                            </article>
                            @endforeach
                         
                      

                            <div class="site-pagination animate-box fadeInUp animated-fast">
                            {{ $posts->onEachSide(10)->links() }}
                              
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