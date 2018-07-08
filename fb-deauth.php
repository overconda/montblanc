<?php

if(isset($_REQUEST[‘signed_request’]))
  {    $data=$this->parse_signed_request($_REQUEST[‘signed_request’],’YOUR_FB_SECRET_KEY’);

}

?>