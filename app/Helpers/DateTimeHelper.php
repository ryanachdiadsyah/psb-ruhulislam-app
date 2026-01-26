<?php

function dateIndo($tanggal) {
    // Array hari dan bulan Indonesia
    $hari = array(
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    );
    
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    // Pecah timestamp
    $split = explode('-', $tanggal);
    $tgl_array = explode(' ', $split[2]); // Memisahkan tanggal dan jam jika ada
    
    $tgl = $tgl_array[0];
    $bln = $split[1];
    $thn = $split[0];
    
    // Mendapatkan nama hari (Opsional)
    $timestamp = strtotime($tanggal);
    $nama_hari = $hari[date('l', $timestamp)];

    // Hasil: Minggu, 26 Januari 2025
    return $nama_hari . ', ' . $tgl . ' ' . $bulan[(int)$bln] . ' ' . $thn;
}