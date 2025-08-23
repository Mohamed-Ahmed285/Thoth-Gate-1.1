<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'subject' => 'Arabic',
                'grade' => '3prep',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/language.jpg',
            ],
            [
                'subject' => 'English',
                'grade' => '3prep',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/language.jpg'
            ],
            [
                'subject' => 'Math',
                'grade' => '3prep',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/maths.jpg',
            ],
            [
                'subject' => 'Science',
                'grade' => '3prep',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/science.jpg',
            ],
            [
                'subject' => 'History',
                'grade' => '3prep',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/history.jpg',
            ],
            // courses for 1 sec
            [
                'subject' => 'Arabic',
                'grade' => '1sec',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/language.jpg',
            ],
            [
                'subject' => 'English',
                'grade' => '1sec',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/language.jpg',
            ],
            [
                'subject' => 'Philosophy & Logic',
                'grade' => '1sec',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/philosophy.jpg',
            ],
            [
                'subject' => 'History',
                'grade' => '1sec',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/history.jpg',
            ],
            [
                'subject' => 'Math',
                'grade' => '1sec',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/maths.jpg',
            ],
            [
                'subject' => 'Integrated Science',
                'grade' => '1sec',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/science.jpg',
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
