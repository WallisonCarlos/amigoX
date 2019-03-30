@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Meus Grupos') }}</div>

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
                    <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Grupo</th>
                        <th>Administrador</th>
                        <th colspan="2">Ações</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($groups as $group)
                      @php
                        @endphp
                        <tr>
                            <td>{{$group->title}}</td>
                            <td>{{$group->name}}</td>
                            <td><a href="{{route('groups.show', $group->id_group)}}" class="btn btn-primary">Ver</a></td>
                            <td>
                                <form action="{{route('requests.destroy', $group->id_group)}}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <button class="btn btn-danger" type="submit">Sair</button>
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
