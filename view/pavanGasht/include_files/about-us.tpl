{$check_general = true}

{if $check_general}
<div class="i_modular_about_us parent-text-about-us">
<h2>درباره ی بیلیتیوم</h2>
<p class="__aboutUs_class__">{$htmlContent = $about['body']|strip_tags}{$htmlContent|truncate:300}</p>
</div>
{/if}