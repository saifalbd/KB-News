@if($can)
<a href="{{$author->url}}" class="meta_author_avatar"><img src="{{$author->avatar->url}}" alt="author details"/></a>
<span class="meta_author_name"><a href="{{$author->url}}" class="author">{{$author->name}}</a></span>
@else
<span class="meta_author_name"><a  class="author">নিজস্ব প্রতিনিধি</a></span>
@endif