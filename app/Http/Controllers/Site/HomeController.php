<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category\CategoryType;
use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $slides = [];
        $page = Page::where('type', 'main-page')->firstOrFail();
        if(isset($page->blocks['slider'])) {
            $ids=[];
            foreach ($page->blocks['slider'] as $slide) {
                $ids[] = $slide['edu_type_id'];
            }

            $edu_types = CategoryType::whereIn('id',$ids)->with('levels') -> get(['id', 'title', 'slug']);
            foreach ($edu_types as $key => $edu_type) {
                $label = 'курс';
                if($edu_type->id === 1) {
                    $label = 'класс';
                }
                if($edu_type->id === 4) {
                    $label = 'возраст';
                }
                $slide = [
                    'id' => $edu_type -> id,
                    'title' => $page->blocks['slider'][$key]['title'],
                    'slug' => $edu_type -> slug,
                    'text' => $page->blocks['slider'][$key]['text'],
                    'label' =>$label,
                    'image' => $page->blocks['slider'][$key]['image']['link'],
                    'levels' => $edu_type->levels,

                ];
                array_push($slides, $slide);
                $slides[0]['label'] = 'класс';
            }
        }
        $banners = $page->blocks['banners'] ?? [];
        $for_whom = $page->blocks['for_whom'] ?? [];
        $price_text = $page->blocks['price']['text'] ?? '';
        $price_list = $page->blocks['price_list'] ?? [];
        $you_get = $page->blocks['you_get'] ?? [];
        $articles = Article::where('active', 1) -> orderBy('menuindex','asc') ->orderBy('created_at','desc') -> limit(3) -> get();
        $youtube_id="";
        if($page->blocks['youtube_link']) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $page->blocks['youtube_link'], $match);
            $youtube_id = $match[1];
        }


        return view('site.home.index',[
            'slides' => $slides,
            'banners' => $banners,
            'for_whom' => $for_whom,
            'price_text' => $price_text,
            'price_list' => $price_list,
            'you_get' => $you_get,
            'articles' => $articles,
            'youtube_id' => $youtube_id,
        ]);
    }
    public function smsTest(Request $request)
    {


        echo "<script>parent.document.getElementById('_out').innerHTML = '";


        include_once "/../../Services/Smsc/smsc_api.php";
        if (isset($_POST["sendsms"])) {
            $r = send_sms($_POST["phone"], ok_code($_POST["phone"]));

            if ($r[1] > 0)
                echo "Код подтверждения отправлен на номер ".$_POST["phone"];
        }

        if (isset($_POST["ok"])) {
            $oc = ok_code($_POST["phone"]);

            if ($oc == $_POST["code"])
                echo "Номер активирован";
            else
                echo "Неверный код подтверждения";
        }

        echo "'</script>";

        function ok_code($s) {
            return hexdec(substr(md5($s."<секретная строка>"), 7, 5));
        }

    }
}
