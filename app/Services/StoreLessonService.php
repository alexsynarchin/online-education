<?php


namespace App\Services;


use App\Models\Category\Category;
use App\Models\Category\Course;
use App\Models\Lesson\Lesson;
use App\Models\Lesson\Test;
use App\Services\Test\StoreQuestionService;
use Carbon\Carbon;
use Storage;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Models\Description;


class StoreLessonService
{
    public function make(Request $request)
    {

        if(!($request->get('price_user'))){
            $price = $request->get('price');
        }
        else {
            $price = $request -> get('price_user');
        }
        $slug = new SlugService();
        $slug = $slug->createSlug($request->get('title'), 'Lesson');
        $course_id =$request->get('course_id');
        $lesson =  new Lesson([
            'title' => $request->get('title'),
            'course_id' => $request->get('course_id'),
            'price_user' => $price,
            'time' => $request->get('time'),
            'user_id' => Auth::user()->id,
            'status' => $request -> get('status'),
        ]);
        if(!$request->get('type_video'))
        {
            $lesson->type_video = true;
        }
        if(!$request->get('type_image'))
        {
            $lesson->type_image = true;
        }
        if(!$request->get('type_video'))
        {
            $lesson->type_text = true;
        }
        $lesson->save();
        $directory = 'users/user-' . Auth::user()->id .'/courses/course-'. $course_id . '/lesson-' . $lesson->id .'/';
        $content_path = 'users/user-' . Auth::user()->id .'/courses/course-'. $course_id . '/lesson-' . $lesson->id.'/content';
       $lesson ->save();
        $test = new Test([
            'repeat_period' => $request->get('repeat_period'),
            'complete_percent' => $request->get('complete_percent'),
        ]);
        $lesson ->tests()->save($test);
        $question_dir = $directory . 'test_student-'.$test->id . '/';
        $questions = new StoreQuestionService();
        $questions -> store($test->id, $request->get('questions'), $question_dir);
        $content_service= new ContentRichTextService();
        $content = $content_service->store($request->get('text'), $directory, $content_path);
        $lesson -> content()->save($content);
        return $lesson;
    }
}