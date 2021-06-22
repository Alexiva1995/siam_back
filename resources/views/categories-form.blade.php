@extends('adminlte::page')

@section('title', $title . ' - ' . config('adminlte.brand'))

@section('content_header')
    <div class="row">
        <div class="col">
            <h1 class="m-0 text-dark">{{ $title }}</h1>
        </div>
    </div>
@stop

@section('content')
    <form role="form" method="POST" autocomplete="off" enctype="multipart/form-data">
        @if ($categorie)
            <input type="hidden" name="_method" value="PUT">
        @endif
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Español</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="esTitleInput">Título</label>
                            <input name="es_title" value="{{ old('es_title', optional($categorie)->es_title) }}" type="text" class="form-control {{ $errors->get('es_title') ? 'is-invalid' : '' }}" id="esTitleInput" placeholder="Ej: Estilo de vida">
                            @error('es_title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Inglés</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="enTitleInput">Título</label>
                            <input name="en_title" value="{{ old('en_title', optional($categorie)->en_title) }}" type="text" class="form-control {{ $errors->get('en_title') ? 'is-invalid' : '' }}" id="enTitleInput" placeholder="Ej: Lifestyle">
                            @error('en_title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-5">
            <div class="col">
                <a class="btn btn-lg btn-danger" href="/categories">Cancelar</a>
            </div>
            <div class="col text-right">
                <button type="submit" class="btn btn-lg btn-primary">{{ $categorie ? 'Modificar' : 'Agregar' }}</button>
            </div>
        </div>
    </form>
	
	<div class="modal fade" id="modal-remove">
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
					<button type="button" class="btn btn-danger" data-proceed>Sí, eliminar</button>
				</div>
			</div><!--modal-content-->
		</div><!--modal-dialog-->
	</div><!--modal-->
@stop
