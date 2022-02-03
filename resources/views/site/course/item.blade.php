<section class="course-item">
    <div class="course-item__heading">
        <a href="{{route('catalog.show', ['edu_slug' => $course -> edu_type -> slug, 'slug' => $course -> slug])}}"  class="course-item__link">
            <h4 class="course-item__title">
                {{$course -> title}}
            </h4>
        </a>
        @if($course->rating > 0)
            <course-rating
                :count="{{json_encode($course->rating_count)}}"
                :rating="{{json_encode($course->rating)}}"
            ></course-rating>
        @endif
    </div>
    <div class="course-item__content">
        <figure class="course-item__img">
            <img src="{{$course -> image}}" >
        </figure>
        <div class="course-item__main">
            <p class="course-item__descr">
                {{$course -> description}}
            </p>
            <ul class="course-item-lessons">
                @foreach($course -> lessons as $lesson)
                    <li class="course-item-lessons__item course-item-lessons__item--preview">
                        <a href="{{route('lesson.show',[ $course -> edu_type -> slug, $course->slug, $lesson -> slug])}}"
                           class="course-item-lessons__link">
                            {{$lesson -> title}}
                        </a>
                    </li>
                @endforeach
            </ul>
            <a href="{{route('catalog.show', ['edu_slug' => $course -> edu_type -> slug, 'slug' => $course -> slug])}}"
               class="course-item-lessons__btn btn">Полный список уроков</a>
        </div>
        <div class="course-item__right course-item__right--text-right">
            <div class="course-item__price">
                {{$course ->price}} ₽
            </div>
            <div class="course-item__actions">
                <buy-btn :buying_id="{{$course->id}}" v-if="{{json_encode(!$course->user_buy)}}"></buy-btn>
                <a
                    href="{{route('catalog.show', ['edu_slug' => $course -> edu_type -> slug, 'slug' => $course -> slug])}}"
                    class="course-item__btn btn" v-else>
                    Перейти
                </a>
            </div>

        </div>
    </div>
    <div class="course-item__footer">
        <div class="course-item__author">
            <label class="course-item__author-label">
                Автор:
            </label>
            <a href="{{route('teacher.show', $course->author -> id)}}" class="course-item__author-value">
                                    {{$course -> author -> name}}
                {{$course -> author -> surname}}
                                </a>
            <el-tooltip class="item" effect="dark" content="Кликнете по имени преподавателя чтобы посмотреть его курсы" placement="top-start">
                <svg class="course-item__author-icon">
                    <use xlink:href="{{URL::asset('assets/site/images/sprites.svg?ver=12#sprite-question-icon')}}"></use>
                </svg>
            </el-tooltip>

        </div>
    </div>
</section>
