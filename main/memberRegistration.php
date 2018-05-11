<?php 
	require_once '../lib/memeberManagement.php';
 	require_once 'config.php';
 	require_once 'inc/memberRegistrationVariables.php';
 	
 	if($_SERVER["REQUEST_METHOD"] == "POST") {
 	    $personalNumber = $memberManagement->test_input($_POST["txtPersonalNumber"]);
 	    $dateOfBirth= $memberManagement->test_input($_POST["txtDateOfBirth"]);
 	    $firstName= $memberManagement->test_input($_POST["txtFirstName"]);
 	    $fatherName= $memberManagement->test_input($_POST["txtFatherName"]);
 	    $gFatherName= $memberManagement->test_input($_POST["txtGFatherName"]);
 	    $sex= $memberManagement->test_input($_POST["selectSex"]);
 	    $maritalStatus = $memberManagement->test_input($_POST["selectMeritalStatus"]);
 	    $residenceStatus = $memberManagement->test_input($_POST["selectResidenceStatus"]);
 	    $primaryEmail= $memberManagement->test_input($_POST["primaryEmail"]);
 	    $email2= $memberManagement->test_input($_POST["email2"]);
 	    $password= $memberManagement->test_input($_POST["password"]);
 	    $confirmPassword= $memberManagement->test_input($_POST["confirmPassword"]);
 	    $mobileNumber= $memberManagement->test_input($_POST["txtMobileNumber"]);
 	    $mobileNumber2= $memberManagement->test_input($_POST["txtMobileNumber2"]);
 	    $telephoneNumber= $memberManagement->test_input($_POST["txtTelephoneNumber"]);
 	    $city= $memberManagement->test_input($_POST["txtCity"]);
 	    $streetAddress= $memberManagement->test_input($_POST["txtStreetAddress"]);
 	    $poBox= $memberManagement->test_input($_POST["txtPoBox"]);
 	    $kommun= $memberManagement->test_input($_POST["txtKommun"]);
 	    $country = $memberManagement->test_input($_POST["txtCountry"]);
 	    
 	    $PersonalNumberErr =  $memberManagement->checkInputData($personalNumber, "Personal number", 3, true);
 	    $dateOfBirthlErr = $memberManagement->checkInputData($dateOfBirth, "Date of birth", 2, true, "", "19671225 or 1967-12-25");
 	    $firstNameErr = $memberManagement->checkInputData($firstName, "First name", 1, true);
 	    
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
  <label for="txtPersonalNumber">Personal number:</label><input type="text" name="txtPersonalNumber" value="<?php echo $personalNumber;?>">
  <span class="error">* <?php echo $PersonalNumberErr;?></span>
  <br><br>
  <label for="txtDateOfBirth">Date of birth </label><input type="text" name="txtDateOfBirth" value="<?php echo $dateOfBirth;?>">
  <span class="error">* <?php echo $dateOfBirthlErr;?></span>
  <br><br>
  <label for="txtFirstName">First name: </label><input type="text" name="txtFirstName" value="<?php echo $firstName;?>">
  <span class="error"><?php echo $firstNameErr;?></span>
  <br><br>
  <label for="txtFatherName">Father name:</label> <input type="text" name="txtFatherName" value="<?php echo $fatherName;?>">
  <span class="error"><?php echo $fatherNameErr;?></span>
  <br><br>
  <label for="txtGFatherName">G.Father name:</label> <input type="text" name="txtGFatherName" value="<?php echo $gFatherName;?>">
  <span class="error"><?php echo $gFatherNameErr;?></span>
  <br><br>
  <label for="selectSex">Sex</label> 
<select name="selectSex" form="memberRegistration">
  <option value="0"<?php if(isset($sex) && $sex=="0") echo "selected = 'selected'";?>></option>
  <option value="1"<?php if(isset($sex) && $sex=="1") echo "selected = 'selected'";?>>Male</option>
  <option value="2"<?php if(isset($sex) && $sex=="2") echo "selected = 'selected'";?>>Female</option>
  <?php if (isset($gender) && $gender=="female") echo "checked";?>
</select>
   <br><br>
    <label for="selectMeritalStatus">Meriatal Status:</label> 
   <?php echo $memberManagement->getMeritalStatusSelect($maritalStatus);?>
   <br><br>
   <label for="selectResidenceStatus">Residental Status:</label>
   <?php echo $memberManagement->getResidenceStatusSelect($residenceStatus)?>
   <br><br>
    <label for="primaryEmail">Primary email:</label> <input type="email" name="primaryEmail" value="<?php echo $primaryEmail;?>">
  <span class="error"><?php echo $primaryEmailErr;?></span>
  <br><br>
    <label for="email2">Email2:</label> <input type="email" name="email2" value="<?php echo $email2;?>">
  <span class="error"><?php echo $email2Err;?></span>
  <br><br>
    <label for="password">Password:</label>  <input type="password" name="password" value="<?php echo $password;?>">
  <span class="error"><?php echo $passwordErr;?></span>
  <br><br>
    <label for="confirmPassword">Confirm Password:</label> <input type="password" name="confirmPassword" value="<?php echo $confirmPassword;?>">
  <span class="error"><?php echo $ConfirmPasswordErr;?></span>
  <br><br>
   <label for="mobileNumber">Mobile number:</label><input type="text" name="txtMobileNumber" value="<?php echo $mobileNumber;?>">
  <span class="error"><?php echo $mobileNumberErr;?></span>
  <br><br>
     <label for="mobileNumber2">Mobile number2:</label><input type="text" name="txtMobileNumber2" value="<?php echo $mobileNumber2;?>">
  <span class="error"><?php echo $mobileNumber2Err;?></span>
  <br><br>
   <label for="telephoneNumber">Telephone number:</label> <input type="text" name="txtTelephoneNumber" value="<?php echo $telephoneNumber;?>">
  <span class="error"><?php echo $telephoneNumberErr;?></span>
  <br><br>
   <!-- <fieldset style="width:330px"> -->
   <fieldset style="width:100%">
  <legend>Residental address:</legend>
     <label for="txtCity">City:</label> <input type="text" name="txtCity" value="<?php echo $city;?>">
  <span class="error"><?php echo $cityErr;?></span>
  <br><br>
      <label for="txtStreetAddress">Street Address:</label> <input type="text" name="txtStreetAddress" value="<?php echo $streetAddress;?>">
  <span class="error"><?php echo $streetAddressErr;?></span>
  <br><br>
        <label for="txtPoBox">Po.Box:</label> <input type="text" name="txtPoBox" value="<?php echo $poBox;?>">
  <span class="error"><?php echo $poBoxErr;?></span>
  <br><br>
        <label for="txtKommun">Kommun:</label> <input type="text" name="txtKommun" value="<?php echo $kommun;?>">
   <span class="error"><?php echo $kommunErr;?></span>
  <br><br>
        <label for="Country:">Country:</label> <input type="text" name="txtCountry" value="Sweden" disabled="disabled">
        </fieldset>
  <br><br>
  <input type="submit" name="subRegister" value="Register">  
</form>

</body>
</html>
