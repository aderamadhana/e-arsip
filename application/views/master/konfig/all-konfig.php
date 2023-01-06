 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" style="background-color: #F5F7FF;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Konfig
        <small>master</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">master</a></li>
        <li class="active">Konfig</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
              <div class="row">
                <div class="col-md-6">
                 
                </div>
                <div class="col-md-6">
                  <div class="pull-right">
                  <!-- <a href="<?= base_url('master/Konfig/create') ?>">
                    <button type="button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Konfig</button> 
                  </a> -->
                   </div>
                </div>  
              </div>
              
            </div>
            <div class="box-body">
              
              <form action="<?= base_url('master/konfig/update_all') ?>" method="POST" role="form" enctype="multipart/form-data"> 
              <?php
                $this->db->where_in('slug', ['TITLE_APPLICATION','APPLICATION','LOGO','LOGIN_BACKGROUND','VERSION','COPYRIGHT','TERM_CONDITION','CATATAN_CV']);
                $this->db->order_by("FIELD(slug,'TITLE_APPLICATION','APPLICATION','VERSION','COPYRIGHT','TERM_CONDITION','CATATAN_CV') ASC");
                $konfig = $this->mymodel->selectWhere('konfig',['status'=>'ENABLE']);
                foreach($konfig as $k){
              ?>
                  <div class="form-group">
                      <?php if($k['slug']=="LOGO" || $k['slug'] == 'LOGIN_BACKGROUND'):
                        if($k['value']!=''):
                      ?>
                        <a target="_blank" href="<?= $k['value'] ?>" class="btn btn-primary btn-xs pull-right"> <i class="fa fa-eye"></i> Preview</a>
                      <?php 
                        else :
                      ?>
                        <button type="button" class="btn btn-danger btn-xs pull-right"><i class="fa fa-times"></i> Data Kosong</button>
                      <?php
                          endif; 
                        endif; 
                      ?>
                      <label for=""><?= $k['slug'] ?></label>
                      <?php if($k['slug']=="SKIN"){ ?>
                        <!-- <input type="text" class="form-control" name="dt[<?= $k['slug'] ?>]" id="" placeholder="Input <?= $k['slug'] ?>" value="<?= $k['value'] ?>"> -->
                        
                        <select name="dt[<?= $k['slug'] ?>]"  id="input" class="form-control" required="required">
                            <option value="skin-blue" <?php if($k['value']=="black") echo "selected"; ?>>skin-blue</option>
                            <option value="skin-blue-light" <?php if($k['value']=="skin-blue-light") echo "selected"; ?>>skin-blue-light</option>
                            <option value="skin-yellow" <?php if($k['value']=="skin-yellow") echo "selected"; ?>>skin-yellow</option>
                            <option value="skin-yellow-light" <?php if($k['value']=="skin-yellow-light") echo "selected"; ?>>skin-yellow-light</option>
                            <option value="skin-green" <?php if($k['value']=="skin-green") echo "selected"; ?>>skin-green</option>
                            <option value="skin-green-light" <?php if($k['value']=="skin-green-light") echo "selected"; ?>>skin-green-light</option>
                            <option value="skin-purple" <?php if($k['value']=="skin-purple") echo "selected"; ?>>skin-purple</option>
                            <option value="skin-purple-light" <?php if($k['value']=="skin-purple-light") echo "selected"; ?>>skin-purple-light</option>
                            <option value="skin-red" <?php if($k['value']=="skin-red") echo "selected"; ?>>skin-red</option>
                            <option value="skin-red-light" <?php if($k['value']=="skin-red-light") echo "selected"; ?>>skin-red-light</option>
                            <option value="skin-black" <?php if($k['value']=="skin-black") echo "selected"; ?>>skin-black</option>
                            <option value="skin-black-light" <?php if($k['value']=="skin-black-light") echo "selected"; ?>>skin-black-light</option>
                            
                        </select>
                        
                      <?php }else if($k['slug']=="CAPTCHA" || $k['slug']=="FAIL_ATTEMP" || $k['slug']=="EMAIL_VERIFICATION" || $k['slug']=="REGISTER" || $k['slug']=="ONE_TIME_LOGIN" ){ ?>
                        <br>
                        <input type="radio" name="dt[<?= $k['slug'] ?>]" id="" placeholder="Input <?= $k['slug'] ?>" value="0" <?php if($k['value']==0) echo "checked" ?>> Ya &nbsp;&nbsp;&nbsp;
                        <input type="radio" name="dt[<?= $k['slug'] ?>]" id="" placeholder="Input <?= $k['slug'] ?>" value="1" <?php if($k['value']==1) echo "checked" ?>> Tidak
                        <?php }else if($k['slug']=="COPYRIGHT" || $k['slug'] == 'TERM_CONDITION'){ ?>
                      <textarea class="form-control" name="dt[<?= $k['slug'] ?>]" id="" cols="30" rows="3"><?= $k['value'] ?></textarea>
                    <?php }else if($k['slug']=="LOGO" || $k['slug'] == 'LOGIN_BACKGROUND'){ ?>
                      <input type="file" name="<?= $k['slug'] ?>" class="form-control">
                      <?php }else{ ?>
                        <input type="text" class="form-control" name="dt[<?= $k['slug'] ?>]" id="" placeholder="Input <?= $k['slug'] ?>" value="<?= $k['value'] ?>">
                      <?php } ?>
                  </div>
                <?php
                }
                ?>
              
                  
              
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
