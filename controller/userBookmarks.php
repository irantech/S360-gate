<?php

class userBookmarks extends clientAuth
{
    public $bookmarks = array();
    public $total_bookmarks = 0;


    public function __construct()
    {
        parent::__construct();
        $this->loadBookmarks();
    }

    private function loadBookmarks()
    {
        $clientId = CLIENT_ID;
        $model = $this->getModel('userBookmarksModel');

        $bookmarksArray = $model->get(array("id", "title", "url", "sort_order"))
            ->where('client_id', $clientId)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->all();

        $this->bookmarks = $bookmarksArray ?: array();
        $this->total_bookmarks = count($this->bookmarks);
    }

    public function addBookmark($title, $url)
    {

        if (empty($title) || empty($url)) {
            return array('success' => false, 'message' => 'عنوان و لینک الزامی است');
        }

        // اعتبارسنجی URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return array('success' => false, 'message' => 'لینک وارد شده معتبر نیست');
        }

        $clientId = CLIENT_ID;
        $model = $this->getModel('userBookmarksModel');

        $data = array(
            'client_id' => $clientId,
            'title' => "$title",
            'url' => "$url",
            'sort_order' => $this->total_bookmarks
        );



        $result = $model->insertWithBind($data);


        if ($result) {
            $this->loadBookmarks(); // رفرش لیست
            return array('success' => true, 'message' => 'بوکمارک با موفقیت اضافه شد');
        }


    }

    public function deleteBookmark($bookmarkId)
    {
        $clientId = CLIENT_ID;
        $model = $this->getModel('userBookmarksModel');
        $condition = "id = '{$bookmarkId}' AND client_id='$clientId'";
        $result = $model->delete($condition);


        if ($result) {
            $this->loadBookmarks();
            return array('success' => true, 'message' => 'بوکمارک حذف شد');
        }

        return array('success' => false, 'message' => 'خطا در حذف');
    }

    public function updateOrder($bookmarkIds)
    {
        if (!is_array($bookmarkIds)) {
            return array('success' => false, 'message' => 'داده نامعتبر');
        }

        $clientId = CLIENT_ID;
        $model = $this->getModel('userBookmarksModel');

        foreach ($bookmarkIds as $index => $id) {
            $model->update(array('sort_order' => $index))
                ->where('id', $id)
                ->where('client_id', $clientId)
                ->execute();
        }

        $this->loadBookmarks();
        return array('success' => true, 'message' => 'ترتیب به‌روز شد');
    }

    public function getBookmarks()
    {
        return $this->bookmarks;
    }
}