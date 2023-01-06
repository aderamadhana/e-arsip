<style>
    .grid-margin {
        margin-bottom: 2.5rem;
    }

    @media (min-width: 576px) {
        .grid-margin-sm-0 {
            margin-bottom: 0;
        }
    }

    @media (min-width: 768px) {
        .grid-margin-md-0 {
            margin-bottom: 0;
        }
    }

    @media (min-width: 992px) {
        .grid-margin-lg-0 {
            margin-bottom: 0;
        }
    }

    @media (min-width: 1200px) {
        .grid-margin-xl-0 {
            margin-bottom: 0;
        }
    }

    .stretch-card {
        display: -webkit-flex;
        display: flex;
        -webkit-align-items: stretch;
        align-items: stretch;
        -webkit-justify-content: stretch;
        justify-content: stretch;
    }

    .stretch-card>.card {
        width: 100%;
        min-width: 100%;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid #e3e3e3;
        border-radius: 20px;
    }

    .card.card-light-danger {
        background: #F3797E;
        color: #ffffff;
    }

    .card.card-light-danger:hover {
        background: #f59095;
    }

    .mt-4,
    .my-4 {
        margin-top: 1.5rem !important;
    }

    .card>.card-header+.list-group,
    .card>.list-group+.card-footer {
        border-top: 0;
    }

    .card-body2 {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1.25rem;
    }

    .card.tale-bg {
        background: #DAE7FF;
    }

    .card.card-tale {
        background: #439ffa;
        color: #ffffff;
    }

    .card.card-tale:hover {
        background: #0b7ee6 !important;
    }

    .card-people {
        position: relative;
        padding-top: 20px;
    }

    .card-people img {
        border-radius: 20px;
        width: 100%;
    }

    .card-people .logo {
        border-radius: 0px;
        width: 100%;
    }

    .mb-lg-0,
    .my-lg-0 {
        margin-bottom: 0 !important;
    }

    .mt-auto,
    .my-auto {
        margin-top: auto !important;
    }

    .card.transparent {
        background: transparent;
    }

    .card .card-body2 {
        padding: 1.25rem 1.25rem;
    }

    .card .card-body2+.card-body2 {
        padding-top: 1rem;
    }

    .card.card-dark-blue {
        background: #439ffa;
        color: #ffffff;
    }

    .card.card-dark-blue:hover {
        background: #0b7ee6 !important;
    }

    .card.card-light-blue {
        background: #439ffa;
        color: #ffffff;
    }

    .card.card-light-blue:hover {
        background: #0b7ee6 !important;
    }

    .mb-4,
    .my-4 {
        margin-bottom: 0.5rem !important;
    }

    .fs-30 {
        font-size: 30px;
    }

    .mb-2,
    .my-2 {
        margin-bottom: 0.5rem !important;
    }

    .mb-0,
    .my-0 {
        margin-bottom: 0 !important;
    }

    .font-weight-normal {
        font-weight: 400 !important;
    }

    .ml-2,
    .btn-toolbar .btn-group+.btn-group,
    .btn-toolbar .fc .fc-button-group+.btn-group,
    .fc .btn-toolbar .fc-button-group+.btn-group,
    .btn-toolbar .fc .btn-group+.fc-button-group,
    .fc .btn-toolbar .btn-group+.fc-button-group,
    .btn-toolbar .fc .fc-button-group+.fc-button-group,
    .fc .btn-toolbar .fc-button-group+.fc-button-group,
    .rtl .settings-panel .events i,
    .mx-2 {
        margin-left: 0.5rem !important;
    }

    .row-flex {
        display: flex;
        flex-wrap: wrap;
    }
</style>

<div class="content-wrapper" style="background-color: #F5F7FF;">
    <section class="content">
        <div class="row row-flex">
            <?php
            $role = $this->mymodel->selectDataone('role', ['id' => $this->session->userdata('role_id')]);
            $jsonmenu = json_decode($role['menu']);

            $departement = $this->mymodel->selectDataone('m_departemen', ['id' => $this->session->userdata('departement')]);
            $departmentmenu = json_decode($departement['menu']);

            $this->db->order_by('urutan asc');
            $this->db->group_start();
            $this->db->where_in('id', $jsonmenu);
            $this->db->or_where_in('id', $departmentmenu);
            $this->db->group_end();
            $menu = $this->mymodel->selectWhere('menu_master', ['parent' => 1, 'status' => 'ENABLE']);
            if (count($menu) > 0) {
                echo '<div class="col-md-8 col-xs-12 grid-margin transparent">';
            } else {
                echo '<div class="col-md-12 col-xs-12 grid-margin transparent">';
            }
            ?>
            <div class="row" style="height: 100%;">
                <div class="col-md-12 mb-4 stretch-card transparent" style="height: inherit;">
                    <div class="card">
                        <div class="card-body2" style="display: flex;align-items: center;">
                            <div class="row" style="display: flex;align-items: center;width:100%">
                                <div class="col-md-4">
                                    <img src="<?= LOGO ?>" class="img-responsive" style="width: 200px;margin:auto">
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        <h4><b><span style="font-size: 25px;">Platform Kerjamu, Digimon! <br /> (Digital Arsip & Monitoring Corporate Secretary Division)</span></b></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (count($menu) > 0) { ?>
            <div class="col-md-4 col-xs-12 grid-margin transparent">
                <div class="row">
                    <?php
                    foreach ($menu as $m) {
                        if ($m['type'] == 'menu') {
                            if ($m['name'] == 'Vendor/Konsultan') { ?>
                                <!-- <div class="col-md-3"></div> -->
                                <div class="col-md-12 mb-4 stretch-card transparent" onclick="dashboardClicked('<?= base_url($m['function']) ?>', '<?= $m['name'] ?>')" style="cursor:pointer">
                                <?php } else { ?>
                                    <div class="col-md-12 mb-4 stretch-card transparent" onclick="dashboardClicked('<?= base_url($m['function']) ?>', '<?= $m['name'] ?>')" style="cursor:pointer">
                                    <?php }

                                if ($m['name'] == 'Arsip') {
                                    echo '<div class="card card-tale" id="menu-Arsip">';
                                } else if ($m['name'] == 'Sponsorship') {
                                    echo '<div class="card card-light-blue" id="menu-Sponsorship">';
                                } else {
                                    echo '<div class="card card-dark-blue" id="menu-Vendor">';
                                }
                                    ?>
                                    <div class="card-body2">
                                        <p class="mb-4">
                                            <?php
                                            if ($m['type_icon'] == 'image') {
                                            ?>
                                                <img src="<?= base_url('assets/images'); ?>/<?= $m['icon']; ?>" width="45px" height="45px" />
                                            <?php
                                            } else {
                                            ?>
                                                <i class="<?= $m['icon'] ?>" style="font-size: 3em;"></i>
                                            <?php
                                            }
                                            ?>
                                            &emsp;<span style="font-size: 16px;">Dashboard <?= $m['name'] ?></span>
                                        </p>
                                    </div>
                                    </div>
                                </div>

                        <?php }
                    }
                        ?>
                </div>
            </div>
        <?php } ?>
</div>
<div class="row">
    <div id="load-dashboard"></div>
</div>
</section>
</div>

<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="<?= base_url('assets/') ?>vendor2/js/hoverable-collapse.js"></script>
<script src="<?= base_url('assets/') ?>vendor2/js/template.js"></script>
<script src="<?= base_url('assets/') ?>vendor2/js/settings.js"></script>
<script src="<?= base_url('assets/') ?>vendor2/js/todolist.js"></script>
<!-- endinject -->

<script>
    $(document).ready(function() {
        $('#load-dashboard').load('home/arsip');
        $('#menu-Arsip').css("background", "#0b7ee6");
        return false;
    });

    function dashboardClicked(param, id) {
        $('#load-dashboard').load(param);
        if (id == 'Arsip') {
            $('#menu-Arsip').css("background", "#0b7ee6");
            $('#menu-Sponsorship').css("background", "#439ffa");
            $('#menu-Vendor').css("background", "#439ffa");
        } else if (id == 'Sponsorship') {
            $('#menu-Arsip').css("background", "#439ffa");
            $('#menu-Sponsorship').css("background", "#0b7ee6");
            $('#menu-Vendor').css("background", "#439ffa");
        } else {
            $('#menu-Arsip').css("background", "#439ffa");
            $('#menu-Sponsorship').css("background", "#439ffa");
            $('#menu-Vendor').css("background", "#0b7ee6");
        }
        return false;
    }
</script>