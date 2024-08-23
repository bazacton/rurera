@php use App\Models\QuizzesResult;
$is_completed = isset( $itemObj->is_completed )? $itemObj->is_completed : false;
$item_type = isset( $itemObj->item_type ) ?  $itemObj->item_type : '';
$item_path_folder = '';
$item_path_folder = ($item_type == 'stage' )? 'stages' : $item_path_folder;
$item_path_folder = ($item_type == 'stage_objects' )? 'objects' : $item_path_folder;
$item_path_folder = ($item_type == 'path' )? 'paths' : $item_path_folder;
$field_style = isset( $itemObj->field_style ) ?  $itemObj->field_style : '';
$item_path = isset( $itemObj->item_path ) ?  $itemObj->item_path : '';
$item_path = 'assets/editor/'.$item_path_folder.'/'.$item_path;
$svgCode = getFileContent($item_path);
//pre($itemObj, false);
@endphp

<div class="learning-journey-item" style="{{$field_style}}">
	{!! $svgCode !!}
</div>

