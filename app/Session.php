<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Session extends Model
{
   protected $fillable = [
        'title',
    ];
   
   
    public static function addParticipant($session, $paticipant) {
        DB::table('participants_session')->insert([
            'participant' => $paticipant,
            'session' => $session,
        ]);
    }
    
    public static function members($session) {
        $result = DB::select('select *, participants_session.id as id_participant, users.id as id_user from users '
                . 'INNER JOIN 	participants_session ON users.id=participants_session.participant'
                . ' WHERE participants_session.session=?', array($session));
        
        return $result;
    }
    
    public static function noMembers($group, $session) {
        $result = DB::select('select *, users.id as id_user, members_group.id as id_member from (users '
                . 'INNER JOIN members_group ON users.id=members_group.member)'
                . ' WHERE members_group.group=? AND members_group.accept=? '
                . 'AND NOT EXISTS (select * from participants_session where'
                . ' participants_session.participant=users.id AND'
                . ' participants_session.session=?)', array($group, true, $session));
        
        return $result;
    }
    
    public static function getGroup($session) {
        $result = DB::select('select *, groups.id as id_group from groups '
                . 'INNER JOIN secrets_friends_group ON groups.id=secrets_friends_group.group'
                . ' WHERE secrets_friends_group.session=?', array($session));
        
        return $result;
    }

        public static function pair($session) {
        $result = DB::select('select *, pairs.id as id_pair, pairs_session.id as id_pairs from (users '
                . 'INNER JOIN pairs ON users.id=pairs.to)'
                . 'INNER JOIN pairs_session ON pairs_session.pair=pairs.id'
                . ' WHERE pairs.from = ? AND pairs_session.session = ?', array(Auth::user()->id, $session));
        
        return $result;
    }
    
    public static function pairs($session) {
        $result = DB::select('select *, pairs.id as id_pair, pairs_session.id id_pairs from (users '
                . 'INNER JOIN pairs ON users.id=pairs.to)'
                . 'INNER JOIN pairs_session ON pairs_session.pair=pairs.id'
                . ' WHERE pairs_session.session = ?', array($session));
        
        return $result;
    }

    public static function get($session) {
        return DB::select('select *, sessions.id as id_session from sessions where id=?',array($session));
    }
    
    public static function addPair($session, $pair) {
        DB::table('pairs_session')->insert([
            'pair' => $pair,
            'session' => $session,
        ]);
    }

    
    public static function drawn($session) {
        return DB::update("UPDATE sessions SET drawn = ? WHERE id = ?", array(true, $session));
    }

    public static function deleteParticipants($session) {
        return DB::delete("delete from participants_session where session={$session}");
    }
    
    public static function deleteParticipant($user, $session) {
        return DB::table('participants_session')
                ->where('participant', '=', $user)
                ->where('session','=', $session)
                ->delete();
    }


    public static function deletePairs($session) {
        foreach (self::pairs($session) as $pair) {
            DB::delete("delete from pairs where pairs.id={$pair->id_pair}");
        }
        return DB::delete("delete from pairs_session where pairs_session.session={$session}");
    } 
    
    public static function random($session) {
        
        $members = self::members($session);
        $members2 = self::members($session);
        $size = count($members2);
        $drawn = array();
        if ($size > 2) {
            for ($i = 0;$i < $size;$i++) {
                $rand = rand(0, $size-1);
                while ($i == $rand OR in_array($rand, $drawn)) {
                   $rand = rand(0, $size-1); 
                }
                $drawn[] = $rand;
                $pair = new \App\Pair();
                $pair->from = $members[$i]->id_user;
                $pair->to = $members2[$rand]->id_user;
                $pair->save();

                self::addPair($session, $pair->id);
            }

            return self::drawn($session);

        } else {
            return false;
        }
    }
}
