<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;

class Etape extends Model
{
    protected $table = "etapes";
    protected $fillable = [
        'etape',
        'longueur',
        'nb_coureur',
        'rang',
        'date_depart',
        'heure_depart',
    ];

    public $timestamps = false;
    protected $primaryKey = "id_etape";
    public $incrementing = false;

    public static function getEtapeLibelle($id){
        $rep = Etape::where('id_etape', $id)
                ->first();
         return $rep->etape;
    }

    public static function getNombreMaxCoureurEtape($etapeId){
        $resultat = Etape::where('id_etape', $etapeId)
                ->first();
        return $resultat->nb_coureur;
    }

    public static function  importCsvEtape($csvFilePath){
        $csv = Reader::createFromPath(storage_path('app/' . $csvFilePath), 'r');

        $csv->setDelimiter(',');

        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        $validData = [];

        $lineNumber = 0;
        $errors = [];

        foreach ($records as $record) {
            $lineNumber++;
            $rowErrors = [];
            $etape = trim(($record['etape']));
            $longueur = doubleval(str_replace("km", "", str_replace(",",".", trim(($record['longueur'])))));
            $nb_coureur = intval(str_replace("%", "", str_replace(",",".", trim(($record['nb coureur'])))));
            $rang = intval(str_replace("e", "", str_replace(",",".", trim(($record['rang'])))));
            $date_depart = trim(($record['date départ']));
            $heure_depart = trim(($record['heure départ']));


                if (!empty($rowErrors)) {
                    $errors[] = [
                        'line' => $lineNumber,
                        'row' => $record,
                        'errors' => $rowErrors
                    ];
                }else{
                    $validData[] = [
                        'etape' => $etape,
                        'longueur' => $longueur,
                        'nb_coureur' => $nb_coureur,
                        'rang' => $rang,
                        'date_depart' => $date_depart,
                        'heure_depart' => $heure_depart
                    ];
                }
        }

            DB::beginTransaction();
            try {
                Etape::insert($validData);
                DB::commit();
            }catch (\Exception $e) {
                    DB::rollback();
                    echo "Une erreur est survenue : " . $e->getMessage() . "<br>";
                }
        return $errors;
    }
}

