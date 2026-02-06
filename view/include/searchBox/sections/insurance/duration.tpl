<div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search">
    <div class="form-group">
        <select data-placeholder="##travelDurationChoose##"
                name="travel_time" id="travel_time"
                class="select2_in travel-time-js select2-hidden-accessible"
                tabindex="-1" aria-hidden="true">
            <option value="">##ChoseOption## ...</option>
            <option selected="" default="" disabled> ##Durationtrip##</option>
            <option value="5" {if $smarty.const.INSURANCE_NUM_DAY eq 5} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'5'],"TOXDay")}</option>
            <option value="7" {if $smarty.const.INSURANCE_NUM_DAY eq 7} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'7'],"TOXDay")}</option>
            <option value="8" {if $smarty.const.INSURANCE_NUM_DAY eq 8} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'8'],"TOXDay")}</option>
            <option value="15" {if $smarty.const.INSURANCE_NUM_DAY eq 15} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'15'],"TOXDay")}</option>
            <option value="23" {if $smarty.const.INSURANCE_NUM_DAY eq 23} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'23'],"TOXDay")}</option>
            <option value="31" {if $smarty.const.INSURANCE_NUM_DAY eq 31} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'31'],"TOXDay")}</option>
            <option value="45" {if $smarty.const.INSURANCE_NUM_DAY eq 45} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'45'],"TOXDay")}</option>
            <option value="62" {if $smarty.const.INSURANCE_NUM_DAY eq 62} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'62'],"TOXDay")}</option>
            <option value="92" {if $smarty.const.INSURANCE_NUM_DAY eq 92} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'92'],"TOXDay")}</option>
            <option value="182" {if $smarty.const.INSURANCE_NUM_DAY eq 182} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'182'],"TOXDay")}</option>
            <option value="186" {if $smarty.const.INSURANCE_NUM_DAY eq 186} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'186'],"TOXDay")}</option>
            <option value="365" {if $smarty.const.INSURANCE_NUM_DAY eq 365} selected="selected" {/if}>{functions::StrReplaceInXml(["@@Day@@"=>'365'],"TOXDay")}</option>
        </select></div>
</div>