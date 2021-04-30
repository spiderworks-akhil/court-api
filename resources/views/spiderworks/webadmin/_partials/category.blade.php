@if ($category->children()->count() > 0 )
       
    @foreach($category->children as $category)
    	<option value="{{$category->id}}" @if($category->id == $selected) selected="selected" @endif>
    		@for($i=0; $i<$depth; $i++)
	    		&nbsp;-
	    	@endfor
    		&nbsp;{{$category->name}}
    	</option>
        @include('spiderworks.webadmin._partials.category', ['category'=>$category, 'depth'=>++$depth, 'selected'=>$selected])
    @endforeach

@endif