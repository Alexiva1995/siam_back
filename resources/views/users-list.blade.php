@extends('adminlte::page')

@section('title', $title . ' - ' . config('adminlte.brand'))

@section('content_header')
    <div class="row">
        <div class="col">
            <h1 class="m-0 text-dark">{{ $title }}</h1>
        </div>
        <div class="col-auto">
            <a class="btn btn-primary" href="/users/add">Agregar</a>
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
                                <th>Nombre y Apellido</th>
                                <th>E-mail</th>
                                <th>Admin</th>
                                <th>Fecha alta</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $user)
                            <tr>
                                <td class="align-middle">{{ $user['name'] . ' ' . $user['last_name'] }}</td>
                                <td class="align-middle">{{ $user['email'] }}</td>
                                <td class="align-middle">@if($user['admin'])<i class="fa fa-check text-primary"></i>@endif</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($user['created_at'])->format("d/m/Y H:i:s") }} (GMT)</td>
                                <td class="align-middle" style="width: 15%">
                                    <a href="/users/edit/{{ $user['id'] }}" class="btn btn-sm btn-secondary">Editar</a>
                                    <button type="button" 
                                    data-toggle="modal" 
                                    data-target="#modal-remove"
                                    data-title="Atención"
                                    data-body="<p>El usuario será eliminado. ¿Estás seguro?</p>"
                                    data-url="/users/{{ $user['id'] }}"
                                    class="btn btn-sm btn-danger"
                                    {{ Auth::user()->id == $user['id'] ? 'disabled' : '' }}>Eliminar</button>
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