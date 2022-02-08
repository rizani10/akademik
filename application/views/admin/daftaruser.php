<div id="content">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $judul; ?></h1>

        <div class="row">
            <div class="col-lg">

                <!-- flash data -->
                <?= $this->session->flashdata('pesan');
                ?>
                <!-- flash data -->

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar User</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama </th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Tanggal Registrasi</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($usr as $u) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $u['nama']; ?></td>
                                            <td><?= $u['email']; ?></td>
                                            <td>
                                                <?= $u['role']; ?>
                                                <button type="button" data-toggle="modal" data-target="#editRole<?= $u['id'] ?>" class="btn btn-warning btn-sm" title="Edit Data">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </td>
                                            <td><?= date('d F Y', $u['tgl_buat']) ?></td>
                                            <td><img src="<?= base_url('assets/img/profil/') . $u['foto']; ?>" alt="" width="100px" height="100px"> </td>
                                            <td>
                                                <a href="" class="btn btn-danger" title="Hapus Data">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
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
    </div>
    <!-- /.container-fluid -->
</div>

<!-- modal edit role -->
<?php foreach ($usr as $u) : ?>
    <div class="modal fade" id="editRole<?= $u['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('admin/editrole') ?>
                <input type="hidden" name="email" value="<?= $u['email']; ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="role_id" id="salutation" class="form-control">
                            <option value="<?= $u['role_id'] ?>"><?= $u['role'] ?></option>
                            <?php foreach ($role as $r) : ?>
                                <option value="<?= $r['id'] ?>"><?= $r['role']; ?></option>
                            <?php endforeach; ?>
                        </select>
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
<!-- modal edit role -->