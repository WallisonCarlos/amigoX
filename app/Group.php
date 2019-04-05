<?php

namespace App;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $fillable = [
        'title',
    ];
    
    public static function addMember($group, $member, $accept = false) {
        DB::table('members_group')->insert([
            'member' => $member,
            'group' => $group,
            'accept' => $accept,
        ]);
    }
    
    public static function addSession($group, $session) {
        DB::table('secrets_friends_group')->insert([
            'session' => $session,
            'group' => $group,
        ]);
    }
    
    public static function getMyGroups(){
        $result = DB::select('select *, groups.id as id_group from (groups inner join members_group on groups.id=members_group.group)'
                . 'inner join users on users.id=groups.administrator where members_group.member=? AND members_group.accept=?', array(Auth::user()->id, true));
        return $result;
    }
    
    public static function getRequests() {
        $results = DB::select('select *, members_group.id as id_member, groups.id as id_group from '
                . '(members_group INNER JOIN groups ON members_group.group=groups.id)'
                . 'INNER JOIN users ON groups.administrator=users.id'
                . ' where member = ? AND accept = ?', array(Auth::user()->id, false));
        return $results;
    }
    
    public static function acceptRequest($id) {
        $result = DB::update('update members_group set accept = ? where member = ? AND id=?', array(true, Auth::user()->id, $id));
        return $result;
    }
    
    public static function removeRequest($id) {
        return DB::delete("delete from members_group where id={$id}");
    }
    
    public static function removeRequestFromGroup($user, $group) {
        return DB::table('members_group')->where('member', '=', $user)->where('group', '=', $group)->delete();
        
    }
    
    public static function deleteMembers($group) {
        return DB::delete("delete from members_group where members_group.group=?", array($group));
    }
    
    
    public static function deletePairs($group) {
        foreach (self::sessions($group) as $session) { 
            DB::delete("delete from sessions where sessions.id={$session->id_session}");
        }
        return DB::delete("delete from secrets_friends_group where secrets_friends_group.group={$group}");
    } 
    
    public static function members($group) {
        $result = DB::select('select *, members_group.id as id_member from users '
                . 'INNER JOIN members_group ON users.id=members_group.member'
                . ' WHERE members_group.group=? AND members_group.accept=?', array($group, true));
        
        return $result;
    }
    
    public static function sessions($group) {
        $result = DB::select('select *, sessions.session as title, sessions.id as id_session from (sessions '
                . 'INNER JOIN secrets_friends_group ON sessions.id=secrets_friends_group.session)'
                . ' WHERE secrets_friends_group.group=?', array($group));
        
        return $result;
    }
    
    public static function noMembers($group) {
        $result = DB::select('select * from users '
                . ' WHERE NOT EXISTS(select * from members_group where members_group.member=users.id AND members_group.group=?)', array($group));
        
        return $result;
    }
    
    public static function get($group) {
        return DB::select('select *, id as id_group from groups where id=?', array($group));
    }
    
    public static function accept($id) {
        $result = DB::update('UPDATE members_group SET accept = ? WHERE member = ? AND id = ?', array(true, Auth::user()->id, $id));
        return $result;
    }
}
