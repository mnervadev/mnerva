<?php


function select($selection,$table,$where,$order,$limit,$count,$ui=null){

	global $con;

	$sql = 'SELECT ';

	if(is_array($selection)){

	$sqls = '';

	foreach($selection as $select){

	$sqls .= $select.',';

	}

	$sql .= substr($sqls,0,strlen($sqls)-1).' ';

	}else {

	if($selection === '*'){

	$sql .= '* ';

    }else {

	$sql .= $selection.' ';

    }

    }

	if($where != null && $where !=''){

    $sql .= 'FROM '.$table.' WHERE '.$where. ' ';

	}else {

	  $sql .= 'FROM '.$table. ' ';	

	}

	if($order != '' && $order != null){

		$sql .= $order;

	}

	if($limit != '' && $limit != null){

		$sql .= ' LIMIT '.$limit;

	}

	$result = array();

    $bind = $con->query($sql);

	$bind->execute();

	if($bind->rowCount() > 1){

	while($line = $bind->fetch(PDO::FETCH_ASSOC)){

		array_push($result,$line);

	}

	}else {

		if($ui != null){

		$result = array($bind->fetch(PDO::FETCH_ASSOC));

		}else{

		$result = $bind->fetch(PDO::FETCH_ASSOC);

		}

	}

    if($count === true){

		$result['count'] = $bind->rowCount();

	}

	return $result;

}

function rowcount($selection,$table,$where,$order,$limit){

	global $con;

	$sql = 'SELECT ';

	if(is_array($selection)){

	$sqls = '';

	foreach($selection as $select){

	$sqls .= $select.',';

	}

	$sql .= substr($sqls,0,strlen($sqls)-1).' ';

	}else {

	if($selection === '*'){

	$sql .= '* ';

    }else {

	$sql .= $selection.' ';

    }

    }

	if($where != null && $where !=''){

    $sql .= 'FROM '.$table.' '.$where. ' ';

	}else {

	  $sql .= 'FROM '.$table. ' ';	

	}

	if($order != '' && $order != null){

		$sql .= $order;

	}

	if($limit != '' && $limit != null){

		$sql .= ' LIMIT '.$limit;

	}

	$result = array();

    $bind = $con->query($sql);

	$bind->execute();

	echo $bind->rowCount();

}

function insert($table,$col,$value){

	global $con;

	$sql = 'INSERT INTO '.$table.' ';

	$newcol = '';

	$bol = '';

	$newval = array();

	$br = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

	if(is_array($col)){

		foreach($col as $c){

			$newcol .= $c.',';

		}

		$sql .= '('.substr($newcol,0,strlen($newcol)-1).') ';

		for($i = 0; $i < count($col); $i++){

			$bol .= ':'.$br[$i].',';

			$newval[$br[$i]] = $value[$i];

		}

		$sql .= 'VALUES ('.substr($bol,0,strlen($bol)-1).')';

	}

	$bind = $con->prepare($sql);

	if($bind->execute($newval)){

		return array('id'=>$con->lastInsertId());

	}

}

function update($table,$set,$where){

	global $con;

	$sql = 'UPDATE '.$table.' ';

	$newset = 'SET ';

	$update = array();

	$dumm = array();

	$br = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

	$par = array();

	foreach($set as $k => $v){

		array_push($par,$k);

		array_push($dumm,$v);

	}

	for($i=0;$i<count($set);$i++){

		$newset .= $par[$i].'=:'.$br[$i]. ',';

		$update[':'.$br[$i]] = $dumm[$i];

	}

	$newset = substr($newset,0,strlen($newset)-1). ' ';

	$sql .= $newset.'WHERE '.$where;

	$bind = $con->prepare($sql);

	$bind->execute($update);

	return $set;

}

function delsql($table,$where){

	global $con;

	$sql = 'DELETE FROM '.$table.' WHERE '.$where;

	$bind = $con->query($sql);

	$bind->execute();

	return $bind;

}


function tags($id){

	$items = select('tags','content','id="'.$id.'"',null,'1');

	$tages = explode(',',$items['tags']);

	$re = '';

	for($i = 0;$i < count($tages); $i++){

		$re .= '<a target="_blank" class="tags" href="'.$tages[$i].'">'.$tages[$i].'</a>';

	}  

	return $re;

}