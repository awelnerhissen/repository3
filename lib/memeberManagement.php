<?php
class MemberManagement{
    /** @var object $pdo Copy of PDO connection */
    private $pdo;
    /** @var object of the logged in user */
    private $user;
    /** @var string error msg */
    private $msg;
    
    /**
     * Connection init function
     * @param string $conString DB connection string.
     * @param string $user DB user.
     * @param string $pass DB password.
     *
     * @return bool Returns connection success.
     */
    public function dbConnect($conString, $user, $pass){
        if(session_status() === PHP_SESSION_ACTIVE){
            try {
                $pdo = new PDO($conString, $user, $pass);
                $this->pdo = $pdo;
                return true;
            }catch(PDOException $e) {
                $this->msg = 'Connection did not work out!';
                return false;
            }
        }else{
            $this->msg = 'Session did not start.';
            return false;
        }
    }
    
    /**
     * Strip whitespace (or other characters) from the beginning and end of a string ,
     * Un-quotes a quoted string and Convert special characters to HTML entities for security
     * reason.
     * @param  $data
     * @return string
     */
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    /**
     *
     * Check validty of the input data
     * @param String $input
     * @param String $inputName
     * @param int $validationType
     *        1 Only letters and white space allowed
     *        2 Only numbers and - allowed
     *        3 Only numbers - and white space allowed
     *        4 Only numbers - + and white space allowed
     *        10 Check only if the input is empty if empty is not allowed.
     * @param String $errorMessag replace error message by this when the input data is invalid.
     * @param boolean $checkEmpty
     * @param String $example add this exmaple to error when the input data is invalid
     * @return string
     */
    
    function checkInputData($input, $inputName, $validationType, $checkEmpty,  $errorMessag="", $example=""){
        $ONLY_LETTERS_AND_WHITE_SPACE = "/^[a-zA-ZåäöÅÄÖ ]*$/";
        $ONLY_NUMBERS_AND_HYPHEN = "/^[0-9-]*$/";
        $ONLY_NUMBERS_AND_WHITE_SPACE_AND_HYPHEN = "/^[0-9- ]*$/";
        $ONLY_NUMBERS_AND_WHITE_SPACE_AND_HYPHEN_AND_PLUS = "/^[0-9-+ ]*$/";
        
        
        $strError = "";
        $regularExpression ="";
        $errorMessageWhenInvalid="";
        if ($checkEmpty && empty($input)) {
            $strError = $inputName. " is required";
        } else if ($validationType!=10){
            if($validationType==1){
                $regularExpression = $ONLY_LETTERS_AND_WHITE_SPACE;
                $errorMessageWhenInvalid="Only letters and white space allowed";
            }else if($validationType==2){
                $regularExpression = $ONLY_NUMBERS_AND_HYPHEN;
                $errorMessageWhenInvalid="Only numbers and - allowed";
            }else if($validationType==3){
                $regularExpression = $ONLY_NUMBERS_AND_WHITE_SPACE_AND_HYPHEN;
                $errorMessageWhenInvalid="Only numbers - and white space allowed";
            }else if($validationType==4){
                $regularExpression = $ONLY_NUMBERS_AND_WHITE_SPACE_AND_HYPHEN_AND_PLUS;
                $errorMessageWhenInvalid="Only numbers - + and white space allowed";
            }
            
            
            if($errorMessag !=""){
                $errorMessageWhenInvalid = $errorMessag;
            }
            
            if($example !=""){
                $errorMessageWhenInvalid .= " e.g ". $example;
            }
            // check if name only contains letters and whitespace
            if (!preg_match($regularExpression,$input)) {
                $strError = $errorMessageWhenInvalid;
            }
        }
        return $strError;
    }
    
    /**
     * Validate if sex has been selected/filled
     * @param String $selectedSex
     * @return string
     */
    function checkSelectedSex($selectedSex){
        $strError="";
        if($selectedSex=="0"){
            $strError="Fill your sex.";
        }
        return $strError;
    }
    
    /**
     * Check if email is valid email. Skip checking email if $checkEmail 
     * is false and $email is empy.
     * 
     * @param String $email
     * @param boolean $checkEmpty
     */
    function checkEmail($email, $checkEmpty){
        $validateEmail = true;
        $emailErr="";
        if (!$checkEmpty && empty($email)){
            $validateEmail = false;
        }
        if($validateEmail){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }
        return $emailErr;
    }
    
   /**
    * 
    * @param String $number
    * @param String $checkEmpty
    */
    function checkMobileNumber($number, $checkEmpty){
        $numberLocal="";
        $ONLY_NUMBERS_AND_WHITE_SPACE_AND_HYPHEN_AND_PLUS = "/^[0-9-+ ]*$/";
        $validateNumber = true;
        $minimumMobileOrTelephoneNumberLength = 10; //e.g 0735618xxxx
        $numberError="";
        if (!$checkEmpty && empty($number)){
            $validateNumber = false;
        }
        if($validateNumber){
            $numberLocal = $this->changeMobileOrTelephoneNumberForm($number);
            if(strlen($number)<$minimumMobileOrTelephoneNumberLength){
                $numberError="Invalid number";
                return $numberError;
            }
            if( !preg_match($ONLY_NUMBERS_AND_WHITE_SPACE_AND_HYPHEN_AND_PLUS,$number)){
                $numberError="Only numbers - + and white space allowed";
                return $numberError;
            }
        }
        return $numberError;
        
    }
    
    /**
     * Validate if passowrd fullfills some requirements.
     * @param String $password
     * @param String $confirmPassword
     * @param boolean $useStrongPass
     * @return string
     */
    function checkPassword($password, $confirmPassword, $useStrongPass){
        //&&!preg_match( $digitsRegExp, $password) && !preg_match($specialCharacterRegExp, $password)
        //&& !preg_match( $alphabetsRegExp, $password) && !preg_match( $digitsRegExp, $password)
        $strErr =  "";
        $alphabetsRegExp='/[a-zA-Z]+/'; //match characters a to z or A to Z
        $digitsRegExp='/\d+/'; //match digits
        $specialCharacterRegExp ='/\W+/';
        if(strlen($password)<6){
            $strErr ="Password length at least 6 characters.";
            return $strErr;
        }
        if($useStrongPass  && (!preg_match( $alphabetsRegExp, $password) || !preg_match( $digitsRegExp, $password) || !preg_match( $specialCharacterRegExp, $password))){
                $strErr ="Password must have at least one character, one digit and one special symbol.";
                return $strErr;
        }
        if($password != $confirmPassword){
            $strErr ="Password and Confirm password are not the same.";
            return $strErr;
        }
        
        
    }
    /**
     * Change personal number to fixed form, 12 digits only
     * @param  $personalNumber
     * @return int persona number in fixed form.
     */
    function changePersonalNumberForm($personalNumber){
        return $this->removeSpaceAndhyphen($personalNumber);
        
    }
    
    /**
     * Remove white space and - from $input
     * @param String $intput
     * @return mixed
     */
    function removeSpaceAndhyphen($intput){
        $updatedInput = str_replace("-", "",$intput);
        $updatedInput = str_replace(" ", "",$updatedInput);
        return $updatedInput;
        
    }
    
    /**
     * Change mobile or telephone number to fixed form.
     * @param  $personalNumber
     * @return int mobile or telephone number in fixed form.
     */
    function changeMobileOrTelephoneNumberForm($mobileOrTelephoneNumber){
        $mobileOrTelephoneNumberNumberForm = $this->removeSpaceAndhyphen($mobileOrTelephoneNumber);
        $$mobileOrTelephoneNumberNumberForm = str_replace("+", "00",$$mobileOrTelephoneNumberNumberForm);
        return $mobileOrTelephoneNumberNumberForm;
        
    }
    
    /**
     * Validate personal number
     * @param  $personalNumber
     * @return String, empty of $personalNumber is valid otherwise error message. 
     */
    function validatePersonalNumber($personalNumber){
        $personalNumberErr = $this->checkInputData($personalNumber, "Personal number", 2, true);
        if(empty($personalNumberErr) && !empty($personalNumber)){
            $personalNumberForm = $this->changePersonalNumberForm($personalNumber);
            $firstTwoDigit = substr($personalNumberForm, 0, 2);
            if(strlen($personalNumberForm)!=12 || ($firstTwoDigit!="19" && $firstTwoDigit!="20")){
                $personalNumberErr = "Invalid personal number";
            }
        }
        return $personalNumberErr;
    }
    function incrementAvailableMemberId(){
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('update tblMemberId set availableId= availableId+1');
        $stmt->execute();
    }
    
    function registerMember($data){
        $hashedPassword = $this->hashPass($data['password']);
        $personalNumberWithoutSpace = $this->removeSpaceAndhyphen($data['personalNumber']);
        $date = $data['dateOfBirth'];
        if(empty($date)){
            $date = $this->getDateOfBirthFromPersonalNumber($personalNumberWithoutSpace);
        }
        
        if(empty($personalNumberWithoutSpace)){
            $personalNumberWithoutSpace = $date;
        }
        $pdo = $this->pdo;
        $pdo->beginTransaction();
        $tblBasicInformation = "INSERT INTO tblBasicInformation (memberId, firstName, lastName, gender, dateOfBirth, peronalNumber,familyStatus, residentStatus)
                  VALUES (".$data['memberId']." , '".$data['firstName']."' , '".$data['gFatherName']."' , '".$data['sex']."' , '".$date."' , ".$personalNumberWithoutSpace." , ".$data['familyStatus']." , ".$data['residentStatus'].")";
        $pdo->exec($tblBasicInformation);
        $tblLoginSql = "INSERT INTO tblLogin (memberId, primaryEmail, password, memberRole, confirmed, ConfirmationCode)
                  VALUES (".$data['memberId']." , '".$data['primaryEmail']."' , '".$hashedPassword."' , 1, 1, 'confirmationCode')";
        $pdo->exec($tblLoginSql);
        $tblContactAddress = "INSERT INTO tblContactAddress (memberId, mobileNumber1, country, ort, streetAddress, poBox)VALUES (".
            $data['memberId']." , '".$data['mobileNumber']."' , '".$data['country']."' , '".$data['ort']."' , '".
            $data['streetAddress']."' , '".$data['poBox']."')";
        $pdo->exec($tblContactAddress);
        $result = $pdo->commit();
        if($result){
           $this->incrementAvailableMemberId(); 
        }
        return $result;
    }
    /**
     * Password hash function
     * @param string $password User password.
     * @return string $password Hashed password.
     */
    private function hashPass($pass){
        return password_hash($pass, PASSWORD_DEFAULT);
    }
    
    /**
     * Validate date of birth
     * @param String $dateOfBirth
     * @param String $personalNumber
     * @return string empty string if $dateOfBirth is valid otherwise error message.
     */
    function validateDateOfBirth($dateOfBirth, $personalNumber){
        $dateOfBirthErr = $this->checkInputData($dateOfBirth, "Date of birth", 2, true);
        if(empty($dateOfBirthErr) && !empty($dateOfBirth)){
            $dateOfBirthLocal = $this->removeSpaceAndhyphen($dateOfBirth);
            $firstTwoDigit = substr($dateOfBirthLocal, 0, 2);
            if(strlen($dateOfBirthLocal)!=8 ||( $firstTwoDigit !="19" && $firstTwoDigit!="20")){
                $dateOfBirthErr ="Invalid date of birth. e.g 19671225 or 1967-12-25";
            }
            
            //check with personal number
            if(!empty($personalNumber)){
                $dateOfBirthFromPersonNumber = $this->changePersonalNumberForm($this->getDateOfBirthFromPersonalNumber($personalNumber));
                if($dateOfBirthLocal !=$dateOfBirthFromPersonNumber){
                    $dateOfBirthErr ="Invalid date of birth, does not much with personal number";
                }
             }
        }
        return $dateOfBirthErr;
        
    }
   
    /**
     * Get date of birth from personal number
     * @param  $personalNumber
     * @return string
     */
    function getDateOfBirthFromPersonalNumber($personalNumber){
        $dateOfBirth="";
        $personalNumberForm = $this->changePersonalNumberForm($personalNumber);
        if(strlen($personalNumberForm)==12){
            $dateOfBirth = substr($personalNumberForm, 0, 4)."-".substr($personalNumberForm, 4, 2)."-".substr($personalNumberForm, 6, 2);
        }
        return  $dateOfBirth;
    }
    
    /**
     * Check if email is already used.
     * @param string $email of user.
     * @return String
     */
     function checkEmailIfUsed($email){
         $emailError ="";
         if(!empty($email)){
             $pdo = $this->pdo;
             $stmt = $pdo->prepare('SELECT memberId FROM tblLogin where primaryEmail=? or email2=? limit 1');
             $stmt->execute([$email, $email]);
             if($stmt->rowCount() > 0){
                 $emailError="This email is used by other";
             }
         }
        return $emailError;
    }
    
    /**
     * Get the next free available member id.
     * @return int availableId
     */
    function getAvailableMemberId(){
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('SELECT * from tblMemberId limit 1');
        $stmt->execute();
        $row =$stmt->fetch();
        return $row['availableId'];
        
    }
    
    /**
     * Check if personal number is already used.
     * @param string $personalNumber of user.
     * @return String
     */
    function checkPersonalNumberIfUsed($personalNumber){
        $personalNumberError="";
        if(!empty($personalNumber)){
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('SELECT peronalNumber FROM tblBasicInformation WHERE peronalNumber = ? limit 1');
            $stmt->execute([$personalNumber]);
            if($stmt->rowCount() > 0){
                $personalNumberError="This personal number is used by other";
            }
        }
        return $personalNumberError;
    }
    
    
    /**
     * Get list of marital status in prepared select form.
     * @param $selectedFamilyStatusId 
     * 
     * @return string on successful
     */public function getMeritalStatusSelect($selectedFamilyStatusId){
        if(is_null($this->pdo)){
            $this->msg = 'Connection did not work out!';
            return "";
        }else{
            $localSelectedFamilyStatusId =4;
            if($selectedFamilyStatusId != 0){
                $localSelectedFamilyStatusId=$selectedFamilyStatusId;
            }
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('SELECT * from tblFamilyStatusTypes');
            $stmt->execute();
            $result = "<select name = 'selectMeritalStatus' form='memberRegistration'>";
            
            while($row =$stmt->fetch()){
                $result .="<option value = '{$row[0]}'";
                if ($localSelectedFamilyStatusId == $row[0]){
                    $result .= "selected = 'selected'";
                }
                $result .=">{$row[1]}</option><br>";
            }
            $result .="</select>";
            return $result;
        }
    }
    
    /**
     * Get list of residental status in prepared select form.
     * @param $selectedFamilyStatusId
     *
     * @return string on successful
     */public function getResidenceStatusSelect($selectedResidenceStatusId){
     if(is_null($this->pdo)){
         $this->msg = 'Connection did not work out!';
         return "";
     }else{
         $localSelectedResidenceStatusId =6; //default Not specified
         if($selectedResidenceStatusId != 0){
             $localSelectedResidenceStatusId=$selectedResidenceStatusId;
         }
         $pdo = $this->pdo;
         $stmt = $pdo->prepare('SELECT * from tblResidenceStatusTypes');
         $stmt->execute();
         $result = "<select name = 'selectResidenceStatus' form='memberRegistration'>";
         
         while($row =$stmt->fetch()){
             $result .="<option value = '{$row[0]}'";
             if ($localSelectedResidenceStatusId == $row[0]){
                 $result .= "selected = 'selected'";
             }
             $result .=">{$row[1]}</option><br>";
         }
         $result .="</select>";
         return $result;
     }
    }
    
}
?>
