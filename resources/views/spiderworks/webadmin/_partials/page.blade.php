@if ($page->children()->count() > 0 )
       
    @foreach($page->children as $page)
    	<option value="{{$page->id}}" @if($page->id == $selected) selected="selected" @endif>
    		@for($i=0; $i<$depth; $i++)
	    		&nbsp;-
	    	@endfor
    		&nbsp;{{$page->name}}
    	</option>
        @include('spiderworks.webadmin._partials.page', ['page'=>$page, 'depth'=>++$depth, 'selected'=>$selected])
    @endforeach

@endif