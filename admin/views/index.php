<div class="wrap">
  <h2>Long Beach Lists <a href="index.php?page=longbeach_lists/admin/index.php&action=new" class="add-new-h2">Add New</a></h2>
	<table style="width:300px;margin-top:10px" class="wp-list-table widefat fixed pages" cellspacing="0">
		<tr>
			<th colspan="2">
				<span>List Name</span>
			</th>
		</tr>
    <?php foreach($this->results as $r){ ?>
		<tr>
			<td>
				<span><?php echo $r['name']; ?></span>
			</td>
      <td>
        <span><a href="#">Edit</a> | <a href="#">Delete</a></span>
      </td>
		</tr>
    <?php } ?>
  </table>
</div>
