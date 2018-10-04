@extends('layout.index')

@section('css')
	
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Page Header
        <small>Optional description</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li>Sửa tài khoản</li>
        <li class="active">id</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Select2</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- Form -->
          <form>
            <div class="row">
              <div class="col-md-6">
               <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <input type="file" id="exampleInputFile">
              </div>

              <!-- select -->
              <div class="form-group">
                <label>Select</label>
                <select class="form-control">
                  <option>option 1</option>
                  <option>option 2</option>
                  <option>option 3</option>
                  <option>option 4</option>
                  <option>option 5</option>
                </select>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6">

              <div class="form-group">
                <label>Text</label>
                <input type="text" class="form-control" placeholder="Enter ...">
              </div>
              <!-- textarea -->
              <div class="form-group">
                <label>Textarea</label>
                <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </form>
        <!-- /Form -->
      </div>
      <!-- /.box-body -->
       <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('script')

@endsection