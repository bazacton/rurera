@php $data_values = json_decode($pageInfoLink->data_values);
$content = isset($data_values->infobox_value)? base64_decode(trim(stripslashes($data_values->infobox_value))) : '';

@endphp
<div class="flipbook-slide-menu">
    <div class="slide-menu-head">
        <div class="menu-controls">
            <a href="#" class="close-btn"><i class="fa fa-chevron-right"></i></a>
        </div>
        <h4>{{$pageInfoLink->info_title}}</h4>
    </div>
    <div class="slide-menu-body">
        {!! $content !!}
    </div>
</div>
<script type="text/javascript">
    $("body").addClass("menu-open");
</script>
