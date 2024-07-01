<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Upload extends Model
{
    use HasFactory;

    public static function uploadImage($request){
        foreach ($request as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $base = "storage/images/".$imageName;
                echo "<br>".$base." <br> ";
                Storage::disk('public')->put('images/' . $imageName, file_get_contents($image));
            }

    }

    public static function importCsv($csvFilePath ){
        $csv = Reader::createFromPath(storage_path('app/' . $csvFilePath), 'r');
        $csv->setHeaderOffset(0); // Si la première ligne est l'en-tête

        $headers = $csv->getHeader();

        $data = $csv->getRecords();

        foreach ($data as $row) {
            foreach ($row as $column) {
                echo $column . ' | ';
            }
            echo '<br>';
        }
    }


    public static function importCsvFinal($csvFilePath ){
        $csv = Reader::createFromPath(storage_path('app/' . $csvFilePath), 'r');
        $csv->setHeaderOffset(0); // Si la première ligne est l'en-tête

         $headers = $csv->getHeader();
        $errors = [];
        $validData = [];
        $lineNumber = 0;

        foreach ($csv as $record) {
            $lineNumber++;
           // $record = array_map('utf8_encode', $records);
            $idseance = trim($record['idseance']);
            $nom_film = trim(utf8_encode($record['nom_film'])); // Encodage en UTF-8
            $categorie_film = trim(utf8_encode($record['categorie_film'])); // Encodage en UTF-8
           $date = trim($record['date']);
            $heure = trim($record['heure']);

            // Validation des champs
            $rowErrors = [];

            // Vérification si idseance est négatif
            if ($idseance < 0) {
                $rowErrors[] = "L'identifiant de la séance ne peut pas être négatif.";
            }

            // Vérification si idseance est un nombre entier
            if (!ctype_digit($idseance)) {
                $rowErrors[] = "L'identifiant de la séance doit être un nombre entier.";
            }

            // Vérification si categorie_film est null ou vide
            if (empty($categorie_film)) {
                $rowErrors[] = "La catégorie du film ne peut pas être vide.";
            }

            // Vérification de la validité de la date
            if (!strtotime($date)) {
                $rowErrors[] = "La date '$date' n'est pas valide.";
            }

            // Vérification de la validité de l'heure
            if (!preg_match("/^(2[0-3]|[01][0-9]):([0-5][0-9])$/", $heure)) {
                $rowErrors[] = "L'heure '$heure' n'est pas valide.";
            }

            // Vérification si heure est un nombre entier
            if (!ctype_digit(str_replace(':', '', $heure))) {
                $rowErrors[] = "L'heure ne peut pas contenir de virgule.";
            }

            // Si des erreurs sont trouvées, les ajouter au tableau des erreurs
            if (!empty($rowErrors)) {
                $errors[] = [
                    'line' => $lineNumber,
                    'row' => $record,
                    'errors' => $rowErrors
                ];
            } else {
                // Si aucune erreur, ajouter les données valides au tableau des données valides
                $validData[] = [
                    'idseance' => $idseance,
                    'nom_film' => $nom_film,
                    'categorie_film' => $categorie_film,
                    'date' => $date,
                    'heure' => $heure
                ];
            }
        }

        // Si aucune erreur, procéder à l'insertion des données dans la table TempTableSeance
        if (empty($errors)) {
            // Début de la transaction
            DB::beginTransaction();

            try {
                // Insertion des données valides dans la table TempTableSeance
                TempTableSeance::insert($validData);


                // Insertion dans categorie_film
                DB::statement("
                    INSERT INTO categorie_film (nom)
                    SELECT DISTINCT t.categorie_film
                    FROM temp_table_seance t
                    LEFT JOIN categorie_film c ON c.nom = t.categorie_film
                    WHERE c.nom IS NULL
                ");

                // Insertion dans film
                DB::statement("
                    INSERT INTO film (titre, categorie_id)
                    SELECT DISTINCT t.nom_film, c.id
                    FROM temp_table_seance t
                    LEFT JOIN film f ON f.titre = t.nom_film
                    JOIN categorie_film c ON c.nom = t.categorie_film
                    WHERE f.titre IS NULL
                ");

                // Insertion dans seance
                DB::statement("
                    INSERT INTO seance (id, id_film, date, heure)
                    SELECT t.idseance, f.id, t.date, t.heure
                    FROM temp_table_seance t
                    JOIN film f ON f.titre = t.nom_film
                ");

                // Troncature de la table TempTableSeance
                TempTableSeance::truncate();

                // Si toutes les opérations ont réussi, commit la transaction
                DB::commit();

                echo "Toutes les opérations ont été effectuées avec succès.<br>";
            } catch (\Exception $e) {
                // En cas d'erreur, rollback la transaction et afficher l'erreur
                DB::rollback();
                echo "Une erreur est survenue : " . $e->getMessage() . "<br>";
            }
        }
        return $errors;
    }




    public static function importExcel($excelFilePath){
        // Lecture et traitement du fichier Excel
        $rows = (new FastExcel)->import(storage_path('app/' . $excelFilePath));

        // Afficher les colonnes de chaque ligne
        foreach ($rows as $row) {
            foreach ($row as $column) {
                echo $column . ' | ';
            }
            echo "<br>";
        }

    }

    public static function genererPDF($equipe, $id_categorie)
    {
        // Données statiques simulées pour remplacer les données de la base de données
        $facture = '00123';
        $dateFacture = '2024-04-04';
        $clientNom = 'John Doe';
        $clientAdresse = '123 Street, City, Country';
        $totalProduit = 150;
        $montant_en_lettre = FormatLetter::convertDecimalToWords($totalProduit);

        // Produits facturés (simulés)
        $detailProduit = array(
            array(
                'reference' => 'P001',
                'description' => 'Produit 1',
                'quantite' => 2,
                'prix_unitaire' => 50,
                'montant_total' => 100
            ),
            array(
                'reference' => 'P002',
                'description' => 'Produit 2',
                'quantite' => 1,
                'prix_unitaire' => 50,
                'montant_total' => 50
            )
        );

        $imageData = file_get_contents('assets/static/images/logo.png');

        // Récupération de l'image (données simulées)
        $imageDataEncoded = base64_encode($imageData);

        // Numéro de symbole (données simulées)
        $numeroSymbol = '№';

        // Génération du HTML pour la facture
        $html = '
        <!-- Styles CSS -->
        <style>
        @page {
            margin: 10mm;
          }
            body {
                font-family: Arial, sans-serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            img {
                width: 100px;
                height: 100px;
            }
            .header {
                margin-bottom: 20px;
            }
            .header p {
                margin: 0;
            }
            .header p b {
                font-size: 16px;
            }
            .invoice-details {
                margin-bottom: 20px;
            }
            .invoice-details p {
                margin: 0;
            }
            .total {
                font-weight: bold;
            }
        </style>

        <!-- Contenu de la facture -->
        <img src="data:image/png;base64,' . $imageDataEncoded . '" alt="Logo">

        <div class="header">
            <p><b>MIANDRISON Hasinjo </b></p>
            <p><b>Toavina</b></p>
            <p><b>H Corporation</b></p>
            <p>Lot IEC 09 Ambatofotsy GAra</p>
            <p>ATSIMONDRANO</p>
            <p>Telephone: 034 90 133 58 </p>
            <p>Mail: toavina@gmail.com</p>
        </div>


        <div class="invoice-details">
            <p><strong>BL/FACTURE ' . $numeroSymbol . ' ' . $facture . '</strong></p>
            <p>Date: ' . $dateFacture . '</p>
            <p>A: ' . $clientNom . '</p>
            <p>Adresse: ' . $clientAdresse . '</p>
        </div>

        <table>
            <tr>
                <th>Référence</th>
                <th>Description</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Montant total</th>
            </tr>';

        foreach ($detailProduit as $produit) {
            $html .= '
            <tr>
                <td>' . $produit['reference'] . '</td>
                <td>' . $produit['description'] . '</td>
                <td style="text-align:right;">' .  number_format($produit['quantite'],2,',',' ')   . '</td>
                <td style="text-align:right;">' . number_format($produit['prix_unitaire'] ,2,',',' '). '</td>
                <td style="text-align:right;">' . number_format($produit['montant_total'],2,',',' ') . '</td>
            </tr>';
        }

        $html .= '
            <tr>
                <td colspan="4" align="right"><strong>Total:</strong></td>
                <td>' .  number_format($totalProduit,2,',',' ') . '</td>
            </tr>
        </table>

        <p class="total"><strong>Montant en lettres:</strong> ' . $montant_en_lettre . '</p>';


        $result = DB::table('v_classement_categorie')
                    ->select('*')
                    ->where('equipe',$equipe)
                    ->where('id_categorie',$id_categorie)
                    ->first();

       // $equipe = $result -> equipe_libelle;
        //$temps = $result -> temps_chrono;
        $equipe = "fhkjshl";
        $temps = "djhsfg";

        $background = file_get_contents('assets/static/images/confetti-vector-background-party-design-with-colorful-confetti_165143-1898.avif');
        $image= base64_encode($background);

        $html='
                <style>
                    body {
                    font-family: Roboto;
                }
                .certificate-container {
                    padding: 50px;
                    width: 1024px;
                }
                .certificate {
                    border: 20px solid #0C5280;
                    padding: 25px;
                    height: 570px;
                    position: relative;
                    background-size: 100%;
                }
                .certificate:after {
                    top: 0px;
                    left: 0px;
                    bottom: 0px;
                    right: 0px;
                    position: absolute;
                    z-index: -1;
                }
                .certificate-header > .logo {
                    width: 150px;
                }
                .certificate-title {
                    text-align: center;
                }
                .certificate-body {
                    text-align: center;
                }
                h1 {
                    font-weight: 400;
                    font-size: 48px;
                    color: #0C5280;
                }
                .student-name {
                    font-size: 24px;
                }
                .certificate-content {
                    margin: 0 auto;
                    width: 750px;
                }
                .about-certificate {
                    width: 380px;
                    margin: 0 auto;
                }
                .topic-description {
                    text-align: center;
                }
                </style>
            ';
            $html.='<div class="certificate-container">';
            $html.='<div class="certificate">';
            $html.='<div class="water-mark-overlay"></div>';
            $html.='<div class="certificate-body">
                        <p class="certificate-title"><strong>RUNNING MARATHON</strong></p>
                        <h1>CERTIFICAT DE MERITE</h1>
                        <p class="student-name"> Eqipe'.$equipe. '</p>';
            $html.='        <div class="certificate-content">';
            $html.='             <div class="about-certificate">
                                <p>
                                    en reconnaissance de sa performance exceptionnelle.
                                </p>
                            </div>';
            $html.='                <p class="topic-title">
                                Avec un chrono impressionnant de '.$temps . ', '.$equipe . ' a démontré un engagement,
                                une détermination et une endurance exemplaires.
                            </p>';
            $html.='             <div class="text-center">
                                <p class="topic-description text-muted">
                                    Nous félicitons Equipe'.$equipe . ' pour cet exploit remarquable et célébrons cette réalisation extraordinaire.
                                </p>
                            </div>';
            $html.='    </div>';
            $html.='         <div class="certificate-footer text-muted">';
            $html.='         <div class="row">';
            $html.='              <div class="">
                                    <p>Organisateur: ______________________</p>
                                </div>';
            $html.='             </div>';
            $html.='         </div>';
            $html.='     </div>';
            $html.='  </div>';
            $html.=' </div>';
            $html.=' </div>';


        return $html;

        return $html;
    }





}
