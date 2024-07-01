<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateurs;
use App\Models\Etape;
use App\Models\TempResultat;
use App\Models\CoureurEtape;
use App\Models\TempsCoureurEtape;
use App\Models\Penalite;
use App\Models\Points;
use App\Models\Equipe;
use App\Models\Categorie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDF;

class AdminController extends Controller
{

    public function dashboard(){

        $classementEquipe = Equipe::getClassementEquipe();
        $classementCategorie = Categorie::getClassementCategorie();
        $classemeEquipeSimple =  Equipe::getClassementEquipeSimple();
        return view("template.Layout", [
            'title' => 'Graphe',
            'page' => "admin.Acceuil",
            'classementEquipe' => $classementEquipe,
            'classementEquipeSimple' => $classemeEquipeSimple,
            'resultat'  =>$classementCategorie
        ]);
    }

    public function signIn(Request $request)
    {
       if ($request->session()->has('id_utilisateurAdmin')) {
           return redirect('/dashboar');
       }
        return view('auth.login');
    }

    public function logout(Request $request)
     {
        if (!$request->session()->has('id_utilisateurAdmin')) {
            return redirect('loginAdmin');
        }
        $request->session()->forget('id_utilisateurAdmin');
        $request->session()->forget('name');
        $request->session()->forget('roles');
        return Redirect::to('loginAdmin');
     }

    public function login(Request $request)
     {

        $email = $request->input('email');
        $password = $request->input('password');
        try {
            $response = Utilisateurs::checkLoginAdmin($email, $password);
            $request->session()->put('id_utilisateurAdmin', $response['user']->id_utilisateur);
            $request->session()->put('name', $response['user']->nom);
            $request->session()->put('roles', $response['roles']);
            return redirect()->intended('/dashboard');
        } catch (\Throwable $th) {
          return back()->withErrors(['email' => $th->getMessage()]);
        }
     }

     public function listeEtape(Request $request){
        $rec = Etape::paginate(10);

        return view("template.Layout", [
            'title' => 'Liste des étapes',
            'page' => "admin.etape.Etape",
            'recherches' => $rec
        ]);
     }

     public function formulaireTemps($id){
        $rec = TempsCoureurEtape::getTempsCoureurEtape($id);
        $eta = Etape::getEtapeLibelle($id);
        $listeCoureur = TempsCoureurEtape::getListeCoureurNonTemps($id);
        $simple = TempsCoureurEtape::getListeCoureurSimple($id);
        return view("template.Layout", [
            'title' => 'Formualre temps courier',
            'page' => "admin.etape.Temps",
            'simple' => $simple,
            'resultat' => $rec,
            'etape' => $eta,
            'coureurs' => $listeCoureur
        ]);
     }

     public function addTemps(Request $request){

        $rules = [
            'coureur_etape_id' => 'required|numeric|min:1',
            'date_depart'=>'required|date',
            'heure_depart' => 'required|date_format:H:i:s',
            'heure_arriver' => 'required|after:date_cours heure_depart'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            dd($validator);
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $coureur_etape_id = $request->input('coureur_etape_id');
        $date_cours=$request->input('date_depart');
        $heure_depart = $request->input('heure_depart');
        $heure_arriver = $request->input('heure_arriver');

        TempsCoureurEtape::insertTempsCoureurEtape($coureur_etape_id,$date_cours, $heure_depart, $heure_arriver);
        return redirect()->back();
     }

     public function importetapesresultat(){
        return view("template.Layout", [
            'title' => 'Import',
            'page' => "admin.import.ImportEtapeResultat"

        ]);
     }

     public function importpoint(){
        return view("template.Layout", [
            'title' => 'Import',
            'page' => "admin.import.ImportPoint"

        ]);
    }

    public function importationpoint(Request $request){

        if ($request->hasFile('csvpoint')) {
            $pointFile = $request->file('csvpoint');
            $csvFilePath = $pointFile->store('csvpoint');
            Points::importPoints($csvFilePath);
        }

        return redirect()->back();

     }

     public function genererCategorie(){
        Categorie::generateCategorieCoureur();
        return redirect()->back();
     }

     public function importationetapesresultat(Request $request){

        if ($request->hasFile('csvetape')) {
            $etapeFile = $request->file('csvetape');
            $csvFilePath = $etapeFile->store('csvetape');
            Etape::importCsvEtape($csvFilePath);
        }

        if ($request->hasFile('csvresultat')) {
            $resultatFile = $request->file('csvresultat');
            $csvFilePath = $resultatFile->store('csvresultat');
            TempResultat::importResultat($csvFilePath);
        }

        return redirect()->back();
     }

     public function clearBase(){
        Utilisateurs::clearBase();
        return redirect('listeEtape');
     }

     public function penalite(){
        $etape=Etape::all();
        $equipe=Equipe::getEquipe();
        return view("template.Layout", [
            'title' => 'Penalité',
            'page' => "admin.penalite.formulaire",
            'etapes' => $etape,
            'equipes' => $equipe
        ]);
    }

    public function addPenalite(Request $request){

        $rules = [
            'etape_id' => 'required|numeric|min:1',
            'equipe_id'=>'required|numeric|min:1',
            'penalite' => 'required|date_format:H:i:s'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            dd($validator);
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $etape_id = $request->input('etape_id');
        $equipe_id=$request->input('equipe_id');
        $penalite = $request->input('penalite');

        Penalite::insertPenalite($etape_id,$equipe_id, $penalite);
        return redirect()->back();
     }

     public function listPenalite(){
        $liste=Penalite::listPenalite();
        return view("template.Layout", [
            'title' => 'Penalité',
            'page' => "admin.penalite.ListEquipePenalisee",
            'liste' => $liste
        ]);
     }


     public function supprimerPenalite(Request $request){
        $id = $etape_id = $request->input('id');
        Penalite::supprimerPenalite($id);
        return redirect()->back();
     }


     public function certificat(){
        $result = DB::table('v_classement_equipe_simple')
                                ->select('*')
                                ->orderBy('total_points', 'DESC')
                                ->first();
        return view("template.Layout", [
            'title' => 'Certificat',
            'page' => "admin.import.ExportCertificat",
            'resultat' => $result
        ]);
     }

     public function exportation(Request $request){
        $equipe = $request->input('equipe');
        $id_categorie = $request->input('id_categorie');
        $html = Equipe::genererPDF($equipe,$id_categorie );
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('certificats.pdf');
     }

     public function export(){
        $html = Equipe::geneerPDF();
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('certificats.pdf');
     }

     public function resultatEtape($id){
        $result = DB::table('v_classement_coureur_simple')
                    ->select('*')
                    ->where('etape_id',$id)
                    ->orderby('rang_coureur2','ASC')
                    ->get();

        return view("template.Layout", [
            'title' => 'Formualre temps courier',
            'page' => "admin.etape.Resultat",
            'resultat' => $result
        ]);
     }

     public static function poinEtape($id){
        $result=DB::table('v_classement_coureur_simple')
                ->select('etape_id','etape',DB::raw('SUM(points) as points'))
                ->where('equipe',$id)
                ->groupBy('etape_id','etape')
                ->get();

        return view("template.Layout", [
            'title' => 'Point',
            'page' => "admin.etape.pointEtape",
            'resultat' => $result
        ]);
     }

}
