{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{assign var="socialLinks"  value=$about['social_links']|json_decode:true}
{include file="include_files/header.tpl" }

<main>
    {include file="include_files/banner.tpl" }
    {include file="include_files/search-box.tpl"}
    {include file="include_files/tours-special.tpl" }
    {include file="include_files/tours-recent.tpl" }
    {include file="include_files/airlines.tpl" }
    {include file="include_files/mag.tpl" }
    {include file="include_files/help.tpl" }
    {include file="include_files/faq.tpl" }
    {include file="include_files/news-letter.tpl" socialLinks=$socialLinks}
</main>
{include file="include_files/footer.tpl" socialLinks=$socialLinks}
</body>
{include file="include_files/script-footer.tpl"}
</html>

