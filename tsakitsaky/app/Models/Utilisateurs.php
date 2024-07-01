<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Utilisateurs extends Model
{
    protected $table = "utilisateur";
    protected $fillable = [
        'nom',
        'email',
        'pwd'
    ];

    public $timestamps = false;
    protected $primaryKey = "id_utilisateur";
    public $incrementing = false;

    public static function checkLoginAdmin($email, $pwd){
        try {
            $result = DB::table('utilisateur')
                        ->where('email', $email)
                        ->where('pwd', $pwd)
                        ->first();

            if ($result) {
                $roles = Utilisateurs::cheackRole($result->id_utilisateur);
                $cheak  = false;
                foreach ($roles as $key => $value) {
                    if($value->role_id == 1){
                        $cheak = true;
                        break;
                    }
                }
                if($cheak == false){
                    throw new \Exception('Vous n avez pas accés');
                }
                $data['user'] = $result;
                $data['roles'] = $roles;
                return $data;
            } else {
                throw new \Exception('Adresse email ou mot de passe incorrect.');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function checkLoginEquipe($email, $pwd){
        try {
            $result = DB::table('utilisateur')
                        ->where('email', $email)
                        ->where('pwd', $pwd)
                        ->first();

            if ($result) {
                $roles = Utilisateurs::cheackRole($result->id_utilisateur);
                $cheak  = false;
                foreach ($roles as $key => $value) {
                    if($value->role_id == 2){
                        $cheak = true;
                        break;
                    }
                }
                if($cheak == false){
                    throw new \Exception('Vous n avez pas accés');
                }
                $data['user'] = $result;
                $data['roles'] = $roles;
                return $data;
            } else {
                throw new \Exception('Adresse email ou mot de passe incorrect.');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private static function cheackRole($utilisateurId){
        $result = DB::table('role_utilisateur')
                        ->where('utilisateur_id', $utilisateurId)
                        ->get();
        return $result;
    }

    public static function roleAdmin($listeRoles){
        foreach ($listeRoles as $key => $value) {
            if($value->role_id == 1){
                return true;
            }
        }
        return false;
    }

    public static function roleEquipe($listeRoles){
        foreach ($listeRoles as $key => $value) {
            if($value->role_id == 2){
                return true;
            }
        }
        return false;
    }

    public static function clearBase(){
        DB::beginTransaction();
       try {
            DB::statement("delete from penalite");
           DB::statement("delete from point_classement");
           DB::statement("delete from temps_coureur_etape");
           DB::statement("delete from coureur_etape");
           DB::statement("delete from categorie_coureur");
           DB::statement("delete from coureur");
           DB::statement("delete from etapes");
           DB::statement("delete from role_utilisateur where id_role_utilsiateur != 1");
           DB::statement("delete from utilisateur where id_utilisateur != 1");


           DB::commit();
       } catch (\Throwable $th) {
        dd($th);
           //throw $th;
       }
   }
}
