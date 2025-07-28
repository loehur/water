<?php
$menu[1] = [
    [
        'p' => 100,
        'c' => 'Approval',
        'title' => 'Approval',
        'icon' => 'fas fa-tasks',
        'txt' => 'Approval'
    ],
    [
        'p' => 100,
        'c' => '',
        'title' => 'Rekap',
        'icon' => 'fas fa-chart-line',
        'txt' => 'Laporan',
        'submenu' =>
        [
            [
                'c' => 'Rekap/i/1',
                'title' => 'Rekap Cabang Harian',
                'txt' => 'Cabang Harian',
            ],
            [
                'c' => 'Rekap/i/2',
                'title' => 'Rekap Cabang Bulanan',
                'txt' => 'Cabang Bulanan',
            ],
        ]
    ],
    [
        'p' => 100,
        'c' => '',
        'title' => 'Karyawan',
        'icon' => 'fas fa-user-friends',
        'txt' => 'Karyawan',
        'submenu' =>
        [
            [
                'c' => 'Karyawan/index/1',
                'title' => 'Karyawan Aktif',
                'txt' => 'Aktif',
            ],
            [
                'c' => 'Karyawan/index/0',
                'title' => 'Karyawan Non Aktif',
                'txt' => 'Non Aktif',
            ],
        ]
    ],
    [
        'p' => 100,
        'c' => 'WA_Status',
        'title' => 'WA_Status',
        'icon' => 'fab fa-whatsapp',
        'txt' => 'Whatsapp Status'
    ],
];
