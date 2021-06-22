@extends('adminlte::page')

@section('title', $title . ' - ' . config('adminlte.brand'))

@section('content_header')
    <div class="row">
        <div class="col">
            <h1 class="m-0 text-dark">{{ $title }}</h1>
        </div>
        <div class="col-auto">
            <a class="btn btn-primary" href="/events/add">Agregar</a>
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

    <div class="row">
        <div class="col-12">
            @if (count($items) > 0)
            <div class="card">
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="d-none d-sm-table-cell"></th>
                                <th>Título</th>
                                <th>Bajada</th>
                                <th>Suscripciones</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $event)
                            <tr>
                                <td style="width: 8%" class="d-none d-sm-table-cell">
                                    @if (!empty($event['image']))
                                        <img src="{{ Storage::url($event['image']->path) }}" class="img-thumbnail">
                                    @endif
                                </td>
                                <td class="align-middle">{{ $event['es_title'] }}</td>
                                <td class="align-middle">{{ Str::limit($event['es_caption'], 100, $end='...') }}</td>
                                <td class="align-middle">
                                    @if (count($event['users']) > 0)
                                    <a href="javascript:;" 
                                    data-toggle="modal" 
                                    data-target="#modal-list"
                                    data-title="Suscripciones - {{ $event['title'] }}"
                                    data-body="
                                        <table class='table'>
                                            <thead>
                                                <tr>
                                                    <th class='d-none d-sm-table-cell'>ID</th>
                                                    <th>Nombre</th>
                                                    <th>Apellido</th>
                                                    <th>Email</th>
                                                    <th>Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($event['users'] as $user)
                                                <tr>
                                                    <td>{{ $user['id'] }}</td>
                                                    <td>{{ $user['name'] }}</td>
                                                    <td>{{ $user['last_name'] }}</td>
                                                    <td>{{ $user['email'] }}</td>
                                                    <td>{{ $user['suscription_date'] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    "
                                    data-url="/events/subscriptions/{{ $event['id'] }}">{{ count($event['users']) }}</a>
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="align-middle" style="width: 15%">
                                    <a href="/events/edit/{{ $event['id'] }}" class="btn btn-sm btn-secondary">Editar</a>
                                    <button type="button" 
                                    data-toggle="modal" 
                                    data-target="#modal-remove"
                                    data-title="Atención"
                                    data-body="<p>El evento será eliminado. ¿Estás seguro?</p>"
                                    data-url="/events/{{ $event['id'] }}"
                                    class="btn btn-sm btn-danger">Eliminar</button>
                                </td>
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

    <div class="modal fade" id="modal-list">
        <form method="POST" action="">
            {{ csrf_field() }}
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        
                    </div>
                    <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Exportar a XLS</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </form>
    </div><!-- /.modal -->

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