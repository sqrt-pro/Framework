<form method="POST" action="/login/">
  <label>
    Логин:
    <input type="text" name="auth[login]" />
  </label>

  <label>
    Пароль:
    <input type="password" name="auth[password]" />
  </label>

  <label><input type="checkbox" name="auth[remindme]" /> Запомнить меня</label>

  <button type="submit">Войти</button>
</form>