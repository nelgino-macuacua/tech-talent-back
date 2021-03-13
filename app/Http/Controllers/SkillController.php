<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Skill;
use App\Http\Controllers\UserSkillController;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function get(Request $request){
       return Skill::with('users')->get();
    }

    public function create(array $values)
    {
        $skills = [];



        for ($i = 0; $i < count($values); $i++) {
            array_push($skills, ["skill" => $values[$i]]);
        }

        //nao está funcionando
    	Skill::insert($skills);
    }


    public function store(array $skills, $idUser)
    {

        $skillsId=[];
        for($i=0; $i<count($skills); $i++){
            $skill=new Skill();
            $skill->skill=$skills[$i];
            $resultado= Skill::where(function ($query) use($skills, $i){
                $query->where('skill','like',$skills[$i]);
            })->get();

            if($resultado->isEmpty()){
                $skill->save();
                $skillsId[$i]=$skill->getAttributes()['id'];
            }else{
                for($j=0;$j<count($resultado);$j++) {
                    $skillsId[$i] = $resultado[$j]->id;
                }
            }

        }
        $userSkill=new UserSkillController();
        $userSkill->store($skillsId, $idUser);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
