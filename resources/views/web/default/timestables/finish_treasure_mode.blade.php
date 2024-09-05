<section class="p-25 panel-border border-radius-10">
    <form action="/timestables/generate_treasure_mission" method="post" class="treasure_mission_form">
                            {{ csrf_field() }}
        <input type="hidden" name="nugget_id" id="nugget_id" value="0">
    </form>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title mb-30 text-center"><h2>Completed! </h2></div>
                </div>
                <div class="col-12 col-lg-12 mx-auto">
                   <a href="/panel/analytics/timestables/result/{{$QuizzesResult->id}}" class="timestables-results">See Results</a>
                    @if( $percentage_correct_answer >= 95)
                        <a href="javascript:;"  data-id="{{isset( $nuggetObj['id'] )? $nuggetObj['id'] : ''}}" class="timestables-next-stage">Next Stage</a>
                    @else
                        <a href="javascript:;"  data-id="{{isset( $nuggetObj['id'] )? $nuggetObj['id'] : ''}}" class="timestables-retry-stage">Retry</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
<script>
$(document).on('click', '.timestables-next-stage, .timestables-retry-stage', function (e) {
    var nugget_id = $(this).attr('data-id');
    $("#nugget_id").val(nugget_id);
    $(".treasure_mission_form").submit();

});
</script>