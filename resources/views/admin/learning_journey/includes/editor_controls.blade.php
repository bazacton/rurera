@php $objects_list = getSvgFiles('assets/admin/editor/objects/');
$stages_list = getSvgFiles('assets/admin/editor/stages/');
$paths_list = getSvgFiles('assets/admin/editor/paths/');
$topics_list = getSvgFiles('assets/admin/editor/topics/');
 @endphp
 
<div class="editor-controls-holder">
	<div class="editor-parent-nav">
		<ul class="nav" id="myTab" role="tablist">
  
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="stages-tab" data-toggle="tab" data-target="#stages" type="button" role="tab" aria-controls="profile" aria-selected="false">Clipboard</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="layers-tab" data-toggle="tab" data-target="#layers" type="button" role="tab" aria-controls="contact" aria-selected="false">Layers</button>
		</li>
		</ul>
	</div>
	<div class="editor-controls tab-pane fade" id="stages" role="tabpanel" aria-labelledby="profile-tab">
		<ul class="nav nav-pills" id="myTab3" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="stages-tab{{$data_id}}" data-toggle="tab" href="#stages{{$data_id}}" role="tab" aria-controls="stages{{$data_id}}" aria-selected="true">Stages</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="paths-tab{{$data_id}}" data-toggle="tab" href="#paths{{$data_id}}" role="tab" aria-controls="paths{{$data_id}}" aria-selected="true">Paths</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="objects-tab{{$data_id}}" data-toggle="tab" href="#objects{{$data_id}}" role="tab" aria-controls="objects{{$data_id}}" aria-selected="true">Objects</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="topics-tab{{$data_id}}" data-toggle="tab" href="#topics{{$data_id}}" role="tab" aria-controls="topics{{$data_id}}" aria-selected="true">Topics</a>
			</li>
		</ul>
		
		<div class="tab-content" id="myTabContent2">
			<div class="tab-pane mt-3 fade  show active " id="stages{{$data_id}}" role="tabpanel" aria-labelledby="stages-tab{{$data_id}}">
				<ul class="editor-objects">
					@if( !empty( $stages_list ) )
						@foreach( $stages_list as $stageObj)
							@php $stage_path = isset( $stageObj['path'] )? $stageObj['path'] : ''; 
							$stage_slug = isset( $stageObj['slug'] )? $stageObj['slug'] : '';
							$stage_title = isset( $stageObj['title'] )? $stageObj['title'] : '';
							@endphp
							<li>
								<a href="javascript:;" title="{{$stage_title}}" class="control-tool-item"
								data-drag_type="stage" data-object_path="/assets/admin/editor/stages/{{$stage_path}}" data-item_path="{{$stage_path}}" data-drag_object="{{$stage_slug}}">
									<img src="/assets/admin/editor/stages/{{$stage_path}}" style="width:65px">
								</a>
							</li>
						@endforeach
					@endif
					
				</ul>
			</div>
			<div class="tab-pane mt-3 fade" id="paths{{$data_id}}" role="tabpanel" aria-labelledby="paths-tab{{$data_id}}">
					<ul class="editor-objects">
					@if( !empty( $paths_list ) )
						@foreach( $paths_list as $pathObj)
							@php $object_path = isset( $pathObj['path'] )? $pathObj['path'] : ''; 
							$object_slug = isset( $pathObj['slug'] )? $pathObj['slug'] : '';
							$object_title = isset( $pathObj['title'] )? $pathObj['title'] : '';
							@endphp
							<li>
								<a href="javascript:;" title="{{$object_title}}" class="control-tool-item"
								data-drag_type="path" data-object_path="/assets/admin/editor/paths/{{$object_path}}" data-item_path="{{$object_path}}" data-drag_object="{{$object_slug}}">
									<img src="/assets/admin/editor/paths/{{$object_path}}" style="width:65px">
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
									<img src="/assets/admin/editor/objects/{{$object_path}}" style="width:65px">
								</a>
							</li>
						@endforeach
					@endif
					</ul>
			</div>
			<div class="tab-pane mt-3 fade" id="topics{{$data_id}}" role="tabpanel" aria-labelledby="topics-tab{{$data_id}}">
					<ul class="editor-objects">
					@if( !empty( $topics_list ) )
						@foreach( $topics_list as $topicObj)
							@php $object_path = isset( $topicObj['path'] )? $topicObj['path'] : ''; 
							$object_slug = isset( $topicObj['slug'] )? $topicObj['slug'] : '';
							$object_title = isset( $topicObj['title'] )? $topicObj['title'] : '';
							@endphp
							<li>
								<a href="javascript:;" title="{{$object_title}}" class="control-tool-item"
								data-drag_type="topic" data-object_path="/assets/admin/editor/topics/{{$object_path}}" data-item_path="{{$object_path}}" data-drag_object="{{$object_slug}}">
									<img src="/assets/admin/editor/topics/{{$object_path}}" style="width:65px">
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
			if( isset( $itemObj->id ) && !empty( $itemObj->LearningJourneyObjects->where('status','active') )){
				foreach( $itemObj->LearningJourneyObjects->where('status','active') as $learningJourneyItemObj){
					
					echo '<li data-id="rand_'.$learningJourneyItemObj->id.'" data-field_postition="2">'.$learningJourneyItemObj->item_slug.' <i class="fa fa-trash"></i><i class="lock-layer fa fa-unlock"></i><i class="fa fa-sort"></i><i class="fa fa-copy"></i></li>';
					
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

	@if( !empty( $stages_list ) )
		@foreach( $stages_list as $stageObj)
			@php 
			$stage_slug = isset( $stageObj['slug'] )? $stageObj['slug'] : '';
			@endphp
			<div class="infobox-{{$stage_slug}}-fields">
				<div class="option-field-item">
					<label>Size (px)</label>
					<div class="input-group">
						<input type="number" name="stage_width" class="form-control trigger_field"
								   value="500" data-field_id="stage_width" data-field_name="width"
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
	
	@if( !empty( $paths_list ) )
		@foreach( $paths_list as $pathObj)
			@php 
			$obj_slug = isset( $pathObj['slug'] )? $pathObj['slug'] : '';
			$svg_code = isset( $pathObj['svg_code'] )? $pathObj['svg_code'] : '';
			@endphp
			<div class="infobox-{{$obj_slug}}-fields">
				<div class="option-field-item">
					<label>Size (px)</label>
					<div class="input-group">
						<input type="number" name="path_width" class="form-control trigger_field"
								   value="300" data-field_id="path_width" data-field_name="width"
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
    
	@if( !empty( $topics_list ) )
		@foreach( $topics_list as $topicObj)
			@php 
			$obj_slug = isset( $topicObj['slug'] )? $topicObj['slug'] : '';
			$svg_code = isset( $topicObj['svg_code'] )? $topicObj['svg_code'] : '';
			@endphp
			<div class="infobox-{{$obj_slug}}-fields">
				<div class="option-field-item">
					<label>Size (px)</label>
					<div class="input-group">
						<input type="number" name="topic_width" class="form-control trigger_field"
								   value="180" data-field_id="topic_width" data-field_name="width"
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
				
				<div class="option-field-item">
					<label class="input-label">Topic</label>
					<select data-field_id="topic"
							data-search-option="topic"
							class="trigger_field form-control search_topic" data-field_name="select_topic" data-field_type="select_topic"
							data-placeholder="Search Topic" data-id="">
					</select>
				</div>
			</div>
		@endforeach
	@endif
	


</div>



<div class="svgs-data rurera-hide">


	@if( !empty( $stages_list ) )
		@foreach( $stages_list as $stageObj)
			@php 
			$stage_slug = isset( $stageObj['slug'] )? $stageObj['slug'] : '';
			$svg_code = isset( $stageObj['svg_code'] )? $stageObj['svg_code'] : '';
			$svg_code = updateSvgDimensions($svg_code, '100%', '100%');
			@endphp
			<div class="{{$stage_slug}}_svg">
				{!! $svg_code !!}
			</div>
		@endforeach
	@endif
	
	@if( !empty( $paths_list ) )
		@foreach( $paths_list as $pathObj)
			@php 
			$obj_slug = isset( $pathObj['slug'] )? $pathObj['slug'] : '';
			$svg_code = isset( $pathObj['svg_code'] )? $pathObj['svg_code'] : '';
			$svg_code = updateSvgDimensions($svg_code, '100%', '100%');
			@endphp
			<div class="{{$obj_slug}}_svg">
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
	
	@if( !empty( $topics_list ) )
		@foreach( $topics_list as $topicObj)
			@php 
			$obj_slug = isset( $topicObj['slug'] )? $topicObj['slug'] : '';
			$svg_code = isset( $topicObj['svg_code'] )? $topicObj['svg_code'] : '';
			$svg_code = updateSvgDimensions($svg_code, '100%', '100%');
			@endphp
			<div class="{{$obj_slug}}_svg">
				{!! $svg_code !!}
			</div>
		@endforeach
	@endif
	
</div>