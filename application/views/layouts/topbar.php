<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-md"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            
            <?php 
            // Ambil data foto dari session terbaru
            $session_foto = $this->session->userdata('foto');
            
            // Pengecekan path fisik menggunakan FCPATH agar sinkron di Windows/Laragon
            if (!empty($session_foto) && file_exists(FCPATH . 'uploads/profile/' . $session_foto)) {
                $avatar_src = base_url('uploads/profile/' . $session_foto);
            } else {
                $avatar_src = base_url('assets/img/avatars/1.png'); // Fallback default template
            }
            ?>

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online" style="width: 38px; height: 38px;">
                        <img src="<?= $avatar_src; ?>" alt="User Avatar" class="rounded-circle h-100 w-100 object-fit-cover" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <div class="dropdown-item mt-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online" style="width: 40px; height: 40px;">
                                        <img src="<?= $avatar_src; ?>" alt="User Avatar" class="rounded-circle h-100 w-100 object-fit-cover" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold"><?= $this->session->userdata('nama'); ?></h6>
                                    <small class="text-muted"><?= ucfirst($this->session->userdata('role')); ?></small>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <li><div class="dropdown-divider my-1 mx-n2"></div></li>

                    <li>
                        <?php 
                        $role_aktif = $this->session->userdata('role');
                        $url_profil = base_url($role_aktif . '/dashboard');
                        
                        if ($role_aktif == 'admin') {
                            $url_profil = base_url('admin/admin_manage/profil');
                        }
                        ?>
                        <a class="dropdown-item py-2" href="<?= $url_profil; ?>">
                            <i class="ti ti-user-check me-3 ti-md text-primary"></i>
                            <span class="align-middle fw-medium">Edit Profil Saya</span>
                        </a>
                    </li>

                    <li><div class="dropdown-divider my-1 mx-n2"></div></li>

                    <li>
                        <div class="d-grid px-2 pt-2 pb-1">
                            <a class="btn btn-sm btn-danger d-flex align-items-center justify-content-center gap-2" href="<?= base_url('auth/logout') ?>">
                                <small class="align-middle fw-semibold">Keluar Aplikasi</small>
                                <i class="ti ti-logout ti-14px"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>