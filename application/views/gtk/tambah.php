<div id="content">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $judul; ?></h1>



        <div class="row">
            <div class="col-lg">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Data Guru</h6>
                    </div>
                    <div class="card-body">
                        <form>

                            <div class="form-row mb-4">
                                <div class="col">
                                <label for="nama">Nama</label>
                                    <input type="text" class="form-control" placeholder="Masukkan Nama" id="nama" name="nama">
                                </div>
                                <div class="col">
                                <label for="nip">NIP</label>
                                    <input type="text" class="form-control" placeholder="Masukkan NIP" id="nip" name="nip">
                                </div>
                            </div>


                            <div class="form-row mb-4">
                                <div class="col">
                                    <label for="nuptk">NUPTK</label>
                                    <input type="text" class="form-control" placeholder="Masukkan NUPTK" id="nuptk" name="nuptk">
                                </div>
                                <div class="col">
                                    <label for="jk">Jenis Kelamin</label>
                                    <select name="jk" id="theSelect" class="form-control">
                                        <option disable>Silahkan Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <div class="col">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" class="form-control" placeholder="Masukkan Tempat Lahir" id="tempat_lahir" name="tempat_lahir">
                                </div>
                                <div class="col">
                                    <label for="tanggal">Tanggal Lahir</label>
                                    <input type="text" class="form-control" placeholder="Masukkan Tanggal Lahir" id="tanggal" name="tgl_lahir">
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <div class="col">
                                <label for="kepegawaian">Kepegawaian</label>
                                    <select name="kepegawaian" id="kepegawaian" class="form-control">
                                        <option value="">Silahkan Pilih</option>
                                        <option value="Pegawai Negeri Sipil">Pegawai Negeri Sipil</option>
                                        <option value="Honorer">Honorer</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Last name">
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="First name">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Last name">
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="First name">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Last name">
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="First name">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Last name">
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="First name">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Last name">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- /.container-fluid -->
</div>