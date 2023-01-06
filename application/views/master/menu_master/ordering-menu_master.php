<style type="text/css">
  /**
   * Nestable
   */

  .dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }

  .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
  .dd-list .dd-list { padding-left: 30px; }
  .dd-collapsed .dd-list { display: none; }

  .dd-item,
  .dd-empty,
  .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

  .dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
      background: #fafafa;
      background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
      background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
      background:         linear-gradient(top, #fafafa 0%, #eee 100%);
      -webkit-border-radius: 3px;
              border-radius: 3px;
      box-sizing: border-box; -moz-box-sizing: border-box;
  }
  .dd-handle:hover { color: #2ea8e5; background: #fff; }

  .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
  .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
  .dd-item > button[data-action="collapse"]:before { content: '-'; }

  .dd-placeholder,
  .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
  .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
      background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                        -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
      background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                           -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
      background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                                linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
      background-size: 60px 60px;
      background-position: 0 0, 30px 30px;
  }

  .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
  .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
  .dd-dragel .dd-handle {
      -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
              box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
  }
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Menu Master
        <small>Master</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">master</a></li>
        <li class="active">Menu Master</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <form method="POST" action="<?= base_url('master/Menu_master/update_ordering') ?>" id="upload-create" enctype="multipart/form-data">

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
              <h5 class="box-title">
                  Ordering Menu Master
              </h5>
            </div>
            <div class="box-body">
                <div class="show_error"></div>
                <?php 
                $this->db->order_by('urutan', 'asc');
                $menu = $this->mmodel->selectWhere('menu_master',['status'=>'ENABLE','parent'=>0])->result(); ?>
                <div class="dd" id="nestable">
                    <ol class="dd-list">
                    <?php foreach ($menu as $vmenu){ ?>                      
                        <li class="dd-item" data-id="<?= $vmenu->id ?>">
                            <div class="dd-handle"><i class="<?= $vmenu->icon ?>"></i> <?= $vmenu->name ?></div>
                            <?php 
                            $this->db->order_by('urutan', 'asc');
                            $menu_child = $this->mmodel->selectWhere('menu_master',['status'=>'ENABLE','parent'=>$vmenu->id])->result(); ?>
                            <?php if (count($menu_child)){ ?>
                            <ol class="dd-list">
                              <?php foreach ($menu_child as $vchild){ ?>
                                <li class="dd-item" data-id="<?= $vchild->id ?>"><div class="dd-handle"><i class="<?= $vchild->icon ?>"></i> <?= $vchild->name ?></div></li>
                              <?php } ?>
                            </ol>
                            <?php } ?>
                        </li>
                    <?php } ?>
                    </ol>
                </div>
                <textarea id="nestable-output" name="menu" class="hidden"></textarea>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>
                <a href="<?= base_url('master/Menu_master/ordering'); ?>" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</a>
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      </form>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script src="<?= base_url('assets/') ?>plugins/nestable/jquery.nestable.js"></script>
  <script type="text/javascript">
    $(document).ready(function()
    {

        var updateOutput = function(e)
        {
            var list   = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        // activate Nestable for list 1
        $('#nestable').nestable()
        .on('change', updateOutput);


        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));;

        $('#nestable-menu').on('click', function(e)
        {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });


    });
  </script>