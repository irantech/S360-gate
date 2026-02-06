{load_presentation_object filename="lottery" assign="objLotteries"}
{assign var="lottery" value=$objLotteries->getLottery($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/lottery/list?section={$lottery['section']}">
                        لیست قرعه کشی ها
                    </a>
                </li>
                <li class='active'>
                    ویرایش گالری
                    <span class='font-bold underdash'>{$lottery['title']}</span>
                </li>
            </ol>
        </div>


    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box col-md-12">
                <h3 class="box-title m-b-0"> اضافه کردن عکس برای قرعه کشی</h3>

                <p class="text-muted m-b-30 textPriceChange">
                </p>

                <div class="col-md-12">
                    <div id="actions" class="col-sm-12  p-0">
                        <!-- HTML heavily inspired by https://blueimp.github.io/jQuery-File-Upload/ -->
                        <div class="col-lg-7 p-0">


                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-success fileinput-button dz-clickable"><i
                                            class="fa fa-plus"></i>اضافه کردن فایل
                                </button>
                                <button data-dz-remove type="submit" class="btn btn-primary start"><i
                                            class="fa fa-upload"></i> شروع آپلود
                                </button>
                                <button type="reset" class="btn btn-warning cancel">لغو آپلود</button>
                            </div>


                        </div>

                        <div class="col-lg-5">
                            <!-- The global file processing state -->
                            <span class="fileupload-process">
                                <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0"
                                     aria-valuemax="100" aria-valuenow="0">
                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
                                </div>
                            </span>

                        </div>
                    </div>
                    <div class="table table-striped files" id="previews">
                        <div id="template" class="file-row dz-image-preview">
                            <!-- This is used as the file preview template -->
                            <div>
                                <span class="preview"><img data-dz-thumbnail></span>
                            </div>
                            <div>
                                <p class="name" data-dz-name></p>
                                <strong class="error text-danger" data-dz-errormessage></strong>
                            </div>
                            <div>
                                <p class="size" data-dz-size></p>
                                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0"
                                     aria-valuemax="100" aria-valuenow="0">
                                    <div class="progress-bar progress-bar-success" style="width:0%;"
                                         data-dz-uploadprogress></div>
                                </div>
                            </div>
                            <div class="btn-actions">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary start"><i class="fa fa-upload"></i>
                                        آپلود
                                    </button>
                                    <button data-dz-remove type="button" class="btn btn-warning cancel"><i
                                                class="fa fa-ban"></i> لغو
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>


            </div>

        </div>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <p class="text-muted m-b-30">
                </p>
                <div class="table-responsive">
                    <table class="table table-hover GalleryTable">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">عکس</th>
                            <th scope="col">عملیات</th>
                        </tr>
                        </thead>
                        <tbody id="AllArticleGallery">


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="assets/js/blog-jquery-dropzone.js"></script>

<script type="text/javascript">
  myDropzone.on('sending', function(file, xhr, formData) {

    formData.append('method', 'addToGallery')
    formData.append('className', 'lottery')
    formData.append('id', "{$lottery['id']}")
  })
  myDropzone.on('success', function(file, response) {
     GetLotteryGalleryData("{$lottery['id']}")

  })
  $(document).ready(function() {
     GetLotteryGalleryData("{$lottery['id']}")
  })
</script>
<script type="text/javascript" src="assets/JsFiles/lottery.js"></script>