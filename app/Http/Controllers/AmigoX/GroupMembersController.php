<?php

namespace App\Http\Controllers\AmigoX;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class GroupMembersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = \App\Group::getRequests();
        return view('amigox.requests', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
     
    }


        /**
     * Display the specified resource.
     *
     * @param  \App\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = '';
        $status = '';
        if (\App\Group::removeRequest($id)) {
            $msg = 'Solicitação recusada com sucesso!';
            $status = 'success';
        } else {
            $status = 'error';
            $msg = 'Problemas em recusar solicitação, tente novamente mais tarde!';
        }
        return redirect('requests.index')->with($status, $msg);
    }
}
