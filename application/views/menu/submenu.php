<div id="content">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $judul; ?></h1>

        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahSubmenu">
            <i class="fas fa-plus-circle"></i> Tambah Submenu
        </a>

        <div class="row">
            <div class="col-lg">

                <!-- Pemberitahun -->
                <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= validation_errors(); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>'
                        '
                    </div>
                <?php endif; ?>

                <?= $this->session->flashdata('pesan');
                ?>
                <!-- Pemberitahun -->

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Submenu</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Sub Menu</th>
                                        <th>Nama Menu</th>
                                        <th>Url</th>
                                        <th>Icon</th>
                                        <th>Aktif</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($subMenu as $sm) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $sm['judul'] ?></td>
                                            <td><?= $sm['menu'] ?></td>
                                            <td><?= $sm['url'] ?></td>
                                            <td><?= $sm['icon'] ?></td>
                                            <td><?= $sm['aktive'] ?></td>
                                            <td>
                                                <button type="button" class="badge badge-warning" data-toggle="modal" data-target="#edit<?= $sm['id']; ?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="badge badge-danger" data-toggle="modal" data-target="#hapus<?= $sm['id']; ?>">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
</div>



<!-- modal tambah -->
<div class="modal fade" id="tambahSubmenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="menu_id" id="salutation" class="form-control">
                            <option disabled selected>Silahkan Pilih Nama Menu</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="judul" id="judul" placeholder="Nama Submenu">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="url" id="url" placeholder="Url">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="aktive" name="aktive" checked>
                            <label class="form-check-label" for="aktive">
                                Aktif ?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal tambah -->


<!-- modal edit -->
<?php foreach ($subMenu as $sm) : ?>
    <div class="modal fade" id="edit<?= $sm['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Submenu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('menu/editsubmenu'); ?>" method="post">
                    <input type="hidden" name="id" value="<?= $sm['id']; ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="menu_id" id="salutation" class="form-control">
                                <option disabled selected value="<?= $sm['menu_id'] ?>"><?= $sm['menu'] ?></option>
                                <?php foreach ($menu as $m) : ?>
                                    <option value="<?= $m['id'] ?>"><?= $m['menu']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="judul" id="judul" value="<?= $sm['judul'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="url" id="url" value="<?= $sm['url'] ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="icon" id="icon" value="<?= $sm['icon'] ?>">
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="aktive" name="aktive" checked>
                                <label class="form-check-label" for="aktive">
                                    Aktif ?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- modal edit -->

<!-- modal Hapus -->
<?php foreach ($subMenu as $sm) : ?>
    <div class="modal fade" id="hapus<?= $sm['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    Yakin Ingin Menghapus Submenu
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a href="<?= base_url('menu/hapussubmenu/') . $sm['id']; ?>" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- modal Hapus -->