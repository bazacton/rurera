@php $objects_list = getSvgFiles('assets/admin/editor/objects/');
$stages_list = getSvgFiles('assets/admin/editor/stages/');
$paths_list = getSvgFiles('assets/admin/editor/paths/');
$topics_list = getSvgFiles('assets/admin/editor/topics/');
 @endphp
<div class="editor-controls">
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
<div class="editor-objects-block">
	<h5>Layers</h5>
	<ul class="editor-objects-list">
	</ul>
</div>

<div class="drag-controls rurera-hide">
    <a href="#" class="controls-close-btn">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="128.000000pt"
             height="128.000000pt" viewBox="0 0 128.000000 128.000000"
             preserveAspectRatio="xMidYMid meet">

            <g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"
               fill="#cccccc" stroke="none">
                <path
                    d="M29 1251 c-57 -57 -56 -58 233 -348 l262 -263 -262 -263 c-235 -236 -262 -266 -262 -295 0 -44 38 -82 82 -82 29 0 59 27 295 262 l263 262 263 -262 c236 -235 266 -262 295 -262 44 0 82 38 82 82 0 29 -27 59 -262 295 l-262 263 262 263 c289 290 290 291 233 348 -57 57 -58 56 -348 -233 l-263 -262 -263 262 c-290 289 -291 290 -348 233z"/>
            </g>
        </svg>
    </a>
    <div class="controls-box">
        <ul class="controls-dropdown">
		
		

            <li>
                <a href="javascript:;" class="control-tool-item"
                   data-drag_type="ACTIONS">
				   
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.0"
                         width="64.000000pt" height="64.000000pt"
                         viewBox="0 0 64.000000 64.000000"
                         preserveAspectRatio="xMidYMid meet">

                        <g transform="translate(0.000000,64.000000) scale(0.100000,-0.100000)"
                           fill="#cccccc" stroke="none">
                            <path
                                d="M0 630 c0 -5 19 -10 43 -10 69 0 207 -20 244 -35 48 -20 43 -45 -22 -94 -44 -33 -55 -47 -55 -70 0 -23 7 -32 34 -45 19 -9 42 -16 52 -16 13 0 -2 -21 -50 -69 -62 -63 -72 -69 -119 -75 -80 -9 -137 -64 -124 -118 8 -32 43 -75 53 -66 4 5 0 16 -8 25 -43 49 -29 102 34 127 60 25 76 21 48 -10 -21 -21 -22 -27 -10 -34 8 -5 21 -10 28 -10 6 0 12 -7 12 -16 0 -9 9 -18 20 -21 11 -3 23 -16 26 -29 3 -13 9 -24 13 -24 4 0 39 33 80 74 l73 73 71 6 c85 7 120 29 125 75 3 26 -2 34 -22 44 -14 6 -26 16 -26 22 0 7 -25 36 -55 66 l-55 54 -43 -42 c-32 -31 -49 -41 -63 -36 -89 29 -95 46 -31 95 55 42 67 58 67 86 0 19 -10 28 -43 43 -68 30 -297 53 -297 30z m531 -330 c26 -15 24 -46 -5 -65 -13 -9 -48 -18 -77 -22 l-54 -6 50 52 c53 55 56 56 86 41z"/>
                            <path
                                d="M503 546 l-28 -25 58 -58 58 -58 25 30 c32 40 30 61 -10 101 -40 40 -65 43 -103 10z"/>
                            <path
                                d="M439 484 c-11 -13 -4 -23 44 -72 54 -54 58 -56 74 -39 16 16 14 20 -37 72 -30 30 -57 55 -61 55 -4 0 -12 -7 -20 -16z"/>
                            <path
                                d="M87 93 c-8 -39 37 -84 76 -76 34 7 40 53 7 53 -13 0 -24 10 -30 25 -13 35 -46 33 -53 -2z"/>
                            <path
                                d="M70 16 c0 -9 7 -16 16 -16 9 0 14 5 12 12 -6 18 -28 21 -28 4z"/>
                        </g>
                    </svg>
                    <span>Stages</span>
                </a>
                <ul class="sub-dropdown">
                    <li>
                        <a href="javascript:;" title="Stage 1" class="control-tool-item"
                           data-drag_type="stage_objects" data-drag_object="stage1">
                            <img src="/assets/admin/editor/stages/stage1.svg" style="width:65px">
                        </a>
                    </li>
					<li>
                        <a href="javascript:;" title="Stage 2" class="control-tool-item"
                           data-drag_type="stage_objects" data-drag_object="stage2">
                            <img src="/assets/admin/editor/stages/stage2.svg" style="width:65px">
                        </a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="javascript:;" class="control-tool-item"
                   data-drag_type="ACTIONS">
				   
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.0"
                         width="64.000000pt" height="64.000000pt"
                         viewBox="0 0 64.000000 64.000000"
                         preserveAspectRatio="xMidYMid meet">

                        <g transform="translate(0.000000,64.000000) scale(0.100000,-0.100000)"
                           fill="#cccccc" stroke="none">
                            <path
                                d="M0 630 c0 -5 19 -10 43 -10 69 0 207 -20 244 -35 48 -20 43 -45 -22 -94 -44 -33 -55 -47 -55 -70 0 -23 7 -32 34 -45 19 -9 42 -16 52 -16 13 0 -2 -21 -50 -69 -62 -63 -72 -69 -119 -75 -80 -9 -137 -64 -124 -118 8 -32 43 -75 53 -66 4 5 0 16 -8 25 -43 49 -29 102 34 127 60 25 76 21 48 -10 -21 -21 -22 -27 -10 -34 8 -5 21 -10 28 -10 6 0 12 -7 12 -16 0 -9 9 -18 20 -21 11 -3 23 -16 26 -29 3 -13 9 -24 13 -24 4 0 39 33 80 74 l73 73 71 6 c85 7 120 29 125 75 3 26 -2 34 -22 44 -14 6 -26 16 -26 22 0 7 -25 36 -55 66 l-55 54 -43 -42 c-32 -31 -49 -41 -63 -36 -89 29 -95 46 -31 95 55 42 67 58 67 86 0 19 -10 28 -43 43 -68 30 -297 53 -297 30z m531 -330 c26 -15 24 -46 -5 -65 -13 -9 -48 -18 -77 -22 l-54 -6 50 52 c53 55 56 56 86 41z"/>
                            <path
                                d="M503 546 l-28 -25 58 -58 58 -58 25 30 c32 40 30 61 -10 101 -40 40 -65 43 -103 10z"/>
                            <path
                                d="M439 484 c-11 -13 -4 -23 44 -72 54 -54 58 -56 74 -39 16 16 14 20 -37 72 -30 30 -57 55 -61 55 -4 0 -12 -7 -20 -16z"/>
                            <path
                                d="M87 93 c-8 -39 37 -84 76 -76 34 7 40 53 7 53 -13 0 -24 10 -30 25 -13 35 -46 33 -53 -2z"/>
                            <path
                                d="M70 16 c0 -9 7 -16 16 -16 9 0 14 5 12 12 -6 18 -28 21 -28 4z"/>
                        </g>
                    </svg>
                    <span>Objects</span>
                </a>
                <ul class="sub-dropdown">
                    <li>
                        <a href="javascript:;" title="Animal" class="control-tool-item"
                           data-drag_type="stage_objects" data-drag_object="animal_object">
                            <img src="/assets/admin/editor/objects/animal_object.svg">
                        </a>
                    </li>
					<li>
                        <a href="javascript:;" title="Butterfly" class="control-tool-item"
                           data-drag_type="stage_objects" data-drag_object="butterfly_object">
                            <img src="/assets/admin/editor/objects/butterfly_object.svg">
                        </a>
                    </li>

                </ul>
            </li>
        </ul>
    </div>
</div>

<div class="field-options hide"></div>

<div class="option-fields-block hide">


	@if( !empty( $stages_list ) )
		@foreach( $stages_list as $stageObj)
			@php 
			$stage_slug = isset( $stageObj['slug'] )? $stageObj['slug'] : '';
			@endphp
			<div class="infobox-{{$stage_slug}}-fields">
				<div class="option-field-item">
					<label>Size (px)</label>
					<input type="number" class="form-control trigger_field" data-field_id="object_width" data-field_name="width"
						   data-field_type="svg_style" data-id=""></input>	   
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
					<input type="number" class="form-control trigger_field" data-field_id="object_width" data-field_name="width"
						   data-field_type="svg_style" data-id=""></input>	   
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
				<div class="option-field-item 3333">
					<label>Size (px)</label>
					<input type="number" class="form-control trigger_field" data-field_id="object_width" data-field_name="width"
						   data-field_type="svg_style" data-id=""></input>	   
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
					<input type="number" class="form-control trigger_field" data-field_id="object_width" data-field_name="width"
						   data-field_type="svg_style" data-id=""></input>	   
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
			$svg_code = updateSvgDimensions($svg_code, 500, 500);
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
			@endphp
			<div class="{{$obj_slug}}_svg">
				{!! $svg_code !!}
			</div>
		@endforeach
	@endif
	
</div>