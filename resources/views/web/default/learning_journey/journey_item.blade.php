@php use App\Models\QuizzesResult;
$is_completed = isset( $itemObj->is_completed )? $itemObj->is_completed : false;
$item_type = isset( $itemObj->item_type ) ?  $itemObj->item_type : '';
$data_values = isset( $itemObj->data_values ) ?  json_decode($itemObj->data_values) : array();
$fill_color = isset( $data_values->fill_color )? $data_values->fill_color : '';
$style_parameter = '';
if( $item_type == 'stage'){
	//$style_parameter = 'margin: 18px 15px;';
}
$item_path_folder = '';
$item_path_folder = ($item_type == 'stage' )? 'stages' : $item_path_folder;
$item_path_folder = ($item_type == 'stage_objects' )? 'objects' : $item_path_folder;
$item_path_folder = ($item_type == 'path' )? 'paths' : $item_path_folder;
$field_style = isset( $itemObj->field_style ) ?  $itemObj->field_style : '';
$item_path = isset( $itemObj->item_path ) ?  $itemObj->item_path : '';
$item_path = 'assets/editor/'.$item_path_folder.'/'.$item_path;
$svgCode = getFileContent($item_path);
$svgCode = updateSvgDimensions($svgCode, '100%', '100%');
//pre($itemObj, false);
@endphp

<style>
	@if( $fill_color != '')
	.learning-journey-item-{{$itemObj->id}} svg path{
		fill:{{$fill_color}};
	}
	@endif
	@if($style_parameter != '')
		.learning-journey-item-{{$itemObj->id}}{
			{{$style_parameter}}
		}
	@endif
</style>

<div class="learning-journey-item learning-journey-item-{{$itemObj->id}}" style="{{$field_style}}">
	<div class="field-data">
	{!! $svgCode !!}
	</div>
</div>

