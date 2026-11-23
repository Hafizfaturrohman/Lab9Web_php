<section class="content">
    <h2>Demo Library Function (helpers/functions.php)</h2>
    <table>
        <tr><th>Function</th><th>Pemanggilan</th><th>Hasil</th></tr>
        <tr><td>formatRupiah()</td><td>formatRupiah(150000)</td><td><?= e(formatRupiah(150000)) ?></td></tr>
        <tr><td>hitungDiskon()</td><td>hitungDiskon(200000) / (200000, 15)</td>
            <td><?= e(formatRupiah(hitungDiskon(200000))) ?> / <?= e(formatRupiah(hitungDiskon(200000, 15))) ?></td></tr>
        <tr><td>validasiEmail()</td><td>validasiEmail('rina@example.com')</td><td><?= validasiEmail('rina@example.com') ? 'Valid' : 'Tidak valid' ?></td></tr>
        <tr><td>validasiEmail()</td><td>validasiEmail('rina@')</td><td><?= validasiEmail('rina@') ? 'Valid' : 'Tidak valid' ?></td></tr>
        <tr><td>ringkasTeks()</td><td>ringkasTeks('Modularisasi...', 30)</td>
            <td><?= e(ringkasTeks('Modularisasi membagi aplikasi menjadi bagian-bagian kecil', 30)) ?></td></tr>
        <tr><td>konversiCelciusKeFahrenheit()</td><td>(37)</td><td><?= konversiCelciusKeFahrenheit(37) ?> °F</td></tr>
        <tr><td>tentukanStatusNilai()</td><td>(78)</td><td><?= e(tentukanStatusNilai(78)) ?></td></tr>
        <tr><td>hitungTotal()</td><td>(25000, 4)</td><td><?= e(formatRupiah(hitungTotal(25000, 4))) ?></td></tr>
        <tr><td>e()</td><td>e('&lt;script&gt;alert("uji")&lt;/script&gt;')</td><td><?= e('<script>alert("uji")</script>') ?></td></tr>
    </table>
</section>
