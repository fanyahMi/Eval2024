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
            'title' => 'Classements par étape par équipe',
            'page' => "classement.Etape",
            'descriptionMeta' => "Consultez les classements par étape par équipe avec leurs points dans cette section dédiée à la compétition.",
            'keywordMeta'=>"classements par étape, équipes, points, compétition",
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
            'descriptionMeta' => "Consultez les classements par étape par équipe avec leurs points dans cette section dédiée à la compétition.",
            'keywordMeta'=>"classements par étape, équipes, points, compétition",
            'classementEquipe' => $classementEquipe,
            'classementEquipeSimple' => $classemeEquipeSimple,
            'resultat'  =>$classementCategorie
        ]);
    }
}
