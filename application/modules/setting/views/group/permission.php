<div class='content-inner well'>
<div class="page-header">
	<a class="btn btn-small btn-primary" id="save">Update Permission</a>
</div>
    <form action="" method="POST" id="fform">
    <table class="table table-striped table-condensed table-hover">
        <thead>
        <tr>
	        <th data-key='control'><input type="checkbox" name="idall" id="idall" value="on"><input type="hidden" name="hidden_id" value="<?php echo $lev_id;?>"></th>
	        <th>Name</th>
	        <th>Description</th>
	      </tr>
        </thead>
        <tbody id="document-data">
            <?php
            	foreach ($populate as $rows) {
            		$checked = in_array($rows['p_id'], $populate_by_lev_id) ? "checked" : '' ;
					echo "<tr>
						<td><input type='checkbox' name='id[]' id='id' value='{$rows['p_id']}' {$checked}></td>
						<td>{$rows['name']}</td>
						<td>{$rows['desc']}</td>
            		</tr>";
            	}
            ?>
        </tbody>
    </table>
    </form>
</div>