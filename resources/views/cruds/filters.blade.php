<form class="crud-filters">
    @csrf
    <label for="crud-paginate-by" class="form-control">
        <span>{{ __('Results per page') }}</span>
        <select id="crud-paginate-by" name="crud-per-page" class="form-control">
            <option selected value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
    </label>
    <label for="crud-filter-by" class="form-control">
        <span>{{ __('Filter by') }}</span>
        <select id="crud-filter-by" name="crud-filter" class="form-control">
            <option value="none" selected>{{ __('No filter') }}</option>
            @foreach($thead as $option)
                @if(!array_key_exists($option, $extracts) && $option !== 'avatar')
                    <option value="{{ $option }}">{{ __(ucfirst(str_replace('_', ' ', $option))) }}</option>
                @endif
            @endforeach
        </select>
    </label>
    <div class="crud-radios form-control">
        <span>{{ __('Order by') }}</span>
        <label for="crud-radio-1">
            <input class="with-font" value="asc" id="crud-radio-1" type="radio" checked name="crud-order">
            <span>
                <i class="fa-solid fa-arrow-up-short-wide" title="{{ __('Ascendant order') }}"></i>
            </span>
        </label>
        <label for="crud-radio-2">
            <input class="with-font" value="desc" id="crud-radio-2" type="radio" name="crud-order">
            <span>
                <i class="fa-solid fa-arrow-down-short-wide" title="{{ __('Descendant order') }}"></i>
            </span>
        </label>
    </div>
    <label for="crud-search" class="form-control">
        <span>{{ __('Search') }}</span>
        <input id="crud-search" type="text" name="crud-search" placeholder="Type search...">
    </label>
    <button class="white" type="submit">{{ __('Apply') }}</button>
</form>