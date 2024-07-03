<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipe;
use App\Models\Categorie;

class EquipeAdminController extends Controller
{
    public function classementEtape(){
        $classementEtape = Equipe::getClassementEtape();
        return view("template.Layout", [
            'title' => 'Classement general par étape',
            'page' => "classement.Etape",
            'classementEtape' => $classementEtape
        ]);
    }
    public function classementEquipe(){
        $classementEquipe = Equipe::getClassementEquipe();
        $classementCategorie = Categorie::getClassementCategorie();
        $classemeEquipeSimple =  Equipe::getClassementEquipeSimple();

        return view("template.Layout", [
            'title' => 'Classement par équipe',
            'page' => "classement.Equipe",
            'classementEquipe' => $classementEquipe,
            'classementEquipeSimple' => $classemeEquipeSimple,
            'resultat'  =>$classementCategorie
        ]);
    }
}
