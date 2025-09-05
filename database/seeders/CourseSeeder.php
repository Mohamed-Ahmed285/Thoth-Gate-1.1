<?php

namespace Database\Seeders;

use App\Models\Community;
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
                'grade' => 'Third Preparatory',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/language.jpg',
            ],
            [
                'subject' => 'English',
                'grade' => 'Third Preparatory',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/language.jpg'
            ],
            [
                'subject' => 'Math',
                'grade' => 'Third Preparatory',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/maths.jpg',
            ],
            [
                'subject' => 'Science',
                'grade' => 'Third Preparatory',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/science.jpg',
            ],
            [
                'subject' => 'History',
                'grade' => 'Third Preparatory',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/history.jpg',
            ],
            // courses for 1 sec
            [
                'subject' => 'Arabic',
                'grade' => 'First Secondary',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/language.jpg',
            ],
            [
                'subject' => 'English',
                'grade' => 'First Secondary',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/language.jpg',
            ],
            [
                'subject' => 'Philosophy & Logic',
                'grade' => 'First Secondary',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/philosophy.jpg',
            ],
            [
                'subject' => 'History',
                'grade' => 'First Secondary',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/history.jpg',
            ],
            [
                'subject' => 'Math',
                'grade' => 'First Secondary',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/maths.jpg',
            ],
            [
                'subject' => 'Integrated Science',
                'grade' => 'First Secondary',
                'teacher' => 'Mohamed Hamed',
                'image' => 'imgs/science.jpg',
            ],
        ];

        $communities = [
            [
                'grade' => 'Third Preparatory',
            ],
            [
                'grade' => 'First Secondary',
            ]
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
        foreach ($communities as $community) {
            Community::create($community);
        }
    }
}
