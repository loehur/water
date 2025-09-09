<?php

class Riwayat_Bayar extends Controller
{
   public function __construct()
   {
      $this->session_cek();
      $this->operating_data();
   }

   public function index()
   {
      $layout = ['title' => 'Riwayat Bayar'];
      $data['bayar'] = $this->db($this->book)->get_where('kas', "(jenis_transaksi = 1 OR jenis_transaksi = 4) AND insertTime LIKE '" . date("Y-m-d") . "%' AND metode_mutasi = 1 AND status_mutasi <> 2 AND id_cabang = '" . $this->id_cabang . "'");
      $data['total'] = $this->db($this->book)->sum_col_where('kas', "jumlah", "jenis_mutasi = 1 AND insertTime LIKE '" . date("Y-m-d") . "%' AND metode_mutasi = 1 AND status_mutasi <> 2 AND id_cabang = '" . $this->id_cabang . "'");
      $data['keluar'] = $this->db($this->book)->sum_col_where('kas', "jumlah", "jenis_mutasi = 2 AND insertTime LIKE '" . date("Y-m-d") . "%' AND metode_mutasi = 1 AND status_mutasi <> 2 AND id_cabang = '" . $this->id_cabang . "'");
      $data['pelanggan'] = $this->db(0)->get_where('pelanggan', "id_cabang = '" . $this->id_cabang . "'", 'id');

      $this->view('layout', $layout);
      $this->view(__CLASS__ . "/main", $data);
   }

   public function cart($ref = 0)
   {
      $viewData = __CLASS__ . '/cart';
      $data['menu'] = $_SESSION[URL::SESSID]['menu'];
      $data['order'] = $this->db($this->book)->get_where('pesanan', "ref = '" . $ref . "'", "id_menu");
      $data['bayar'] = $this->db($this->book)->get_where('kas', "ref = '" . $ref . "' AND status_mutasi <> 2");
      $this->view($viewData, $data);
   }
}
