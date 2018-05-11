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
        $ONLY_NUMBERS_AND_WHITE_SPACE_AND_HYPHEN_PLUS = "/^[0-9-+ ]*$/";
        
        
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
                $regularExpression = $ONLY_NUMBERS_AND_WHITE_SPACE_AND_HYPHEN_PLUS;
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