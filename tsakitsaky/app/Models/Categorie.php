<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTime;
class Categorie extends Model
{
    protected $table = "categorie_coureur";
    protected $fillable = [
        'categorie_id',
        'coureur_id'
    ];

    public $timestamps = false;
    protected $primaryKey = "id_categorie_coureur";
    public $incrementing = false;

    public static function getListeCategorie(){
        $result=DB::table('categorie')
            ->select('*')
            ->get();
        return $result;
    }



    public static function differenceEnAnnees($dateDonnee) {
        $dateActuelle = date('Y-m-d');
        $date1 = new DateTime($dateDonnee);
        $date2 = new DateTime($dateActuelle);
        $diff = $date1->diff($date2);
        $annees = $diff->y;
        return $annees;
    }

    public static function generateCategorieCoureur(){
        $coureurs = Equipe::getListeCoureurAll();
        $categorieCoureurs = [];

            foreach ($coureurs as $key => $value) {
                if($value->genre_id == 1){
                    $categorieCoureurs[] =  [
                        'categorie_id' => 1,
                        'coureur_id' => $value->id_coureur
                    ];
                }else{
                    $categorieCoureurs[] =  [
                        'categorie_id' => 2,
                        'coureur_id' => $value->id_coureur
                    ];
                }
                $age = Categorie::differenceEnAnnees($value->dtn);
                if($age < 18){
                    $categorieCoureurs[] =  [
                        'categorie_id' => 3,
                        'coureur_id' => $value->id_coureur
                    ];
                }
            }
        Categorie::insert($categorieCoureurs);

    }

    public static function getClassementCategorie(){
        $result = DB::table('v_classement_categorie')
        ->select('*')
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
}
