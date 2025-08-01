<?php

class Stok extends Controller
{
   public function __construct()
   {
      $this->session_cek();
      $this->operating_data();
   }

   public function index()
   {
      $layout = ['title' => 'Stok'];
      $data['tgl'] = [];
      $id_user = $_SESSION[URL::SESSID]['user']['id_user'];
      for ($i = 0; $i >= -10; $i--) {
         $tgl = date('Ymd', strtotime($i . ' days', strtotime(date('Y-m-d'))));
         array_push($data['tgl'], $tgl);
         $tgl_pesan = date('Y-m-d', strtotime($i . ' days', strtotime(date('Y-m-d'))));
         $refs_arr = $this->db($this->book)->get_where('ref', "tgl = '" . $tgl_pesan . "' AND id_user = " . $id_user, 'id');
         $refs_arr = array_keys($refs_arr); // Get only the IDs of the refs
         $refs = "";
         foreach ($refs_arr as $key => $d) {
            $refs .= $d . ",";
         }
         $refs = rtrim($refs, ',');
         if (empty($refs)) {
            $refs = "''"; // If no refs, set to empty string to avoid SQL error
         }
         $data['qty'][$tgl]['t'] = 0; // Initialize total sales for the day
         $sales = 0; // Reset sales count for the day
         $where = "insertTime LIKE '" . $tgl_pesan . "%' AND ref IN (" . $refs . ")";

         $terjual = $this->db($this->book)->get_cols_where('pesanan', 'id_menu, SUM(qty) as qty', $where, 1, 'id_menu'); //sale

         foreach ($terjual as $d) {
            $sales += $d['qty'];
         }

         $data['qty'][$tgl]['t'] = $sales;
      }
      $this->view('layout', $layout);
      $this->view(__CLASS__ . "/main", $data);
   }
}
