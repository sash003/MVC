</div>


<footer>
  <img src="/template/img/chat.png" id="openChat" />
  <div id="littleMenu2">
    <img id="openMenu2" src="/template/img/menu6.png" alt="" />
    <div id="menuWrap2">
      <div id="menu2">
        <a href="/ru/books"><img src="/template/img/books.png" alt="" /> Акции</a>
        <a href="/ru"><img src="/template/img/logo.png" alt="" /> Каталог</a>
        <a href="/ru/frends"><img src="/template/img/news.png" alt="" /> Доставка</a>
        <a href="/ru/inspiration"><img src="/template/img/insp.png" alt="" /> Контакты</a>
      </div>
    </div>
  </div>
</footer>

<!-- ===== МОДАЛЬНАЯ КОРЗИНА ===== -->
<div class="modal" id="cartModal">
  <div class="modal-content">
    <span class="close" id="closeCart">&times;</span>
    <h3>Ваша корзина</h3>
    <div class="cart-items" id="cartItems"></div>
    <div class="checkout">
      <input type="text" id="customerName" placeholder="Ваше имя" required>
      <input type="text" id="customerPhone" placeholder="Телефон" required>
      <button class="btn" id="checkoutBtn">Оформить заказ</button>
    </div>
  </div>
</div>



<div id="chat-panel">
  <div id="chat-header"><img src="/template/img/5.png" />Чат</div>
  <div id="chat-body">
    <div id="chat-messages">
      <ul></ul>
    </div>
    <form id="chat-form" method="post">
      <input type="text" name="name" id="name" placeholder="Ваше имя (запомнит)" value="">
      <textarea id="chat-input" name="message_text" id="message_text" placeholder="Напишите сообщение..."></textarea>
      <button type="submit" id="submit">➤</button>
    </form>
  </div>
</div>


<audio src="/template/req/call_init.mp3" id="audio"></audio>


<img id="to_top" src="/template/img/top.png" alt="" /><img id="top" src="/template/img/top2.png" alt="" /><img id="bottom" src="/template/img/bottom.png" alt="" />

<script src="/template/js/jquery.min.js" type="text/javascript">
</script>
<script src="/template/js/prefixfree.min.js" type="text/javascript"></script>
<script src="/template/js/lightBox.js" type="text/javascript"></script>
<script src="/template/js/chat.js"></script>
<script src="/template/js/tweenmax.js" type="text/javascript"></script>
<script src="/template/js/carusel.js" type="text/javascript"></script>
<script src="/template/js/script.js" type="text/javascript"></script>

</body></html>