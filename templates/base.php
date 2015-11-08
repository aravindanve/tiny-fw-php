<?php defined('APPPATH') or die('No script access'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- /meta -->

    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('favicon.png'); ?>">

    <title><?php echo $PAGE_TITLE; ?></title>

    <!-- cdn/css includes -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic|Oxygen:400,300,700" type="text/css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.9.1/styles/default.min.css">
    <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->
    <!-- /cdn/css includes -->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- css includes -->
    <link rel="stylesheet" href="<?php echo static_url('css/highlight-github.css'); ?>">
    <link rel="stylesheet" href="<?php echo static_url('css/style.css'); ?>">
    <!-- /css includes -->
</head>
<body>
    <div id="body-wrapper">

        <!-- header -->
        <?php include partial('header'); ?>
        
        <!-- page-body -->
        <?php echo $PAGE_BODY; ?>
        
        <!-- footer -->
        <?php include partial('footer'); ?>

    </div><!-- /#body-wrapper -->
    <!-- scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.9.1/highlight.min.js"></script>
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>-->
    <script src="<?php // echo static_url('js/script.js'); ?>"></script>
    <script>hljs.initHighlightingOnLoad();</script>
</body>
</html>


