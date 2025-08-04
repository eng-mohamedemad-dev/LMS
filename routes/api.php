<?php

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Route::get('test',function(){
//    $students = Student::get();
//    $tokens = $students->flatMap(function($student){
//     return $student->firebaseTokens->pluck('token');
//    });
//    $test = $students->map(function($student){
//     return $student->firebaseTokens->pluck('token');
//    });
//    dump($tokens);
//    dump($test->flatten()[0]);
// });
Route::post('/test', function (Request $request) {
    
    return response()->json([
        'message' => 'Request received!',
        'name' => $request->input('name'),
        'email' => $request->input('email'),
    ]);
});

require __DIR__.'/admin.php';
require __DIR__.'/teacher.php';
require __DIR__.'/student.php';
require __DIR__.'/father.php';



