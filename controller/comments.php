<?php

/**
 * Class Comments
 * @property comments $Comments
 */

//if(  $_SERVER['REMOTE_ADDR']=='5.201.144.255'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//   @ini_set('display_errors', 1);
//   @ini_set('display_errors', 'on');
//}

class comments extends clientAuth
{

    public function __construct() {
        parent::__construct();
    }


    public function EditCommentValidate($input) {

        $Model = Load::library('Model');
        $dataUpdate['validate'] = $input['validate'];

        $condition = " id = '{$input['id']}' ";
        $Model->setTable('comment_tb');
        $resultUpdate = $Model->update($dataUpdate, $condition);

        if ($resultUpdate) {
            return 'success : تغغیرات با موفقیت انجام شد ';
        } else {
            return 'error : خطا در  تغییرات';
        }
    }

    public function getComments($section, $itemId, $adminSide = false) {
        $Model = Load::library('Model');
        $section = filter_var($section, FILTER_SANITIZE_STRING);

        if ($adminSide) {
            $query = "SELECT * FROM comment_tb WHERE `section` = '{$section}' ORDER BY `id` DESC";
        } else {
            $query = "SELECT * FROM comment_tb WHERE `section` = '{$section}' AND `item_id` = '{$itemId}' AND `parent_id` = '0' AND `validate`='1' ORDER BY `id` DESC";
        }
        return $Model->select($query);
    }

    public function findcommentByParentId($id) {
        return $this->getModel('commentModel')->get()->where('id', $id)->find();
    }

    public function findcommentsNotConfirmByParentId($parentId) {
//        return $this->getModel('commentModel')->get()->where('parent_id', $parentId)->find();
        $model_comment = $this->getModel('commentModel')->get()->where('parent_id' , $parentId)->where('validate' , 0);
        $result = $model_comment->all();
        $count = count($result);
        return $count;
    }

    public function getAllComments($section, $item_id = null, $parent_id = 0, $is_admin = false, $base_list = 0) {
        $article_controller = $this->getController('articles');
        $comment_model = $this->getModel('commentModel');
        $comment_table = $comment_model->getTable();
        $comments = $comment_model->get([
            $comment_table . '.*',
        ], true)
            ->where($comment_table . '.deleted_at', null, 'IS')
            ->where($comment_table . '.parent_id', $parent_id)
            ->where($comment_table . '.section', $section);
        if ($item_id) {
            $comments = $comments
                ->where($comment_table . '.item_id', $item_id);
        }
        if (!$is_admin) {
            $comments = $comments
                ->where($comment_table . '.validate', '1');
        }
        $comments = $comments
            ->orderBy($comment_table . '.created_at', 'desc')
            ->all(false);

        $result = [];


        foreach ($comments as $key => $comment) {
            $result[$key] = $comment;

            if ($is_admin) {
                if ($section == 'mag') {

                    $article_controller->setSection('mag');
                    $article = $article_controller->getArticle($comment['item_id']);
                    $result[$key]['item_title'] = $article['title'];
//                    $result[$key]['item_link'] = $article['link'] . '#comment-item-' . $comment['id'];
                    $result[$key]['item_link'] = $article['link'];

                } elseif ($section == 'news') {
                    $article_controller->setSection('news');
                    $article = $article_controller->getArticle($comment['item_id']);
                    $result[$key]['item_title'] = $article['title'];
//                    $result[$key]['item_link'] = $article['link'] . '#comment-item-' . $comment['id'];
                    $result[$key]['item_link'] = $article['link'];
                } elseif ($section == 'tour') {
                    $Model = Load::library('Model');
                    $sql = "SELECT
                
                    T.* 
                FROM
                    reservation_tour_tb as T
                WHERE
                    T.id_same = '{$comment['item_id']}'
                 
                    ORDER BY id ASC LIMIT 0,1 ";
                    $tour = $Model->load($sql);
                    $result[$key]['item_title'] = $tour['tour_name'];

//                    $result[$key]['item_link'] = $tour['link'] . '#comment-item-' . $comment['id'];
                    $result[$key]['item_link'] = ROOT_ADDRESS_WITHOUT_LANG . '/' . SOFTWARE_LANG . '/detailTour/' . $tour['id'] . '/' . $tour['tour_name_en'];
                }
            }

            $result[$key]['created_at_fa'] = functions::ConvertToJalali($comment['created_at']) . ' <br>' . substr($comment['created_at'], 11);
            $result[$key]['created_at_fa_without_time'] = functions::ConvertToJalali($comment['created_at']) . ' <br>' . substr($comment['created_at'], 11);
            if ($base_list == 0){
                $result[$key]['replays'] = $this->getAllComments($section, $item_id, $comment['id'], $is_admin);
               }

            $check_exist_comment = $this->findcommentByParentId($comment['parent_id']);
            $check_exist_comment_not_confirm = $this->findcommentsNotConfirmByParentId($comment['id']);
            $result[$key]['text_under'] = $check_exist_comment['text'];
            $result[$key]['count_under_not_confirm'] = $check_exist_comment_not_confirm;

        }

        return $result;
    }

    public function getCommentsCount($section, $item_id) {
        $comment_model = $this->getModel('commentModel');
        $comment_table = $comment_model->getTable();


        return $comment_model->get([
            'count(id) as comments_count',
        ], true)
            ->where($comment_table . '.deleted_at', null, 'IS')
            ->where($comment_table . '.item_id', $item_id)
            ->where($comment_table . '.section', $section)
            ->find(false);
    }

    //region getOneComment
    public function getOneComment($input) {
        $Model = Load::library('Model');
        $commentId = filter_var($input['commentId'], FILTER_SANITIZE_STRING);

        $query = "SELECT * FROM comment_tb WHERE `id` = '{$commentId}'";
        return $Model->load($query);
    }


    public function editComment($params) {

        $comment_model = $this->getModel('commentModel');

        $comment_id = filter_var($params['comment_id'], FILTER_SANITIZE_NUMBER_INT);

        $body = filter_var($params['comment_body'], FILTER_SANITIZE_STRING);


        if (!$comment_id || $body == '') {
            return functions::withError('', 400, 'متن نظر نمی‌تواند خالی باشد');
        }

        $comment = $comment_model->get()->where('id', $comment_id)->find();
        if (!$comment) {
            return functions::withError('', 404, 'نظر مورد نظر یافت نشد');
        }

        $updateData = [
            'text' => $body,
        ];
        try {
            $condition = "id='{$comment_id}'";
            $result = $comment_model->updateWithBind($updateData, $condition);
            return functions::JsonSuccess($result, [
                'title' => 'ویرایش نظر',
                'message' => 'ویرایش نظر با موفقیت انجام شد',
            ], 200);
        }catch (\mysql_xdevapi\Exception $e){
            return functions::withError('', 500, 'خطا در ویرایش نظر');
        }

    }

    public function deleteComment($params) {
        $comment_model = $this->getModel('commentModel');

        $comment_id = filter_var($params['comment_id'], FILTER_SANITIZE_NUMBER_INT);

        if (!$comment_id) {
            return functions::withError('', 400, 'شناسه نظر معتبر نیست');
        }

        $comment = $comment_model->get()->where('id', $comment_id)->find();
        if (!$comment) {
            return functions::withError('', 404, 'نظر مورد نظر یافت نشد');
        }

        $updateData = [
            'deleted_at' => date('Y-m-d H:i:s'), // تاریخ و زمان فعلی
        ];

        try {
            $condition = "id='{$comment_id}'";
            $result = $comment_model->updateWithBind($updateData, $condition);

            if ($result) {
                return functions::JsonSuccess($result, [
                    'title' => 'حذف نظر',
                    'message' => 'نظر با موفقیت حذف شد',
                ], 200);
            } else {
                return functions::withError('', 500, 'خطا در حذف نظر');
            }
        } catch (\Exception $e) {
            return functions::withError('', 500, 'خطا در حذف نظر: ' . $e->getMessage());
        }
    }



    //endregion


    public function getCommentsReply($section, $itemId, $parentId) {
        $Model = Load::library('Model');
        $section = filter_var($section, FILTER_SANITIZE_STRING);

        $query = "SELECT * FROM comment_tb WHERE `section` = '{$section}' AND `item_id` = '{$itemId}' AND `parent_id` = '{$parentId}' AND `validate`='1' ORDER BY `id` DESC";
        return $Model->select($query);
    }

    public function newComment($params) {
        $comment_model = $this->getModel('commentModel');
        $user_data = $this->getUserData($params);

        $name = filter_var($user_data['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($user_data['email'], FILTER_SANITIZE_STRING);
        $mobile = filter_var($user_data['mobile'], FILTER_SANITIZE_STRING);
        $body = filter_var($params['comment_body'], FILTER_SANITIZE_STRING);
        $user_id = filter_var($user_data['user_id'], FILTER_SANITIZE_NUMBER_INT);
        $item_id = filter_var($params['item_id'], FILTER_SANITIZE_NUMBER_INT);
        $parent_id = filter_var($params['parent_id'], FILTER_SANITIZE_NUMBER_INT);
        $section = filter_var($params['section'], FILTER_SANITIZE_STRING);
        $validate = $user_data['validate'];
        if ($body != '') {
            $insert_result = $comment_model->insertWithBind([
                'user_id' => $user_id,
                'item_id' => $item_id,
                'parent_id' => $parent_id,
                'section' => $section,
                'name' => $name,
                'email' => $email,
                'mobile' => $mobile,
                'text' => $body,
                'validate' => $validate,
            ]);
            if ($insert_result) {

                return functions::JsonSuccess($insert_result, [
                    'title' => functions::Xmlinformation('WeAreGratefulForComment')->__toString(),
                    'message' => functions::Xmlinformation('YourcommenthasbeenregisteredThankyou')->__toString(),
                    'data' => $insert_result
                ], 200);
            }
        }
        else {
            return functions::JsonSuccess('', [
                'title' => functions::Xmlinformation('Errorrecordinginformation')->__toString(),
                'message' => functions::Xmlinformation('NoUserFoundWithThisProfile')->__toString(),

            ], 200);
        }

    }

    private function getUserData($params) {
        if (Session::IsLogin()) {
            Load::library('Session');
            $user_id = Session::getUserId();
            $user_info = functions::infoMember($user_id);
            $data['user_id'] = $user_id;
            $data['name'] = $user_info['name'] . ' ' . $user_info['family'];
            $data['email'] = $user_info['email'];
            $data['mobile'] = $user_info['mobile'];
            $data['validate']=0;
        } else {
            $data['user_id'] = 0;
            if (Session::adminIsLogin()) {
                $data['name'] = CLIENT_NAME;
                $data['email'] = CLIENT_EMAIL;
                $data['mobile'] = CLIENT_MOBILE;
                $data['validate']=1;
            } else {
                $data['name'] = $params['comment_name'];
                $data['email'] = $params['comment_email'];
                $data['mobile'] = $params['comment_mobile'];
                $data['validate']=0;
            }
        }
        return $data;
    }

    public function insertComment($input) {


        if (Session::IsLogin()) {
            Load::library('Session');
            $UserId = Session::getUserId();
            $UserInfo = functions::infoMember($UserId);
            $CommentInfo['user_id'] = $UserId;
            $CommentInfo['name'] = $UserInfo['name'] . ' ' . $UserInfo['family'];
            $CommentInfo['email'] = $UserInfo['email'];
        } else {
            $CommentInfo['user_id'] = '';
            $CommentInfo['name'] = $input['name'] . ' ' . $input['family'];
            $CommentInfo['email'] = $input['email'];
        }

        $CommentInfo['item_id'] = filter_var($input['tour_id'], FILTER_SANITIZE_NUMBER_INT);
        $CommentInfo['parent_id'] = filter_var($input['parent_id'], FILTER_SANITIZE_NUMBER_INT);
        $CommentInfo['section'] = filter_var($input['section'], FILTER_SANITIZE_STRING);

        $CommentInfo['text'] = filter_var($input['text'], FILTER_SANITIZE_STRING);
        $CommentInfo['validate'] = 0;
        $CommentInfo['created_at'] = time();

        $Model = Load::library('Model');

        $Model->setTable('comment_tb');
        $resultInsert = $Model->insertLocal($CommentInfo);

        if ($resultInsert) {
            $output['result_status'] = 'success';
            $output['result_message'] = 'نظر شما ثبت شد و پس از بررسی پاسخ داده خواهد شد.';
        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطایی در ثبت نظر رخ داده است لطفا دوباره تلاش کنید یا در صورت تکرر با پشتیبانی تماس حاصل فرمایید.';
        }

        return $output;
    }

    public function getByCommentMainPage($data_main_page = []) {
        $comment_model = $this->getModel('commentModel')->get();
        $comment_table = $comment_model->getTable();

        // شرط‌های پایه
        $comment_model->where($comment_table . '.validate', 1)
            ->where($comment_table . '.parent_id', 0)
            ->where($comment_table . '.show_main', 1)
            ->orderBy($comment_table . '.orders', 'ASC');

        // تنظیم limit با offset صریح
        $limit = isset($data_main_page['limit']) && !empty($data_main_page['limit'])
            ? intval($data_main_page['limit'])
            : 10;

        $comment_model->limit(0, $limit);

        $listComment = $comment_model->all(false);
        return $listComment;
    }




    public function changeShowCommentManiPage($data_update) {

        $check_exist_comment = $this->findcommentByParentId($data_update['id']);
        if ($check_exist_comment) {
            $data_update_status['show_main'] = ($check_exist_comment['show_main'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_comment['id']}'";
            $result_update_comment = $this->getModel('commentModel')->updateWithBind($data_update_status,$condition_update_status);

            if ($result_update_comment) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت نمایش نظر در صفحه اصلی  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت نمایش نظر در صفحه اصلی ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }



    public function changeCommentMainOrder($data_update) {


        try {
            $check_exist_comment = $this->findcommentByParentId($data_update['id']);
            if ($check_exist_comment) {
                $data_update_order['orders'] = intval($data_update['order']); // اضافه کردن backtick
                $condition_update_order = "id='{$check_exist_comment['id']}'";

                $result_update_order = $this->getModel('commentModel')->updateWithBind($data_update_order, $condition_update_order);

                if ($result_update_order) {
                    return functions::withSuccess('', 200, 'ترتیب نمایش نظر با موفقیت تغییر یافت');
                }
                return functions::withError('', 400, 'خطا در تغییر ترتیب نمایش نظر');
            }
            return functions::withError('', 404, 'نظر مورد نظر یافت نشد');
        } catch (Exception $e) {
            return functions::withError('', 500, 'خطای سرور: ' . $e->getMessage());
        }
    }


    


}

?>
