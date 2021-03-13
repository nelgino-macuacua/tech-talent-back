<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\SkillController;

class UserController extends Controller
{
    public function index()
    {
       // return User::all();

        return User::with('skills')->get();
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $skills = $request->input('skills');
        $user= json_encode($request->input('user'));
        //dd($user);
        //return  User::create($user->all());
        //return $skills;
        //$usuario=$request->all();

        //*UserController::create($skills);
        //return $skills;
        $user=new User();
        //$request=User::$request->all();
        $user->nome=$request->input('nome');
        $user->titulo=$request->input('titulo');
        $user->email=$request->input('email');
        $user->password=$request->input('password');
        $user->taxa=$request->input('taxa');
        $user->disponibilidade=$request->input('disponibilidade');
        $user->github=$request->input('github');
        $user->portifolio=$request->input('portifolio');
        $user->linkedin=$request->input('linkedin');
        $user->save();
        //dd($user->getAttributes()['id']);

        $controlarSkill=new SkillController();
        $controlarSkill->store($skills,$user->getAttributes()['id']);











    }

    public function filter(Request $request){

        $search = $request->input('search');
        $disponibilidade = $request->input('disponibilidade');
        $taxa = $request->input('taxa');

        $users = User::with('skills')->whereHas('skills', function($q) use ($search,
            $disponibilidade, $taxa) {
            $q->where('skill', 'like', '%'.$search.'%')
                ->where('disponibilidade','like', $disponibilidade)
                ->where('taxa','=', $taxa);
        })->get();
        if($users->isEmpty()) {
            $users = User::with('skills')->whereHas('skills',
                function ($q) use ($search, $disponibilidade, $taxa) {
                $q->where('titulo', 'like', '%' . $search . '%')
                    ->where('disponibilidade', 'like', $disponibilidade)
                    ->where('taxa', '=', $taxa);
            })->get();
        }
        //User::with('skills')->get();

        return $users;

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
}
