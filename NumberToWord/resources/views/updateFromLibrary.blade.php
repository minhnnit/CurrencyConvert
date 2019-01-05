@extends('app')

@section('scripts')
    <script src="{{ asset('vendor/jquery/jquery-1.11.4.ui.min.js'.$common['version_app']) }}" type="text/javascript" async defer></script>
@endsection

@section('content_main')
<?php var_dump($results); ?>
@endsection


@section('scripts-footer')
    @include('elements.auto-update-from-lib')
@endsection