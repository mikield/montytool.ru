var _users = {
 _login: function() {
  var login = $('#login').val();
  var password = $('#password').val();
  $('#login_button .box_button_first').html('<div class="upload_inv"></div>');
  $.post('/auth', {
   _login: login,
   _password: password
  }, function(data) {
   var response = $.parseJSON(data);
   var error_code = response.error_code;
   var error_text = response.error_text;
   if(error_code == 2) {
    var error = '\
    <b>Не удается войти.</b>\
    <br />\
    <span style="padding-left: 1px;">Пожалуйста, проверьте правильность написания <b>логина</b> и <b>пароля</b>.</span>\
    ';
    _box._show({width: 500, title: 'Ошибка', message: error, second_button: 'Отмена'});
   } else if(error_code == 401) {
    var error = '\
    <b>Не удается установить cookies.</b>\
    <br />\
    <span style="padding-left: 1px;">В Вашем браузере отключены cookies. Продолжение невозможно.</span>\
    ';
    _box._show({width: 500, title: 'Ошибка', message: error, second_button: 'Отмена'}); 
   } else if(error_code == 402) {
    location.href = '/tasks';
   } else if(error_code == 1) {
    $('#login_button .box_button_first').html('<div class="upload_inv"></div>');
    location.href = '/tasks';
   }
   $('#login_button .box_button_first').html('Войти в систему');
  });
 },
 _reg: function() {
  var url = $('#reg_vk').val();
  var login = $('#reg_login').val();
  var password = $('#reg_password').val();
  $('#reg_error').hide().html('');
  $('#reg_button .box_button_first').html('<div class="upload_inv"></div>');
  $.post('/reg', {
   _url: url,
   _login: login,
   _password: password
  }, function(data) {
   var response = $.parseJSON(data);
   var error_code = response.error_code;
   var error_text = response.error_text;
   if(error_code == 3000) {
    var error = '\
    <div id="reg_error_table">\
     <b>Регистрация временно недоступна.</b>\
     <div class="text">Мы временно запретили регистрацию, так как новая версия MontyTool ещё не полностью готова.</div>\
    </div>';
    $('#reg_error').show().html(error);
   }
   else if(error_code == 300) {
    var error = '\
    <div id="reg_error_table">\
     <b>Пожалуйста, укажите ссылку на свою страницу ВКонтакте.</b>\
     <div class="text">Чтобы проверить, выполнили Вы задание или нет, нам необходимо знать Вашу страницу.</div>\
    </div>';
    $('#reg_error').show().html(error);
    $('#reg_vk').focus();
   } else if(error_code == 301) {
    var error = '\
    <div id="reg_error_table">\
     <b>Не удалось установить соединить с сервером ВКонтакте.</b>\
     <div class="text">Повторите попытку снова или попробуйте позже.</div>\
    </div>';
    $('#reg_error').show().html(error);
   } else if(error_code == 307) {
    var error = '\
    <div id="reg_error_table">\
     <b>Пожалуйста, придумайте логин.</b>\
     <div class="text">Логин может состоять только из латинских символов, цифр и некоторых знаков(-, @, .).</div>\
    </div>';
    $('#reg_error').show().html(error);
    $('#reg_login').focus();
   } else if(error_code == 308) {
    var error = '\
    <div id="reg_error_table">\
     <b>Пожалуйста, придумайте пароль.</b>\
     <div class="text">Пароль может состоять только из латинских символов, цифр и некоторых знаков(-, @, .).</div>\
    </div>';
    $('#reg_error').show().html(error);
    $('#reg_password').focus();
   } else if(error_code == 601 || error_code == 701) {
    var error = '\
    <div id="reg_error_table">\
     <b>Ошибка соединения с сервером.</b>\
     <div class="text">Повторите попытку снова или попробуйте позже.</div>\
    </div>';
    $('#reg_error').show().html(error);
   } else if(error_code == 600) {
    var error = '\
    <div id="reg_error_table">\
     <b>Такой логин уже занят.</b>\
     <div class="text">Пожалуйста, придумайте другой логин.</div>\
    </div>';
    $('#reg_error').show().html(error);
    $('#reg_login').focus();
   } else if(error_code == 700) {
    var error = '\
    <div id="reg_error_table">\
     <b>Такой пользователь уже зарегистрирован.</b>\
     <div class="text">Пользователь с такой ссылкой уже зарегистрирован на нашем сайте.</div>\
    </div>';
    $('#reg_error').show().html(error);
    $('#reg_vk').focus();
   } else if(error_code == 309) {
    var error = '\
    <div id="reg_error_table">\
     <b>Подтвердите, что страница '+url+' принадлежит Вам.</b>\
     <div class="text">Подпишитесь на <a href="http://vk.com/id152585671" target="_blank">vk.com/id152585671</a>. После завершения регистрации, можете отписаться.</div>\
    </div>';
    $('#reg_error').show().html(error);
   } else if(error_code == 1) {
    location.href = '/tasks';
   }
   $('#reg_button .box_button_first').html('Зарегистрироваться');
  });
 },
 _return_paswd_box: function() {
  var template = '\
   <div id="returned_error"></div>\
   <div id="return_password_box">\
    <input type="text" id="return_url" placeholder="Ссылка на страницу ВК">\
    <br />\
    <input type="password" id="return_password" placeholder="Новый пароль">\
    <div onclick="_users.return_paswd_post();" id="returnpaswd_button" class="box_button_first_wrap"><div class="box_buttons box_button_first">Восстановить аккаунт</div></div>\
   </div>\
  ';
  _box._show({width: 600, title: 'Восстановление аккаунта', message: template, footer: 2});
 },
 return_paswd_post: function() {
  $('#returnpaswd_button .box_button_first').html('<div class="upload_inv"></div>');
  $('#returned_error').html('');
  $.post('/returned', {
   _url: $('#return_url').val(),
   _password: $('#return_password').val()
  }, function(data) {
   var response = $.parseJSON(data);
   $('#returnpaswd_button .box_button_first').html('Восстановить аккаунт');
   if(response.error == '!url') {
    var error = '\
     <b>Пожалуйста, укажите ссылку на свою страницу ВКонтакте.</b>\
     <div class="text">Мы не сможем Вам помочь, не зная Вашу страницу ВК.</div>';
     $('#returned_error').html('<div style="margin-top: 0 !important; margin-bottom: 15px !important" id="reg_error_table">'+error+'</div>');
   } else if(response.error == '!password') {
    var error = '\
     <b>Пожалуйста, придумайте пароль.</b>\
     <div class="text">Пароль может состоять только из латинских символов, цифр и некоторых знаков(-, @, .).</div>';
     $('#returned_error').html('<div style="margin-top: 0 !important; margin-bottom: 15px !important" id="reg_error_table">'+error+'</div>');
   } else if(response.error == '!db') {
    var error = '\
     <b>Ошибка соединения с сервером.</b>\
     <div class="text">Повторите попытку снова или попробуйте позже.</div>';
    $('#returned_error').html('<div style="margin-top: 0 !important; margin-bottom: 15px !important" id="reg_error_table">'+error+'</div>');
   } else if(response.error == '!id') {
    var error = '\
     <b>Пользователь не найден.</b>\
     <div class="text">Такой пользователь не зарегистрирован на нашем сайте.</div>';
    $('#returned_error').html('<div style="margin-top: 0 !important; margin-bottom: 15px !important" id="reg_error_table">'+error+'</div>');
   } else if(response.error == '!status') {
    var error = '\
     <b>Пожалуйста, установите в статус следующий текст:</b>\
     <div class="text">'+response.text+'</div>';
    $('#returned_error').html('<div style="margin-top: 0 !important; margin-bottom: 15px !important" id="reg_error_table">'+error+'</div>');
   } else if(response.error == 'success') {
    var template_success = '<div style="margin-top: 0 !important; height: 47px !important" id="reg_error_table">\
     <b>Заявка на восстановление аккаунта одобрена.</b>\
     <div class="text">Ваш логин — <b>'+response.login+'</b> <div style="padding: 2px;"></div> Ваш пароль — <b>'+response.password+'</b></div>\
    </div>';
    _box._show({width: 600, title: 'Восстановление аккаунта', message: template_success, footer: 2});
   }
  });
 }
}

var tasks = {
 _next: function(cat, repost) {
  var _page_result = $('#num_page_tasks').val() * 1 + 1;
  $('#tasks_all_next').show().html('<div class="upload_inv"></div>');
  $.get('/tasks/next', {
   page: _page_result,
   cat: cat,
   repost: repost
  }, function(data) {
   var response = data;
   $('#num_page_tasks').val($('#num_page_tasks').val() * 1 + 1);
   $('#tasks_all_next').show().html('Показать ещё задания');
   if(response) $('#body_next_tasks').append(data);
   else $('#tasks_all_next, #tasks_all_next_wrap').hide();
  });
 },
 _search: function() {
  if($('#_tasks_search').val() < 5) {
   $('#tasks_all_list').show();
   $('#tasks_search_list').hide();
   return false;
  }
  nav.loader(1);
  $.get('/tasks/search', {
   _q: $('#_tasks_search').val()
  }, function(data) {
   nav.loader('');
   var response = data;
   if(response) {
    $('#tasks_all_list').hide();
    $('#tasks_search_list').show().html(data);
   } else {
    $('#tasks_all_list').hide();
    $('#tasks_search_list').show().html('<div style="color: gray; font-size: 12px; padding: 20px; text-align: center;">По Вашему запросу ничего не найдено...</div>');
   }
  });
 },
 _add: function(type, url, count, price, num) {
  $('#task_add').find('.tab_add'+num).find('#button_type'+num).hide();
  $('#task_add').find('.tab_add'+num).find('#button_type_load'+num).show().html('<div class="upload_inv"></div>');
  $('#task_add_error').hide();
  var _top = $('#top_task'+num).attr('checked') === true ? 1 : 0;
  $.post('/tasks/add_post', {
   type: type,
   url: url,
   count: count,
   price: price,
   top: _top
  }, function(data) {
  $('#task_add').find('.tab_add'+num).find('#button_type'+num).show();
  $('#task_add').find('.tab_add'+num).find('#button_type_load'+num).hide();
  var response = $.parseJSON(data);
  if(response.error_code == 301) {
   var error = '\
    <b>Не удалось соединиться с сервером ВКонтакте.</b>\
    <div class="text">Скорее всего, ВК не дал разрешение на получение информации или ссылка недоступна. Попробуйте позже.</div>';
   $('#task_add_error').show().html('<div id="task_error_table">'+error+'</div>');
  } else if(response.error_code == 300) {
   var error = '\
    <b>Ссылка указана неверно.</b>\
    <div class="text">Проверьте правильность введенной Вами ссылки. Возможно, что выбрана не та категория.</div>';
   $('#task_add_error').show().html('<div id="task_error_table">'+error+'</div>');
  } else if(response.error_code == 320) {
   var error = '\
    <b>Произошла ошибка.</b>\
    <div class="text">Значение в поле "количество" может быть от 1 до 200.</div>';
   $('#task_add_error').show().html('<div id="task_error_table">'+error+'</div>');
  } else if(response.error_code == 302) {
   var error = '\
    <b>Произошла ошибка.</b>\
    <div class="text">Не удалось соединиться с сервером. Попробуйте позже.</div>';
   $('#task_add_error').show().html('<div id="task_error_table">'+error+'</div>');
  } else if(response.error_code == 333) {
   var error = '\
    <b>Произошла ошибка.</b>\
    <div class="text">На Вашем счету недостаточно монет для размещения задания.</div>';
   $('#task_add_error').show().html('<div id="task_error_table">'+error+'</div>');
  } else if(response.error_code == 351) {
   var error = '\
    <b>Произошла ошибка.</b>\
    <div class="text">Значение в поле "количество" может быть от 5 до 1000.</div>';
   $('#task_add_error').show().html('<div id="task_error_table">'+error+'</div>');
  } else if(response.error_code == 352 || response.error_code == 353) {
   var error = '\
    <b>Произошла ошибка.</b>\
    <div class="text">Значение в поле "цена за выполнение" может быть от 5 до 60.</div>';
   $('#task_add_error').show().html('<div id="task_error_table">'+error+'</div>');
  } else if(response.error_code == 1) {
   nav.go('', '/tasks/my');
   mini_wnd._show({title: 'Задание добавлено', text: 'С Вашего счёта списано <b>'+response.points+' '+declOfNum(response.points, ['монета', 'монеты', 'монет'])+'</b>.', style: 'green'});
  }
  });
 },
 _check: function(id, comment) {
  $('#error_task'+id).html('');
  $('#task'+id).addClass('loading');
  $('#check'+id).html('<div style="margin-left: -2px;"><div class="upload_inv"></div></div>');
  $.get('/tasks/check', {
   id: id,
   comment: comment
  }, function(data) {
   var response = $.parseJSON(data);
   $('#task'+id).removeClass('loading');
   $('#check'+id).html('<b>Выполнить задание</b>');
   if(response.error_code == 4) {
    location.href = '/';
   } else if(response.error_code == 3) {
    mini_wnd._show({title: 'Ошибка', text: 'Вы уже выполняли это задание.', style: 'red'});
   } else if(response.error_code == 301) {
    mini_wnd._show({title: 'Ошибка', text: 'Не удалось соединиться с сервером ВК. Попробуйте позже.', style: 'red'});
   } else if(response.error_code == 6) {
    mini_wnd._show({title: 'Ошибка', text: 'Не удалось соединиться с сервером. Попробуйте позже.', style: 'red'});
   } else if(response.error_code == 9) {
    mini_wnd._show({title: 'Ошибка', text: 'Это задание достигло определенного количества участников.', style: 'red'});
   } else if(response.error_code == 2) {
    mini_wnd._show({title: 'Ошибка', text: 'Вы не выполнили задание.', style: 'red'});
   } else if(response.error_code == 1) {
    mini_wnd._show({title: 'Задание выполнено', text: 'На Ваш счёт зачислено <b>'+response.points+' '+declOfNum(response.points, ['монета', 'монеты', 'монет'])+'</b>.', style: 'green'});
    $('#task'+id).fadeOut(300);
   } else if(response.error_code == 21) {
    mini_wnd._show({title: 'Ошибка', text: 'Такого комментария нет в списке.', style: 'red'});
   } else {
    mini_wnd._show({title: 'Ошибка', text: 'Неизвестная ошибка. Попробуйте позже.', style: 'red'});
   }
  });
 },
 _del: function(id) {
  _box._show({width: 500, title: 'Удаление задания', message: 'Вы действительно хотите удалить задание? Это действие нельзя будет отменить. <br /> <br /> Оставшиеся монеты будут <b>возвращены</b> Вам на счёт.', first_button: 'Удалить', first_button_click: '_box._close(); tasks._del_post('+id+')', second_button: 'Отмена'});
 },
 _del_post: function(id) {
  $('#task'+id).addClass('loading');
  $('#check'+id).html('<div style="margin-left: -2px;"><div class="upload_inv"></div></div>');
  $.get('/tasks/del', {
   id: id
  }, function(data) {
   $('#task'+id).removeClass('loading');
   $('#check'+id).html('<b>Удалить задание</b>');
   var response = $.parseJSON(data);
   if(response.error == '!id') {
    mini_wnd._show({title: 'Ошибка', text: 'Неизвестная ошибка. Попробуйте позже.', style: 'red'});
   } else if(response.error == '!del') {
    mini_wnd._show({title: 'Ошибка', text: 'Это задание уже удалено.', style: 'red'});
   } else if(response.error == '!my') {
    mini_wnd._show({title: 'Ошибка', text: 'Неизвестная ошибка. Попробуйте позже.', style: 'red'});
   } else if(response.error == '!db') {
    mini_wnd._show({title: 'Ошибка', text: 'Не удалось соединиться с сервером. Попробуйте позже.', style: 'red'});
   } else if(response.error == '!uid') {
    location.href = '/';
   } else if(response.error == 'success') {
    $('#task'+id).hide();
    mini_wnd._show({title: 'Задание удалено', text: 'На Ваш счёт возвращено <b>'+response.points+' '+declOfNum(response.points, ['монета', 'монеты', 'монет'])+'</b>.', style: 'green'});
   } else {
    mini_wnd._show({title: 'Ошибка', text: 'Неизвестная ошибка. Попробуйте позже.', style: 'red'});
   }
  });
 },
 _ignored: function(id) {
  $('#task'+id).addClass('loading');
  $('#ignored'+id).html('<div style="margin-left: -2px;"><div class="upload_inv"></div></div>');
  $.get('/tasks/ignored', {
   id: id
  }, function(data) {
   var response = $.parseJSON(data);
   $('#task'+id).removeClass('loading');
   $('#ignored'+id).html('<b>Не показывать</b>');
   if(response.error == '!uid') {
    location.href = '/';
   } else if(response.error == '!id') {
    mini_wnd._show({title: 'Ошибка', text: 'Неизвестная ошибка. Попробуйте позже.', style: 'red'});
   } else if(response.error == '!ignored') {
    mini_wnd._show({title: 'Ошибка', text: 'Это задание уже проигнорировано.', style: 'red'});
   } else if(response.error == '!db') {
    mini_wnd._show({title: 'Ошибка', text: 'Не удалось соединиться с сервером. Попробуйте позже.', style: 'red'});
   } else if(response.error == 'success') {
    mini_wnd._show({title: 'Задание скрыто', text: 'Это задание больше не будет показываться Вам.', style: 'green'});
    $('#task'+id).hide();
   } else {
    mini_wnd._show({title: 'Ошибка', text: 'Неизвестная ошибка. Попробуйте позже.', style: 'red'});
   }
  });
 },
 _edit: function(id, count, price) {
  var template = '\
   <div id="task_info_table">\
     <b>Важная информация.</b>\
     <div class="text">В редактировании нельзя изменять значение поля "Цена за выполнение".\
     <div class="text_append">Чтобы этого избежать, сначала удалите задание, а потом снова добавьте с новыми значениями.</div>\
     </div>\
   </div>\
   <div class="legend">\
    <div class="label">Количество:</div>\
    <div class="field"><input style="background: #f1f1f1;" disabled="disabled" maxlength="3" type="text" class="count_field_edit_old" placeholder="'+count+'"> <span style="padding-left: 5px; padding-right: 5px;">+</span> <input maxlength="3" type="text" class="count_field_edit" placeholder="0"> <div onclick="tasks._edit_post('+id+')" class="box_button_first_wrap edit_task_save"><div class="box_buttons box_button_first"><span id="button_type_edit">Применить изменения — <b id="auto_coins_edit">0 монет</b></span></span><span id="button_type_load_edit"></span></div></div>\</div>\
   </div>\
   <div style="display: none;" class="field"><input maxlength="2" type="text" class="price_field_edit" value="'+price+'"></div>\
  ';
  _box._show({width: 600, title: 'Редактирование задания', message: template, second_button: 'Отмена', footer: 2});
  $('.count_field_edit, .price_field_edit').keyup(function() {
   var points = $('.count_field_edit').val() * 1 * $('.price_field_edit').val() * 1;
   var procents = (points/100) * 10;
   var points_result = Math.round(points + procents);
   $('#auto_coins_edit').text(points+' '+declOfNum(points, ['монета', 'монеты', 'монет']));
  });
 },
 _edit_post: function(id) {
  $('#button_type_edit').hide();
  $('#button_type_load_edit').show().html('<div class="upload_inv"></div>');
  $.post('/tasks/edit', {
   id: id,
   _count: $('.count_field_edit').val(),
   _price: $('.price_field_edit').val()
  }, function(data) {
   var response = $.parseJSON(data);
   $('#button_type_edit').show();
   $('#button_type_load_edit').hide();
   if(response.error == '!id') {
    mini_wnd._show({title: 'Ошибка', text: 'Неизвестная ошибка. Попробуйте позже.', style: 'red'});
   } else if(response.error == '!uid') {
    location.href = '/';
   } else if(response.error == '!count_min') {
    mini_wnd._show({title: 'Ошибка', text: 'Значение в поле <b>Количество</b> должно быть не менее 1.', style: 'red'});
   } else if(response.error == '!count_max') {
    mini_wnd._show({title: 'Ошибка', text: 'Значение в поле <b>Количество</b> должно быть не более 200.', style: 'red'});
   } else if(response.error == '!price_min') {
    mini_wnd._show({title: 'Ошибка', text: 'Значение в поле <b>Цена за выполнение</b> должно быть не менее 5.', style: 'red'});
   } else if(response.error == '!price_max') {
    mini_wnd._show({title: 'Ошибка', text: 'Значение в поле <b>Цена за выполнение</b> должно быть не более 10.', style: 'red'});
   } else if(response.error == '!points') {
    mini_wnd._show({title: 'Ошибка', text: 'На Вашем счете недостаточно монет для совершения операции.', style: 'red'});
   } else if(response.error == '!db') {
    mini_wnd._show({title: 'Ошибка', text: 'Не удалось соединиться с сервером. Попробуйте позже.', style: 'red'});
   } else if(response.error == '!del') {
    mini_wnd._show({title: 'Ошибка', text: 'Это задание удалено. Продолжение невозможно.', style: 'red'});
   } else if(response.error == '!success') {
    mini_wnd._show({title: 'Ошибка', text: 'Необходимо указать новое значение в поле <b>Количество</b>, т.к. задание завершено.', style: 'red'});
   } else if(response.error == 'success') {
    nav.go('', '/tasks/my');
    _box._close();
    mini_wnd._show({title: 'Задание изменено', text: 'С Вашего счета '+declOfNum(response.points, ['списана', 'списано', 'списано'])+' <b>'+response.points+' '+declOfNum(response.points, ['монета', 'монеты', 'монет'])+'</b>.', style: 'green'});
   }
  });
 }
}

var complaint = {
 _add: function(id, eid) {
  $('#btn_complt2'+eid).html('<div class="upload_inv"></div>');
  $.post('/tasks/complaints_post', {
   id: id,
   eid: eid
  }, function(data) {
   $('#btn_complt2'+eid).html('Оштрафовать на 1000 монет');
   if(data == 1) {
    $('#btn_complt'+eid).hide();
   }
  });
 }
}

var task_check = {
 _like: function(id) {
  run_task = window.open('http://montytool.ru/tasks/go?id='+id, 'run_task', 'width=860, height=500, top='+((screen.height-500)/2)+',left='+((screen.width-860)/2)+', resizable=yes, scrollbars=no, status=yes');
  var run_task_int = setInterval(function() {
   if(run_task.closed) {
    clearInterval(run_task_int);
    tasks._check(id);
   }
  }, 50);
 },
 _repost: function(id) {
  run_task = window.open('http://montytool.ru/tasks/go?id='+id, 'run_task', 'width=860, height=500, top='+((screen.height-500)/2)+',left='+((screen.width-860)/2)+', resizable=yes, scrollbars=no, status=yes');
  var run_task_int = setInterval(function() {
   if(run_task.closed) {
    clearInterval(run_task_int);
    tasks._check(id);
   }
  }, 50);
 },
 _friend: function(id) {
  run_task = window.open('http://montytool.ru/tasks/go?id='+id, 'run_task', 'width=860, height=500, top='+((screen.height-500)/2)+',left='+((screen.width-860)/2)+', resizable=yes, scrollbars=no, status=yes');
  var run_task_int = setInterval(function() {
   if(run_task.closed) {
    clearInterval(run_task_int);
    tasks._check(id);
   }
  }, 50);
 },
 _group: function(id) {
  run_task = window.open('http://montytool.ru/tasks/go?id='+id, 'run_task', 'width=860, height=500, top='+((screen.height-500)/2)+',left='+((screen.width-860)/2)+', resizable=yes, scrollbars=no, status=yes');
  var run_task_int = setInterval(function() {
   if(run_task.closed) {
    clearInterval(run_task_int);
    tasks._check(id);
   }
  }, 50);
 },
 _new_comment: function(id, text, url) {
  _box._show({width: 700, title: 'Оставить комментарий', message: '<div id="box_comment">Перейдите по ссылке <a href="javascript://" onclick="task_check._comment('+id+')"><b>vk.com/'+url+'</b></a> и оставьте следующий комментарий: <div id="comment">'+text+'</div></div>', first_button: 'Готово', first_button_click: '_box._close();tasks._check('+id+',$(\'#comment_hide'+id+'\').text())', second_button: 'Отмена'});
 },
 _comment: function(id) {
  run_task = window.open('http://montytool.ru/tasks/go?id='+id, 'run_task', 'width=860, height=500, top='+((screen.height-500)/2)+',left='+((screen.width-860)/2)+', resizable=yes, scrollbars=no, status=yes');
 }
}