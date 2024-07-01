<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TempsCoureurEtape extends Model
{
   protected $table = "temps_coureur_etape";
    protected $fillable = [
        'coureur_etape_id',
        'date_cours',
        'heure_depart',
        'heure_arriver',
        'penalite',
    ];

    public $timestamps = false;
    protected $primaryKey = "id_temps_coureur_etape";
    public $incrementing = false;


    public static function insertTempsCoureurEtape($coureurEtapeId,$date_cours ,$heureDepart, $heureArriver){
        TempsCoureurEtape::create([
            'coureur_etape_id'=>$coureurEtapeId,
            'date_cours'=>$date_cours,
            'heure_depart'=>$heureDepart,
            'heure_arriver'=>$heureArriver
        ]);
    }

    public static function getTempsCoureurEtape($etapeId){
        $result = DB::table('v_classement_coureur')
        ->select('*')
        ->where('etape_id', $etapeId)
        ->get();

        $data = array();
        $listeCategorie = Categorie::getListeCategorie();

        foreach ($listeCategorie as $key => $value) {
            $categorie = $value->categorie;
            if (!isset($data[$key])) {
                $data[$key] = array(
                    'categorie' => $categorie,
                    'data' => array()
                );
            }
            foreach ($result as $v) {
                if ($v->id_categorie == $value->id_categorie) {
                    $data[$key]['data'][] = $v;
                }
            }
        }
        return $data;
    }

    public static function getListeCoureurSimple($etapeId){
        $result = DB::table('v_classement_coureur_simple')
        ->select('*')
        ->where('etape_id', $etapeId)
        ->get();
        return $result;
    }

    public static function getListeCoureurNonTemps($etapeId){
        $result=DB::table('v_liste_coureur_sans_duree_etape')
            ->select('*')
            ->where('etape_id', $etapeId)
            ->get();
        return $result;
    }


}
