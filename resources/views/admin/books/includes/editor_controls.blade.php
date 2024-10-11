@php $objects_list = getSvgFiles('assets/books-editor/objects/');
$infolinks_list = getSvgFiles('assets/books-editor/infolinks/');
$misc_list = getSvgFiles('assets/books-editor/misc/');
 @endphp
 
 
<div class="editor-controls-holder">
	<div class="editor-parent-nav">
		<ul class="nav" id="myTab" role="tablist">
  
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="infolinks-tab" data-toggle="tab" data-target="#infolinks" type="button" role="tab" aria-controls="profile" aria-selected="false">Clipboard</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="layers-tab" data-toggle="tab" data-target="#layers" type="button" role="tab" aria-controls="contact" aria-selected="false">Layers</button>
		</li>
		</ul>
	</div>
	<div class="editor-controls tab-pane fade" id="infolinks" role="tabpanel" aria-labelledby="profile-tab">
		<ul class="nav nav-pills" id="myTab3" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="infolinks-tab{{$data_id}}" data-toggle="tab" href="#infolinks{{$data_id}}" role="tab" aria-controls="infolinks{{$data_id}}" aria-selected="true">Infolinks</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="objects-tab{{$data_id}}" data-toggle="tab" href="#objects{{$data_id}}" role="tab" aria-controls="objects{{$data_id}}" aria-selected="true">Objects</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="misc-tab{{$data_id}}" data-toggle="tab" href="#misc{{$data_id}}" role="tab" aria-controls="misc{{$data_id}}" aria-selected="true">Miscellaneous</a>
			</li>
		</ul>
		
		<div class="tab-content" id="myTabContent2">
			<div class="tab-pane mt-3 fade  show active " id="infolinks{{$data_id}}" role="tabpanel" aria-labelledby="infolinks-tab{{$data_id}}">
				<ul class="editor-objects">
					@if( !empty( $infolinks_list ) )
						@foreach( $infolinks_list as $infolinkObj)
							@php $object_path = isset( $infolinkObj['path'] )? $infolinkObj['path'] : ''; 
							$object_slug = isset( $infolinkObj['slug'] )? $infolinkObj['slug'] : '';
							$object_title = isset( $infolinkObj['title'] )? $infolinkObj['title'] : '';
							@endphp
							<li>
								<a href="javascript:;" title="{{$object_title}}" class="control-tool-item"
								data-drag_type="infolink" data-object_path="/assets/books-editor/infolinks/{{$object_path}}" data-item_path="{{$object_path}}" data-drag_object="{{$object_slug}}">
									<img src="/assets/books-editor/infolinks/{{$object_path}}" style="width:42px">
								</a>
							</li>
						@endforeach
					@endif
					
				</ul>
			</div>
			<div class="tab-pane mt-3 fade" id="objects{{$data_id}}" role="tabpanel" aria-labelledby="objects-tab{{$data_id}}">
					<ul class="editor-objects">
					@if( !empty( $objects_list ) )
						@foreach( $objects_list as $objectObj)
							@php $object_path = isset( $objectObj['path'] )? $objectObj['path'] : ''; 
							$object_slug = isset( $objectObj['slug'] )? $objectObj['slug'] : '';
							$object_title = isset( $objectObj['title'] )? $objectObj['title'] : '';
							@endphp
							<li>
								<a href="javascript:;" title="{{$object_title}}" class="control-tool-item"
								data-drag_type="stage_objects" data-object_path="/assets/admin/editor/objects/{{$object_path}}" data-item_path="{{$object_path}}" data-drag_object="{{$object_slug}}">
									<img src="/assets/books-editor/objects/{{$object_path}}" style="width:65px">
								</a>
							</li>
						@endforeach
					@endif
					</ul>
			</div>
			<div class="tab-pane mt-3 fade" id="misc{{$data_id}}" role="tabpanel" aria-labelledby="misc-tab{{$data_id}}">
					<ul class="editor-misc">
					@if( !empty( $misc_list ) )
						@foreach( $misc_list as $miscObj)
							@php $object_path = isset( $miscObj['path'] )? $miscObj['path'] : ''; 
							$object_slug = isset( $miscObj['slug'] )? $miscObj['slug'] : '';
							$object_title = isset( $miscObj['title'] )? $miscObj['title'] : '';
							@endphp
							<li>
								<a href="javascript:;" title="{{$object_title}}" class="control-tool-item"
								data-drag_type="misc" data-object_path="/assets/admin/editor/misc/{{$object_path}}" data-item_path="{{$object_path}}" data-drag_object="{{$object_slug}}">
									<img src="/assets/books-editor/misc/{{$object_path}}" style="width:65px">
								</a>
							</li>
						@endforeach
					@endif
					</ul>
			</div>
		</div>
		
	</div>
	<div class="editor-objects-block tab-pane fade" id="layers" role="tabpanel" aria-labelledby="profile-tab">
		<h5>Layers</h5>
		<ul class="editor-objects-list">
		@php
			if( isset( $bookPage->id ) && !empty( $bookPage->pageObjects->where('status','active') )){
				foreach( $bookPage->pageObjects->where('status','active') as $bookPageItemObj){
					
					echo '<li data-id="rand_'.$bookPageItemObj->id.'" data-field_postition="2">'.$bookPageItemObj->item_slug.' <i class="fa fa-trash"></i><i class="lock-layer fa fa-unlock"></i><i class="fa fa-sort"></i><i class="fa fa-copy"></i></li>';
					
				}
			}
		@endphp
		
		</ul>
	</div>
</div>


<div class="option-fields-block hide">

		
		<div class="page-settings-fields">
			<div class="option-field-item">
				<label>Background Color</label>
				<div class="input-group">
					<input type="text" name="background_color" class="form-control trigger_field colorpickerinput"
							   value="#ffffff" data-field_id="page_background" data-field_name="background"
					   data-field_type="page_style" data-id="">
						<div class="input-group-append">
							<div class="input-group-text">
								<i class="fas fa-fill-drip"></i>
							</div>
						</div>
					</div>	   
			</div>
			<div class="option-field-item">
				<label>Height</label>
				<div class="input-group">
					<input type="number" name="page_height" class="form-control trigger_field"
							   value="800" data-field_id="page_height" data-field_name="height" min="800"
					   data-field_type="page_style" data-id="">
					</div>	   
			</div>
			
			<div class="option-field-item">
				<label class="custom-switch pl-0">
					<input type="hidden" name="page_graph" class="trigger_field" value="0" data-field_id="page_graph" data-field_name="graph" data-field_type="page_style" data-id="">
					<input type="checkbox" name="page_graph_radio" id="rtlSwitch" value="1" class="custom-switch-input">
					<span class="custom-switch-indicator"></span>
					<label class="custom-switch-description mb-0 cursor-pointer" for="rtlSwitch">Enable Graph</label>
				</label>
			</div>
		</div>

	@if( !empty( $infolinks_list ) )
		@foreach( $infolinks_list as $infolinkObj)
			@php 
			$object_slug = isset( $infolinkObj['slug'] )? $infolinkObj['slug'] : '';
			@endphp
			<div class="infobox-{{$object_slug}}-fields">
			
				<div class="option-field-item">
					<label>Info Title</label>
					<div class="input-group">
						<input type="text" name="info_title" class="form-control trigger_field" value="" data-field_id="info_title" data-field_name="info_title" data-field_type="infolink_data" data-id="">
					</div>	   
				</div>
				
				@if( $object_slug != 'quiz')
				<div class="option-field-item">
					<label>Info Details</label>
					<div class="input-group">
						<textarea cols="10" rows="5" name="info_content" class="form-control trigger_field" value="" data-field_id="info_content" data-field_name="info_content" data-field_type="infolink_data" data-id=""></textarea>
					</div>	   
				</div>
				@endif
				
				@if( $object_slug == 'quiz')
				<div class="option-field-item">
					<label class="input-label">Questions</label>


					<select data-field_id="questions_ids" multiple="multiple"
							data-search-option="questions_ids"
							class="trigger_field form-control search-questions-select2" data-field_type="select"
							data-placeholder="Search Question" data-id="">
					</select>
				</div>

				<div class="option-field-item">
					<label class="input-label">Dependent Info</label>
					<select data-field_id="dependent_info" multiple="multiple"
							data-search-option="dependent_info"
							class="trigger_field form-control search-infobox-select2" data-field_type="select_info"
							data-placeholder="Search Infobox" data-id="">
					</select>
				</div>

				<div class="option-field-item">
					<label class="input-label">No of Attempts</label>
					<input type="text" class="form-control trigger_field" data-field_id="no_of_attempts" data-field_type="textarea" data-id=""></input>
				</div>
				@endif
				
				<div class="option-field-item">
					<label>Size (px)</label>
					<div class="input-group">
						<input type="number" name="info_width" class="form-control trigger_field"
								   value="42" data-field_id="info_width" data-field_name="width"
						   data-field_type="style" data-id="">
							
						</div>	   
				</div>
				<div class="option-field-item">
					<label>Fill Color</label>
					<div class="input-group">
						<input type="text" name="background_color" class="form-control trigger_field colorpickerinput"
								   value="#ffffff" data-field_id="fill_color" data-field_name="fill"
						   data-field_type="svg_path_style" data-id="">
							<div class="input-group-append">
								<div class="input-group-text">
									<i class="fas fa-fill-drip"></i>
								</div>
							</div>
						</div>	   
				</div>
			</div>
		@endforeach
	@endif
	
	@if( !empty( $objects_list ) )
		@foreach( $objects_list as $objectObj)
			@php 
			$obj_slug = isset( $objectObj['slug'] )? $objectObj['slug'] : '';
			$svg_code = isset( $objectObj['svg_code'] )? $objectObj['svg_code'] : '';
			@endphp
			<div class="infobox-{{$obj_slug}}-fields">
				<div class="option-field-item">
					<label>Size (px)</label>
					<div class="input-group">
						<input type="number" name="object_width" class="form-control trigger_field"
								   value="180" data-field_id="object_width" data-field_name="width"
						   data-field_type="style" data-id="">
							
						</div>	   
				</div>
				<div class="option-field-item">
					<label>Fill Color</label>
					<div class="input-group">
						<input type="text" name="background_color" class="form-control trigger_field colorpickerinput"
								   value="#ffffff" data-field_id="fill_color" data-field_name="fill"
						   data-field_type="svg_path_style" data-id="">
							<div class="input-group-append">
								<div class="input-group-text">
									<i class="fas fa-fill-drip"></i>
								</div>
							</div>
						</div>	   
				</div>
			</div>
		@endforeach
	@endif
	
	@if( !empty( $misc_list ) )
		@foreach( $misc_list as $miscObj)
			@php 
			$obj_slug = isset( $miscObj['slug'] )? $miscObj['slug'] : '';
			$svg_code = isset( $miscObj['svg_code'] )? $miscObj['svg_code'] : '';
			@endphp
			<div class="infobox-{{$obj_slug}}-fields">
				<div class="option-field-item">
					<label>Size (px)</label>
					<div class="input-group">
						<input type="number" name="object_width" class="form-control trigger_field"
								   value="180" data-field_id="object_width" data-field_name="width"
						   data-field_type="style" data-id="">
							
						</div>	   
				</div>
				<div class="option-field-item">
					<label>Fill Color</label>
					<div class="input-group">
						<input type="text" name="background_color" class="form-control trigger_field colorpickerinput"
								   value="#ffffff" data-field_id="fill_color" data-field_name="fill"
						   data-field_type="svg_path_style" data-id="">
							<div class="input-group-append">
								<div class="input-group-text">
									<i class="fas fa-fill-drip"></i>
								</div>
							</div>
						</div>	   
				</div>
			</div>
		@endforeach
	@endif
    

</div>



<div class="svgs-data rurera-hide">


	@if( !empty( $infolinks_list ) )
		@foreach( $infolinks_list as $infolinkObj)
			@php 
			$object_slug = isset( $infolinkObj['slug'] )? $infolinkObj['slug'] : '';
			$svg_code = isset( $infolinkObj['svg_code'] )? $infolinkObj['svg_code'] : '';
			$svg_code = updateSvgDimensions($svg_code, '100%', '100%');
			@endphp
			<div class="{{$object_slug}}_svg">
				{!! $svg_code !!}
			</div>
		@endforeach
	@endif
	
	
	@if( !empty( $objects_list ) )
		@foreach( $objects_list as $objectObj)
			@php 
			$obj_slug = isset( $objectObj['slug'] )? $objectObj['slug'] : '';
			$svg_code = isset( $objectObj['svg_code'] )? $objectObj['svg_code'] : '';
			$svg_code = updateSvgDimensions($svg_code, '100%', '100%');
			@endphp
			<div class="{{$obj_slug}}_svg">
				{!! $svg_code !!}
			</div>
		@endforeach
	@endif
	
	@if( !empty( $misc_list ) )
		@foreach( $misc_list as $miscObj)
			@php 
			$obj_slug = isset( $miscObj['slug'] )? $miscObj['slug'] : '';
			$svg_code = isset( $miscObj['svg_code'] )? $miscObj['svg_code'] : '';
			$svg_code = updateSvgDimensions($svg_code, '100%', '100%');
			@endphp
			<div class="{{$obj_slug}}_svg">
				{!! $svg_code !!}
			</div>
		@endforeach
	@endif
	
	
</div>