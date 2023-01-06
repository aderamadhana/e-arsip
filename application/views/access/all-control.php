

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Restrict
        <small>Access</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Access</a></li>
        <li class="active">Restrict</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
            <h5 class="box-title">Role : <?= $role['role'] ?></h5>
            </div>
            <form action="<?= base_url('access/store') ?>" method="POST">
            <div class="box-body">
              <input type="hidden" name="role" value="<?= $role['id'] ?>">
              <table class="table table-condensed table-striped table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Folder</th>
                    <th>Class</th>
                    <th>Method</th>
                    <th>Link</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($data_url as $k => $v): ?>
                <?php $cek_akun = $this->mmodel->selectWhere('access_block',['ab_role_id'=>$role['id'],'ab_link'=>$v['val']])->num_rows(); ?>
                  <tr>
                    <td><?= $k+1 ?></td>
                    <td><?= $v['folder'] ?></td>
                    <td><?= $v['class'] ?></td>
                    <td><?= $v['method'] ?></td>
                    <td><?= $v['val'] ?></td>
                    <td>
                       <input type="checkbox" name="link[]" value="<?= $v['val'] ?>" <?= ($cek_akun)?"checked":""; ?>> 
                    </td>
                  </tr>
                 <?php endforeach ?>
                </tbody>
              </table>
              <button class="btn btn-block btn-danger"><i class="fa fa-save"></i> SAVE DATA</button>
            </div>
            </form>
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
