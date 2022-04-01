@extends('site.base.base')
@section('content')
 <div class="container">
     @if($page->type != 'instruction')
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
     @endif
     @if($page->type != 'about' && $page->type != 'instruction')
         <h1 class="page-title">
             {{$page->name}}
         </h1>
     @endif
     @if($page->type != 'about' && $page->type != 'instruction')
     <div class="mb-5" >
         {!! $page->text !!}
     </div>
     @endif
     @if($page->type === 'about')
         @include('site.static-page.components.about')
     @endif
         @if($page->type === 'instruction')
             @include('site.static-page.components.instruction')
         @endif
 </div>
@endsection
