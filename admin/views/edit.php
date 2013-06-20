<div class="wrap">
  <h2>Long Beach List: <?php echo $this->results[0]['name']; ?></h2>
	<table style="width:900px;margin-top:10px" class="wp-list-table widefat fixed pages" cellspacing="0">
		<tr>
			<th>
				List Item:
			</th>
			<th>
			  URL:
			</th>
      <th>
        Address:
      </th>
      <th>
        Phone:
      </th>
			<th>
			  Tags:
			</th>
			<th>
			  Action:
			</th>
		</tr>
    <?php foreach($this->list_items as $l){ ?>
		<tr>
			<td>
				<?php echo stripslashes($l['name']); ?>
			</td>
			<td>
			  <?php echo stripslashes($l['url']); ?>
			</td>
			<td>
			  <?php echo stripslashes($l['address']); ?>
			</td>
			<td>
			  <?php echo stripslashes($l['phone']); ?>
			</td>
			<td>
			  <?php echo stripslashes($l['tags']); ?>
			</td>
      <td>
        <span>
          <a href="<?php echo APP_PATH; ?>&action=delete_list_item&id=<?php echo $l['id']; ?>">Delete</a>
        </span>
      </td>
		</tr>
    <?php } ?>
  </table>
  <p>Add List Item</p>
  <form action="<?php echo APP_PATH; ?>&action=add_list_item" method="post">
  <input type="hidden" name="list_id" value="<?php echo $this->results[0]['id']; ?>" />
 	<table style="width:900px;margin-top:10px" class="wp-list-table widefat fixed pages" cellspacing="0">
 		<tr>
       <th>
         Name:
       </th>
       <th>
         URL:
        </th>
        <th>
          Address:  
        </th>
        <th>
          Phone:
        </th>
        <th>
          Tags: (comma separated)
        </th>
     </tr>
     <tr>
 			<td>
        <input type="text" name="name" />
 			</td>
 			<td>
        <input type="text" name="url" />
 			</td>
 			<td>
        <input type="text" name="address" />
 			</td>
 			<td>
 			  <input type="text" name="phone" />
 			</td>
      <td>
        <input type="text" name="tags" />
      </td>
 		</tr>
 		<tr>
 		  <td>
 		    <input class="button action" type="submit" value="Create List" />
      </td>
    </tr>
 	</table>
  </form>
</div>
