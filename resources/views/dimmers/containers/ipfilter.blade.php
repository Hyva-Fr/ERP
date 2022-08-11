<div class="dimmers" id="ipfilter-dimmer">
    <h4 class="dimmers-title">{{ __('IPs Filter') }}&nbsp;<span>({{ __('ISP') }})</span></h4>
    <div class="dimmer-cont scroll-dimmer">
        <table>
            <thead>
                <tr style="vertical-align: middle; text-align: center;">
                    <th style="vertical-align: middle; text-align: center;">
                        <i class="fa-solid fa-globe fa-lg fa-fw"></i>
                    </th>
                    <th style="vertical-align: middle; text-align: center;">
                        <i class="fa-solid fa-location-dot fa-lg fa-fw"></i>
                    </th>
                    <th style="vertical-align: middle; text-align: center;">
                        <i class="fa-solid fa-calculator fa-lg fa-fw"></i>
                    </th>
                    <th style="vertical-align: middle; text-align: center;">
                        <i class="fa-solid fa-calendar fa-lg fa-fw"></i>
                    </th>
                    <th style="vertical-align: middle; text-align: center;">
                        <i class="fa-solid fa-flag fa-lg fa-fw"></i>
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach($data as $ip)
                <tr style="vertical-align: middle; text-align: center;" class="ip-container" data-info='@json($ip, JSON_THROW_ON_ERROR)'>
                    <td style="vertical-align: middle; text-align: center;">
                        <span class="dimmer-table-img-container">
                            @if($ip['flag'] !== null)
                                <img title="{{ __($ip['countryName']) }}" src="/storage/media/flags/{{ $ip['flag'] }}" src="{{ __($ip['countryName']) }}">
                            @else
                                <i class="fa-solid fa-circle-question fa-lg fa-fw"></i>
                            @endif
                        </span>
                    </td>
                    <td>{{ $ip['ip'] }}</td>
                    <td>{{ $ip['attempts'] }}</td>
                    <td>
                        @if($ip['updated_at'] !== null)
                            {{ $ip['updated_at'] }}
                        @else
                            {{ $ip['created_at'] }}
                        @endif
                    </td>
                    <td>
                        @if($ip['is_ban'] === 1)
                            <i class="fa-solid fa-lock fa-lg fa-fw red"></i>
                        @else
                            <i class="fa-solid fa-lock-open fa-lg fa-fw blue"></i>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>