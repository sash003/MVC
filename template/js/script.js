
$(function(){



	let cart = [];

	// Добавить в корзину
	$(".addToCart").on("click", function(e) {
		e.preventDefault();
		let product = $(this).closest(".product");
		let name = product.data("name");
		let price = product.data("price");

		cart.push({ name, price });
		updateCart();
	});

	// Открыть корзину
	$("#openCart").on("click", function() {
		$("#cartModal").fadeIn();
	});

	// Закрыть корзину
	$("#closeCart").on("click", function() {
		$("#cartModal").fadeOut();
	});

	// Обновление корзины
	function updateCart() {
		$("#cartCount").text(cart.length);
		let items = "";
		cart.forEach((item, i) => {
			items += `<div class="cart-item">
                  <span>${item.name}</span>
                  <span>${item.price} ₽</span>
                </div>`;
		});
		$("#cartItems").html(items);
	}

	// Оформить заказ
	$("#checkoutBtn").on("click", function() {
		let name = $("#customerName").val();
		let phone = $("#customerPhone").val();

		if (!name || !phone) {
			alert("Заполните все поля!");
			return;
		}

		alert("Спасибо за заказ, " + name + "! Мы свяжемся с вами по телефону " + phone);
		cart = [];
		updateCart();
		$("#cartModal").fadeOut();
	});



	// Переключение выезда панели
	$('#openChat').on('click', function() {
		$('#chat-panel').toggleClass('open');
	});


	// Добавление сообщения
	function addMessage(name, msg) {
		const html = `<div><strong>${name}:</strong> ${msg}</div>`;
		$('#chat-messages').append(html);
		$('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
	}


	$('.flags img:first-child').click(function (){
		$('.flags a').css('display', 'inline-block')
	})
    
    $('a').on('click', function(e){
      if($(this).attr('href') == '/inspiration'){
        //e.preventDefault()
      }
    })
    
    
    //alert($('#bookText').css('font-size'))
    
      
		var time, open, open2, winH = $(window).height(), winW = $(window).width()
		var browser = getBrowser();
		browser = browser.split('/')
		browser = browser[0]
    
    //alert($(window).height())
    
    if($(window).width()>400){
      $('#book img:not(#bookImg,#bookImg2, .chakra)').css({'height': winH+'px', 'width':'auto'})
    }
    
    if(winW > winH){
      $('.quotes img').css({'height': winH+'px', 'width':'auto'})
    }else{
      $('.quotes img').css({'height': 'auto', 'width':'100%'})
    }


		/*
		if(browser == 'Firefox' || $(window).width() < 900){
			$('.button').after("<img class='wrap' src='/template/img/wrap.png' />")
			//$('.button').css('left', '7px')
		}
    if($(window).width() < 800 && $(window).width() > 400){
      $('.button').css('left', '8px')
      $('.wrap').css('width', '108%')
      $('.wrap').css('left', '-10px')

    }
    */
  
		//для скролла к ссылкам с #
		$("#content a").bind("click", function(e){
				e.preventDefault()
				var href = $(this).attr("href")
				href = href.slice(1)
				var as = $("[data-name='"+href+"']")
    
				$('html, body').animate(
					{
						scrollTop: as.offset().top - 11 + 'px'
					}, 555, function()
					{
						return
					});
    
			})

  
		// Верхнее и нижнее меню
		$("#menu a").each(function(index){
				time = 77*index
				$(this).css({"transition-delay": time+"ms"})
			})
		$("#menu2 a").each(function(index){
				index++
				time = 555*(1/index)
				$(this).css({"transition-delay": time+"ms"})
			})
  
		$("#openMenu").on("click", function(){
				if(open)return
				$("#menu").css({left: 0})
				$("#menu a").css({left: 0})
				setTimeout(function(){
						open = 1
					},123)
				if(!open){
					$(this).css({transform: "rotate(90deg)"})
				}else{
					$(this).css({transform: "none"})
				}
			})
      
		$("#openMenu2").on("click", function(){
				if(open2)return
				$("#menu2").css({left: 0})
				$("#menu2 a").css({left: 0})
				setTimeout(function(){
						open2 = 1
					},123)
				if(!open2){
					$(this).css({transform: "rotate(90deg)"})
				}else{
					$(this).css({transform: "none"})
				}
			})
  


		// скрытие по клику вне элемента
		$(document).bind('click', function(e)
			{
				if (!$(e.target).closest("#chat-panel").length && !$(e.target).closest("#openChat").length){
					$('#chat-panel').removeClass('open')
				}
				if (!$(e.target).closest("#menu").length && open)
				{
					$("#menu").css({left: "-342px"})
					$("#openMenu").css({transform: "none"})
					$("#menu a").css({left: "-100%"})
					open = 0
				}
				if (!$(e.target).closest("#menu2").length && open2)
				{
					$("#menu2").css({left: "-444px"})
					$("#openMenu2").css({transform: "none"})
					$("#menu2 a").css({left: "-100%"})
					open2 = 0
				}
				if (!$(e.target).closest(".flags").length)
				{
					$('.flags a').hide()
				}
			})



		// События клавиатуры
		$(document).bind('keydown', function(e)
			{
				if(event.key == "Escape")
				{
					$('#chat-panel').removeClass('open')
					$("#menu").css({left: "-342px"})
					$("#menu2").css({left: "-444px"})
					$("#openMenu").css({transform: "none"})
					$("#openMenu2").css({transform: "none"})
					$("#menu a").css({left: "-100%"})
					$("#menu2 a").css({left: "-100%"})
					open = 0
					open2 = 0
				}
			})

  
  
		// показать кнопку для прокрутки вверх
		$(window).bind('scroll', function()
			{
				scroll = $(window).scrollTop();
				offset = $(window).height();
			
				//console.log(scroll, offset)
				if(scroll >= offset)
				{
					$("#to_top").css("right", "17px");
					$("#to_top").css("bottom", "17px");
					$("#top").css("display", "block");
          
				}else{
					$("#to_top").css("bottom", "-123px");
					$("#top").css("display", "none");
				}
			});


		$("#to_top").bind('click',function(e){
				e.preventDefault();
				$('html, body').animate({scrollTop: 0}, 2);
			});


		//Прокрутка страниц вниз и вверх
		$("#bottom").bind('click', function(e){
				var pageH = document.documentElement.clientHeight - 33
				$('html, body').animate({
						scrollTop: window.pageYOffset + pageH + 'px'
					}, 111, function(){
					})
			})
      
		$("#top").bind('click', function(e){
				var pageH = document.documentElement.clientHeight - 33
				$('html, body').animate({
						scrollTop: window.pageYOffset - pageH + 'px'
					}, 111, function(){
					})
			})
    
    
		$('#right, #audioImg').lightBox()
    
    
    
		// открытие подразделов Вдохновение
		$('#inspiration2 a').bind('click', function(e){
				e.preventDefault();
				$('.inspiration').hide()
				var href = $(this).attr("id")
				if(href == 'video' || href == 'audio'){
          $("."+href).css('display', 'flex')
        }else{
          $("."+href).css('display', 'block')
        }
        if($('.video iframe').length){
          var sootn = 560/315, vW = $('.video iframe').width()
          $('.video iframe').css('height', vW/sootn + 'px')
        }
				$('html, body').animate({
						scrollTop: $(this).offset().top - 11 + 'px'
					}, 555);
			})
    
		// открытие историй
		$('.histories a').bind('click', function(e){
				e.preventDefault();
				if($(this).next().css('display') !== 'block'){
					$('html, body').animate({
							scrollTop: $(this).offset().top - 11 + 'px'
						}, 555);
				}
				$(this).next().slideToggle()
			})
    
    
    
		// открытие "О наших книгах"
		$('#our_authors').bind('click', function(e){
				$(this).next().slideToggle(555)
				$('html, body').animate({
						scrollTop: $(this).offset().top - 11 + 'px'
					}, 555);
			})




		$('#chat-input').on('input', function () {
			this.style.height = 'auto';
			this.style.height = (this.scrollHeight) + 'px';
		});
	})
  




$(window).on('load', function(){

	//setTimeout(console.clear(), 11111)



    if($('.video iframe').length){
      var sootn = 560/315, vW = $('.video iframe').width()
      $('.video iframe').css('height', vW/sootn + 'px')
    }

    if($('#inspiration').length){
      $('html, body').animate({
						scrollTop: $('#inspiration').offset().top - 11 + 'px'}, 555);
    }
    if($('.bookTable').length){
      $('html, body').animate({
			 scrollTop: $('.bookTable').offset().top - 22 + 'px'}, 555);
    }


		$('#contentContainer, #contentContainer *, figure, figure *').css('z-index', '1 !important')

		$(window).click(function(){
				$('#contentContainer, #contentContainer *, figure, figure *').css('z-index', '1 !important')
			})

		$(window).bind('resize', function(){

      if($(window).width() < 800 && $(window).width() > 400){
        $('.button').css('left', '10px')
        $('.wrap').css('width', '109%')
        $('.wrap').css('left', '-10px')

      }

      if($('.video iframe').length){
        var sootn = 560/315, vW = $('.video iframe').width()
        $('.video iframe').css('height', vW/sootn + 'px')
      }

      var winH = $(window).height(), winW = $(window).width()
      if(winW > winH){
        $('.quotes img').css({'height': winH+'px', 'width':'auto'})
      }else{
        $('.quotes img').css({'height': 'auto', 'width':'100%'})
      }

      if($(window).width()>400){
        winH = $(window).height()
        $('#book img:not(#bookImg,#bookImg2, .chakra)').css({'height': winH+'px', 'width':'auto !important'})
      }

				if($('figure').length){
					var heightCont = $('figure').height(),
					transform = $('body').width()/1280,
					mn = 1.05, mn2 = 1

					if ($('body').width()<1211) var mn = 1.2
					if ($('body').width()<1100) var mn = 1.25
					if ($('body').width()<1000) var mn = 1.3
					if ($('body').width()<900)var mn = 1.45
					if ($('body').width()<800)var mn = 0.9
					if ($('body').width()<700){ var mn = 1.05; var mn2 = 1.1}
					if ($('body').width()<600){ var mn2 = 1.2; var mn = 1.2}
					if ($('body').width()<400){ var mn2 = 1.25; var mn = 1.45}

					heightCont = heightCont*transform

					$('#citata').css('margin-top', heightCont*1.9*mn2+'px')
					$('#contentContainer').css('top', heightCont*1.2*mn+'px')
					$('#contentContainer').css('height', heightCont*1.5+'px')
				}

			})

		if($('figure').length){
			var heightCont = $('figure').height(),
			transform = $('body').width()/1280,
			mn = 1.05, mn2 = 1

			if ($('body').width()<1211) var mn = 1.2
			if ($('body').width()<1100) var mn = 1.25
			if ($('body').width()<1000) var mn = 1.3
			if ($('body').width()<900)var mn = 1.45
			if ($('body').width()<800)var mn = 0.9
			if ($('body').width()<700){ var mn = 1.05; var mn2 = 1.1}
			if ($('body').width()<600){ var mn2 = 1.2; var mn = 1.2}
			if ($('body').width()<400){ var mn2 = 1.25; var mn = 1.45}

			heightCont = heightCont*transform

			$('#citata').css('margin-top', heightCont*1.9*mn2+'px')
			$('#contentContainer').css('top', heightCont*1.2*mn+'px')
			$('#contentContainer').css('height', heightCont*1.5+'px')
		}

	const players = [];

	$('.audioWrap').each(function (index) {
		const wrap = $(this);
		const audio = wrap.find('audio')[0];
		const playBtn = wrap.find('#playPauseBtn');
		const progress = wrap.find('#progress');
		const time = wrap.find('#time');

		// Сохраняем в массив всех плееров
		players.push({ audio, playBtn });

		// Play / Pause
		playBtn.on('click', function () {
			// Остановить все другие аудио
			players.forEach(p => {
				if (p.audio !== audio) {
					p.audio.pause();
					p.playBtn.text('▶');
				}
			});

			if (audio.paused) {
				audio.play();
				playBtn.text('⏸');
			} else {
				audio.pause();
				playBtn.text('▶');
			}
		});

		// Обновление прогресса и времени
		audio.addEventListener('timeupdate', function () {
			const percent = (audio.currentTime / audio.duration) * 100;
			progress.val(percent || 0);

			const format = s => Math.floor(s / 60) + ':' + String(Math.floor(s % 60)).padStart(2, '0');
			time.text(`${format(audio.currentTime)} / ${format(audio.duration)}`);
		});

		// Перемотка вручную
		progress.on('input', function () {
			audio.currentTime = (progress.val() / 100) * audio.duration;
		});

		// Когда заканчивается — включить следующее
		audio.addEventListener('ended', function () {
			playBtn.text('▶');

			const next = players[index + 1];
			if (next) {
				next.audio.play();
				next.playBtn.text('⏸');

				// Остановить все другие
				players.forEach((p, i) => {
					if (i !== index + 1) {
						p.audio.pause();
						p.playBtn.text('▶');
					}
				});
			}
		});
	});

	})



/*Функции*/
getBrowser = () => {
	const userAgent = navigator.userAgent;
	let browser = 'unkown';
	// Detect browser name
	browser = /ucbrowser/i.test(userAgent) ? 'UCBrowser' : browser;
	browser = /edg/i.test(userAgent) ? 'Edge' : browser;
	browser = /googlebot/i.test(userAgent) ? 'GoogleBot' : browser;
	browser = /chromium/i.test(userAgent) ? 'Chromium' : browser;
	browser =
	/firefox|fxios/i.test(userAgent) && !/seamonkey/i.test(userAgent)
	? 'Firefox'
	: browser;
	browser =
	/; msie|trident/i.test(userAgent) && !/ucbrowser/i.test(userAgent)
	? 'IE'
	: browser;
	browser =
	/chrome|crios/i.test(userAgent) &&
	!/opr|opera|chromium|edg|ucbrowser|googlebot/i.test(userAgent)
	? 'Chrome'
	: browser;
	browser =
	/safari/i.test(userAgent) &&
	!/chromium|edg|ucbrowser|chrome|crios|opr|opera|fxios|firefox/i.test(
		userAgent
	)
	? 'Safari'
	: browser;
	browser = /opr|opera/i.test(userAgent) ? 'Opera' : browser;

	// detect browser version
	switch (browser) {
		case 'UCBrowser':
		return `${browser}/${browserVersion(
				userAgent,
				/(ucbrowser)\/([\d\.]+)/i
			)}`;
		case 'Edge':
		return `${browser}/${browserVersion(
				userAgent,
				/(edge|edga|edgios|edg)\/([\d\.]+)/i
			)}`;
		case 'GoogleBot':
		return `${browser}/${browserVersion(
				userAgent,
				/(googlebot)\/([\d\.]+)/i
			)}`;
		case 'Chromium':
		return `${browser}/${browserVersion(
				userAgent,
				/(chromium)\/([\d\.]+)/i
			)}`;
		case 'Firefox':
		return `${browser}/${browserVersion(
				userAgent,
				/(firefox|fxios)\/([\d\.]+)/i
			)}`;
		case 'Chrome':
		return `${browser}/${browserVersion(
				userAgent,
				/(chrome|crios)\/([\d\.]+)/i
			)}`;
		case 'Safari':
		return `${browser}/${browserVersion(
				userAgent,
				/(safari)\/([\d\.]+)/i
			)}`;
		case 'Opera':
		return `${browser}/${browserVersion(
				userAgent,
				/(opera|opr)\/([\d\.]+)/i
			)}`;
		case 'IE':
		const version = browserVersion(userAgent, /(trident)\/([\d\.]+)/i);
		// IE version is mapped using trident version
		// IE/8.0 = Trident/4.0, IE/9.0 = Trident/5.0
		return version
		? `${browser}/${parseFloat(version) + 4.0}`
		: `${browser}/7.0`;
		default:
		return `unknown/0.0.0.0`;
	}
};

browserVersion = (userAgent, regex) => {
	return userAgent.match(regex) ? userAgent.match(regex)[2] : null;
};

