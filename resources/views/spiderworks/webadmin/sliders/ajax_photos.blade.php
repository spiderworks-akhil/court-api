@if(count($photos)>0)
	@foreach($photos as $photo)
		<div class="col-md-3 media-preview-wrap parent">
			<a href="{{route($route.'.photo_edit', array('id'=>$photo->id, 'slider_id'=>$slider, 'type'=>$type))}}" class="webadmin-open-ajax-popup" title="update Image Details" data-popup-size="xlarge"><img src="{{ asset('public/'.$photo->media->thumb_file_path) }}"></a>
			<a href="{{route($route.'.photo-delete',[$slider, $photo->id, $type])}}" class="btn btn-danger delete-btn slider-photo-delete webadmin-btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{route($route.'.edit', [encrypt($slider)])}}">X</a>
		</div>
	@endforeach
@endif