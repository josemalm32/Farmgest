<aside class="right-side">
	<section class="content">
		<div class="row">
			<form method="POST" action="<?=base_url()?>index.php/dashboard/test_val">
				<div id="frame">
				<!-- print the entity -->
					<table>
						<tbody>
						<?php 
						for($i = 0, $size = count($farm)-1; $i < $size; $i++) {
							// print line by farm
							if($i == 0) 
								echo '<tr>';
							
							if($flag == 1){
								echo '</tr>';
								echo '<tr>';
								$flag = 0;
							}
							if($farm[$i]['id_field'] == $farm[$i+1]['id_field']) {
								echo '<td>';?>
								<div id="<?php echo $farm[$i]['id'], ' '; ?>" onclick="myFunction(this, 'red')" style="width:60px; height:60px; border:1px solid #aaaaaa;background:#CCFF99">
								<center><?php echo $farm[$i]['section_name'] ?></center></div>
							    <?php echo '</td>';
							}else
								$flag = 1;
							
							if($i == $size - 1)
								echo '</tr>';
						}?>
				        </tbody>
				    </table>
			    </div>
			    <hr>
			    <div> <!-- in this option the controller get all the treatments and problems and let the user choose one to aply the selected fields -->
			    	<label>Select Problem</label>
			    	<select name"ChoosenProblem">
			    		<?php foreach ($problem as $row) : ?>
			    			<option value="<?php echo $row['id'] ?>"> <?php echo $row['name'] ?> </option>		    			
			    		<?php endforeach;?>
			    	</select>
			    	<label>Select treatment to aplly:</label>
			    	<select name="ChoosenTreatment">
			    		<?php foreach ($treatment as $row) : ?>
			    			<option value="<?php echo $row['id'] ?>"> <?php echo $row['name'] ?> </option>		    			
			    		<?php endforeach;?>
			    	</select>
			    	<br />
			    	<button>Apply Treatment</button>
			    	<input type="text" id="allValues" name="allValues" hidden>
			    </div>
		    </form>
		</div>
	</section>

</aside>