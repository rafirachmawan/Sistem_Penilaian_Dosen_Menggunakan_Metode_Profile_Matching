<?php 
require_once('../logout.php');
require_once('../restrict.php'); 
require_once('../Connections/koneksi.php'); 
require_once('require/header.php'); 

mysqli_select_db($koneksi, $database_koneksi);
$query_rs_profile = "SELECT * FROM tb_master WHERE id_master = '".$ID."'";
$rs_profile = mysqli_query($koneksi, $query_rs_profile) or die(mysqli_error($koneksi));
$row_rs_profile = mysqli_fetch_assoc($rs_profile);
$totalRows_rs_profile = mysqli_num_rows($rs_profile);
?>

<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">

  <header class="main-header">
   <?php require_once('require/navbar.php'); ?>
  </header>
  <?php require_once('require/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard :: 
        <small>Selamat Datang, <?= $nama; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>             
               
<p>
<?php
// Perangkingan alternatif berdasarkan nilai bobot kriteria "Pelaksanaan Pendidikan"
pesan('success', '<b>PERANGKINGAN DOSEN BERDASARKAN NILAI BOBOT KRITERIA PELAKSANAAN PENDIDIKAN</b>');
?>
</p>

<div class="table-responsive">
  <table width="100%" class="table table-striped table-bordered">
    <thead>
      <tr bgcolor="#003366">
        <th><div align="center" class="style1">NO.</div></th>
        <th><div align="center" class="style1">NAMA ALTERNATIF</div></th>
        <th><div align="center" class="style1">NIDN</div></th>
        <th><div align="center" class="style1">Mata Kuliah</div></th>
        <th><div align="center" class="style1">NILAI AKHIR</div></th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Mendapatkan nilai bobot kriteria "Pelaksanaan Pendidikan"
      $kriteria_id = 1; // ID kriteria "Pelaksanaan Pendidikan"
      $query_bobot_kriteria = "SELECT tb_alternatif.id_alternatif, nama_alternatif, nidn, mata_kuliah, nilai_bobot FROM tb_bobot 
                              INNER JOIN tb_kriteria ON tb_bobot.kriteria_id = tb_kriteria.id_kriteria
                              INNER JOIN tb_alternatif ON tb_bobot.alternatif_id = tb_alternatif.id_alternatif
                              WHERE tb_bobot.kriteria_id = $kriteria_id";
      $rs_bobot_kriteria = mysqli_query($koneksi, $query_bobot_kriteria) or die(mysqli_error($koneksi));
      $nilai_bobot = array();
      while ($row_bobot_kriteria = mysqli_fetch_assoc($rs_bobot_kriteria)) {
        $alternatif_id = $row_bobot_kriteria['id_alternatif'];
        $nama_alternatif = $row_bobot_kriteria['nama_alternatif'];
        $nidn = $row_bobot_kriteria['nidn'];
        $mata_kuliah = $row_bobot_kriteria['mata_kuliah'];
        $bobot = $row_bobot_kriteria['nilai_bobot'];
        $nilai_bobot[$alternatif_id] = $bobot;
      }

      // Perangkingan alternatif
      $perangkingan = array();
      foreach ($nilai_bobot as $alternatif_id => $bobot) {
        $nilai_akhir = $bobot;
        $perangkingan[$alternatif_id] = $nilai_akhir;
      }

      // Mengurutkan perangkingan dari nilai tertinggi ke terendah
      arsort($perangkingan);

      $no = 1;
      foreach ($perangkingan as $alternatif_id => $nilai_akhir) {
        $query_alternatif = "SELECT nama_alternatif, nidn, mata_kuliah FROM tb_alternatif WHERE id_alternatif = $alternatif_id";
        $rs_alternatif = mysqli_query($koneksi, $query_alternatif) or die(mysqli_error($koneksi));
        $row_alternatif = mysqli_fetch_assoc($rs_alternatif);
      ?>
        <tr>
          <td align="center"><?php echo $no; ?></td>
          <td><?php echo $row_alternatif['nama_alternatif']; ?></td>
          <td><?php echo $row_alternatif['nidn']; ?></td>
          <td><?php echo $row_alternatif['mata_kuliah']; ?></td>
          <td align="center"><?php echo $nilai_akhir; ?></td>
        </tr>
      <?php
        $no++;
      }
      ?>
    </tbody>
  </table>
</div>


<!-- ... kode setelahnya ... -->

<p>
<?php
// Perangkingan alternatif berdasarkan nilai bobot kriteria "Pelaksanaan Penelitian"
pesan('success', '<b>PERANGKINGAN DOSEN BERDASARKAN NILAI BOBOT KRITERIA PELAKSANAAN PENELITIAN</b>');
?>
</p>

<div class="table-responsive">
  <table width="100%" class="table table-striped table-bordered">
    <thead>
      <tr bgcolor="#003366">
        <th><div align="center" class="style1">NO.</div></th>
        <th><div align="center" class="style1">NAMA ALTERNATIF</div></th>
        <th><div align="center" class="style1">NIDN</div></th>
        <th><div align="center" class="style1">Mata Kuliah</div></th>
        <th><div align="center" class="style1">NILAI AKHIR</div></th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Mendapatkan nilai bobot kriteria "Pelaksanaan Penelitian"
      $kriteria_id = 2; // ID kriteria "Pelaksanaan Penelitian"
      $query_bobot_kriteria = "SELECT tb_alternatif.id_alternatif, nama_alternatif, nidn, mata_kuliah, nilai_bobot FROM tb_bobot 
                              INNER JOIN tb_kriteria ON tb_bobot.kriteria_id = tb_kriteria.id_kriteria
                              INNER JOIN tb_alternatif ON tb_bobot.alternatif_id = tb_alternatif.id_alternatif
                              WHERE tb_bobot.kriteria_id = $kriteria_id";
      $rs_bobot_kriteria = mysqli_query($koneksi, $query_bobot_kriteria) or die(mysqli_error($koneksi));
      $nilai_bobot = array();
      while ($row_bobot_kriteria = mysqli_fetch_assoc($rs_bobot_kriteria)) {
        $alternatif_id = $row_bobot_kriteria['id_alternatif'];
        $nama_alternatif = $row_bobot_kriteria['nama_alternatif'];
        $nidn = $row_bobot_kriteria['nidn'];
        $mata_kuliah = $row_bobot_kriteria['mata_kuliah'];
        $bobot = $row_bobot_kriteria['nilai_bobot'];
        $nilai_bobot[$alternatif_id] = $bobot;
      }

      // Perangkingan alternatif
      $perangkingan = array();
      foreach ($nilai_bobot as $alternatif_id => $bobot) {
        $nilai_akhir = $bobot;
        $perangkingan[$alternatif_id] = $nilai_akhir;
      }

      // Mengurutkan perangkingan dari nilai tertinggi ke terendah
      arsort($perangkingan);

      $no = 1;
      foreach ($perangkingan as $alternatif_id => $nilai_akhir) {
        $query_alternatif = "SELECT nama_alternatif, nidn, mata_kuliah FROM tb_alternatif WHERE id_alternatif = $alternatif_id";
        $rs_alternatif = mysqli_query($koneksi, $query_alternatif) or die(mysqli_error($koneksi));
        $row_alternatif = mysqli_fetch_assoc($rs_alternatif);
      ?>
        <tr>
          <td align="center"><?php echo $no; ?></td>
          <td><?php echo $row_alternatif['nama_alternatif']; ?></td>
          <td><?php echo $row_alternatif['nidn']; ?></td>
          <td><?php echo $row_alternatif['mata_kuliah']; ?></td>
          <td align="center"><?php echo $nilai_akhir; ?></td>
        </tr>
      <?php
        $no++;
      }
      ?>
    </tbody>
  </table>
</div>

<!-- ... kode setelahnya ... -->

<p>
<?php
// Perangkingan alternatif berdasarkan nilai bobot kriteria "Pelaksanaan Pengabdian"
pesan('success', '<b>PERANGKINGAN DOSEN BERDASARKAN NILAI BOBOT KRITERIA PELAKSANAAN PENGABDIAN</b>');
?>
</p>

<div class="table-responsive">
  <table width="100%" class="table table-striped table-bordered">
    <thead>
      <tr bgcolor="#003366">
        <th><div align="center" class="style1">NO.</div></th>
        <th><div align="center" class="style1">NAMA ALTERNATIF</div></th>
        <th><div align="center" class="style1">NIDN</div></th>
        <th><div align="center" class="style1">Mata Kuliah</div></th>
        <th><div align="center" class="style1">NILAI AKHIR</div></th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Mendapatkan nilai bobot kriteria "Pelaksanaan Pengabdian"
      $kriteria_id = 3; // ID kriteria "Pelaksanaan Pengabdian"
      $query_bobot_kriteria = "SELECT tb_alternatif.id_alternatif, nama_alternatif, nidn, mata_kuliah, nilai_bobot FROM tb_bobot 
                              INNER JOIN tb_kriteria ON tb_bobot.kriteria_id = tb_kriteria.id_kriteria
                              INNER JOIN tb_alternatif ON tb_bobot.alternatif_id = tb_alternatif.id_alternatif
                              WHERE tb_bobot.kriteria_id = $kriteria_id";
      $rs_bobot_kriteria = mysqli_query($koneksi, $query_bobot_kriteria) or die(mysqli_error($koneksi));
      $nilai_bobot = array();
      while ($row_bobot_kriteria = mysqli_fetch_assoc($rs_bobot_kriteria)) {
        $alternatif_id = $row_bobot_kriteria['id_alternatif'];
        $nama_alternatif = $row_bobot_kriteria['nama_alternatif'];
        $nidn = $row_bobot_kriteria['nidn'];
        $mata_kuliah = $row_bobot_kriteria['mata_kuliah'];
        $bobot = $row_bobot_kriteria['nilai_bobot'];
        $nilai_bobot[$alternatif_id] = $bobot;
      }

      // Perangkingan alternatif
      $perangkingan = array();
      foreach ($nilai_bobot as $alternatif_id => $bobot) {
        $nilai_akhir = $bobot;
        $perangkingan[$alternatif_id] = $nilai_akhir;
      }

      // Mengurutkan perangkingan dari nilai tertinggi ke terendah
      arsort($perangkingan);

      $no = 1;
      foreach ($perangkingan as $alternatif_id => $nilai_akhir) {
        $query_alternatif = "SELECT nama_alternatif, nidn, mata_kuliah FROM tb_alternatif WHERE id_alternatif = $alternatif_id";
        $rs_alternatif = mysqli_query($koneksi, $query_alternatif) or die(mysqli_error($koneksi));
        $row_alternatif = mysqli_fetch_assoc($rs_alternatif);
      ?>
        <tr>
          <td align="center"><?php echo $no; ?></td>
          <td><?php echo $row_alternatif['nama_alternatif']; ?></td>
          <td><?php echo $row_alternatif['nidn']; ?></td>
          <td><?php echo $row_alternatif['mata_kuliah']; ?></td>
          <td align="center"><?php echo $nilai_akhir; ?></td>
        </tr>
      <?php
        $no++;
      }
      ?>
    </tbody>
  </table>
</div>

<!-- ... kode setelahnya ... -->

<p>
<?php
// Perangkingan alternatif berdasarkan nilai bobot kriteria "Pelaksanaan Penunjang"
pesan('success', '<b>PERANGKINGAN DOSEN BERDASARKAN NILAI BOBOT KRITERIA PELAKSANAAN PENUNJANG</b>');
?>
</p>

<div class="table-responsive">
  <table width="100%" class="table table-striped table-bordered">
    <thead>
      <tr bgcolor="#003366">
        <th><div align="center" class="style1">NO.</div></th>
        <th><div align="center" class="style1">NAMA ALTERNATIF</div></th>
        <th><div align="center" class="style1">NIDN</div></th>
        <th><div align="center" class="style1">Mata Kuliah</div></th>
        <th><div align="center" class="style1">NILAI AKHIR</div></th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Mendapatkan nilai bobot kriteria "Pelaksanaan Penunjang"
      $kriteria_id = 4; // ID kriteria "Pelaksanaan Penunjang"
      $query_bobot_kriteria = "SELECT tb_alternatif.id_alternatif, nama_alternatif, nidn, mata_kuliah, nilai_bobot FROM tb_bobot 
                              INNER JOIN tb_kriteria ON tb_bobot.kriteria_id = tb_kriteria.id_kriteria
                              INNER JOIN tb_alternatif ON tb_bobot.alternatif_id = tb_alternatif.id_alternatif
                              WHERE tb_bobot.kriteria_id = $kriteria_id";
      $rs_bobot_kriteria = mysqli_query($koneksi, $query_bobot_kriteria) or die(mysqli_error($koneksi));
      $nilai_bobot = array();
      while ($row_bobot_kriteria = mysqli_fetch_assoc($rs_bobot_kriteria)) {
        $alternatif_id = $row_bobot_kriteria['id_alternatif'];
        $nama_alternatif = $row_bobot_kriteria['nama_alternatif'];
        $nidn = $row_bobot_kriteria['nidn'];
        $mata_kuliah = $row_bobot_kriteria['mata_kuliah'];
        $bobot = $row_bobot_kriteria['nilai_bobot'];
        $nilai_bobot[$alternatif_id] = $bobot;
      }

      // Perangkingan alternatif
      $perangkingan = array();
      foreach ($nilai_bobot as $alternatif_id => $bobot) {
        $nilai_akhir = $bobot;
        $perangkingan[$alternatif_id] = $nilai_akhir;
      }

      // Mengurutkan perangkingan dari nilai tertinggi ke terendah
      arsort($perangkingan);

      $no = 1;
      foreach ($perangkingan as $alternatif_id => $nilai_akhir) {
        $query_alternatif = "SELECT nama_alternatif, nidn, mata_kuliah FROM tb_alternatif WHERE id_alternatif = $alternatif_id";
        $rs_alternatif = mysqli_query($koneksi, $query_alternatif) or die(mysqli_error($koneksi));
        $row_alternatif = mysqli_fetch_assoc($rs_alternatif);
      ?>
        <tr>
          <td align="center"><?php echo $no; ?></td>
          <td><?php echo $row_alternatif['nama_alternatif']; ?></td>
          <td><?php echo $row_alternatif['nidn']; ?></td>
          <td><?php echo $row_alternatif['mata_kuliah']; ?></td>
          <td align="center"><?php echo $nilai_akhir; ?></td>
        </tr>
      <?php
        $no++;
      }
      ?>
    </tbody>
  </table>
</div>

<!-- ... kode setelahnya ... -->
<?php  
mysqli_select_db($koneksi, $database_koneksi);
$query_rs_alternatif = "SELECT id_alternatif, nama_alternatif, nidn, mata_kuliah, nilai_akhir FROM tb_alternatif ORDER BY nilai_akhir DESC";
$rs_alternatif = mysqli_query($koneksi, $query_rs_alternatif) or die(mysqli_error($koneksi));
$row_rs_alternatif = mysqli_fetch_assoc($rs_alternatif);

$totalRows_rs_alternatif = mysqli_num_rows($rs_alternatif);
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>

<?php if ($totalRows_rs_alternatif > 0) { ?>
<div class="table-responsive">
  <h3><?php pesan('success','HASIL PERINGKAT YANG DIPEROLEH'); ?></h3>
  <table width="100%" class="table table-striped table-bordered">
    <thead>
      <tr bgcolor="#003366">
        <th width="3%"><div align="center"><span class="style1">RANGKING</span></div></th>
        <th width="30%"><div align="center"><span class="style1">NAMA</span></div></th>
        <th width="15%"><div align="center"><span class="style1">NIDN</span></div></th>
        <th width="30%"><div align="center"><span class="style1">MATA KULIAH</span></div></th>
        <th width="22%"><div align="center"><span class="style1">NILAI AKHIR</span></div></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; do { ?>
      <tr>
        <td align="center"><a href="?page=alternatif/update&id_alternatif=<?php echo $row_rs_alternatif['id_alternatif']; ?>"><?php echo $no++; ?></a></td>
        <td><?php echo $row_rs_alternatif['nama_alternatif']; ?></td>
        <td><?php echo $row_rs_alternatif['nidn']; ?></td>
        <td><?php echo $row_rs_alternatif['mata_kuliah']; ?></td>
        <td align="center"><?php echo $row_rs_alternatif['nilai_akhir']; ?></td>
      </tr>
      <?php } while ($row_rs_alternatif = mysqli_fetch_assoc($rs_alternatif)); ?>
    </tbody>
  </table>
</div>
<?php } else {
  pesan('danger','Oops! Nilai belum diproses');
} ?>
           
           </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  
<?php require_once('require/footer.php'); ?>