@foreach($items as $key=>$item)
	<li @if($item->id == $parent) class="open active" @elseif($cur_url == $item->slug) class="active" @endif>
		<a href="{{url($item->slug)}}"  class="detailed">
			<span class="title">{{$item->name}}</span>
			@if(isset($item->children))
				<span class="arrow"></span>
			@endif
		</a>
		<span class="icon-thumbnail">{{substr($item->name,0,2)}}</span>
		@if(isset($item->children))
			<ul class="sub-menu">
		    	@include('spiderworks.webadmin._partials.menu', ['items'=>$item->children, 'parent'=>$parent, 'cur_url'=>$cur_url])
		    </ul>
		@endif
	</li>
@endforeach