<?php
$array_special_char = ["\n", "‘", "’", "“", "”", "„" , "(", ")", "<", ">","</","/>","alert","+","from","sleep"] ;
foreach ($_POST as $key=>$item) {
    $item_after_replace[$key] = str_replace($array_special_char, '', $item);

    $_POST[$key] = $item_after_replace[$key];
}


require 'config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require CONFIG_DIR . 'configBase.php';
require LIBRARY_DIR . 'functions.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

if(isset($_POST['flag']) && $_POST['flag']=='EditEntertainment'){
    unset($_POST['flag']);
    $Enter=Load::controller('entertainment');
    echo json_encode($Enter->EditEntertainment($_POST));
}elseif(isset($_POST['flag']) && $_POST['flag']=='AddEntertainment'){
    unset($_POST['flag']);
    $Enter=Load::controller('entertainment');
    echo json_encode($Enter->AddEntertainment($_POST));
}elseif(isset($_POST['flag']) && $_POST['flag']=='GetEntertainmentData'){
//var_dump($_POST);
//die;
    unset($_POST['flag']);
    if(isset($_POST['data_table']) && $_POST['data_table'] == 'true' ){
        $data_table=true;
    }else{
        $data_table=false;
    }
    /**@param $Enter entertainment  */
    $Enter=Load::controller('entertainment');

    $Data=$Enter->GetEntertainmentData($_POST['country_id'],$_POST['city_id'],$_POST['category_id'], $_POST['is_request'], $_POST['EntertainmentId'], $data_table);

    $getDiscount=$Enter->getDiscount();
    if($Data){
        $output['data']=$Data;
        $output['discount']=$getDiscount;
        $output['result_status']='success';
        $output['result_message']='دریافت موفقیت آمیز';
    }else{
//        $output['result_status']=functions::Xmlinformation('Noresult');
//        $output['result_message']=functions::Xmlinformation('NotResultForSearch');
        $full_capacity_controller=Load::controller('fullCapacity');
        $get_full_capacity = $full_capacity_controller->getFullCapacitySite(1);
        $pic_not_resule = '';
        if ($get_full_capacity['pic_url']) {
            $pic_not_resule = "<img src='".$get_full_capacity['pic_url'] ."' alt='".$get_full_capacity['pic_title'] ."'>";
        }else{
            $pic_not_resule = " <img src='".ROOT_ADDRESS_WITHOUT_LANG."/view/" . FOLDER_CLIENT . "/assets/images/fullCapacity.png' alt='fullCapacity'>";
        }
//        echo $pic_not_resule;
//        die;
        $output['result_status']=$pic_not_resule;
        $output['result_message']=functions::Xmlinformation('NotResultForSearch');
    }
    echo json_encode($output);
}elseif(isset($_POST['flag']) && $_POST['flag']=='insert_Gallery'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo $edit->InsertGallery($_POST);

}elseif(isset($_POST['flag']) && $_POST['flag']=='RemoveSingleGallery'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo $edit->RemoveSingleGallery($_POST);

}elseif(isset($_POST['flag']) && $_POST['flag']=='getEntertainmentCountries'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    $filter = true;
    if(isset($_POST['filter']) && ($_POST['filter'] == 'false' || $_POST['filter'] == false))
    {
        $filter = false;
    }
    echo json_encode($edit->getCountries($filter));


}
elseif(isset($_POST['flag']) && $_POST['flag']=='getEntertainmentCurrency'){


    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo json_encode($edit->getCurrency());

}
elseif(isset($_POST['flag']) && $_POST['flag']=='getCategories'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo json_encode($edit->getCategories($_POST));


}elseif(isset($_POST['flag']) && $_POST['flag']=='getSubCategories'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo json_encode($edit->getSubCategories($_POST));


}elseif(isset($_POST['flag']) && $_POST['flag']=='getEntertainmentCities'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo json_encode($edit->getCities($_POST));


}elseif(isset($_POST['flag']) && $_POST['flag']=='GetEntertainmentGalleryData'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo $edit->GetEntertainmentGalleryData($_POST);

}elseif(isset($_POST['flag']) && $_POST['flag']=='PreReserve'){
    $edit=Load::controller('entertainment');
//    var_dump($_POST);
//    die;
    unset($_POST['flag']);
    echo $edit->PreReserveEntertainment($_POST);

}elseif(isset($_POST['flag']) && $_POST['flag']=='PreRequest'){
//var_dump($_POST);
//die;
    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo $edit->PreRequestEntertainment($_POST);

}elseif(isset($_POST['flag']) && $_POST['flag']=='preReserveEntertainment'){
    unset($_POST['flag']);

    $Model=Load::library('Model');
    $ModelBase=Load::library('ModelBase');

    $data['successfull']='TemporaryPreReserve';
    $data['creation_date_int']=time();

    $Condition=" factor_number ='{$_POST['factorNumber']}' ";
    $Model->setTable("book_entertainment_tb");
    $res2[]=$Model->update($data, $Condition);

    $ModelBase->setTable("report_entertainment_tb");
    $res2[]=$ModelBase->update($data, $Condition);

    if(in_array('0', $res2)){
        echo 'error:'.functions::Xmlinformation('ErrorUnknownBuyHotel');
    }else{
        echo 'success';
    }


}elseif(isset($_POST['flag']) && $_POST['flag']=='checkUserLogin'){
    unset($_POST['flag']);

    $resultLogin=Session::IsLogin();
    $resultTypeLogin=Session::getTypeUser();

    if($resultLogin && $resultTypeLogin=='counter'){
        $return['result_status']='success';
    }else{
        $return['result_status']='error';
    }

    echo json_encode($return);
}elseif(isset($_POST['flag']) && $_POST['flag']=='categoryList'){

    $edit=Load::controller('entertainment');

    unset($_POST['flag']);
    if(isset($_POST['parent_id'])){
        $parent_id=$_POST['parent_id'];
    }else{
        $parent_id=null;
    }
    if(isset($_POST['id'])){
        $id=$_POST['id'];
    }else{
        $id=null;
    }
    if(isset($_POST['dataTable'])){
        $dataTable=$_POST['dataTable'];
    }else{
        $dataTable=null;
    }



    echo json_encode($edit->GetData($parent_id,$id,$dataTable));
}
elseif(isset($_POST['flag']) && $_POST['flag']=='entertainmentList'){
    $edit=Load::controller('entertainment');

    unset($_POST['flag']);
    if(isset($_POST['category_id'])){
        $category_id=$_POST['category_id'];
    }else{
        $category_id=null;
    }
    if(isset($_POST['id'])){
        $id=$_POST['id'];
    }else{
        $id=null;
    }
    if(isset($_POST['dataTable'])){
        $dataTable=$_POST['dataTable'];
    }else{
        $dataTable=null;
    }

    if($edit->GetEntertainmentGdsData($category_id,$id,$dataTable)){
        echo json_encode($edit->GetEntertainmentGdsData($category_id,$id,$dataTable));
    }else{
        echo json_encode(['data'=>[],'total'=>0,'recordsTotal'=>0,'recordsFiltered'=>0,]);
    }
}elseif(isset($_POST['flag']) && $_POST['flag']=='editEntertainmentCategory'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo $edit->editEntertainmentCategory($_POST);

}elseif(isset($_POST['flag']) && $_POST['flag']=='newEntertainmentCategory'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo $edit->newEntertainmentCategory($_POST);

}elseif(isset($_POST['flag']) && $_POST['flag']=='validateEntertainmentCategory'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo $edit->validateEntertainmentCategory($_POST);

}elseif(isset($_POST['flag']) && $_POST['flag']=='validateEntertainment'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo $edit->validateEntertainment($_POST);

}elseif(isset($_POST['flag']) && $_POST['flag']=='getEntertainmentTypes'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo json_encode($edit->GetTypes($_POST));

}elseif(isset($_POST['flag']) && $_POST['flag']=='manageAcceptEntertainment'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo $edit->manageAcceptEntertainment($_POST);

}elseif(isset($_POST['flag']) && $_POST['flag']=='changeCategoryApproval'){

    $edit=Load::controller('entertainment');
    unset($_POST['flag']);
    echo $edit->changeCategoryApproval($_POST['id']);

}
