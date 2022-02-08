<div id="content">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $judul;  ?></h1>


        <!-- pemberitahuan -->
        <div class="row">
            <div class="col-lg-6">
                <?= $this->session->flashdata('pesan');
                ?>
            </div>
        </div>
        <!-- pemberitahuan -->

        <div class="card mb-3 col-lg-8" style="max-width: 620px;">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="<?= base_url('assets/img/profil/') . $user['foto']; ?>" class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?= $user['nama'] ?></h5>
                        <p class="card-text"><?= $user['email'] ?></p>
                        <p class="card-text"><small class="text-muted">Terdaftar Sejak <?= date('d F Y', $user['tgl_buat']) ?></small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>