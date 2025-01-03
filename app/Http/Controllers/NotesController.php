<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notes;

class NotesController extends Controller
{
    //

    public function insertNotes(Request $request)
    {
        // dd($request);
       if(!$request->notes){
        return view('notes.insertnotes');
       }
    //    dd($request->notes);
        $notes = new Notes();

        $notes->insert([
            'notes_title' =>$request->notes_title,
            'notes' =>$request->notes,
            'id_user' => $request->session()->get('curruser')->id
        ]);



        return redirect()->route('home');
    }

    public function editnotes(Request $request,$id){
// dd($request);

$notes = Notes::find($id);

      if(empty($request->all())){
        
   
        return view('notes.editnotes', compact('notes'));
      }

      
      $notes->update([
      
        'notes' =>$request->notes,
     
    ]);
      return redirect()->route('home');

    }
}
