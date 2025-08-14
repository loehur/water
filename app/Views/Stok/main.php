<?php $d = $data; ?>

<div class="row mt-2 mx-1 py-2">
  <div class="col text-center">
    <h4 class="text-purple">Hari Ini</h4>
    <h3 class="fw-bold"><i class="fa-light fa-bottle-water"></i> <?= number_format($d['me'] + $d['xme']) ?></h3>
  </div>
</div>
<div class="row">
  <div class="col text-center border-end">
    <h5>Saya</h5>
    <h4 class="fw-bold"><i class="fa-light fa-bottle-water"></i> <?= number_format($d['me'] + $d['xme']) ?></h4>
  </div>
  <div class="col text-center">
    <h5>Tim</h5>
    <h4 class="fw-bold"><i class="fa-light fa-bottle-water"></i> <?= number_format($d['me'] + $d['xme']) ?></h4>
  </div>
</div>
<hr>
<div class="row mt-5">
  <div class="col text-center">
    <h4 class="text-success">Bulan Ini</h4>
    <h3 class="fw-bold"><i class="fa-light fa-bottle-water"></i> <?= number_format($d['allm']) ?></h3>
  </div>
</div>