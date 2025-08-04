<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\MessageRequest;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __invoke(MessageRequest $request)
    {
        $teacher = auth('teacher')->user();
        $message = $teacher->messages()->create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
             'messageable_type' => 'teacher',
            'messageable_id' => $teacher->id
        ]);
         if($message){
                return self::success('تم إرسال الرسالة بنجاح',[
                    'name' => $message->name,
                    'email' => $message->email,
                    'message' => $message->message,
                ],201);
            }
            return self::error('حدث خطأ أثناء إرسال الرسالة');
    }
   
}
