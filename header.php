<!DOCTYPE html>
<html lang="pt-br">

<head>
	<!-- Meta tags -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="content-language" content="pt-br">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="follow">
	<meta name="description" content="<?=__('Liga Internacional dos Trabalhadores - Quarta Internacional')?>">

	<meta property="og:title" content="<?php is_front_page() ? bloginfo('name') : wp_title('|', 1, 'right').' | '.bloginfo('name'); ?>"/>
	<meta property="og:type" content="article"/>
	<meta property="og:description" content="<?=__('Liga Internacional dos Trabalhadores - Quarta Internacional')?>"/>
	<meta property="og:site_name" content="Opinião Socialista"/>
	<meta property="or:url" content=""/>
	<!-- End of Meta tags -->

	<!-- CSS -->
	<link rel="icon" type="image/x-icon" href=<?= get_template_directory_uri() . "/assets/img/favicon.gif" ?>>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" />

	<title><?php is_front_page() ? bloginfo('name') : wp_title('|', 1, 'right').' | '.bloginfo('name'); ?></title>

	<?php wp_head(); ?>


</head>

<body <?php body_class(); ?>>
<?php
	include('nav.php');
?>