<?php
foreach ($data['pelanggan'] as $key => $r) { ?>
  <div id="row<?= $r['id'] ?>" data-id="<?= $r['id'] ?>" data-pelanggan="<?= strtoupper($r['nama']) ?>" data-titip="<?= $r['titip'] ?>" class="row mx-0 border-bottom py-1 cekPesanan" style="cursor: pointer;" aria-controls="offcanvasRight">
    <div class="col">
      <b class="text-success"><?= strtoupper($r['nama']) ?></b><br>
      <span class=""><?= date('d M y', strtotime($r['last_order'] . " " . "00:00")) ?></span>
    </div>
    <div class="col text-end">
      <?php
      $tanggal = $r['last_order'] . ' 00:00:00';
      $tanggal = new DateTime($tanggal);
      $sekarang = new DateTime();
      $beda = $tanggal->diff($sekarang);
      ?>
      <span class="fw-bold"><i class="fa-light fa-bottle-water"></i> <?= $r['titip'] ?></span><br>
      <span class="fw-bold text-danger"><?= $beda->d ?> Hari</span>
    </div>
  </div>
<?php } ?>

<div class="offcanvas offcanvas-end overflow-hidden" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="bg-light bg-gradient mb-2" style="box-shadow: 0px 1px 10px silver;">
    <div class="row py-2" style="cursor: pointer;" data-bs-dismiss="offcanvas">
      <div class="col py-2 w-100 text-dark text-center"><i class="fas fa-arrow-left"></i> &nbsp; Kembali</div>
    </div>
  </div>
  <div class="offcanvas-body pt-0">

    <div class="row mt-5">
      <div class="col">Pelanggan</div>
      <div class="col text-end">:</div>
      <div class="col fw-bold" id="pelanggan"></div>
    </div>
    <div class="row">
      <div class="col">Galon</div>
      <div class="col text-end">:</div>
      <div class="col fw-bold" id="galon"></div>
    </div>

    <div class="row mt-5">
      <div class="col text-center">
        <button class="btn btn-danger w-100" onclick="ambilGalon()">Ambil Galon</button>
      </div>
    </div>

  </div>
  <div style="max-height: 50px; cursor:pointer" class="w-100 mt-1 bg-light bg-gradient" data-bs-dismiss="offcanvas">
    <div class="d-flex justify-content-center" style="box-shadow: 0px -1px 10px silver; height:50px">
      <div class="align-self-center"><i class="fas fa-arrow-left"></i> &nbsp; Kembali</div>
    </div>
  </div>
</div>

<script>
  var id_pelanggan = 0;
  $(".cekPesanan").click(function() {
    buka_canvas('offcanvasRight');
    id_pelanggan = $(this).data('id');
    $("#pelanggan").html($(this).data('pelanggan'));
    $("#galon").html($(this).data('titip'));
  })

  function ambilGalon() {
    $.ajax({
      url: '<?= URL::BASE_URL ?>Galon/ambilGalon',
      type: "POST",
      data: {
        id_pelanggan: id_pelanggan
      },
      success: function(response) {
        response = JSON.parse(response);
        if (response.status) {
          $("#row" + id_pelanggan).remove();
          $('.offcanvas.show').each(function() {
            $(this).offcanvas('hide');
          });
        } else {
          alert(response.message);
        }
      },
    })
  }
</script>