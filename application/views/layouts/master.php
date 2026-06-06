<?php $this->load->view('layouts/header'); ?>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            <?php $this->load->view('layouts/sidebar'); ?>

            <div class="layout-page">
                
                <?php $this->load->view('layouts/topbar'); ?>

                <div class="content-wrapper">
                    
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?php $this->load->view($content); ?>
                    </div>
                    <?php $this->load->view('layouts/footer'); ?>

                    <div class="content-backdrop fade"></div>
                </div>
                </div>
            </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>

    <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/popper/popper.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/js/bootstrap.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/js/menu.js') ?>"></script>
    
    <script src="<?= base_url('assets/js/main.js') ?>"></script>

</body>
</html>