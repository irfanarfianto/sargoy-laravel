<?php

if (!function_exists('base64_to_image_src')) {
   function base64_to_image_src($base64String, $mime = 'image/jpeg')
   {
      return 'data:' . $mime . ';base64,' . $base64String;
   }
}
