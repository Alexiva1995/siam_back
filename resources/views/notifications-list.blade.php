@extends('adminlte::page')

@section('title', $title . ' - ' . config('adminlte.brand'))

@section('content_header')
    <div class="row">
        <div class="col">
            <h1 class="m-0 text-dark">{{ $title }}</h1>
        </div>
        <div class="col-auto">
            <a class="btn btn-primary" href="/notifications/new">Nueva</a>
        </div>
    </div>
@stop

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('danger'))
        <div class="alert alert-danger">
            {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            @if (count($items) > 0)
            <div class="card">
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mensaje (ES)</th>
                                <th>Mensaje (EN)</th>
                                <th>Link</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $notification)
                            <tr>
                                <td class="align-middle"><strong>{{ $notification['es_title'] }}</strong><br>{{ $notification['es_body'] }}</td>
                                <td class="align-middle"><strong>{{ $notification['en_title'] }}</strong><br>{{ $notification['en_body'] }}</td>
                                <td class="align-middle">{{ $notification['link'] }}</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($notification['created_at'])->format("d/m/Y H:i:s") }} (GMT)</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!--card-body-->
            </div><!--card-->
            @else
                No se encontró información.
            @endif
        </div><!--col-->
    </div><!--row-->

    <div class="modal fade" id="modal-remove">
        <form method="POST" action="">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-danger">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No, cancelar</button>
                        <button type="submit" class="btn btn-danger" data-proceed>Sí, eliminar</button>
                    </div>
                </div><!--modal-content-->
            </div><!--modal-dialog-->
        </form>
	</div><!--modal-->
@stop