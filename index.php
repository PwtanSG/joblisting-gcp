<?php
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
   case '/':                   // URL (without file name) to a default screen
      require 'jobview.php';
      break; 
   case '/jobsave.php':     // if you plan to also allow a URL with the file name 
      require 'jobsave.php';
      break;              
   case '/jobview.php':
      require 'jobview.php';
      break;
   case '/jobdetails.php':
      require 'jobdetails.php';
      break;
//    case '/index.php':
//       require 'jobview.php';
//       break;
   default:
      http_response_code(404);
      exit('Not Found');
}  
?>