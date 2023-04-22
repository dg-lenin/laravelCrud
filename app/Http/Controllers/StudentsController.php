<?php 

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;  
use App\Models\Student; 
use DataTables;
use Validator;

class StudentsController extends Controller 
{ 
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
   
        $students = Student::latest()->get();
        
        if ($request->ajax()) {
            $data = Student::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editStudent">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteStudent">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('student',compact('students'));
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
            'email'        => "required|max:60|unique:students,email,$request->student_id",
            'profile_image'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()]);
        }
        Student::updateOrCreate(['id' => $request->student_id],
                ['first_name' => $request->first_name,'last_name' => $request->last_name, 'email' => $request->email]);        
                if ($request->hasFile('profile_image')) {
                    $extension = $request->file('profile_image')->getClientOriginalExtension();
                    $file_name = date('YmdHis') . '_' . $teacher->id . '.' . $extension;
                    $path = 'image/';
                    $store = $request->file('profile_image')->storeAs($path, $file_name);
                    
                    $teacher->profile_image=$file_name;
                    $teacher->save();
                }

        return response()->json(['success'=>'Student saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::find($id);
        return response()->json($student);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::find($id)->delete();
     
        return response()->json(['success'=>'Student deleted successfully.']);
    }
}