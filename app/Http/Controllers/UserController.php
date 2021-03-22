<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\SkillController;
use Exception;

class UserController extends Controller
{
    public function index()
    {
        $users=User::with('skills','titulos')->get();
        for($j=0;$j<count($users);$j++){
            $users[$j]->password=null;
        }

        return $users;
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $skills = $request->input('skills');
        $titulos=$request->input('titulos');

        //$user= json_encode($request->input('user'));
        $user=new User();
        try{
            $user->nome=$request->input('nome');
            $user->email=$request->input('email');
            $user->password=$request->input('password');
            $user->taxa=$request->input('taxa');
            $user->disponibilidade=$request->input('disponibilidade');
            $user->github=$request->input('github');
            $user->portifolio=$request->input('portifolio');
            $user->linkedin=$request->input('linkedin');

            if($request->input('imagem')){
                $img=$request->input('imagem');
                $novonome=time().uniqid().'.png';
                try{
                    move_uploaded_file($img,"../../../resources/imagens/".$novonome);
                }catch(Exception $e){
                    return "ERRO: Imagem";
                }
                $user->imagem=$novonome;
            }else{
                $user->imagem='';
            }

            $user->save();
        }catch(Exception $e){
            return "ERRO: DADOS EXISTENTES - verifique o email/github/portifolio/linkedin";
        }
        $controlarSkill=new SkillController();
        $controlarSkill->store($skills,$titulos, $user->getAttributes()['id']);

    }

    public function filter(Request $request){

        $search = $request->input('search');
        $disponibilidade = $request->input('disponibilidade');
        $taxaMax = $request->input('taxaMax');
        $taxaMin = $request->input('taxaMin');

        $users2=[];
        $cont=0;
        for ($i=0;$i<count($search);$i++) {
                //buscar usuarios a partir do skill
                if($taxaMax==null && $taxaMin==null){
                    $users[$i] = User::with('skills')->with('titulos')->whereHas(
                        'skills',
                        function ($q) use ($search, $disponibilidade, $i) {
                        $q->where('skill', 'like', '%'.$search[$i].'%')
                            ->where('disponibilidade', 'like', "%".$disponibilidade."%");
                    })->get();
                }elseif($taxaMax==null){
                    $users[$i] = User::with('skills')->with('titulos')->whereHas(
                        'skills',
                        function ($q) use ($search, $disponibilidade, $taxaMin, $i) {
                        $q->where('skill', 'like', '%'.$search[$i].'%')
                            ->where('disponibilidade', 'like', "%".$disponibilidade."%")
                            ->where('taxa', '>=', $taxaMin);
                    })->get();
                }elseif($taxaMin==null){

                    $users[$i] = User::with('skills')->with('titulos')->whereHas(
                        'skills',
                        function ($q) use ($search, $disponibilidade, $taxaMax, $i) {
                        $q->where('skill', 'like', '%'.$search[$i].'%')
                            ->where('disponibilidade', 'like', "%".$disponibilidade."%")
                            ->where('taxa', '<=', $taxaMax);
                    })->get();
                }else{
                    $users[$i] = User::with('skills')->with('titulos')->whereHas(
                        'skills',
                        function ($q) use ($search, $disponibilidade, $taxaMax, $taxaMin, $i) {
                        $q->where('skill', 'like', '%'.$search[$i].'%')
                            ->where('disponibilidade', 'like', "%".$disponibilidade."%")
                            ->where('taxa', '>=', $taxaMin)
                            ->where('taxa', '<=', $taxaMax);
                    })->get();
                }

                //organizando os elementos do array bidimensional em um array unidimensional
                for($j=0;$j<count($users[$i]);$j++){
                    $users[$i][$j]->password=null;
                    $users2[$cont]=$users[$i][$j];
                    $cont++;
                }

            if ($users[$i]->isEmpty()) {
                //buscando usuarios a partir do titulo
                if ($taxaMax==null && $taxaMin==null) {
                    $users[$i] = User::with('titulos')->with('skills')->whereHas(
                        'titulos',
                        function ($q) use ($search, $disponibilidade, $i) {
                            $q->where('titulo', 'like', '%' . $search[$i] . '%')
                            ->where('disponibilidade', 'like', "%".$disponibilidade."%");
                        }
                    )->get();
                }elseif($taxaMax==null){
                    $users[$i] = User::with('titulos')->with('skills')->whereHas(
                        'titulos',
                        function ($q) use ($search, $disponibilidade, $taxaMin, $i) {
                            $q->where('titulo', 'like', '%' . $search[$i] . '%')
                            ->where('disponibilidade', 'like', "%".$disponibilidade."%")
                            ->where('taxa', '>=', $taxaMin);
                        }
                    )->get();
                }elseif($taxaMin==null){
                    $users[$i] = User::with('titulos')->with('skills')->whereHas(
                        'titulos',
                        function ($q) use ($search, $disponibilidade, $taxaMax, $i) {
                            $q->where('titulo', 'like', '%' . $search[$i] . '%')
                            ->where('disponibilidade', 'like', "%".$disponibilidade."%")
                            ->where('taxa', '<=', $taxaMax);
                        }
                    )->get();
                }else{
                    $users[$i] = User::with('titulos')->with('skills')->whereHas(
                        'titulos',
                        function ($q) use ($search, $disponibilidade, $taxaMax, $taxaMin, $i) {
                            $q->where('titulo', 'like', '%' . $search[$i] . '%')
                            ->where('disponibilidade', 'like', "%".$disponibilidade."%")
                            ->where('taxa', '>=', $taxaMin)
                            ->where('taxa', '<=', $taxaMax);
                        }
                    )->get();
                }


                //organizando os elementos do array bidimensional em um array unidimensional
                for($j=0;$j<count($users[$i]);$j++){
                    $users[$i][$j]->password=null;
                    $users2[$cont]=$users[$i][$j];
                    $cont++;
                }
            }
        }

        //imprimir valores nao repetidos
        //
        return array_values(array_unique($users2, SORT_REGULAR));
    }


    public function show($id)
    {

    }
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function validar_dados($request){
        if (User::where('email', '=', $request->input('email'))->exists()) {
            return "Este email ja possui uma conta";
        }
    }
}
