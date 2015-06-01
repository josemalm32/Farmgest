
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
                            <h3 class="box-title">REPORT</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <?php if ($file == "successExcel") :?>
							<a href="<?=base_url()?>/report.xls">Download Report</a>
							<form method="POST" action="<?php echo base_url();?>index.php/finances/tableQuery">
								<label> Number of Restrictions: </label>
                            	<input type="text" name="numRow" /> <br /><br />        
                                <button class="btn btn-primary">Build Report</button>
                            </form>    
							<br/><br/>
							<a href="<?=base_url()?>index.php/dashboard">Voltar</a></button>
						<?php endif; ?>
						<?php if ($file == "successWord") :?>
							<a href="<?=base_url()?>/report.docx">Download Report</a>
							<form method="POST" action="<?php echo base_url();?>index.php/finances/tableQuery">
								<label> Number of Restrictions: </label>
                            	<input type="text" name="numRow" /> <br /><br />        
                                <button class="btn btn-primary">Build Report</button>
                            </form>
							<br/><br/>
							<a href="<?=base_url()?>index.php/dashboard">Voltar</a></button>
						<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	</aside>
 