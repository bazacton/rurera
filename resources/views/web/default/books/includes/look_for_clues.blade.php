@php $data_values = json_decode($pageInfoLink->data_values);
$content = isset($data_values->info_content)? $data_values->info_content : '';
@endphp
<div class="flipbook-slide-menu">
    <div class="slide-menu-head">
        <div class="menu-controls">
            <a href="#" class="close-btn"><i class="fa fa-chevron-right"></i></a>
        </div>
        <h4>{{$pageInfoLink->item_title}}</h4>
    </div>
    <div class="slide-menu-body">
        {!! $content !!}
    </div>
</div>
<script type="text/javascript">
    $("body").addClass("menu-open");
</script>
