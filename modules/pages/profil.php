<?php
// Ganti data berikut dengan identitas Anda
$profil = [
    'Nama'     => 'Hafiz Faturrohman',
    'NIM'      => '312210375',
    'Kelas'    => 'I251C',
    'Mata Kuliah' => 'Pemrograman Web',
];
?>
<section class="content">
    <h2>Profil</h2>
    <table>
        <?php foreach ($profil as $label => $isi): ?>
            <tr><th style="width:180px"><?= e($label) ?></th><td><?= e($isi) ?></td></tr>
        <?php endforeach; ?>
    </table>
</section>
