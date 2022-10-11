<!-------------------- START - Mobile Menu -------------------->
<div class="menu-mobile menu-activated-on-click color-scheme-dark">
  <div class="mm-logo-buttons-w">
    <a class="mm-logo" href="index.html"><img src="<?php echo site_url('public/img/logo.png'); ?>"><span>Loco Admin</span></a>
    <div class="mm-buttons">
      <div class="content-panel-open">
        <div class="os-icon os-icon-grid-circles"></div>
      </div>
      <div class="mobile-menu-trigger">
        <div class="os-icon os-icon-hamburger-menu-1"></div>
      </div>
    </div>
  </div>

  <div class="menu-and-user">
    <div class="logged-user-w">
      <div class="avatar-w"><img alt="" src="<?php echo site_url('uploads/user/'.$_SESSION['image']); ?>"></div>
      <div class="logged-user-info-w">
        <div class="logged-user-name"><?php echo $_SESSION['name']; ?></div>
        <div class="logged-user-role">
            <?php 
              $arr_type = array('admin'=>'Administrator','editor'=>'Editor','viewer'=>'Viewer');
              echo $arr_type[$_SESSION['access']];
            ?>
          
        </div>
      </div>
    </div>
    <!-------------------- START - Mobile Menu List -------------------->
    <ul class="main-menu">
      <li class="li-menu-dashboard">
        <a href="<?php echo ADMIN_URL;?>">
          <div class="icon-w">
            <div class="os-icon os-icon-window-content"></div>
          </div>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="li-menu-transaction">
        <a href="<?php echo ADMIN_URL.'/transaction';?>">
          <div class="icon-w">
            <div class="os-icon os-icon-pencil-12"></div>
          </div>
          <span>Transaction</span>
        </a> 
      </li>
      <li class="has-sub-menu li-menu-report">
        <a href="#">
          <div class="icon-w">
            <div class="os-icon os-icon-newspaper"></div>
          </div>
          <span>Report</span></a>
        <ul class="sub-menu">
          <li>
            <a href="<?php echo ADMIN_URL.'/report/daily';?>">Daily Report</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/report/monthly';?>">Monthly Report</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/report/yearly';?>">Yearly Report</a>
          </li>
          <li class="li-menu-item-report">
            <a href="<?php echo ADMIN_URL.'/report/item-record';?>">Item Record</a>
          </li>
          <li class="li-menu-item-report">
            <a href="<?php echo ADMIN_URL.'/report/buy-items-record';?>">Buy Items Record</a>
          </li>
          <li class="li-menu-item-report">
            <a href="<?php echo ADMIN_URL.'/report/bestsellers';?>">Bestsellers</a>
          </li>
        </ul>
      </li>
      <li class="has-sub-menu li-menu-item">
        <a href="#">
          <div class="icon-w">
            <div class="os-icon os-icon-delivery-box-2"></div>
          </div>
          <span>Item</span></a>
        <ul class="sub-menu">
          <li>
            <a href="<?php echo ADMIN_URL.'/buy-items';?>">Buy Items</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/items';?>">Item</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/category-item';?>">Category Item</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/store';?>">Store</a>
          </li>         
        </ul>
      </li>
      <!--<li class="">
        <a href="<?php echo ADMIN_URL.'/events';?>">
          <div class="icon-w">
            <div class="os-icon os-icon-tasks-checked"></div>
          </div>
          <span>Events</span></a>
      </li>-->
      
      <li class="li-menu-event">
        <a href="<?php echo ADMIN_URL.'/check-stock';?>">
          <div class="icon-w">
            <div class="os-icon os-icon-tasks-checked"></div>
          </div>
          <span>Check Stock</span>
        </a>
      </li>
      <li class="li-menu-event">
        <a href="<?php echo ADMIN_URL.'/events';?>">
          <div class="icon-w">
            <div class="os-icon os-icon-hierarchy-structure-2"></div>
          </div>
          <span>Events</span></a>
      </li>





      <li class="has-sub-menu li-menu-user">
        <a href="#">
          <div class="icon-w">
            <div class="os-icon os-icon-user-male-circle"></div>
          </div>
          <span>Users</span></a>
        <ul class="sub-menu">
          <li>
            <a href="<?php echo ADMIN_URL.'/user';?>">All</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/user/create';?>">Create</a>
          </li>
        </ul>
      </li>

      <li class="has-sub-menu">
        <a href="#">
          <div class="icon-w">
            <div class="os-icon os-icon-robot-1"></div>
          </div>
          <span>Profile</span></a>
        <ul class="sub-menu">
          <li>
            <a href="<?php echo ADMIN_URL.'/edit-profile';?>">Profile Details</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/bonus/my-bonus';?>">My Bonus</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/logout';?>">Logout</a>
          </li>
        </ul>
      </li>  


      <li class="has-sub-menu li-menu-setting">
        <a href="#">
          <div class="icon-w">
            <div class="os-icon os-icon-grid-squares"></div>
          </div>
          <span>Setting</span>
        </a>
        <ul class="sub-menu">
          <li>
            <!--<a href="<?php echo ADMIN_URL.'/general-option';?>">General Setting</a>-->
            <a href="<?php echo ADMIN_URL.'/setting';?>">General Setting</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/bonus';?>">Bonus Range</a>
          </li>
        </ul>
      </li>



    </ul>    
    <!-------------------- END - Mobile Menu List -------------------->
  </div> <!-- END menu-and-user -->
</div>
<!-------------------- END - Mobile Menu -------------------->

















<div class="desktop-menu menu-side-w menu-activated-on-click">
  <div class="logo-w">
    <a class="logo" href="index.html">
      <div class="logo-element"></div>
      <div class="logo-label">
        Loco Admin
      </div>
    </a>
  </div>
  <div class="menu-and-user">
    <div class="logged-user-w">
      <div class="logged-user-i">
        <div class="avatar-w">
          <img alt="" src="<?php echo site_url('uploads/user/'.$_SESSION['image']); ?>">
        </div>
        <div class="logged-user-info-w">
          <div class="logged-user-name">
            <?php echo $_SESSION['name']; ?>
          </div>
          <div class="logged-user-role">
            <?php 
              $arr_type = array('admin'=>'Administrator','editor'=>'Editor','viewer'=>'Viewer');
              echo $arr_type[$_SESSION['access']];
            ?>
          </div>
        </div>
        <div class="logged-user-menu">
          <div class="logged-user-avatar-info">
            <div class="avatar-w">
              <img alt="" src="<?php echo site_url('uploads/user/'.$_SESSION['image']); ?>">
            </div>
            <div class="logged-user-info-w">
              <div class="logged-user-name">
                <?php echo $_SESSION['name']; ?>
              </div>
              <div class="logged-user-role">
                <?php 
                  echo $arr_type[$_SESSION['access']];
                ?>
              </div>
            </div>
          </div>
          <div class="bg-icon">
            <i class="os-icon os-icon-wallet-loaded"></i>
          </div>
          <ul>
            <li>
              <a href="<?php echo ADMIN_URL.'/edit-profile';?>"><i class="os-icon os-icon-user-male-circle2"></i><span>Profil</span></a>
            </li>
            <li>
              <a href="<?php echo ADMIN_URL.'/bonus/my-bonus';?>"><i class="os-icon os-icon-coins-4"></i><span>Bonus Saya</span></a>
            </li>
            <li>
              <a href="<?php echo ADMIN_URL.'/logout';?>"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <ul class="main-menu">
      <li class="li-menu-dashboard">
          <a href="<?php echo ADMIN_URL;?>">
            <div class="icon-w">
              <div class="os-icon os-icon-window-content"></div>
            </div>
            <span>Dashboard</span>
          </a> 
      </li>
      <li class="li-menu-transaction">
        <a href="<?php echo ADMIN_URL.'/transaction';?>">
          <div class="icon-w">
            <div class="os-icon os-icon-pencil-12"></div>
          </div>
          <span>Transaksi</span>
        </a>
      </li>
      <li class="has-sub-menu li-menu-report">
        <a href="#">
          <div class="icon-w">
            <div class="os-icon os-icon-newspaper"></div>
          </div>
          <span>Laporan</span>
        </a>
        <ul class="sub-menu">
          <li>
            <a href="<?php echo ADMIN_URL.'/report/daily';?>">Laporan Penjualan Harian</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/report/monthly';?>">Laporan Penjualan Bulanan</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/report/yearly';?>">Laporan Penjualan Tahunan</a>
          </li>
          <li class="li-menu-item-report">
            <a href="<?php echo ADMIN_URL.'/report/buy-items-record';?>">Laporan Belanja Barang</a>
          </li>
          <li class="li-menu-item-report">
            <a href="<?php echo ADMIN_URL.'/report/item-record';?>">Rekam Barang</a>
          </li>
          <li class="li-menu-item-report">
            <a href="<?php echo ADMIN_URL.'/report/bestsellers';?>">Barang Terlaris</a>
          </li>
        </ul>
      </li>            
      <li class="has-sub-menu li-menu-item">
        <a href="<?php echo ADMIN_URL.'/items';?>">
          <div class="icon-w">
            <div class="os-icon os-icon-delivery-box-2"></div>
          </div>
          <span>Barang</span></a>
        <ul class="sub-menu">
          <li>
            <a href="<?php echo ADMIN_URL.'/buy-items';?>">Belanja Barang</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/items';?>">Stok Barang</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/category-item';?>">Kategori Barang</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/store';?>">Toko</a>
          </li>
        </ul>
      </li>
      <li class="li-menu-event">
        <a href="<?php echo ADMIN_URL.'/check-stock';?>">
          <div class="icon-w">
            <div class="os-icon os-icon-tasks-checked"></div>
          </div>
          <span>Cek Stok</span></a>
      </li>
      <li class="li-menu-event">
        <a href="<?php echo ADMIN_URL.'/events';?>">
          <div class="icon-w">
            <div class="os-icon os-icon-hierarchy-structure-2"></div>
          </div>
          <span>Hari Penting</span></a>
      </li>
      

      <li class="has-sub-menu li-menu-user">
        <a href="#">
          <div class="icon-w">
            <div class="os-icon os-icon-user-male-circle"></div>
          </div>
          <span>Users</span></a>
        <ul class="sub-menu">
          <li>
            <a href="<?php echo ADMIN_URL.'/user';?>">Users</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/user/create';?>">Baru</a>
          </li>
        </ul>
      </li>
      <li class="has-sub-menu li-menu-setting">
        <a href="#">
          <div class="icon-w">
            <div class="os-icon os-icon-grid-squares"></div>
          </div>
          <span>Pengaturan</span>
        </a>

        <ul class="sub-menu">
          <li>
            <!--<a href="<?php echo ADMIN_URL.'/general-option';?>">General Setting</a>-->
            <a href="<?php echo ADMIN_URL.'/setting';?>">Pengaturan Umum</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/bonus';?>">Jangkauan Bonus</a>
          </li>
        </ul>
      </li>
      
    </ul>
  </div>
</div>

<div class="content-w">
  <!-------------------- START - Breadcrumbs -------------------->
  <!--<ul class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="index.html">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a href="index.html">Products</a>
    </li>
    <li class="breadcrumb-item">
      <span>Laptop with retina screen</span>
    </li>
  </ul>-->
  <!-------------------- END - Breadcrumbs -------------------->