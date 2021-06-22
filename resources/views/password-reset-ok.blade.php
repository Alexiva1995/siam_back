@extends('adminlte::master')

@section('adminlte_css')
    @yield('css')
@stop

@section('classes_body', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
        </div>
        <div class="card">
            <div class="card-body pb-0">
                <p class="login-box-msg">La contraseña se ha reiniciado correctamente.</p>
            </div>
        </div>
    </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
