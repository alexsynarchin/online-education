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
            'vk_url' => $request->get('vk_url'),
            'youtube_url' => $request->get('youtube_url'),
            'status' => $request -> get('status'),
        ]);

        if($request->get('type_text'))
        {
            $lesson->type_video =$request->get('type_text');
        }
        if($request->get('type_image'))
        {
            $lesson->type_image = $request->get('type_image');
        }
        if($request->get('type_audio'))
        {
            $lesson->type_audio = $request->get('type_audio');
        }
        if($request->get('type_video'))
        {
            $lesson->type_text = $request->get('type_video');
        }
        $lesson->save();

       $lesson ->save();
        $test = new Test([
            'repeat_period' => $request->get('repeat_period'),
            'complete_percent' => $request->get('complete_percent'),
        ]);
        $lesson ->tests()->save($test);
        $questions = new StoreQuestionService();
        $questions -> store($test->id, $request->get('questions'));
        $content_service= new ContentRichTextService();
        $directory = 'users/user-' . Auth::user()->id .'/courses/course-'. $course_id . '/lesson-' . $lesson->id .'/';
        $content_path = 'users/user-' . Auth::user()->id .'/courses/course-'. $course_id . '/lesson-' . $lesson->id.'/content';
        $content = $content_service->store($request->get('text'), $directory, $content_path);
        $lesson -> content()->save($content);
        return $lesson;
    }
}
