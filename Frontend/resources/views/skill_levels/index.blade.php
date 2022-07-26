@extends('layouts.main')
@section('custom_css')
<style>
  .dark-mode .page-item.active .page-link {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #fff;
}
</style>
@endsection
@section('content')
        <div class="row">


          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <!-- <h3 class="card-title">Simple Full Width Table  </h3> -->

              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Skill Level Name</th>
                      <th style="width: 40px">Act</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($skill_levels as $skill)
                        
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $skill->skillLevelName }}</td>
                      <td>

                  <button type="button" class="btn btn-success btn-block btn-sm"><i class="fa fa-search"></i></button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
@endsection