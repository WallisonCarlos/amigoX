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
    
    public static function getMyGroups(){
        $result = DB::table('groups')
            ->join('members_group', 'groups.id_group', '=', 'members_group.group')
            ->join('users', 'users.id', '=', 'groups.administrator')
            ->where('members_group.member', '=', Auth::user()->id)
            ->get();
        return $result;
    }
    
    public static function getRequests() {
        $results = DB::select('select * from '
                . '(members_group INNER JOIN groups ON members_group.group=groups.id_group)'
                . 'INNER JOIN users ON groups.administrator=users.id'
                . ' where member = ? AND accept = ?', array(Auth::user()->id, false));
        return $results;
    }
    
    public static function acceptRequest($id) {
        $result = DB::update('update members_group set accept = ? where member = ? AND id_member = ?', array(true, Auth::user()->id, $id));
        return $result;
    }
    
    public static function removeRequest($id) {
        return DB::delete("delete from members_group where id_member={$id}");
    }
}
