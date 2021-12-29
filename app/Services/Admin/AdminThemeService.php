<?php


namespace App\Services\Admin;
use App\Models\Theme\CourseTheme;
use App\Models\Theme\LessonTheme;
use Illuminate\Http\Request;


class AdminThemeService
{
    public function storeTheme(Request $request){
    if($request->get('type') === 'lesson'){
          $theme = new LessonTheme();
          $theme -> course_theme_id = $request->get('course')['theme_id'];
        $theme -> title = $request->get('title');
        $theme -> slug = $request->get('slug');
        $theme -> save();
        return $theme;
       }
        elseif($request->get('type') === 'course'){
            $theme = new CourseTheme();
            $theme -> title = $request->get('title');
            $theme -> slug = $request->get('slug');
            $theme -> save();
            return $theme;
        }
    }
}
