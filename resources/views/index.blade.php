@extends('app')
@section('content')
    <div id="lista_posts" style="padding-top: 25px;"></div>
@stop
@section('scripts')
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
    <script src="<?=asset('js/post.js')?>"></script>
@stop