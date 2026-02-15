{assign var="breadcrumbs" value=$obj_main_page->breadcrumb scope=parent}

{if $breadcrumbs}
        <div class='my-breadcrumbs container'>
            <nav aria-label="breadcrumb" class="w-100">
                <ol class="parent-breadcrumb-item">
                    {foreach $breadcrumbs as $key => $breadcrumb}
                        <li class="breadcrumb-item{if count($breadcrumbs) eq $key+1} active align-items-center d-flex{/if}">
                            {if count($breadcrumbs) eq $key+1}
                                <h1 class='d-flex font-13 mb-0 site-main-text-color'
                                    href="{$breadcrumb['url']}">{$breadcrumb['title']}</h1>
                            {else}
                                <a class='font-13 text-dark' href="{$breadcrumb['url']}">{$breadcrumb['title']}</a>
                            {/if}
                        </li>
                    {/foreach}
                </ol>
            </nav>
        </div>
{/if}
