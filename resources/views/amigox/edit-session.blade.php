@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar Sessão') }}</div>

                <div class="card-body">
                    
                    @if (\Session::has('success'))
                      <div class="alert alert-success">
                        {{ \Session::get('success') }}
                      </div>
                     @endif
                     @if ($errors->any())
                        <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                        </div><br />
                      @endif
                    <form method="POST" action="{{route('sessions.update', $session->id)}}">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="group" value="{{$group}}">
                        <div class="form-group">
                            <label for="name" class="">{{ __('Título') }}</label>
                                <input id="name" type="text" class="form-control {{ $errors->has('session') ? ' is-invalid' : '' }}" name="session" value="{{$session->session}}" required autofocus>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('session') }}</strong>
                                    </span>
                                @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleFormControlSelect2" class="">Selecione os Participantes</label>
                            <select name="members[]" multiple class="form-control" id="exampleFormControlSelect2">
                                @foreach ($users as $user)
                                <option value="{{$user->id_user}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-primary form-control">
                                    {{ __('Salvar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
