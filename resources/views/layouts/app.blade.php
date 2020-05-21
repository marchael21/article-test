<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.header')
<body>
    <div id="app">
        @include('includes.navbar')
        <main class="py-4">
            @yield('content')
        </main>

        <footer class="footer">
            @include('includes.footer') 
        </footer>
    </div>

    <!-- page specific scripts -->
    <script src="{{ asset('js/main.js') }}"></script>

    <script type="text/javascript">
        // alert message
        var alertMsg = {!! Session::has('alertMsg') ? json_encode(Session::get('alertMsg')) : 'false' !!};

        if(typeof alertMsg !== 'undefined') {
            if (alertMsg !== false && alertMsg !== '') {
                renderAlertMsg(alertMsg);
            }       
        }     
    </script>

    <script type="text/javascript">
       
        /*window.addEventListener('load', function() {
            alert($);
        })*/      
    </script>

    @stack('scripts')

</body> 
</html>
