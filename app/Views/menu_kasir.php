<?php
$menu[0] = [
    [
        'p' => 0,
        'c' => 'Penjualan',
        'title' => 'Buka Order',
        'icon' => 'fas fa-cash-register',
        'txt' => 'Order [ <b>' . $_SESSION[URL::SESSID]['cabangs'][$_SESSION[URL::SESSID]['user']['id_cabang']]['kode_cabang'] . '</b> ]'
    ],
    [
        'p' => 0,
        'c' => 'Stok',
        'title' => 'Stok',
        'icon' => 'fas fa-vote-yea',
        'txt' => 'Laporan Stok',
    ],
    [
        'p' => 0,
        'c' => 'Riwayat',
        'title' => 'Riwayat Pesanan',
        'icon' => 'far fa-clock',
        'txt' => 'Riwayat Pesanan',
    ],
    [
        'p' => 0,
        'c' => 'Piutang',
        'title' => 'Piutang',
        'icon' => 'fas fa-file-invoice',
        'txt' => 'Piutang',
    ],
    [
        'p' => 0,
        'c' => 'Kas',
        'title' => 'Kas',
        'icon' => 'fas fa-wallet',
        'txt' => 'Kas',
    ],
    [
        'p' => 0,
        'c' => 'Absen',
        'title' => 'Absen',
        'icon' => 'fas fa-calendar-check',
        'txt' => 'Absen'
    ],
    [
        'p' => 0,
        'c' => 'Pelanggan',
        'title' => 'Pelanggan',
        'icon' => 'fas fa-address-book',
        'txt' => 'Pelanggan'
    ],
];
