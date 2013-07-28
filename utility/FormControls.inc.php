<?php

/**
 * @author 
 * @copyright 2013
 */

//TODO: add exception handling

class FormControls {
    //private member data
    private $isError = false;
    private $errorMsg = '';    
    
    //constructor
    function __construct(){
    }
    
    /********************************************
     * createSelect
     *
     * creates HTML select tag based on input parameters
     * 
     * INPUT:
     *  optionsRS       recordset of options data (id and names)
     *  selectedId      'value' of selected option
     *  attributeName   name of select form control (name attribute in select)
     *  idField         'value' field name in options recordset (in optionsRS)
     *  labelField      'label' field name in options recordset (in optionsRS)
     *  cssClass (optional) css class(es) to be applied to select tag
     *  cssId (optional)    css id for select tag
     *
     * OUTPUT: html of select dropdown
     *******************************************/
    public static function createSelect($optionsRS, $selectedId, $attributeName, $idField, $labelField, $cssClass = '', $cssId = ''){
        
        //die("DEBUG: $selectedId, $attributeName, $idField, $labelField");
        
        //input validation
        if(!isset($optionsRS)){
            die('optionsRS is a required parameter for FormControls->createSelect'); //required parameter
        }
        
        if(!isset($selectedId) || !strlen($attributeName)){
            die('selectedId is a required parameter for FormControls->createSelect'); //required parameter
        }
        
        if(!isset($attributeName) || !strlen($attributeName)){
            die('attributeName is a required parameter for FormControls->createSelect'); //required parameter
        }
        
        if(!isset($idField) || !strlen($idField)){
            die('idField is a required parameter for FormControls->createSelect'); //required parameter
        }
        
        if(!isset($labelField) || !strlen($labelField)){
            die('nameField is a required parameter for FormControls->createSelect'); //required parameter
        }
        
        $htmlString = '';
        
        //opening select tag
        $htmlString = '<select name="' . $attributeName . '" ';
        if(strlen($cssId)){ $htmlString .= ' id="' . $cssId . '" '; }
        if(strlen($cssClass)){ $htmlString .= ' class="' . $cssClass . '" '; }
        $htmlString .= '">';
        
        //option tags
        while($optionsRS && $optionsRS->num_rows && $row = $optionsRS->fetch_assoc()){
            $htmlString .= '<option value="' .  $row[$idField] . '" ';
            if($selectedId == $row[$idField]){ $htmlString .= ' selected '; }
            $htmlString .=  '>' . $row[$labelField] . '</option>';
        }
        
        //closing select tag
        $htmlString .= '</select>';
        
        return $htmlString;
    }
    
    public function isError(){
        return $this->isError;
    }
    
    public function getErrorMsg(){
        return $this->errorMsg;
    }
        
    //destructor
    function __destruct(){
    }
}
?>