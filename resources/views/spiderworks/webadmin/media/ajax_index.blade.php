@foreach($files as $file)
	<div class="media-preview-wrap parent" style="width: 120px;height: 120px;margin: 5px;overflow: hidden">
		<input type="checkbox" name="ids[]" class="bulk-selet-media"  value="{{$file->id}}">
		@if($file->media_type == "Image")
			<a href="{{route($route.'.edit', [encrypt($file->id)])}}" class="webadmin-open-ajax-popup" title="Edit Image Details" data-popup-size="large"><img src="{{ asset('public/'.$file->thumb_file_path) }}"></a>

			<div style="font-size: 10px">
				RES: {{$file->dimensions}}
			</div>

		@else
			<div class="attachment-preview" style="width: auto">
				<div class="thumbnail_new">
					<div class="centered">
						<a href="{{route($route.'.edit', [encrypt($file->id)])}}" class="webadmin-open-ajax-popup icon" title="Edit Document Details" data-popup-size="large"><img src="{{ asset('public/'.$file->thumb_file_path) }}" class="icon"></a>
					</div>
					<div class="filename" style="font-size: 10px">
						<a href="{{route($route.'.edit', [encrypt($file->id)])}}" class="webadmin-open-ajax-popup" title="Edit Document Details" data-popup-size="large">{{$file->file_name}}</a>
					</div>
				</div>
			</div>
		@endif
		<a href="{{route($route.'.index.post')}}" data-id="{{$file->id}}" class="delete-btn media-delete">X</a>
		<a href="{{route($route.'.edit', [encrypt($file->id)])}}" data-id="{{$file->id}}" class="edit-btn webadmin-open-ajax-popup" title="Edit Image Details" data-popup-size="large"><small><i class="fa fa-edit"></i></small></a>

	</div>
@endforeach
<div class="col-md-12 media-nav text-right">
	<input type="hidden" id="currentPage" value="{{$page}}">
	{{ $files->appends(['req' => $req])->links() }}
</div>