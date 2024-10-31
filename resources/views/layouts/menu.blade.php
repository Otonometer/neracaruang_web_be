<li class="nav-label mg-t-25">Menu</li>

<li class="{{ Request::is('dashboard*') ? 'active' : '' }} nav-item">
    <a class="nav-link" href="{!! route('dashboard') !!}"><i data-feather="home"></i><span>Dashboard</span></a>
</li>

@canany(['role-show', 'user-show', 'moderators-show', 'writer-show'])
<li class="nav-label mg-t-25">User Management</li>
    @can('permissiongroup-show')
    <li class="{{ Request::is('permissiongroups*') ? 'active' : '' }} nav-item">
        <a class="nav-link" href="{!! route('permissiongroups.index') !!}"><i data-feather="user-check"></i><span>Permissions Group</span></a>
    </li>
    @endcan

    @can('permission-show')
    <li class="{{ Request::is('permissions*') ? 'active' : '' }} nav-item">
        <a class="nav-link" href="{!! route('permissions.index') !!}"><i data-feather="user-check"></i><span>Permissions</span></a>
    </li>
    @endcan

    @can('role-show')
    <li class="{{ Request::is('roles*') ? 'active' : '' }} nav-item">
        <a class="nav-link" href="{!! route('roles.index') !!}"><i data-feather="lock"></i><span>Roles</span></a>
    </li>
    @endcan

    @can('user-show')
    <li class="{{ Request::is('users*') ? 'active' : '' }} nav-item">
        <a class="nav-link" href="{!! route('users.index') !!}"><i data-feather="user-plus"></i><span>Users</span></a>
    </li>
    @endcan

    @can('writer-show')
    <li class="{{ Request::is('writer*') ? 'active' : '' }} nav-item">
        <a class="nav-link" href="{!! route('writer.index') !!}"><i data-feather="user-plus"></i><span>Writer</span></a>
    </li>
    @endcan

    @can('moderators-show')
    <li class="{{ Request::is('moderators*') ? 'active' : '' }} nav-item">
        <a class="nav-link" href="{!! route('moderators.index') !!}"><i data-feather="user-plus"></i><span>Moderators/Co Moderators</span></a>
    </li>
    @endcan

@endcanany

<li class="nav-label mg-t-25">Others</li>

@can('content-show')
    {{-- <li class="nav-item show">
        <a href="" class="nav-link with-sub">
            @foreach ($contentTypesEnum::cases() as $type)
                <nav class="nav">
                    <a class="nav-link" href="{{ route('contents.index',$type->slug()) }}">{{ $type->title() }}</a>
                </nav>
            @endforeach
        </a>
    </li> --}}
    <li class="nav-item with-sub {{ Request::is('contents*') ? 'active show' : '' }}">
        <a href="" class="nav-link"><i data-feather="edit-3"></i> Page Section</a>
        <ul>
            @foreach ($contentTypesEnum::cases() as $type)
                <li class="{{ Request::is('contents/'.$type->slug()) ? 'active' : '' }}"><a href="{{ route('contents.index',$type->slug()) }}"> {{ $type->title() }}</li>
            @endforeach
        </ul>
    </li>
    {{-- <div class="accordion" id="accordionExample">
        <div class="accordion-item nav-item">
            <a class="nav-link justify-content-between" id="btn-nav" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <span><i data-feather="edit-3"></i>Page sections</span> <i class="fa fa-chevron-down rotate" id="chevron" aria-hidden="true"></i>
            </a>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body" style="padding-left: 15px">
                    @foreach ($contentTypesEnum::cases() as $type)
                        <nav class="nav">
                            <a class="nav-link text-capitalize" href="{{ route('contents.index',$type->slug()) }}"><i data-feather="edit-3"></i> <span>{{ $type->title() }}</span></a>
                        </nav>
                    @endforeach
                </div>
            </div>
        </div>
    </div> --}}
@endcan

@canany(['discussion-show', 'discussionSuggestion-show'])
    <li class="nav-item with-sub {{ Request::is('discussionSuggestions*') || Request::is('discussions*') ? 'active show' : '' }}">
        <a href="" class="nav-link"><i data-feather="edit-3"></i> Discussion</a>
        <ul>
            <li class="{{ Request::is('discussions*') && !Request::is('discussionSuggestions*') ? 'active' : '' }}"><a href="{!! route('discussions.index') !!}"> Discussions</li>
            <li class="{{ Request::is('discussionSuggestions*') ? 'active' : '' }}"><a href="{!! route('discussionSuggestions.index') !!}"> Discussions Suggestions</a></li>
        </ul>
    </li>
@endcanany

@can('province-show')
<li class="{{ Request::is('provinces*') ? 'active' : '' }} nav-item">
    <a class="nav-link" href="{!! route('provinces.index') !!}"><i data-feather="edit-3"></i><span>Provinces</span></a>
</li>
@endcan

@can('city-show')
<li class="{{ Request::is('cities*') ? 'active' : '' }} nav-item">
    <a class="nav-link" href="{!! route('cities.index') !!}"><i data-feather="edit-3"></i><span>Cities</span></a>
</li>
@endcan

{{-- @can('icon-show')
<li class="{{ Request::is('icons*') ? 'active' : '' }} nav-item">
    <a class="nav-link" href="{!! route('icons.index') !!}"><i data-feather="edit-3"></i><span>Icons</span></a>
</li>
@endcan

@can('category-show')
<li class="{{ Request::is('categories*') ? 'active' : '' }} nav-item">
    <a class="nav-link" href="{!! route('categories.index') !!}"><i data-feather="edit-3"></i><span>Categories</span></a>
</li>
@endcan --}}

@can('tag-show')
<li class="{{ Request::is('tags*') ? 'active' : '' }} nav-item">
    <a class="nav-link" href="{!! route('tags.index') !!}"><i data-feather="edit-3"></i><span>Tags</span></a>
</li>
@endcan

@can('ad-show')
<li class="{{ Request::is('ads*') ? 'active' : '' }} nav-item">
    <a class="nav-link" href="{!! route('ads.index') !!}"><i data-feather="edit-3"></i><span>Ads</span></a>
</li>
@endcan

@can('socialMedia-show')
<li class="{{ Request::is('socialMedia*') ? 'active' : '' }} nav-item">
    <a class="nav-link" href="{!! route('socialMedia.index') !!}"><i data-feather="edit-3"></i><span>Social Media</span></a>
</li>
@endcan

@can('ebook-show')
<li class="{{ Request::is('ebook*') ? 'active' : '' }} nav-item">
    <a class="nav-link" href="{!! route('ebook.index') !!}"><i data-feather="edit-3"></i><span>E-Book</span></a>
</li>
@endcan

@can('notification-show')
<li class="{{ Request::is('notification*') ? 'active' : '' }} nav-item">
    <a class="nav-link" href="{!! route('notification.index') !!}"><i data-feather="edit-3"></i><span>Notification</span></a>
</li>
@endcan
