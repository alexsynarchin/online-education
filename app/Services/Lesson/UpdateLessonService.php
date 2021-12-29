<?php


namespace App\Services\Lesson;
use App\Models\Description;
use App\Models\Lesson\LessonContent;
use Auth;
use App\Models\Lesson\Lesson;
use App\Services\ImageService;
use App\Services\Test\UpdateTestService;
use Illuminate\Http\Request;

class UpdateLessonService
{
    public function update(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        $description = $request->get('lesson');
        $content = $request->get('lesson')['content'];

        $lesson ->fill([
            'price_user' => $description['price'],
            'price' => 0,
            'time' => $description['time'],
            'status' => 1
        ]);
        $contentService = new ContentService();
        $directory = 'users/user-' . Auth::user()->id .'/courses/course-'. $lesson->course_id . '/lesson-' . $lesson->id . '/';




        $contentModel = $contentService -> update($content['text'],$id,$directory);
        $contentModel->save();
        $testService = new UpdateTestService();
        $test_id = $request->get('test')['id'];
        $test = $testService -> update($request->get('test'), $test_id, $directory);
        $test->save();
        $lesson->save();
        return $lesson;
    }
}
