{$check_general = true}
{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $check_general}
<section class="i_modular_about_us about">
<div class="container">
<div class="parent-about">
<div class="parent-text-about">
<h3>

 چرا سفر با دانش گشت...؟!!

 </h3>
<p class="__aboutUs_class__">{$htmlContent = $about['body']|strip_tags}{$htmlContent|truncate:500}</p>
<div class="parent-box-about">
<div class="item-about">
<div class="parent-svg-about">
<svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M160 80c0-26.5 21.5-48 48-48h32c26.5 0 48 21.5 48 48V432c0 26.5-21.5 48-48 48H208c-26.5 0-48-21.5-48-48V80zM0 272c0-26.5 21.5-48 48-48H80c26.5 0 48 21.5 48 48V432c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V272zM368 96h32c26.5 0 48 21.5 48 48V432c0 26.5-21.5 48-48 48H368c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48z"></path></svg>
</div>
<div class="parent-paragraph-about">
<h6> با بیش از 20 سال سابقه کاری</h6>
<p>

 ما در سایت گردشگری با بیش از ده سال تجربه کاری در دنیای مسافرت‌ها و تورهای گردشگری به عنوان راهنمایی معتبر و قابل اطمینان برای سفرهای شما هستیم. با تیمی از متخصصین با تجربه در زمینه‌های مختلف گردشگری، ما بهترین تجربه‌ها، مقالات مفید و مشاوره‌های مستدام را به شما ارائه می‌دهیم. اعتماد به ما برای سفرهای لذت‌بخش و مموری ماندگار

</p>
</div>
</div>
<div class="item-about">
<div class="parent-svg-about">
<svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M253.4 2.9C249.2 1 244.7 0 240 0s-9.2 1-13.4 2.9L38.3 82.8C16.3 92.1-.1 113.8 0 140c.5 99.2 41.3 280.7 213.6 363.2c16.7 8 36.1 8 52.8 0C438.7 420.7 479.5 239.2 480 140c.1-26.2-16.3-47.9-38.3-57.2L253.4 2.9zM353 209L225 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L319 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"></path></svg>
</div>
<div class="parent-paragraph-about">
<h6> سریع‌تر و مطمئن ‌تر به سفر بروید</h6>
<p>

 سایت گردشگری ما با هدف ارائه بهترین تجربه‌های سفر و مشاوره‌های قابل اطمینان برای شما به وجود آمده است. با ما، شما می‌توانید سفرهایی سریع‌تر و مطمئن‌تر را تجربه کنید. تیم ما از افراد با تجربه در صنعت گردشگری تشکیل شده و اطلاعات و مشورهایی را ارائه می‌دهد که به شما در برنامه‌ریزی و انجام سفرهای خود کمک می‌کند. با ما سفری مطمئن و لذت‌بخش را تجربه کنید

</p>
</div>
</div>
<div class="item-about">
<div class="parent-svg-about">
<svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 48C141.1 48 48 141.1 48 256v40c0 13.3-10.7 24-24 24s-24-10.7-24-24V256C0 114.6 114.6 0 256 0S512 114.6 512 256V400.1c0 48.6-39.4 88-88.1 88L313.6 488c-8.3 14.3-23.8 24-41.6 24H240c-26.5 0-48-21.5-48-48s21.5-48 48-48h32c17.8 0 33.3 9.7 41.6 24l110.4 .1c22.1 0 40-17.9 40-40V256c0-114.9-93.1-208-208-208zM144 208h16c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H144c-35.3 0-64-28.7-64-64V272c0-35.3 28.7-64 64-64zm224 0c35.3 0 64 28.7 64 64v48c0 35.3-28.7 64-64 64H352c-17.7 0-32-14.3-32-32V240c0-17.7 14.3-32 32-32h16z"></path></svg>
</div>
<div class="parent-paragraph-about">
<h6> کشف دنیای جدید گردشگری</h6>
<p>

این وب‌سایت به شما فرصت می‌دهد تا جهان را به شیوه‌ای تازه تر و منحصر به فرد تجربه کنید. از جاذبه‌های توریستی معمول تا سفرهای خارق‌العاده و تجربه‌هایی که در دسترس تعداد محدودی از مسافران است، اینجا همه چیز وجود دارد. اگر شما نیز به دنبال تجربه‌های جدید و تازه در دنیای گردشگری هستید، این وب‌سایت به عنوان راهنمای شما در کشف سرزمین‌های ناشناخته و تعامل با جهان می‌باشد.

</p>
</div>
</div>
<div class="item-about">
<div class="parent-svg-about">
<svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M352 256c0 22.2-1.2 43.6-3.3 64H163.3c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64H348.7c2.2 20.4 3.3 41.8 3.3 64zm28.8-64H503.9c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64H380.8c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32H376.7c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0H167.7c6.1-36.4 15.5-68.6 27-94.7c10.5-23.6 22.2-40.7 33.5-51.5C239.4 3.2 248.7 0 256 0s16.6 3.2 27.8 13.8c11.3 10.8 23 27.9 33.5 51.5c11.6 26 21 58.2 27 94.7zm-209 0H18.6C48.6 85.9 112.2 29.1 190.6 8.4C165.1 42.6 145.3 96.1 135.3 160zM8.1 192H131.2c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64H8.1C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.6c-11.6-26-20.9-58.2-27-94.6H344.3c-6.1 36.4-15.5 68.6-27 94.6c-10.5 23.6-22.2 40.7-33.5 51.5C272.6 508.8 263.3 512 256 512s-16.6-3.2-27.8-13.8c-11.3-10.8-23-27.9-33.5-51.5zM135.3 352c10 63.9 29.8 117.4 55.3 151.6C112.2 482.9 48.6 426.1 18.6 352H135.3zm358.1 0c-30 74.1-93.6 130.9-171.9 151.6c25.5-34.2 45.2-87.7 55.3-151.6H493.4z"></path></svg>
</div>
<div class="parent-paragraph-about">
<h6>تمام تورهای جهان را با ما کاوش کنید</h6>
<p>

 سایت گردشگری ما یک منبع جامع برای کاوش تورهای جهانی است. از جاذبه‌های شهرهای بزرگ گرفته تا مسیرهای ماجراجویانه در دیگر نقاط جهان، ما همه را برای شما فراهم می‌کنیم. تیم متخصص و تجربه‌دار ما به شما در برنامه‌ریزی و انتخاب بهترین تورها کمک می‌کند. با ما جهان را کاوش کنید و تورهای خود را به تجربه‌هایی فراموش ‌نشدنی تبدیل کنید

</p>
</div>
</div>
</div>
<div class="parent-btn-about">
<a class="__aboutUs_class_href__" href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
<span>مشاهده بیشتر</span>
<svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 288 480 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-370.7 0 73.4-73.4c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-128 128z"></path></svg>
</a>
</div>
</div>
<div class="parent-img-about">
<img alt="img-about" src="https://www.iran-tech.com/under_construction/hooman/hooman2/images/he2.jpg"/>
</div>
</div>
</div>
</section>
{/if}