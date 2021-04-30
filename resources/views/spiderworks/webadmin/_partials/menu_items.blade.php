@foreach($items as $key=>$item)
	<li class="dd-item" data-id="{{$item->menu_nextable_id}}">
		<div class="dd-handle accord-header"><span class="menu-title">{{$item->title}}</span><span class="pull-right fa fa-angle-down toggle-arraow dd-nodrag"></span></div>
		<div class="accord-content">
			<div class="form-group required">
				<label class="control-label" for="inputCode">Navigation Label</label>
				<input type="text" name="menu[{{$item->menu_nextable_id}}][text]" class="form-control menu-title-input" value="{{$item->title}}"/>
			</div>
			@if($item->menu_type == 'custom_link')
				<div class="form-group required">
					<label class="control-label" for="inputCode">Url</label>
					<input type="text" name="menu[{{$item->menu_nextable_id}}][url]" class="form-control" value="{{$item->url}}"/>
				</div>
				<div class="form-group required">
					<div class="checkbox">
						<input type="checkbox" name="menu[{{$item->menu_nextable_id}}][target_blank]" id="checkbox-{{$item->menu_nextable_id}}" @if($item->target_blank==1) checked="checked" @endif /> <label for="checkbox-{{$item->menu_nextable_id}}"> New Window</label>
					</div>
				</div>
				<input type="hidden" name="menu[{{$item->menu_nextable_id}}][original_title]" value="{{$item->original_title}}"/>
			@else
				<input type="hidden" name="menu[{{$item->menu_nextable_id}}][id]" value="{{$item->linkable_id}}"/>
			@endif
			<input type="hidden" name="menu[{{$item->menu_nextable_id}}][menu_nextable_id]" value="{{$item->menu_nextable_id}}"/>
			<p class="menu-original-text"> Original: @if($item->menu_type == 'custom_link') {{$item->original_title}} @else @if($item->linkable) {{$item->linkable->name}} @endif @endif</p>
			<p><a href="javascript:void(0)" class="remove-menu">Remove</a></p>
		</div>
		@if(isset($item->children))
			<ol class="dd-list">
				@include('spiderworks.webadmin._partials.menu_items', ['items'=>$item->children])
	        </ol>
		@endif
	</li>
@endforeach