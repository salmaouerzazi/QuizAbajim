<!DOCTYPE html>
<html>
<head>
    <title>Laravel </title>
    <!-- PWA  -->
<meta name="theme-color" content="#6777ef"/>
<link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
<link rel="manifest" href="{{ asset('/manifest.json') }}">
</head>
<body>
    
<div class="container">
    <h1>Laravel </h1>
    <a class="btn btn-info" href="javascript:void(0)" id="createNewPost"> Add New Post</a>

</div>
   

    
</body>
 <script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script>
</html>