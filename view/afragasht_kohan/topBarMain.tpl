{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
<!doctype html>
<html style="overflow-x: hidden" lang="fa">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="http://online.afragashtekohan.com/gds/view/afragasht_kohan/project_files/css/style.css">
    <style>

        body {
            background:none !important;
        }

    </style>

</head>
<body>

{include file="`$smarty.const.FRONT_THEMES_DIR`afragasht_kohan/topBar.tpl"}
{literal}
    <script type="text/javascript" src="http://www.afragashtekohan.com/fa/user/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript">

        function signout() {
            $.post('http://online.afragashtekohan.com/gds/user_ajax.php',
                {flag: 'signout'},
                function (data) {
                    window.top.location.href ="http://afragashtekohan.com/fa/user/home.php";
                }
            )
        }
    </script>
{/literal}
</body>

</html>
