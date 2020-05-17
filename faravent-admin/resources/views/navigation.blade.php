<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboards</li>
                <li>
                    <a href="/" @if($path=="home") class="mm-active"@endif>
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Jakubčatá - fara
                    </a>
                </li>
                <li class="app-sidebar__heading">Hardware</li>
                <li>
                    <a href="{{route('devicesList')}}" @if($path=="devices") class="mm-active"@endif>
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Zariadenia
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="mm-show">
                        @foreach(Helper::devicesList() as $device)
                        <li>
                            <a href="{{route('showDevice',['id'=>$device->id])}}" @if($path=="device".$device->id) class="mm-active"@endif>
                                <i class="metismenu-icon"></i>
                                {{$device->verbose_name}}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li>
                    <a href="{{route('ota')}}" @if($path=="ota") class="mm-active"@endif>
                        <i class="metismenu-icon pe-7s-display2"></i>
                        OTA Update
                    </a>
                </li>
                <li class="app-sidebar__heading">Miestnosti</li>
                <li>
                    <a href="">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        <span style="text-decoration: line-through;">Stará skúšobňa</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        <span style="text-decoration: line-through;">Nová skúšobňa</span>
                    </a>
                </li>
                <li class="app-sidebar__heading">Systém</li>
                <li>
                    <a href="">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        MQTT server
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        System logs
                    </a>
                </li>
                <li style="display:none;" id="install-button">
                    <a href="">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Install app
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
