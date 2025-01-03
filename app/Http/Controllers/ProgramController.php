<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Notes;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProgramController extends Controller
{

    private function getallprojects()
    {

        $projects = DB::table('tb_project')
            ->leftJoin('tb_issue', 'tb_project.id_project', '=', 'tb_issue.id_project')
            ->select(
                'id_issue',
                'tb_project.id_project',
                'issue_title',
                'issue_type',
                'issue_desc',
                'tb_issue.pic',
                'note',
                'priority',
                'project_title',
                'tb_project.PIC AS pic_project',
                'tb_project.owner',
                'tb_project.created_at',
                'tb_project.due_date AS project_due_date',
                'tb_issue.due_date AS issue_due_date',
                'tb_issue.status AS issue_status'
            )
            ->get();

        // dd($projects);
        return $projects;
    }

    private function getcurrentprojects($curruser)
    {
        $projects = DB::table('tb_project')
            ->leftJoin('tb_issue', 'tb_project.id_project', '=', 'tb_issue.id_project')
            ->select(
                'id_issue',
                'tb_project.id_project',
                'issue_title',
                'issue_type',
                'issue_desc',
                'tb_issue.pic',
                'note',
                'priority',
                'project_title',
                'tb_project.owner',
                'tb_project.created_at',
                'tb_project.PIC AS pic_project',
                'tb_project.due_date AS project_due_date',
                'tb_issue.due_date AS issue_due_date',
                'tb_issue.status AS issue_status'
            )
            ->where('tb_project.PIC', $curruser->name)
            ->get();

        return $projects;
    }

    private function getotherprojects($curruser,$projects)
    {
        $projectIds = $projects->pluck('id_project')->toArray();
        $otherprojects = DB::table('tb_project')
            ->leftJoin('tb_issue', 'tb_project.id_project', '=', 'tb_issue.id_project')
            ->select(
                'id_issue',
                'tb_project.id_project',
                'issue_title',
                'issue_type',
                'issue_desc',
                'tb_issue.pic',
                'note',
                'priority',
                'project_title',
                'tb_project.PIC AS pic_project',
                'tb_project.owner',
                'tb_project.created_at',
                'tb_project.due_date AS project_due_date',
                'tb_issue.due_date AS issue_due_date',
                'tb_issue.status AS issue_status'
            )
            ->where(function($query) use ($curruser) {
                // Kelompokkan kondisi orWhere di sini
                $query->where('issue_type', 'bug')
                      ->orWhere('tb_issue.pic', $curruser->name);
            })
            ->whereNot('tb_project.pic', $curruser->name)
            ->whereNotIn('tb_project.id_project', $projectIds)
            ->get();

//             dump($projects);
//            dump($curruser->name);
// dump($otherprojects);
// dump($otherprojects[0]->pic_project);

        return $otherprojects;
    }


    public function showPrograms(Request $request)
    {
        //   dump($request);
        // Check if user is logged in
        if (!$request->session()->get('curruser')) {
            return redirect()->route('login');
        }

        // Retrieve users for the view
        $users = DB::table('users')->get();

        // Initialize variables
        $projects = collect();  // Use collect to ensure it's a collection
        $otherprojects = collect();  // Use collect to ensure it's a collection
        $curruser = null;
        $curruser1 = null;

        // dd($notes);

        // Get the current user from the session or request
        if ($request->session()->get('curruser')) {
            $curruser = $request->session()->get('curruser');
        } elseif ($request->curruser) {
            $curruser = User::find($request->curruser);
            Session::put('variableName', $curruser);
        }

        // If user_id is provided, assign a new user from the request
        if ($request->user_id) {
            $curruser1 = User::find($request->user_id);
            Session::put('variableName', $curruser1);
        }

        // Default to the first user if no user found
        if (!$curruser) {
            $curruser = User::first();
        }

        // Save current user to session
        $request->session()->put('curruser', $curruser);


        $notes = Notes::where('id_user', $curruser->id)->get();
        // dump($curruser->id);
        // dd($notes);

        // Fetch projects based on user type curruser1 = filter
        if ($curruser1) {
            
            // For Super User (su)
            if ($curruser1->user_type == 'su') {
                $projects = $this->getallprojects($curruser1);
            }
            // For Common User (common)
            elseif ($curruser1->user_type == 'common') {
                // dd($curruser1);
                $projects = $this->getcurrentprojects($curruser1);
// dd($projects);
                $otherprojects = $this->getotherprojects($curruser1,$projects);
                // dd($otherprojects);
            }
        } else {
            // If no curruser1, use curruser (default behavior)
            if ($curruser->user_type == 'su') {

                $projects = $this->getallprojects();
            } elseif ($curruser->user_type == 'common') {


                $projects = $this->getcurrentprojects($curruser);

                $otherprojects = $this->getotherprojects($curruser,$projects);
            }
        }

        // Filter projects based on search query, if present

        $search = $request->search;

        $filter = $request->filter;

        if ($filter) {
            if ($filter == 'projects') {
                $otherprojects = null;
                $notes = null;
            } else if ($filter == 'otherprojects') {
                $projects = null;
                $notes = null;
            } else if ($filter == 'notes') {
                $projects = null;
                $otherprojects = null;
            }
        }


        if ($search) {
            if ($projects) {
                // dump($projects);
                $projects = $projects->filter(function ($project) use ($search) {
                    // Convert search string to lowercase
                    $search = strtolower($search);

                    // Get all properties of the project as an array
                    $projectFields = get_object_vars($project);

                    // Check if any field contains the search string
                    foreach ($projectFields as $field) {
                        // dump($field);
                        if (is_string($field) && str_contains(strtolower($field), $search)) {
                         
                            return true; // Return the entire project object if it matches
                        }
                    }

                    // If no field matches, return false to exclude it
                    return false;
                });
               
        }
           

            if ($otherprojects) {
                // dump($otherprojects);
                $otherprojects = $otherprojects->filter(function ($otherprojects) use ($search) {
                    // Convert search string to lowercase
                    $search = strtolower($search);

                    // Get all properties of the project as an array
                    $projectFields = get_object_vars($otherprojects);

                    // Check if any field contains the search string
                    foreach ($projectFields as $field) {
                        if (is_string($field) && str_contains(strtolower($field), $search)) {
                            return true; // Return the entire project object if it matches
                        }
                    }

                    // If no field matches, return false to exclude it
                    return false;
                });
            }

            if ($notes) {
                // dump($notes);
                //salah di getobjectvars
                
                // dump("notes");
                $notes = $notes->filter(function ($note) use ($search) {
                    // Convert search string to lowercase
                    $search = strtolower($search);

                    // Get all properties of the note as an array
                    $noteFields = $note->getAttributes();

                    // Check if any field contains the search string
                    foreach ($noteFields as $field) {
                        // dump($field);
                        if (is_string($field) && str_contains(strtolower($field), $search)) {
                          
                            return true; // Return the entire note object if it matches
                        }
                    }

                    // If no field matches, return false to exclude it
                    return false;
                });
                // dump($notes);
              
            }
        }

$expand = false;
if (    $request->session()->get('expandedProject')){
    $expand =     $request->session()->get('expandedProject');
    session()->forget('expandedProject');
}
    
        // Return the view with the relevant data
        return view('home', compact('projects', 'users', 'curruser', 'otherprojects', 'curruser1', 'notes', 'filter','expand'));
    }

    public function insertProgramsView()
    {
        $curruser = session()->get('curruser');
        $users = User::all();
        // dd ($curruser);
        return view('projects.insertprogram', compact('curruser', 'users'));
    }


    public function insertPrograms(Request $request)
    {
        // dd($request);
        $project = new Project();
        // $project->project_title = $request ->project_title;
        // $project->save();
        $project->insert([
            'project_title' => $request->project_title,
            'PIC' => $request->pic,
            'owner' => $request->owner,
            'due_date' => $request->due_date
        ]);



        return redirect()->route('home', [
            'success' => 'Project successfully added',
            'curruser' => $request->curruser,
        ]);
    }






    public function delete($type, $id, Request $request)
    {
        // Find the issue by ID
        // dd($type);
        // dd($id);
        if ($type == 'project') {
            $project = Project::find($id);
            // dd($project);
            $project->delete();
        } else if ($type == 'issue') {
            // dd($request);
            $issue = Issue::findOrFail($id);
            // session(['expanded_project' => $request->input('expandedProject')]);
            // Session::put('expanded_project', $request->input('expandedProject'));
            // $request->session()->put('curruser', $curruser);

            $request->session()->put('expandedProject', $request->expandedProject);
            // dd($request->session()->get('expandedProject'));
            $issue->delete();
        } else if ($type == 'notes') {
            $notes = Notes::find($id);
            $notes->delete();
        }

        return redirect()->route('home', [
            'success' => 'Project successfully added',
            'curruser' => $request->curruser,
        ]);
    }

    public function editprojectview($project_id)
    {
        $project = Project::find($project_id);
        $users = User::all();
        // dd($project);
        return view('projects.editprojects', compact('project', 'users'));
    }

    public function editproject(Request $request)
    {

        $project = Project::findOrFail($request->id_project);
        // dd($request);
        $project->update([
            'project_title' => $request->project_title,
            'pic' => $request->pic,
            'due_date' =>$request->due_date
        ]);


        return redirect()->route('home', [
            'success' => 'Project successfully added',
            'curruser' => Session::get('curruser'),
        ]);
        // return redirect()->route('home')->with('success', 'Project updated successfully!');
    }


    public function assignuser(Request $request)
    {
        $user = User::find($request->user_id);
        session('curruser', $user);
        dd(session()->get('curruser'));
        if ($user) {
            return response()->json([
                'status' => 'success',
                'user' => $user
            ]);
        }
    }

    public function showimage($issueid)
    {
        // dd("masuk");
        $imagepaths = DB::table('tb_image')
            ->select('image')
            ->where('id_issue', $issueid)->get();
        // dd($imagepaths);

        $encodedimages = [];
        foreach ($imagepaths as $image) {
            // dd($image->image);
            $encodedimages[] = base64_encode($image->image);  // Assuming 'image_column' contains the BLOB data
        }
        return view('showimage', compact('encodedimages'));
    }
}
