<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Equipe extends Model
{
    public static function getListeCoureur($equipeId){
        $resultat = DB::table('coureur')
                    ->select('*')
                    ->where('equipe', $equipeId)
                    ->get();
        return $resultat;
    }

    public static function getListeCoureurAll(){
        $resultat = DB::table('coureur')
                    ->select('*')
                    ->get();
        return $resultat;
    }

    public static function getClassementEtape(){
        $resultat = DB::table('v_classement_coureur as c')
                    ->select(
                        'c.etape_id',
                        'c.etape',
                        'c.equipe',
                        'c.equipe_libelle',
                        DB::raw('SUM(points) AS total_points'),
                        DB::raw('ROW_NUMBER() OVER (PARTITION BY c.etape_id ORDER BY SUM(points) DESC) AS rang')
                    )
                    ->groupBy('c.etape_id', 'c.etape', 'c.equipe', 'c.equipe_libelle')
                    ->orderBy('c.etape_id')
                    ->get();
        return $resultat;
    }

    public static function getClassementEtapeSimple(){
        $resultat = DB::table('v_classement_coureur_simple as c')
                    ->select(
                        'c.etape_id',
                        'c.etape',
                        'c.equipe',
                        'c.equipe_libelle',
                        DB::raw('SUM(points) AS total_points'),
                        DB::raw('ROW_NUMBER() OVER (PARTITION BY c.etape_id ORDER BY SUM(points) DESC) AS rang')
                    )
                    ->groupBy('c.etape_id', 'c.etape', 'c.equipe', 'c.equipe_libelle')
                    ->orderBy('c.etape_id')
                    ->get();
        return $resultat;
    }


    public static function getClassementEquipe(){
        $resultat = DB::table('v_classement_coureur as c')
                        ->select('c.equipe', 'c.equipe_libelle', DB::raw('SUM(points) as total_points'))
                        ->groupBy('c.equipe', 'c.equipe_libelle')
                        ->orderBy('c.equipe')
                        ->orderBy('total_points')
                        ->get();
        return $resultat;
    }

    public static function getClassementEquipeSimple(){
        $resultat = DB::table('v_classement_equipe_simple')
                    ->select('*')
                    ->orderBy('total_points', 'DESC')
                    ->get();
        return $resultat;
    }

    public static function getEquipe(){
        $resultat = DB::table('role_utilisateur')
                    ->select('*')
                    ->where('role_id', 2)
                    ->join('utilisateur','role_utilisateur.utilisateur_id','=','utilisateur.id_utilisateur')
                    ->get();
        return $resultat;
    }

    public static function genererPDF($equipe,$id_categorie){
        $result = DB::table('v_classement_categorie')
                    ->select('*')
                    ->where('equipe',$equipe)
                    ->where('id_categorie',$id_categorie)
                    ->first();

        $equipe = $result -> equipe_libelle;
        $temps = $result -> temps_chrono;
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
                    background-image: url(../../assets/static/images/confetti-vector-background-party-design-with-colorful-confetti_165143-1898.avif);
                    background-size: 100%;
                    margin-right:80px;
                    margin-top:-70px;
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
            $html.='<div class="certificate-header"><img src="../public/assets/static/images/running-and-marathon-logo-design-running-man-symbol-free-vector.jpg" class="logo" alt=""></div>';
            $html.='<div class="certificate-body">
                        <p class="certificate-title"><strong>RUNNING MARATHON</strong></p>
                        <h1>CERTIFICAT DE MERITE</h1>
                        <p class="student-name"> Equipe '.$equipe. ', categorie '.$result ->categorie .'</p>';
            $html.='        <div class="certificate-content">';
            $html.='             <div class="about-certificate">
                                <p>
                                    en reconnaissance de sa performance exceptionnelle.
                                </p>
                            </div>';
            $html.='                <p class="topic-title">
                                Avec un chrono impressionnant de '.$temps . ', equipe '.$equipe . ' a démontré un engagement,
                                une détermination et une endurance exemplaires.
                            </p>';
            $html.='             <div class="text-center">
                                <p class="topic-description text-muted">
                                    Nous félicitons Equipe '.$equipe . ' pour cet exploit remarquable et célébrons cette réalisation extraordinaire.
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
    }

    public static function geneerPDF(){
        $result = DB::table('v_classement_equipe_simple')
                    ->select('*')
                    ->orderBy('total_points', 'DESC')
                    ->first();

        $equipe = $result -> equipe_libelle;

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
                    background-image: url(../../assets/static/images/confetti-vector-background-party-design-with-colorful-confetti_165143-1898.avif);
                    background-size: 100%;
                    margin-right:80px;
                    margin-top:-70px;
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
            $html.='<div class="certificate-header"><img src="../public/assets/static/images/running-and-marathon-logo-design-running-man-symbol-free-vector.jpg" class="logo" alt=""></div>';
            $html.='<div class="certificate-body">
                        <p class="certificate-title"><strong>RUNNING MARATHON</strong></p>
                        <h1>CERTIFICAT DE MERITE</h1>
                        <p class="student-name"> Equipe'.$equipe. '</p>';
            $html.='        <div class="certificate-content">';
            $html.='             <div class="about-certificate">
                                <p>
                                    en reconnaissance de sa performance exceptionnelle.
                                </p>
                            </div>';
            $html.='                <p class="topic-title">
                                Avec un chrono tres impressionnant , Equipe '.$equipe . ' a démontré un engagement,
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
    }
}
