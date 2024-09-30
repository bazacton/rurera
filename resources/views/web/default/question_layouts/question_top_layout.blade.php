@if( $questionObj->review_required == 1 || $questionObj->developer_review_required == 1)
<div class="question-review-required">
    @if( $questionObj->review_required == 1)
    <div class="question-label-tag">Teacher Review Required</div>
    @endif
    @if( $questionObj->developer_review_required == 1)
    <div class="question-label-tag">Developer Review Required</div>
    @endif
</div>
@endif