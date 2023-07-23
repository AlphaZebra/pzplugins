 

  ob_start();
	?>
	
	<form action="http://suchthings.local/wp-admin/admin-post.php" method="POST" class="form-style-1">
		<input type="hidden" name="action" value="do-person-edit-block" required>
	
    <input type='text' name=firstname><br>
<input type='text' name=lastname><br>
<input type='text' name=title><br>
<input type='text' name=company><br>
<input type='text' name=addr_line1><br>
<input type='text' name=addr_line2><br>
<input type='text' name=addr_city><br>
<input type='text' name=addr_state><br>
<input type='text' name=addr_zip><br>
<input type='text' name=email><br>
<input type='text' name=phone1><br>
<input type='text' name=phone1_type><br>
<input type='text' name=phone2><br>
<input type='text' name=phone2_type><br>
<input type='text' name=username><br>
<input type='text' name=has_notes><br>
<input type='text' name=pz_level><br>
<input type='text' name=pz_status><br>
<input type='text' name=created><br>
<input type='text' name=last_contact><br>
</form>