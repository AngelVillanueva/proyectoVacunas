<?php    

echo 'INFORMES <br/>';
echo $html->link('Antihepatitis-B neonatos',array('controller' => 'vaccinations', 'action' => 'report', 1));
echo '<br/>';
echo $html->link('Calendario infantil obligatorio',array('controller' => 'vaccinations', 'action' => 'report', 2));
echo '<br/>';
echo $html->link('Campaña Antigripal',array('controller' => 'vaccinations', 'action' => 'report', 3));
echo '<br/>';
echo $html->link('Adultos (dosis)',array('controller' => 'vaccinations', 'action' => 'report', 4));
echo '<br/>';
echo $html->link('Adultos (sin dosis)',array('controller' => 'vaccinations', 'action' => 'report', 5));
?>
<br/>
<br/>
<br/>
<br/>
<?php    

echo 'FORMULARIOS <br/>';
echo $html->link('Antihepatitis-B neonatos',array('controller' => 'patients', 'action' => 'add', 1));
echo '<br/>';
echo $html->link('Calendario infantil obligatorio',array('controller' => 'patients', 'action' => 'add', 2));
echo '<br/>';
echo $html->link('Campaña Antigripal',array('controller' => 'patients', 'action' => 'add', 3));
echo '<br/>';
echo $html->link('Adultos (dosis)',array('controller' => 'patients', 'action' => 'add', 4));
echo '<br/>';
echo $html->link('Adultos (sin dosis)',array('controller' => 'patients', 'action' => 'add', 5));
?>