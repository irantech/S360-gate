{load_presentation_object filename="rules" assign="objCategory"}
{assign var="allCategories" value=$objCategory->getAllCategories($smarty.const.SOFTWARE_LANG)}

<div class="container d-flex flex-wrap" id="rules">
    <div class="col-md-12 p-0 mb-2">
       <div class="header_top mt-3">
           <h3 class="site-main-text-color">
               ##TermsandConditions##
           </h3>
       </div>
   </div>
    {if $allCategories}
    <div class="col-lg-3 mb-3 mb-lg-0 pr-3 pr-lg-0">
        <div class='box_rules'>
            <ul class="nav nav-fill nav-pills" id="pills-tab" role="tablist">
                {foreach $allCategories as $key => $category}
                    {if $category.rules|count > 0}
                    <li class="nav-item w-100">
                        <a class="nav-link {if $key eq '0'}active{/if}" id="pills-{$category.slug}-tab" data-toggle="pill" href="#pills-{$category.slug}"
                           role="tab" aria-controls="pills-{$category.slug}" aria-selected="false">
                            <span class='{$category.icon}'></span>
                            {$category.title}
                        </a>
                    </li>
                    {/if}
                {/foreach}

            </ul>
        </div>
    </div>
    <div class="col-lg-9 pl-3 pl-lg-0 mb-3">
        <div class='box_rules tab-content' id="pills-tabContent">
            {foreach $allCategories as $key => $category}
                {if $category.rules|count > 0}

                {*<div id="accordion-{$category.slug}">*}
                <div class="tab-pane fade {if $key eq '0'}show active{/if}" id="pills-{$category.slug}" role="tabpanel">
                    <h3 class='title_rules'>
                        <span class='{$category.icon} site-bg-main-color'></span>
                        {$category.title}
                    </h3>
                    <div id="accordion-{$category.slug}">
                        {foreach $category.rules as $rule_key => $rule}
                            <div class="card mb-1rem">
                                <div class="card-header card_rules" id="{$rule.id}">
                                    <h5 class="align-items-center btn collapsed d-flex justify-content-between text-right w-100 p-0"
                                        data-target="#rule-{$rule.id}" aria-expanded="false"
                                        aria-controls="rule-{$rule.id}" data-toggle="collapse">
                                        {$rule.title}
                                        <span><i class='fa'></i></span>
                                    </h5>
                                </div>
                                <div id="rule-{$rule.id}" class="collapse" aria-labelledby="{$rule.id}">
                                    <div class="card-body line-h-1 text-justify">{$rule.content}</div>

                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
                {*</div>*}
                {/if}
            {/foreach}
        </div>
    </div>
    {else}
        <div class='alert alert-warning d-flex flex-wrap font-15 font-weight-bold justify-content-center mr-3 w-100'>
            ##NoInformationToDisplay##
        </div>
    {/if}
</div>


<style>
    .nav-link.active{
        color: #fff !important;
    }
    li.nav-link{
        background-color: #ffffff !important;
        color: #3f3f3f !important;
    }
    .after-border{
        width: 100%;
        vertical-align: middle;
        align-items: center;
        text-align: start;
        display: flex;
    }
    .after-border:after{
        content: "";
        border-bottom: 1px solid #ededed;
        line-height: 0.1em;
        margin-right: 18px;
        flex: 1 1 auto;

    }
    .p-sticky{
        position: sticky;
        top: 90px;
    }

    .header_top{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #ddd;
    }
    .box_rules{
        padding:1rem;
        border-radius:10px;
        border:1px solid #ccc;
        background:#fff;
    }

    .box_rules .nav-link{
        background:#fff;
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        margin-bottom: 1rem;
        color:#555;
        border-radius:10px;
        transition: all .3s;
        padding: 0.6rem 1rem;
    }
    .box_rules > ul > li:last-child .nav-link {
        margin-bottom: 0;
    }
    .box_rules .nav-link > span{
        font-size: 18px;
        margin-left: 1rem;
    }
    .box_rules .nav-link.active{
        border-color:transparent
    }
    .title_rules{
        font-size: 20px;
        border-bottom: 1px solid #ddd;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        color: #666;
        display: flex;
        align-items: center;
    }
    .title_rules span{
        font-size: 18px;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 100%;
        margin-left: 1rem;
    }
    .mb-1rem{
        margin-bottom:1rem
    }
    .box_rules .card_rules{
        padding: 0 !important;
        background:transparent !important;
    }
    .box_rules .card_rules > h5{
        padding: 0.6rem 1rem !important;
        display: flex !important;
        align-items: center !important;
    }
    .box_rules .card_rules > h5{
        background: #f9f9f9;
        translate: all .3s ;
        border-bottom: 1px solid #ddd;
        border-radius: 10px 10px 0 0;
        white-space: normal;
    }
    .box_rules .card_rules > h5.collapsed{
        background: none;
        translate: all .3s ;
        border-bottom: 1px solid transparent;

    }





    [data-toggle="collapse"].collapsed .fa:before {
        content: "\f106";
    }
    [data-toggle="collapse"] .fa:before {
        content: "\f106";
    }



    .box_rules .card_rules > h5 > span{
        font-size: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        color: #999;
        transform:rotate(0) !important;
        translate: all .3s !important;
    }
    .box_rules .card_rules > h5.collapsed > span{
        translate: all .3s !important;
        transform:rotate(180deg) !important;
    }
    .box_rules .card-header{
        border-bottom:none !important
    }
    .box_rules .card{
        border-radius:10px;
        border-color: #ddd
    }

    /*error*/
    .error {
        padding: 5px;
        margin: 5px 5px 20px 5px;
        border: solid 1px #FBD3C6;
        background: #FDE4E1;
        color: #CB4721;
        line-height: 25px;
        /*border-radius: 5px !important;*/
        clear: both !important;
    }
    .box_rules .card-body ul {
        list-style-type: disc;
        padding-right: 1.5rem;
        margin-bottom: 1rem;
    }
    .box_rules .card-body ol {
        list-style-type: decimal;
        padding-right: 1.5rem;
        margin-bottom: 1rem;
    }
    .box_rules .card-body li {
        margin-bottom: 0.5rem;
    }
</style>


