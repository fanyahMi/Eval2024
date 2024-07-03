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


/*****MidlWare ****/
use App\Http\Middleware\CheckEquipeRole;
use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckUserSession;


/*************Admin *************/
Route::get('/Login-Administrateur', [AdminController::class, 'signIn'])->name('Login-Administrateur');
Route::post('/login', [AdminController::class, 'login'])->name('login');
Route::middleware([CheckAdminRole::class])->group(function () {
    Route::get('/acceuil', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/logoutAdmin', [AdminController::class, 'logout']);
    Route::get('/liste-des-etapes', [AdminController::class, 'listeEtape'])->name('listeEtape');
    Route::get('/formulaire-pour-ajout-de-temps/{id}', [AdminController::class, 'formulaireTemps'])->name('formulaireTemps');
    Route::post('/addTemps', [AdminController::class, 'addTemps'])->name('addTemps');
    Route::get('/importation-etapes-et-resultat', [AdminController::class, 'importetapesresultat']);
    Route::get('/importation-des-points', [AdminController::class, 'importpoint']);
    Route::post('/importationpoint', [AdminController::class, 'importationpoint']);
    Route::post('/importationetapesresultat', [AdminController::class, 'importationetapesresultat']);
    Route::get('/genererCategorie', [AdminController::class, 'genererCategorie'])->name('genererCategorie');
    Route::get('/clearBase', [AdminController::class, 'clearBase'])->name('clearBase');
    Route::get('/liste-des-penalites', [AdminController::class, 'listPenalite']);
    Route::get('/ajout-de-penalite', [AdminController::class, 'penalite']);
    Route::post('/addPenalite', [AdminController::class, 'addPenalite']);
    Route::get('/supprimerPenalite', [AdminController::class, 'supprimerPenalite']);
    Route::get('/certificat', [AdminController::class, 'certificat']);
    Route::get('/exportation', [AdminController::class, 'exportation']);
    Route::get('/export', [AdminController::class, 'export']);
    Route::get('/resultat-pour-une-etape/{id}', [AdminController::class, 'resultatEtape']);
    Route::get('/pointEtape/{id}', [AdminController::class, 'poinEtape']);
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

});
/*************************************************** */
Route::get('/pdf', [Controllers::class, 'pdf'])->name('pdf');

Route::middleware([CheckEquipeRole::class])->group(function () {
    Route::get('/export/csv', [UsersController::class, 'exportToCSV'])->name('export.csv');
    Route::get('/export/excel', [UsersController::class, 'exportToExcel'])->name('export.excel');

});

Route::middleware([CheckEquipeRole::class])->group(function () {
    Route::get('/formgeneralize', [Controllers::class, 'formgeneralize'])->name('formgeneralize');
    Route::get('/formUpdate/{id}', [Controllers::class, 'getDetail'])->name('formUpdate/{id}');
    Route::post('/addform', [Controllers::class, 'addform'])->name('addform');
    Route::post('/updateM', [Controllers::class, 'updateM'])->name('updateM');
    Route::post('/importerFinal', [Controllers::class, 'importFinal'])->name('importerFinal');
    Route::get('/recherche', [RechercheController::class, 'recherche'])->name('recherche');
    Route::get('/fulltext', [RechercheController::class, 'fulltext'])->name('fulltext');
    Route::get('/multimot', [RechercheController::class, 'multimot'])->name('multimot');
    Route::get('/multicritere', [RechercheController::class, 'multicritere'])->name('multicritere');
    Route::get('/tableau', [RechercheController::class, 'tableau'])->name('tableau');
    Route::get('/rechercheTableau', [RechercheController::class, 'rechercheTableau'])->name('rechercheTableau');
    Route::get('/tableauNormal', [RechercheController::class, 'tableauNormal'])->name('tableauNormal');
});

//Mail
Route::get('/sendMail', [MailController::class, 'sendMail'])->name('sendMail');


//Chart
Route::get('/chart-donutData', [ChartController::class, 'donutData']);
Route::get('/chart-secteureData', [ChartController::class, 'secteureData']);
Route::get('/chart-barChartData', [ChartController::class, 'barChartData']);
Route::get('/chart-lineSimpleChartData', [ChartController::class, 'lineSimpleChartData']);
Route::get('/chart-linePlusData', [ChartController::class, 'linePlusData']);

