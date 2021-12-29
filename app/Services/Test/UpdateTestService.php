<?php


namespace App\Services\Test;
use App\Models\Lesson\Test;
use Illuminate\Http\Request;

class UpdateTestService
{
    public function update($data, $id, $directory)
    {
        $test = Test::findOrFail($id);
        $test->fill([
            'complete_percent' => $data['complete_percent'],
            'repeat_period' => $data['repeat_period']
        ]);
        $question_dir = $directory . 'test_student-'.$test->id . '/';
        $questionsService = new QuestionService();
        $questions = $data['questions'];
        $questionsService->update($data['questions'], $test -> id,$question_dir);
        return $test;
    }
}
