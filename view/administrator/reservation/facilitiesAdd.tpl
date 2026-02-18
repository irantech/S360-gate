{load_presentation_object filename="reservationBasicInformation" assign="objResult"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li class="active">افزودن امکانات</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30 textPriceChange">
                </p>

                <form id="FormFacilities" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_facilities">

                    <div class="form-group col-sm-12">
                    <div class="form-group col-sm-3">
                        <label for="title" class="control-label">عنوان</label>
                        <input type="text" class="form-control" name="title" value="{$smarty.post.title}"
                               id="title" placeholder="عنوان را وارد نمائید">
                    </div>
                    </div>

                    <div class="form-group col-md-12">
                            <label class="control-label">انتخاب کنید</label>
                            <div class="radio-list">

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio1" value="fa fa-bluetooth-b">
                                        <label for="radio1" class="size20"><i class="fontSize30 fa fa-bluetooth-b"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio2" value="fa fa-automobile">
                                        <label for="radio2" class="size20"><i class="fontSize30 fa fa-automobile"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio3" value="fa fa-coffee">
                                        <label for="radio3" class="size20"><i class="fontSize30 fa fa-coffee"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio4" value="fa fa-credit-card-alt">
                                        <label for="radio4" class="size20"><i class="fontSize30 fa fa-credit-card-alt"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio5" value="fa fa-taxi">
                                        <label for="radio5" class="size20"><i class="fontSize30 fa fa-taxi"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio6" value="fa fa-bed">
                                        <label for="radio" class="size20"><i class="fontSize30 fa fa-bed"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio7" value="fa fa-shopping-cart">
                                        <label for="radio7" class="size20"><i class="fontSize30 fa fa-shopping-cart"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio8" value="fa fa-medkit">
                                        <label for="radio8" class="size20"><i class="fontSize30 fa fa-medkit"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio9" value="fa fa-car">
                                        <label for="radio9" class="size20"><i class="fontSize30 fa fa-car"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio10" value="fa fa-cutlery">
                                        <label for="radio10" class="size20"><i class="fontSize30 fa fa-cutlery"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio12" value="fa fa-bank">
                                        <label for="radio12" class="size20"><i class="fontSize30 fa fa-bank"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio13" value="fa fa-archive">
                                        <label for="radio13" class="size20"><i class="fontSize30 fa fa-archive"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio14" value="fa fa-edge">
                                        <label for="radio14" class="size20"><i class="fontSize30 fa fa-edge"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio15" value="fa fa-product-hunt">
                                        <label for="radio15" class="size20"><i class="fontSize30 fa fa-product-hunt"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio16" value="fa fa-beer">
                                        <label for="radio16" class="size20"><i class="fontSize30 fa fa-beer"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio17" value="fa fa-bell">
                                        <label for="radio17" class="size20"><i class="fontSize30 fa fa-bell"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio18" value="fa fa-book">
                                        <label for="radio18" class="size20"><i class="fontSize30 fa fa-book"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio19" value="fa fa-camera-retro">
                                        <label for="radio19" class="size20"><i class="fontSize30 fa fa-camera-retro"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio20" value="fa fa-child">
                                        <label for="radio20" class="size20"><i class="fontSize30 fa fa-child"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio21" value="fa fa-check">
                                        <label for="radio21" class="size20"><i class="fontSize30 fa fa-check"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio23" value="fa fa-code-fork">
                                        <label for="radio23" class="size20"><i class="fontSize30 fa fa-code-fork"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio24" value="fa fa-credit-card">
                                        <label for="radio24" class="size20"><i class="fontSize30 fa fa-credit-card"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio26" value="fa fa-desktop">
                                        <label for="radio26" class="size20"><i class="fontSize30 fa fa-desktop"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio27" value="fa fa-edit">
                                        <label for="radio27" class="size20"><i class="fontSize30 fa fa-edit"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio28" value="fa fa-female">
                                        <label for="radio28" class="size20"><i class="fontSize30 fa fa-female"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio29" value="fa fa-film">
                                        <label for="radio29" class="size20"><i class="fontSize30 fa fa-film"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio30" value="fa fa-fire-extinguisher">
                                        <label for="radio30" class="size20"><i class="fontSize30 fa fa-fire-extinguisher"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio31" value="fa fa-home">
                                        <label for="radio31" class="size20"><i class="fontSize30 fa fa-home"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio32" value="fa fa-laptop">
                                        <label for="radio32" class="size20"><i class="fontSize30 fa fa-laptop"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio33" value="fa fa-mobile">
                                        <label for="radio33" class="size20"><i class="fontSize30 fa fa-mobile"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio34" value="fa fa-music">
                                        <label for="radio34" class="size20"><i class="fontSize30 fa fa-music"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio35" value="fa fa-phone-square">
                                        <label for="radio35" class="size20"><i class="fontSize30 fa fa-phone-square"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio36" value="fa fa-phone">
                                        <label for="radio36" class="size20"><i class="fontSize30 fa fa-phone"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio37" value="fa fa-pencil-square-o">
                                        <label for="radio37"  class="size20"><i class="fontSize30 fa fa-pencil-square-o"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio38" value="fa fa-pencil">
                                        <label for="radio38" class="size20"><i class="fontSize30 fa fa-pencil"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio40" value="fa fa-spoon">
                                        <label for="radio40" class="size20"><i class="fontSize30 fa fa-spoon"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio41" value="fa fa-suitcase">
                                        <label for="radio41" class="size20"><i class="fontSize30 fa fa-suitcase"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio42" value="fa fa-tree">
                                        <label for="radio42" class="size20"><i class="fontSize30 fa fa-tree"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio43" value="fa fa-wheelchair">
                                        <label for="radio43" class="size20"><i class="fontSize30 fa fa-wheelchair"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio44" value="fa fa-bicycle">
                                        <label for="radio44" class="size20"><i class="fontSize30 fa fa-bicycle"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio45" value="fa fa-cart-arrow-down">
                                        <label for="radio45" class="size20"><i class="fontSize30 fa fa-cart-arrow-down"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio46" value="fa fa-cart-plus">
                                        <label for="radio46" class="size20"><i class="fontSize30 fa fa-cart-plus"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio47" value="fa fa-bus">
                                        <label for="radio47" class="size20"><i class="fontSize30 fa fa-bus"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio48" value="fa fa-fighter-jet">
                                        <label for="radio48" class="size20"><i class="fontSize30 fa fa-fighter-jet"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio49" value="fa fa-gear">
                                        <label for="radio49" class="size20"><i class="fontSize30 fa fa-gear"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio50" value="fa fa-globe">
                                        <label for="radio50" class="size20"><i class="fontSize30 fa fa-globe"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio51" value="fa fa-key">
                                        <label for="radio51" class="size20"><i class="fontSize30 fa fa-key"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio52" value="fa fa-lock">
                                        <label for="radio52" class="size20"><i class="fontSize30 fa fa-lock"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio53" value="fa fa-leaf">
                                        <label for="radio53" class="size20"><i class="fontSize30 fa fa-leaf"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio54" value="fa fa-minus-circle">
                                        <label for="radio54" class="size20"><i class="fontSize30 fa fa-minus-circle"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio55" value="fa fa-motorcycle">
                                        <label for="radio55" class="size20"><i class="fontSize30 fa fa-motorcycle"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio56" value="fa fa-train">
                                        <label for="radio56" class="size20"><i class="fontSize30 fa fa-train"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio57" value="fa fa-shopping-basket">
                                        <label for="radio57" class="size20"><i class="fontSize30 fa fa-shopping-basket"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio58" value="fa fa-street-view">
                                        <label for="radio58" class="size20"><i class="fontSize30 fa fa-street-view"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio59" value="fa fa-television">
                                        <label for="radio59" class="size20"><i class="fontSize30 fa fa-television"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio60" value="fa fa-umbrella">
                                        <label for="radio60" class="size20"><i class="fontSize30 fa fa-umbrella"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio61" value="fa fa-tv">
                                        <label for="radio61" class="size20"><i class="fontSize30 fa fa-tv"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio62" value="fa fa-trash-o">
                                        <label for="radio62" class="size20"><i class="fontSize30 fa fa-trash-o"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio63" value="fa fa-unlock">
                                        <label for="radio63" class="size20"><i class="fontSize30 fa fa-unlock"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio64" value="fa fa-unlock-alt">
                                        <label for="radio64" class="size20"><i class="fontSize30 fa fa-unlock-alt"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio65" value="fa fa-user">
                                        <label for="radio65" class="size20"><i class="fontSize30 fa fa-user"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio66" value="fa fa-volume-down">
                                        <label for="radio66" class="size20"><i class="fontSize30 fa fa-volume-down"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio67" value="fa fa-wheelchair">
                                        <label for="radio67" class="size20"><i class="fontSize30 fa fa-wheelchair"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio68" value="fa fa-wifi">
                                        <label for="radio68" class="size20"><i class="fontSize30 fa fa-wifi"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio69" value="fa fa-wrench">
                                        <label for="radio69" class="size20"><i class="fontSize30 fa fa-wrench"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio70" value="fa fa-users">
                                        <label for="radio70" class="size20"><i class="fontSize30 fa fa-users"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio71" value="fa fa-github-alt">
                                        <label for="radio71" class="size20"><i class="fontSize30 fa fa-github-alt"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio72" value="fa fa-linux">
                                        <label for="radio72" class="size20"><i class="fontSize30 fa fa-linux"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio73" value="fa fa-pagelines">
                                        <label for="radio73" class="size20"><i class="fontSize30 fa fa-pagelines"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio74" value="fa fa-futbol-o">
                                        <label for="radio74" class="size20"><i class="fontSize30 fa fa-futbol-o"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio75" value="mdi mdi-amplifier">
                                        <label for="radio75" class="size20"><i class="fontSize30 mdi mdi-amplifier"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio76" value="ravis-icon-air-conditioner">
                                        <label for="radio76" class="size20"><i class="fontSize30 ravis-icon-air-conditioner"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio77" value="ravis-icon-alarm-clock">
                                        <label for="radio77" class="size20"><i class="fontSize30 ravis-icon-alarm-clock"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio78" value="ravis-icon-briefcase">
                                        <label for="radio78" class="size20"><i class="fontSize30 ravis-icon-briefcase"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio79" value="ravis-icon-door-knob">
                                        <label for="radio79" class="size20"><i class="fontSize30 ravis-icon-door-knob"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio80" value="ravis-icon-drawers">
                                        <label for="radio80" class="size20"><i class="fontSize30 ravis-icon-drawers"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio81" value="ravis-icon-fire-extinguisher">
                                        <label for="radio81" class="size20"><i class="fontSize30 ravis-icon-fire-extinguisher"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio82" value="ravis-icon-funnel">
                                        <label for="radio82" class="size20"><i class="fontSize30 ravis-icon-funnel"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio83" value="ravis-icon-hanger">
                                        <label for="radio83" class="size20"><i class="fontSize30 ravis-icon-hanger"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio84" value="ravis-icon-iron">
                                        <label for="radio84" class="size20"><i class="fontSize30 ravis-icon-iron"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio85" value="ravis-icon-key">
                                        <label for="radio85" class="size20"><i class="fontSize30 ravis-icon-key"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio86" value="ravis-icon-microwave">
                                        <label for="radio86" class="size20"><i class="fontSize30 ravis-icon-microwave"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio87" value="ravis-icon-navigator">
                                        <label for="radio87" class="size20"><i class="fontSize30 ravis-icon-navigator"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio88" value="ravis-icon-newspaper">
                                        <label for="radio88" class="size20"><i class="fontSize30 ravis-icon-newspaper"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio89" value="ravis-icon-nightstand">
                                        <label for="radio89" class="size20"><i class="fontSize30 ravis-icon-nightstand"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio90" value="ravis-icon-paint-roller">
                                        <label for="radio90" class="size20"><i class="fontSize30 ravis-icon-paint-roller"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio91" value="ravis-icon-photo-camera">
                                        <label for="radio91" class="size20"><i class="fontSize30 ravis-icon-photo-camera"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio92" value="ravis-icon-plug">
                                        <label for="radio92" class="size20"><i class="fontSize30 ravis-icon-plug"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio93" value="ravis-icon-radio">
                                        <label for="radio93" class="size20"><i class="fontSize30 ravis-icon-radio"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio94" value="ravis-icon-plug">
                                        <label for="radio94" class="size20"><i class="fontSize30 ravis-icon-plug"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio95" value="ravis-icon-radio">
                                        <label for="radio95" class="size20"><i class="fontSize30 ravis-icon-radio"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio96" value="ravis-icon-shower">
                                        <label for="radio96" class="size20"><i class="fontSize30 ravis-icon-shower"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio97" value="ravis-icon-speaker">
                                        <label for="radio97" class="size20"><i class="fontSize30 ravis-icon-speaker"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio98" value="ravis-icon-stairs">
                                        <label for="radio98" class="size20"><i class="fontSize30 ravis-icon-stairs"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio99" value="ravis-icon-stairs-1">
                                        <label for="radio99" class="size20"><i class="fontSize30 ravis-icon-stairs-1"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio100" value="ravis-icon-television">
                                        <label for="radio100" class="size20"><i class="fontSize30 ravis-icon-television"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio101" value="ravis-icon-toilet-paper">
                                        <label for="radio101" class="size20"><i class="fontSize30 ravis-icon-toilet-paper"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio102" value="ravis-icon-towel">
                                        <label for="radio102" class="size20"><i class="fontSize30 ravis-icon-towel"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio103" value="ravis-icon-wash">
                                        <label for="radio103" class="size20"><i class="fontSize30 ravis-icon-wash"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio104" value="ravis-icon-watch">
                                        <label for="radio104" class="size20"><i class="fontSize30 ravis-icon-watch"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio105" value="ravis-icon-air-conditioner2">
                                        <label for="radio105" class="size20"><i class="fontSize30 ravis-icon-air-conditioner2"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio106" value="ravis-icon-bar">
                                        <label for="radio106" class="size20"><i class="fontSize30 ravis-icon-bar"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio107" value="ravis-icon-business-center">
                                        <label for="radio107" class="size20"><i class="fontSize30 ravis-icon-business-center"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio108" value="ravis-icon-check-in">
                                        <label for="radio108" class="size20"><i class="fontSize30 ravis-icon-check-in"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio109" value="ravis-icon-cleaning-service">
                                        <label for="radio109" class="size20"><i class="fontSize30 ravis-icon-cleaning-service"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio110" value="ravis-icon-coffee-cup">
                                        <label for="radio110" class="size20"><i class="fontSize30 ravis-icon-coffee-cup"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio111" value="ravis-icon-conference">
                                        <label for="radio111" class="size20"><i class="fontSize30 ravis-icon-conference"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio112" value="ravis-icon-family-room">
                                        <label for="radio112" class="size20"><i class="fontSize30 ravis-icon-family-room"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio113" value="ravis-icon-hotel-room">
                                        <label for="radio113" class="size20"><i class="fontSize30 ravis-icon-hotel-room"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio114" value="ravis-icon-hotel-sign">
                                        <label for="radio114" class="size20"><i class="fontSize30 ravis-icon-hotel-sign"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio115" value="ravis-icon-hotel-staff">
                                        <label for="radio115" class="size20"><i class="fontSize30 ravis-icon-hotel-staff"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio116" value="ravis-icon-laundry-service">
                                        <label for="radio116" class="size20"><i class="fontSize30 ravis-icon-laundry-service"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio117" value="ravis-icon-luggage">
                                        <label for="radio117" class="size20"><i class="fontSize30 ravis-icon-luggage"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio118" value="ravis-icon-no-smoking">
                                        <label for="radio118" class="size20"><i class="fontSize30 ravis-icon-no-smoking"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio119" value="ravis-icon-not-disturb">
                                        <label for="radio119" class="size20"><i class="fontSize30 ravis-icon-not-disturb"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio120" value="ravis-icon-parking">
                                        <label for="radio120" class="size20"><i class="fontSize30 ravis-icon-parking"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio121" value="ravis-icon-reception">
                                        <label for="radio121" class="size20"><i class="fontSize30 ravis-icon-reception"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio122" value="ravis-icon-reception-bell">
                                        <label for="radio122" class="size20"><i class="fontSize30 ravis-icon-reception-bell"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio123" value="ravis-icon-restaurant">
                                        <label for="radio123" class="size20"><i class="fontSize30 ravis-icon-restaurant"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio124" value="ravis-icon-room-key">
                                        <label for="radio124" class="size20"><i class="fontSize30 ravis-icon-room-key"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio125" value="ravis-icon-room-service">
                                        <label for="radio125" class="size20"><i class="fontSize30 ravis-icon-room-service"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio126" value="ravis-icon-safebox">
                                        <label for="radio126" class="size20"><i class="fontSize30 ravis-icon-safebox"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio127" value="ravis-icon-shower2">
                                        <label for="radio127" class="size20"><i class="fontSize30 ravis-icon-shower2"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio128" value="ravis-icon-spa">
                                        <label for="radio128" class="size20"><i class="fontSize30 ravis-icon-spa"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio129" value="ravis-icon-sport-centre">
                                        <label for="radio129" class="size20"><i class="fontSize30 ravis-icon-sport-centre"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio130" value="ravis-icon-swimming-pool">
                                        <label for="radio130" class="size20"><i class="fontSize30 ravis-icon-swimming-pool"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio131" value="ravis-icon-television2">
                                        <label for="radio131" class="size20"><i class="fontSize30 ravis-icon-television2"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio132" value="ravis-icon-toiletries">
                                        <label for="radio132" class="size20"><i class="fontSize30 ravis-icon-toiletries"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio133" value="ravis-icon-wifi-room">
                                        <label for="radio133" class="size20"><i class="fontSize30 ravis-icon-wifi-room"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio134" value="ravis-icon-h-clock">
                                        <label for="radio134" class="size20"><i class="fontSize30 ravis-icon-h-clock"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio135" value="ravis-icon-h-telephone">
                                        <label for="radio135" class="size20"><i class="fontSize30 ravis-icon-h-telephone"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio136" value="ravis-icon-alarm-clock2">
                                        <label for="radio136" class="size20"><i class="fontSize30 ravis-icon-alarm-clock2"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio137" value="ravis-icon-bathroom-sink">
                                        <label for="radio137" class="size20"><i class="fontSize30 ravis-icon-bathroom-sink"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio138" value="ravis-icon-bathtub-with-water-dropping">
                                        <label for="radio138" class="size20"><i class="fontSize30 ravis-icon-bathtub-with-water-dropping"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio139" value="ravis-icon-beer-mug">
                                        <label for="radio139" class="size20"><i class="fontSize30 ravis-icon-beer-mug"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio140" value="ravis-icon-black-and-white-credit-cards">
                                        <label for="radio140" class="size20"><i class="fontSize30 ravis-icon-black-and-white-credit-cards"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio141" value="ravis-icon-bottle-in-bucket">
                                        <label for="radio141" class="size20"><i class="fontSize30 ravis-icon-bottle-in-bucket"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio142" value="ravis-icon-bowling-pin-and-ball">
                                        <label for="radio142" class="size20"><i class="fontSize30 ravis-icon-bowling-pin-and-ball"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio143" value="ravis-icon-briefcase-with-plus-symbol">
                                        <label for="radio143" class="size20"><i class="fontSize30 ravis-icon-briefcase-with-plus-symbol"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio144" value="ravis-icon-burger-on-plate">
                                        <label for="radio144" class="size20"><i class="fontSize30 ravis-icon-burger-on-plate"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio145" value="ravis-icon-cigar-with-smoke">
                                        <label for="radio145" class="size20"><i class="fontSize30 ravis-icon-cigar-with-smoke"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio146" value="ravis-icon-closed-sign">
                                        <label for="radio146" class="size20"><i class="fontSize30 ravis-icon-closed-sign"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio147" value="ravis-icon-clothes-hanger">
                                        <label for="radio147" class="size20"><i class="fontSize30 ravis-icon-clothes-hanger"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio148" value="ravis-icon-clothes-iron">
                                        <label for="radio148" class="size20"><i class="fontSize30 ravis-icon-clothes-iron"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio149" value="ravis-icon-cocktail-glass">
                                        <label for="radio149" class="size20"><i class="fontSize30 ravis-icon-cocktail-glass"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio150" value="ravis-icon-coffee-pot">
                                        <label for="radio150" class="size20"><i class="fontSize30 ravis-icon-coffee-pot"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio151" value="ravis-icon-computer-with-wifi-signal">
                                        <label for="radio151" class="size20"><i class="fontSize30 ravis-icon-computer-with-wifi-signal"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio152" value="ravis-icon-desk-bell">
                                        <label for="radio152" class="size20"><i class="fontSize30 ravis-icon-desk-bell"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio152" value="ravis-icon-digital-phone">
                                        <label for="radio152" class="size20"><i class="fontSize30 ravis-icon-digital-phone"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio153" value="ravis-icon-dollar-bills">
                                        <label for="radio153" class="size20"><i class="fontSize30 ravis-icon-dollar-bills"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio154" value="ravis-icon-door-hanger">
                                        <label for="radio154" class="size20"><i class="fontSize30 ravis-icon-door-hanger"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio155" value="ravis-icon-door-key">
                                        <label for="radio155" class="size20"><i class="fontSize30 ravis-icon-door-key"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio156" value="ravis-icon-double-bed">
                                        <label for="radio156" class="size20"><i class="fontSize30 ravis-icon-double-bed"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio157" value="ravis-icon-down-left-arrow">
                                        <label for="radio157" class="size20"><i class="fontSize30 ravis-icon-down-left-arrow"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio158" value="ravis-icon-elevator-braille-button">
                                        <label for="radio158" class="size20"><i class="fontSize30 ravis-icon-elevator-braille-button"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio159" value="ravis-icon-fast-food-burger-and-drink">
                                        <label for="radio159" class="size20"><i class="fontSize30 ravis-icon-fast-food-burger-and-drink"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio160" value="ravis-icon-fire-extinguisher2">
                                        <label for="radio160" class="size20"><i class="fontSize30 ravis-icon-fire-extinguisher2"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio161" value="ravis-icon-food-tray-with-cover">
                                        <label for="radio161" class="size20"><i class="fontSize30 ravis-icon-food-tray-with-cover"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio162" value="ravis-icon-golf-green">
                                        <label for="radio162" class="size20"><i class="fontSize30 ravis-icon-golf-green"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio163" value="ravis-icon-gym-dumbbell">
                                        <label for="radio163" class="size20"><i class="fontSize30 ravis-icon-gym-dumbbell"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio164" value="ravis-icon-hair-dryer">
                                        <label for="radio164" class="size20"><i class="fontSize30 ravis-icon-hair-dryer"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio165" value="ravis-icon-hair-scissors-and-comb">
                                        <label for="radio165" class="size20"><i class="fontSize30 ravis-icon-hair-scissors-and-comb"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio166" value="ravis-icon-hotel-bellhop">
                                        <label for="radio166" class="size20"><i class="fontSize30 ravis-icon-hotel-bellhop"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio167" value="ravis-icon-hotel-coat-check">
                                        <label for="radio167" class="size20"><i class="fontSize30 ravis-icon-hotel-coat-check"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio168" value="ravis-icon-hotel-do-not-disturb-door-hanger">
                                        <label for="radio168" class="size20"><i class="fontSize30 ravis-icon-hotel-do-not-disturb-door-hanger"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio169" value="ravis-icon-hotel-door-key">
                                        <label for="radio169" class="size20"><i class="fontSize30 ravis-icon-hotel-door-key"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio170" value="ravis-icon-hotel-elevator-sign">
                                        <label for="radio170" class="size20"><i class="fontSize30 ravis-icon-hotel-elevator-sign"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio171" value="ravis-icon-hotel-five-stars-sign">
                                        <label for="radio171" class="size20"><i class="fontSize30 ravis-icon-hotel-five-stars-sign"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio172" value="ravis-icon-hotel-food-cart">
                                        <label for="radio172" class="size20"><i class="fontSize30 ravis-icon-hotel-food-cart"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio173" value="ravis-icon-hotel-front-view">
                                        <label for="radio173" class="size20"><i class="fontSize30 ravis-icon-hotel-front-view"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio174" value="ravis-icon-hotel-keycard">
                                        <label for="radio174" class="size20"><i class="fontSize30 ravis-icon-hotel-keycard"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio175" value="ravis-icon-hotel-left-luggage">
                                        <label for="radio175" class="size20"><i class="fontSize30 ravis-icon-hotel-left-luggage"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio176" value="ravis-icon-hotel-luggage-trolley">
                                        <label for="radio176" class="size20"><i class="fontSize30 ravis-icon-hotel-luggage-trolley"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio177" value="ravis-icon-hotel-maid">
                                        <label for="radio177" class="size20"><i class="fontSize30 ravis-icon-hotel-maid"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio178" value="ravis-icon-hotel-receptionist">
                                        <label for="radio178" class="size20"><i class="fontSize30 ravis-icon-hotel-receptionist"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio179" value="ravis-icon-hotel-receptionist-1">
                                        <label for="radio179" class="size20"><i class="fontSize30 ravis-icon-hotel-receptionist-1"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio180" value="ravis-icon-hotel-single-bed">
                                        <label for="radio180" class="size20"><i class="fontSize30 ravis-icon-hotel-single-bed"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio181" value="ravis-icon-hotel-tv">
                                        <label for="radio181" class="size20"><i class="fontSize30 ravis-icon-hotel-tv"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio182" value="ravis-icon-ice-cream-cone">
                                        <label for="radio182" class="size20"><i class="fontSize30 ravis-icon-ice-cream-cone"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio183" value="ravis-icon-information-sign">
                                        <label for="radio183" class="size20"><i class="fontSize30 ravis-icon-information-sign"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio184" value="ravis-icon-no-cameras-sign">
                                        <label for="radio184" class="size20"><i class="fontSize30 ravis-icon-no-cameras-sign"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio185" value="ravis-icon-no-smoking-sign">
                                        <label for="radio185" class="size20"><i class="fontSize30 ravis-icon-no-smoking-sign"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio186" value="ravis-icon-open-sign">
                                        <label for="radio186" class="size20"><i class="fontSize30 ravis-icon-open-sign"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio187" value="ravis-icon-parking-sign">
                                        <label for="radio187" class="size20"><i class="fontSize30 ravis-icon-parking-sign"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio187" value="ravis-icon-pet-transport-box">
                                        <label for="radio187" class="size20"><i class="fontSize30 ravis-icon-pet-transport-box"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio188" value="ravis-icon-photo-camera2">
                                        <label for="radio188" class="size20"><i class="fontSize30 ravis-icon-photo-camera2"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio189" value="ravis-icon-plunger-and-brush">
                                        <label for="radio189" class="size20"><i class="fontSize30 ravis-icon-plunger-and-brush"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio190" value="ravis-icon-pool-eight-ball">
                                        <label for="radio190" class="size20"><i class="fontSize30 ravis-icon-pool-eight-ball"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio191" value="ravis-icon-restaurant-sign">
                                        <label for="radio191" class="size20"><i class="fontSize30 ravis-icon-restaurant-sign"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio192" value="ravis-icon-soup-bowl">
                                        <label for="radio192" class="size20"><i class="fontSize30 ravis-icon-soup-bowl"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio193" value="ravis-icon-sun-umbrella-with-beach-chair">
                                        <label for="radio193" class="size20"><i class="fontSize30 ravis-icon-sun-umbrella-with-beach-chair"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio194" value="ravis-icon-surveillance-camera">
                                        <label for="radio194" class="size20"><i class="fontSize30 ravis-icon-surveillance-camera"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio195" value="ravis-icon-sweeping-broom">
                                        <label for="radio195" class="size20"><i class="fontSize30 ravis-icon-sweeping-broom"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio196" value="ravis-icon-swimming-pool-sign">
                                        <label for="radio196" class="size20"><i class="fontSize30 ravis-icon-swimming-pool-sign"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio197" value="ravis-icon-taxi-front-view">
                                        <label for="radio197" class="size20"><i class="fontSize30 ravis-icon-taxi-front-view"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio198" value="ravis-icon-tennis-racket-and-ball">
                                        <label for="radio198" class="size20"><i class="fontSize30 ravis-icon-tennis-racket-and-ball"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio199" value="ravis-icon-thermometer-cold-temperature">
                                        <label for="radio199" class="size20"><i class="fontSize30 ravis-icon-thermometer-cold-temperature"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio200" value="ravis-icon-thermometer-high-temperature">
                                        <label for="radio200" class="size20"><i class="fontSize30 ravis-icon-thermometer-high-temperature"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio201" value="ravis-icon-three-star-hotel-sign">
                                        <label for="radio201" class="size20"><i class="fontSize30 ravis-icon-three-star-hotel-sign"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio202" value="ravis-icon-toilet-sign">
                                        <label for="radio202" class="size20"><i class="fontSize30 ravis-icon-toilet-sign"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio203" value="ravis-icon-toilet-sign-1">
                                        <label for="radio203" class="size20"><i class="fontSize30 ravis-icon-toilet-sign-1"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio204" value="ravis-icon-toothpaste-and-toothbrush">
                                        <label for="radio204" class="size20"><i class="fontSize30 ravis-icon-toothpaste-and-toothbrush"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio205" value="ravis-icon-towel-on-hanger">
                                        <label for="radio205" class="size20"><i class="fontSize30 ravis-icon-towel-on-hanger"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio206" value="ravis-icon-towel-on-hanger-1">
                                        <label for="radio206" class="size20"><i class="fontSize30 ravis-icon-towel-on-hanger-1"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio207" value="ravis-icon-travelling-luggage">
                                        <label for="radio207" class="size20"><i class="fontSize30 ravis-icon-travelling-luggage"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio208" value="ravis-icon-two-semicircles">
                                        <label for="radio208" class="size20"><i class="fontSize30 ravis-icon-two-semicircles"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio209" value="ravis-icon-up-right-arrow">
                                        <label for="radio209" class="size20"><i class="fontSize30 ravis-icon-up-right-arrow"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio210" value="ravis-icon-waiter-with-tray">
                                        <label for="radio210" class="size20"><i class="fontSize30 ravis-icon-waiter-with-tray"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio211" value="ravis-icon-washing-machine">
                                        <label for="radio211" class="size20"><i class="fontSize30 ravis-icon-washing-machine"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio212" value="fa fa-github">
                                        <label for="radio212" class="size20"><i class="fontSize30 fa fa-github"></i></label>
                                    </div>
                                </div>

                                <div class="radio-inline col-sm-1">
                                    <div class="radio radio-info">
                                        <input type="radio" name="radio" id="radio213" value="mdi mdi-fire">
                                        <label for="radio213" class="size20"><i class="fontSize30 mdi mdi-fire"></i></label>
                                    </div>
                                </div>

                            </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>



    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">امکانات</h3>
                <p class="text-muted m-b-30">
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>آیکون</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->SelectAll('reservation_facilities_tb')}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td id="borderTypeOfVehicle-{$item.id}">{$number}</td>

                            <td>{$item.title}</td>

                            <td><i class="fontSize30 {$item.icon_class}"></i></td>

                            <td>

                                {*if $objResult->permissionToDelete('reservation_hotel_facilities_tb', 'id_facilities', {$item.id}) eq 'yes' || $objResult->PermissionToDelete('reservation_room_facilities_tb', 'id_facilities', {$item.id}) eq 'yes'}
                                <a onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title=" تغییرات" data-placement="right"
                                   data-content="امکان ویرایش وجود ندارد"><i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                </a>
                                {else}
                                <a href="facilitiesEdit&id={$item.id}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش">

                                    </i>
                                </a>
                                {/if*}
                                <a href="facilitiesEdit&id={$item.id}">
                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش">

                                    </i>
                                </a>

                            </td>


                            <td>

                                {if $objResult->permissionToDelete('reservation_hotel_facilities_tb', 'id_facilities', {$item.id}) eq 'yes' || $objResult->PermissionToDelete('reservation_room_facilities_tb', 'id_facilities', {$item.id}) eq 'yes'}
                                <a onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="امکان حذف وجود ندارد"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                </a>
                                {else if $item.is_del eq 'yes'}
                                <a onclick="return false" class="cursor-default  popoverBox  popover-default"  data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content=" قبلا حذف کرده اید"> <i class="fcbtn btn btn-outline btn-default btn-1c fa fa-ban " ></i>
                                </a>
                                {else}
                                <a id="DelHotelRoom-{$item.id}" onclick="logical_deletion('{$item.id}', 'reservation_facilities_tb'); return false" class="popoverBox  popover-danger" data-toggle="popover" title="حذف تغییرات" data-placement="right"
                                   data-content="حذف "> <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-trash "></i>
                                </a>
                                {/if}
                            </td>

                        </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>



</div>

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش امکانات هتل و اتاق   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/379/---.html" target="_blank" class="i-btn"></a>

</div>


<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>