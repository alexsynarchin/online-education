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
        $content = $request->get('content');
        $lesson ->fill([
            'price_user' => $description['price'],
            'description' => $description['description'],
            'price' => 0,
            'time' => $description['time'],
            'type_video' => $content['type_video'],
            'type_image' => $content['type_image'],
            'type_text' => $content['type_text'],
            'status' => 1
        ]);
        $descriptionModel = Description::where('descriptions_id', $id)->firstOrFail();
        $descriptionModel ->text= $description['description'];
        $descriptionModel ->save();
        $contentService = new ContentService();
        $directory = 'users/user-' . Auth::user()->id .'/courses/course-'. $lesson->course_id . '/lesson-' . $lesson->id . '/';


        if (strpos($request->get('lesson')['preview'], 'data:image') !== false) {
            $imageService = new ImageService();
            $filename = $imageService -> make($request->get('lesson')['preview'],$directory);
            $lesson -> image = $filename;
            $lesson ->directory = $directory;
        }

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
