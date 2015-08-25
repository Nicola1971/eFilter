<?php
if(!defined('MODX_BASE_PATH')){die('What are you doing? Get out of here!');}

class eListsModule{

public $moduleid;
public $moduleurl;
public $iconfolder;
public $theme;
public $info_type=1;
public $eBlock=''; //there will be the main information block depending on the value $info_type
public $info=''; //information sign in case of successful / unsuccessful actions
public $zagol='parameter List';
public $list_catagory_table='';
public $list_value_table='';
public $type=array(// fields available in the form of
				"1"=>"line",
				"2"=>"text",
				"3"=>"Email",
				"5"=>"list (select)",
				"6" =>"checkbox (radio)",
				"7"=>"switch (checkbox)",
				"8"=>"file",
				"9"=>"Multyselekt",
				"10"=>"Hidden field "
			);
public $form_info;
public $pole_info;


public function __construct($modx){
	$this->modx=$modx;
	$this->moduleid=(int)$_GET['id'];
	$this->moduleurl='index.php?a=112&id='.$this->moduleid;
	$this->list_catagory_table=$this->modx->getFullTableName('list_catagory_table');
	$this->list_value_table=$this->modx->getFullTableName('list_value_table');
	$this->theme=$this->modx->config['manager_theme'];
	$this->iconfolder='media/style/'.$this->theme.'/images/icons/';
}

public function parseTpl($arr1,$arr2,$tpl){
	return str_replace($arr1,$arr2,$tpl);
}

public function createTables(){
	//ÑÐ¾Ð·Ð´Ð°ÐµÐ¼ ÑÐ°Ð±Ð»Ð¸ÑÑ ÑÐ¾ÑÐ¼, ÐµÑÐ»Ð¸ ÐµÐµ Ð½ÐµÑ
	$sql="
	CREATE TABLE IF NOT EXISTS ".$this->list_catagory_table." (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`sort` int(5) NOT NULL DEFAULT '0',
		`title` text NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	";
	$q=$this->modx->db->query($sql);

	//ÑÐ¾Ð·Ð´Ð°ÐµÐ¼ ÑÐ°Ð±Ð»Ð¸ÑÑ Ð¿Ð¾Ð»ÐµÐ¹ ÑÐ¾ÑÐ¼, ÐµÑÐ»Ð¸ ÐµÐµ Ð½ÐµÑ
	$sql="
	CREATE TABLE IF NOT EXISTS ".$this->list_value_table." (
		`id` int(5) NOT NULL AUTO_INCREMENT,
		`parent` int(5) NOT NULL DEFAULT '0',
		`title` varchar(255) NOT NULL DEFAULT '',
		`sort` int(5) NOT NULL DEFAULT '0',
		PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	";
	$q=$this->modx->db->query($sql);
}


public function escape($a){
	return $this->modx->db->escape($a);
}

public function getRow($table,$id){
	$row=$this->modx->db->getRow($this->modx->db->query("SELECT * FROM ".$table." WHERE id=".$id." LIMIT 0,1"));
	return $row;
}

public function addForm($fields,$table){
	$query=$this->modx->db->insert($fields,$table);
	if($query){$this->info='<p class="info">Option successfully added</p>';}
	else{$this->info='<p class="info error">Failed to add parameter</p>';}
}

public function updateForm($fields,$table,$where){
	$query=$this->modx->db->update($fields,$table,$where);
	if($query){$this->info='<p class="info">The parameter changed successfully</p>';}
	else{$this->info='<p class="info error">Unable to change setting</p>';}
}

public function delForm($id){
	$query=$this->modx->db->query("DELETE FROM ".$this->list_catagory_table." WHERE id=".$id);
	if($query){
		$query2=$this->modx->db->query("DELETE FROM ".$this->list_value_table." WHERE parent=".$id);
		$this->info='<p class="info">Parameter successfully removed</p>';
	}
	else{$this->info='<p class="info error">Unable to remove the option</p>';}
}


public function addField($fields,$table){
	$query=$this->modx->db->insert($fields,$table);
	if($query){$this->info='<p class="info">Value list successfully added</p>';}
	else{$this->info='<p class="info error">Unable to add value</p>';}
}

public function updateField($fields,$table,$where){
	$query=$this->modx->db->update($fields,$table,$where);
	if($query){$this->info='<p class="info">Value successfully changed</p>';}
	else{$this->info='<p class="info error">Unable to change the value</p>';}
}

public function sortFields($order){
	$ok=1;
	foreach($order as $k=>$v){//save the sort order
		$query=$this->modx->db->query("UPDATE ".$this->list_value_table." SET `sort`='".(int)$v."' WHERE id=".(int)$k);
		if(!$query){$ok=1;}
	}
	if($ok==1){$this->info='<p class="info">Values successfully sorted</p>';}
	else{$this->info='<p class="info error">An error occurred while changing the order of fields</p>';}
}

public function delField($id){
	$query=$this->modx->db->query("DELETE FROM ".$this->list_value_table." WHERE id=".$id);
	if($query){$this->info='<p class="info">Meaning successfully removed</p>';}
	else{$this->info='<p class="info error">Failed to delete a value</p>';}
}



public function makeActions(){
	if(isset($_POST['delform1'])){//Remove form
		$this->delForm((int)$_POST['delform1']);
	}

	if(isset($_POST['delpole1'])){//Remove field
		$this->delField((int)$_POST['delpole1']);
	}

	if(isset($_POST['action'])&&$_POST['action']=='newForm'){//add a new form
		$name=$this->escape($_POST['name']);
		$title=$this->escape($_POST['title']);
		$email=$this->escape($_POST['email']);
		$sort=1;
		$maxformsort=$this->modx->db->getValue($this->modx->db->query("SELECT MAX(sort) FROM ".$this->list_catagory_table." LIMIT 0,1"));
		if($maxformsort){
			$sort=(int)$maxformsort+1;
		}
		$flds=array(
			'title'=>$title,
			'sort'=>$sort
		);
		$this->addForm($flds,$this->list_catagory_table);
	}

	if(isset($_GET['fid'])&&isset($_GET['action'])&&$_GET['action']=='edit'){//editing form
		$this->info_type=2;
		$this->zagol='Editing option';
		if(isset($_POST['action'])&&$_POST['action']=='updateForm'){
			$title=$this->escape($_POST['title']);
			$flds=array(
				'title'=>$title
			);

			$this->updateForm($flds, $this->list_catagory_table, "id=" . (int)$_GET['fid']);
		}

		//We update the information on the form to display
		$this->form_info=$this->getRow($this->list_catagory_table, (int)$_GET['fid']);
	}


	//List of form fields
	if(isset($_GET['fid'])&&isset($_GET['action'])&&$_GET['action']=='pole'&&!isset($_GET['pid'])){
		$this->info_type=3;
		$this->zagol='Setting list';

		if(isset($_POST['sortpole'])){//sort field

			$this->sortFields($_POST['sortpole']);
		}

		$parent=(int)$_GET['fid'];
		if(isset($_POST['action'])&&$_POST['action']=='newField'){//add a new field
			$title=$this->escape($_POST['title']);
			$type=$this->escape($_POST['type']);
			$value=$this->escape($_POST['value']);
			$require=isset($_POST['require'])?1:0;
			$sort=1;
			$maxpolesort=$this->modx->db->getValue($this->modx->db->query("SELECT MAX(sort) FROM ".$this->list_value_table." WHERE parent=".$parent." LIMIT 0,1"));
			if($maxpolesort){
				$sort=(int)$maxpolesort+1;
			}
			$flds=array(
				'parent'=>$parent,
				'title'=>$title,
				'sort'=>$sort
			);
			$this->addField($flds,$this->list_value_table);
		}
	}//the end of the list of fields


	//Editing form fields
	if(isset($_GET['fid'])&&isset($_GET['action'])&&$_GET['action']=='pole'&&isset($_GET['pid'])){
		$this->info_type=4;
		$this->zagol='Editing values';
		$parent=(int)$_GET['fid'];
		if(isset($_POST['action'])&&$_POST['action']=='updateField'){//edit field
			$title=$this->escape($_POST['title']);
			$type=$this->escape($_POST['type']);
			$value=$this->escape($_POST['value']);
			$require=isset($_POST['require'])?1:0;
			$flds=array(
				'title'=>$title
			);

			$this->updateField($flds,$this->list_value_table,"id=".(int)$_GET['pid']);
		}

		//update the information on the field to display
		$this->pole_info=$this->getRow($this->list_value_table,(int)$_GET['pid']);
	}
}


public function getFormList(){
	include_once('config/config.php');
	$form_list=$this->modx->db->query("SELECT * FROM ".$this->list_catagory_table." ORDER BY sort ASC");
	$formRows='';
	$out='';
	while($row=$this->modx->db->getRow($form_list)){
		$formRows.=$this->parseTpl(
			array('[+id+]', '[+title+]', '[+moduleurl+]', '[+iconfolder+]', '[+code+]'),
			array($row['id'], $row['title'], $this->moduleurl, $this->iconfolder, '@EVAL return $modx->runSnippet("multiParams", array("parent"=>"' . $row['id'] . '"));'),
			$formRowTpl
		);
	}
	$out=$this->parseTpl(
				array('[+formRows+]'),
				array($formRows),
				$formListTpl
				);
	return $out;
}

public function getFormEdit(){
	include_once('config/config.php');
	$out='';
	$out.=$this->parseTpl(
		array('[+title+]', '[+moduleurl+]'),
		array($this->form_info['title'], $this->moduleurl),
		$formEditTpl
	);
	return $out;
}

public function getFieldList(){
	include_once('config/config.php');
	$out='';
	$rows='';
	$form_list=$this->modx->db->query("SELECT * FROM ".$this->list_value_table." WHERE parent=".(int)$_GET['fid']." ORDER BY sort ASC");
	while($row=$this->modx->db->getRow($form_list)){
		$rows.=$this->parseTpl(
			array('[+id+]', '[+parent+]', '[+title+]', '[+sort+]', '[+moduleurl+]', '[+iconfolder+]'),
			array($row['id'], $row['parent'], $row['title'], $row['sort'], $this->moduleurl, $this->iconfolder),
			$fieldRowTpl
		);
	}

	$out=$this->parseTpl(
		array('[+fieldRows+]','[+moduleurl+]'),
		array($rows,$this->moduleurl),
		$fieldListTpl
	);
	return $out;
}

public function getFieldEdit(){
	include_once('config/config.php');
	$this->eBlock.=$this->parseTpl(
		array('[+title+]','[+parent+]','[+moduleurl+]'),
		array($this->pole_info['title'],$this->pole_info['parent'],$this->moduleurl),
		$fieldEditTpl
	);
	return $out;
}

public function show(){
	//block a list of forms
	switch ($this->info_type){
		case '1':
			$this->eBlock .= $this->getFormList();
		break;

		case '2':
			$this->eBlock .= $this->getFormEdit();
		break;

		case '3':
			$this->eBlock .= $this->getFieldList();
		break;

		case '4':
			$this->eBlock .= $this->getFieldEdit();
		break;

		default:
			$this->eBlock .= $this->getFormList();
		break;
	}
}


public function Run(){
	$this->createTables();
	$this->makeActions();
	$this->show();
}

}
//