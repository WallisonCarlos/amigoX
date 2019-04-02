<?php

namespace App\Http\Controllers\AmigoX;

use App\Session;
use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SessionController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }
    
    public function createSession($group)
    {
        $users = \App\Group::members($group);
        return view('amigox.create-session', compact('users', 'group'));
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
            'session' => 'required|max:45'
        ]);
        
        $session = new \App\Session();
        $session->session = $request->get('session');
        $session->administrator = Auth::user()->id;
        $session->drawn = false;
        $session->save();
        
        $members = $request->input('members', []);
        $members[] = Auth::user()->id;
        $members = array_unique($members);
        foreach ($members as $memberId) {
            \App\Session::addParticipant($session->id, $memberId);
        }
        
        \App\Group::addSession($request->get('group'), $session->id);
        
        return redirect('sessions/group/'.$request->get('group'))->with('success', 'Sessão adicionada com sucesso!');
    }

    public function sessionsGroup($group){
        $sessions = \App\Group::sessions($group);
        $group = Group::get($group);
        $userAuth = Auth::user()->id;
        return view('amigox.sessions-group', compact('group', 'sessions', 'userAuth'));
    }


    
    /**
     * Display the specified resource.
     *
     * @param  \App\Sessao  $sessao
     * @return \Illuminate\Http\Response
     */
    public function show($session)
    {
        $pair = \App\Session::pair($session);
        $members = \App\Session::members($session);
        $session = \App\Session::get($session);
        $userAuth = Auth::user()->id;
        $group = \App\Session::getGroup($session[0]->id);
        $group = $group[0]->id_group;
        return view('amigox.session', compact('session', 'members', 'userAuth', 'pair', 'group'));
    }
    
    

    public function generatePairs($session) {
        \App\Session::random($session);
        return redirect('sessions/'.$session)->with('success', 'Sorteio realizado com sucesso!');
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sessao  $sessao
     * @return \Illuminate\Http\Response
     */
    public function edit($session)
    {
        $users = \App\Group::members($group);
        $session = Session::find($session);
        return view('amigox.create-session', compact('users', 'session'));
    }
    
    public function editSession($session, $group)
    {
        $users = \App\Session::noMembers($group, $session);
        $session = Session::find($session);
        return view('amigox.edit-session', compact('users', 'session', 'group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sessao  $sessao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $session)
    {
        $validatedRequest = $request->validate([
            'session' => 'required|max:45'
        ]);
        
        $session = \App\Session::find($session);
        $session->session = $request->get('session');
        $session->save();
        
        $group = \App\Session::getGroup($session->id);
        
        $members = $request->input('members', []);
        $members = array_unique($members);
        foreach ($members as $memberId) {
            \App\Session::addParticipant($session->id, $memberId);
        }
                
        return redirect('edit-session/'.$session->id.'/'.$group[0]->id_group)->with('success', 'Sessão atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sessao  $sessao
     * @return \Illuminate\Http\Response
     */
    public function destroy($session)
    {
        Session::deleteParticipants($session);
        Session::deletePairs($session);
        
        $session = Session::find($session);
        
        $session->delete();
        
        return redirect('my-groups')->with('success', 'Sessão removida com sucesso!');
    }
}
