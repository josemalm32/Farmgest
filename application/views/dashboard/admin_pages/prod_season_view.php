<!-- Right side column. Contains the navbar and content of the page -->
	<aside class="right-side">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
            	Season
            </h1>
            <ol class="breadcrumb">
            	<li><a href="<?=base_url()?>index.php/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            	<li class="active">Season</li>
            </ol>
		</section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Season Table</h3>
                        </div>
                        <div class="box-body ">
                            <table >
                                <?php echo $output; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	</aside>
