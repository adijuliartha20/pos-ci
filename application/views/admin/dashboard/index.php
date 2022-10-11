<div class="content-i">
  <div class="content-box">
    <div class="element-wrapper">
      <h6 class="element-header">
        Penjualan
      </h6>
      <div class="element-box">
        <div class="os-tabs-w">
          <div class="os-tabs-controls">
            <ul class="nav nav-tabs smaller">
              <!--<li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab_overview">Overview</a>
              </li>-->
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab_month">Bulanan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab_year">Tahunan</a>
              </li>
            </ul>
           
          </div>
          <div class="tab-content">
            <div class="error hide" id="error_info"></div> 
            <div class="form-desc">
                <div id="alert-form" class="alert-form clearfix">
                  <div id="alert" class="alert alert-success" role="alert">
                    <div id="middle-alert" class="middle-alert"></div>
                  </div>  
                </div>
            </div>

            <div class="tab-pane active" id="tab_month">
              <div class="el-tablo">
                <form id="form-report-monthly" class="form-inline form-desc" action="<?php echo ADMIN_URL.'/dashboard/get-monthly-sales'; ?>" >
                  <select class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" name="month">
                    <?php
                  $curr_value = date('m', time());
                  foreach ($months as $key => $month) {
                    ?>
                      <option value="<?php echo $key; ?>" <?php echo ($key==$curr_value?'selected':''); ?> ><?php echo $month; ?></option>
                    <?php
                  }
                ?>  
                  </select>

                  <select class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" name="year">
                    <?php
                  $curr_year = date('Y', time());
                  foreach ($years as $key => $year) {
                    ?>
                      <option value="<?php echo $key; ?>" <?php echo ($key==$curr_year?'selected':''); ?> ><?php echo $year; ?></option>
                    <?php
                  }
                ?>  
                  </select>

                  
                  <select class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" id="id_store" name="id_store" data-error="Please select Store" placeholder="Select Store" required="required" >
                <?php
                  //$curr_value = (isset($data['id_store']) && !empty($data['id_store']) ? $data['id_store'] :'2');
                  $arr = $store;
                  foreach ($arr as $key => $dt) {
                    $id_curr = $dt['id_store'];
                    $val_curr = $dt['store'];
                    ?>
                      <option value="<?php echo $id_curr; ?>" <?php echo ($id_curr==$curr_value?'selected':''); ?> ><?php echo $val_curr; ?></option>
                    <?php
                  }
                ?>
                <input type="hidden" name="div" value="lineChartMonth">
              </select>
              <button class="mr-2 mb-2 btn btn-outline-primary btn-add" type="submit"  id="btn-month">Tampilkan</button>
              </form>
                <!--<div class="label">Unique Visitors</div>
                <div class="value">12,537</div>-->
              </div>
              <div class="el-chart-w">
                <canvas height="150px" id="lineChartMonth" width="600px"></canvas>
              </div>
            </div> <!-- END TAB MONTH -->

            <div class="tab-pane" id="tab_year">
              <div class="el-tablo">
                <form id="form-report-yearly" class="form-inline form-desc" action="<?php echo ADMIN_URL.'/dashboard/get-yearly-sales'; ?>">
                      <span class="lbl-form-inline">Dari</span>
                      <select class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" name="start-year">
                        <?php
                      $curr_year = date('Y', time());
                      foreach ($years as $key => $year) {
                        ?>
                          <option value="<?php echo $key; ?>" <?php echo ($key==$curr_year?'selected':''); ?> ><?php echo $year; ?></option>
                        <?php
                      }
                    ?>  
                      </select>

                      <span class="lbl-form-inline">Sampai</span>
                      <select class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" name="end-year">
                        <?php
                      $curr_year = date('Y', time());
                      foreach ($years as $key => $year) {
                        ?>
                          <option value="<?php echo $key; ?>" <?php echo ($key==$curr_year?'selected':''); ?> ><?php echo $year; ?></option>
                        <?php
                      }
                    ?>  
                      </select>


                      <span class="lbl-form-inline">Toko</span>
                      <select class="single-daterange form-control mb-2 mr-sm-2 mb-sm-0" id="id_store" name="id_store" data-error="Please select Store" placeholder="Select Store" required="required" >
                    <?php
                      $curr_value = (isset($data['id_store']) && !empty($data['id_store']) ? $data['id_store'] :'');
                      $arr = $store;
                      foreach ($arr as $key => $dt) {
                        $id_curr = $dt['id_store'];
                        $val_curr = $dt['store'];
                        ?>
                          <option value="<?php echo $id_curr; ?>" <?php echo ($id_curr==$curr_value?'selected':''); ?> ><?php echo $val_curr; ?></option>
                        <?php
                      }
                    ?>
                  </select>
                  <input type="hidden" name="div" value="lineChartYear">
                  <button class="mr-2 mb-2 btn btn-outline-primary btn-add" type="submit" id="btn-year">Tampilkan</button>
                </form>
              </div>
              <div class="el-chart-w">
                <canvas height="150px" id="lineChartYear" width="600px"></canvas>
              </div>
            </div> 
            <!-- END TAB YEAR -->

            </div>
            <div class="tab-pane" id="tab_conversion"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


