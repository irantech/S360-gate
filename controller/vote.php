<?php

class vote extends clientAuth {
    /**
     * @var string
     */
    protected $table = 'vote_tb';
    private $voteTb,$voteQuestionTb,$page_limit;
    /**
     * @var string
     */

    public function __construct() {
        parent::__construct();
        $this->page_limit = 6;
        $this->voteTb = 'vote_tb';
        $this->voteQuestionTb = 'vote_question_tb';
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        $return = json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $return;
    }
    public function addVoteIndexes(array $voteList) {
        $result = [];

        foreach ($voteList as $key => $vote) {

            $result[$key] = $vote;
            $time_date = functions::ConvertToDateJalaliInt($vote['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['tiny_title'] = strip_tags(substr_replace($vote['title'], "...", 250));
            $result[$key]['is_active'] = "{$vote['is_active']}";

        }

        return $result;
    }
    public function insertVote($params) {
        $dataVote = [
            'title' => $params['title'],
            'created_at' => date('Y-m-d H:i:s', time()),
            'language' => $params['language'],
            'is_active' => 1,
        ];
          $vote_model = Load::getModel('voteModel');
          $insert_vote =  $this->getModel('voteModel')->insertWithBind($dataVote);
          if ($insert_vote) {
              $last_vote_id = $vote_model->getLastId();
              if(isset($params['vote_item']) && is_array($params['vote_item'])){
                  $array_vote_item=array();
                  foreach(@$params['vote_item'] as $k => $v){
                      foreach($v as $k1 => $v1){
                          if ($v1 != '') {
                              $array_vote_item[$k1][$k] = $v1;
                          }
                      }
                  }
                  foreach($array_vote_item as $key=> $value){
                      $dataInsertQuestion = [
                          'vote_id' => $last_vote_id,
                          'title' => $value['question']
                      ];


                      $this->getModel('voteQuestionModel')->insertWithBind($dataInsertQuestion);
                  }
              }
              return $this->returnJson(true, 'ثبت پرسش با موفقیت انجام شد', $insert_vote);
          }
        return $this->returnJson(false, 'خطا در فرایند ثبت پرسش');
    }

    public function listVote($data = []) {
        $result = [];
        $voteList = $this->getModel('voteModel')->get();
        $vote_table = $voteList->getTable();
        if (!isset($data_main_page['order']) || empty($data_main_page['order'])) {
            $data_main_page['order'] = 'ASC';
        }
        if (isset($data['is_active'] )) {
            $voteList
                ->where($vote_table . '.is_active', 1)
                ->where($vote_table . '.language', SOFTWARE_LANG)
                ->orderBy('orders' , $data_main_page['order']);
        }
        $listVote = $voteList->all();
        $result = $this->addVoteIndexes($listVote);
        return $result;
    }
    public function findVoteById($id) {
        return $this->getModel('voteModel')->get()->where('id', $id)->find();
    }
    public function updateStatusVote($params) {
        $check_exist_vote = $this->findVoteById($params['id']);
        if ($check_exist_vote) {
            $data_update['is_active'] = ($check_exist_vote['is_active'] == 1) ? 0 : 1;
            $data ="id='{$check_exist_vote['id']}'";
            $result_update_vote = $this->getModel('voteModel')->updateWithBind($data_update,$data);

            if ($result_update_vote) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت پرسش  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت پرسش ');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }


    public function deleteVote($data_update) {
        $check_exist_vote = $this->findVoteById($data_update['id']);
        if ($check_exist_vote) {
            $result_update_vote = $this->getModel('voteModel')->delete("id='{$data_update['id']}'");
            if ($result_update_vote) {
                return functions::withSuccess('', 200, 'حذف پرسش با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف جدبد');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }


    public function changeOrder($params){
        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $model = $this->getModel('voteModel');
                $dataUpdate = [
                    'orders' => $v
                ];
                $model->updateWithBind($dataUpdate, ['id' => $k]);
            }
            return self::returnJson(true, 'درخواست شما با موفقیت انجام شد');
        }else {
            return self::returnJson(true, 'هیچ موردی انتخاب نشده یا تغییری اعمال نشده است');
        }
    }

    public function getVote($id) {
        $vote_model = $this->getModel('voteModel');
        $vote_table = $vote_model->getTable();
        $vote = $vote_model->get([
            $vote_table.'.*',
        ] ,true)
            ->where($vote_table . '.id' , $id)
            ->find(false);
        return $this->addVoteIndexes([$vote])[0];
    }

    public function getQuestion($questionId) {
        $question_model = $this->getModel('voteQuestionModel');
        $question_table = $question_model->getTable();
        $question = $question_model->get([
            $question_table.'.*',
        ] ,true)
            ->where($question_table . '.id' , $questionId)
            ->find(false);
        return $question;
    }

    public function getQuestionItem($voteId){
        $question_item_model = $this->getModel('voteQuestionModel')->get()->where('vote_id', $voteId);
        $result =  $question_item_model->all();
        return $result;
    }

    public function updateVote($params) {
        if(empty($_POST['title'])) {
            return self::returnJson(true, 'لطفا عنوان سوال را وارد نمایید');
            die();
        }
        $request_model = $this->getModel('voteModel');
        $dataUpdate = [
            'title' => $params['title'],
            'language' => $params['language'],
        ];

        $request_model->updateWithBind($dataUpdate, ['id' => $_POST['id']]);
        $this->getModel('voteQuestionModel')->delete("vote_id='{$_POST['id']}' AND count_answer=0 ");

        $vote_id = $_POST['id'];
        if(isset($params['vote_item']) && is_array($params['vote_item'])){
            $array_vote_item=array();
            foreach($params['vote_item'] as $k => $v){
                foreach($v as $k1 => $v1){
                    if ($v1 != '') {
                        $array_vote_item[$k1][$k] = $v1;
                    }
                }
            }
            foreach($array_vote_item as $key=> $value){
                    $dataInsertQuestion = [
                        'vote_id' => $vote_id,
                        'title' => $value['question'],
                    ];
                $insert_vote =  $this->getModel('voteQuestionModel')->insertWithBind($dataInsertQuestion);
            }
        }
        return $this->returnJson(true, 'ثبت پرسش با موفقیت انجام شد', $insert_vote);

    }

    public function answerVote($params) {

        if (isset($_POST['answer'])) {
            foreach ($_POST['answer'] as $k => $v) {
                $data_insert = [
                    'vote_id' => $k,
                    'question_id' => $v,
                    'reason' => $_POST['reason_'.$k],
                ];
                $temp_model = Load::getModel('voteAnswerModel');
               $insert_answer = $temp_model->insertWithBind($data_insert);
            }
            return $this->returnJson(true, 'ز اینکه در نظرسنجی شرکت نمودید از شما سپاسگزاریم', $insert_answer);

        }
    }
    public function countAnswerList($questionId = null) {

        $question_item_model = $this->getModel('voteAnswerModel')->get()->where('question_id', $questionId);
        $result =  $question_item_model->all();
        $count = count($result);
        return $count;
    }
    public function countAnswerListAll($voteId =null) {

        $question_item_model = $this->getModel('voteAnswerModel')->get()->where('vote_id', $voteId);
        $result =  $question_item_model->all();
        $count = count($result);
        return $count;
    }
    public function listReasonItem($answerId) {
        $reasonList = $this->getModel('voteAnswerModel')->get()->where('question_id', $answerId);
        $reason_table = $reasonList->getTable();
        $result = $reasonList->all();
        return $result;
    }



    public function answerVoteUser_old($params) {

        if (isset($_POST['answer'])) {
            foreach ($_POST['answer'] as $k => $v) {
                $data_insert = [
                    'vote_id' => $k,
                    'question_id' => $v,
                    'reason' => $_POST['reason_'.$k],
                ];
                $temp_model = Load::getModel('voteAnswerModel');
                $insert_answer = $temp_model->insertWithBind($data_insert);
                $this->getModel('voteQuestionModel')->updateWithBind(['count_answer' =>  1], ['id' => $v]);

            }
            return $this->returnJson(true, 'ز اینکه در نظرسنجی شرکت نمودید از شما سپاسگزاریم', $insert_answer);

        }
    }

    public function answerVoteUser($params) {

        if (!isset($_POST['answer'])) {
            return "error : حداقل به یک مورد پاسخ داده شود ";
        }
        if (isset($_POST['answer'])) {
            foreach ($_POST['answer'] as $k => $v) {
                $data_insert = [
                    'vote_id' => $k,
                    'question_id' => $v,
                    'reason' => $_POST['reason_'.$k],
                ];
                $temp_model = Load::getModel('voteAnswerModel');
                $insert_answer = $temp_model->insertWithBind($data_insert);
                $this->getModel('voteQuestionModel')->updateWithBind(['count_answer' =>  1], ['id' => $v]);
            }
            return "success : از اینکه با شرکت در این نظرسنجی ما را در ارائه خدمات بهتر یاری نمودید متشکریم. ";

        }
    }

}


