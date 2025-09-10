"use strict";

$(document).ready(function()
{

  const socket = new WebSocket("ws://test.waytohome.in.net:3007/");

  const notifySound = new Audio('/template/req/call_init.mp3');
  notifySound.volume = 0.8;

  // 1. При загрузке страницы — подставить имя, если сохранено
  if (localStorage.getItem('name')) {
    $('input[name="name"]').val(localStorage.getItem('name'));
    $('#name').hide()
  }




  var login = localStorage.getItem('name')
  //console.log(login)
  //if (login){
    $.ajax(
      {
        url: "/models/ChatHandler.php",
        type: "POST",
        data: {'func':'listPrev', 'destination': login},
        success: function(res)
        {
          //console.log(res)
          if(!res) return;
          $('#chat-messages ul').html(res)
          setTimeout(function (){
            $("#chat-messages").stop().animate(
              {
                scrollTop: $("#chat-messages").height() * 111
              },
              555
            );
          })
          setTimeout(function (){
            $(".time").each(function()
            {
              var time = parseInt($(this).text()+"000"),
                rightTime = getRightTime(time);
              if (/\d{13}/.test(time))
              {
                $(this).text(rightTime);
              }
            });

          }, 111)

        }
      });

  //}


  // в бд лежат секунды по UTC
  $(".time").each(function()
  {
    var time = parseInt($(this).text()+"000"),
      rightTime = getRightTime(time);
    if (/\d{13}/.test(time))
    {
      $(this).text(rightTime);
    }
  });




  /*

    $(document).on('contextmenu', function(e) {
      e.preventDefault(); // ���� Блок правого клика
    });

    $(document).on('keydown', function(e) {
      var key = e.key.toLowerCase();

      // ���� F12
      if (e.key === 'F12') {
        e.preventDefault();
      }

      // ���� Ctrl + (U, S, P)
      if (e.ctrlKey && ['u', 's', 'p'].includes(key)) {
        e.preventDefault();
      }

      // ���� Ctrl+Shift + (I, C, J, S)
      if (e.ctrlKey && e.shiftKey && ['i', 'c', 'j', 's'].includes(key)) {
        e.preventDefault();
      }
    });

  */






  var message_txt = $("#message_text"),
    audio = $("#audio")[0],
    start

  socket.onerror = function(error) {
    console.error('WebSocket Error:', error);
  };




  socket.onopen = function(event)
  {
    console.log('connected')
  };




  socket.onclose = function(event)
  {
    if( event.wasClean )
    {
    }else
    {
    }
  };


  function formDataToJson(formData) {
    const obj = {};

    for (const [key, value] of formData.entries()) {
      if (value instanceof File) {
        obj[key] = value.name
          ? { name: value.name, size: value.size, type: value.type }
          : null; // если файл не выбран — null
      } else {
        obj[key] = value;
      }
    }
    return JSON.stringify(obj);
  }


  function setCursors() {
    // /console.log('setCursors called');
    $('.name').each(function() {
      let name = $(this).text().trim().replace(/:$/, '');
      if (name !== 'adi das') {
        $(this).css('cursor', 'pointer');
      } else {
        $(this).css('cursor', 'default');
      }
    });
  }



  setTimeout(setCursors(), 111)



  var destination = ''
  $(document).on('click', '.name', function () {
    destination = $(this).text();
    destination = destination.trim()
    destination = destination.slice(0, -1);
    if(destination == localStorage.getItem('name')) destination = ''
    if(destination == 'adi das') destination = ''
  });



  // всё начинается отсюда
  $('#chat-form').on('submit', function(e)
  {
    e.preventDefault();
    var text = $("#chat-input").val(), name

    if(localStorage.getItem('name')){
      name = localStorage.getItem('name')
    }else{
      name = $("#name").val()
    }
    var time = getUTC()
    text = text.trim()
    name = name.trim()
    if (!text || !name) return;
    if(!localStorage.getItem('name')) {
      localStorage.setItem('name', name);
    }
    $('#name').hide()
    var data = new FormData($("#chat-form").get(0));
    data.append("func", "setToDB");

    data.append("destination", destination);

    socket.send(formDataToJson(data))
    $("#chat-input").val("")
    $('#chat-input').css('height', '');
    /*
    $.ajax(
      {
        url: "/models/ChatHandler.php",
        type: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(res)
        {
          console.log(res)
          if(!res) return;


          setTimeout(function()
          {
            socket.send(formDataToJson(data))
          }, 11);

          $("#chat-input").val("")
        }
      });
*/

  });




  // а это ловит сообщение, которое отослал нам сервер
  socket.onmessage = function(data)
  {
    data = JSON.parse(data.data);
   // console.log(data)
    msg(data.name, data.message);

    setTimeout(function (){
      $(".time").each(function()
      {
        var time = parseInt($(this).text()+"000"),
          rightTime = getRightTime(time);
        if (/\d{13}/.test(time))
        {
          $(this).text(rightTime);
        }
      });

    }, 111)
  };





  // вставка словленного сообщения в хтмл
  function msg(name, message)
  {
    if (name == $("#name").val())
    {
      start = '<li class="msg" style="margin-left: 15px;">';
    } else {
      start = '<li class="msg" style="margin-left: 22px;">';
      notifySound.play().catch(e => console.warn("Звук не воспроизвёлся:", e));
    }
    var m =
      start +
      '<b class="name">' +
      name +
      ":</b> &nbsp;&nbsp;" +
      message +
      "<span class='time'>" +
      getRightTime(getUTC()) +
      "</span>" +
      "</li>";
    var last = $(m);
    last.appendTo("#chat-messages ul");
    // если вверх не крутили чтото не искали

    setTimeout(setCursors(), 111)

    $("#chat-messages").stop().animate(
      {
        scrollTop: $("#chat-messages").height() * 33
      },
      333
    );
  }





  // в бд лежат секунды по UTC
  $(".time").each(function()
  {
    var time = parseInt($(this).text()+"000"),
      rightTime = getRightTime(time);
    if (/\d{13}/.test(time))
    {
      $(this).text(rightTime);
    }
  });











  //  KEYDOWN отправка
  $(window).on("keydown", function(e)
  {
    if (e.ctrlKey && e.which == 13)
    {
      $("#submit").trigger("click");
    }
  });






  function getUTC()
  {
    var date = new Date(),
      ms = date.getTime();
    return ms;
  }

  function getRightTime(ms)
  {
    var date = new Date(),
      difference = date.getTimezoneOffset() / 60000,
      msn = ms + difference,
      date = new Date(msn),
      day = String(date.getDate()),
      month = String(date.getMonth() + 1);
    if (day.length < 2)
    {
      day = "0" + day;
    }
    if (month.length < 2)
    {
      month = "0" + month;
    }
    date =
      day +
      "." +
      month +
      "." +
      " " +
      date.getHours() +
      ":" +
      date.getMinutes();
    return date;
  }

});
