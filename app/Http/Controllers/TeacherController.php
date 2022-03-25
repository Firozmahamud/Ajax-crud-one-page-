<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{

    public function index()
    {
        $teacher= Teacher::all();
        return view('teacher.index',compact('teacher'));
    }
    public function allData()
    {
        $teacher= Teacher::orderBy('id','DESC')->get();
        // $teacher= Teacher::all();
        // return view('teacher.index',compact('teacher'));
        return response()->json($teacher);
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'title'=>'required',
            'phone'=>'required|unique:teachers'


        ]);
        $data=Teacher::create($request->all());
        // return redirect()->route('teacher.index')->with('success','created successfull');
        return response()->json($data);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        // $teacher= Teacher::find($id);
        // return view('teacher.view',compact('teacher'));
        $data= Teacher::findOrFail($id);
        return response()->json($data);

    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'title'=>'required',
            'phone'=>'required'


        ]);

       $data= Teacher::findorFail($id)->update([
        'name'=>$request->name,
        'title'=>$request->title,
        'phone'=>$request->phone,
       ]);
       return response()->json( $data);


    //    $edit= Teacher::find($id);
    //    $edit->name=$request->name;
    //    $edit->title=$request->title;
    //    $edit->phone=$request->phone;
    //    $edit->save();

    //    return redirect()->route('teacher.index')->with('success','updated successfull');
    }


    public function destroy($id)
    {
        $data= Teacher::destroy($id);
       return response()->json( $data);

        // return view('teacher.index')->with('danger','delete succcessfull');
    }
}
