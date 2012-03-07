<!DOCTYPE html> 
<html> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title><?= $data['title'] . " (" . SITE_NAME . ")" ?></title> 
    <link rel="stylesheet" href="//code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css" />
    <link rel="stylesheet" href="css/main.css" />
    <script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
    <script src="//code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
    <script src="js/core.js"></script>
</head> 
<body> 
    <div data-role="page" data-cache="never">
    <div data-role="header">
        <h1><?= $data['title'] ?></h1>
        <a href="/" data-role="button" data-icon="home">Home</a>
    </div><!-- /header -->