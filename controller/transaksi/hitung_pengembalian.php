<?php
$pattern = '/([^0-9]+)/';

$total_text = $_POST['total'];
$total = preg_replace($pattern, '', $total_text);

$bayar_text = $_POST['bayar'];
$bayar = preg_replace($pattern, '', $bayar_text);

$kembalian = (int) $bayar - (int) $total;

if ($bayar == $total) {
    $data[] = array(
        'hasil'   => '0',
        'KembalianRp'   => '0'
    );

    echo json_encode($data);
} else if ($bayar < $total) {
    $data[] = array(
        'hasil'   => '2',
    );

    echo json_encode($data);
} else if ($bayar > $total) {
    $kembalianRp = number_format($kembalian, 0, ',', '.');
    $data[] = array(
        'hasil'   => '1',
        'KembalianRp'   => $kembalianRp
    );

    echo json_encode($data);
}
//     if ($kembalian > 0) {
//         $kembalianRp = number_format($kembalian, 0, ',', '.');
//         $data[] = array(
//             'hasil'   => '1',
//             'KembalianRp'   => $kembalianRp
//         );

//         echo json_encode($data);
//     } else if ($kembalian < 0) {
//         $data[] = array(
//             'hasil'   => '2',
//         );

//         echo json_encode($data);
//     }
// }
