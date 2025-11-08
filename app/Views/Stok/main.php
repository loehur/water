<?php $d = $data; ?>
<div class="row mt-2 mx-1 py-2">
  <div class="col text-center border-end">
    <h5 class="text-purple">Hari Ini</h5>
    <h5 class="fw-bold"><i class="fa-light fa-bottle-water"></i> <?= number_format($d['alltoday']) ?></h5>
    <span class="text-primary"><i class="fa-light fa-motorcycle"></i> <?= number_format($data['allv_t']['bike']) ?>,</span> <span class="text-success"><i class="fa-light fa-truck-pickup"></i> <?= number_format($data['allv_t']['car']) ?></span>
  </div>
  <div class="col text-center">
    <h5 class="text-info">Kemarin</h5>
    <h5 class="fw-bold"><i class="fa-light fa-bottle-water"></i> <?= number_format($d['allyesterday']) ?></h5>
    <span class="text-primary"><i class="fa-light fa-motorcycle"></i> <?= number_format($data['allv_y']['bike']) ?>,</span> <span class="text-success"><i class="fa-light fa-truck-pickup"></i> <?= number_format($data['allv_y']['car']) ?></span>
  </div>
</div>
<hr>
<div class="row mt-2">
  <div class="col text-center">
    <h5 class="text-purple">Bulan Ini</h5>
    <h5 class="fw-bold"><i class="fa-light fa-bottle-water"></i> <?= number_format($d['allm']) ?></h5>
    <span class="text-primary"><i class="fa-light fa-motorcycle"></i> <?= number_format($data['allmv_t']['bike']) ?>,</span> <span class="text-success"><i class="fa-light fa-truck-pickup"></i> <?= number_format($data['allmv_t']['car']) ?></span>
  </div>
  <div class="col text-center">
    <h5 class="text-info">Bulan Lalu</h5>
    <h5 class="fw-bold"><i class="fa-light fa-bottle-water"></i> <?= number_format($d['allml']) ?></h5>
    <span class="text-primary"><i class="fa-light fa-motorcycle"></i> <?= number_format($data['allmv_y']['bike']) ?>,</span> <span class="text-success"><i class="fa-light fa-truck-pickup"></i> <?= number_format($data['allmv_y']['car']) ?></span>
  </div>
</div>