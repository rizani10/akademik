        <!-- Page Wrapper -->
        <div id="wrapper">
            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                    <div class="sidebar-brand-icon rotate-n-15">
                        <i class="fas fa-laugh-wink"></i>
                    </div>
                    <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider">


                <!-- QUERY dari menu -->
                <?php
                $role_id =
                    $this->session->userdata('role_id');

                $queryMenu = "SELECT `user_menu`.`id`, `menu`
                            FROM `user_menu` 
                                JOIN `user_akses_menu` 
                            ON `user_menu`.`id` = `user_akses_menu`.`menu_id`
                        WHERE `user_akses_menu`.`role_id` = $role_id
                        ORDER BY `user_akses_menu`.`menu_id` ASC
                    ";

                // panggil menu
                $menu = $this->db->query($queryMenu)->result_array();


                ?>

                <!-- Looping Menu nya -->
                <?php foreach ($menu as $mn) : ?>
                    <div class="sidebar-heading">
                        <?= $mn['menu'] ?>
                    </div>

                    <!-- menyiapkan sub menu berdasarkan menu nya -->
                    <?php
                    //    tentukan menunya
                    $menuId = $mn['id'];
                    // query sub menu
                    $querySubMenu = "SELECT * FROM `user_sub_menu`
                                        WHERE `menu_id` = $menuId
                                        AND `aktive` = 1
                                    ";

                    // masukkan lagi kedalam result
                    $subMenu = $this->db->query($querySubMenu)->result_array();
                    ?>

                    <!-- foreach tampilkan submenunya -->
                    <?php foreach ($subMenu as $sm) : ?>
                        <!-- menampikan li activ -->
                        <?php if ($judul == $sm['judul']) : ?>
                            <li class="nav-item active">
                            <?php else : ?>
                            <li class="nav-item">
                            <?php endif; ?>
                            <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
                                <i class="<?= $sm['icon']; ?>"></i>
                                <span><?= $sm['judul'] ?></span>
                            </a>
                            </li>

                        <?php endforeach; ?>
                        <hr class="sidebar-divider mt-3">
                    <?php endforeach; ?>


                    <!-- Nav Item - Dashboard -->


                    <!-- Divider -->
                    <!-- <hr class="sidebar-divider"> -->

                    <!-- Heading -->
                    <!-- <div class="sidebar-heading">
                    Tata Usaha
                </div> -->

                    <!-- Nav Item - Pages Collapse Menu -->
                    <!-- <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>GTK</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">GTK Component</h6>
                            <a class="collapse-item" href="<?= base_url('guru') ?>">Guru</a>
                            <a class="collapse-item" href="">Tenaga Kependidikan</a>
                        </div>
                    </div>
                </li> -->

                    <!-- Nav Item - Utilities Collapse Menu -->
                    <!-- <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Siswa</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Siswa Component : </h6>
                            <a class="collapse-item" href="">Siswa Aktif</a>
                            <a class="collapse-item" href="">Alumni</a>
                        </div>
                    </div>
                </li> -->

                    <!-- <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('user/profil'); ?>">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Profil Saya</span></a>
                </li> -->

                    <!-- <hr class="sidebar-divider"> -->

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
                            <i class="fas fa-fw fa-sign-out-alt"></i>
                            <span>Logout</span></a>
                    </li>
                    <!-- Sidebar Toggler (Sidebar) -->
                    <div class="text-center d-none d-md-inline">
                        <button class="rounded-circle border-0" id="sidebarToggle"></button>
                    </div>

            </ul>
            <!-- End of Sidebar -->