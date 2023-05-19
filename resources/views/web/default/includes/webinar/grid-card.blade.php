<div class="categories-boxes">
    <div class="categories-card">
        <span class="topic-numbers" style="background-color: #fff; color: #27325e;">{{ trans('webinars.'.$webinar->type) }}</span>
        <div class="categories-icon" style="background-color: #000;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-anchor" style="color: #fff;">
                <circle cx="12" cy="5" r="3"></circle>
                <line x1="12" y1="22" x2="12" y2="8"></line>
                <path d="M5 12H2a10 10 0 0 0 20 0h-3"></path>
            </svg>
        </div>
        <a href="{{ $webinar->getUrl() }}">
            <h4 class="categories-title">{{ clean($webinar->title,'title') }}</h4>
        </a>
    </div>
</div>


