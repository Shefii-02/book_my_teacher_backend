<?php
// database/seeders/GradesSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesSubjectsSeeder extends Seeder
{
  public function run(): void
  {
    DB::table('grades')->insert([
      ['id' => 1, 'name' => 'Pre-Primary / Kindergarten', 'value' => 'Pre-Primary / Kindergarten'],
      ['id' => 2, 'name' => 'Lower Primary', 'value' => 'Lower Primary'],
      ['id' => 3, 'name' => 'Upper primary', 'value' => 'Upper primary'],
      ['id' => 4, 'name' => 'Up to 10th', 'value' => 'Up to 10th'],
      ['id' => 5, 'name' => 'Higher Secondary', 'value' => 'Higher Secondary'],
      ['id' => 6, 'name' => 'Under/Post Graduate Level', 'value' => 'Under/Post Graduate Level'],
      ['id' => 7, 'name' => 'Competitive Exams', 'value' => 'Competitive Exams'],
      ['id' => 8, 'name' => 'Skill Development', 'value' => 'Skill Development'],
    ]);

    DB::table('subjects')->insert([
      // Common subjects
      ['id' => 1, 'name' => 'All Subjects', 'value' => 'All Subjects', 'grade_id' => null],
      ['id' => 2, 'name' => 'Mathematics', 'value' => 'Mathematics', 'grade_id' => null],
      ['id' => 3, 'name' => 'Science', 'value' => 'Science', 'grade_id' => null],
      ['id' => 4, 'name' => 'English', 'value' => 'English', 'grade_id' => null],
      ['id' => 5, 'name' => 'Social Studies', 'value' => 'Social Studies', 'grade_id' => null],
      ['id' => 6, 'name' => 'Computer Science', 'value' => 'Computer Science', 'grade_id' => null],

      // Higher Secondary
      ['id' => 7, 'name' => 'Physics', 'value' => 'Physics', 'grade_id' => 4],
      ['id' => 8, 'name' => 'Chemistry', 'value' => 'Chemistry', 'grade_id' => 4],
      ['id' => 9, 'name' => 'Biology', 'value' => 'Biology', 'grade_id' => 4],

      // UG/PG
      ['id' => 10, 'name' => 'Commerce', 'value' => 'Commerce', 'grade_id' => 5],
      ['id' => 11, 'name' => 'Economics', 'value' => 'Economics', 'grade_id' => 5],
      ['id' => 12, 'name' => 'Engineering Subjects', 'value' => 'Engineering Subjects', 'grade_id' => 5],
      ['id' => 13, 'name' => 'Medical Subjects', 'value' => 'Medical Subjects', 'grade_id' => 5],

      // Competitive Exams
      ['id' => 14, 'name' => 'General Knowledge', 'value' => 'General Knowledge', 'grade_id' => 6],
      ['id' => 15, 'name' => 'Quantitative Aptitude', 'value' => 'Quantitative Aptitude', 'grade_id' => 6],
      ['id' => 16, 'name' => 'Reasoning', 'value' => 'Reasoning', 'grade_id' => 6],
      ['id' => 17, 'name' => 'Current Affairs', 'value' => 'Current Affairs', 'grade_id' => 6],

      // Skills
      ['id' => 18, 'name' => 'Spoken English', 'value' => 'Spoken English', 'grade_id' => 7],
      ['id' => 19, 'name' => 'Programming', 'value' => 'Programming', 'grade_id' => 7],
      ['id' => 20, 'name' => 'Digital Marketing', 'value' => 'Digital Marketing', 'grade_id' => 7],
      ['id' => 21, 'name' => 'Designing', 'value' => 'Designing', 'grade_id' => 7],
    ]);
  }
}
