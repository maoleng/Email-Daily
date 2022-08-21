<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="{{route('template.index')}}" class="flex mr-auto">
            <img alt="Mao Leng" class="w-6" src="{{asset('app/images/logo.png')}}" style="width:40px">
        </a>
        <a href="javascript:;" class="mobile-menu-toggler">
            <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i>
        </a>
    </div>
    <div class="scrollable">
        <a href="{{route('template.index')}}" class="mobile-menu-toggler">
            <i data-lucide="x-circle" class="w-8 h-8 text-white transform -rotate-90"></i>
        </a>
        <ul class="scrollable__content py-2">
            <li>
                <a href="javascript:;" class="menu menu--active">
                    <div class="menu__icon">
                        <i data-lucide="home"></i>
                    </div>
                    <div class="menu__title">
                        Mẫu tin nhắn
                    </div>
                </a>
            </li>



        </ul>
    </div>
</div>
