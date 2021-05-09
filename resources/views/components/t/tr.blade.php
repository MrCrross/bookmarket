@props(['body'=>'body','color'=>'blue'])
<?php
    $bg='';
    if($body==='head'){
        $bg='bg-'.$color.'-200';
    }
?>
<tr {{$attributes->merge(['class'=>$bg.' hover:bg-'.$color.'-300 transition ease-in-out duration-150'])}} >
    {{ $slot }}
</tr>
