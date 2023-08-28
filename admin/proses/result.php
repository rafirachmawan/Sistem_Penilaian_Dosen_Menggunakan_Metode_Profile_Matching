<?php
//inputan nilai bobot
mysqli_select_db($koneksi, $database_koneksi);
$query_bobot = "SELECT nilai_bobot FROM tb_bobot INNER JOIN tb_kriteria ON kriteria_id = id_kriteria WHERE kode_kriteria = 'tb_kriteria'";
$rs_bobot = mysqli_query($koneksi, $query_bobot) or die(mysqli_error($koneksi));
$row_bobot = mysqli_fetch_assoc($rs_bobot);
$bobot_pendidikan = $row_bobot['nilai_bobot'];

//inputan nilai bobot
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  for ($a = 1; $a <= $_POST['id_tempbobot']; $a++) {
  $insertSQL = sprintf("UPDATE tb_alternatif SET nilai_akhir=%s WHERE id_alternatif=%s",
                       GetSQLValueString($koneksi, $_POST['name'.$a], "double"),
                       GetSQLValueString($koneksi, $_POST['id_tempbobot'.$a], "float"));

  mysqli_select_db($koneksi, $database_koneksi);
  $Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error($koneksi));
  }
  
  echo "
  <script>
  	document.location = '?page=proses/result';
  </script>
  ";
}
//function
function nilaibobot($gap){
		if ($gap == 0) {
			$nilai = 5;
			return $nilai;
		}elseif ($gap == 1) {
			$nilai = 4.5;
			return $nilai;
		}elseif ($gap == -1) {
			$nilai = 4;
			return $nilai;
		}elseif ($gap == 2) {
			$nilai = 3.5;
			return $nilai;
		}elseif ($gap == -2) {
			$nilai = 3;
			return $nilai;
		}elseif ($gap == 3) {
			$nilai = 2.5;
			return $nilai;
		}elseif ($gap == -3) {
			$nilai = 2;
			return $nilai;
		}elseif ($gap == 4) {
			$nilai = 1.5;
			return $nilai;
		}elseif ($gap == -4) {
			$nilai = 1;
			return $nilai;
		}else{
			return "Oops! Error";
		}
	}
//-----------
 
mysqli_select_db($koneksi, $database_koneksi);
$query_rs_alternatif = "SELECT * FROM tb_alternatif ORDER BY id_alternatif ASC";
$rs_alternatif = mysqli_query($koneksi, $query_rs_alternatif) or die(mysqli_error($koneksi));
$rs_alternatif2 = mysqli_query($koneksi, $query_rs_alternatif) or die(mysqli_error($koneksi));
$rs_alternatif3 = mysqli_query($koneksi, $query_rs_alternatif) or die(mysqli_error($koneksi));
$rs_alternatif4 = mysqli_query($koneksi, $query_rs_alternatif) or die(mysqli_error($koneksi));
$row_rs_alternatif = mysqli_fetch_assoc($rs_alternatif);
$row_rs_alternatif2 = mysqli_fetch_assoc($rs_alternatif2);
$row_rs_alternatif3 = mysqli_fetch_assoc($rs_alternatif3);
$row_rs_alternatif4 = mysqli_fetch_assoc($rs_alternatif4);
$totalRows_rs_alternatif = mysqli_num_rows($rs_alternatif);


mysqli_select_db($koneksi, $database_koneksi);
$query_rs_kriteria = "SELECT `id_kriteria`, kode_kriteria, nama_kriteria, faktor_id FROM tb_kriteria";
$rs_kriteria = mysqli_query($koneksi, $query_rs_kriteria) or die(mysqli_error($koneksi));
$row_rs_kriteria  = mysqli_fetch_assoc($rs_kriteria);
$rs_kriteria2 = mysqli_query($koneksi, $query_rs_kriteria) or die(mysqli_error($koneksi));
$row_rs_kriteria2 = mysqli_fetch_assoc($rs_kriteria2);
$totalRows_rs_kriteria = mysqli_num_rows($rs_kriteria);

mysqli_select_db($koneksi, $database_koneksi);
$query_rs_kriteria3 = "SELECT COUNT(faktor_id) as faktor, persen_faktor FROM `tb_kriteria` INNER JOIN tb_faktor ON faktor_id = id_faktor GROUP BY faktor_id";
$rs_kriteria3 = mysqli_query($koneksi, $query_rs_kriteria3) or die(mysqli_error($koneksi));
$row_rs_kriteria3 = mysqli_fetch_assoc($rs_kriteria3);

do {
	$faktorku[] = $row_rs_kriteria3['faktor'];
	$persen[] = $row_rs_kriteria3['persen_faktor'] / 100;
} while($row_rs_kriteria3 = mysqli_fetch_assoc($rs_kriteria3));

do {
	$id_kriteria[] = $row_rs_kriteria['id_kriteria'];
	$kode_kriteria[] = $row_rs_kriteria['kode_kriteria'];
	$faktor[] = $row_rs_kriteria['faktor_id'];	
} while($row_rs_kriteria = mysqli_fetch_assoc($rs_kriteria));
?>

<style type="text/css">
.style1 {
    color: #FFFFFF
}
</style>

<p><?php 
//nilai bobot
 pesan('success','<b>NILAI BOBOT</b>');
 ?> </p>

    <div class="table-responsive">
        <table width="100%" class="table table-striped table-bordered">
            <thead>
                <tr bgcolor="#003366">
                    <th><span class="style1">NO.</span></th>
                    <th><span class="style1">NAMA ALTERNATIF</span></th>
                    <?php foreach($rs_kriteria as $row_rs_kriteria) {  ?>
                    <th bgcolor="#FF6600"><span class="style1"><?php echo $row_rs_kriteria['nama_kriteria']; ?></span>
                    </th>

                    <?php }  ?>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; do { ?>
                <tr>
                    <td align="center"><?php echo $no; ?></td>
                    <td><?php echo $row_rs_alternatif['nama_alternatif']; ?></td>
                    <?php
	  $total = 0; 
    
	  // for ($a = 0; $a < $totalRows_rs_kriteria; $a++ ) { 
	  foreach($rs_kriteria as $row_rs_kriteria) {
		mysqli_select_db($koneksi, $database_koneksi);
		$query_rs_bobot =  sprintf("SELECT nilai_bobot FROM tb_bobot INNER JOIN tb_kriteria ON kriteria_id = id_kriteria WHERE alternatif_id = %s AND kriteria_id = %s", 
										GetSQLValueString($koneksi, $row_rs_alternatif['id_alternatif'], "int"),
										GetSQLValueString($koneksi, $row_rs_kriteria['id_kriteria'], "float"));
		$rs_bobot = mysqli_query($koneksi, $query_rs_bobot) or die(mysqli_error($koneksi));
		$row_rs_bobot = mysqli_fetch_assoc($rs_bobot);
		$totalRows_rs_bobot = mysqli_num_rows($rs_bobot);
	  ?>
                    <td>
                        <div align="center">
                            <?= $row_rs_bobot['nilai_bobot']; ?>
                        </div>
                    </td>
                    <?php 
	  	 
	  } ?>
                </tr>
                <?php 
	$no++;
	} while ($row_rs_alternatif = mysqli_fetch_assoc($rs_alternatif)); ?>
                <tr>
                    <td colspan="2" align="center"><strong>PROFILE IDEAL</strong></td>
                    <?php  foreach($rs_kriteria as $row_rs_kriteria) {
	  mysqli_select_db($koneksi, $database_koneksi);
		$query_rs_bobot =  sprintf("SELECT MAX(nilai_bobot) as maks FROM tb_bobot INNER JOIN tb_kriteria ON kriteria_id = id_kriteria WHERE  kriteria_id = %s",  GetSQLValueString($koneksi, $row_rs_kriteria['id_kriteria'], "int"));
		$rs_bobot = mysqli_query($koneksi, $query_rs_bobot) or die(mysqli_error($koneksi));
		$row_rs_bobot = mysqli_fetch_assoc($rs_bobot);
		$totalRows_rs_bobot = mysqli_num_rows($rs_bobot);
	  ?>
                    <td>
                        <div align="center">
                            <?= $row_rs_bobot['maks']; ?>
                            <?php $ar_max[] = $row_rs_bobot['maks']; ?>
                        </div>
                    </td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
    </div>
<!-- ... kode sebelumnya ... -->

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
        <th><div align="center" class="style1">JURUSAN</div></th>
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
        <th><div align="center" class="style1">JURUSAN</div></th>
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
        <th><div align="center" class="style1">JURUSAN</div></th>
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
        <th><div align="center" class="style1">JURUSAN</div></th>
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
        <th width="30%"><div align="center"><span class="style1">JURUSAN</span></div></th>
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


