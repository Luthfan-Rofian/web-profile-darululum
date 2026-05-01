<?php

if (!function_exists('Tgl_indo')) {
    function date_indo($tgl)
    {
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }
}

if (!function_exists('bulan')) {
    function bulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}

//Format Shortdate
if (!function_exists('shortdate_indo')) {
    function shortdate_indo($tgl)
    {
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = short_bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal . '-' . $bulan . '-' . $tahun;
    }
}

if (!function_exists('short_bulan')) {
    function short_bulan($bln)
    {
        switch ($bln) {
            case 1:
                return "01";
                break;
            case 2:
                return "02";
                break;
            case 3:
                return "03";
                break;
            case 4:
                return "04";
                break;
            case 5:
                return "05";
                break;
            case 6:
                return "06";
                break;
            case 7:
                return "07";
                break;
            case 8:
                return "08";
                break;
            case 9:
                return "09";
                break;
            case 10:
                return "10";
                break;
            case 11:
                return "11";
                break;
            case 12:
                return "12";
                break;
        }
    }
}

//Format Medium date
if (!function_exists('mediumdate_indo')) {
    function mediumdate_indo($tgl)
    {
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = medium_bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }
}

if (!function_exists('medium_bulan')) {
    function medium_bulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Jan";
                break;
            case 2:
                return "Feb";
                break;
            case 3:
                return "Mar";
                break;
            case 4:
                return "Apr";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Jun";
                break;
            case 7:
                return "Jul";
                break;
            case 8:
                return "Ags";
                break;
            case 9:
                return "Sep";
                break;
            case 10:
                return "Okt";
                break;
            case 11:
                return "Nov";
                break;
            case 12:
                return "Des";
                break;
        }
    }
}

//Long date indo Format
if (!function_exists('longdate_indo')) {
    function longdate_indo($tanggal)
    {
        $ubah = gmdate($tanggal, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tgl = $pecah[2];
        $bln = $pecah[1];
        $thn = $pecah[0];
        $bulan = bulan($pecah[1]);

        $nama = date("l", mktime(0, 0, 0, $bln, $tgl, $thn));
        $nama_hari = "";
        if ($nama == "Sunday") {
            $nama_hari = "Minggu";
        } else if ($nama == "Monday") {
            $nama_hari = "Senin";
        } else if ($nama == "Tuesday") {
            $nama_hari = "Selasa";
        } else if ($nama == "Wednesday") {
            $nama_hari = "Rabu";
        } else if ($nama == "Thursday") {
            $nama_hari = "Kamis";
        } else if ($nama == "Friday") {
            $nama_hari = "Jumat";
        } else if ($nama == "Saturday") {
            $nama_hari = "Sabtu";
        }
        return $nama_hari . ', ' . $tgl . ' ' . $bulan . ' ' . $thn;
    }
}

if (!function_exists('generate_years')) {
    function generate_years($id = 'year', $startYear = '', $endYear = '')
    {
        $startYear = (strlen(trim($startYear)) ? $startYear : date('Y') - 10);
        $endYear = (strlen(trim($endYear)) ? $endYear : date('Y'));

        if (!isInt($startYear) || !isInt($endYear)) {
            return 'Year must be integer value!';
        }

        if ((strlen(trim($startYear)) < 4) || (strlen(trim($endYear)) < 4)) {
            return 'Year must be 4 digits in length!';
        }

        if (trim($startYear) > trim($endYear)) {
            return 'Start Year cannot be greater than End Year!';
        }

        //start the select tag
        $html = '<select id="' . $id . '" name="' . $id . '">"n"';
        $html .= '<option value="">-- Year --</option>"n"';
        //echo each year as an option    
        for ($i = $endYear; $i >= $startYear; $i--) {
            $html .= '<option value="' . $i . '">' . $i . '</option>"n"';
        }
        //close the select tag
        $html .= "</select>";

        return $html;
    }
}


if (!function_exists('generate_months')) {
    function generate_months($id = 'month')
    {
        //start the select tag
        $html = '<select id="' . $id . '" name="' . $id . '">"n"';
        $html .= '<option value="">-- Month --</option>"n"';
        //echo each month as an option    
        for ($i = 1; $i <= 12; $i++) {
            $timestamp = mktime(0, 0, 0, $i);
            $label = date("F", $timestamp);
            $html .= '<option value="' . $i . '">' . $label . '</option>"n"';
        }
        //close the select tag
        $html .= "</select>";

        return $html;
    }
}

if (!function_exists('isInt')) {
    function isInt($str)
    {
        return preg_match("/^[1-9][0-9]*$/", $str);
    }
}
