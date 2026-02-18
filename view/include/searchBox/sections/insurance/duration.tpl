<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
    <div class="form-group">
        <select data-placeholder="##travelDurationChoose##"
                name="travel_time" id="travel_time"
                class="select2_in travel-time-js select2-hidden-accessible"
                tabindex="-1" aria-hidden="true">
            <option value="">##ChoseOption## ...</option>
            <option selected="" default="" disabled> ##Durationtrip##</option>
            <option value="4" {if $smarty.const.INSURANCE_NUM_DAY eq 4} selected="selected" {/if}>1 {functions::StrReplaceInXml(["@@Day@@"=>'4'],"TOXDay")}</option>
            <option value="8" {if $smarty.const.INSURANCE_NUM_DAY eq 7} selected="selected" {/if}>5 {functions::StrReplaceInXml(["@@Day@@"=>'8'],"TOXDay")}</option>
            <option value="10" {if $smarty.const.INSURANCE_NUM_DAY eq 8} selected="selected" {/if}>9 {functions::StrReplaceInXml(["@@Day@@"=>'10'],"TOXDay")}</option>
            <option value="15" {if $smarty.const.INSURANCE_NUM_DAY eq 15} selected="selected" {/if}>11 {functions::StrReplaceInXml(["@@Day@@"=>'15'],"TOXDay")}</option>
            <option value="21" {if $smarty.const.INSURANCE_NUM_DAY eq 21} selected="selected" {/if}>16 {functions::StrReplaceInXml(["@@Day@@"=>'21'],"TOXDay")}</option>
            <option value="23" {if $smarty.const.INSURANCE_NUM_DAY eq 23} selected="selected" {/if}>22 {functions::StrReplaceInXml(["@@Day@@"=>'23'],"TOXDay")}</option>
            <option value="31" {if $smarty.const.INSURANCE_NUM_DAY eq 31} selected="selected" {/if}>24 {functions::StrReplaceInXml(["@@Day@@"=>'31'],"TOXDay")}</option>
            <option value="45" {if $smarty.const.INSURANCE_NUM_DAY eq 45} selected="selected" {/if}>32 {functions::StrReplaceInXml(["@@Day@@"=>'45'],"TOXDay")}</option>
            <option value="62" {if $smarty.const.INSURANCE_NUM_DAY eq 62} selected="selected" {/if}>46 {functions::StrReplaceInXml(["@@Day@@"=>'62'],"TOXDay")}</option>
            <option value="92" {if $smarty.const.INSURANCE_NUM_DAY eq 92} selected="selected" {/if}>63 {functions::StrReplaceInXml(["@@Day@@"=>'92'],"TOXDay")}</option>
            <option value="180" {if $smarty.const.INSURANCE_NUM_DAY eq 180} selected="selected" {/if}>93 {functions::StrReplaceInXml(["@@Day@@"=>'180'],"TOXDay")}</option>
            <option value="365" {if $smarty.const.INSURANCE_NUM_DAY eq 365} selected="selected" {/if}>181 {functions::StrReplaceInXml(["@@Day@@"=>'365'],"TOXDay")}</option>
        </select></div>
</div>