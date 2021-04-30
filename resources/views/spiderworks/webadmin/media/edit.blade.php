<div class="settings-item w-100 confirm-wrap">
  <div class="row no-margin">
  	<div class="col-md-7">
  		<div class="img-container-edit">
        @if($file->media_type == 'Image')
          <img  src="{{ asset($file->file_path) }}" alt="{{$file->file_name}}" style="width: 100%">
        @elseif($file->media_type == 'Video')
          <div class="embed-responsive embed-responsive-16by9">
            <video class="embed-responsive-item" controls>
              <source src="{{ asset($file->file_path) }}" type="{{$file->file_type}}">
              Your browser does not support the video tag.
            </video>
          </div>
        @elseif($file->media_type == 'Audio')
          <div>
             <audio controls>
              <source src="{{ asset($file->file_path) }}" type="{{$file->file_type}}">
              Your browser does not support the audio element.
            </audio> 
          </div>
        @else
          <div>
            <img  src="{{ asset('public/'.$file->thumb_file_path) }}" alt="{{$file->file_name}}">
          </div>
        @endif
      </div>
  	</div>
  	<div class="col-md-5 img-details-edit">
  		    <div class="img-details">
            <p><b>File Path: </b> {{ asset('public/'.$file->file_path) }} </p>
            <p><b>File Name: </b> {{$file->file_name}}</p>
            <p><b>File Size: </b> {{$file->file_size}} </p>
            <p><b>Created On: </b> <?php echo date('d M, Y h:i A', strtotime($file->created_at));?></p>
            <p><b>File Type: </b> {{$file->file_type}}</p>
            @if($file->media_type == 'Image')
              <p><b>File Dimensions: </b> {{$file->dimensions}}</p>
            @endif
          </div>
          <form method="POST" action="{{ route($route.'.store-extra', ['id'=>$file->id]) }}" id="mediaExtraFrm">
            @csrf
            <div class="image_details_edit">
              @if($file->media_type == 'Image')
                <div class="form-group required">
                  <input type="text" name="alt_text" class="form-control" value="{{$file->alt_text}}" placeholder="Alt Text" id="inputAlt">
                </div>
              @else
              <div class="form-group required">
                  <input type="text" name="title" class="form-control" value="{{$file->title}}" placeholder="Title">
              </div>
              @endif
              <div class="form-group required">
                  <textarea name="description" class="form-control" id="inputDescription" rows="3" placeholder="Description">{{$file->description}}</textarea>
              </div>
              <div class="form-group required">
                  <button type="button" class="btn btn-primary" id="miniweb-ajax-form-submit-btn" data-force-open="true">Save</button> 
              </div>
              <div class="alert alert-success" style="display: none;" id="mediaExtraMsg" >
              </div>
            </div>
          </form>
  	</div>
  </div>
</div>