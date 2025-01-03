<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class IssueController extends Controller
{
    //

    public function editissueview($issue_id)
    {
        // Find the issue by ID
        $statuses = ['completed', 'on_progress', 'need_testing','not_started'];
        $issue = Issue::find($issue_id);
        $users = User::all();
        $imagepaths = DB::table('tb_image')
            ->select('image','id')
            ->where('id_issue', $issue_id)
            ->get();
        // Return the view and pass the issue data
        // dd($imagepaths);
        return view('issues.editissues', compact('issue', 'users', 'imagepaths','statuses'));
    }

    public function editissue(request $request)
    {
        // dd($request);
        $imageBlob = []; // Default to null if no image is uploaded

        $issue = Issue::findOrFail($request->id_issue);
        // dd($issue);
        $issue->update([
            'issue_title' => $request->issue_title,
            'issue_type' => strtolower($request->issue_type),
            'issue_desc' => $request->issue_desc,
            'pic' => $request->pic,
            'note' => $request->note,
            'priority' => strtolower($request->priority),
            'pic' => $request->pic,
            'due_date' => $request->due_date,
            'status' => $request->status
         
        ]);

        $imagepaths = DB::table('tb_image')
            ->select('image')
            ->where('id_issue', $request->id_issue)->first();


        // dd($imagepaths);
        // dd($request->hasFile('images'));
        if ($request->image_ids){
            Image::where('id_issue', $request->id_issue)
           ->whereNotIn('id', $request->image_ids)
           ->delete();

       }
       else{
        Image::where('id_issue', $request->id_issue)
           ->delete();
       }
        if ($request->hasFile('images')) {
            // dd("here");
            // Get the image content as binary data

            foreach ($request->file('images') as $image) {
                // dd("here");
                // Get the image content as a blob
                $imageBlob = file_get_contents($image->getRealPath());
                

                    $image = new Image();

                    $image->id_issue = $issue->id_issue;

                    $image->image = $imageBlob;

                    $image->save();
                    $imagepaths = $image;
                }
            }
// dd($request);
      
        



        $curruser = Session::get('curruser');

        return redirect()->route('home', [
            'success' => 'Project successfully added',
            'curruser' => Session::get('curruser'),
        ]);
    }

    public function showInsertIssueForm($project_id)
    {
        $statuses = ['completed', 'on_progress', 'need_testing','not_started'];
        $users = User::all();
        $project = Project::find($project_id);

        if (!$project) {
            return redirect()->route('home')->with('error', 'Project not found');
        }
        return view('issues.insertissue', compact('project', 'users','statuses'));
    }

    public function insertIssueForm(Request $request)
    {
        // dd($request);
        $imageBlob = null; // Default to null if no image is uploaded
        if ($request->hasFile('image')) {
            // Get the image content as binary data
            $imageBlob = file_get_contents($request->file('image')->getRealPath());
            // dd($imageBlob);
        }
        // dd($request);
        $issue = new Issue();
        $issue->id_project = $request->id_project;
        $issue->issue_title = $request->issue_title;
        $issue->issue_type = strtolower($request->issue_type);
        $issue->issue_desc = $request->issue_desc;
        $issue->pic = $request->pic;
        $issue->note = $request->note;
        $issue->status = $request->status;
        $issue->priority = strtolower($request->priority);

        $issue->save();

        $issueId = $issue->id_issue;
        // dd($issueId);

        if ($request->hasFile('images')) {
            // dd("here");
            // Get the image content as binary data

            foreach ($request->file('images') as $image) {
                // dd("here");
                // Get the image content as a blob
                $imageBlob = file_get_contents($image->getRealPath());
                

                    $image = new Image();

                    $image->id_issue = $issue->id_issue;

                    $image->image = $imageBlob;

                    $image->save();
                    $imagepaths = $image;
                }
            }

        return redirect()->route('home', [
            'success' => 'Project successfully added',
            'curruser' => Session::get('curruser'),
        ]);
    }

    public function  showissue($issue_id)
    {
        $issue = Issue::findOrFail($issue_id);

        $imagepaths = DB::table('tb_image')
            ->select('image')
            ->where('id_issue', $issue_id)
            ->get();

        return view('issues.showissue', compact('issue', 'imagepaths'));
    }
}
