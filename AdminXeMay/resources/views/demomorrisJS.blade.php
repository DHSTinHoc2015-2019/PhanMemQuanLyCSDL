@extends('layout.index')

@section('css')
	<!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <b>Nhập xe máy</b>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="nhapxemay">Nhập xe máy</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Danh sách</h3>
              <div class="pull-right">
                <a class="btn btn-info" href="nhapxemay/them">
                    <i class="fa fa-plus-square"></i> Thêm
                  </a>
             </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="nav nav-pills ranges">
		        <li class="active"><a href="#" data-range='7'>7 Days</a></li>
		        <li><a href="#" data-range='30'>30 Days</a></li>
		        <li><a href="#" data-range='60'>60 Days</a></li>
		        <li><a href="#" data-range='90'>90 Days</a></li>
			</ul>	

			<div class="col-xs-7">
				<div id="stats-container" style="height: 250px;"></div>
			</div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection

@section('script')
  <!-- DataTables -->
  <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="bower_components/fastclick/lib/fastclick.js"></script>
   <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
 <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> -->
 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <script>
$(function() {

  // Create a function that will handle AJAX requests
	  function requestData(days, chart){
	    $.ajax({
	      type: "GET",
	      dataType: 'json',
	      url: "./api/" + days, // This is the URL to the API
	      data: { days: days }
	    })
	    .done(function( data ) {
	      // When the response to the AJAX request comes back render the chart with new data
	      chart.setData(data);
	    })
	    .fail(function() {
	      // If there is no communication between the server, show an error
	      alert( "error occured" );
	    });
	  }

	  var chart = Morris.Bar({
	    // ID of the element in which to draw the chart.
	    element: 'stats-container',
	    data: [0, 0], // Set initial data (ideally you would provide an array of default data)
	    xkey: 'date', // Set the key for X-axis
	    ykeys: ['value'], // Set the key for Y-axis
	    labels: ['Số lượng'] // Set the label when bar is rolled over
	  });

	  // Request initial data for the past 7 days:
	  requestData(7, chart);

	  $('ul.ranges a').click(function(e){
	    e.preventDefault();

	    // Get the number of days from the data attribute
	    var el = $(this);
	    days = el.attr('data-range');
	    console.log(days);
	    // Request the data and render the chart using our handy function
	    requestData(days, chart);
	    el.parent().addClass('active');
    	el.parent().siblings().removeClass('active');
	  })
	});
</script>
@endsection