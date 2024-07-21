<?php

declare(strict_types=1);

namespace Flasher\Laravel\Resources;

return [
    // Default notification library (e.g., 'flasher', 'toastr', 'noty', etc.)
    'default' => 'toastr',

    // Path to the main JavaScript file of PHPFlasher
    'main_script' => '/vendor/flasher/flasher.min.js',

    // Path to the stylesheets for PHPFlasher notifications
    'styles' => [
        '/vendor/flasher/flasher.min.css',
    ],

    // Whether to translate PHPFlasher messages using Laravel's translation service
    'translate' => true,

    // Automatically inject PHPFlasher assets into HTML response
    'inject_assets' => true,

    // Configuration for the flash bag (converting Laravel flash messages)
    // Map Laravel session keys to PHPFlasher types
    'flash_bag' => [
        'success' => ['success'],
        'error' => ['error', 'danger'],
        'warning' => ['warning', 'alarm'],
        'info' => ['info', 'notice', 'alert'],
    ],

    // Filter criteria for notifications (e.g., limit number, types)
    'filter' => [
        'limit' => 5, // Limit the number of displayed notifications
    ],

    'presets' => [
        'terdaftar' => [
            'type' => 'success',
            'message' => 'Silamat menikmati layanan kami',
            'title' => 'Selamat Datang!',
        ],

        'terlogin' => [
            'type' => 'success',
            'title' => 'Selamat Datang Kembali!',
        ],

        'tersimpan' => [
            'type' => 'success',
            'message' => 'Data berhasil disimpan',
            'title' => 'Sukses!',
        ],

        'terhapus' => [
            'type' => 'success',
            'message' => 'Data berhasil dihapus',
            'title' => 'Sukses!',
        ],

        'terupdate' => [
            'type' => 'success',
            'message' => 'Data berhasil diperbarui',
            'title' => 'Sukses!',
        ],

        'tergagal' => [
            'type' => 'error',
            'message' => 'Data gagal disimpan',
            'title' => 'Gagal!',
        ],

        'terbatal' => [
            'type' => 'error',
            'message' => 'Data gagal diperbarui',
            'title' => 'Gagal!',
        ],

    ],
];
