<div class="categories-boxes">
    <div class="categories-card">
        <span class="topic-numbers" style="background-color: #fff; color: #27325e;">{{ trans('webinars.'.$webinar->type) }}</span>
        <div class="categories-icon" style="background:{{$webinar->background_color}}">
            {!! $webinar->icon_code !!}
        </div>
        <a href="{{ $webinar->getUrl() }}" itemprop="url">
            <h4 class="categories-title" itemprop="title">{{ clean($webinar->title,'title') }}</h4>
        </a>
    </div>
</div>


