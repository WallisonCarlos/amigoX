@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Meus Convites') }}</div>

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
                        <th colspan="2">Ação</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($requests as $request)
                      @php
                        @endphp
                        <tr>
                            <td>{{$request->title}}</td>
                            <td>{{$request->name}}</td>
                            <td><a href="{{route('remove-request', $request->id_member)}}" class="btn btn-primary">Aceitar</a></td>
                            <td>
                                <form action="{{route('remove-request', $request->id_member)}}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <button class="btn btn-danger" type="submit">Recusar</button>
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
