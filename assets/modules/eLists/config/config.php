<?php
if(!defined('MODX_BASE_PATH')){die('What are you doing? Get out of here!');}

//List of available shapes
$formListTpl='
	<table class="fl">
		<thead>
			<tr>
				<td>id</td>
				<td>name</td>
				<td>description (inserted in the "Possible values" necessary TV)</td>
				<td>value</td>
				<td>Edit</td>
				<td>Remove</td>
			</tr>
		</thead>
		<tbody>
			[+formRows+]
		</tbody>
	</table>
	<br><br>
	<!--Form to create a new form-->
	<form action="" method="post" class="actionButtons">
		<input type="hidden" name="action" value="newForm">
		New option: <br><input type="text" value="" name="title"><br>
		<input type="submit" value="Add option">
	</form>
';

//line forms in table form a list
$formRowTpl='
	<tr>
		<td>[+id+]</td>
		<td><b>[+title+]</b></td>
		<td>[+code+]</td>
		<td class="actionButtons"><a href="[+moduleurl+]&fid=[+id+]&action=pole" class="button choice"> <img src="[+iconfolder+]page_white_copy.png" alt=""> The list of values</a></td>
		<td class="actionButtons"><a href="[+moduleurl+]&fid=[+id+]&action=edit" class="button edit"> <img alt="" src="[+iconfolder+]page_white_magnify.png" > Edit</a></td>
		<td class="actionButtons"><a onclick="document.delform.delform1.value=[+id+];document.delform.submit();" style="cursor:pointer;" class="button delete"> <img src="[+iconfolder+]delete.png" alt=""> remove</a></td>
	</tr>
';

$formEditTpl='
	<form action="" method="post" class="actionButtons">
		<input type="hidden" name="action" value="updateForm">
	parameter: <br><input type="text" value=\'[+title+]\' name="title" size="50"><br>
		<input type="submit" value="retain">
	</form><br><br>
	<a href="[+moduleurl+]">To the list of parameters</a>
';

$fieldListTpl='
	<form id="sortpole" action="" method="post" class="actionButtons">
		<table class="fl">
			<thead>
				<tr>
					<td>value</td>
					<td>order</td>
					<td>Edit</td>
					<td>Remove</td>
				</tr>
			</thead>
			<tbody>
				[+fieldRows+]
			</tbody>
		</table>
		<br>
		<input type="submit" value="Save your order">
	</form>
	<br><br>
	<h2>Add a new value</h2>
	<form action="" method="post" class="actionButtons">
		<input type="hidden" name="action" value="newField">
		title <br><input type="text" value="" name="title"><br>
		<input type="submit" value="add value">
	</form>
	<br><br>
	<a href="[+moduleurl+]">To the list of parameters</a>
';

$fieldRowTpl='
		<tr>
			<td>[+title+]</td>
			<td><input type="text" name="sortpole[[+id+]]" value="[+sort+]" class="sort small"></td>
			<td> <a href="[+moduleurl+]&fid=[+parent+]&pid=[+id+]&action=pole" class="button edit"><img alt="" src="[+iconfolder+]page_white_magnify.png" > Edit</a> </td>
			<td> <a onclick="document.delpole.delpole1.value=[+id+];document.delpole.submit();" style="cursor:pointer;" class="button delete"> <img src="[+iconfolder+]delete.png" alt=""> Remove</a> </td>
		</tr>
';

$fieldEditTpl='
	<form action="" method="post" class="actionButtons">
		<input type="hidden" name="action" value="updateField">
		value: <br><input type="text" value=\'[+title+]\' name="title"><br>
		<input type="submit" value="save Changes">
	</form>
	<br><br>
	<a href="[+moduleurl+]&fid=[+parent+]&action=pole">To the list of values</a>
';








?>