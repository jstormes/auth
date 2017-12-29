<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?=$this->e($title)?> - zend-expressive</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
    <style>
        body { padding-top: 60px; }
        .app { display: flex; min-height: 100vh; flex-direction: column; }
        .app-content { flex: 1; }
        .app-footer { padding-bottom: 1em; }
        .zf-green, h2 a { color: #68b604; }




    </style>
    <?=$this->section2('stylesheets')?>
</head>
<body class="app">
<header class="app-header">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    Oauth2
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="/users">
                            <i class="fa fa-users"></i> Users
                        </a>
                    </li>
                    <li>
                        <a href="https://docs.zendframework.com/zend-expressive/" target="_blank">
                            <i class="fa fa-book"></i> Docs
                        </a>
                    </li>
                    <li>
                        <a href="https://github.com/zendframework/zend-expressive" target="_blank">
                            <i class="fa fa-wrench"></i> Contribute
                        </a>
                    </li>
                    <li>
                        <a href="/api/ping">
                            Ping Test
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="app-content">
    <main class="container">
        <?=$this->section('content')?>
    </main>
</div>

<footer class="app-footer">
    <div class="container">
        <hr />
        <?php if ($this->section('footer')): ?>
            <?=$this->section('footer')?>
        <?php else: ?>
            <p>
                &copy; 2005 - <?=date('Y')?> by Zend Technologies Ltd. All rights reserved.
            </p>
        <?php endif ?>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<?=$this->section('javascript')?>
</body>
</html>
