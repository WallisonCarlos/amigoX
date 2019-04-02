@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Grupo') }}</div>

                <div class="card-body">
                    @if (\Session::has('success'))
                      <div class="alert alert-success">
                        {{ \Session::get('success') }}
                      </div>
                     @endif
                     @if (\Session::has('error'))
                      <div class="alert alert-danger">
                        {{ \Session::get('error') }}
                      </div>
                     @endif
                     <center>
                     <h3>{{$group[0]->title}}</h3>
                     <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{route('groups.show', $group[0]->id_group)}}" class="btn btn-secondary">Participantes</a>
                        <a href="{{route('sessions.createSession', $group[0]->id_group)}}" class="btn btn-secondary">Criar Sessão</a>
                        <a href="" class="btn btn-secondary">Ver Sessões</a>
                        @if ($group[0]->administrator == $userAuth)
                        <a href="{{route('groups.edit', $group[0]->id_group)}}" class="btn btn-secondary">Editar</a>
                        <form action="{{route('groups.destroy', $group[0]->id_group)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-secondary" type="submit">Remover</button>
                          </form>
                        @endif
                      </div>
                     <h4>Sessões de amigos secretos</h4>
                     </center>
                    <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Sessão</th>
                        <th colspan="2">Ações</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($sessions as $session)
                        <tr>
                            <td>{{$session->title}}</td>
                            <td><a href="{{route('sessions.show', $session->id_session)}}" class="btn btn-primary">Ver</a></td>
                            <td>
                                <form action="{{route('requests.destroy', $session->id_session)}}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  @if($group[0]->administrator == $userAuth)
                                  <button class="btn btn-danger" type="submit">Remover</button>
                                  @endif
                                </form>
                            </td>
                            
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
