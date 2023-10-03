<div id="topFilters" class="topFilters">
    <div class="row align-items-center">

        <div class="col-lg-9 d-block d-md-flex align-items-center justify-content-start my-25 my-lg-0" itemprop="products numbers">
            {{ $productsCount }} products showing
        </div>

        <div class="col-lg-3 d-flex align-items-center" itemprop="products filter">
            <label>{{ trans('public.sort_by') }}:</label>
            <select name="sort" class="form-control font-14">
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
