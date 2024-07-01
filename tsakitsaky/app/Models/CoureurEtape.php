<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoureurEtape extends Model
{
    protected $table = "coureur_etape";
    protected $fillable = [
        'etape_id',
        'coureur_id',
    ];

    public $timestamps = false;
    protected $primaryKey = "id_coureur_etape";
    public $incrementing = false;

    public static function insertCoureurEtape($etapeId, $coureurId){
        CoureurEtape::create([
            'etape_id'=> $etapeId,
            'coureur_id'=>$coureurId
        ]);
    }

    public static function getListeCoureurEtape($etapeId, $equipeId){
        $resultat = DB::table('coureur_etape')
                        ->select('*')
                        ->join('coureur', 'coureur.id_coureur', '=', 'coureur_etape.coureur_id')
                        ->join('etapes','etapes.id_etape','=','coureur_etape.etape_id')
                        ->where('etape_id', $etapeId)
                        ->where('equipe', $equipeId)
                        ->get();
        return $resultat;
    }

}
