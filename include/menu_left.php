<div id="menu">
      <div class="links">
       <a<?if($page_name == 'my_tasks') echo ' class="active"';?> href="/tasks/my" onclick="nav.go(this); return false;">Мои задания</a>
       <a<?if($page_name == 'all_tasks') echo ' class="active"';?> href="/tasks" onclick="nav.go(this); return false;">Все задания</a>
       <a href="javascript://" onclick="alert('Смотреть свои штрафы можно будет позднее.')">Мои штрафы — <? echo $complaints; ?></a>
      </div>
      <div id="news_left">
       <div id="title">Новости</div>
       <div id="text">
        Сайт на глобальном обновлении. Чтобы не закрывать его, мы оставляем эту версию для использования. Обновится всё через 4 дня. Выполняйте задания, накапливайте монеты, чтобы в новой версии похвастаться достижениями! Сайт станет полноценным!
       </div>
      </div>
     </div>