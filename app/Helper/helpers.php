<?php

if (!function_exists('validation_message')) {
    function validation_message($errors){
    	$message = [];
    	foreach ($errors as $key => $value) {
    		$message[$key] = implode($value, ". ");
    	}

    	return $message;
    }
}

// if (!function_exists('check_scope')) {
//     function check_scope($guards)
//     {
//         $user = null;
//         foreach ($guards as $scope) {
//             if (auth($scope)->user($scope) && auth($scope)->user($scope)->tokenCan($scope)) {
//                 $user = auth($scope)->user($scope);
//             }
//         }
//         return $user;
//     }
// }