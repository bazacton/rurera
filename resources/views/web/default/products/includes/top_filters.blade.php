<div id="topFilters" class="topFilters">
    <div class="row align-items-center">

        <div class="col-lg-8 d-block d-md-flex align-items-center justify-content-start my-25 my-lg-0" itemprop="products numbers">
            
            <div class="section-title mb-0">
                <h2 itemprop="title" class="font-22 mb-0">{{ $productsCount }} products showing</h2>
            </div>
        </div>

        <div class="col-lg-4 d-flex align-items-center" itemprop="products filter">
            <label>{{ trans('public.sort_by') }}:</label>
            <select name="sort" class="form-control font-16">
                <option value="">{{ trans('public.all') }}</option>
                <option value="newest" @if(request()->get('sort', null) == 'newest') selected="selected" @endif>{{ trans('public.newest') }}</option>
                <option value="expensive" @if(request()->get('sort', null) == 'expensive') selected="selected" @endif>{{ trans('public.expensive') }}</option>
                <option value="inexpensive" @if(request()->get('sort', null) == 'inexpensive') selected="selected" @endif>{{ trans('public.inexpensive') }}</option>
                <option value="bestsellers" @if(request()->get('sort', null) == 'bestsellers') selected="selected" @endif>{{ trans('public.bestsellers') }}</option>
                <option value="best_rates" @if(request()->get('sort', null) == 'best_rates') selected="selected" @endif>{{ trans('public.best_rates') }}</option>
            </select>
        </div>

    </div>
</div>
