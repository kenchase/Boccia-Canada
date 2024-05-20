<?php 
   function ccpsa_format_file_size_units($bytes)
   {
       if ($bytes >= 1073741824)
       {
           $bytes = number_format($bytes / 1073741824, 2) . __(' GB', 'ccpsa');
       }
       elseif ($bytes >= 1048576)
       {
           $bytes = number_format($bytes / 1048576, 2) . __(' MB', 'ccpsa');
       }
       elseif ($bytes >= 1024)
       {
           $bytes = number_format($bytes / 1024, 2) . __('KB', 'ccpsa');
       }
       elseif ($bytes > 1)
       {
           $bytes = $bytes . __(' bytes', 'ccpsa');
       }
       elseif ($bytes == 1)
       {
           $bytes = $bytes . __(' byte', 'ccpsa');
       }
       else
       {
           $bytes =  __('0 bytes', 'ccpsa');
       }
       return $bytes;
}