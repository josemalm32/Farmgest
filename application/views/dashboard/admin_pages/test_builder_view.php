            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url()?>index.php/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-6 connectedSortable"> 
                            
                            <div class="box box-primary">
                                <div class="box-header">
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                        
                                    </div><!-- /. tools -->
                                    <i class="fa fa-cloud"></i>

                                    <h3 class="box-title">Query Builder</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body padding">
                                <?php if($numRow == 0) :?>
                                    <form method="POST" action="tableQuery">
                                        <label> Select your Table: </label><br />
                                        <?php echo form_dropdown('table', $tables) ?>
                                        <br /> <br /> 
                                        <label> Number of Restrictions: </label>
                                        <input type="text" name="numRow" /> <br /><br />
                                        <button class="btn btn-primary">Build Restrictions</button>
                                    </form>
                                    <br />
                                <?php endif; ?>
                                <?php if($numRow > 1) : ?>
                                    <form method="POST" action ="" >
                                        <?php for($i = 0; $i < $numRow; $i++){
                                            echo form_dropdown('column', $columns[$i]['column_name']);
                                            echo form_dropdown('data', $type);
                                            echo '<input type="text" name="value'.$i.'" />';
                                        }
                                        ?>
                                        <button class="btn btn-primary">Build Query</button>
                                    </form>
                                    <br />
                                <?php endif; ?>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->        

                        </section>
                </div>
            </aside>
 

