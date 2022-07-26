@extends('layouts.main')
@section('content')
        <div class="row">
          <div class="col-lg-12">

            <div class="card card-primary card-outline">
              <div class="card-body">
                <h5 class="card-title">Hello, {{ session('name') }}</h5>

                <p class="card-text">
                  Department : {{ session('department') }}
                  <br>
                  Section : {{ session('section') }}
                  <br>
                  Email : {{ session('email') }}
                  <br>
                  Role : {{ session('role') }}
                </p>
                <!-- <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a> -->
              </div>
            </div><!-- /.card -->
          </div>
        </div>
@endsection