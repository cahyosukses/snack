f<?php
 if (empty($_SESSION['pelanggan_username']) AND empty($_SESSION['pelanggan_password'])){
    echo "<script>location='media.php?module=home';</script>";
} else { 
    $action="modul/saldocancel/action.php?module=".$_GET['module']."&act=".$_GET['act'];
    switch($_GET['act']) {
        default:
        ?>

    <div class="page-content container-fluid">
        <div class="row">
        <div class="col-md-3">
            <div class="panel">
                <div class="panel-heading">
                    <h5 class="panel-title">Saldo</h5>
                </div>
                <ul class="list">
                    <li class="list-item">
                        <a href="?module=saldoprocess" class="animsition-link">
                           Saldo - Proses
                        </a>
                    </li>
                    <li class="list-item">
                        <a href="?module=saldodone" class="animsition-link">
                            Saldo - Selesai
                        </a>
                    </li>
                    <li class="list-item">
                        <a href="?module=saldocancel" class="animsition-link">
                            Saldo - Cancel
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
                <div class="panel">
                    <div class="panel-heading">
                        <h5 class="panel-title">Saldo - Proses</h5>
                    </div>
                    <div class="panel-body container-fluid table-detail">
                        <div class="table-full table-view">
                            <div class="navigation-btn">
                                <form method="get" action='<?php echo $_SERVER[' PHP_SELF '] ?>'>
                                    <div class='btn-navigation'>
                                        <div class='pull-right'>
                                            <a class="btn btn-primary" href="?module=saldocancel">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <th>No</th>
                                        <th>Pelanggan</th>
                                        <th>Foto</th>
                                        <th>Total Isi Saldo</th>
                                        <th>Dibuat</th>
                                        <th>Terakhir diubah</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (empty(isset($_GET['filter']))) {
                                            $p      = new Paging;
                                            $batas  = 10;
                                            $posisi = $p->cariPosisi($batas);

                                            $result=mysqli_query($connect,"SELECT * FROM saldo WHERE saldo_status='cancel' AND pelanggan_username='$_SESSION[pelanggan_username]' ORDER BY saldo_created DESC LIMIT $posisi,$batas");
                                            $jmldata = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM saldo WHERE saldo_status='cancel' AND pelanggan_username='$_SESSION[pelanggan_username]'"));
                                            if(mysqli_num_rows($result) === 0) {
                                    ?>
                                            <tr>
                                                <td class="text-center" colspan="10">Data kosong...</td>
                                            </tr>
                                            <?php } else {
                                                $no = $posisi+1;
                                                while ($r=mysqli_fetch_array($result)) {
                                                $tanggal=tgl_indo($r['saldo_created']);
                                                $tanggal2=tgl_indo($r['saldo_updated']);
                                                $saldo_price=format_rupiah($r['saldo_price']);
                                                ?>
                                            <tr>
                                                <td>
                                                    <?php echo $no; ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $result2 = mysqli_query($connect, "SELECT * FROM pelanggan WHERE pelanggan_username='$r[pelanggan_username]'");
                                                    $pelanggan      = mysqli_fetch_array($result2);
                                                    ?>
                                                    <a href="?module=pelanggan&act=detail&id=<?php echo $pelanggan['pelanggan_username']; ?>">
                                                        <?php echo $pelanggan['pelanggan_name']; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="admin/assets/images/saldo/<?php echo $r['saldo_photo'] ?>" target="_blank">
                                                        <img style="width: 100px" src="admin/assets/images/saldo/<?php echo $r['saldo_photo'] ?>">
                                                    </a>
                                                </td>
                                                <td>
                                                <?php echo $r['saldo_cancel']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $tanggal?>
                                                </td>
                                                <td>
                                                    <?php echo $tanggal2?>
                                                </td>
                                                <?php $no++; } ?>
                                            </tr>
                                            <?php }
                                                $jmldata = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM saldo WHERE saldo_status='cancel' AND pelanggan_username='$_SESSION[pelanggan_username]'"));
                                                $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
                                                $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
                                            } else {
                                            $p      = new Paging;
                                            $batas  = 10;
                                            $posisi = $p->cariPosisi($batas);
                                            $search = $_GET['filter'];

                                            $result=mysqli_query($connect,"SELECT * FROM saldo WHERE saldo_name LIKE '%$search%' AND saldo_status='cancel' LIMIT $posisi,$batas");
                                            $jmldata = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM saldo WHERE saldo_name LIKE '%$search%' AND saldo_status='cancel'"));
                                            if(mysqli_num_rows($result) === 0) {
                                    ?>
                                            <tr>
                                                <td class="text-center" colspan="10">Pencarian tidak ditemukan...</td>
                                            </tr>
                                            <?php } else {
                                                $no = $posisi+1;
                                                while ($r=mysqli_fetch_array($result)) {
                                                $tanggal=tgl_indo($r['saldo_created']);
                                                $tanggal2=tgl_indo($r['saldo_updated']);
                                                $saldo_price=format_rupiah($r['saldo_price']);
                                                ?>
                                            <tr>
                                                                <td>
                                                    <?php echo $no; ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $result2 = mysqli_query($connect, "SELECT * FROM pelanggan WHERE pelanggan_username='$r[pelanggan_username]'");
                                                    $pelanggan      = mysqli_fetch_array($result2);
                                                    ?>
                                                    <a href="?module=pelanggan&act=detail&id=<?php echo $pelanggan['pelanggan_username']; ?>">
                                                        <?php echo $pelanggan['pelanggan_name']; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="admin/assets/images/saldo/<?php echo $r['saldo_photo'] ?>" target="_blank">
                                                        <img style="width: 100px" src="admin/assets/images/saldo/<?php echo $r['saldo_photo'] ?>">
                                                    </a>
                                                </td>
                                                <td>
                                                <?php echo $r['saldo_cancel']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $tanggal?>
                                                </td>
                                                <td>
                                                    <?php echo $tanggal2?>
                                                </td>
                                                <?php $no++; } ?>
                                            </tr>
                                            <?php }
                                                $jmldata = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM saldo WHERE saldo_name LIKE '%$search%' AND saldo_status='cancel'"));
                                                $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
                                                $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
                                            } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="wrapper">
                                <div class="paging">
                                    <div id='pagination'>
                                        <div class='pagination-right'>
                                            <ul class="pagination">
                                                <?php echo $linkHalaman ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="total">Total :
                                    <?php echo $jmldata;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        break;
        case "cancel":
        $result = mysqli_query($connect, "SELECT * FROM saldo WHERE saldo_id='$_GET[id]'");
        $p      = mysqli_fetch_array($result);
        ?>
        <form action="<?php echo $action ?>" method="post" enctype="multipart/form-data" id="exampleStandardForm" autocomplete="off">
            <div class="page-content container-fluid">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h5 class="panel-title">Cancel Isi Saldo #
                                <?php echo $p['saldo_id']?>
                            </h5>
                        </div>
                        <div class="panel-body container-fluid">
                            <div class="form-group form-material">
                                <label class="control-label" for="inputText">Order ID</label>
                                <input type="text" readonly class="form-control input-sm" id="saldo_id" name="saldo_id" placeholder="Masukan Order ID"
                                    value="<?php echo $p['saldo_id']?>" required/>
                            </div>
                            <div class="form-group form-material">
                                <label class="control-label" for="inputText">Alasan Cancel</label>
                                <input type="text" class="form-control input-sm" id="saldo_cancel" name="saldo_cancel" placeholder="Masukan Alasan Cancel"
                                    value="" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-12">
                    <div class='button text-center'>
                        <input class="btn btn-primary btn-sm" type="submit" name="simpan" value="Cancel Isi Saldo" id="validateButton2">
                        <a class="btn btn-default btn-sm" href="?module=saldocancel">Kembali</a>
                    </div>
                </div>
            </div>
        </form>
        <?php
        break;
        case "accept":
        $result = mysqli_query($connect, "SELECT * FROM saldo WHERE saldo_id='$_GET[id]'");
        $p      = mysqli_fetch_array($result);
        ?>
        <form action="<?php echo $action ?>" method="post" enctype="multipart/form-data" id="exampleStandardForm" autocomplete="off">
            <div class="page-content container-fluid">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h5 class="panel-title">Isi Saldo #
                                <?php echo $p['saldo_id']?>
                            </h5>
                        </div>
                        <div class="panel-body container-fluid">
                            <div class="form-group form-material">
                                <label class="control-label" for="inputText">Order ID</label>
                                <input type="text" readonly class="form-control input-sm" id="saldo_id" name="saldo_id" placeholder="Masukan Order ID"
                                    value="<?php echo $p['saldo_id']?>" required/>
                            </div>
                            <div class="form-group form-material">
                                <label class="control-label" for="inputText">Pelanggan Username</label>
                                <input type="text" readonly class="form-control input-sm" id="pelanggan_username" name="pelanggan_username" placeholder=""
                                    value="<?php echo $p['pelanggan_username']?>" required/>
                            </div>
                            <div class="form-group form-material">
                                <label class="control-label" for="inputText">Total Isi Saldo</label>
                                <input type="text" class="form-control input-sm" id="saldo_price" name="saldo_price" placeholder="Masukan Total isi Saldo"
                                    value="" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-12">
                    <div class='button text-center'>
                        <input class="btn btn-primary btn-sm" type="submit" name="simpan" value="Isi Saldo" id="validateButton2">
                        <a class="btn btn-default btn-sm" href="?module=saldocancel">Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    <?php
        break;
        case "add":
        ?>

        <form action="<?php echo $action ?>" method="post" enctype="multipart/form-data" id="exampleStandardForm" autocomplete="off">
            <div class="page-content container-fluid">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel">
                        <div class="panel-heading">
                            <h5 class="panel-title">Tambah Saldo - Proses</h5>
                        </div>
                        <div class="panel-body container-fluid">
                            <div class="form-material">
                                <label class="control-label" for="inputText">Bukti Pembayaran</label>
                            </div>
                            <input name="fupload" type="file" class="form-control" id="fupload" required/>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class='button text-center'>
                        <input class="btn btn-primary btn-sm" type="submit" name="simpan" value="Tambah Data" id="validateButton2">
                        <a class="btn btn-default btn-sm" href="?module=saldocancel">Kembali</a>
                    </div>
                </div>
            </div>
        </form>

        <?php
        break;
    }}
?>