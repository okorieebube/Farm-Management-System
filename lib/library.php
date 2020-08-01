<?php
session_start();
ob_start();

class lib{
    public $host = 'localhost';
	public $user = 'root';
	public $password = '';
	public $dbName = 'farm_mgt';

    public $managers = 'managers';
    public $crops = 'crops';
	public $field = 'field';
	public $link_crop = 'link_crop';
	public $tasks = 'tasks';
	public $machinery = 'machinery';
	public $finance = 'finance';


    public function connectDb(){
		$link = mysqli_connect($this->host,$this->user,$this->password,$this->dbName);
		if(mysqli_select_db($link,$this->dbName)){
			return $link;
		}else{
			return 'Sorry, not connected to database';
		}
	}
	
	public function sqlQuery($sql){
		if($result = mysqli_query(self::connectDb(),$sql)){
			return $result;
		}else{
			return 'sorry, database error';
		}
    }
   
	public function chkEmail($checkthis){
		$query = "SELECT * FROM $this->managers WHERE `email`='".$checkthis."'  ";
		$sql = self::sqlQuery($query);
		$row = mysqli_fetch_assoc($sql);
		if(!empty($row)){
			return 1;
		}else{
			return 0;
		}
	}
	public function chkFieldName($checkthis){
		$query = "SELECT * FROM $this->field WHERE `field_name`='".$checkthis."'  ";
		$sql = self::sqlQuery($query);
		$row = mysqli_fetch_assoc($sql);
		if(!empty($row)){
			return 1;
		}else{
			return 0;
		}
	}
	public function chkFieldId($checkthis){
		$query = "SELECT * FROM $this->field WHERE `farm_uniq_id`='".$checkthis."'  ";
		$sql = self::sqlQuery($query);
		$row = mysqli_fetch_assoc($sql);
		if(!empty($row)){
			return 1;
		}else{
			return 0;
		}
	}

    public function hashPass($pass){
		$hashedpass = crypt(md5($pass),'$6$rounds=1000$YourSaltyStringz$');
		return $hashedpass;
    }
    

    public function transactDate(){
		$today = date("F j, Y, g:i a");
		return $today;
	}

    public function genCropID(){
		$ini = array('RPC34','RPD32','RPD56','RPE89','RPF87','RPG76','RPH23','RPI78','RPJ54','RPK45','RPL90','RPM43','RPN43','RPO56','RPP67','RPQ78','RPR43','RPS76','RPT34','RPU45','RPV67','RPW78','RPX56','RPY67','RPZ34','RRR09','REA90','REB56','REC54','RED67','REE78','REF54','REG','REH56','REI56','REJ34','REK87','REL56','REM54','REN45','REO43','REP78','REQ67','RER43','RES45','RET34','REU34','REV65','REW56','REX56','REY78','REZ43','RDA65','RDB67','RDC34','RDD23','RDE87',"RAA87","RBH54","RHJ65","RKK45","RWH43","RBB45","RFC67","RGC54","RHC90","RJC43","RKC67","TLC34","TZC54","TXC34","TCC34","TVC67","TBC54","TNC54","TDO56","TDT67","TTT45","TAG54","TAH34","TAS54","TAR45","TAC78","TAT67","TAZ34","TSY54","TSB54","TZX78","TQO65",);
		$mid = mt_rand();
		$key = array_rand($ini);
		$value = $ini[$key];
		
		/* $key2 = array_rand($ini);
		$value2 = $ini[$key2]; */
		
		return $value.$mid;
	}
    
    public function registerOwner( $FNAME, $EMAIL, $SEX, $PHONE, $PASS, $CPASS){
       
	if(!empty($FNAME) && !empty($EMAIL) && !empty($SEX) && !empty($PHONE) && !empty($PASS) && !empty($CPASS)){
			if(filter_var($EMAIL,FILTER_VALIDATE_EMAIL)){
				if(self::chkEmail($EMAIL) == 0){
					
				if($PASS == $CPASS){
					$passhash = $this->hashPass($PASS);
					$dateReg = self::transactDate();
					/*$query = "INSERT INTO managers VALUES (null,'".$FNAME."','".$EMAIL."','".$SEX."','0','".$PASS."','".$PHONE."','0','0') ";*/
					$query = "INSERT INTO $this->managers VALUES (null,
			'".mysqli_real_escape_string($this->connectDb(),$FNAME)."',
			'".mysqli_real_escape_string($this->connectDb(),$EMAIL)."',
			'".mysqli_real_escape_string($this->connectDb(),$SEX)."',
			'".mysqli_real_escape_string($this->connectDb(),'0')."',
			'".mysqli_real_escape_string($this->connectDb(),$passhash)."',
			'".mysqli_real_escape_string($this->connectDb(),$PHONE)."',
			'".mysqli_real_escape_string($this->connectDb(),'Level1')."',
			'".mysqli_real_escape_string($this->connectDb(),$dateReg)."',
			'".mysqli_real_escape_string($this->connectDb(),$EMAIL)."') ";
					mysqli_close($this->connectDb());
					
					if($this->sqlQuery($query)){
						return 'Registration successful, login to continue!';
					}else{
						return ' Unexpected error';
					}
				}else{
					return 'Passwords do not match';
				}
				}else{
					return 'This Email already Exists. Use Another Email Address';
				}
			}else{
				return 'please enter a valid email';
			}
			
		}else{
			return "please fill all fields!";
		}
    }

    public function login($email,$pass){
		if(!empty($email) && !empty($pass)){
			if(filter_var($email,FILTER_VALIDATE_EMAIL)){
				$hashedpass = $this->hashPass($pass);
				$query = "SELECT * FROM $this->managers WHERE `email`='".$email."' and `password`='".$hashedpass."' ";
				$sql = @self::sqlQuery($query);
				$row = @mysqli_fetch_assoc($sql);

					if(mysqli_num_rows($sql)>0 ){
						$_SESSION['user_code'] = $row['email'];
						header("location:themenate.com/index.php");
					}else{
						return 'Sorry, Invalid Email Or Password';
					}
				
			}else{
				return 'Please enter a valid email';
			}
		}else{
			return 'Please enter username and password';
		}
	}

    public function getLoggedInName(){
        $query = "SELECT * FROM $this->managers WHERE `email`='".$_SESSION['user_code']."' ";
				$sql = @self::sqlQuery($query);
                $row = @mysqli_fetch_assoc($sql);
                return $row['name'];
;    }

    
    public function addSingleCrop($cropName,$location){
        if(!empty($cropName) && !empty($location)){
			$cropId = self::genCropID();
			$duration = '0 to 0';

            $query = "INSERT INTO $this->crops VALUES (null, 
			'".mysqli_real_escape_string($this->connectDb(),$cropId)."',
			'".mysqli_real_escape_string($this->connectDb(),$cropName)."',
			'".mysqli_real_escape_string($this->connectDb(),$location)."',
			'".mysqli_real_escape_string($this->connectDb(),'0')."',
			'".mysqli_real_escape_string($this->connectDb(),'0')."',
			'".mysqli_real_escape_string($this->connectDb(),'pending')."',
			'".mysqli_real_escape_string($this->connectDb(),'0')."',
			'".mysqli_real_escape_string($this->connectDb(),$duration)."',
			'".mysqli_real_escape_string($this->connectDb(),'0')."',
			'".mysqli_real_escape_string($this->connectDb(),'0')."',
            '".mysqli_real_escape_string($this->connectDb(),$_SESSION['user_code'])."') ";
			mysqli_close($this->connectDb());
            if($this->sqlQuery($query)) {
                return 'Crop added successfully.Go to ... to complete Crop setup';
            }else{
                return 'Unexpected Error';
            }
            
        }else{
            return 'Please Fill All Required Fields.';
        }
    }

	public function registerField($field_name,$location,$field_size,$soil_type,$ownership){
		if(!empty($field_name) && !empty($location) && !empty($field_size) && !empty($soil_type) && !empty($ownership)){

			$field_uniq_id = 'field'.mt_rand();
			$status = $this->chkFieldId($field_uniq_id);
			if($status == 0){

			}else if( $status == 1) {

				for($i=0;$status==1;$i++){
					$field_uniq_id = 'field'.mt_rand();
					$status = $this->chkFieldId($field_uniq_id);
				}
				
			}
			$query = "INSERT INTO $this->field VALUES (null, 
			'".mysqli_real_escape_string($this->connectDb(),$field_name)."',
			'".mysqli_real_escape_string($this->connectDb(),$location)."',
			'".mysqli_real_escape_string($this->connectDb(),$field_size)."',
			'".mysqli_real_escape_string($this->connectDb(),$soil_type)."',
			'".mysqli_real_escape_string($this->connectDb(),$ownership)."',
			'".mysqli_real_escape_string($this->connectDb(),$field_uniq_id)."',
			'".mysqli_real_escape_string($this->connectDb(),$_SESSION['user_code'])."',
            '".mysqli_real_escape_string($this->connectDb(),'0')."') ";
			mysqli_close($this->connectDb());
            if($this->sqlQuery($query)) {
                return 'Your field has been added successfully';
            }else{
                return 'Unexpected Error';
            }
		}else{
			return 'Please, all field details are required.';
		}

	}
	public function returnValue($table,$field,$row,$return){
		$query = "SELECT * FROM $table WHERE $field = '".$row."' ";
		$result = self::sqlQuery($query);
		$row = mysqli_fetch_assoc($result);
		return $row[$return];
	}

	public function returnParticularRow($table,$field,$row){
		$query = "SELECT * FROM $table WHERE $field = '".$row."' ";
		$result = self::sqlQuery($query);
		$row = mysqli_fetch_assoc($result);
		return $row;
	}

	public function calcCropNoOfTasks($cropid){
		$query = "SELECT * FROM $this->tasks WHERE `crop_id`='".$cropid."' ";
		$result = self::sqlQuery($query);
		
		$amt = 0;$i = 0;
		
		while($row = mysqli_fetch_assoc($result)){
			$amt += 1;
			$i++;
			}
		return $amt;
		
		
		}

	public function getUserCrops(){
		if(!empty($_SESSION['user_code'])){
			$query = "SELECT * FROM $this->crops WHERE owner_email = '".$_SESSION['user_code']."'  ORDER by id DESC ";

			$result = self::sqlQuery($query);
			
			for($i=0;$row = mysqli_fetch_assoc($result) ;$i++){
				$noOfTasks = self::calcCropNoOfTasks($row['crop_unique_id']);
				$farm_name = self::returnValue('field','farm_uniq_id',$row['farm_uniq_id'],'name');
				if($farm_name == ''){
					$d = '-';
				}elseif(!empty($farm_name)) {
					$d = $farm_name;
				}
				print '
				<tr style="cursor:pointer;" id="'.$row['crop_unique_id'].'">
					<td>'.$row['crop_name'].'</td>
					<td>'.$d.'</td>
					<td>'.$row['plot_size'].'</td>
					<td>'.$row['estimate_yield'].'</td>
					<td>'.$row['final_yield'].'</td>
					<td>'.$noOfTasks.'</td>
					<td>
					<a href="crop-profile.php?crop='.$row['crop_unique_id'].'" id="'.$row['crop_unique_id'].'"  class="btn btn-primary show-noty">
						<span style="color:white;">
						<i class="ti-agenda"></i>
						</span>
					</a>
					</td>
					<td>
					<a href="crop-details.php?crop='.$row['crop_unique_id'].'" id="'.$row['crop_unique_id'].'"  class="btn btn-primary show-noty">
						<span style="color:white;">
						<i class="ei-signals"></i>
						</span>
					</a>
					</td>
				</tr>';
			}
		}else{
			header('../index.php');
		}
	}
	

	public function getUserFields(){
		if(!empty($_SESSION['user_code'])){
			$query = "SELECT * FROM $this->link_crop WHERE crop_id = '".$_GET['crop']."'  ORDER by id DESC ";

			$result = self::sqlQuery($query);
			
			for($i=0;$row = mysqli_fetch_assoc($result) ;$i++){
				$farm_name = self::returnValue('field','farm_uniq_id',$row['farm_id'],'name');
				$farm_size = self::returnValue('field','farm_uniq_id',$row['farm_id'],'field_size');

				/* @$crops_linked = self::returnValue('crops','farm_uniq_id',$row['farm_uniq_id'],'plot_size');
				@$fieldSizeUsed += $cropslinked;
				@$totalFieldSize = $row['field_size'];
				@$usableFieldSize = 	$totalFieldSize - $fieldSizeUsed; */
				print '
				
				<tr>
				<td>'.$farm_name.'</td>
				<td>'.$farm_size.'</td>
				<td>'.$row['area_to_cover'].'</td>
			</tr>';
			}
		}else{
			header('../index.php');
		}
	}

	public function getCropSeason(){
		if(!empty($_SESSION['user_code'])){
			$query = "SELECT * FROM $this->crops WHERE crop_unique_id = '".$_GET['crop']."'  ORDER by id DESC ";

			$result = self::sqlQuery($query);
			
			for($i=0;$row = mysqli_fetch_assoc($result) ;$i++){
				$season_dura = explode('to',$row['season_duration']);
				if($row['season_name'] == '0'){
					 print '
				
					<tr class="text-center" >
					<td colspan="7">Incomplete Farm Produce Registration.
					<a href="crop-profile.php?crop='.$_GET['crop'].'"> Complete?</a></td>
				</tr>'; 
				}else{
					
				print '
				
				<tr>
				<td>'.$row['season_name'].'</td>
				<td>'.$season_dura[0].'</td>
				<td>'.$season_dura[1].'</td>
				<td>'.$row['estimate_yield'].'</td>
				<td>'.$row['final_yield'].'</td>
				<td>'.$row['planting_status'].'</td>
			</tr>';
				}
			}
		}else{
			header('../index.php');
			
		}
	}

	public function getFieldsForSelect(){
		if(isset($_SESSION['user_code'])){
			$query = "SELECT * FROM $this->field WHERE farm_owner='".$_SESSION['user_code']."' ";
			$result = self::sqlQuery($query);
			$main_farm_id = self::returnValue('crops','crop_unique_id',$_GET['crop'],'farm_uniq_id');

			for($i=0; $i <count($row = mysqli_fetch_assoc($result));$i++){
				if($row['farm_uniq_id'] == $main_farm_id){
					$dm = "selected='selected'";
				}else{
					$dm = "";
				}
					print '
					<option '.$dm.' value="'.$row['farm_uniq_id'].'">'.$row['name'].'</option>
					';
				
			}
		
		}
	}

	public function splitSeasonDuration($stringToExplode){
		
		$msg = explode('to', $stringToExplode);
		return $msg;
	}

	public function getLinkedToFarmArea($farmid){
		$query = "SELECT * FROM $this->link_crop WHERE farm_id='".$farmid."' ";
		$result = self::sqlQuery($query);
		$area_plotted = 0;
		for($i=0;$row = mysqli_fetch_assoc($result);$i++){
			$area_plotted +=$row['area_to_cover'];
		}
		if(mysqli_num_rows($result) < 0){
			$linked_to = 0;
		}else {
			$linked_to = $area_plotted;
		}
		return $linked_to;
	}


	public function calcFarmArea($farmid){
		$query = "SELECT * FROM $this->field WHERE farm_uniq_id='".$farmid."' ";
		$result = self::sqlQuery($query);
		$row = mysqli_fetch_assoc($result);
		$farm_area = $row['field_size'];
		$area_covered = self::getLinkedToFarmArea($farmid);
		$areaRem = $farm_area - $area_covered;
		$fieldDetails = array('total'=>$farm_area,'areaRem'=>$areaRem);

		return $fieldDetails;

	}

	public function linkToFarm($farmid,$cropid){
		$query = "UPDATE $this->crops SET 
			`farm_uniq_id`='".mysqli_real_escape_string($this->connectDb(),$farmid)."' WHERE `crop_unique_id`='".$cropid."'";
			self::sqlQuery($query);
	}

	public function updateNoOfCropPlanted($farmid,$cropid){
		$noOfCropPlanted = self::returnValue('field','farm_uniq_id',$farmid,'crops_planted');
		$noOfCropPlanted +=1;
		$query = "UPDATE $this->field SET 
			`crops_planted`='".mysqli_real_escape_string($this->connectDb(),$noOfCropPlanted)."' WHERE `farm_uniq_id`='".$farmid."'";
			self::sqlQuery($query);
	}

	public function linkCropToFarm($farmId,$areaToLink,$cropid){
		if(!empty($farmId) && !empty($areaToLink)){
			$areaRem = self::calcFarmArea($farmId);
			//return ($areaRem);
			if($areaToLink > $areaRem['areaRem']){
				return 'Your linked area is greater than the free plot in this Farm.Try a smaller plot.';
			}else if($areaToLink < $areaRem){
				$linkId = self::genCropID();
				$query = "INSERT INTO $this->link_crop VALUES (null, 
			'".mysqli_real_escape_string($this->connectDb(),$cropid)."',
			'".mysqli_real_escape_string($this->connectDb(),$farmId)."',
			'".mysqli_real_escape_string($this->connectDb(),$areaToLink)."',
			'".mysqli_real_escape_string($this->connectDb(),$_SESSION['user_code'])."',
			'".mysqli_real_escape_string($this->connectDb(),$linkId)."') ";
			
			if(self::sqlQuery($query)){
				self::linkToFarm($farmId,$cropid);
				self::updateNoOfCropPlanted($farmId,$cropid);
				return 'Your crop was linked to farm successfully';
			}
			}
		}else{
			return 'Please fill all required fields';
		}
	}

	public function completeCropRegistration($cid,$cname,$plot,$status,$season,$fdate,$edate,$eyield,$fyield){
		if(!empty($cid) && !empty($cname) && !empty($plot) && !empty($status) && !empty($season) && !empty($fdate) && !empty($edate) && !empty($eyield) ){
			$seasonDuration = $fdate.' '.'to'.' '.$edate;
			$query = "UPDATE $this->crops SET 
			`plot_size`='".mysqli_real_escape_string($this->connectDb(),$plot)."', 
			`planting_status`='".mysqli_real_escape_string($this->connectDb(),$status)."',
			`season_name`='".mysqli_real_escape_string($this->connectDb(),$season)."',
			`season_duration`='".mysqli_real_escape_string($this->connectDb(),$seasonDuration)."',
			`estimate_yield`='".mysqli_real_escape_string($this->connectDb(),$eyield)."',
			`final_yield`='".mysqli_real_escape_string($this->connectDb(),$fyield)."' WHERE `crop_unique_id`='".$cid."'";
			if($this->sqlQuery($query)) {
                return 'Your Crop Update was successful';
            }else{
                return 'Unexpected Error.Contact your administrator.';
            }

		}else{
			return 'You have to fill all fields';
		}
	}

	public function getWorkers(){
			$query = "SELECT * FROM $this->managers WHERE main_owner = '".$_SESSION['user_code']."'  ORDER by id DESC ";

			print_r($result = self::sqlQuery($query));
			
			for($i=0;$row = mysqli_fetch_assoc($result) ;$i++){
				print '<option id="ct-selectize" value="'.$row['email'].'," >'.$row['name'].'</option>';
			}
			
	}

	public function getCropsLinkedToFarm($farmid){
		$query = "SELECT * FROM $this->crops WHERE farm_uniq_id='".$farmid."' ";
		$result = self::sqlQuery($query);
		$cropDetails = array();
		$test = 'test';
		$test2 = 'test';
		for($i=0;$row = mysqli_fetch_assoc($result);$i++){
			/* ${'crop'.$i} = []; */
			$current_crop = $row['crop_name'];
			$current_crop_value = $row['crop_unique_id'];
			/* $mTest = array($test,$test2); */
			/* array_push(${'crop'.$i},$current_crop,$current_crop_value); */
			
		$cropDetails[] = array($current_crop_value,$current_crop);
		/* array_push(${'crop'.$i},$mTest); */
		}
		return $cropDetails;
	}


	public function createTask($t_name,$category,$t_startdate,$t_enddate,$t_status,$incharge,$farm,$crop,$note,$session,$workers){
        if(!empty($t_name) && !empty($t_startdate) && !empty($t_enddate) && !empty($t_status) && !empty($incharge) && !empty($workers) && !empty($farm) && !empty($crop) && !empty($note) && !empty($session)){
			$task_uniq_id = 'task'.mt_rand();
			$taskDuration = $t_startdate.' '.'to'.' '.$t_enddate;

            $query = "INSERT INTO $this->tasks VALUES (null, 
			'".mysqli_real_escape_string($this->connectDb(),$task_uniq_id)."',
			'".mysqli_real_escape_string($this->connectDb(),$t_name)."',
			'".mysqli_real_escape_string($this->connectDb(),$taskDuration)."',
			'".mysqli_real_escape_string($this->connectDb(),$t_status)."',
			'".mysqli_real_escape_string($this->connectDb(),$incharge)."',
			'".mysqli_real_escape_string($this->connectDb(),$workers)."',
			'".mysqli_real_escape_string($this->connectDb(),$category)."',
			'".mysqli_real_escape_string($this->connectDb(),$farm)."',
			'".mysqli_real_escape_string($this->connectDb(),$crop)."',
			'".mysqli_real_escape_string($this->connectDb(),$session)."',
            '".mysqli_real_escape_string($this->connectDb(),$note)."') ";
			mysqli_close($this->connectDb());
            if($this->sqlQuery($query)) {
                return 'Task created successfully';
            }else{
                return 'Unexpected Error';
            }
            
        }else{
            return 'Please Fill All Required Fields.';
        }
	}
	
	public function getUserTask(){
		if(!empty($_SESSION['user_code'])){
			$query = "SELECT * FROM $this->tasks WHERE owner_email = '".$_SESSION['user_code']."'  ORDER by id DESC ";

			$result = self::sqlQuery($query);
			
			for($i=0;$row = mysqli_fetch_assoc($result) ;$i++){
				$worker_incharge = self::returnValue('managers','email',$row['incharge_email'],'name');
				$farm_n = self::returnValue('field','farm_uniq_id',$row['field_id'],'name');
				/* if($farm_n == ''){
					$d = '-';
				}elseif(!empty($farm_name)) {
					$d = $farm_name;
				} */
				print '
				<tr  id="'.$row['task_id'].'">
					<td>'.$row['name'].'</td>
					<td>'.$row['task_duration'].'</td>
					<td>'.$row['status'].'</td>
					<td>'.$worker_incharge.'</td>
					<td>'.$farm_n.'</td>
					<td>
					<a href="task-detail.php?task='.$row['task_id'].'" id="'.$row['task_id'].'"  class="btn btn-primary show-noty">
						<span style="color:white;">
						<i class="ti-agenda"></i>
						</span>
					</a>
					</td>
				</tr>';
			}
		}else{
			header('../index.php');
		}
	}

	public function getWorkerincharge(){
		$query = "SELECT * FROM $this->managers WHERE main_owner = '".$_SESSION['user_code']."'  ORDER by id DESC ";

		print_r($result = self::sqlQuery($query));
		
		for($i=0;$row = mysqli_fetch_assoc($result) ;$i++){
			print '<option value="'.$row['email'].'" >'.$row['name'].'</option>';
		}
		
}
public function registerWorker( $FNAME, $EMAIL, $SEX, $PHONE,$session){
       
	if(!empty($FNAME) && !empty($EMAIL) && !empty($SEX) && !empty($PHONE)){
			if(filter_var($EMAIL,FILTER_VALIDATE_EMAIL)){
				if(self::chkEmail($EMAIL) == 0){
					$pass = $this->genCropID();
					$passhash = $this->hashPass($pass);
					$dateReg = self::transactDate();
					/*$query = "INSERT INTO managers VALUES (null,'".$FNAME."','".$EMAIL."','".$SEX."','0','".$PASS."','".$PHONE."','0','0') ";*/
					$query = "INSERT INTO $this->managers VALUES (null,
			'".mysqli_real_escape_string($this->connectDb(),$FNAME)."',
			'".mysqli_real_escape_string($this->connectDb(),$EMAIL)."',
			'".mysqli_real_escape_string($this->connectDb(),$SEX)."',
			'".mysqli_real_escape_string($this->connectDb(),'0')."',
			'".mysqli_real_escape_string($this->connectDb(),$passhash)."',
			'".mysqli_real_escape_string($this->connectDb(),$PHONE)."',
			'".mysqli_real_escape_string($this->connectDb(),'Level2')."',
			'".mysqli_real_escape_string($this->connectDb(),$dateReg)."',
			'".mysqli_real_escape_string($this->connectDb(),$session)."') ";
					mysqli_close($this->connectDb());
					
					if($this->sqlQuery($query)){
						return 'Worker Registered successfully.';
					}else{
						return ' Unexpected error';
					}
				}else{
					return 'This Email already Exists. Use Another Email Address';
				}
			}else{
				return 'please enter a valid email';
			}
			
		}else{
			return "please fill all fields!";
		}
	}
	public function registerMachinery($m_name,$category,$manufacturer,$year,$session){
        if(!empty($m_name) && !empty($category) && !empty($manufacturer) && !empty($year) && !empty($session)){
			$id = $this->genCropID();
			$machine_uniq_id = 'Machine'.$id;

            $query = "INSERT INTO $this->machinery VALUES (null, 
			'".mysqli_real_escape_string($this->connectDb(),$m_name)."',
			'".mysqli_real_escape_string($this->connectDb(),$category)."',
			'".mysqli_real_escape_string($this->connectDb(),$manufacturer)."',
			'".mysqli_real_escape_string($this->connectDb(),$machine_uniq_id)."',
			'".mysqli_real_escape_string($this->connectDb(),$year)."',
			'".mysqli_real_escape_string($this->connectDb(),$session)."') ";
			mysqli_close($this->connectDb());
            if($this->sqlQuery($query)) {
                return 'Machinery created successfully';
            }else{
                return 'Unexpected Error';
            }
            
        }else{
            return 'Please Fill All Required Fields.';
        }
	}
	public function getRegisteredFarm(){
		if(!empty($_SESSION['user_code'])){
			$query = "SELECT * FROM $this->field WHERE farm_owner = '".$_SESSION['user_code']."'  ORDER by id DESC ";

			$result = self::sqlQuery($query);
			if(mysqli_num_rows($result) < 1){
				print '
		   
			   <tr class="text-center" >
			   <td colspan="5">No registered Farm.
			   <a href="add-field.php"> Register?</a></td>
		   </tr>'; 
		   }else{
			   
		   
		   
			for($i=0;$row = mysqli_fetch_assoc($result) ;$i++){
				print '
		   
		   <tr>
		   <td>'.$row['name'].'</td>
		   <td>'.$row['field_size'].'</td>
		   <td>'.$row['soil_type'].'</td>
		   <td>'.$row['ownership_type'].'</td>
		   <td>'.$row['crops_planted'].'</td>
	   </tr>';
			}
			}
		}else{
			header('../index.php');
			
		}
	}


	public function getMachine(){
		if(!empty($_SESSION['user_code'])){
			$query = "SELECT * FROM $this->machinery WHERE owner_email = '".$_SESSION['user_code']."'  ORDER by id DESC ";

			$result = self::sqlQuery($query);
			if(mysqli_num_rows($result) < 1){
				print '
		   
			   <tr class="text-center" >
			   <td colspan="5">No registered Machinery.
			   <a href="register-machinery.php"> Register?</a></td>
		   </tr>'; 
		   }else{
			   
		   
		   
			for($i=0;$row = mysqli_fetch_assoc($result) ;$i++){
				print '
		   
		   <tr>
		   <td>'.$row['name'].'</td>
		   <td>'.$row['reg_number'].'</td>
		   <td>'.$row['category'].'</td>
		   <td>'.$row['manufacturer'].'</td>
		   <td>'.$row['year'].'</td>
	   </tr>';
			}
			}
		}else{
			header('../index.php');
			
		}
	}




	public function getRegisteredWorkers(){
		if(!empty($_SESSION['user_code'])){
			$query = "SELECT * FROM $this->managers WHERE main_owner = '".$_SESSION['user_code']."' AND permission='Level2' ORDER by id DESC ";

			$result = self::sqlQuery($query);
			if(mysqli_num_rows($result) < 1){
				print '
		   
			   <tr class="text-center" >
			   <td colspan="5">No registered Workers.
			   <a href="register-workers.php"> Register?</a></td>
		   </tr>'; 
		   }else{
			   
		   
		   
			for($i=0;$row = mysqli_fetch_assoc($result) ;$i++){
				print '
		   
		   <tr>
		   <td>'.$row['name'].'</td>
		   <td>'.$row['email'].'</td>
		   <td>'.$row['gender'].'</td>
		   <td>'.$row['phone_no'].'</td>
		   <td>'.$row['date_registered'].'</td>
	   </tr>';
			}
			}
		}else{
			header('../index.php');
			
		}
	}

	public function registerFinance($f_name,$f_category,$amount,$p_method,$session){
        if(!empty($f_name) && !empty($f_category) && !empty($amount) && !empty($p_method) && !empty($session)){
			$id = $this->genCropID();
			$dateReg = self::transactDate();

            $query = "INSERT INTO $this->finance VALUES (null, 
			'".mysqli_real_escape_string($this->connectDb(),$id)."',
			'".mysqli_real_escape_string($this->connectDb(),$f_category)."',
			'".mysqli_real_escape_string($this->connectDb(),$f_name)."',
			'".mysqli_real_escape_string($this->connectDb(),$amount)."',
			'".mysqli_real_escape_string($this->connectDb(),$p_method)."',
			'".mysqli_real_escape_string($this->connectDb(),$dateReg)."',
			'".mysqli_real_escape_string($this->connectDb(),$session)."') ";
			mysqli_close($this->connectDb());
            if($this->sqlQuery($query)) {
                return 'Finance was registered successfully';
            }else{
                return 'Unexpected Error';
            }
            
        }else{
            return 'Please Fill All Required Fields.';
        }
	}
	public function getFinance(){
		if(!empty($_SESSION['user_code'])){
			$query = "SELECT * FROM $this->finance WHERE owner_email = '".$_SESSION['user_code']."' ORDER by id DESC ";

			$result = self::sqlQuery($query);
			if(mysqli_num_rows($result) < 1){
				print '
		   
			   <tr class="text-center" >
			   <td colspan="6">No registered Transactions.
			   <a href="register-finance.php"> Register?</a></td>
		   </tr>'; 
		   }else{
			   
			for($i=0;$row = mysqli_fetch_assoc($result) ;$i++){
				print '
		   
		   <tr>
		   <td>'.$row['item_name'].'</td>
		   <td>'.$row['transaction_id'].'</td>
		   <td>'.$row['category'].'</td>
		   <td>'.$row['net_amount'].'</td>
		   <td>'.$row['payment_method'].'</td>
		   <td>'.$row['date'].'</td>
	   </tr>';
			}
			}
		}else{
			header('../index.php');
			
		}
	}
		public function calcFarmsOwned(){
		$query = "SELECT * FROM $this->field WHERE `farm_owner`='".$_SESSION['user_code']."' ";
		$result = self::sqlQuery($query);
		
		$amt = 0;$i = 0;
		
		while($row = mysqli_fetch_assoc($result)){
			$amt += 1;
			$i++;
			}
		return $amt;
		
		
	}
	public function calcCropsOwned(){
	$query = "SELECT * FROM $this->crops WHERE `owner_email`='".$_SESSION['user_code']."' ";
	$result = self::sqlQuery($query);
	
	$amt = 0;$i = 0;
	
	while($row = mysqli_fetch_assoc($result)){
		$amt += 1;
		$i++;
		}
	return $amt;
	
	
}
public function calcAmountInSales(){
$query = "SELECT * FROM $this->finance WHERE `owner_email`='".$_SESSION['user_code']."' AND category='Sales' ";
$result = self::sqlQuery($query);

$amt = 0;$i = 0;

while($row = mysqli_fetch_assoc($result)){
	$amt += $row['net_amount'];
	$i++;
	}
return $amt;


}
public function calcAmountInExpense(){
$query = "SELECT * FROM $this->finance WHERE `owner_email`='".$_SESSION['user_code']."' AND category='Expense' ";
$result = self::sqlQuery($query);

$amt = 0;$i = 0;

while($row = mysqli_fetch_assoc($result)){
	$amt += $row['net_amount'];
	$i++;
	}
return $amt;


}
public function calcPendingTasks(){
$query = "SELECT * FROM $this->tasks WHERE `owner_email`='".$_SESSION['user_code']."' AND `status`='pending' ";
$result = self::sqlQuery($query);

$amt = 0;$i = 0;

while($row = mysqli_fetch_assoc($result)){
	$amt += 1;
	$i++;
	}
return $amt;


}
public function calcInProgressTasks(){
$query = "SELECT * FROM $this->tasks WHERE `owner_email`='".$_SESSION['user_code']."' AND `status`='In Progress' ";
$result = self::sqlQuery($query);

$amt = 0;$i = 0;

while($row = mysqli_fetch_assoc($result)){
	$amt += 1;
	$i++;
	}
return $amt;


}
public function calcFinishedTasks(){
$query = "SELECT * FROM $this->tasks WHERE `owner_email`='".$_SESSION['user_code']."' AND `status`='Finished' ";
$result = self::sqlQuery($query);

$amt = 0;$i = 0;

while($row = mysqli_fetch_assoc($result)){
	$amt += 1;
	$i++;
	}
return $amt;


}
public function calcNoOfWorkers(){
$query = "SELECT * FROM $this->managers WHERE `main_owner`='".$_SESSION['user_code']."' AND `permission`='Level2' ";
$result = self::sqlQuery($query);

$amt = 0;$i = 0;

while($row = mysqli_fetch_assoc($result)){
	$amt += 1;
	$i++;
	}
return $amt;


}
public function getTasksForThisCrop(){
	if(!empty($_SESSION['user_code'])){
		$query = "SELECT * FROM $this->tasks WHERE crop_id = '".$_GET['crop']."'  ORDER by id DESC ";

		$result = self::sqlQuery($query);
		
		
			if(mysqli_num_rows($result) < 1){
				 print '
				<tr class="text-center" >
				<td colspan="4">No Tasks Assigned To This Farm Produce.
				<a href="create-task.php"> Create Task?</a></td>
			</tr>'; 
			}else{
				for($i=0;$row = mysqli_fetch_assoc($result) ;$i++){
				$worker_incharge = $row['incharge_email'];
				$farm_id = $row['field_id'];
				$incharge_name = self::returnValue('managers','email',$worker_incharge,'name');
				$farm_name = self::returnValue('field','farm_uniq_id',$farm_id,'name');
			print '
			
			<tr>
			<td>'.$row['name'].'</td>
			<td>'.$incharge_name.'</td>
			<td>'.$row['task_duration'].'</td>
			<td>'.$farm_name.'</td>
		</tr>';
	}
			}
		
	}else{
		header('../index.php');
		
	}
}

public function security(){
	if(isset($_SESSION['user_code'])){

	}else{
		header("location:../");
	}
}



}
$lib = new lib();
$lib->connectDb();




?>