@extends('site.base.base')
@section('content')
 <div class="container">
     <ul class="breadcrumb">
         <li class="breadcrumb__item">
             <a href="/" class="breadcrumb__link">
                 Главная
             </a>
         </li>
         <li class="breadcrumb__item">
             {{$page->name}}
         </li>
     </ul>
     @if($page->type != 'about')
         <h1 class="page-title">
             {{$page->name}}
         </h1>
     @endif
     @if($page->type === 'about')
         @include('site.static-page.components.about')
     @endif
 </div>
@endsection
