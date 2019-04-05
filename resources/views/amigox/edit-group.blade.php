@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar Grupo') }}</div>

                <div class="card-body">
                    <center>
                     <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{route('groups.show', $group[0]->id_group)}}" class="btn btn-secondary">Participantes</a>
                        <a href="{{route('sessions.createSession', $group[0]->id_group)}}" class="btn btn-secondary">Criar Sessão</a>
                        <a href="{{route('sessions.sessionsGroup', $group[0]->id_group)}}" class="btn btn-secondary">Ver Sessões</a>
                        @if ($group[0]->administrator == Auth::user()->id)
                        <a href="{{route('groups.edit', $group[0]->id_group)}}" class="btn btn-secondary">Editar</a>
                        <form onsubmit="return confirm('Tem certeza que remover esse grupo?');" action="{{route('groups.destroy', $group[0]->id_group)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-secondary" type="submit">Remover</button>
                          </form>
                        @endif
                      </div>
                    </center>
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
                    <form method="POST" action="{{route('groups.update', $group[0]->id_group)}}">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="name" class="">{{ __('Título') }}</label>
                                <input id="name" type="text" value="{{$group[0]->title}}" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required autofocus>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleFormControlSelect2" class="">Adicione mais Membros</label>
                            <select name="members[]" multiple class="form-control" id="exampleFormControlSelect2">
                                @foreach ($members as $member)
                                <option value="{{$member->id}}">{{$member->name}}</option>
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
