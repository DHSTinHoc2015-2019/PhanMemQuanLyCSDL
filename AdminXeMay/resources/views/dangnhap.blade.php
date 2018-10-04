<!DOCTYPE html>
<html>
<head>
  <title>Admin - Đăng nhập</title>
    <meta charset="utf-8">
    <base href="{{ asset('') }}">
    <link href="dist/css/style.css" rel='stylesheet' type='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!--webfonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:600italic,400,300,600,700' rel='stylesheet' type='text/css'>
    <!--//webfonts-->
</head>
<body>
   <!-----start-main---->
   <div class="main">
    <div class="login-form">
      <h1>Đăng nhập</h1>
          <div class="head">
            <img src="dist/images/user.png" alt=""/>
          </div>
        <form action="dangnhap" method="post" enctype="multipart/form-data">
          @csrf
            <input type="text" class="text" value="Nhập Email hoặc tên đăng nhập" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Nhập Email hoặc tên đăng nhập';}" name="login" required="">
            <input type="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}" name="password" required="">
            <div class="submit">
              <input type="submit" value="ĐĂNG NHẬP">
          </div>  
          <p><a href="dangky1">Đăng ký tài khoản mới</a></p>
        </form>
      </div>
      <!--//End-login-form-->
    </div>
       <!-----//end-main---->
</body>
</html>