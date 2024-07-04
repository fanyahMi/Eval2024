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
            'title' => 'Classement de Course par Équipe - Global et par Catégorie            ',
            'page' => "admin.Acceuil",
            'classementEquipe' => $classementEquipe,
            'classementEquipeSimple' => $classemeEquipeSimple,
            'resultat'  =>$classementCategorie,
            'descriptionMeta' => "Consultez le classement complet des courses par équipe, incluant les classements globaux sans catégorie et les classements spécifiques par catégorie. Visualisez les performances des équipes grâce à des graphiques détaillés.            ",
            'keywordMeta'=>"classement de course, classement par équipe, classement global, classement par catégorie, course, compétition, résultats, graphiques de performance"
                ]);
    }

    public function signIn(Request $request)
    {
       if ($request->session()->has('id_utilisateurAdmin')) {
           return redirect('/classement-course-equipe');
       }
        return view('auth.login');
    }

    public function logout(Request $request)
     {
        if (!$request->session()->has('id_utilisateurAdmin')) {
            return redirect('Login-Administrateur');
        }
        $request->session()->forget('id_utilisateurAdmin');
        $request->session()->forget('name');
        $request->session()->forget('roles');
        return Redirect::to('Login-Administrateur');
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
            return redirect()->intended('/classement-course-equipe');
        } catch (\Throwable $th) {
          return back()->withErrors(['email' => $th->getMessage()]);
        }
     }

     public function listeEtape(Request $request){
        $rec = Etape::paginate(10);

        return view("template.Layout", [
            'title' => 'Liste des Étapes de la Course - Ajouter Temps et Résultats par Étape',
            'page' => "admin.etape.Etape",
            'descriptionMeta' => "Consultez la liste complète des étapes de la course, avec des détails sur le nombre de coureurs, la longueur de chaque étape, et accédez aux liens pour ajouter les temps pour chaque étape et consulter les résultats détaillés.            ",
            'keywordMeta'=>"étapes de la course, liste des étapes, détails des étapes, ajouter temps étape, résultats par étape, course, compétition, gestion de course",
            'recherches' => $rec
        ]);
     }

     public function formulaireTemps($id){
        $rec = TempsCoureurEtape::getTempsCoureurEtape($id);
        $eta = Etape::getEtapeLibelle($id);
        $listeCoureur = TempsCoureurEtape::getListeCoureurNonTemps($id);
        $simple = TempsCoureurEtape::getListeCoureurSimple($id);
        return view("template.Layout", [
            'title' => 'Formualre pour ajouter le temps par coureur',
            'page' => "admin.etape.Temps",
            'descriptionMeta' => "Utilisez notre formulaire pour ajouter le temps d'un coureur pour une étape spécifique de la course. Suivez les performances individuelles des coureurs et enregistrez leurs temps pour chaque étape de la compétition. Notre formulaire convivial vous permet de saisir facilement les informations nécessaires et de les soumettre en un clic. Restez à jour avec les temps des coureurs et suivez l'évolution de la compétition.",
            'keywordMeta'=>"formulaire de temps coureur, ajout temps étape, performance coureur, suivi temps coureur, compétition sportive, enregistrement temps, formulaire convivial, temps étape course, suivi compétition, mise à jour temps coureurs",
            'simple' => $simple,
            'resultat' => $rec,
            'etape' => $eta,
            'coureurs' => $listeCoureur
        ]);
     }

     public function addTemps(Request $request)
    {
        // Règles de validation
        $rules = [
            'coureur_etape_id' => 'required|numeric|min:1',
            'date_depart' => 'required|date',
            'heure_depart' => 'required|date_format:H:i:s',
            'heure_arriver' => 'required|after:date_depart heure_depart'
        ];

        // Messages d'erreur personnalisés
        $messages = [
            'heure_arriver.after' => 'L\'heure d\'arrivée doit être postérieure à l\'heure de départ et à la date de départ.'
        ];

        // Validation des données
        $validator = Validator::make($request->all(), $rules, $messages);

        // Vérification de la validation
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Récupération des données du formulaire
        $coureur_etape_id = $request->input('coureur_etape_id');
        $date_depart = $request->input('date_depart');
        $heure_depart = $request->input('heure_depart');
        $heure_arriver = $request->input('heure_arriver');

        // Insertion des données dans la base de données
        TempsCoureurEtape::insertTempsCoureurEtape($coureur_etape_id, $date_depart, $heure_depart, $heure_arriver);

        // Réponse de succès
        return response()->json(['success' => 'Temps ajouté avec succès.']);
    }

     public function importetapesresultat(){
        return view("template.Layout", [
            'title' => 'Importation des données',
            'descriptionMeta' => "Utilisez notre formulaire pour importer les données des étapes et leurs résultats dans la compétition. Notre page vous permet de télécharger un fichier contenant les informations nécessaires, telles que les détails de chaque étape, les résultats des participants, les temps, les classements, etc. Importez facilement ces données en sélectionnant le fichier à partir de votre appareil ou en utilisant un lien externe. Assurez-vous que le fichier est au format approprié pour une importation correcte. Simplifiez le processus de gestion des données de la compétition grâce à notre formulaire convivial.",
            'keywordMeta'=>"formulaire d'importation de données, importation de résultats, importation de données d'étapes, compétition sportive, gestion des données, téléchargement de fichiers, résultats des participants, temps d'étape, classements d'étape, format de fichier",
            'page' => "admin.import.ImportEtapeResultat"

        ]);
     }

     public function importpoint(){
        return view("template.Layout", [
            'title' => 'Importation des points',
            'descriptionMeta' => "Utilisez notre formulaire pour importer les points utilisés pour le calcul des résultats. Cette page vous permet de télécharger un fichier contenant les points attribués à chaque critère, participant ou équipe, qui sont utilisés pour déterminer les résultats. Importez facilement ces points en sélectionnant le fichier à partir de votre appareil ou en utilisant un lien externe. Assurez-vous que le fichier est au format approprié pour une importation correcte. Simplifiez le processus de gestion des points et obtenez des résultats précis grâce à notre formulaire convivial.",
            'keywordMeta'=>"formulaire d'importation de points, importation de points, points de résultat, calcul des résultats, compétition sportive, gestion des points, téléchargement de fichiers, format de fichier",
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
        return redirect('classement-course-equipe');
     }

     public function penalite(){
        $etape=Etape::all();
        $equipe=Equipe::getEquipe();
        return view("template.Layout", [
            'title' => 'Formulaire pour ajout de penalite',
            'page' => "admin.penalite.formulaire",
            'descriptionMeta' => "Utilisez notre formulaire pour donner une pénalité à une équipe pour une étape spécifique de la compétition. Suivez les infractions commises par les équipes participantes et enregistrez les pénalités correspondantes. Notre formulaire convivial vous permet de saisir facilement les informations nécessaires, telles que l'équipe concernée, l'étape, la description de l'infraction et la sanction appliquée. Restez à jour avec les performances disciplinaires des équipes et suivez l'évolution de la compétition.",
            'keywordMeta'=>"formulaire de pénalité équipe, donner une pénalité, infractions sportives, équipes participantes, compétition sportive, suivi des pénalités, performances disciplinaires, formulaire convivial, enregistrement pénalités, suivi compétition",
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
            'title' => 'Liste des penalités',
            'descriptionMeta' => "Consultez la liste des pénalités par étape pour chaque équipe dans cette compétition. Notre page affiche les pénalités infligées à chaque équipe, étape par étape, mettant en évidence les infractions commises et les conséquences associées. Découvrez les règles spécifiques de la compétition et les sanctions appliquées en cas de non-respect par les équipes participantes. Suivez l'évolution des pénalités tout au long de la compétition et restez informé des performances disciplinaires des équipes par étape.",
            'keywordMeta'=>"iste des pénalités par étape, pénalités par équipe, infractions sportives, conséquences pénalités, règles de compétition, sanctions disciplinaires, suivi des pénalités, performances disciplinaires, équipes participantes, compétition sportive",
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
            'descriptionMeta' => "Découvrez le certificat du gagnant et célébrez sa victoire ! Notre page affiche fièrement le certificat officiel du gagnant, attestant de sa réussite et de sa performance exceptionnelle. Observez en détail le design élégant du certificat et les informations clés qui le rendent unique. Partagez la joie de la victoire avec le gagnant en téléchargeant et en partageant ce certificat personnalisé.",
            'keywordMeta'=>"certificat du gagnant, certificat officiel, victoire, récompense, réussite, performance exceptionnelle, design élégant, informations clés, téléchargement certificat, partage certificat",
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
            'title' => 'Résultats pour une Étape de Course - Liste par Coureur avec Chrono, Pénalité et Temps Final            ',
            'page' => "admin.etape.Resultat",
            'descriptionMeta' => "Consultez les résultats complets de cette étape passionnante, indépendamment de la catégorie des participants ! Notre page affiche les classements détaillés de l'étape, mettant en évidence les performances des coureurs sans distinction de catégorie. Découvrez les temps, les positions et les statistiques clés de chaque coureur. Suivez l'évolution de la compétition et plongez-vous dans les détails captivants de cette étape, où tous les coureurs sont évalués sur un pied d'égalité.",
            'keywordMeta'=>"résultat étape, classement étape, temps coureurs, performance coureurs, compétition sportive, résultats complets, temps étape, classement indépendant catégorie, suivi compétition, détails étape, statistiques étape",
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
            'title' => 'Point par etape',
            'page' => "admin.etape.pointEtape",
            'descriptionMeta' => "Points obtenus par étape pour l'équipe",
            'keywordMeta'=>"points, étapes, équipe, compétition",
            'resultat' => $result
        ]);
     }

     public static function getClassementGlobal()
    {
        $classementEquipeSimple = Equipe::getClassementEquipeSimple();
        return response()->json(['classementEquipeSimple' => $classementEquipeSimple]);
    }

    public static function getClassementParCategorie()
    {
        $resultat = Categorie::getClassementCategorie();
        return response()->json(['resultat' => $resultat]);
    }

    public function getCertificatData()
    {
        $result = DB::table('v_classement_equipe_simple')
                    ->select('*')
                    ->orderBy('total_points', 'DESC')
                    ->first();

        return response()->json(['result' => $result]);
    }

}
