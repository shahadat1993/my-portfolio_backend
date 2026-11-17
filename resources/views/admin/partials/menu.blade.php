@php
  $pc = config('pages.pages'); $groups = config('site.groups');
  $curPage = request()->route('page'); $curSec = request()->route('section'); $onPages = request()->routeIs('admin.pages.*');
  $newMsgs = \App\Models\ContactMessage::where('status', 'new')->count();
  $act = fn ($p) => request()->routeIs($p) ? 'active' : '';
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ route('admin.dashboard') }}" class="app-brand-link"><span class="app-brand-logo demo d-flex align-items-center">@include('admin.partials.logo')</span></a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none"><i class="bx bx-chevron-left bx-sm align-middle"></i></a>
  </div>
  <div class="menu-inner-shadow"></div>
  <ul class="menu-inner py-1">
    <li class="menu-item {{ $act('admin.dashboard') }}"><a href="{{ route('admin.dashboard') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-home-circle"></i><div>Dashboard</div></a></li>

    <li class="menu-header small text-uppercase"><span class="menu-header-text">Website content</span></li>
    <li class="menu-item {{ $onPages ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle"><i class="menu-icon tf-icons bx bx-layout"></i><div>Pages</div></a>
      <ul class="menu-sub">
        @foreach($pc as $pk => $page)
          <li class="menu-item {{ $onPages && $curPage === $pk ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle"><div>{{ $page['label'] }}</div></a>
            <ul class="menu-sub">
              <li class="menu-item {{ $onPages && $curPage === $pk && !$curSec ? 'active' : '' }}"><a href="{{ route('admin.pages.show', [$pk]) }}" class="menu-link"><div>All sections</div></a></li>
              @foreach($page['sections'] as $sk => $sec)
                <li class="menu-item {{ $onPages && $curPage === $pk && $curSec === $sk ? 'active' : '' }}"><a href="{{ route('admin.pages.show', [$pk, $sk]) }}" class="menu-link"><div>{{ \Illuminate\Support\Str::limit($sec['label'], 30) }}</div></a></li>
              @endforeach
            </ul>
          </li>
        @endforeach
      </ul>
    </li>
    <li class="menu-item {{ request()->routeIs('admin.settings') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle"><i class="menu-icon tf-icons bx bx-cog"></i><div>Site settings</div></a>
      <ul class="menu-sub">
        @foreach($groups as $gk => $g)<li class="menu-item"><a href="{{ route('admin.settings') }}#{{ $gk }}" class="menu-link"><div>{{ $g['label'] }}</div></a></li>@endforeach
      </ul>
    </li>
    <li class="menu-item {{ $act('admin.social.*') }}"><a href="{{ route('admin.social.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-share-alt"></i><div>Social links</div></a></li>
    <li class="menu-item {{ $act('admin.colors.*') }}"><a href="{{ route('admin.colors.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-palette"></i><div>Theme colours</div></a></li>

    <li class="menu-header small text-uppercase"><span class="menu-header-text">Portfolio items</span></li>
    <li class="menu-item {{ $act('admin.projects.*') }}"><a href="{{ route('admin.projects.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-briefcase"></i><div>Projects</div></a></li>
    <li class="menu-item {{ $act('admin.posts.*') }}"><a href="{{ route('admin.posts.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-edit"></i><div>Blog posts</div></a></li>
    <li class="menu-item {{ $act('admin.categories.*') }}"><a href="{{ route('admin.categories.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-category"></i><div>Categories</div></a></li>
    <li class="menu-item {{ $act('admin.skills.*') }}"><a href="{{ route('admin.skills.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-bulb"></i><div>Skills</div></a></li>
    <li class="menu-item {{ $act('admin.services.*') }}"><a href="{{ route('admin.services.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-layer"></i><div>Services</div></a></li>
    <li class="menu-item {{ $act('admin.timeline.*') }}"><a href="{{ route('admin.timeline.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-git-branch"></i><div>Journey timeline</div></a></li>
    <li class="menu-item {{ $act('admin.faqs.*') }}"><a href="{{ route('admin.faqs.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-help-circle"></i><div>FAQs</div></a></li>

    <li class="menu-header small text-uppercase"><span class="menu-header-text">Inbox & files</span></li>
    <li class="menu-item {{ $act('admin.messages.*') }}"><a href="{{ route('admin.messages.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-envelope"></i><div>Messages</div>@if($newMsgs)<div class="badge bg-danger rounded-pill ms-auto">{{ $newMsgs }}</div>@endif</a></li>
    <li class="menu-item {{ $act('admin.subscribers.*') }}"><a href="{{ route('admin.subscribers.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-bell"></i><div>Subscribers</div></a></li>
    <li class="menu-item {{ $act('admin.media.*') }}"><a href="{{ route('admin.media.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-images"></i><div>Media library</div></a></li>

    <li class="menu-header small text-uppercase"><span class="menu-header-text">Account</span></li>
    <li class="menu-item {{ $act('admin.profile*') }}"><a href="{{ route('admin.profile') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-user"></i><div>My profile</div></a></li>
    <li class="menu-item"><a href="{{ config('site.frontend_url') }}" target="_blank" class="menu-link"><i class="menu-icon tf-icons bx bx-link-external"></i><div>Open website</div></a></li>
  </ul>
</aside>
