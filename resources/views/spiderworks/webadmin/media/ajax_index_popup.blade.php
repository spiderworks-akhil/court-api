@foreach($files as $key=>$file)
	<div class="col-md-1 media-previe-wrap">
		<div class="thumbnail text-center">
			@if($file->media_type == "Image")
				<img src="{{ asset('public/'.$file->thumb_file_path) }}" class="checkable" id="{{$file->id}}" data-extra-attr="{{$holder_attr}}" data-original-src="{{ asset('public/'.$file->file_path) }}">
				
			@else
				<img src="{{ asset('public/'.$file->thumb_file_path) }}" class="icon checkable" id="{{$file->id}}" data-original-src="{{ asset('public/'.$file->file_path) }}" data-type="{{$file->file_type}}" data-extra-attr="{{$holder_attr}}">
				
			@endif
		</div>
	</div>
	@if(($key+1)%4 == 0)
	<div class="clearfix"></div>
	@endif
@endforeach
<div class="col-md-12 media-popup-nav text-right">
	<input type="hidden" id="currentPage" value="{{$page}}">
	{{ $files->appends(['req' => $req])->links() }}
</div>