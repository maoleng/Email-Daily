<!DOCTYPE html>
<html lang="en" class="light theme">
    @include('app-theme.page')

    <body class="py-5">
        @include('app-theme.sidebar-mb')
        <div class="flex mt-[4.7rem] md:mt-0">
            @include('app-theme.sidebar-pc')
            <div class="content">
                @include('app-theme.header')
                <div class="intro-y flex items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">@yield('title')</h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    @yield('content')
                </div>
            </div>
        </div>

    <script src="{{asset('app/js/app.js')}}"></script>
    @yield('script')
    </body>
</html>
