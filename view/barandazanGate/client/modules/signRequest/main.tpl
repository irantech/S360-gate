{load_presentation_object filename="uploadFiles" assign="objFile"}
{assign var="info_file" value=$objFile->getFile(17)}
<div class="sign">
    <div class="container">
        <h2 class="titr-sign">
            درخواست ساین
        </h2>
        <div class="parent-sign">

            <div class="box-sign-download">
                <div class="level">
                    <span>مرحله </span>
                    <span>اول</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 24 24" version="1.1">
                    <title>Download</title>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Download">
                            <rect id="Rectangle" fill-rule="nonzero" x="0" y="0" width="24" height="24">

                            </rect>
                            <line x1="12" y1="10" x2="12" y2="19" id="Path" stroke="#0C0310" stroke-width="2" stroke-linecap="round">

                            </line>
                            <path d="M15,18 L12.7071,20.2929 C12.3166,20.6834 11.6834,20.6834 11.2929,20.2929 L9,18" id="Path" stroke="#0C0310" stroke-width="2" stroke-linecap="round">

                            </path>
                            <path d="M8,15 L6,15 C4.34315,15 3,13.6569 3,12 C3,10.3431 4.34315,9 6,9 C6,5.68629 8.68629,3 12,3 C15.3137,3 18,5.68629 18,9 C19.6569,9 21,10.3431 21,12 C21,13.6569 19.6569,15 18,15 L16,15" id="Path" stroke="#0C0310" stroke-width="2" stroke-linecap="round">

                            </path>
                        </g>
                    </g>
                </svg>
                <p>جهت ارسال درخواست ساین ابتدا فایل زیر را دریافت و تکمیل نمایید. </p>
                <a class="btn-sign" href="{$info_file['file']}" target="_blank">
                    دانلود فایل
                </a>
            </div>

            <div class="box-sign-upload">
                <div class="level">
                    <span>مرحله </span>
                    <span>دوم</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 24 24" version="1.1">
                    <title>Upload-1</title>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Upload-1">
                            <rect id="Rectangle" fill-rule="nonzero" x="0" y="0" width="24" height="24">

                            </rect>
                            <line x1="12" y1="11" x2="12" y2="20" id="Path" stroke="#0C0310" stroke-width="2" stroke-linecap="round">

                            </line>
                            <path d="M15,13 L12.7071,10.7071 C12.3166,10.3166 11.6834,10.3166 11.2929,10.7071 L9,13" id="Path" stroke="#0C0310" stroke-width="2" stroke-linecap="round">

                            </path>
                            <path d="M8,16 L6,16 C4.34315,16 3,14.6569 3,13 C3,11.3431 4.34315,10 6,10 C6,6.68629 8.68629,4 12,4 C15.3137,4 18,6.68629 18,10 C19.6569,10 21,11.3431 21,13 C21,14.6569 19.6569,16 18,16 L16,16" id="Path" stroke="#0C0310" stroke-width="2" stroke-linecap="round">

                            </path>
                        </g>
                    </g>
                </svg>

                <p>حال با زدن گزینه ارسال درخواست اطلاعات مورد نیاز را وارد کرده و فایل را برای ما ارسال فرمایید.</p>
                <a class="btn-sign" href="{$smarty.const.ROOT_ADDRESS}/registerAgency">ورود اطلاعات</a>

            </div>
        </div>
    </div>
</div>
