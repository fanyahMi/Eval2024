<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
class TempResultat extends Model
{
    protected $table = "temp_resultat";
    protected $fillable = [
        'etape_rang',
        'numero_dossard',
        'nom',
        'genre',
        'date_naissance',
        'equipe',
        'arrivee',
    ];

    public $timestamps = false;
    protected $primaryKey = "";
    public $incrementing = false;


    public static function  importResultat($csvFilePath){
        $csv = Reader::createFromPath(storage_path('app/' . $csvFilePath), 'r');

        $csv->setDelimiter(',');

        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        $validData = [];

        $lineNumber = 0;
        $errors = [];

        $listeDossartImport = [];
        $baseListeCoureur = DB::table('coureur')
        ->get();

        foreach ($records as $record) {
            $lineNumber++;
            $rowErrors = [];


            $etape_rang = trim(($record['etape_rang']));
            $numero_dossard = trim(($record['numero dossard']));
            $nom = trim(($record['nom']));
            $genre = trim(($record['genre']));
            $dtn = trim(($record['date naissance']));
            $equipe = trim(($record['equipe']));
            $arrivee = trim(($record['arrivée']));

            $check = false;

            foreach ($listeDossartImport as $key => $value) {
                if($value == $numero_dossard){
                    $rowErrors[] = "Numero ao";
                    $check = true;
                    break;
                }
            }
            if($check == false){
                foreach ($baseListeCoureur as $key => $value) {
                    if($value->numero_dossard == $numero_dossard){
                        $rowErrors[] = "Numero ao";
                        $check = true;

                        break;
                    }
                }
            }
            if($check == false){
                $listeDossartImport[] = $numero_dossard;
            }



                if (!empty($rowErrors)) {
                    $errors[] = [
                        'line' => $lineNumber,
                        'row' => $record,
                        'errors' => $rowErrors
                    ];
                }else{

                }
                $validData[] = [
                    'etape_rang' => $etape_rang,
                    'numero_dossard' =>$numero_dossard,
                    'nom' =>$nom,
                    'genre' =>$genre,
                    'date_naissance' =>$dtn,
                    'equipe' => $equipe,
                    'arrivee' => $arrivee
                ];



                $check = false;

        }
        if(!empty($errors)){

        }
            DB::beginTransaction();

            try {
                TempResultat::insert($validData);
                DB::statement("
                insert into utilisateur (nom, email, pwd)
                select
                    DISTINCT t.equipe,t.equipe,t.equipe
                    from temp_resultat t
                    LEFT join  utilisateur  u on u.nom = t.equipe
                    WHERE u.nom IS NULL
                ");

                DB::statement("
                insert into role_utilisateur (role_id, utilisateur_id)
                select
                    2,id_utilisateur
                    from utilisateur
                    left join role_utilisateur
                        on role_utilisateur.utilisateur_id = utilisateur.id_utilisateur
                    where role_utilisateur.utilisateur_id is null
                ");

                DB::statement("
                insert into genre (genre)
                select
                   DISTINCT temp_resultat.genre
                   from temp_resultat
                   left join genre on genre.genre = temp_resultat.genre
                   WHEre genre.genre is null
                ");

                DB::statement("
                insert into coureur (nom, numero_dossard, genre_id, dtn, equipe)
                select
                    DISTINCT t.nom,
                    t.numero_dossard,
                    g.id_genre,
                    t.date_naissance,
                    u.id_utilisateur
                    from temp_resultat t
                    left join coureur c on c.nom = t.nom
                    join utilisateur u on u.nom = t.equipe
                    join genre g on g.genre = t.genre
                    where c.nom is null
                ");

                DB::statement("
                insert into coureur_etape (etape_id, coureur_id)
                select
                   et.id_etape,
                   c.id_coureur
                   from temp_resultat t
                   join coureur c on c.nom = t.nom
                   join etapes et on et.rang = t.etape_rang
                   left join coureur_etape ct
                       on ct.etape_id = et.id_etape and ct.coureur_id = c.id_coureur
                   where ct.etape_id is null and  ct.coureur_id is null
                ");

                DB::statement("
                insert into temps_coureur_etape (coureur_etape_id, date_cours, heure_depart, heure_arriver)
                select
                  ct.id_coureur_etape,
                  e.date_depart,
                  e.heure_depart,
                  t.arrivee
                  from temp_resultat t
                  join etapes e on e.rang =  t.etape_rang
                  join coureur c on c.nom = t.nom
                  join coureur_etape ct
                      on ct.etape_id = e.id_etape and ct.coureur_id = c.id_coureur
                  left join
                      temps_coureur_etape tc
                        on  tc.coureur_etape_id = ct.id_coureur_etape
                  where tc.coureur_etape_id is null
                ");


                TempResultat::truncate();

                DB::commit();
            }catch (\Exception $e) {
                dd($e);
                    DB::rollback();
                    echo "Une erreur est survenue : " . $e->getMessage() . "<br>";
                }
        return $errors;
    }
}
