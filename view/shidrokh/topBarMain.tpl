{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
<!doctype html>
<html lang="fa">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" type="text/css" href="https://shidrokh-travel.ir/fa/user/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://shidrokh-travel.ir/fa/user/GlobalFile/css/register.css">



    <style>

        html{
            overflow: hidden;
            height: 100%;
        }
        body {
            height: 100%;
            font-family: IranSansLight, IRANSansnum !important;
            position: relative;
            direction: rtl;
            overflow: hidden;
            background:none !important;
            margin: 0!important;
            padding: 0;
        }
        .logined-name{
           /* display: block!important;*/
            line-height: 58px!important;
            height: 58px!important;
            color:#460096!important;
        }
        .userProfile-name{ padding-top: 3px; }
        .top-bar-inner{ display: flex }
        i.svg-icon svg {
            width: 17px;
            height: 17px;
            fill: #bfb7b1;
        }
        .login {
            margin-right: 0px;
            border-left: 1px solid #bfb7b1;
            padding-left: 20px;
        }
        .login-register > div {
            margin: 0 10px;
            margin-right: 10px;
        }
        .login-register {
            display: flex;
            margin: 0;
        }
        .tell {
            margin-right: auto;
        }
        .top-bar-inner a {
            font-size: 14px;
            font-family: IranSans;
            color: #bfb7b1;
            position: relative;
            text-decoration: none;
        }
        .tell a{ font-size: 12px; font-family: IranSans}




    </style>

</head>
<body>

{include file="`$smarty.const.FRONT_THEMES_DIR`shidrokh/topBar.tpl"}
{literal}
    <script  type="text/javascript" src="https://shidrokh-travel.ir/fa/user/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript">
        function signout() {
            $.post('https://online.shidrokh-travel.ir/gds/user_ajax.php',
                {flag: 'signout'},
                function (data) {
                    window.top.location.href ="https://shidrokh-travel.ir/";
                }
            )
        }
    </script>
{/literal}
</body>

</html>
