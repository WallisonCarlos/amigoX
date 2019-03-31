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
        $result = DB::select('select * from users '
                . 'INNER JOIN 	participants_session ON users.id=participants_session.participant'
                . ' WHERE participants_session.session=?', array($session));
        
        return $result;
    }
    
    public static function pair($session) {
        $result = DB::select('select * from (users '
                . 'INNER JOIN pairs ON users.id=pairs.to)'
                . 'INNER JOIN pairs_session ON pairs_session.pair=pairs.id_pair'
                . ' WHERE pairs.from = ? AND pairs_session.session = ? LIMIT 1', array(Auth::user()->id, $session));
        
        return $result;
    }

    public static function get($session) {
        return DB::select('select * from sessions where id_session=?',array($session));
    }
    
    public static function addPair($session, $pair) {
        DB::table('pairs_session')->insert([
            'pair' => $pair,
            'session' => $session,
        ]);
    }

    
    public static function drawn($session) {
        return DB::update("UPDATE sessions SET drawn = ? WHERE id_session = ?", array(true, $session));
    }

    
    
    public static function random($session) {
        
        $members = self::members($session);
        $members2 = self::members($session);
        $size = count($members2);
        $drawn = array();
        for ($i = 0;$i < $size;$i++) {
            $rand = rand(0, $size-1);
            while ($i == $rand OR in_array($rand, $drawn)) {
               $rand = rand(0, $size-1); 
            }
            $drawn[] = $rand;
            $pair = new \App\Pair();
            $pair->from = $members[$i]->id;
            $pair->to = $members2[$rand]->id;
            $pair->save();
            
            self::addPair($session, $pair->id);
        }
        
        return self::drawn($session);
        
    }
}
