<aside>
    <ul id="aside-list-container">
        <li class="aside-list">
            <a href="{{ route('dashboard') }}">
                @if(\Request::route()->getName() === 'dashboard')
                    <i class="fa-solid fa-house fa-lg fa-fw selected"></i>
                @else
                    <i class="fa-solid fa-house fa-lg fa-fw"></i>
                @endif
                <b class="aside-links-labels">{{ __('Dashboard') }}</b>
            </a>
        </li>
        <li class="aside-list">
            <span>
                <i class="fa-solid fa-list-check fa-lg fa-fw {{ setSelectedParent(['forms', 'categories', 'completed-forms']) }}"></i>
                <b class="aside-links-labels">
                    {{ __('Forms') }}
                    <i class="fa-solid fa-angle-down @if(setSelectedParent(['forms', 'categories', 'completed-forms']) === 'selected') rotate @endif"></i>
                </b>
            </span>
            <ul class="dropdown @if(setSelectedParent(['forms', 'categories', 'completed-forms']) === 'selected') show @endif">
                <li>
                    <a href="{{ route('forms.create') }}">
                        @if(\Request::route()->getName() === 'forms.create')
                            <i class="fa-regular fa-circle-dot selected fa-lg fa-fw"></i>
                        @else
                            <i class="fa-regular fa-circle fa-lg fa-fw"></i>
                        @endif
                        <b class="aside-links-labels">{{ __('New form') }}</b>
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}">
                        @if(setSelectedParent(['categories']) === 'selected')
                            <i class="fa-regular fa-circle-dot selected fa-lg fa-fw"></i>
                        @else
                            <i class="fa-regular fa-circle fa-lg fa-fw"></i>
                        @endif
                        <b class="aside-links-labels">{{ __('Categories') }}</b>
                    </a>
                </li>
                <li>
                    <a href="{{ route('forms.index') }}">
                        @if(setSelectedParent(['forms'], ['forms.create']) === 'selected')
                            <i class="fa-regular fa-circle-dot selected fa-lg fa-fw"></i>
                        @else
                            <i class="fa-regular fa-circle fa-lg fa-fw"></i>
                        @endif
                        <b class="aside-links-labels">{{ __('Forms') }}</b>
                    </a>
                </li>
                <li>
                    <a href="{{ route('completed-forms.index') }}">
                        @if(setSelectedParent(['completed-forms']) === 'selected')
                            <i class="fa-regular fa-circle-dot selected fa-lg fa-fw"></i>
                        @else
                            <i class="fa-regular fa-circle fa-lg fa-fw"></i>
                        @endif
                        <b class="aside-links-labels">{{ __('Completed forms') }}</b>
                    </a>
                </li>
            </ul>
        </li>
        <li class="aside-list">
            <a href="{{ route('missions.index') }}">
                @if(setSelectedParent(['missions']) === 'selected')
                    <i class="fa-solid fa-barcode fa-lg fa-fw selected"></i>
                @else
                    <i class="fa-solid fa-barcode fa-lg fa-fw"></i>
                @endif
                <b class="aside-links-labels">{{ __('Missions') }}</b>
            </a>
        </li>
        <li class="aside-list">
            <a href="{{ route('societies.index') }}">
                @if(setSelectedParent(['societies']) === 'selected')
                    <i class="fa-solid fa-tags fa-lg fa-fw selected"></i>
                @else
                    <i class="fa-solid fa-tags fa-lg fa-fw"></i>
                @endif
                <b class="aside-links-labels">{{ __('Societies') }}</b>
            </a>
        </li>
        <li class="aside-list">
            <a href="{{ route('users.index') }}">
                @if(setSelectedParent(['users']) === 'selected')
                    <i class="fa-solid fa-users fa-lg fa-fw selected"></i>
                @else
                    <i class="fa-solid fa-users fa-lg fa-fw"></i>
                @endif
                <b class="aside-links-labels">{{ __('Collaborators') }}</b>
            </a>
        </li>
        <li class="aside-list">
            <span>
                <i class="fa-solid fa-industry fa-lg fa-fw {{ setSelectedParent(['agencies', 'states', 'countries', 'geographic-zones']) }}"></i>
                <b class="aside-links-labels">
                    {{ __('Industries sites') }}
                    <i class="fa-solid fa-angle-down @if(setSelectedParent(['agencies', 'states', 'countries', 'geographic-zones']) === 'selected') rotate @endif"></i>
                </b>
            </span>
            <ul class="dropdown @if(setSelectedParent(['agencies', 'states', 'countries', 'geographic-zones']) === 'selected') show @endif">
                <li>
                    <a href="{{ route('agencies.index') }}">
                        @if(setSelectedParent(['agencies']) === 'selected')
                            <i class="fa-regular fa-circle-dot selected fa-lg fa-fw"></i>
                        @else
                            <i class="fa-regular fa-circle fa-lg fa-fw"></i>
                        @endif
                        <b class="aside-links-labels">{{ __('Agencies') }}</b>
                    </a>
                </li>
                <li>
                    <a href="{{ route('states.index') }}">
                        @if(setSelectedParent(['states']) === 'selected')
                            <i class="fa-regular fa-circle-dot selected fa-lg fa-fw"></i>
                        @else
                            <i class="fa-regular fa-circle fa-lg fa-fw"></i>
                        @endif
                        <b class="aside-links-labels">{{ __('States') }}</b>
                    </a>
                </li>
                <li>
                    <a href="{{ route('countries.index') }}">
                        @if(setSelectedParent(['countries']) === 'selected')
                            <i class="fa-regular fa-circle-dot selected fa-lg fa-fw"></i>
                        @else
                            <i class="fa-regular fa-circle fa-lg fa-fw"></i>
                        @endif
                        <b class="aside-links-labels">{{ __('Countries') }}</b>
                    </a>
                </li>
                <li>
                    <a href="{{ route('geographic-zones.index') }}">
                        @if(setSelectedParent(['geographic-zones']) === 'selected')
                            <i class="fa-regular fa-circle-dot selected fa-lg fa-fw"></i>
                        @else
                            <i class="fa-regular fa-circle fa-lg fa-fw"></i>
                        @endif
                        <b class="aside-links-labels">{{ __('Geographic zones') }}</b>
                    </a>
                </li>
            </ul>
        </li>
        <li class="aside-list">
            <span>
                <i class="fa-solid fa-shield-halved fa-lg fa-fw {{ setSelectedParent(['roles', 'emails']) }}"></i>
                <b class="aside-links-labels">
                    {{ __('Administration') }}
                    <i class="fa-solid fa-angle-down @if(setSelectedParent(['roles', 'emails']) === 'selected') rotate @endif"></i>
                </b>
            </span>
            <ul class="dropdown @if(setSelectedParent(['roles', 'emails']) === 'selected') show @endif">
                <li>
                    <a href="{{ route('emails.index') }}">
                        @if(setSelectedParent(['emails']) === 'selected')
                            <i class="fa-regular fa-circle-dot selected fa-lg fa-fw"></i>
                        @else
                            <i class="fa-regular fa-circle fa-lg fa-fw"></i>
                        @endif
                        <b class="aside-links-labels">{{ __('Emails management') }}</b>
                    </a>
                </li>
                <li>
                    <a href="{{ route('roles.index') }}">
                        @if(setSelectedParent(['roles']) === 'selected')
                            <i class="fa-regular fa-circle-dot selected fa-lg fa-fw"></i>
                        @else
                            <i class="fa-regular fa-circle fa-lg fa-fw"></i>
                        @endif
                        <b class="aside-links-labels">{{ __('Roles management') }}</b>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>