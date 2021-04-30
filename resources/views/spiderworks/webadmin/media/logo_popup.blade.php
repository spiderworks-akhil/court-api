<div class="row">
  <div class="col-md-12">
	   <div class="panel with-nav-tabs panel-default">
                <div class="panel-body">
                          <div class="col-md-12 media-list-modal" id="mediaList">
                            @foreach($files as $key=>$file)
                              <div class="col-md-3 media-previe-wrap">
                                <div class="thumbnail text-center">
                                    <img src="{{ asset('public/'.$file->file_path) }}" class="checkable" id="{{$file->id}}" data-original-src="{{ asset('public/'.$file->file_path) }}">
                                    <div class="caption">
                                      <p>{{$file->file_name}}</p>
                                    </div>
                                </div>
                              </div>
                              @if(($key+1)%4 == 0)
                              <div class="clearfix"></div>
                              @endif
                            @endforeach
                          </div>
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-primary" id="addLogo"><i class="glyphicon glyphicon-plus-sign"></i> Add Logo</button>
                </div>
            </div>
    </div>
</div>
<script type="text/javascript">
    var bd_id = '{{ Input::get('modal_id') }}';
    if(bd_id)
    {
      var bd = BootstrapDialog.getDialog(bd_id);
      bd.setTitle('Add Logo');
      bd.setSize(BootstrapDialog.SIZE_WIDE); 
    }
</script>