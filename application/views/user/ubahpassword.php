<div id="content">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $judul; ?></h1>




        <div class="row">
            <div class="col-lg-8">

                <!-- pemberitahuan -->
                <?= $this->session->flashdata('pesan');
                ?>
                <!-- pemberitahuan -->

                <?= form_open('user/ubahpassword'); ?>
                <div class="form-group">
                    <label for="passwordlama">Password Lama</label>
                    <input type="password" name="passwordlama" class="form-control" id="passwordlama">
                    <?= form_error('passwordlama', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="passwordbaru1">Password Baru</label>
                    <input type="password" name="passwordbaru1" class="form-control" id="passwordbaru1">
                    <?= form_error('passwordbaru1', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="passwordbaru2">Konfirmasi Password Baru</label>
                    <input type="password" name="passwordbaru2" class="form-control" id="passwordbaru2">
                    <?= form_error('passwordbaru2', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <button type="submit" class="btn btn-primary">Ubah Password</button>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
</div>