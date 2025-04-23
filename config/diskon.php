<?php

function diskon($total, $diskon)
{
   $bayar = $total - $diskon;

   return $bayar;
}
