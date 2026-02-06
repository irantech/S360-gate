<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search search_col p-1">
    <div class="form-group destination_start">
        <div class="s-u-in-out-wrapper raft raft-change change-bor w-100">
            <input id="autoComplateSearchIN" name="autoComplateSearchIN"
                   class="inputSearchForeign w-100 form-control" type="text"
                   value=""
                   placeholder='##SelectDestinationCity##'
                   autocomplete="off"
                   onkeyup="searchCity('hotel')"
                   onclick="openBoxPopular('hotel')">
            <input type='hidden' id='autoComplateSearchIN_hidden' value=''
                   placeholder='##SelectDestinationCity##'>
            <input type='hidden' id='autoComplateSearchIN_hidden_en' value=''
                   placeholder='##SelectDestinationCity##'>
            <ul id="listSearchCity"
                class="ul-inputSearch-externalHotel displayiN"></ul>
        </div>

    </div>
</div>
