<div id="crud-ajax">
    <div id="crud-loader">
        <span></span>
    </div>
    @if(!$data->isEmpty())
        {{ $data->links('cruds.pagination', ['position' => 'top']) }}
        <div class="crud-table-container">
            <table class="crud-table">
                <thead>
                <tr>
                    <th class="small-th" style="vertical-align: middle;">
                        <i class="fa-solid fa-ellipsis-vertical fa-lg fa-fw" title="{{ __('Edit actions') }}"></i>
                    </th>
                    @foreach($thead as $th)
                        <th style="vertical-align: middle;">
                            <p>
                                @if(!array_key_exists($th, $extracts) && $th !== 'avatar')
                                    <i class="fa-solid fa-magnifying-glass fa-lg fa-fw" title="{{ __('Search allowed') }}"></i>
                                @elseif($th === 'avatar')
                                    <i class="fa-solid fa-circle-user fa-lg fa-fw" title="{{ __('Image') }}"></i>
                                @else
                                    <i class="fa-solid fa-link fa-lg fa-fw" title="{{ __('Links section') }}"></i>
                                @endif
                                {{ __(ucfirst(str_replace('_', ' ', $th))) }}
                            </p>
                        </th>
                    @endforeach
                    <th class="small-th" style="vertical-align: middle;">
                        <i class="fa-solid fa-ellipsis-vertical fa-lg fa-fw" title="{{ __('Delete actions') }}"></i>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $row)
                    <tr>
                        <td style="vertical-align: middle;">
                            <span class="actions-container">
                            @if((commonRoute() === 'users' && $row->id === Auth::user()->id))
                                <a href="{{ route('profile') }}">
                                    <i class="fa-solid fa-pen crud-actions fa-lg fa-fw" title="{{ __('Edit row') }} {{ $row->id }}"></i>
                                </a>
                            @elseif(commonRoute() === 'completed-forms')
                                <a href="{{ route(commonRoute() . '.show', [commonRoute(true) => $row->id]) }}">
                                    <i class="fa-solid fa-eye crud-actions fa-lg fa-fw" title="{{ __('Show row') }} {{ $row->id }}"></i>
                                </a>
                            @else
                                <a href="{{ route(commonRoute() . '.show', [commonRoute(true) => $row->id]) }}">
                                    <i class="fa-solid fa-eye crud-actions fa-lg fa-fw" title="{{ __('Show row') }} {{ $row->id }}"></i>
                                </a>
                                <a href="{{ route(commonRoute() . '.edit', [commonRoute(true) => $row->id]) }}">
                                    <i class="fa-solid fa-pen crud-actions fa-lg fa-fw" title="{{ __('Edit row') }} {{ $row->id }}"></i>
                                </a>
                            @endif
                            </span>
                        </td>
                        @foreach($thead as $index)
                            <td style="vertical-align: middle;">
                                @if(array_key_exists($index, $extracts))
                                    <a class="crud-link" href="/{{ $extracts[$index]['route'] }}/{{ $row->toArray()[$extracts[$index]['rel']] }}/edit">{{ $row->$index }}</a>
                                @else
                                    {!! __(setRowType($row->$index, $index, $table)) !!}
                                @endif
                            </td>
                        @endforeach
                        <td style="vertical-align: middle;">
                            @if(commonRoute() === 'users' && $row->id === Auth::user()->id)
                                <span class="crud-forbidden">
                                    <i class="fa-solid fa-ban fa-lg fa-fw"></i>
                                </span>
                            @else
                                <form class="delete-crud-record" method="post" action="{{ route(commonRoute() . '.destroy', [commonRoute(true) => $row->id]) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="nude" type="submit">
                                        <i class="fa-solid fa-trash crud-actions fa-lg fa-fw" title="{{ __('Delete row') }} {{ $row->id }}"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $data->links('cruds.pagination', ['position' => 'bottom']) }}
    @else
        <p class="no-result">{{ __('No result found.') }}</p>
        <p class="no-result-advice">{{ __('Let\'s create a new record.') }}</p>
    @endif
</div>