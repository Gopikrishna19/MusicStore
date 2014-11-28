<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet" type="text/css">
<link href="/Assets/css/master.css" rel="stylesheet" type="text/css">
<?php foreach($this->css as $c): ?>
<link href="/Assets/css/<?php echo $c; ?>.css" rel="stylesheet" type="text/css">
<?php endforeach; ?>

<script src="/Assets/js/jquery.js"></script>
<script src="/Assets/js/plugin.js"></script>
<?php foreach($this->js as $j): ?>
<script src="/Assets/js/<?php echo $j; ?>.js"></script>
<?php endforeach; ?>

<title>Music Share<?php echo isset($this->title) ? " - ".$this->title : ""; ?></title>