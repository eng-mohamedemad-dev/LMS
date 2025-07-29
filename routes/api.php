<?php

use App\Models\Student;
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
Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});

require __DIR__.'/admin.php';
require __DIR__.'/teacher.php';
require __DIR__.'/student.php';
require __DIR__.'/father.php';



