<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\models\Controllers;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\EquipeAdminController;
use App\Http\Controllers\PointController;
use Illuminate\Support\Facades\Response;


/*****MidlWare ****/
use App\Http\Middleware\CheckEquipeRole;
use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckUserSession;


/*************Admin *************/
Route::get('/Login-Administrateur', [AdminController::class, 'signIn'])->name('Login-Administrateur');
Route::post('/login', [AdminController::class, 'login'])->name('login');
Route::middleware([CheckAdminRole::class])->group(function () {
    Route::get('/classement-course-equipe', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout-Admin', [AdminController::class, 'logout']);
    Route::get('/liste-des-etapes', [AdminController::class, 'listeEtape'])->name('listeEtape');
    Route::get('/formulaire-pour-ajout-de-temps/{id}', [AdminController::class, 'formulaireTemps'])->name('formulaireTemps');
    Route::post('/add-temps', [AdminController::class, 'addTemps'])->name('addTemps');
    Route::get('/importation-etapes-et-resultat', [AdminController::class, 'importetapesresultat']);
    Route::get('/importation-des-points', [AdminController::class, 'importpoint']);
    Route::post('/importation-point', [AdminController::class, 'importationpoint']);
    Route::post('/importation-etapes-resultat', [AdminController::class, 'importationetapesresultat']);
    Route::get('/generer-categorie', [AdminController::class, 'genererCategorie'])->name('genererCategorie');
    Route::get('/clear-Base', [AdminController::class, 'clearBase'])->name('clearBase');
    Route::get('/liste-des-penalites', [AdminController::class, 'listPenalite']);
    Route::get('/ajout-de-penalite', [AdminController::class, 'penalite']);
    Route::post('/add-penalite', [AdminController::class, 'addPenalite']);
    Route::get('/supprimer-penalite', [AdminController::class, 'supprimerPenalite']);
    Route::get('/certificat', [AdminController::class, 'certificat']);
    Route::get('/exportation', [AdminController::class, 'exportation']);
    Route::get('/export', [AdminController::class, 'export']);
    Route::get('/resultat-pour-une-etape/{id}', [AdminController::class, 'resultatEtape']);
    Route::get('/point-par-etape-pour-equipe/{id}', [AdminController::class, 'poinEtape']);
    Route::get('/classement/global', [AdminController::class, 'getClassementGlobal']);
    Route::get('/classement/categorie', [AdminController::class, 'getClassementParCategorie']);
    Route::get('/certificat-data', [AdminController::class, 'getCertificatData']);

});
/*****************/


/*************Equipe*************/
Route::get('/Login-Equipe', [EquipeController::class, 'signIn']);
Route::post('/siginEquipe', [EquipeController::class, 'login'])->name('login');
Route::middleware([CheckEquipeRole::class])->group(function () {
    Route::get('/logout-Equipe', [EquipeController::class, 'logout'])->name('logoutEquipe');
    Route::redirect('/', '/Liste-des-coureurs-par-tout-les-etapes');
    Route::get('/Liste-des-coureurs-par-tout-les-etapes', [EquipeController::class, 'index'])->name('accueil');
    Route::get('/liste-etapes-course', [EquipeController::class, 'listeEtapeEquipe'])->name('listeEtapeEquipe');
    Route::get('/Liste-des-coureurs/{id}', [EquipeController::class, 'listeCoureur'])->name('listeCoureur');
    Route::post('/affectation-du-coureur', [EquipeController::class, 'addAffectationEtape'])->name('addAffectationEtape');
    Route::get('/ajout-de-coureur/{id}', [EquipeController::class, 'ajoutcoureur'])->name('addAffectationEtape');
});
/*****************/


/************Equipe et Admin *******/
Route::middleware([CheckUserSession::class])->group(function () {
    Route::get('/classements-par-etape-par-equipe', [EquipeAdminController::class, 'classementEtape'])->name('classementEtape');
    Route::get('/classement-par-equipe-par-categorie', [EquipeAdminController::class, 'classementEquipe'])->name('classementEquipe');
    Route::get('/liste-etapes', [EquipeAdminController::class, 'getListeEtape'])->name('getListeEtape');

});
/*************************************************** */





