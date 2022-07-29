<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){
        $students = Student::all();
        return response()->json($students);
    }

    public function show($id){
        $student = Student::find($id);
        return response()->json($student);
    }
    
    public function store(Request $request){

       
        $validator = \Validator::make($request->all(), [
            'name' => 'required|min:4',
            'lastname' => 'required|min:4',
            'age' => 'required|integer|min:18',
            'date_of_birth' => 'required|date',
            'date_of_inscription' => 'required|date|after:date_of_birth',
            
        ]);

       /* validate date_of_birth < date_of_inscription */
       $date_of_birth = $request->input('date_of_birth');
       $date_of_inscription = $request->input('date_of_inscription');
       $date_of_birth_year = substr($date_of_birth, 0, 4);
       $date_of_inscription_year = substr($date_of_inscription, 0, 4);
       if ($date_of_birth_year > $date_of_inscription_year) {
           return response()->json(['error' => 'La fecha de nacimiento no puede ser mayor a la fecha de inscripción'], 400);
       }

        if ($validator->fails()) {
            return response()->json(["error" =>$validator->errors()], 400);
        }

        $today = date('Y');
        $date_of_birth = $request->input('date_of_birth');
        $age = $request->input('age');
        $date_of_birth_year = substr($date_of_birth, 0, 4);
        $age_year = substr($age, 0, 4);
       
        if ($date_of_birth_year + $age_year != $today ) {
            return response()->json(['error' => 'La edad no coincide con la fecha de nacimiento'], 400);
        }

       
        $date_of_inscription = $request->date_of_inscription;
        $date_to_years = date('Y', strtotime($date_of_inscription));
       
      
        $year_diff = $today - $date_to_years;
        $cost = ($year_diff * 100);        

        $student = Student::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'age' => $request->age,
            'date_of_birth' => $request->date_of_birth,
            'date_of_inscription' => $request->date_of_inscription,
            'cost' => $cost,
        
        ]);
        return response()->json([
            'ok'=>true,
            'student'=> $student,
            'code'=>201
        ]);
    }

    public function update(Request $request, $id){

        $student = Student::find($id);

        if(!$student){
            return response()->json(['message' => 'Not found'], 404);
        }

        
     
        $validator = \Validator::make($request->all(), [
            'name' => 'required|min:4',
            'lastname' => 'required|min:4',
            'age' => 'required|integer|min:18',
            'date_of_birth' => 'required|date',
            'date_of_inscription' => 'required|date|after:date_of_birth',
            
        ]);

        /* validate date_of_birth < date_of_inscription */
        $date_of_birth = $request->input('date_of_birth');
        $date_of_inscription = $request->input('date_of_inscription');
        $date_of_birth_year = substr($date_of_birth, 0, 4);
        $date_of_inscription_year = substr($date_of_inscription, 0, 4);
        if ($date_of_birth_year > $date_of_inscription_year) {
            return response()->json(['error' => 'La fecha de nacimiento no puede ser mayor a la fecha de inscripción'], 400);
        }

        if ($validator->fails()) {
            return response()->json( ["error" =>$validator->errors() ], 400);
        }
            /* Validate age  */
        $today = date('Y');
        $date_of_birth = $request->input('date_of_birth');
        $age = $request->input('age');
        $date_of_birth_year = substr($date_of_birth, 0, 4);
        $age_year = substr($age, 0, 4);
        
        if ($date_of_birth_year + $age_year != $today ) {
            return response()->json(['error' => 'La edad no coincide con la fecha de nacimiento'], 400);
        }

        $date_of_inscription = $request->date_of_inscription;
        $date_to_years = date('Y', strtotime($date_of_inscription));

       
        $year_diff = $today - $date_to_years;
        $cost = ($year_diff * 100);

        $student->update([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'age' => $request->age,
            'date_of_birth' => $request->date_of_birth,
            'date_of_inscription' => $request->date_of_inscription,
            'cost' => $cost,
        ]);
        
        return response()->json([
            'ok'=>true,
            'student'=>$student,
            'status'=> 200
        ]);
    }

    public function delete($id){
        $student = Student::find($id);
        if(!$student){
            return response()->json(['message' => 'Studen Not found'], 404);
        }

        $student->delete();
        return response()->json(["message"=>"delete"], 204);
    }
}
