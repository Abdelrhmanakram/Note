<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiNoteController extends Controller
{
    public function allNotes(){
        $notes=note::all();
        if($notes == null){
            return response()->json(
                [
                    'msg'=>'Notes not found'
            ],403);
        }
        return NoteResource::collection($notes);
    }

    public function __construct()
{
    $this->middleware('auth:sanctum')->only('showOne','update');
}
    public function showOne($id){
        $note=note::find($id);
        if($note == null){
            return response()->json(
                [
                    'msg'=>'Note not found'
            ],403);
        }
        return new NoteResource($note);
    }

    public function store(Request $request){
      $validator = Validator::make($request->all(),[
        "title"=>"required|string",
        "content"=>"required|string",
        "user_id"=>"required|integer"
      ]);

      if ($validator->fails()) {
        return response()->json([
            "errors"=>$validator->errors()
        ],301);
      }

      note::create([
        "title"=>$request->title,
        "content"=>$request->content,
        "user_id"=>$request->user_id
      ]);
      return response()->json(
        [
            'msg'=>'Notes added successfuly'
    ],201);
    }


    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            "title"=>"required|string",
            "content"=>"required|string",
            "user_id"=>"required|integer"
          ]);

          if ($validator->fails()) {
            return response()->json([
                "errors"=>$validator->errors()
            ],301);
          }

          $note=note::find($id);
          if($note == null){
              return response()->json(
                  [
                      'msg'=>'Note not found'
              ],403);
          }

         $note->update([
            "title"=>$request->title,
            "content"=>$request->content,
            "user_id"=>$request->user_id
          ]);
          return response()->json(
            [
                'msg'=>'Notes updated successfuly',
                "product"=>new NoteResource($note)
        ],201);
    }

    public function delete($id){

        $note=note::find($id);
        if($note == null){
            return response()->json(
                [
                    'msg'=>'Note not found'
            ],403);
        }

        $note->delete();

        return response()->json(
            [
                'msg'=>'Notes deleted successfuly',

        ],200);
    }

}
