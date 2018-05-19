<?php 
	require_once '../lib/memeberManagement.php';
 	require_once 'config.php';
 	require_once 'inc/memberRegistrationVariables.php';
 	
 	if($_SERVER["REQUEST_METHOD"] == "POST") {
 	    $personalNumber = $memberManagement->test_input($_POST["txtPersonalNumber"]);
 	    $dateOfBirth= $memberManagement->test_input($_POST["txtDateOfBirth"]);
 	    $firstName= $memberManagement->test_input($_POST["txtFirstName"]);
 	    $gFatherName= $memberManagement->test_input($_POST["txtGFatherName"]);
 	    $sex= $memberManagement->test_input($_POST["selectSex"]);
 	    $maritalStatus = $memberManagement->test_input($_POST["selectMeritalStatus"]);
 	    $residenceStatus = $memberManagement->test_input($_POST["selectResidenceStatus"]);
 	    $primaryEmail= $memberManagement->test_input($_POST["primaryEmail"]);
 	    $password= $memberManagement->test_input($_POST["password"]);
 	    $confirmPassword= $memberManagement->test_input($_POST["confirmPassword"]);
 	    $mobileNumber= $memberManagement->test_input($_POST["txtMobileNumber"]);
 	    $streetAddress= $memberManagement->test_input($_POST["txtStreetAddress"]);
 	    $poBox= $memberManagement->test_input($_POST["txtPoBox"]);
 	    $ort= $memberManagement->test_input($_POST["txtOrt"]);
 	    $country = $memberManagement->test_input($_POST["txtCountry"]);
 	    

 	    $personalNumberErr = $memberManagement->validatePersonalNumber($personalNumber);
 	    $dateOfBirthlErr = $memberManagement->validateDateOfBirth($dateOfBirth, $personalNumber);
 	    $firstNameErr = $memberManagement->checkInputData($firstName, "First name", 1, true);
 	    $gFatherNameErr = $memberManagement->checkInputData($gFatherName, "G.Father/Last name", 1, true);
 	    $sexErr=$memberManagement->checkSelectedSex($sex);
 	    $primaryEmailErr = $memberManagement->checkEmail($primaryEmail, true);
 	    $ConfirmPasswordErr=$passwordErr = $memberManagement->checkPassword($password, $confirmPassword, true);
 	    $mobileNumberErr = $memberManagement->checkMobileNumber($mobileNumber,true);
 	    $streetAddressErr = $memberManagement->checkInputData($streetAddress, "Street address", 10, true);
 	    $poBoxErr = $memberManagement->checkInputData($poBox, "Po.Box", 3, true);
 	    $ortErr = $memberManagement->checkInputData($ort, "Ort", 1, true);
 	    
 	    
 	    //check the following fields if they have not be used before
 	    if(empty($personalNumberErr)){
 	        $personalNumberErr = $memberManagement->checkPersonalNumberIfUsed($personalNumber);
 	    }
 	    if(empty($primaryEmailErr)){
 	        $primaryEmailErr = $memberManagement->checkEmailIfUsed($primaryEmail);    
 	    }
 	    
 	    //For time being, personal number if optional if date of birth specified
 	    if(empty($personalNumberErr) && !empty($dateOfBirthlErr) &&empty($dateOfBirth) ){
 	        $dateOfBirthlErr="";
 	    }else if(empty($dateOfBirthlErr) && !empty($personalNumberErr) && empty($personalNumber)){
 	        $personalNumberErr="";
 	    }
 	    $errorMessages = array("personalNumberErr"=>$personalNumberErr, 
                     	        "dateOfBirthErr"=>$dateOfBirthlErr, 
                     	        "firstNameErr"=>$firstNameErr,
                     	        "gFatherNameErr"=>$gFatherNameErr,
                     	        "sexErr"=>$sexErr,
                     	        "primaryEmailErr"=>$primaryEmailErr,
 	                            "passwordErr"=>$passwordErr,
                     	        "ConfirmPasswordErr"=>$ConfirmPasswordErr,
                     	        "mobileNumberErr"=>$mobileNumberErr,
                     	        "streetAddressErr"=>$streetAddressErr,
                     	        "poBoxErr"=>$poBoxErr,
                     	        "ortErr"=>$ortErr
 	    );
 	    $isValidData = true;
 	    foreach($errorMessages as $errorMessage => $errorMessage_value) {
 	        if(!empty($errorMessage_value)){
 	            $isValidData=false;
 	            break;
 	        }
 	        
 	    }
 	    $registrationSuccessful=false;
 	    $messageStyle ="error";
 	    if($isValidData){
 	        $memberId = $memberManagement->getAvailableMemberId();
 	        $memberData = array("memberId"=>$memberId,
 	            "personalNumber"=>$personalNumber,
 	            "dateOfBirth"=>$dateOfBirth,
 	            "firstName"=>$firstName,
 	            "gFatherName"=>$gFatherName,
 	            "sex"=>$sex,
 	            "familyStatus"=>$maritalStatus,
 	            "residentStatus"=>$residenceStatus,
 	            "primaryEmail"=>$primaryEmail,
 	            "password"=>$password,
 	            "mobileNumber"=>$mobileNumber,
 	            "streetAddress"=>$streetAddress,
 	            "poBox"=>$poBox,
 	            "country"=>$country,
 	            "ort"=>$ort);
 	        $registrationSuccessful = $memberManagement->registerMember($memberData);
 	    }
 	    if($registrationSuccessful){
 	        $registrationMessage ="Thank you. You have been registered successfully";
 	        $messageStyle ="successRegistration";
 	        //clear data
 	        $personalNumber="";
 	        $dateOfBirth="";
 	        $firstName="";
 	        $gFatherName="";
 	        $sex="0";
 	        $maritalStatus="4";
 	        $residenceStatus="6";
 	        $primaryEmail="";
 	        $password="";
 	        $confirmPassword="";
 	        $mobileNumber="";
 	        $streetAddress="";
 	        $poBox="";
 	        $ort="";
 	    }else{
 	        $registrationMessage ="Some fields has not been field correctly. Please update them.";
 	        $messageStyle ="error";
 	    }
 	    
 	    
 	    
 	    
 	}
 	
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Member registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="../lib/css/main.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<h3>Fill the following forms to be get registered</h3>

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> "id="memberRegistration">  
  <span class='<?php echo $messageStyle;?>'> <?php echo $registrationMessage;?></span>
  <br><br>
  <label for="txtPersonalNumber">Personal number:</label><input type="text" name="txtPersonalNumber" value="<?php echo $personalNumber;?>">
  <span class="error">* <?php echo $personalNumberErr;?></span>
  <br><br>
  <label for="txtDateOfBirth">Date of birth </label><input type="text" name="txtDateOfBirth" value="<?php echo $dateOfBirth;?>">
  <span class="error">* <?php echo $dateOfBirthlErr;?></span>
  <br><br>
  <label for="txtFirstName">First name: </label><input type="text" name="txtFirstName" value="<?php echo $firstName;?>">
  <span class="error">*<?php echo $firstNameErr;?></span>
  <br><br>
  <label for="txtGFatherName">Last name:</label> <input type="text" name="txtGFatherName" value="<?php echo $gFatherName;?>">
  <span class="error">*<?php echo $gFatherNameErr;?></span>
  <br><br>
  <label for="selectSex">Sex</label> 
<select name="selectSex" form="memberRegistration">
  <option value="0"<?php if(isset($sex) && $sex=="0") echo "selected = 'selected'";?>></option>
  <option value="m"<?php if(isset($sex) && $sex=="m") echo "selected = 'selected'";?>>Male</option>
  <option value="f"<?php if(isset($sex) && $sex=="f") echo "selected = 'selected'";?>>Female</option>
</select>
<span class="error">*<?php echo $sexErr;?></span>
   <br><br>
    <label for="selectMeritalStatus">Meriatal Status:</label> 
   <?php echo $memberManagement->getMeritalStatusSelect($maritalStatus);?>
   <br><br>
   <label for="selectResidenceStatus">Residental Status:</label>
   <?php echo $memberManagement->getResidenceStatusSelect($residenceStatus)?>
   <br><br>
    <label for="primaryEmail">Primary email:</label> <input type="email" name="primaryEmail" value="<?php echo $primaryEmail;?>">
  <span class="error">*<?php echo $primaryEmailErr;?></span>
  <br><br>
    <label for="password">Password:</label>  <input type="password" name="password" value="<?php echo $password;?>">
  <span class="error">*<?php echo $passwordErr;?></span>
  <br><br>
    <label for="confirmPassword">Confirm Password:</label> <input type="password" name="confirmPassword" value="<?php echo $confirmPassword;?>">
  <span class="error">*<?php echo $ConfirmPasswordErr;?></span>
  <br><br>
   <label for="mobileNumber">Mobile number:</label><input type="text" name="txtMobileNumber" value="<?php echo $mobileNumber;?>">
  <span class="error">*<?php echo $mobileNumberErr;?></span>
  <br><br>
   <!-- <fieldset style="width:330px"> -->
   <fieldset style="width:100%">
  <legend>Residental address:</legend>
      <label for="txtStreetAddress">Street Address:</label> <input type="text" name="txtStreetAddress" value="<?php echo $streetAddress;?>">
  <span class="error">*<?php echo $streetAddressErr;?></span>
  <br><br>
        <label for="txtPoBox">Po.Box:</label> <input type="text" name="txtPoBox" value="<?php echo $poBox;?>">
  <span class="error">*<?php echo $poBoxErr;?></span>
  <br><br>
        <label for="txtOrt">Ort:</label> <input type="text" name="txtOrt" value="<?php echo $ort;?>">
   <span class="error"><?php echo $ortErr;?></span>
  <br><br>
        <label for="Country:">Country:</label> <input type="text" name="txtCountry" value="Sweden">
        </fieldset>
  <br><br>
  <input type="submit" name="subRegister" value="Register">  
</form>

</body>
</html>
