<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Penalite extends Model
{
   protected $table = "penalite";
    protected $fillable = [
        'etape_id',
        'equipe',
        'penalite'
    ];

    public $timestamps = false;
    protected $primaryKey = "id_penalite";
    public $incrementing = false;

    public static function insertPenalite($etape_id, $equipe_id, $penalite){
        Penalite::create([
            'etape_id' => $etape_id,
            'equipe' => $equipe_id,
            'penalite' => $penalite
        ]);
    }

    public static function listPenalite(){
        $result=DB::table('penalite')
                    ->select('*')
                    ->join('etapes','etapes.id_etape','=','penalite.etape_id')
                    ->join('utilisateur','utilisateur.id_utilisateur','=','penalite.equipe')
                    ->get();

        return $result;
    }

    public static function supprimerPenalite($id){
        $resource = Penalite::findOrFail($id);
        $resource->delete();
    }
}
