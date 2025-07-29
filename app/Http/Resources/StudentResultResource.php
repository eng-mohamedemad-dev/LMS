<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $qetions = $this->quiz->questions;
        return [
             'questions_number' => $qetions->count(),
             'quiz_title' => $this->quiz->title,
             'total_marks' => $qetions->sum('mark'),
             'score' => $this->score,
            'is_passed' => $this->is_passed,
             'taken_at' => Carbon::parse($this->taken_at)->format('Y-m-d H:i:s'),
        ];
    }
}
