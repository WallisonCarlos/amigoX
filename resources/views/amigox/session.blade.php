@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Sessão de Amigo Secreto') }}</div>

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
                     <h3>{{$session[0]->session}}</h3>
                     <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="" class="btn btn-secondary">Participantes</a>
                        @if ($session[0]->administrator == $userAuth)
                        @if (!$session[0]->drawn)
                        <a href="{{route('sessions.generatePairs', $session[0]->id_session)}}" class="btn btn-secondary">Sortear</a>
                        @endif
                        <a href="{{route('sessions.editSession', ['session'=>$session[0]->id_session,'group'=>$group])}}" class="btn btn-secondary">Editar</a>
                        <form onsubmit="return confirm('Tem certeza que deseja remover essa sessão?');" action="{{route('sessions.destroy', $session[0]->id_session)}}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <button class="btn btn-secondary" type="submit">Remover</button>
                                </form>
                        @endif
                      </div>
                     <h4>Participantes</h4>
                     </center>
                     <p><b>Meu par:</b> 
                     @if (!$session[0]->drawn)
                        Ainda não foi sorteado.
                     @else
                       {{$pair[0]->name}}                       
                     @endif
                     </p>
                    <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th colspan="2">Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($members as $member)
                        <tr>
                            <td>{{$member->name}}</td>
                            <td>{{$member->email}}</td>
                            @if ($member->participant != $userAuth)
                            <td><a href="" class="btn btn-primary">Mensagem</a></td>
                            @endif
                            <td>
                                <form onsubmit="return confirm('Tem certeza que deseja remover esse membro dessa sessão?');" action="{{route('sessions.destroyParticipant', ['user' => $member->id_user, 'session' => $member->session])}}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  @if($session[0]->administrator == $userAuth and $member->participant != $userAuth and !$session[0]->drawn)
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
