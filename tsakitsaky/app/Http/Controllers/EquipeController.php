<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Utilisateurs;
use App\Models\Etape;
use App\Models\Equipe;
use App\Models\CoureurEtape;
use App\Models\TempsCoureurEtape;
class EquipeController extends Controller
{


    public function signIn(Request $request)
    {
        if ($request->session()->has('id_utilisateurEquipe')) {
            return redirect('/');
        }
       return view('auth.equipe.login');
    }

    public function logout(Request $request)
    {
        if (!$request->session()->has('id_utilisateurEquipe')) {
            return redirect('loginEquipe');
        }
        $request->session()->forget('id_utilisateurEquipe');
        $request->session()->forget('name');
        $request->session()->forget('roles');
        return Redirect::to('loginEquipe');
    }

    public function login(Request $request)
     {

        $email = $request->input('email');
        $password = $request->input('password');
        try {
            $response = Utilisateurs::checkLoginEquipe($email, $password);
            $request->session()->put('id_utilisateurEquipe', $response['user']->id_utilisateur);
            $request->session()->put('name', $response['user']->nom);
            $request->session()->put('roles', $response['roles']);
            return redirect()->intended('/');
        } catch (\Throwable $th) {
          return back()->withErrors(['email' => $th->getMessage()]);
        }
     }


     public function index(){
        $lesEtape=DB :: table('etapes')
                        ->select('*')
                        ->get();
        $listCoureur = DB :: table('v_temps_global_coureur')
                        ->select('etape_id', 'nom' , 'temps_chrono')
                        ->where('equipe', session('id_utilisateurEquipe'))
                        ->groupBy('nom', 'etape_id' , 'temps_chrono')
                        ->get();
        $nbcoureur = DB :: table('v_temps_global_coureur')
                        ->select('equipe', 'etape_id', DB::raw('COALESCE(COUNT(coureur_id), 0) as count'))
                        ->where('equipe', session('id_utilisateurEquipe'))
                        ->groupBy('equipe', 'etape_id', 'temps_chrono')
                        ->get();

        return view("template.Layout", [
            'title' => 'Acceuil',
            'page' => "equipe.Acceuil",
            'etapes'=>$lesEtape,
            'coureur' => $listCoureur,
            'nb_coureur' => $nbcoureur
        ]);
    }


     public function listeEtapeEquipe(Request $request){
        $rec = Etape::paginate(10);

        return view("template.Layout", [
            'title' => 'Liste des étapes',
            'page' => "equipe.Etape",
            'recherches' => $rec
        ]);
     }

     public function controlcourreur(Request $request){
        $rec = Etape::paginate(10);

        return view("template.Layout", [
            'title' => 'Liste des étapes',
            'page' => "equipe.Etape",
            'recherches' => $rec
        ]);
     }

     public function listeCoureur($id){
        $listCoureur = CoureurEtape::getListeCoureurEtape($id, session('id_utilisateurEquipe'));
        $nbrMax = Etape::getNombreMaxCoureurEtape($id);
        $eta = Etape::getEtapeLibelle($id);
        $listCoureurEquipe = Equipe::getListeCoureur(session('id_utilisateurEquipe'));
        return view("template.Layout", [
            'title' => 'Formualre affectation coureur a etape',
            'page' => "equipe.Affectation",
            'recherches' => $listCoureur,
            'nbMax' => $nbrMax,
            'etape' => $eta,
            'etape_id' => $id,
            'listCoureurEquipe' => $listCoureurEquipe
        ]);
     }


     public function addAffectationEtape(Request $request){
        $rules = [
            'coureur_id' => 'required|numeric|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $etape_id = $request->input('etape_id');
        $coureur_id = $request->input('coureur_id');
        CoureurEtape::insertCoureurEtape($etape_id, $coureur_id);
        return redirect()->back();
     }

     public function ajoutcoureur($id){
        $listCoureurEquipe = Equipe::getListeCoureur(session('id_utilisateurEquipe'));
        $listCoureurEtape = CoureurEtape::getListeCoureurEtape($id, session('id_utilisateurEquipe'));
        $nbrMax = Etape::getNombreMaxCoureurEtape($id);
            if( count($listCoureurEtape) < $nbrMax ){

                return Redirect::to('listeCoureur/'.$id);
            }
            return redirect()->back()->withErrors("Le nombre maximal de courreur pour ".$listCoureurEtape[0]->etape. " est ".$nbrMax );
     }
}
