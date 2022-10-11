<?php
class Temp_report{
	public function daily($data,$store,$action=''){
		$access = (isset($_SESSION['access'])? $_SESSION['access'] :'');
        $temp_h = '<h1 class="title-report">'.$store['store'].'</h1>
                 <p class="address-report">'.$store['address'].'</p>

                 <div class="list-transaction">';
        $temp = '<h2>Penjualan Detail</h2>';                    
                 //print_r($_SESSION);
        $no = 1;
        $old_date = '';

        
        $arr_chasier = array();
        //print_r($data);
        foreach ($data as $key => $dt) {
            //print_r($dt);

            if(!isset($arr_chasier[$dt['id_cashier']]) && empty($arr_chasier[$dt['id_cashier']])){
                $arr_chasier[$dt['id_cashier']] = array();
                $arr_chasier[$dt['id_cashier']]['cashier'] =$dt['cashier'];
                $arr_chasier[$dt['id_cashier']]['total'] = 0;
            }

            $time = strtotime($dt['date']);
            $date = date("Y-m-d", $time);

            if($old_date!=$date){
                $no =1;
                $old_date = $date;
            }

            $th_s = '';
            $td_s = '';

            $mode = ($dt['reseller_mode']=='yes'?'Iya': 'Tidak');

            if($dt['status_transaction']==0) $status_transaction = 'Belum Bayar';
            else if($dt['status_transaction']==1) $status_transaction = 'Down Payment';
            else if($dt['status_transaction']==2) $status_transaction = 'Lunas';

            $date_transaction = date_create($dt['date_transaction']);
            $date = date_create($dt['date']);
            $dob =  date_create($dt['date_of_birth']);

            $gender = ($dt['gender']==0?'Perempuan':'Laki-laki');

            $payments = $dt['payment'];
            $remaining_payment = $dt['total'];

            $temp_payment = '<ul id="list-payment-'.$dt['id_transaction'].'">';
            foreach ($payments as $key => $pay) {
                $remaining_payment = $remaining_payment - $pay['payment'];
                $dtp = date_create($pay['date']);
                $temp_payment .= '<li><span>'.date_format($dtp,'d F Y H:i:s').'</span> - <span>'.number_format($pay['payment']).'</span></li>';
            }
            $temp_payment .= '</ul>';

            $status_package = $dt['status_package'];
            $temp_status = '<ul id="list-status-'.$dt['id_transaction'].'">';
            $arr_status = array(1=>'Beli Bahan', 2 => 'Proses Jarit', 3 => 'Proses Payet', 4 => 'Siap Kirim', 5 => 'Sudah Kirim');
            foreach ($status_package as $key => $sp) {                
                $dsp = date_create($sp['date']);
                $temp_status .= '<li><span>'.date_format($dsp,'d F Y H:i:s').'</span> - <span>'.$arr_status[$sp['status']].' => '.$sp['first_name'].' '.$sp['last_name'].'</span></li>';
            }
            $temp_status .= '</ul>';

            $button_update_payment = '';
            $button_update_status = '';

            if($action =='show-update-payment')
                $button_update_payment = '<button id="payment-'.$dt['id_transaction'].'" class="copy-wa"  data-toggle="modal" data-id="'.$no.'"data-target="#onboardingFormModal" onclick="set_pembayaran(this)" data-id_transaction="'.$dt['id_transaction'].'" data-remaining_payment="'.$remaining_payment.'" >Bayar Sekarang</button>';
            else if($action =='show-update-status')
                $button_update_status = '<button id="package-'.$dt['id_transaction'].'" class="copy-wa"  data-toggle="modal" data-id="'.$no.'"data-target="#onboardingFormModal" onclick="set_ubah_status(this)" data-id_transaction="'.$dt['id_transaction'].'" data-status_package = "'.$dt['transaction_status_package'].'" >Ubah Status</button>';

            $temp .= '<div id="reports-'.$dt['id_transaction'].'" class="item-reports item-reports-monthly item-reports-'.$no.'">
                        <div class="info"  style="margin-top: 20px;margin-bottom: 0px;padding-bottom: 20px;border-bottom: solid 1px;">
                            <table style="width: 1000px;">
                                <tr>
                                    <td style="vertical-align: top;">
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><b>No :</b> <span>'.$no.'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><b>Tanggal Transaksi :</b> <span>'.date_format($date_transaction,'d F Y H:i:s').'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><b>Tanggal Pembayaran :</b> <span>'.date_format($date,'d F Y H:i:s').'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><b>Nama :</b> <span>'.$dt['name'].'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><b>Handphone :</b> <span>'.$dt['handphone'].'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><b>Tanggal Lahir :</b> <span>'.date_format($dob,'d F Y').'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><b>Gender :</b> <span>'.$gender.'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><b>Alamat :</b> <span>'.$dt['address'].'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><b>Kasir :</b> <span>'.$dt['cashier'].'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><b>Reseller :</b> <span>'.$mode.'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><b>Status :</b> <span>'.$status_transaction.'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><button class="copy-wa"  data-toggle="modal" data-target="#exampleModal'.$dt['id_transaction'].'">Salin Pesanan Ke WA</button></p>
                                    </td>
                                    <td style="vertical-align: top;">
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><b>Data Pembayaran :</b> '.$button_update_payment.'</p>
                                        '.$temp_payment.'
                                        <p style="margin-top: 0px;margin-bottom: 0px;"><b>Data Paket :</b>  '.$button_update_status.'</p>
                                        '.$temp_status.'
                                    </td>
                                </tr>
                            </table>
                        </div>




                        <table class="table table-lightborder table-detail-transaction" style="width:100%;">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>MID</th>
                                <th>Barang</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Diskon</th>
                                <th>Jumlah</th>
                                <th>Sub Total</th>
                                '.($access=='admin'? '<th>Keuntungan</th>':'').'
                              </tr>
                            </thead>
                            <tbody>';
            $total = 0;
            $total_profit = 0;                
            foreach ($dt['detail'] as $kd => $detail) {
                   $temp .= '<tr>
                                <td>'.$kd.'</td>
                                <td>'.$detail['id_item'].'</td>
                                <td>'.$detail['mid'].'</td>
                                <td>'.$detail['item'].'</td>
                                <td>'.$detail['category'].'</td>
                                <td>'.number_format($detail['price']).'</td>
                                <td>'.$detail['text_discount'].'</td>
                                <td>'.number_format($detail['qty']).'</td>
                                <td>'.number_format($detail['sub_total']).'</td>
                                '.($access=='admin'? '<td>'.number_format($detail['sub_total_profit']).'</td>':'').'                                
                            </tr>';
                $total = $total + $detail['sub_total'];
                $total_profit = $total_profit + $detail['sub_total_profit'];             
            }  

            $temp_wa = '';

            foreach ($dt['detail'] as $kd => $detail) {
                $temp_wa .= '
                                <span>##'.$detail['item'].'</span><br>
                                <span>- Warna</span><br>
                                <span>- Harga Rp.'.number_format($detail['price']).'</span><br>
                                <span>- Jumlah '.number_format($detail['qty']).'pcs</span><br>
                                <span>- Sub Total Rp.'.number_format($detail['sub_total']).'</span><br>
                                <br>
                            ';
            }



            $temp .= '<!-- Modal -->
                        <div class="modal modal-whatsapp fade" id="exampleModal'.$dt['id_transaction'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Silahkan Di Salin</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body modal-body-order">
                                  <strong>ORDER No '.$no.'. ('.date_format($date_transaction,'d F Y H:i:s').') </strong><br>
                                  '.$temp_wa.'
                                  <strong>Status Pesanan:</strong> '.$status_transaction.'  <br> 
                                  <strong>Data Konsumen:</strong><br>
                                  '.$dt['name'].', '.$dt['handphone'].'
                                  '.$dt['address'].','.$dt['name_sub_district'].','.$dt['name_district'].','.$dt['name_province'].'
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Copy</button>
                              </div>
                            </div>
                          </div>
                        </div>';





                        


            $manual_discount = $dt['manual_discount'];
            $total_text = number_format($total);
            $total_profit_text = number_format($total_profit);
            $arr_chasier[$dt['id_cashier']]['total'] = $arr_chasier[$dt['id_cashier']]['total'] + $total;

            $text_discount_manual = '';
            if(!empty($manual_discount)){
                $new_total = $total - $manual_discount;
                $new_total = number_format($new_total);
                $total_text = '<p><strike>'.$total_text.'</strike></p><p>'.$new_total.'</p>';

                $new_total_profit = $total_profit - $manual_discount;
                $new_total_profit = number_format($new_total_profit);
                $total_profit_text = '<p><strike>'.$total_profit_text.'</strike></p><p>'.$new_total_profit.'</p>';


                $text_discount_manual = 'Discount: '.number_format($manual_discount);
            }

            $temp .=
                        '</tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th><!--<p>'.$text_discount_manual.'</p><p>&nbsp;</p>--></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>'.$total_text.'</th>
                                '.($access=='admin'? '<th>'.$total_profit_text.'</th>':'').'
                            </tr>
                        </tfoot>
                    </table>
                </div>
                        ';

            $no++;
        }
       //print_r($arr_chasier);

        $temp .= '</div>';


        $header_temp ='

        <table class="table table-lightborder table-detail-transaction table-chasier" style="width:100%;margin-top:70px;">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Penjualan</th>
                              </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($arr_chasier as $key => $chasier) {
            $header_temp .= '<tr>
                                <td>'.$no.'</td>
                                <td>'.$chasier['cashier'].'</td>
                                <td>'.number_format($chasier['total']).'</td>
                            </tr>';
            $no++;                
        }

        $header_temp .= '<tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>';

        $temp = $temp_h.$header_temp.$temp;

        return $this->sanitize_output($temp);
	}

	public function style_report_daily(){
        $style =    '<style>
                        body{font-family:Tahoma; font-size: 14px}
                        .title-report{text-align: center; line-height:120%; margin:0px 0px 10px 0px;padding:0px}
                        .address-report{text-align: center;margin:0px 0px 30px 0px; padding:0px}
                        .info{font-size:12px; padding:0px 0px 3px 0px;margin:0px;}
                        table {border-collapse: collapse;}                        
                        table th{text-align:left;}
                        table tbody td{border-top: 1px solid rgba(83, 101, 140, 0.08);padding:3px 8px 3px 0;vertical-align: top;}
                        table tbody td{text-align:left;}
                        table tfoot tr th {border-top: solid 1px rgba(0, 0, 0, 0.1) !important; font-size: 16px;font-weight: 500;}
                        
                        table thead tr td:first-child,
                        table tbody tr td:first-child,
                        table tfoot tr td:first-child {width: 20px;}
                        
                        table thead tr td:nth-child(2),
                        table tbody tr td:nth-child(2),
                        table tfoot tr td:nth-child(2) {width: 80px;}
                        
                        table thead tr td:nth-child(3),
                        table tbody tr td:nth-child(3),
                        table tfoot tr td:nth-child(3) {width: 40px;}

                        table thead tr td:nth-child(4),
                        table tbody tr td:nth-child(4),
                        table tfoot tr td:nth-child(4) {width: 120px;}

                        .item-reports-1 .info {border-top: solid 2px rgba(0,0,0,0.1);padding-top: 120px;margin-top:40px !important;}
                        .item-reports-1:nth-child(1) .info {border-top: none;padding-top: 0;}
                    </style>';

        return $style;
    }



    public function style_report_monthly(){
        $style =    '<style>
                        body{font-family:Tahoma; font-size: 14px}
                        .title-report{text-align: center; line-height:120%; margin:0px 0px 10px 0px;padding:0px}
                        .address-report{text-align: center;margin:0px 0px 30px 0px; padding:0px}
                        .info{font-size:12px; padding:0px 0px 3px 0px;margin:0px;}
                        table {border-collapse: collapse;width:100%}                        
                        table th{text-align:left;}
                        table tbody td{border-top: 1px solid rgba(83, 101, 140, 0.08);padding:3px 8px 3px 0;}
                        table tbody td{text-align:left;}
                        table tfoot tr th {border-top: solid 1px rgba(0, 0, 0, 0.1) !important; font-size: 16px;font-weight: 500;}
                        
                        table thead tr td:first-child,
                        table tbody tr td:first-child,
                        table tfoot tr td:first-child {width: 20px;}
                    </style>';

        return $style;
    }


    public function monthly($data,$store){
        $access = (isset($_SESSION['access'])? $_SESSION['access'] :'');
        $temp = '<h1 class="title-report">'.$store['store'].'</h1>
                 <p class="address-report">'.$store['address'].'</p>

                 <div class="list-transaction">';

        //print_r($data);return;
        $no = 1;
        foreach ($data as $key => $dt) {
            //print_r($dt);
            $temp .= ($temp!=''?'<br><br>':'');

            $temp .= '<div class="item-reports item-reports-'.$no.'">
                        <div class="info">
                            <p>Bulan: <span>'.$key.'</span></p>
                        </div>
                        <table class="table table-lightborder table-detail-transaction">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th style="width: 140px;">Tanggal</th>
                                <th>Penjualan</th>
                                '.($access=='admin'? '<th>Pokok</th>':'').'
                                '.($access=='admin'? '<th>Keuntungan</th>':'').'
                                <th>Hari Penting</th>
                              </tr>
                            </thead>
                            <tbody>';

            $total = 0;
            $total_profit = 0; 
            $total_capital = 0;

            $n = 1;
            foreach ($dt as $key => $value) {
                $temp .= '<tr>
                                <td>'.$n.'</td>
                                <td>'.$key.'</td>
                                <td>'.number_format($value['total']).'</td>
                                '.($access=='admin'? '<td>'.number_format($value['total_capital']).'</td>':'').'
                                '.($access=='admin'? '<td>'.number_format($value['total_profit']).'</td>':'').'
                                <td>'.$value['events'].'</td>
                            </tr>';
                $total = $total + $value['total'];
                $total_profit = $total_profit + $value['total_profit'];     
                $total_capital = $total_capital + $value['total_capital'];
                $n++;
            }

            $temp .=
                            '</tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th>'.number_format($total).'</th>
                                    '.($access=='admin'? '<th>'.number_format($total_capital).'</th>':'').'
                                    '.($access=='admin'? '<th>'.number_format($total_profit).'</th>':'').'
                                    '.($access=='admin'? '<th></th>':'').'
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                            ';
            $no++;
        }

        $temp .= '</div>';
        return $this->sanitize_output($temp);                               
        
    }


	public function yearly($data,$store){
        $access = (isset($_SESSION['access'])? $_SESSION['access'] :'');
        $temp = '<h1 class="title-report">'.$store['store'].'</h1>
                 <p class="address-report">'.$store['address'].'</p>

                 <div class="list-transaction">';
        $no = 1;
        foreach ($data as $key => $dt) {
            $temp .= '<div class="item-reports item-reports-'.$no.'">
                        <div class="info">
                            <p>Tahun: <span>'.$key.'</span></p>
                        </div>
                        <table class="table table-lightborder table-detail-transaction">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Bulan</th>
                                <th>Penjualan</th>
                                '.($access=='admin'? '<th>Keuntungan</th>':'').'
                              </tr>
                            </thead>
                            <tbody>';

            $total = 0;
            $total_profit = 0; 

            $n = 1;
            foreach ($dt as $key => $value) {
                $temp .= '<tr>
                                <td>'.$n.'</td>
                                <td>'.$key.'</td>
                                <td>'.number_format($value['total']).'</td>
                                '.($access=='admin'? '<td>'.number_format($value['total_profit']).'</td>':'').'

                                
                            </tr>';
                $total = $total + $value['total'];
                $total_profit = $total_profit + $value['total_profit'];     
                $n++;
            }

            $temp .=
                            '</tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th>'.number_format($total).'</th>
                                    '.($access=='admin'? '<th>'.number_format($total_profit).'</th>':'').'
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                            ';
            $no++;
        }

        $temp .= '</div>';
        return $this->sanitize_output($temp);                
        
    }


    public function buy_item($data,$store){
        $access = (isset($_SESSION['access'])? $_SESSION['access'] :'');
        $temp = '<h1 class="title-report">'.$store['store'].'</h1>
                 <p class="address-report">'.$store['address'].'</p>

                 <div class="list-transaction">';

                 //print_r($_SESSION);
        $no = 1;
        $old_date = '';
        foreach ($data as $key => $dt) {
            $time = strtotime($dt['date']);
            $date = date("Y-m-d", $time);

            if($old_date!=$date){
                $no =1;
                $old_date = $date;
            }

            $th_s = '';
            $td_s = '';

            $temp .= '<div class="item-reports item-reports-'.$no.'">
                        <div class="info"  style="margin-top: 20px;margin-bottom: 0px;">
                            <p style="margin-top: 0px;margin-bottom: 0px;">No: <span>'.$no.'</span></p>
                            <p style="margin-top: 0px;margin-bottom: 0px;">Tanggal: <span>'.$dt['date'].'</span></p>
                            <p style="margin-top: 0px;margin-bottom: 0px;">User: <span>'.$dt['edited'].'</span></p>
                        </div>
                        <table class="table table-lightborder table-detail-transaction" style="width:100%;">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>MID</th>
                                <th>Barang</th>
                                <th>Kategori</th>
                                
                                <th>Harga Pokok</th>
                                <th>Jumlah</th>
                                <th>Harga Jual</th>
                                <th>Sub Total</th>
                              </tr>
                            </thead>
                            <tbody>';
            $total = 0;
            $total_profit = 0;                
            foreach ($dt['detail'] as $kd => $detail) {
                   $temp .= '<tr>
                                <td>'.$kd.'</td>
                                <td>'.$detail['id_item'].'</td>
                                <td>'.$detail['mid'].'</td>
                                <td>'.$detail['item'].'</td>
                                <td>'.$detail['category'].'</td>
                                
                                <td>'.number_format($detail['capital_price']).'</td>
                                <td>'.number_format($detail['qty']).'</td>
                                <td>'.number_format($detail['price']).'</td>
                                <td>'.number_format($detail['sub_total']).'</td>                                
                            </tr>';

                    //$total +=   $detail['qty'] *  $detail['capital_price'];     
            }  

            $temp .=
                        '</tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>'.number_format($dt['total']).'</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                        ';

            $no++;
        }

        $temp .= '</div>';

        return $this->sanitize_output($temp);
    }




    public function check_stock($data,$store){
        $access = (isset($_SESSION['access'])? $_SESSION['access'] :'');
        $temp = '<h1 class="title-report">'.$store['store'].'</h1>
                 <p class="address-report">'.$store['address'].'</p>

                 <div class="list-transaction">';

                 //print_r($_SESSION);
        $no = 1;
        $old_date = '';
        foreach ($data as $key => $dt) {
            $time = strtotime($dt['date']);
            $date = date("Y-m-d", $time);

            if($old_date!=$date){
                $no =1;
                $old_date = $date;
            }

            $th_s = '';
            $td_s = '';

            $temp .= '<div class="item-reports item-reports-'.$no.'">
                        <table class="" style="width:100%;margin-top: 20px;margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <td style="width:50%;border:none;border-collapse: collapse;">
                                        <p style="margin-top: 0px;margin-bottom: 0px;">No: <span>'.$no.'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;">Tanggal: <span>'.$dt['date'].'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;">User: <span>'.$dt['edited'].'</span></p>
                                    </td>
                                    <td style="width:50%;border:none;border-collapse: collapse;">
                                        <p style="margin-top: 0px;margin-bottom: 0px;">Total Kehilangan: <span>'.number_format($dt['total_minus']).'</span></p>
                                        <p style="margin-top: 0px;margin-bottom: 0px;">Total Kelebihan: <span>'.number_format($dt['total_plus']).'</span></p>
                                    </td>
                                <tr>
                            </tbody>
                        </table>
                        <table class="table table-lightborder table-detail-transaction" style="width:100%;">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>MID</th>
                                <th>Barang</th>
                                <th>Kategori</th>
                                
                                <th>Harga</th>    
                                <th>Harga Pokok</th>
                                
                                <th style="text-align:center;">Jumlah Komputer</th>
                                <th style="text-align:center;">Jumlah Kenyataan</th>
                                <th style="text-align:center;">Margin</th>


                                <th style="padding: 0 8px;">Hilang</th>
                                <th style="padding: 0 8px;">Kelebihan</th>
                              </tr>
                            </thead>
                            <tbody>';
            $total = 0;
            $total_profit = 0;       

            $s_red      = 'style="background: #E91E63;color: #383333;text-align:center;"';
            $s_yellow   = 'style="background: #fff147;color: #383333;text-align:center;"';

            foreach ($dt['detail'] as $kd => $detail) { 
                    $sr = 'style="text-align:center;"';

                    if($detail['margin_qty'] > 0){
                        $sr = $s_yellow;
                    }else if($detail['margin_qty']){
                        $sr = $s_red;
                    }

                    $temp .= '<tr>
                                <td>'.$kd.'</td>
                                <td>'.$detail['id_item'].'</td>
                                <td>'.$detail['mid'].'</td>
                                <td>'.$detail['item'].'</td>
                                <td>'.$detail['category'].'</td>
                                
                                <td>'.number_format($detail['price']).'</td>
                                <td>'.number_format($detail['capital_price']).'</td>
                                <td style="text-align:center;">'.number_format($detail['qty_comp']).'</td>
                                <td style="text-align:center;">'.number_format($detail['qty_store']).'</td>
                                <td '.$sr.'>'.number_format($detail['margin_qty']).'</td>


                                <td style="padding: 0 8px;">'.number_format($detail['minus_stock']).'</td>
                                <td style="padding: 0 8px;">'.number_format($detail['plus_stock']).'</td>
                            </tr>';

                    //$total +=   $detail['qty'] *  $detail['capital_price'];     
            }  

            $temp .=
                        '</tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>                                
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>

                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>

                                
                                <th style="padding: 0 8px;">'.number_format($dt['total_minus']).'</th>
                                <th style="padding: 0 8px;">'.number_format($dt['total_plus']).'</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                        ';

            $no++;
        }

        $temp .= '</div>';

        return $this->sanitize_output($temp);
    }



    public function style_report_item(){
        $style =    '<style>
                        body{font-family:Tahoma; font-size: 14px}
                        .title-report{text-align: center; line-height:120%; margin:0px 0px 10px 0px;padding:0px}
                        .address-report{text-align: center;margin:0px 0px 30px 0px; padding:0px}
                        .info{font-size:12px; padding:0px 0px 3px 0px;margin:0px;}
                        table {border-collapse: collapse;width:100%; font-size: 12px}                        
                        table th{text-align:left;}
                        table tbody td{border-top: 1px solid rgba(83, 101, 140, 0.08);padding:3px 8px 3px 0;}
                        table tbody td{text-align:left;}
                        table tfoot tr th {border-top: solid 1px rgba(0, 0, 0, 0.1) !important; font-size: 16px;font-weight: 500;}
                        
                        table thead tr td:first-child,
                        table tbody tr td:first-child,
                        table tfoot tr td:first-child {width: 20px;}


                        table thead tr th:nth-child(2),
                        table tbody tr th:nth-child(2),
                        table tfoot tr td:nth-child(2) {width: 100px;}

                        table thead tr th:nth-child(5),
                        table tbody tr th:nth-child(5),
                        table tfoot tr td:nth-child(5) {width: 180px;}

                        table thead tr th, table tbody tr td{padding: 0 5px;}

                        
                    </style>';

        return $style;
    }


    public function item_record($data,$store,$sdate,$edate){
        $temp = '<h1 class="title-report">'.$store['store'].'</h1>
                 <p class="address-report">'.$store['address'].'</p>


                 <br>
                 <h4>Range: '.date('F Y',strtotime($sdate)).' - '.date('F Y',strtotime($edate)).'</h4>
                 <br>
                 <div class="list-transaction">';
        $no = 1;
        /*$th = '<tr>
                    <th>No</th>
                    <th>Tgl</th>
                    <th>Kode</th>

                    <th>MID</th>
                    <th>Barang</th>
                    <th>Hrg Pokok</th>
                    <th>Hrg Reseller</th>
                    <th>Hrg Jual</th>
                    <th style="text-align:center;">Stok</th>
                    <th>Toko</th>
                    <th>Status</th>


                    <th>MID(Baru)</th>
                    <th>Nama(Baru)</th>
                    <th>Hrg Pokok(Baru)</th>
                    <th>Hrg Reseller(Baru)</th>
                    <th>Hrg Jual(Baru)</th>
                    <th style="text-align:center;">Stok(Baru)</th>
                    <th>Toko(Baru)</th>
                    <th>Status(Baru)</th>

                    <th>Edited</th>
                  </tr>';*/


        $th = '<tr>
                    <th>No</th>
                    <th>Tgl</th>
                    <th>Kode</th>
                    <th>MID</th>
                    <th>Barang</th>

                    <th>Hrg Pokok</th>
                    <th>Hrg Reseller</th>
                    <th>Hrg Jual</th>
                    <th style="text-align:center;">Stok</th>
                    <th>Toko</th>
                    <th>Status</th>

                    <th>Edited</th>
                  </tr>';          

        $temp .= '<div class="item-reports item-reports-items item-reports-'.$no.'">
                        <table class="table table-lightborder table-detail-transaction">
                            <thead>'.$th.'</thead>
                            <tbody>';
        $n = 1;                                
        $style_change = 'style="background: #a7daa7;color: #383333;"';
        foreach ($data as $key => $dt) {
            $date = date("d F Y h:i:s", strtotime($dt['date']));

            $temp .=   '<tr>
                            <td>'.$n.'</td>
                            <td style="width: 150px;">'.$date.'</td>
                            <td>'.$dt['id_item'].'</td>

                            <td '.($dt['mid_new']!=$dt['mid_old']? $style_change:'').'>
                            	'.$dt['mid_old'].''.($dt['mid_new']!=$dt['mid_old']? ' => '.$dt['mid_new']:'').'
                            </td>

                            <td '.($dt['name_new']!=$dt['name_old']? $style_change:'').'>
                            	'.$dt['name_old'].''.($dt['name_new']!=$dt['name_old']? ' => '.$dt['name_new']:'').'
                            </td>

                            <td '.($dt['capital_price_new']!=$dt['capital_price_old']? $style_change:'').'>
                            	'.number_format($dt['capital_price_old']).''.($dt['capital_price_new']!=$dt['capital_price_old']? ' => '.number_format($dt['capital_price_old']):'').'
                            </td>

                            <td '.($dt['reseller_price_new']!=$dt['reseller_price_old']? $style_change:'').'>
                            	'.number_format($dt['reseller_price_old']).''.($dt['reseller_price_new']!=$dt['reseller_price_old']? ' => '.number_format($dt['reseller_price_new']):'').'
                            </td>
                            <td '.($dt['price_new']!=$dt['price_old']? $style_change:'').'>
                            	'.number_format($dt['price_old']).''.($dt['price_new']!=$dt['price_old']? ' => '.number_format($dt['price_new']):'').'
                            </td>

                            <td '.($dt['stock_new']!=$dt['stock_old']? 'style="background:#a7daa7; color: #909090; text-align:center;"':'style="text-align:center;"').'>
                            	'.number_format($dt['stock_old']).''.($dt['stock_new']!=$dt['stock_old']? ' => '.number_format($dt['stock_new']) : '').'
                            </td>

                            <td '.($dt['store_new']!=$dt['store_old']? $style_change:'').'>
                            	'.$dt['store_old'].''.($dt['store_new']!=$dt['store_old']? ' => '.$dt['store_new']:'').'
                            </td>  
                            <td '.($dt['state_new']!=$dt['state_old']? $style_change:'').'>
                            	'.ucfirst($dt['state_old']).''.($dt['state_new']!=$dt['state_old']? ' => '.ucfirst($dt['state_new']):'').'
                            </td>    

                            <td>'.$dt['first_name'].' '.$dt['last_name'].'</td>   
                        </tr>        
                        ';





            /*$temp .= '<tr>
                                <td>'.$n.'</td>
                                <td style="width: 150px;">'.$date.'</td>
                                <td>'.$dt['id_item'].'</td>
                                
                                
                                <td>'.$dt['mid_old'].'</td>
                                <td>'.$dt['name_old'].'</td>
                                <td>'.number_format($dt['capital_price_old']).'</td>
                                <td>'.number_format($dt['reseller_price_old']).'</td>
                                <td>'.number_format($dt['price_old']).'</td>
                                <td style="text-align:center;">'.number_format($dt['stock_old']).'</td>
                                <td>'.$dt['store_old'].'</td>
                                <td>'.ucfirst($dt['state_old']).'</td>


                                <td '.($dt['mid_new']!=$dt['mid_old']? $style_change:'').'>'.$dt['mid_new'].'</td>
                                <td '.($dt['name_new']!=$dt['name_old']? $style_change:'').'>'.$dt['name_new'].'</td>
                                <td '.($dt['capital_price_new']!=$dt['capital_price_old']? $style_change:'').'>'.number_format($dt['capital_price_new']).'</td>
                                <td '.($dt['reseller_price_new']!=$dt['reseller_price_old']? $style_change:'').'>'.number_format($dt['reseller_price_new']).'</td>
                                <td '.($dt['price_new']!=$dt['price_old']? $style_change:'').'>'.number_format($dt['price_new']).'</td>
                                <td '.($dt['stock_new']!=$dt['stock_old']? 'style="background:#a7daa7; color: #909090; text-align:center;"':'style="text-align:center;"').'>'.number_format($dt['stock_new']).'</td>
                                

                                <td '.($dt['store_new']!=$dt['store_old']? $style_change:'').'>'.$dt['store_new'].'</td>  
                                <td '.($dt['state_new']!=$dt['state_old']? $style_change:'').'>'.ucfirst($dt['state_new']).'</td>    

                                <td>'.$dt['first_name'].' '.$dt['last_name'].'</td>    
                            </tr>';*/
                $n++;
        }

        $temp .=
                        '</tbody>
                        <!--<tfoot>'.$th.'</tfoot>-->
                    </table>
                </div>';

        $temp .= '</div>';
        return $this->sanitize_output($temp);              
        
    }



    public function bestseller($data,$store, $start, $end, $events){
        //print_r($data);
        $access = (isset($_SESSION['access'])? $_SESSION['access'] :'');
        $str = date_create($start);
        $end = date_create($end);



        $text_event = '';
        foreach ($events as $key => $value) {
            $text_event .= ($text_event!=''? ', ':'').$value['event'].'('.date("d F Y", strtotime($value['date'])).')';
        }


        $temp = '<h1 class="title-report">'.$store['store'].'</h1>
                 <p class="address-report">'.$store['address'].'</p>
                 <br>
                 <h3>Barang Terlaris </h3>
                 <p>Tanggal : '.date_format($str,'d F Y').' - '.date_format($end,'d F Y').'</p>
                 <p>Hari Penting : '.$text_event.'</p>
                 <div class="list-transaction">';
        $no = 1;
        $temp .= '<div class="item-reports item-reports-'.$no.'">
                        <table class="table table-lightborder table-detail-transaction">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>MID</th>
                                <th>Barang</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Terjual</th>
                                <th>Profit</th>
                              </tr>
                            </thead>
                            <tbody>';


        foreach ($data as $key => $dt) {

            $css_p = 'p-green';
            if($dt['profit']>33.3) $css_p = 'p-silver';
            if($dt['profit']>66.6) $css_p = 'p-gold';


            $temp .= '<tr>
                            <td>'.$no.'</td>
                            <td>'.$dt['id_item'].'</td>
                            <td>'.$dt['mid'].'</td>
                            <td>'.$dt['item'].'</td>
                            <td>'.$dt['category'].'</td>
                            <td>'.number_format($dt['price']).'</td>
                            <td>'.number_format($dt['sell']).'</td>
                            <td class="'.$css_p.'">'.number_format($dt['profit'],2).'%</td>
                        </tr>';
            $no++;
        }

        $temp .=
                            '</tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>MID</th>
                                    <th>Barang</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Terjual</th>
                                    <th>Profit</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                            ';

        $temp .= '</div>';
        return $this->sanitize_output($temp);                               
        
    }


    public function not_check_stock($data,$store, $start, $end){
        //print_r($data);
        $str = date_create($start);
        $end = date_create($end);       

        $temp = '<h1 class="title-report">'.$store['store'].'</h1>
                 <p class="address-report">'.$store['address'].'</p>
                 <br>
                 <h3>Barang Belum Dicek </h3>
                 <p>Tanggal : '.date_format($str,'d F Y').' - '.date_format($end,'d F Y').'</p>
                 <div class="list-transaction">';
        $no = 1;
        $temp .= '<div class="item-reports item-reports-'.$no.'">
                        <table class="table table-lightborder table-detail-transaction">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>MID</th>
                                <th>Barang</th>
                                <th>Kategori</th>
                                <th>Harga Pokok</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Sub Total</th>
                              </tr>
                            </thead>
                            <tbody>';

        $grand_total = 0;                       
        foreach ($data as $key => $dt) {
            $temp .= '<tr>
                            <td>'.$no.'</td>
                            <td>'.$dt['id_item'].'</td>
                            <td>'.$dt['mid'].'</td>
                            <td>'.$dt['item'].'</td>
                            <td>'.$dt['category'].'</td>

                            <td>'.number_format($dt['capital_price']).'</td>    
                            <td>'.number_format($dt['qty']).'</td>
                            <td>'.number_format($dt['price']).'</td>
                            <td>'.number_format($dt['sub_total']).'</td>
                        </tr>';
            $grand_total += $dt['sub_total'];            
            $no++;
        }

        $temp .=
                            '</tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>'.number_format($grand_total).'</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                            ';

        $temp .= '</div>';
        return $this->sanitize_output($temp);                               
        
    }



	function sanitize_output($buffer) {

        $search = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );

        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );

        $buffer = preg_replace($search, $replace, $buffer);

        return $buffer;
    }
}
?>