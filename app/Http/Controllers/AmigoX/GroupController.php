<?php

namespace App\Http\Controllers\AmigoX;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class GroupController extends Controller
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
        //
    }

    
    public function myGroups() {
        $groups = \App\Group::getMyGroups();
        return view('amigox.my-groups', compact('groups'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = \App\User::all();
        return view('amigox.create-group', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validatedRequest = $request->validate([
            'title' => 'required|max:45'
        ]);
        
        $group = new \App\Group();
        $group->title = $request->get('title');
        $group->administrator = Auth::user()->id;
        $group->save();
        
        $members = $request->input('members', []);
        $members[] = Auth::user()->id;
        $members = array_unique($members);
        foreach ($members as $memberId) {
            if ($memberId == Auth::user()->id) {
                \App\Group::addMember($group->id, $memberId, true);
            } else {
                \App\Group::addMember($group->id, $memberId);
            }
        }
        
        return redirect('my-groups')->with('success', 'Grupo adicionado com sucesso!');
    }

    
    public function acceptRequest($id) {
        $msg = '';
        $status = '';
        if (\App\Group::acceptRequest($id)) {
            $msg = 'Solicitação aceita com sucesso!';
            $status = 'success';
        } else {
            $status = 'error';
            $msg = 'Problemas em aceitar solicitação, tente novamente mais tarde!';
        }
        return redirect('requests')->with($status, $msg);
    }

        /**
     * Display the specified resource.
     *
     * @param  \App\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function show($group)
    {
        $members = \App\Group::members($group);
        $group = Group::get($group);
        $userAuth = Auth::user()->id;
        return view('amigox.group', compact('group', 'members', 'userAuth'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function edit($group)
    {
        $members = Group::noMembers($group);
        $group = Group::get($group);
        return view('amigox.edit-group', compact('group', 'members'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $group)
    {
        
        $validatedRequest = $request->validate([
            'title' => 'required|max:45'
        ]);
        
        $group = Group::find($group);            
        $group->title = $request->input('title');       
        
        $group->save();
        
        $members = $request->input('members', []);
        //$members[] = Auth::user()->id;
        foreach ($members as $memberId) {
            if ($memberId == Auth::user()->id) {
                \App\Group::addMember($group->id, $memberId, true);
            } else {
                \App\Group::addMember($group->id, $memberId);
            }
        }
        
        return redirect('groups/'.$group->id.'/edit')->with('success', 'Grupo atualizado com sucesso!');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grupo $grupo)
    {
        //
    }
}
