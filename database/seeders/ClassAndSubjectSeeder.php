<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClassAndSubjectSeeder extends Seeder
{
    public function run(): void
    {
        $classrooms = [
            'الصف الأول الثانوي',
            'الصف الثاني الثانوي',
            'الصف الثالث الثانوي',
        ];

        foreach ($classrooms as $classroom) {
            Classroom::create(['name' => $classroom]);
        }

        $classroomIds = Classroom::pluck('id', 'name')->toArray();

        // ✅ المواد المشتركة
        $generalSubjects = [
            ['name' => 'اللغة العربية', 'image' => 'arabic.jpeg'],
            ['name' => 'اللغة الانجليزية', 'image' => 'en.jpeg'],
        ];

        // 🟩 الصف الأول الثانوي
        $firstGradeSubjects = [
            ['name' => 'اللغة العربية', 'image' => 'arabic.jpeg'],
            ['name' => 'اللغة الانجليزية', 'image' => 'en.jpeg'],
            ['name' => 'الرياضيات', 'image' => 'math.jpeg'],
            ['name' => 'الكيمياء', 'image' => 'ki.jpeg'],
            ['name' => 'الفيزياء', 'image' => 'phi.jpeg'],
            ['name' => 'الأحياء', 'image' => 'bio.jpeg'],
            ['name' => 'الجغرافيا', 'image' => 'giography.jpeg'],
            ['name' => 'التاريخ', 'image' => 'history.jpeg'],
        ];

        foreach ($firstGradeSubjects as $subject) {
            Subject::create([
                'id' => Str::uuid(),
                'name' => $subject['name'],
                'classroom_id' => $classroomIds['الصف الأول الثانوي'],
                'image' => $subject['image'],
            ]);
        }

        // 🟨 الصف الثاني الثانوي
        $secondGradeSubjects = [
            'علمي' => [
                ['name' => 'اللغة العربية', 'image' => 'arabic.jpeg'],
                ['name' => 'اللغة الانجليزية', 'image' => 'en.jpeg'],
                ['name' => 'الأحياء', 'image' => 'bio.jpeg'],
                ['name' => 'الكيمياء', 'image' => 'ki.jpeg'],
                ['name' => 'الفيزياء', 'image' => 'phi.jpeg'],
                ['name' => 'الرياضيات', 'image' => 'math.jpeg'],
            ],
            'أدبي' => [
                ['name' => 'اللغة العربية', 'image' => 'arabic.jpeg'],
                ['name' => 'اللغة الانجليزية', 'image' => 'en.jpeg'],
                ['name' => 'التاريخ', 'image' => 'history.jpeg'],
                ['name' => 'الجغرافيا', 'image' => 'giography.jpeg'],
                ['name' => 'علم النفس', 'image' => 'phisio.jpeg'],
                ['name' => 'الفلسفة والمنطق', 'image' => 'phisio.jpeg'],
            ],
        ];

        foreach ($secondGradeSubjects as $classification => $subjectList) {
            foreach ($subjectList as $subject) {
                Subject::create([
                    'id' => Str::uuid(),
                    'name' => $subject['name'],
                    'classification' => $classification,
                    'classroom_id' => $classroomIds['الصف الثاني الثانوي'],
                    'image' => $subject['image'],
                ]);
            }
        }

        // 🟥 الصف الثالث الثانوي
        $thirdGradeSubjects = [
            'علوم' => [
                ['name' => 'اللغة العربية', 'image' => 'arabic.jpeg'],
                ['name' => 'اللغة الانجليزية', 'image' => 'en.jpeg'],
                ['name' => 'الأحياء', 'image' => 'bio.jpeg'],
                ['name' => 'الكيمياء', 'image' => 'ki.jpeg'],
                ['name' => 'الفيزياء', 'image' => 'phi.jpeg'],
            ],
            'رياضيات' => [
                ['name' => 'اللغة العربية', 'image' => 'arabic.jpeg'],
                ['name' => 'اللغة الانجليزية', 'image' => 'en.jpeg'],
                ['name' => 'الرياضيات', 'image' => 'math.jpeg'],
                ['name' => 'الكيمياء', 'image' => 'ki.jpeg'],
                ['name' => 'الفيزياء', 'image' => 'phi.jpeg'],
            ],
            'أدبي' => [
                ['name' => 'اللغة العربية', 'image' => 'arabic.jpeg'],
                ['name' => 'اللغة الانجليزية', 'image' => 'en.jpeg'],
                ['name' => 'التاريخ', 'image' => 'history.jpeg'],
                ['name' => 'الجغرافيا', 'image' => 'giography.jpeg'],
                ['name' => 'علم النفس', 'image' => 'phisio.jpeg'],
                ['name' => 'الفلسفة والمنطق', 'image' => 'phisio.jpeg'],
            ],
        ];

        foreach ($thirdGradeSubjects as $classification => $subjectList) {
            foreach ($subjectList as $subject) {
                Subject::create([
                    'id' => Str::uuid(),
                    'name' => $subject['name'],
                    'classification' => $classification,
                    'classroom_id' => $classroomIds['الصف الثالث الثانوي'],
                    'image' => $subject['image'],
                ]);
            }
        }
    }
}
