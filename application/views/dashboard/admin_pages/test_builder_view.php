
<!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                REPORTS
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?=base_url()?>index.php/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">REPORTS</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">BUILD REPORT</h3>
                        </div>
                        <div class="box-body table-responsive">
                                 <!-- Create a number of restrictions to complete the previous sql query from before and create/update a new report -->
                                    <form method="POST" action ="<?php echo base_url();?>index.php/finances/transformQuery">
                                        <?php for($i = 0; $i < $numRow; $i++): ?>
                                        	<select name="column<?php echo $i ?>">
	                                        	<option value = "0">Select...</option>
	                                        	<?php for($counterC=0; $counterC < count($nameColumns); $counterC++): ?>
	                                        		<option value="<?php echo $nameColumns[$counterC]['name'] ?>"> <?php echo $nameColumns[$counterC]['name']; ?></option>
	                                        	<?php endfor; ?>
                                        	</select>
                                        	<select name="data<?php echo $i ?>">
	                                        	<option value = "0">Select...</option>
	                                        	<?php for($counterT=0; $counterT < count($type); $counterT++): ?>
	                                        		<option value="<?php echo $type[$counterT]; ?>"> <?php echo $type[$counterT]; ?></option>
	                                        	<?php endfor; ?>
                                        	</select>
                                          <?php  echo '<input type="text" name="restriction'.$i.'" />'; ?>
                                          
                                          <br />
                                        <?php endfor; ?>
                                        <input name="nRow" hidden value="<?php echo $numRow; ?>">
                                        <button class="btn btn-primary">Build Report</button>
                                    </form>
                                    <br />
                                 
                                 </div>
                    </div>
                </div>
            </div>
        </section>
    </aside>
 