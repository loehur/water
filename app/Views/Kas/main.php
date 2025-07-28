<?php $kas = $data['saldo']; ?>
<div class="row mx-0">
  <div class="col p-1">
    <div class="d-flex flex-row">
      <div class="mr-auto">
        <small>Saldo Kas</small><br>
        <span class="text-bold text-success">Rp. <?= number_format($kas); ?></span>
      </div>
      <div class="p-0 pr-0 pb-2 pt-2">
        <div class="btn-group dropdown">
          <button class="btn btn-sm btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Menu Kas
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Pengeluaran</a>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal3">Penarikan</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mx-0">
  <div class="col w-100">
    <table class="table table-sm m-0">
      <tr>
        <th class="pt-2 text-center" colspan="4">
          Cashflow History
        </th>
      </tr>
      <tbody>
        <?php
        $no = 0;
        foreach ($data['debit_list'] as $a) {
          $id = $a['id'];
          $f1 = substr($a['insertTime'], 5, 11);
          $f2 = $a['note'];
          $f2b = $a['note_primary'];
          $f3 = $a['id_user'];
          $f4 = $a['jumlah'];
          $f5 = $a['status_mutasi'];
          $f6 = $a['jenis_transaksi'];
          $st = $a['status_mutasi'];
          $cl = $a['id_client'];
          $metod = $a['metode_mutasi'];

          $karyawan = '';
          $client = "";
          $classTR = '';
          if ($f6 == 4) {
            $classTR = 'text-danger';
          } else if ($f6 == 5) {
            $classTR = 'text-info';
          } else {
            $classTR = 'text-primary';
          }

          $metode = "";

          echo "<tr>";
          echo "<td nowrap><small>#" . $id . " " . $f1 . "</small><br><b class='" . $classTR . "'>" . $f2b . "</b> <small>" . $f2 . " " . $client . "</></small></span></td>";
          echo "<td nowrap class='text-right'><small>" . $metode . "</small> <b><span>" . number_format($f4) . "</span></b><br><small class='text-" . URL::ST_MUTASI[$st][1] . "'>" . URL::ST_MUTASI[$st][0] . "</small></td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
</div>
</div>

<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pengeluaran</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <!-- ====================== FORM ========================= -->
        <form action="<?= URL::BASE_URL; ?>Kas/insert_pengeluaran" method="POST">
          <div class="card-body">
            <div class="form-group">
              <input type="text" name='kas' class="form-control text-center text-bold saldoKas" id="exampleInputEmail1" readonly>
            </div>
            <div class="form-group" id="jenisKeluar">
              <label for="exampleInputEmail1">Jenis Pengeluaran</label>
              <select name="f1a" class="form-control form-control-sm jenisKeluar" style="width: 100%;" required>
                <option value="" selected disabled></option>
                <?php
                $sf = 0;
                foreach ($data['pengeluaran_jenis'] as $ip) { ?>
                  <option value="<?= $ip['id_item_pengeluaran'] ?><explode><?= $ip['item_pengeluaran'] ?>"><?= $ip['item_pengeluaran'] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Jumlah Rp</label>
              <input type="number" name="f2" min="1000" class="form-control jumlahTarik text-center" id="exampleInputEmail1" placeholder="" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Keterangan/Banyak</label>
              <input type="text" name="f1" class="form-control" id="exampleInputEmail1" placeholder="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-sm rounded-0 w-100 bg-gradient btn-danger">Buat Pengeluaran</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Penarikan Kas</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <!-- ====================== FORM ========================= -->
        <form action="<?= URL::BASE_URL; ?>Kas/insert" method="POST">
          <div class="card-body">
            <div class="form-group">
              <input type="text" name='kas' class="form-control text-center text-bold saldoKas" id="exampleInputEmail1" readonly>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Jumlah Rp</label>
              <input type="number" name="f2" min="1000" class="form-control jumlahTarik text-center" id="exampleInputEmail1" placeholder="" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Keterangan</label>
              <input type="text" name="f1" class="form-control" id="exampleInputEmail1" placeholder="" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-sm w-100 bg-gradient btn-primary">Tarik Kas</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- SCRIPT -->
<script src="<?= URL::ASSETS_URL ?>plugins/select2/select2.min.js"></script>

<script>
  $(document).ready(function() {
    selectList();
    $("div#nTunai").hide();
    var saldoKas = <?= $kas ?>;
    $('input.saldoKas').val(formatter.format(saldoKas));
  });

  $("form").on("submit", function(e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr('action'),
      data: $(this).serialize(),
      type: $(this).attr("method"),
      success: function(res) {
        if (res == 0) {
          location.reload(true);
        } else {
          console.log(res);
        }
      },
    });
  });

  $("select.metodeBayar").on("keyup change", function() {
    if ($(this).val() == 2) {
      $("div#nTunai").show();
    } else {
      $("div#nTunai").hide();
    }
  });

  $("input.jumlahTarik").on("keyup change", function() {
    if ($(this).val() > 0) {
      saldoKas = <?= $kas ?>;
      var potong = $(this).val();
      var sisaKas = parseInt(saldoKas) - parseInt(potong);

      $('input.saldoKas').val(formatter.format(sisaKas));
      if (sisaKas < 0) {
        $('input.saldoKas').addClass('text-danger');
      } else {
        $('input.saldoKas').removeClass('text-danger');
      }
    } else {
      $('input.saldoKas').val(formatter.format(saldoKas));
      $('input.saldoKas').removeClass('text-danger');
    }
  });

  var formatter = new Intl.NumberFormat('en-ID', {
    style: 'currency',
    currency: 'IDR',
  });

  function selectList() {
    $('select.userKeluar').select2({
      dropdownParent: $("#userKeluar"),
    });
    $('select.jenisKeluar').select2({
      dropdownParent: $("#jenisKeluar"),
    });
    $('select.tarik').select2({
      dropdownParent: $("#exampleModal3"),
    });
  }

  function tarik(idnya) {
    $.ajax({
      url: '<?= URL::BASE_URL ?>Kasbon/tarik_kasbon/',
      data: {
        id: idnya
      },
      type: "POST",
      success: function() {
        location.reload(true);
      },
    });
  }

  function batal(idnya) {
    $.ajax({
      url: '<?= URL::BASE_URL ?>Kasbon/batal_kasbon/',
      data: {
        id: idnya
      },
      type: "POST",
      success: function() {
        location.reload(true);
      },
    });
  }

  $(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
  });
</script>