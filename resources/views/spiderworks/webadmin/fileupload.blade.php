@extends('spiderworks.webadmin.app')

@section('head')
    @parent
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="{{ asset('webadmin/assets/plugins/fileupload/css/jquery.fileupload.css')}}">
    <link rel="stylesheet" href="{{ asset('webadmin/assets/plugins/fileupload/css/jquery.fileupload-ui.css')}}">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="{{ asset('webadmin/assets/plugins/fileupload/css/jquery.fileupload-noscript.css')}}"></noscript>
    <noscript><link rel="stylesheet" href="{{ asset('webadmin/assets/plugins/fileupload/css/jquery.fileupload-ui-noscript.css')}}"></noscript>
@endsection

@section('bottom')
    @parent
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="{{ asset('webadmin/assets/plugins/fileupload/js/load-image.all.min.js')}}"></script> 
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="{{ asset('webadmin/assets/plugins/fileupload/js/canvas-to-blob.min.js')}}"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="{{ asset('webadmin/assets/plugins/fileupload/js/jquery.iframe-transport.js')}}"></script>
    <!-- The basic File Upload plugin -->
    <script src="{{ asset('webadmin/assets/plugins/fileupload/js/jquery.fileupload.js')}}"></script>
    <!-- The File Upload processing plugin -->
    <script src="{{ asset('webadmin/assets/plugins/fileupload/js/jquery.fileupload-process.js')}}"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="{{ asset('webadmin/assets/plugins/fileupload/js/jquery.fileupload-image.js')}}"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="{{ asset('webadmin/assets/plugins/fileupload/js/jquery.fileupload-audio.js')}}"></script>
    <!-- The File Upload video preview plugin -->
    <script src="{{ asset('webadmin/assets/plugins/fileupload/js/jquery.fileupload-video.js')}}"></script>
    <!-- The File Upload validation plugin -->
    <script src="{{ asset('webadmin/assets/plugins/fileupload/js/jquery.fileupload-validate.js')}}"></script>
    <!-- The File Upload user interface plugin -->
    <script src="{{ asset('webadmin/assets/plugins/fileupload/js/jquery.fileupload-ui.js')}}"></script>
@endsection
