@extends('adminlte::page')

@section('title', 'Panel de Control - SIAM')

@section('content_header')
    <h1 class="m-0 text-dark">Panel de control</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-info">
              <div class="inner">
              <h3>{{ $store_count }}</h3>

                <p>Tiendas</p>
              </div>
              <div class="icon">
                <i class="fa fa-store"></i>
              </div>
              <a href="/stores" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
              <div class="inner">
              <h3>{{ $service_count }}</h3>

                <p>Servicios</p>
              </div>
              <div class="icon">
                <i class="fa fa-concierge-bell"></i>
              </div>
              <a href="/services" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
              <div class="inner">
              <h3>{{ $discount_count }}</h3>

                <p>Promociones</p>
              </div>
              <div class="icon">
                <i class="fa fa-tags"></i>
              </div>
              <a href="/discounts" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $user_count }}</h3>

                <p>Usuarios</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="/users" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@stop
