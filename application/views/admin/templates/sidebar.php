<?php //print_r($_SESSION);?>

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
            <a href="<?php echo ADMIN_URL.'/report/package-status';?>">Laporan Status Paket</a>
          </li>          
          <li>
            <a href="<?php echo ADMIN_URL.'/report/sales-not-paid';?>">Laporan Penjualan Belum Lunas</a>
          </li>
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
            <a href="<?php echo ADMIN_URL.'/report/buy';?>">Laporan Belanja Barang</a>
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
        <a href="<?php echo ADMIN_URL.'/customer';?>">
          <div class="icon-w">
            <div class="os-icon os-icon-delivery-box-2"></div>
          </div>
          <span>Konsumen</span></a>
        <ul class="sub-menu">
          <li>
            <a href="<?php echo ADMIN_URL.'/customer';?>">Konsumen</a>
          </li>  
          <li>
            <a href="<?php echo ADMIN_URL.'/sub-district';?>">Kecamatan</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/districts';?>">Kabupaten</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/province';?>">Provinsi</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/country';?>">Negara</a>
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
            <a href="<?php echo ADMIN_URL.'/buy';?>">Belanja Barang</a>
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
      <li class="<?php echo ($_SESSION['access']=='admin'? 'has-sub-menu':''); ?> li-menu-event">
        <a href="<?php echo ADMIN_URL.'/check-stock';?>">
          <div class="icon-w">
            <div class="os-icon os-icon-tasks-checked"></div>
          </div>
          <span>Cek Stok</span>
        </a>
        <ul class="sub-menu">
          <li>
            <a href="<?php echo ADMIN_URL.'/check-stock';?>">Cek Stok</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/report/check-stock';?>">Laporan Cek Stok</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/report/not-check-stock';?>">Laporan Barang Belum Dicek</a>
          </li>

        </ul>  
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





<!--- START MOBILE -->
<div class="menu-mobile menu-activated-on-click">
  <div class="mm-logo-buttons-w">
    <a class="mm-logo" href="index.html"><img src="<?php echo site_url('public/img/logo.png');?>"><span>Clean Admin</span></a>
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
      <div class="avatar-w">
        <a href="<?php echo ADMIN_URL.'/edit-profile';?>">
          <img alt="" src="<?php echo site_url('uploads/user/'.$_SESSION['image']); ?>">  
        </a>        
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
    </div>
    <!--------------------
    START - Mobile Menu List
    -------------------->
    <ul class="main-menu">
      <li> 
        <a href="<?php echo ADMIN_URL;?>">
          <div class="icon-w">
            <div class="os-icon os-icon-window-content"></div>
          </div>
        </a>        
      </li>
      <li class="li-menu-transaction">
        <a href="<?php echo ADMIN_URL;?>/transaction">
          <div class="icon-w">
            <div class="os-icon os-icon-pencil-12"></div>
          </div>
          <!--<span>Transaksi</span>-->
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
            <a href="<?php echo ADMIN_URL.'/report/buy';?>">Laporan Belanja Barang</a>
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
            <a href="<?php echo ADMIN_URL.'/buy';?>">Belanja Barang</a>
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
      <li class="<?php echo ($_SESSION['access']=='admin'? 'has-sub-menu':''); ?> li-menu-event">
        <a href="<?php echo ADMIN_URL.'/check-stock';?>">
          <div class="icon-w">
            <div class="os-icon os-icon-tasks-checked"></div>
          </div>
          <span>Cek Stok</span>
        </a>
        <ul class="sub-menu">
          <li>
            <a href="<?php echo ADMIN_URL.'/check-stock';?>">Cek Stok</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/report/check-stock';?>">Laporan Cek Stok</a>
          </li>
          <li>
            <a href="<?php echo ADMIN_URL.'/report/not-check-stock';?>">Laporan Barang Belum Dicek</a>
          </li>

        </ul>  
      </li>
      <li class="li-menu-event">
        <a href="<?php echo ADMIN_URL.'/events';?>">
          <div class="icon-w">
            <div class="os-icon os-icon-hierarchy-structure-2"></div>
          </div>
          <!--<span>Hari Penting</span>-->

          </a>
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
    <!--------------------
    END - Mobile Menu List
    -------------------->
    <div class="mobile-menu-magic">
      <h4>
        Light Admin
      </h4>
      <p>
        Clean Bootstrap 4 Template
      </p>
      <div class="btn-w">
        <a class="btn btn-white btn-rounded" href="https://themeforest.net/item/light-admin-clean-bootstrap-dashboard-html-template/19760124?ref=Osetin" target="_blank">Purchase Now</a>
      </div>
    </div>
  </div>
</div>


<!-- END MOBILE -->
<div class="content-w">