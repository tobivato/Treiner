<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{__('Live Training')}}</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon-16x16.png')}}">
        <link rel="manifest" href="{{asset('site.webmanifest')}}">
        <link rel="mask-icon" href="{{asset('safari-pinned-tab.svg')}}" color="#5bbad5">
        <meta name="apple-mobile-web-app-title" content="Treiner">
        <meta name="application-name" content="Treiner">
        <meta name="msapplication-TileColor" content="#006942">
        <meta name="theme-color" content="#006942">    
        <link rel="preload" href="{{ mix('css/zoom.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{{ mix('css/zoom.css') }}"></noscript>
    </head>
<body>

<script src="{{ asset('js/zoom.js')}}"></script>

<script>
    (function(){

        ZoomMtg.preLoadWasm();

        ZoomMtg.prepareJssdk();

        ZoomMtg.init({
            leaveUrl: "{{route('live.index')}}",
            isSupportAV: true,
            success: function () {
                ZoomMtg.join(
                    {
                        meetingNumber: {{$zoomNumber}},
                        userName: "{{Auth::user()->name}}",
                        userEmail: "{{Auth::user()->email}}",
                        signature: "{{$signature}}",
                        apiKey: "{{config('zoom.key')}}",
                        passWord: '',
                        success(res){
                            console.log('join meeting success');
                        },
                        error(res) {
                            console.log(res);
                        }
                    }
                );
            },
            error: function(res) {
                console.log(res);
            }
        });
    })();
</script>

</body>
</html>