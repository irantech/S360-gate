{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<section class="i_modular_menu gym" id="gym-box">
    <div class="container">
        <div class="parent-gym">
            <div class="gym-text">
                <h3>باشگاه همسفران گلهای سفر</h3>
                <p>به باشگاه گلهای سفر خوش آمدید، جایی که همه ی سفرها به یاد ماندنی می شوند. اینجا مکانی است برای

                    شما که در ماجراجویی های خود، گلهای سفر را انتخاب کرده اید.</p>
                <p>در این باشگاه منحصر به فرد، خدمات و امکاناتی وجود دارند که تجربه ی سفرهای با گلهای سفر را به اوج

                    می رسانند.

                    شما به عنوان یک همسفر ویژه، بازیگر اصلی این ماجرا هستید. به ما بپیوندید و با گلهای سفر، به

                    دنیایی

                    از لذت و هیجان خوش آمد بگویید که هیچگاه از خاطراتتان محو نخواهد شد.</p>
                <div class="parent-btn-gym">
                    {if $obj_main_page->isLogin()}
                    <a href="{$smarty.const.ROOT_ADDRESS}/profile">ورود به پنل کاربری</a>
                    {else}
                        <a href="{$smarty.const.ROOT_ADDRESS}/authenticate">ورود</a>
                        <a  href="{$smarty.const.ROOT_ADDRESS}/authenticate">ثبت
                        نام</a>
                    {/if}
                </div>
            </div>
            <div class="gym-img">
                <img alt="img-clup" src="project_files/images/clup.png" />
            </div>
        </div>
    </div>
</section>