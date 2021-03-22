<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTitulo;

class UserTituloController extends Controller
{
    public function store($userId, array $tituloId)
    {
        for($i=0;$i<count($tituloId);$i++){
            $userTitulo=new UserTitulo();
            $userTitulo->user_id=$userId;
            $userTitulo->titulo_id=$tituloId[$i];
            $userTitulo->save();
        }
        return "Inserido com sucesso";
    }
}
