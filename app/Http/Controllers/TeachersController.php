<?php 

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;  
use App\Models\Teacher; 
use App\Models\student; 
use DataTables;
use Validator;
use DB;

class TeachersController extends Controller 
{ 
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        $teachers = Teacher::latest()->get();
        
        if ($request->ajax()) {
            $data = Teacher::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editTeacher">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTeacher">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('teacher',compact('teachers'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name'        => 'required|max:60',
            'last_name'        => 'required|max:60',
            'email'        => "required|max:60|unique:teachers,email,$request->teacher_id",
            // 'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()]);
        }
        Teacher::updateOrCreate(['id' => $request->teacher_id],
                ['first_name' => $request->first_name,'last_name' => $request->last_name, 'email' => $request->email]);        
   
        return response()->json(['success'=>'Teacher saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teacher = Teacher::find($id);
        return response()->json($teacher);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Teacher::find($id)->delete();
     
        return response()->json(['success'=>'Teacher deleted successfully.']);
    }

    public function assignList()
    {
        $assigned = array();
        $teachers = Teacher::get();
        $students = Student::get();
        $s =0;
        foreach($teachers as $key => $item){
            foreach($item->myStudent as $key2 => $item2){
                $assigned[$s]['id']=$item2->pivot->id;
                $assigned[$s]['teacher_name']=$item->first_name.' '.$item->last_name;
                $assigned[$s]['student_name']=$item2->first_name.' '.$item2->last_name;
                $s++;
            }
        }
        $data=$assigned;
        // dd($data);

        return view('assign',compact('data','teachers','students'));
    }

    public function assignUser(Request $request)
    {
        $teacher = Teacher::find($request->teacherId);
        $teacher->myStudent()->attach([$request->studentId]);

        return response()->json(['success'=>'Assigned successfully.']);
    }

    public function assignUserDelete($id)
    {
        $teacher = DB::table('teacher_student')->where('id',$id)->delete();

        return response()->json(['success'=>'Assigned successfully.']);
    }
}