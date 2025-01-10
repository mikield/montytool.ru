<div id="panel_wrap">
    <div id="inner">
     <div class="overflow">
      <div class="left left_width">
       <div id="logo_wrap">
        <a id="l" href="/tasks" onclick="nav.go(this); return false;">
         <div id="logo"></div>
        </a>
       </div>
       <div id="menu">
        <a<?if($page_name == 'add_tasks') echo ' class="active"';?> href="/tasks/add" onclick="nav.go(this); return false;">Новое задание</a>
        <a<?if($page_name == 'all_tasks') echo ' class="active"';?> href="/tasks" onclick="nav.go(this); return false;">Список заданий</a>
        <a href="javascript://" onclick="alert('Эта функция временно недоступна.')">Настройки</a>
        <a href="javascript://" onclick="alert('Эта функция временно недоступна.')">Помощь</a>
       </div>
       <span id="profile_wrap">
        <div id="profile_inner">
         <div id="avatar"><img src="<? echo $user_avatar; ?>"></div>
         <div id="fullname">
          <div id="name"><? echo $user_name.' '.mb_substr($user_surname, 0, 1, 'UTF-8').'.'; ?></div>
          <div id="my_id">id<? echo $vkid; ?></div>
         </div>
         <div id="balance">
          <a href="/settings/balance" onclick="nav.go(this); return false;"><? echo '<b>'.$user_points.'</b> '.declOfNum(abs($user_points), array('монета', 'монеты', 'монет')); ?></a>
         </div>
        </div>
       </span>
      </div>
      <div id="logout">
       <a href="/logout">выйти</a>
      </div>
     </div>    
    </div>
   </div>