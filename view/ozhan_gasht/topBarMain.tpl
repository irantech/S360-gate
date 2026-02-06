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
        <link rel="stylesheet" type="text/css"
              href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/GlobalFile/css/register.css">
    <style>
        html{
            height: 100%;
            overflow: hidden;
        }
        body{
            font-family:  IRANSansnum !important;
            margin: 0;
            height: 100%;
            direction: rtl;
        }

    </style>

</head>
<body>

{include file="`$smarty.const.FRONT_THEMES_DIR`ozhan_gasht/topBar.tpl"}
{literal}
    <script src="https://{/literal}{$smarty.const.CLIENT_MAIN_DOMAIN}{literal}/fa/user/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">

        function signout() {
            $.post('https://online.ozhangasht.com/gds/user_ajax.php',
                {flag: 'signout'},
                function (data) {
                    window.top.location.href ="https://{/literal}{$smarty.const.CLIENT_MAIN_DOMAIN}{literal}/fa/user/home.php";
                }
            )
        }
    </script>
{/literal}
</body>

</html>
