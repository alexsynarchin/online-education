@extends('admin.base.admin_base')
@section('content')
    <div class="container auth">
        <div class="row  justify-content-center">
            <div class="col-md-4">
                <div class="card text-center ">
                    <div class="card-header">
                        <figure class="auth__logo">
                            <img src="{{asset('images/logo-3.png')}}">
                        </figure>
                        <h1 class="auth__title">
                           Панель администрирования
                        </h1>
                    </div>
                    <div class="card-body">
                       <admin-login></admin-login>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
