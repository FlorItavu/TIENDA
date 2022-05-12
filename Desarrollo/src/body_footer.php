</div>

<br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br>
<div id="footer">
<!-- <div class="ui inverted segment" style="background-color: #4E4E4E; margin-left: 90%;">
    <button class="ui inverted button" onclick="location.href='logout.php'">Salir</button>
</div>
</div> -->
<!-- <div class='menu-container' style='background-color: #4E4E4E; height:100%;'>
  <div  style="background-color: #4E4E4E; ">
  <button class="ui inverted button" onclick="location.href='logout.php'">Salir</button>
  
  </div>

</div> -->

<?php
echo '<table width="100%" style="color:white"><tbody><tr>';

	echo '<td style="font-size:8pt; " align="right"><b>'.nitavu_nombre($NotITAVU_user).'</b>
<br>'.nitavu_puesto($NotITAVU_user).' <br><br>
<button class="ui inverted button" onclick="location.href= \'logout.php \'">Salir</button>

</td></tr>
</tbody></table>';
?>
</body>

</html>