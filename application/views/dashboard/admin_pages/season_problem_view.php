<aside class="right-side">
	<section class="content">
                    <div class="row">
                        <div class="col-md-12">
                        <div class="box box-primary">
                        <div class="box-header">
                                    <h3 class="box-title">Insert Problem</h3>
                                </div>
                                <div class="box-body">
			<form method="POST" action="<?=base_url()?>index.php/rastreability/problemDB">
				<div id="frame">
				<!-- print the entity -->
					<table>
						<tbody>
						<?php 
						for($i = 0, $size = count($season_rows)-1; $i < $size; $i++) {
							// print line by farm
							if($i == 0) 
								echo '<tr>';
							
							if($flag == 1){
								echo '</tr>';
								echo '<tr>';
								$flag = 0;
							}
							if($season_rows[$i]['id_field'] == $season_rows[$i+1]['id_field']) {
								echo '<td>';?>
								<div id="<?php echo $season_rows[$i]['id'], ' '; ?>" onclick="myFunction(this, 'red')" style="width:60px; height:60px; border:1px solid #aaaaaa;background:#CCFF99">
								<center><?php echo $season_rows[$i]['section_name'] ?></center></div>
							    <?php echo '</td>';
							}else{
								$flag = 1;
								echo '<td>';?>
								<div id="<?php echo $season_rows[$i]['id'], ' '; ?>" onclick="myFunction(this, 'red')" style="width:60px; height:60px; border:1px solid #aaaaaa;background:#CCFF99">
								<center><?php echo $season_rows[$i]['section_name'] ?></center></div>
							    <?php echo '</td>';
							}
							
							if($i == $size-1){
								echo '<td>';?>
								<div id="<?php echo $season_rows[$i]['id'], ' '; ?>" onclick="myFunction(this, 'red')" style="width:60px; height:60px; border:1px solid #aaaaaa;background:#CCFF99">
								<center><?php echo $season_rows[$i]['section_name'] ?></center></div>
							    <?php echo '</td>';
								echo '</tr>';
							}
						}?>
				        </tbody>
				    </table>
			    </div>
			    <input type="text" id="allValues" name="allValues" hidden>
                                
                                
                                    

                                   
                                   		<div class="form-group">
                                            <label>Name</label>
                                            <input name="name" type="text" class="form-control" placeholder="Enter ..."/>
                                        </div>

                                    	<div class="form-group">
                                            <label>Select type</label>
                                            <select name="type" class="form-control">
                                                <option value="0">Disease</option>
                                                <option value="2">Weed</option>
                                                <option value="1">Pest</option>
                                                <option value="3">Other</option>
                                            </select>
                                        </div>

                                    <div class="form-group">
                                            <label>Select Status</label>
                                            <select name="status" class="form-control">
                                                <option value="0">Active</option>
                                                <option value="2">Closed</option>
                                                <option value="1">Solved</option>
                                            </select>
                                        </div>

                                    <!-- Date dd/mm/yyyy -->
                                    <div class="form-group">
                                        <label>Date Start: (yyyy-mm-dd)</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input name="dStart" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                                        </div><!-- /.input group -->
                                    </div><!-- /.form group -->

                                    <!-- Date mm/dd/yyyy -->
                                    <div class="form-group">
                                    <label>Date End:(yyyy-mm-dd)</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input name="dEnd" type="text" class="form-control" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask/>
                                        </div><!-- /.input group -->
                                    </div><!-- /.form group -->

                                    <!-- textarea -->
                                        <div class="form-group">
                                            <label>Description of the Problem</label>
                                            <textarea name="description" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                        </div>

                                    <!-- textarea -->
                                        <div class="form-group">
                                            <label>Notes</label>
                                            <textarea name="notes" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                        </div>

                                        <div class="box-footer">
                                        	<button type="submit" class="btn btn-primary">Insert Problem</button>
                                    	</div>

		    </form>
		</div>
	</section>

</aside>