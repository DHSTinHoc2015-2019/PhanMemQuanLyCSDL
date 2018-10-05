<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::User()->name }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
          <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Cập nhật thông tin</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="khachhang"><i class="fa fa-user-md"></i> Khách hàng</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-user-secret"></i> Nhân viên
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="chucvu"><i class="fa fa-circle-o"></i> Chức vụ</a></li>
                <li><a href="nhanvien"><i class="fa fa-circle-o"></i> Thông tin nhân viên</a></li>
              </ul>
            </li>
            <li><a href="user"><i class="fa fa-user"></i> Người dùng</a></li>
            <li><a href="nhacungcap"><i class="fa fa-home"></i> Nhà cung cấp</a></li>
            <li><a href="xemay"><i class="fa fa-motorcycle"></i> Xe máy</a></li>
            
            <li class="treeview">
              <a href="#"><i class="fa fa-wrench"></i> Phụ tùng
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="loaiphutung"><i class="fa fa-circle-o"></i> Loại phụ tùng</a></li>
                <li><a href="phutung"><i class="fa fa-circle-o"></i> Phụ tùng</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-gears"></i> Phụ kiện
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="thongtinphukien"><i class="fa fa-circle-o"></i> Loại phụ kiện</a></li>
                <li><a href="phukien"><i class="fa fa-circle-o"></i> Phụ kiện</a></li>
              </ul>
            </li>
             <li class="treeview">
              <a href="#"><i class="fa fa-plus-square"></i> Bảo hành
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="loaibaohanh"><i class="fa fa-circle-o"></i> Loại bảo hành</a></li>
                <li><a href="baohanh"><i class="fa fa-circle-o"></i> Bảo hành</a></li>
              </ul>
            </li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i> <span>Giao dịch</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="nhapxemay"><i class="fa fa-motorcycle"></i>Phiếu nhập xe máy</a></li>
            <li><a href="nhapphutungphukien"><i class="fa fa-gears"></i>Phiếu nhập phụ tùng - phụ kiện</a></li>
            <li><a href="hoadonbanxemay"><i class="fa fa-motorcycle"></i>Hóa đơn bán xe máy</a></li>
            <li><a href="#"><i class="fa fa-gears"></i>Hóa đơn bán phụ tùng - phụ kiện</a></li>
          </ul>
        </li>
        <!-- /Cập nhật thông tin-->

        <!-- Tìm kiếm-->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-search"></i> <span>Tìm kiếm</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href=""><i class="fa fa-user"></i>Người dùng</a></li>
            <li><a href="timkiem/nhanvien"><i class="fa fa-user-secret"></i>Nhân viên</a></li>
            <li><a href="timkiem/khachhang"><i class="fa fa-user-md"></i>Khách hàng</a></li>
            <li><a href="timkiem/xemay"><i class="fa fa-motorcycle"></i>Xe máy</a></li>
            <li><a href=""><i class="fa fa-wrench"></i>Phụ tùng</a></li>
            <li><a href=""><i class="fa fa-gears"></i>Phụ kiện</a></li>
            <li><a href="#"><i class="fa fa-motorcycle"></i>Hóa đơn bán xe máy</a></li>
            <li><a href="#"><i class="fa fa-gears"></i>Hóa đơn bán phụ tùng - phụ kiện</a></li>
            <!-- <li><a href="#"><i class="fa fa-plus-square"></i>Bảo hành</a></li> -->
          </ul>
        </li>
        <!-- /Tìm kiếm-->

        <!-- Thống kê-->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-calendar"></i> <span>Báo cáo - Thống kê</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="thongke/nhanvien"><i class="fa fa-user"></i>Nhân viên</a></li>
            <li><a href=""><i class="fa fa-motorcycle"></i>Xe máy</a></li>
            <li><a href="#"><i class="fa fa-gears"></i>Phụ tùng phụ kiện</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-book"></i>Phiếu nhập
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href=""><i class="fa fa-circle-o"></i>Phụ tùng - phụ kiện</a></li>
                <li><a href=""><i class="fa fa-circle-o"></i> Xe máy</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-book"></i>Hóa đơn
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href=""><i class="fa fa-circle-o"></i>Phụ tùng - phụ kiện</a></li>
                <li><a href=""><i class="fa fa-circle-o"></i> Xe máy</a></li>
              </ul>
            </li>

          </ul>
        </li>
        <!-- ./Thống kê -->
        

      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>