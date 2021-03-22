<?php

namespace App\Http\Controllers;

use App\Models\Titulo;
use Illuminate\Http\Request;
use Exception;

class TituloController extends Controller
{
    public function get(Request $request){
        return Titulo::with('users')->get();
    }

    public function store( array $titulos, $idUser)
    {

        $skillsId=[];
        for($i=0; $i<count($titulos); $i++){
            $titulo=new Titulo();
            $titulo->titulo=$titulos[$i];
            $resultado= Titulo::where(function ($query) use($titulos, $i){
                $query->where('titulo','like',$titulos[$i]);
            })->get();

            if($resultado->isEmpty()){

                try{
                    $titulo->save();
                }catch(Exception $e){
                    return "Erro na insercao do titulo";
                }
                $tituloId[$i]=$titulo->getAttributes()['id'];
            }else{
                for($j=0;$j<count($resultado);$j++) {
                    $tituloId[$i] = $resultado[$j]->id;
                }
            }

        }
        $userTitulo=new UserTituloController();
        $userTitulo->store($idUser, $tituloId);

    }


}
