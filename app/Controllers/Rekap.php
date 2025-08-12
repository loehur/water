<?php

class Rekap extends Controller
{
   public $book;
   public function __construct()
   {
      $this->session_cek(1);
      $this->operating_data();
      $this->book = $this->book;
   }

   public function i($mode)
   {
      $dataTanggal = [];
      $data_main = [];
      $gaji = [];
      $whereCabang = "";
      $kas_tarik = 0;

      switch ($mode) {
         case 1:
            $layout = ['title' => 'Rekap Cabang Harian'];
            $viewData = 'Rekap/main';

            if (isset($_POST['m'])) {
               $today = $this->book . "-" . $_POST['m'] . "-" . $_POST['d'];
               $dataTanggal = array('tanggal' => $_POST['d'], 'bulan' => $_POST['m'], 'tahun' => $this->book);
            } else {
               $today = date('Y-m-d');
               $dataTanggal = array('tanggal' => date('d'), 'bulan' => date('m'), 'tahun' => date('Y'));
            }

            $whereCabang = $this->wCabang . " AND ";
            break;
         case 2:
            $layout = ['title' => 'Rekap Cabang Bulanan'];
            $viewData = 'Rekap/main';

            if (isset($_POST['m'])) {
               $today = $this->book . "-" . $_POST['m'];
               $dataTanggal = array('bulan' => $_POST['m'], 'tahun' => $this->book);
            } else {
               $today = date('Y-m');
               $dataTanggal = array('bulan' => date('m'), 'tahun' => date('Y'));
            }

            $whereCabang = $this->wCabang . " AND ";
            break;
         case 3:
            $layout = ['title' => 'Rekap Total Bulanan', 'vLaundry' => true];
            $viewData = 'Rekap/main';

            if (isset($_POST['m'])) {
               $today = $this->book . "-" . $_POST['m'];
               $dataTanggal = array('bulan' => $_POST['m'], 'tahun' => $this->book);
            } else {
               $today = date('Y-m');
               $dataTanggal = array('bulan' => date('m'), 'tahun' => date('Y'));
            }

            $whereCabang = '';
            break;
         case 4:
            $layout = ['title' => 'Rekap Total Harian', 'vLaundry' => true];
            $viewData = 'Rekap/main';

            if (isset($_POST['m'])) {
               $today = $this->book . "-" . $_POST['m'] . "-" . $_POST['d'];
               $dataTanggal = array('tanggal' => $_POST['d'], 'bulan' => $_POST['m'], 'tahun' => $this->book);
            } else {
               $today = date('Y-m-d');
               $dataTanggal = array('tanggal' => date('d'), 'bulan' => date('m'), 'tahun' => date('Y'));
            }

            $whereCabang = '';
            break;
      }

      //STATISTIC
      $total_jual = [];
      $data_ref = $this->db($this->book)->get_where('ref', "tgL LIKE '" . $today . "%'", 'id');

      $cols = "SUM((harga * qty) - diskon) as total";

      $refs = "";
      foreach ($data_ref as $key => $d) {
         $refs .= $key . ",";
      }
      $refs = rtrim($refs, ',');
      $where = "ref IN (" . $refs . ")";
      $total_jual = 0;
      $get = $this->db($this->book)->get_cols_where('pesanan', $cols, $where, 0);
      if (isset($get['total'])) {
         $total_jual = $get['total'];
      }

      //PENDAPATAN
      $cols = "sum(jumlah) as total, metode_mutasi";
      $where = $whereCabang . "jenis_transaksi = 1 AND status_mutasi <> 2 AND insertTime LIKE '%" . $today . "%' GROUP BY metode_mutasi";
      $where_umum = $where;
      $kas = 0;
      $kas = $this->db($this->book)->get_cols_where('kas', $cols, $where_umum, 1, 'metode_mutasi');

      //PENGELUARAN
      $cols = "note_primary, sum(jumlah) as total";
      $where = $whereCabang . "jenis_transaksi = 4 AND status_mutasi <> 2 AND insertTime LIKE '%" . $today . "%' GROUP BY note_primary";
      $where_keluar =  $whereCabang . "jenis_transaksi = 4 AND status_mutasi <> 3 AND insertTime LIKE '%" . $today . "%'";
      $kas_keluar = $this->db($this->book)->get_cols_where('kas', $cols, $where, 1);

      //PENGELUARAN PREPAID/POSTPAID
      $col = "price";
      $where_prepost = $whereCabang . "tr_status = 1 AND insertTime LIKE '" . $today . "%'";
      $cost_pre = $this->db(0)->sum_col_where('prepaid', $col, $where_prepost);
      $cost_post = $this->db(0)->sum_col_where('postpaid', $col, $where_prepost);
      $prepost_cost = $cost_pre + $cost_post;

      //PENARIKAN
      $cols = "note_primary, sum(jumlah) as total";
      $where = $whereCabang . "jenis_transaksi = 2 AND status_mutasi <> 2 AND insertTime LIKE '%" . $today . "%' GROUP BY note_primary";
      $where_tarik =  $whereCabang . "jenis_transaksi = 2 AND status_mutasi <> 3 AND insertTime LIKE '%" . $today . "%'";
      $kas_tarik = $this->db($this->book)->get_cols_where('kas', $cols, $where, 1);

      $this->view('layout', $layout);
      $this->view($viewData, [
         'total_jual' => $total_jual,
         'data_main' => $data_main,
         'dataTanggal' => $dataTanggal,
         'kasLaundry' => $kas,
         'whereUmum' => $where_umum,
         'whereKeluar' => $where_keluar,
         'whereTarik' => $where_tarik,
         'kas_keluar' => $kas_keluar,
         'kas_tarik' => $kas_tarik,
         'prepost_cost' => $prepost_cost,
      ]);
   }

   function detail($where, $mode = 1)
   {
      $viewData = 'Rekap/detail';
      $layout = ['title' => 'Bulanan Cabang - Rekap'];
      $this->view('layout', ['data_operasi' => $layout]);

      $data = [];
      $where =  base64_decode($where);
      $data = $this->db($this->book)->get_where('kas', $where);

      $this->view($viewData, [
         'data' => $data,
         'mode' => $mode
      ]);
   }
}
