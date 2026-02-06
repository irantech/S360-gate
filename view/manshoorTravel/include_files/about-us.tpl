{$check_general = true}

{if $check_general}
{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
    <section class="i_modular_about_us about">
        <div class="container">
            <h3 class="title mb-4">درباره ما ؟!</h3>
            <p class="__aboutUs_class__">
                {$htmlContent = $about['body']|strip_tags}{$htmlContent|truncate:500}
            </p>
            <div class="parent-btn-about">
                <a class="" href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
                    <span>ادامه</span>
                    <svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
{/if}