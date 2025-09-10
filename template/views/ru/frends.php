


<div id="contentContainer" class="trans3d"> 
	<section id="carouselContainer" class="trans3d"> 
		<?php
		$scan = array('<figure id="item" class="carouselItem trans3d" style="opacity: 1 !important;"><div class="carouselItemInner trans3d">
			<a target="_blank" href="https://vk.com/zhividuhovno">
			<img src="/template/img/figures/valmiki.png" alt="" />
			</a>
			</div></figure>', 
    
			'<figure id="item" class="carouselItem trans3d"><div class="carouselItemInner trans3d">
			<a target="_blank" href="https://vk.com/cccprabhu">
			<img src="/template/img/figures/hakimov.png" alt="" />
			</a>
			</div></figure>', 
    
			'<figure id="item" class="carouselItem trans3d"><div class="carouselItemInner trans3d">
			<a target="_blank" href="https://www.youtube.com/watch?v=wMoQo7tw1xE&list=PLJ5aVQ8N8QNVJ1slwf4FajMM3wTLZ7njL&ab_channel=%D0%92%D0%B5%D0%B4%D1%8B%D0%B8%D1%81%D0%B0%D0%BC%D0%BE%D0%BE%D1%81%D0%BE%D0%B7%D0%BD%D0%B0%D0%BD%D0%B8%D0%B5">
			<img src="/template/img/figures/prabhupada.png" alt="" />
			</a>
			</div></figure>',
    
			'<figure id="item" class="carouselItem trans3d"><div class="carouselItemInner trans3d">
			<a target="_blank" href="https://vk.com/club124768140">
			<img src="/template/img/figures/Lakshmi_Narayana_das.png" alt="" />
			</a>
      
			</div></figure>',
    
			'<figure id="item" class="carouselItem trans3d"><div class="carouselItemInner trans3d">
			<a target="_blank" href="http://sampradaya.ru/">
			<img src="/template/img/figures/sampradaya.png" alt="" />
			</a>
			</div></figure>',
    
			'<figure id="item" class="carouselItem trans3d"><div class="carouselItemInner trans3d">
			<a target="_blank" href="https://vk.com/brsridhar">
			<img src="/template/img/figures/shridhar.png" alt="" />
			</a>
			</div></figure>',
    
			'<figure id="item" class="carouselItem trans3d"><div class="carouselItemInner trans3d">
			<a target="_blank" href="https://www.youtube.com/@TheGOINSIDE">
			<img src="/template/img/figures/saraswatmath.png" alt="" />
			</a>
			</div></figure>',
    
			'<figure id="item" class="carouselItem trans3d"><div class="carouselItemInner trans3d">
			<a target="_blank" href="https://audioveda.ru/">
			<img src="/template/img/figures/audioveda.png" alt="" />
			</a>
			</div></figure>',
    
			'<figure id="item" class="carouselItem trans3d"><div class="carouselItemInner trans3d">
			<a target="_blank" href="https://vk.com/avadhyt">
			<img src="/template/img/figures/avadhut.png" alt="" />
			</a>
			</div></figure>',
    
			'<figure id="item" class="carouselItem trans3d"><div class="carouselItemInner trans3d">
			<a target="_blank" href="https://www.youtube.com/watch?v=3o7KUPNCEYQ&list=PLjA8IJ0yiZ5_-h4T12xoj2Ab5n5M3pXE8&ab_channel=%D0%9E%D0%B1%D1%80%D0%B0%D1%82%D0%BD%D0%BE%D0%BA%D0%91%D0%BE%D0%B3%D1%83">
			<img src="/template/img/figures/prabhu.png" alt="" />
			</a>
			</div></figure>',
    
			'<figure id="item" class="carouselItem trans3d"><div class="carouselItemInner trans3d">
			<a target="_blank" href="https://vk.com/audios-27162779">
			<img src="/template/img/figures/Ari_Mardan.png" alt="" />
			</a>
			</div></figure>',
    
			'<figure id="item" class="carouselItem trans3d"><div class="carouselItemInner trans3d">
			<a target="_blank" href="https://www.youtube.com/watch?v=QYXYVNEU1Bo">
			<img src="/template/img/figures/bhaktivinod.png" alt="" />
			</a>
			</div></figure>');
		$numbers = range(1, count($scan));
		shuffle($numbers);
		shuffle($scan);
		for($i = 1; $i <= count($scan); $i++){
			echo str_replace("item", "item".$numbers[$i-1], $scan[$i-1]);
		}
		?>
	</section>
</div>


<div id="main">
<h2>Основные интернет-ресурсы</h2>
<p align="left"><b><a href="https://t.me/splec" target="_blank" rel="noopener">Лекции Шрилы Прабхупады</a> – </b>Телеграмм-канал с аудиолекциями Бхактиведанты Свами Прабхупады</p>
<p align="left"><b><a href="https://t.me/LectureSP" target="_blank" rel="noopener">Лекции Шрилы Прабхупады</a> – </b>Ещё один телеграмм-канал с аудиолекциями Бхактиведанты Свами Прабхупады</p>
<p align="left"><b><a href="https://t.me/avadhutswami" target="_blank" rel="noopener">Свами Авадхут Махарадж</a> – </b>Телеграмм-канал Авадхута Махараджа, ученика Говинды Махараджа</p>
<p align="left"><b><a href="https://www.youtube.com/watch?v=wMoQo7tw1xE&list=PLJ5aVQ8N8QNVJ1slwf4FajMM3wTLZ7njL&ab_channel=%D0%92%D0%B5%D0%B4%D1%8B%D0%B8%D1%81%D0%B0%D0%BC%D0%BE%D0%BE%D1%81%D0%BE%D0%B7%D0%BD%D0%B0%D0%BD%D0%B8%D0%B5" target="_blank" rel="noopener">Воспоминания о Прабхупаде</a> – </b>Эксклюзивный сериал о Шриле Прабхупаде "Prabhupada Memories". Полное собрание из 63 частей (более 90 часов) воспоминаний учеников Шрилы Прабхупады</p>
<p align="left"><b><a href="https://t.me/caitanyacaritamrita" target="_blank" rel="noopener">Аудиокнига «Чайтанья Чаритамрита»</a></b></p>
<p align="left"><b><a href="https://t.me/sriguruandhisgrace" target="_blank" rel="noopener">Аудиокнига Шридхара Махараджа «Шри Гуру и Его милость»</a></b></p>
<p align="left"><b><a href="https://www.youtube.com/watch?v=OTKX80i_SMI" target="_blank" rel="noopener">Аудиокнига Шридхара Махараджа «Субъективная эволюция сознания»</a></b></p>
<p align="left"><b><a href="https://t.me/poiskshrikrishna" target="_blank" rel="noopener">Аудиокнига Шридхара Махараджа «Поиск Шри Кришны, Прекрасной Реальности»</a></b></p>
<p align="left"><b><a href="https://t.me/flagSCSM" target="_blank" rel="noopener">Флаг Шри Чайтанья Сарасват Матха</a> – </b>Телеграмм-канал с лекциями Ачарьев и Гуру Шри Чайтанья Сарасват Матха</p>
<p align="left"><b><a href="https://t.me/mahabharata_video" target="_blank" rel="noopener">Сериал «Махабхарата»</a></b></p>
<p align="left"><b><a href="https://audioveda.ru" target="_blank" rel="noopener">Аудиоведа</a> – </b>Лекции и аудиокниги по ведической культуре, книги, индийская музыка, мантры, бхаджаны, медитации</p>
<p align="left"><b><a href="http://sampradaya.ru" target="_blank" rel="noopener">sampradaya.ru</a> – </b>Сайт Ари Мардана даса, ученика Нараяны Махараджа</p>
<p align="left"><b><a href="https://vk.com/audios-27162779" target="_blank" rel="noopener">Лекции Ари Мардана даса</a> – </b>Группа вКонтакте Ари Мардана даса</p>
<p align="left"><b><a href="http://harekrishna.ru" target="_blank" rel="noopener">harekrishna.ru</a> – </b>официальный сайт русско-украинской миссии Шри Чайтанья Сарасват Матха</p>
<p><b><a href="http://scsmath.com/" target="_blank" rel="noopener">scsmath.com</a> – </b>официальный международный сайт Шри Чайтанья Сарасват Матха</p>
<p align="justify"><b><a href="http://gaudiyadarshan.ru" target="_blank" rel="noopener">gaudiyadarshan.ru</a> – </b>лекции <i>ачарьев, </i>опубликованные Б. К. Тьяги Махараджем, в русских переводах</p>
<p><b><a href="http://sridharmaharaj.ru/" target="_blank" rel="noopener">sridharmaharaj.ru</a> – </b>русскоязычный тематический аудиоархив Шрилы Б.Р. Шридхара Махараджа</p>
<p><b><a href="http://govindamaharaj.com/" target="_blank" rel="noopener">govindamaharaj.com</a> – </b>архив духовного наследия Шрилы Б.С. Говинды Махараджа на двух языках</p>
<p><b><a href="http://avadhutswami.ru/" target="_blank" rel="noopener">avadhutswami.ru</a> – </b>официальный сайт Шрилы Б.Б. Авадхута Махараджа</p>
<p><b><a href="http://youtube.com/user/BeautyOverPower" target="_blank" rel="noopener">youtube.com/user/BeautyOverPower</a> – </b>канал проекта «Beauty over power», посвящённого <i>хари-катхе</i> Шрилы Б.С. Госвами Махараджа</p>
<p><b><a href="http://youtube.com/user/GoswamiTV" target="_blank" rel="noopener">youtube.com/user/GoswamiTV</a> – </b>официальный канал Б.С. Госвами Махараджа</p>
<p><b><a href="http://youtube.com/user/TheisticMediaStudios" target="_blank" rel="noopener">youtube.com/user/TheisticMediaStudios</a> – </b>официальный канал студии INFINITI Media, транслирующей выступления проповедников Шри Чайтанья Сарасват Матха</p>
<p><b><a href="https://www.youtube.com/channel/UCnV8EQbekgebJcHGnJEQTFA/videos" target="_blank">Канал трансляций из Лахтинского храма</a></b></p>
<p><b><a href="https://www.youtube.com/user/TVDarshan/videos" target="_blank">Канал трансляций из Москвы, с Кисельного</a></b></p>
<p><b><a href="https://t.me/scsmbooks" target="_blank" rel="noopener">https://t.me/scsmbooks</a></b> – телеграм-канал с аудиокнигами Шри Чайтанья Сарасват Матха</p>
<p><b><a href="https://t.me/sridharmaharaj" target="_blank" rel="noopener">https://t.me/sridharmaharaj</a></b> <b>– </b>телеграм-канал, посвящённый наследию Шрилы Б.Р. Шридхара Махараджа</p>
<p><b><a href="http://youtube.com/channel/UCHQCoQpYvsqmp0Oy2EQagmA" target="_blank" rel="noopener">youtube.com/channel/UCHQCoQpYvsqmp0Oy2EQagmA</a> – </b>канал «Bhakti Connect» с лекциями основных проповедников Шри Чайтанья Сарасват Матха на английском языке</p>
<p><b><a href="https://premadharma.org" target="_blank" rel="noopener">https://premadharma.org/</a></b> – проповеднический сайт Шрипада Б.К. Тьяги Махараджа (на англ. языке)</p>
<p><b><a href="https://jayasri.org" target="_blank" rel="noopener">https://jayasri.org</a></b> – Сайт Шриюкта Вишкахи д.д., посвящённый наследию Шрилы Б.С. Говинды Махараджа (на англ. языке)</p>
<p><b><a href="http://vk.com/brsridhar" target="_blank" rel="noopener">vk.com/brsridhar</a> – </b>паблик, посвящённый наследию Шрилы Б.Р. Шридхара Махараджа</p>
<p><b><a href="http://vk.com/bsgovinda" target="_blank" rel="noopener">vk.com/bsgovinda</a> – </b>паблик, посвящённый наследию Шрилы Б.С. Говинды Махараджа</p>
<p><b><a href="http://vk.com/bsgoswami" target="_blank" rel="noopener">vk.com/bsgoswami</a> – </b>паблик, посвящённый <i>хари-катхе</i> Шрилы Б.С. Госвами Махараджа</p>
<p><b><a href="http://vk.com/bhakti_lalita" target="_blank" rel="noopener">vk.com/bhakti_lalita</a> – </b>паблик, посвящённый<b> </b><i>хари-катхе </i>Шримати Бхакти Лалиты Диди</p>
<p><b><a href="https://bharati.ru/" target="_blank" rel="noopener">bharati.ru</a></b> – официальный сайт Шрипада Б.Ч. Бхарати Махараджа c большим архивом книг и лекций <i>ачарьев</i></p>
<p><b><a href="http://vk.com/eachdie" target="_blank" rel="noopener">vk.com/eachdie</a> – </b>паблик «Стопроцентная смертность»: творческий проект Аджиты Кришны Прабху и Павана Кришны Прабху, основанный на лекциях Шрилы Б.С. Госвами Махараджа</p>
<p><b><a href="https://www.youtube.com/channel/UCwsP9vHfj2IujZ8ynY7TZzA/videos" target="_blank">Официальный канал сухумского храма</a></b></p>
<p><b><a href="https://www.facebook.com/yogivgoroge" target="_blank" rel="noopener">https://www.facebook.com/yogivgoroge</a></b> – Йоги в дороге: страничка воодушевляющего проекта, созданного Арджуной, Радха Раманом, Анджали, другими преданными и их друзьями</p>
<p><b><a href="https://www.youtube.com/channel/UChiGthIjsGoXvorvEQY7WRw/videos" target="_blank">X-HappyLife, канал Анджали из Винницы, послание добра и любви</a></b></p>
<p><b><a href="http://youtube.com/user/vedalifemedia" target="_blank" rel="noopener">youtube.com/user/vedalifemedia</a> – </b>лекции, прочитанные на фестивале «Ведалайф»</p>
<p><b><a href="http://soundcloud.com/bhakti-sound/sets" target="_blank" rel="noopener">soundcloud.com/bhakti-sound/sets</a> – </b>молитвы и Писания в аудиоформате</p>
<p><b><a href="http://soundcloud.com/huron/sets" target="_blank" rel="noopener">soundcloud.com/huron/sets</a> – </b>плейлисты с записями <i>хари-катхи</i> и молитв <i>ачарьев</i></p>
<p><b><a href="https://soundcloud.com/avadhutswami" target="_blank" rel="noopener">https://soundcloud.com/avadhutswami</a> – </b>аудиозаписи лекций и творчества Шрилы Б.Б. Авадхута Махараджа</p>
</div>


<style type="text/css">
  
  #main{
    color: #2b4240;
  }
  #main a{
    color: #3d5f5c;
    font-weight: bold;
  }
  
  h2{
    font-size: 33px;
  }
  
  #citata{
    margin: 50px;
    width: auto;
  }
  
  * { 
		box-sizing: border-box; 
	}
  figure{
    cursor: pointer;
    opacity: 1 !important;
  }

	.trans3d figure{
		cursor: pointer !important;
	}
	.trans3d figure a{
		display: block;
		height: 100%;
		width: 100%;
		text-align: center;
	}
	.trans3d figure img{
		height: 100%;
	}
	.trans3d
	{
		z-index: 1;
		-webkit-transform-style: preserve-3d;
		-webkit-transform: translate3d(0, 0, 0);
		-moz-transform-style: preserve-3d;
		-moz-transform: translate3d(0, 0, 0);
		-ms-transform-style: preserve-3d;
		-ms-transform: translate3d(0, 0, 0);
		transform-style: preserve-3d;
		transform: translate3d(0, 0, 0);
		/*
		-webkit-backface-visibility: hidden;
		-moz-backface-visibility: hidden;
		-ms-backface-visibility: hidden;
		backface-visibility: hidden;
		*/
	}
	
	#contentContainer, #contentContainer *, figure, figure *{
    z-index: 0 !important;
    opacity: 1 !important;
  }
	#contentContainer
	{
		width: 100%;
    position: absolute;
		background-size: 100% 100%;
	}
	
	#carouselContainer
	{
		position: absolute;
		margin-left: -50%;
		margin-top: -333px;
		left: 50%;
		top: 50%;
		width: 100%;
		height: 500px;
	}
	
	.carouselItem
	{
		width: 333px;
		height: 222px;
		position: absolute;
		left: 50%;
		top: 50%;
		margin-left: -160px;
		margin-top: -90px;
		visibility: hidden;
	}
	
	.carouselItemInner
	{
		width: 333px;
		height: 222px;
		position: absolute;
		background-color: #216c11;;
		border: 10px solid #5f8a29;
		border-radius: 7px;
		left: 50%;
		top: 50%;
		margin-left: -160px;
		margin-top: -90px;
		text-align: center;
		
	}
  
  figure *{
    background: green;
    opacity: 1 !important;
  }
  
  @media (max-width: 1111px){
		#contentContainer
		{
			transform: scale(0.8);
		}
	}
  
	@media (max-width: 1001px){
		#contentContainer
		{
			transform: scale(0.7)
		}
	}
	@media (max-width: 800px){
		#contentContainer
		{
			transform: scale(0.6)
		}
	}
	@media (max-width: 700px){
		#contentContainer
		{
			transform: scale(0.5)
		}
	}
@media (max-width: 600px){
    #citata{
      margin: 20px;
    }
	}
@media (max-width: 500px){
		#contentContainer
		{
			transform: scale(0.4)
		}    
	}
@media (max-width: 400px){
		#contentContainer
		{
			transform: scale(0.3)
		}
    #citata{
      margin: 7px;
    }
	}
</style>


<script type="text/javascript">
    
	var w2 = parseInt(window.innerWidth); 
	var h2 = parseInt(window.innerHeight); 

	if ( (w2<580) || (h2<580)) { // это мобильник 
		//$("#contentContainer").hide();
		//$("#carowrap").show();
	}
  
  
  $("figure").bind("click", function(){
			$(this).find("a").trigger("click");
		});
  
  var Iw = $('.fon').width()
  $('.fon').height(Iw/3)
  $(window).bind("resize", function(){
    var Iw = $('.fon').width()
  $('.fon').height(Iw/3)
  })
</script>