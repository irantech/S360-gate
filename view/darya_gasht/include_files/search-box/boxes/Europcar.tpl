<div class="tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Europcar">
    <div class="col-md-12 col-12">
        <div class="row">
            <form data-action="/" method="post" target="_blank" class="d_contents"
                  name="cartype_rentCar_js" id="cartype_rentCar_js">
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                    <div class="form-group"><select data-placeholder="  نوع ماشین"
                                                    name="cartype_rentCar" id="cartype_rentCar"
                                                    class="select2  select2-hidden-accessible"
                                                    tabindex="-1" aria-hidden="true">
                            <option value="">انتخاب کنید...</option>
                            SELECT * FROM irantech_demogardesh.product1level_tb WHERE idlevel0='0' AND
                            show_index='1' ORDER BY taghadom
                            <option data-value="BMW" value="32">BMW</option>
                            <option data-value="Lexus" value="33">Lexus</option>
                            <option data-value="AUDI" value="34">AUDI</option>
                        </select></div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
                    <div class="form-group"><input type="text"
                                                   class="form-control deptCalendar  hasDatepicker"
                                                   name="rentdate_rentCar" id="rentdate_rentCar"
                                                   placeholder="تاریخ اجاره">
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                    <div class="form-group"><select data-placeholder="   محل اجاره"
                                                    name="rentstation_rentCar" id="rentstation_rentCar"
                                                    class="select2  select2-hidden-accessible"
                                                    tabindex="-1" aria-hidden="true">
                            <option value="">انتخاب کنید...</option>
                            <option value="THR" id="originCityName0">تهران (THR)</option>
                            <option value="MHD" id="originCityName1">مشهد (MHD)</option>
                            <option value="KIH" id="originCityName2">کیش (KIH)</option>
                            <option value="IFN" id="originCityName3">اصفهان (IFN)</option>
                            <option value="AWZ" id="originCityName4">اهواز (AWZ)</option>
                            <option value="SYZ" id="originCityName5">شیراز (SYZ)</option>
                            <option value="TBZ" id="originCityName6">تبریز (TBZ)</option>
                            <option value="BND" id="originCityName7">بندر عباس (BND)</option>
                            <option value="GSM" id="originCityName8">قشم (GSM)</option>
                            <option value="AZD" id="originCityName9">یزد (AZD)</option>
                            <option value="ABD" id="originCityName10">آبادان (ABD)</option>
                            <option value="SDG" id="originCityName11">سنندج (SDG)</option>
                            <option value="KNR" id="originCityName12">کانگان (KNR)</option>
                            <option value="GBT" id="originCityName13">گرگان (GBT)</option>
                            <option value="KSH" id="originCityName14">کرمانشاه (KSH)</option>
                            <option value="ACP" id="originCityName15">مراغه (ACP)</option>
                            <option value="SRY" id="originCityName16">ساری (SRY)</option>
                            <option value="GCH" id="originCityName17">گچساران (GCH)</option>
                            <option value="KSN" id="originCityName18">کاشان (KSN)</option>
                            <option value="ACZ" id="originCityName19">زابل (ACZ)</option>
                            <option value="SXI" id="originCityName20">جزیره سیری (SXI)</option>
                            <option value="HDM" id="originCityName21">همدان (HDM)</option>
                            <option value="LFM" id="originCityName22">لامرد (LFM)</option>
                            <option value="ADU" id="originCityName23">اردبیل (ADU)</option>
                            <option value="SYJ" id="originCityName24">سیرجان (SYJ)</option>
                            <option value="IAQ" id="originCityName25">بهرگان (IAQ)</option>
                            <option value="LRR" id="originCityName26">لار (LRR)</option>
                            <option value="AEU" id="originCityName27">جزیره ابوموسی (AEU)</option>
                            <option value="LVP" id="originCityName28">لاوان (LVP)</option>
                            <option value="AFZ" id="originCityName29">سبزوار (AFZ)</option>
                            <option value="AJK" id="originCityName30">اراک (AJK)</option>
                            <option value="TCX" id="originCityName31">طبس (TCX)</option>
                            <option value="IHR" id="originCityName32">ایران شهر (IHR)</option>
                            <option value="IIL" id="originCityName33">ایلام (IIL)</option>
                            <option value="MRX" id="originCityName34">ماهشهر (MRX)</option>
                            <option value="NSH" id="originCityName35">نوشهر (NSH)</option>
                            <option value="JAR" id="originCityName36">جهرم (JAR)</option>
                            <option value="XBJ" id="originCityName37">بیرجند (XBJ)</option>
                            <option value="YES" id="originCityName38">یاسوج (YES)</option>
                            <option value="OMH" id="originCityName39">ارومیه (OMH)</option>
                            <option value="BDH" id="originCityName40">بندر لنگه (BDH)</option>
                            <option value="JWN" id="originCityName41">زنجان (JWN)</option>
                            <option value="PFQ" id="originCityName42">پارس آباد (PFQ)</option>
                            <option value="BJB" id="originCityName43">بجنورد (BJB)</option>
                            <option value="ZAH" id="originCityName44">زاهدان (ZAH)</option>
                            <option value="JYR" id="originCityName45">جیرفت (JYR)</option>
                            <option value="PGU" id="originCityName46">عسلویه (PGU)</option>
                            <option value="KER" id="originCityName47">کرمان (KER)</option>
                            <option value="ZBR" id="originCityName48">چابهار (ZBR)</option>
                            <option value="RAS" id="originCityName49">رشت (RAS)</option>
                            <option value="KHD" id="originCityName50">خرم آباد (KHD)</option>
                            <option value="BUZ" id="originCityName51">بوشهر (BUZ)</option>
                            <option value="KHK" id="originCityName52">خارک (KHK)</option>
                            <option value="RJN" id="originCityName53">رفسنجان (RJN)</option>
                            <option value="BXR" id="originCityName54">بم (BXR)</option>
                            <option value="RUD" id="originCityName55">شاهرود (RUD)</option>
                            <option value="CQD" id="originCityName56">شهر کرد (CQD)</option>
                            <option value="KHY" id="originCityName57">خوی (KHY)</option>
                            <option value="RZR" id="originCityName58">رامسر (RZR)</option>
                            <option value="DEF" id="originCityName59">دزفول (DEF)</option>
                            <option value="PYK" id="originCityName60">کرج (PYK)</option>
                        </select></div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
                    <div class="form-group"><input type="text"
                                                   class="form-control deptCalendar hasDatepicker"
                                                   name="dept_rentCar" id="dept_rentCar"
                                                   placeholder="تاریخ تحویل">
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                    <div class="form-group"><select data-placeholder=" محل تحویل"
                                                    name="deliverystation_rentCar"
                                                    id="deliverystation_rentCar"
                                                    class="select2  select2-hidden-accessible"
                                                    tabindex="-1" aria-hidden="true">
                            <option value="">انتخاب کنید...</option>
                            <option value="THR" id="originCityName0">تهران (THR)</option>
                            <option value="MHD" id="originCityName1">مشهد (MHD)</option>
                            <option value="KIH" id="originCityName2">کیش (KIH)</option>
                            <option value="IFN" id="originCityName3">اصفهان (IFN)</option>
                            <option value="AWZ" id="originCityName4">اهواز (AWZ)</option>
                            <option value="SYZ" id="originCityName5">شیراز (SYZ)</option>
                            <option value="TBZ" id="originCityName6">تبریز (TBZ)</option>
                            <option value="BND" id="originCityName7">بندر عباس (BND)</option>
                            <option value="GSM" id="originCityName8">قشم (GSM)</option>
                            <option value="AZD" id="originCityName9">یزد (AZD)</option>
                            <option value="ABD" id="originCityName10">آبادان (ABD)</option>
                            <option value="SDG" id="originCityName11">سنندج (SDG)</option>
                            <option value="KNR" id="originCityName12">کانگان (KNR)</option>
                            <option value="GBT" id="originCityName13">گرگان (GBT)</option>
                            <option value="KSH" id="originCityName14">کرمانشاه (KSH)</option>
                            <option value="ACP" id="originCityName15">مراغه (ACP)</option>
                            <option value="SRY" id="originCityName16">ساری (SRY)</option>
                            <option value="GCH" id="originCityName17">گچساران (GCH)</option>
                            <option value="KSN" id="originCityName18">کاشان (KSN)</option>
                            <option value="ACZ" id="originCityName19">زابل (ACZ)</option>
                            <option value="SXI" id="originCityName20">جزیره سیری (SXI)</option>
                            <option value="HDM" id="originCityName21">همدان (HDM)</option>
                            <option value="LFM" id="originCityName22">لامرد (LFM)</option>
                            <option value="ADU" id="originCityName23">اردبیل (ADU)</option>
                            <option value="SYJ" id="originCityName24">سیرجان (SYJ)</option>
                            <option value="IAQ" id="originCityName25">بهرگان (IAQ)</option>
                            <option value="LRR" id="originCityName26">لار (LRR)</option>
                            <option value="AEU" id="originCityName27">جزیره ابوموسی (AEU)</option>
                            <option value="LVP" id="originCityName28">لاوان (LVP)</option>
                            <option value="AFZ" id="originCityName29">سبزوار (AFZ)</option>
                            <option value="AJK" id="originCityName30">اراک (AJK)</option>
                            <option value="TCX" id="originCityName31">طبس (TCX)</option>
                            <option value="IHR" id="originCityName32">ایران شهر (IHR)</option>
                            <option value="IIL" id="originCityName33">ایلام (IIL)</option>
                            <option value="MRX" id="originCityName34">ماهشهر (MRX)</option>
                            <option value="NSH" id="originCityName35">نوشهر (NSH)</option>
                            <option value="JAR" id="originCityName36">جهرم (JAR)</option>
                            <option value="XBJ" id="originCityName37">بیرجند (XBJ)</option>
                            <option value="YES" id="originCityName38">یاسوج (YES)</option>
                            <option value="OMH" id="originCityName39">ارومیه (OMH)</option>
                            <option value="BDH" id="originCityName40">بندر لنگه (BDH)</option>
                            <option value="JWN" id="originCityName41">زنجان (JWN)</option>
                            <option value="PFQ" id="originCityName42">پارس آباد (PFQ)</option>
                            <option value="BJB" id="originCityName43">بجنورد (BJB)</option>
                            <option value="ZAH" id="originCityName44">زاهدان (ZAH)</option>
                            <option value="JYR" id="originCityName45">جیرفت (JYR)</option>
                            <option value="PGU" id="originCityName46">عسلویه (PGU)</option>
                            <option value="KER" id="originCityName47">کرمان (KER)</option>
                            <option value="ZBR" id="originCityName48">چابهار (ZBR)</option>
                            <option value="RAS" id="originCityName49">رشت (RAS)</option>
                            <option value="KHD" id="originCityName50">خرم آباد (KHD)</option>
                            <option value="BUZ" id="originCityName51">بوشهر (BUZ)</option>
                            <option value="KHK" id="originCityName52">خارک (KHK)</option>
                            <option value="RJN" id="originCityName53">رفسنجان (RJN)</option>
                            <option value="BXR" id="originCityName54">بم (BXR)</option>
                            <option value="RUD" id="originCityName55">شاهرود (RUD)</option>
                            <option value="CQD" id="originCityName56">شهر کرد (CQD)</option>
                            <option value="KHY" id="originCityName57">خوی (KHY)</option>
                            <option value="RZR" id="originCityName58">رامسر (RZR)</option>
                            <option value="DEF" id="originCityName59">دزفول (DEF)</option>
                            <option value="PYK" id="originCityName60">کرج (PYK)</option>
                        </select></div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
                    <button type="button" onclick="rentcar_local()" class="btn theme-btn seub-btn b-0">
                        <span>جستجو</span></button>
                </div>
            </form>
        </div>
    </div>
</div>