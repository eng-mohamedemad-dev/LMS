<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\MessageRequest;



class MessageController extends Controller
{
    public function __invoke(MessageRequest $request)
    {
            $student = auth('student')->user();
            $data = $request->validated();
            $message = $student->messages()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'message' => $data['message'],
                'messageable_type' => 'student',
                'messageable_id' => $student->id
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