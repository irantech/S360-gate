<div data-name='service' class="bg-white d-flex flex-wrap rounded w-100 ">
    <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
        <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>
            مکان نمایش
        </h4>

        <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
              data-toggle="tooltip" data-placement="top" title=""
              data-original-title="نمایش آیتم در ابتدای نتایج جستجو"></span>

    </div>

    <hr class='m-0 mb-4 w-100'>
    <div class="d-flex gap-10 my-5 px-4 w-100">
        <div class="align-items-start col-md-3 col-sm-3 col-xs-3 d-flex justify-content-center p-0">
            <div class="form-group w-100">
                <label class="control-label" for="service1">سرویس</label>
                <select onchange='getServicePositions($(this))' name="service[]" id="service1"
                        class="form-control select2">
                    {foreach $getServices|@array_reverse:true as $service}
                        <option value="{$service['MainService']}">{$service['Title']}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class='col-md-9 d-flex flex-wrap p-0'>


            <div data-name='positions' class='align-items-center flex-wrap w-100 d-flex justify-content-center gap-8'>
                <div data-name='position'
                     class="w-100 d-flex each-position justify-content-center gap-8">

                    <div class="col-sm-5 p-0 d-none">
                        <div class="form-group">
                            <label class="align-items-center control-label d-flex flex-wrap justify-content-between"
                                   data-name="origin-label">
                                مبداء
                            </label>

                            <select data-name="origin"
                                    name="position[Public][origin][]"
                                    class="form-control select2">
                                <option value="all">مبداء</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-5 p-0 d-none">
                        <div class="form-group">
                            <label class="align-items-center control-label d-flex flex-wrap justify-content-between"
                                   data-name="destination-label">
                                مقاصد
                            </label>

                            <select data-name="destination"
                                    name="position[Public][destination][]"
                                    class="form-control select2">
                                <option value="all">مقاصد</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>


</div>


<div data-name='add-more-service'
     class="align-items-center   border-primary d-flex flex-wrap font-bold gap-10 justify-content-center rounded w-100 h-160">
    <button onclick='addMoreService($(this))' type='button'
            class='btn btn-default rounded d-flex flex-wrap gap-8 btn-new-style'>
        <span class='fa fa-plus-circle font20'></span>
        مکان نمایش جدید
    </button>
</div>