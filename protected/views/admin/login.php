<div style="width:100%" align="center">
    <form class="form-horizontal" method="POST" style="width:400px">
      <legend>Вход на сайт</legend>
      <?php if(count($user->getErrors())>0): ?>
        <div class="alert alert-error" >
            <?=CHtml::errorSummary($user); ?>
        </div>
      <?php endif; ?>
      <div class="control-group">
        <label class="control-label" for="inputEmail">Login</label>
        <div class="controls">
          <input type="text" id="inputLogin" placeholder="Username" name="username">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputPassword">Password</label>
        <div class="controls">
          <input type="password" id="inputPassword" placeholder="Password" name="password">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <label class="checkbox">
            <input type="checkbox"> Remember me
          </label>
          <button type="submit" class="btn">Войти</button>
        </div>
      </div>
    </form>
</div>