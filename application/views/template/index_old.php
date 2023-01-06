<style>
	.text-white{
		color: #fff;
	}
	.round {
    border-radius: 20px;
    box-shadow: 0 0 40px 0 rgba(0, 0, 0, .1);
    background: #fff;
}
.card-body {
    padding: 15px;
    margin: 10px 0px;
}
</style>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="box">
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<center>
								<img src="<?=LOGO ?>" class="img-responsive" style="max-width: 100px;">
							</center>
						</div>
						<div class="col-md-12">
							<div class="text-center">
								<h3><b>Platform Kerjamu, Digimon! <br> (Digital Arsip & Monitoring Corporate Secretary Division)<br/><br/>Layanan Pengelolaan Data Secara Online</b></h3>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <div class="row">
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
            foreach ($menu as $m) {
                if ($m['type']=='menu') { ?>
                    <div class="col-md-4">
                        <div class="col-md-12">
                            <div class="card mb-4 box-shadow round" onclick="location.href='<?= base_url($m['function']) ?>';" style="cursor:pointer">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <h4>Dashboard<br/><?= $m['name'] ?></h4>
                                        </div>
                                        <div class="col-lg-3">     
                                            <?php
                                            if($m['type_icon'] == 'image') {
                                                ?>
                                                <img src="<?= base_url('assets/images'); ?>/<?= $m['icon']; ?>" width="90%" />
                                                <?php
                                            } else {
                                                ?>
                                                <i class="<?= $m['icon'] ?>" style="font-size: 3em;"></i>
                                                <?php
                                            }
                                            ?>      
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            }
            ?>
        </div>
    </section>
</div>
