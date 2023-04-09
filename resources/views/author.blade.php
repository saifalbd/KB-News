<x-layout>
    <x-slot name="meta">
        <title>কেবি এক্সপ্রেস /সত্যের খোঁজে বদ্ধপরিকর</title>
    </x-slot>

    <div class="container-fluid">
        <div class="container animate-box fadeInUp animated-fast">
            <div class="row">
                <div class="archive-header">
                    <div class="post-author-info">
                        <img class="section_margin_20" src="{{$author->avatar->sm_url}}" alt="author details">
                        <div class="archive-title">
                            <h2>{{$author->name}}</h2>
                        </div>
                        <p>Ouch oh alas crud unnecessary invaluable some goodness opposite hell and absurdly much boa</p>
                        <ul>
                            <li><a href=""><i class="fa fa-facebook"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa fa-google-plus"></i></a></li>
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
                        <h3 class="section_margin">Articles written by {{$author->name}}</h3>
                        <div class="post_list post_list_style_1">
                            @foreach($posts as $post)
                            <article class="row section_margin animate-box fadeInUp animated-fast">
                                <div class="col-md-4 animate-box fadeInUp animated-fast">
                                    <figure class="alith_news_img"><a href="{{$post->url}}"><img src="{{$post->avatar->md_url}}" alt=""></a></figure>
                                </div>
                                <div class="col-md-8 animate-box fadeInUp animated-fast">
                                    <h3 class="alith_post_title"><a href="{{$post->url}}">{{$post->title}}</a></h3>
                                    <div class="post_meta">
                                        <span class="meta_categories"><a href="archive.html">Politics</a>, <a href="archive.html">News</a></span>
                                        <span class="meta_date">{{post_date($post->updated_at)}}</span>
                                    </div>
                                    <p class="alith_post_except">{{$post->description}} </p>
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