function declOfNum(number, titles) {
 cases = [2, 0, 1, 1, 1, 2];
 return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
}

var nav = {
 go: function(a, b) {
  var url = b ? b : a;
  nav.loader(1);
  $('#push').text(0);
  $.get(url, function(data) {
   var response = data;
   var content_page = response.match(/<div id="page">([\s\S]*)<\/div>/i);
   var title_page = response.match(/<title>(.*?)<\/title>/i);
   $('#push_url').text(url);
   $('#page').html(content_page[1]);
   // меняем заголовок
   document.title = title_page[1].toString();
   // меняем url
   var url_min = url.toString().split('/');
   $('#push_url').text('/'+url_min[3]);
   if(!history.pushState) {
    location.hash = '/'+url_min[3];
    nav.loader('');
   } else {
    history.pushState(null, null, url);
    nav.loader('');
   }
   nav.noPushState();
   $.getScript('http://montytool.ru/js/other.js?'+Math.random());
   $.getScript('http://montytool.ru/js/placeholder.js?'+Math.random());
  });
 }, 
 loader: function(a) {
  a ? $('#loading').show().css({position: 'fixed', top: ($(window).height()/2 - 64), marginLeft: $(window).width()/2 + 47}) : $('#loading').hide();
 },
 noPushState: function() {
  
 }
}

var _black_bg = {
 _show: function() {
  $('body').append($('#black_bg').text() ? '' : '<div id="black_bg"> </div>');
  $('#black_bg').show();
 },
 _hide: function() {
  $('#black_bg').hide();
 }
}

var _box = {
 _show: function(obj) {
  var template = '\
   <div id="box">\
    <div id="box_content">\
     <div id="title">\
      <div id="left">\
       '+obj.title+'\
      </div>\
      <div id="right">\
       <a href="javascript://" onclick="_box._close()">Закрыть</a>\
      </div>\
     </div>\
     <div id="message">\
      '+obj.message+'\
     </div>\
     <div id="footer">\
      <span id="button_first"></span>\
      <span id="button_two"></span>\
     </div>\
    </div>\
   </div>\
  ';
  _black_bg._show();
  $('body').append($('#box').text() ? '' : '<div id="box"> </div>');
  $('#box').show().html(template);
  $('#box').css('width', obj.width);
  if(obj.footer == 2) $('#box #footer').hide();
  else $('#box #footer').show();
  $('#box #button_first').html(obj.first_button ? '<div onclick="'+obj.first_button_click+'" class="box_button_first_wrap"><div class="box_buttons box_button_first">'+obj.first_button+'</div></div>' : '');
  $('#box #button_two').html(obj.second_button ? '<div onclick="_box._close()" class="box_button_two_wrap"><div class="box_buttons box_button_two">'+obj.second_button+'</div></div>' : '');
  $('#box').css({position: 'fixed', top: ($(window).height() - $('#box_content').height())/2, left:($(window).width() - obj.width)/2});
 },
 _close: function() {
  _black_bg._hide();
  $('#box').hide().html(' ');
  $('#box #button_first').html(' ');
  $('#box #button_two').html(' ');
  $('#box #footer').show();
 }
}

var cnt_black = {
 _show: function(param) {
  if(param.title)
   var cnt_black_tmpl = '\
   <div id="cnt_black_main">\
    <div id="title">'+param.title+'</div>\
    <div id="text">'+param.text+'\</div>\
   </div>\
  ';
  else
   var cnt_black_tmpl = '\
   <div id="cnt_black_main">\
    <div id="text">'+param.text+'\</div>\
   </div>\
  ';
  $('body').append($('#cnt_black').html() ? '' : '<div id="cnt_black"></div>');
  $('#cnt_black').show().html(cnt_black_tmpl);
  $('#cnt_black').css({position: 'fixed', top: ($(window).height() - $('#cnt_black').height())/2, left:($(window).width() - 400)/2, width: 400});
  setTimeout(function() {
   $('#cnt_black').fadeOut(400);
  }, 5000);
 }
}

var mini_num = 0;
var mini_wnd = {
 _show: function(obj) {
  var mini_wnd_id = mini_num++;
  $('body').append($('.mini_wnd').html() ? '' : '<div class="mini_wnd"></div>');
  var template = '<div style="display: none;" id="mini_wnd_id'+mini_wnd_id+'" class="main '+obj.style+'">\
    <div class="title">'+obj.title+'</div>\
    <div class="text">\
     '+obj.text+'</b>\
    </div>\
   </div>';
   $('.mini_wnd').prepend(template);
   $('#mini_wnd_id'+mini_wnd_id).fadeIn(500);
   $('#mini_wnd_id'+mini_wnd_id).click(function() {
    mini_wnd._close(mini_wnd_id);
   });
   setTimeout(function() {
    $('#mini_wnd_id'+mini_wnd_id).fadeOut(300);
   }, 10000);
 },
 _close: function(id) {
  $('#mini_wnd_id'+id).fadeOut(300);
 }
}

setTimeout(function() {
 // добавление элементов
 $('body').append('\
  <div id="loading">\
   <div id="load"></div>\
  </div>\
  <div id="push">1</div>\
  <div id="push_url"></div>\
 ');
 // авторизация по нажатию на Enter
 $('#login, #password').keydown(function(event) {
  var keyCode = event.which;
  if(keyCode == 13) _users._login();
 });
 // регистрация по нажатию на Enter
 $('#reg_vk, #reg_login, #reg_password').keydown(function(event) {
  var keyCode = event.which;
  if(keyCode == 13) _users._reg();
 });
 // поиск заданий по нажатию на Enter
 $('#_tasks_search').keydown(function(event) {
  var keyCode = event.which;
  if(keyCode == 13) tasks._search();
 });
 // вкладки при добавлении нового задания
 $('.task_add a').click(function() {
  var id = $(this).attr('id');
  $('#task_error_table').hide();
  $('.task_add a').removeClass('active');
  $(this).addClass('active');
  $('div[class^="tab_add"]').hide();
  $('.'+id).show();
 });
 // считаем цену при добавлении задания
 $('#task_add .count_likes, #task_add .price_likes').keyup(function() { // лайки
  var count_page = $('.count_likes').val() * 1;
  var price_page = $('.price_likes').val() * 1;
  var result_points = count_page * price_page;
  $('#auto_coins_likes').text(result_points+' '+declOfNum(result_points, ['монета', 'монеты', 'монет']));
 });
 $('#task_add .count_reposts, #task_add .price_reposts').keyup(function() { // лайки
  var count_page = $('.count_reposts').val() * 1;
  var price_page = $('.price_reposts').val() * 1;
  var result_points = count_page * price_page;
  $('#auto_coins_reposts').text(result_points+' '+declOfNum(result_points, ['монета', 'монеты', 'монет']));
 });
 $('#task_add .count_friends, #task_add .price_friends').keyup(function() { // лайки
  var count_page = $('.count_friends').val() * 1;
  var price_page = $('.price_friends').val() * 1;
  var result_points = count_page * price_page;
  $('#auto_coins_friends').text(result_points+' '+declOfNum(result_points, ['монета', 'монеты', 'монет']));
 });
 $('#task_add .count_group, #task_add .price_group').keyup(function() { // лайки
  var count_page = $('.count_group').val() * 1;
  var price_page = $('.price_group').val() * 1;
  var result_points = count_page * price_page;
  $('#auto_coins_group').text(result_points+' '+declOfNum(result_points, ['монета', 'монеты', 'монет']));
 });
}, 1000);
$(document).ready(function() {
 $('#counter_live').html("<a href='http://www.liveinternet.ru/click' "+
      "target=_blank><img src='//counter.yadro.ru/hit?t19.6;r"+
      escape(document.referrer)+((typeof(screen)=="undefined")?"":
      ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
      screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
      ";"+Math.random()+
      "' alt='' title='LiveInternet: показано число просмотров за 24"+
      " часа, посетителей за 24 часа и за сегодня' "+
      "border='0' width='88' height='31'><\/a>");
});