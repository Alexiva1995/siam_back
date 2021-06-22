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
        @if ($user)
            <input type="hidden" name="_method" value="PUT">
        @endif
        {{ csrf_field() }}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="admin" value="1" {{ optional($user)->admin ? 'checked' : '' }} class="custom-control-input" id="customSwitch1" {{ $user && Auth::user()->id == $user['id'] ? 'disabled' : '' }}>
                                <label class="custom-control-label" for="customSwitch1">Admin</label>
                                @if ($user && Auth::user()->id == $user['id'])
                                    <input type="hidden" name="admin" value="1">
                                @endif
                            </div>
                        </div><!--form-group-->
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="nameInput">Nombre</label>
                                    <input name="name" value="{{ old('name', optional($user)->name) }}" type="text" class="form-control {{ $errors->get('name') ? 'is-invalid' : '' }}" id="nameInput">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div><!--col-->
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="lastnameInput">Apellido</label>
                                    <input name="last_name" value="{{ old('last_name', optional($user)->last_name) }}" type="text" class="form-control {{ $errors->get('last_name') ? 'is-invalid' : '' }}" id="lastnameInput">
                                    @error('last_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div><!--col-->
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="emailInput">Email</label>
                                    <input name="email" value="{{ old('email', optional($user)->email) }}" type="text" class="form-control {{ $errors->get('email') ? 'is-invalid' : '' }}" id="emailInput">
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="birthdateInput">Fecha de nacimiento</label>
                                    <input name="birthdate" value="{{ old('birthdate', optional($user)->birthdate) }}" type="text" class="form-control {{ $errors->get('birthdate') ? 'is-invalid' : '' }}" id="birthdateInput" placeholder="" data-inputmask="'alias': 'datetime','inputFormat': 'dd/mm/yyyy','placeholder': 'dd/mm/aaaa'">
                                    @error('birthdate')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div><!--col-->
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="phonenumberInput">Teléfono</label>
                                    <input name="phone_number" value="{{ old('phone_number', optional($user)->phone_number) }}" type="text" class="form-control {{ $errors->get('phone_number') ? 'is-invalid' : '' }}" id="phonenumberInput">
                                    @error('phone_number')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div><!--col-->
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="addressInput">Dirección</label>
                                    <input name="address" value="{{ old('address', optional($user)->address) }}" type="text" class="form-control {{ $errors->get('address') ? 'is-invalid' : '' }}" id="addressInput">
                                    @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="languageInput">Idioma</label>
                                    <select name="language" id="languageInput" class="form-control">
                                        <option value="es" {{ optional($user)->language == 'es' ? 'selected' : '' }}>Español</option>
                                        <option value="en" {{ optional($user)->language == 'en' ? 'selected' : '' }}>Inglés</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="zipcodeInput">Código Postal</label>
                                    <input name="zip_code" value="{{ old('zip_code', optional($user)->zip_code) }}" type="text" class="form-control {{ $errors->get('zip_code') ? 'is-invalid' : '' }}" id="zipcodeInput">
                                    @error('zip_code')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div><!--col-->
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="newPasswordInput">{{ $user ? 'Nueva contraseña' : 'Contraseña' }}</label>
                                    <input name="password" value="" type="password" class="form-control {{ $errors->get('password') ? 'is-invalid' : '' }}" id="newPasswordInput">
                                    @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div><!--col-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ !empty($user['image']) ? 'd-none' : '' }}" id="photoLoader">
                                    <label>Foto</label>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input" id="customFile2">
                                        <label class="custom-file-label" for="customFile2">Elegir archivo</label>
                                    </div>
                                    @error('image')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                                @if (!empty($user['image']))
                                <div class="form-group" on-remove-display="#photoLoader">
                                    <label>Foto</label>
                                    <ul class="mailbox-attachments">
                                        <li id="{{ $user['image']->hash }}">
                                            <span class="mailbox-attachment-icon has-img"><img src="{{ Storage::url($user['image']->path) }}" alt="Attachment"></span>
                                            <div class="mailbox-attachment-info">
                                                <a href="#" class="mailbox-attachment-name">{{ Str::limit($user['image']->name, 18, $end='...') }}</a>
                                                <span class="mailbox-attachment-size clearfix mt-1">
                                                    <span>{{ number_format($user['image']->size / 1024, 2) }} KB</span>

                                                    <div class="btn-group float-right" role="group">
                                                        <button type="button" 
                                                        data-toggle="modal" 
                                                        data-target="#modal-remove"
                                                        data-title="Atención"
                                                        data-body="<p>La foto será eliminada.<br>Esta acción no se puede deshacer. ¿Estás seguro?</p>"
                                                        data-callback="callDelete('#{{ $user['image']->hash }}', '/users/{{ $user['id'] }}/image', '{{ csrf_token() }}')"
                                                        class="btn btn-default btn-sm float-right"><i class="fas fa-trash"></i></button>
                                                    </div>
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div><!--form-group-->
                                @endif
                            </div>
                        </div><!--row-->
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-->
        </div><!--row-->
        <div class="row pb-5">
            <div class="col">
                <a class="btn btn-lg btn-danger" href="/users">Cancelar</a>
            </div>
            <div class="col text-right">
                <button type="submit" class="btn btn-lg btn-primary">{{ $user ? 'Modificar' : 'Agregar' }}</button>
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
