<!DOCTYPE html>
<html lang="en" class="light theme">
    @include('app.page')

    <body class="py-5">
        @include('app.sidebar-mb')
        <div class="flex mt-[4.7rem] md:mt-0">
            @include('app.sidebar-pc')
            <div class="content">
                @include('app.header')
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 2xl:col-span-9">
                        <div class="grid grid-cols-12 gap-6">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="{{asset('app/js/app.js')}}"></script>
    </body>
</html>
