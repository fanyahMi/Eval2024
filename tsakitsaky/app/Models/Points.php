<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class Points extends Model
{
    protected $table = "point_classement";
    protected $fillable = [
        'rang',
        'points',
    ];

    public $timestamps = false;
    protected $primaryKey = "id_point_classement";
    public $incrementing = false;

    public static function importPoints($csvFilePath){
        $csv = Reader::createFromPath(storage_path('app/' . $csvFilePath), 'r');

        $csv->setDelimiter(',');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        $validData = [];

        $lineNumber = 0;
        $errors = [];

        foreach ($records as $record ) {
            $lineNumber++;
            $rowErrors = [];

            $rang = trim(($record['classement']));
            $points = trim(($record['points']));

            if (empty($rang)) {
                $rowErrors[] = "le classement est obligatoire";
            }
            if (empty($points)) {
                $rowErrors[] = "les points sont obligatoire";
            }

            if (!empty($rowErrors)) {
                $errors[] = [
                    'line' => $lineNumber,
                    'row' => $record,
                    'errors' => $rowErrors
                ];
            } else {
                $validData[] = [
                    'rang' => $rang,
                    'points' => $points
                ];
            }

        }
            DB::beginTransaction();
            try {
                DB::table('point_classement')->insert($validData);
                DB::commit();
            } catch (\Exception $th) {
                DB::rollback();
                echo "Une erreur est survenue : ". $th->getMessage() . "<br>";
            }
        return $errors;
    }
}
