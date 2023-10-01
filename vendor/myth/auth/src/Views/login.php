<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<main class="form-signin w-100 m-auto">
  <form action="<?= url_to('login') ?>" method="post">
    <?= csrf_field() ?>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48" height="80" width="80" class="mb-4">
      <path fill="#FFED00" d="M31.75 1.74205C28.0885 1.53135 21.84 1.3137 15.6795 1.76418C13.6312 1.91397 11.8627 3.23803 11.1341 5.15288C8.0277 13.3169 6.54787 20.8474 5.9174 24.837C5.52188 27.3399 7.34104 29.5715 9.84314 29.7433C11.9813 29.8901 15.1216 30.0421 18.7883 30.0221C18.3976 33.1959 17.9905 37.4298 17.5864 41.9843C17.2245 46.0644 22.1306 48.5171 25.0508 45.388C32.5476 37.3552 39.4201 28.4222 43.1892 23.3312C45.2626 20.5306 43.4365 16.613 39.8961 16.5209C38.264 16.4784 36.2622 16.454 33.9067 16.4744C34.6034 13.4356 35.2332 10.1354 35.8122 6.94923C36.2824 4.36158 34.4289 1.8962 31.75 1.74205Z"></path>
    </svg>
    <h1 class="h3 mb-3 fw-normal text-white">LOGIN</h1>

    <?= view('Myth\Auth\Views\_message_block') ?>

    <?php if ($config->validFields === ['email']) : ?>
      <div class="form-floating">
        <input type="email" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.email') ?>">
        <label for="login"><?= lang('Auth.email') ?></label>
        <div class="invalid-feedback">
          <?= session('errors.login') ?>
        </div>
      </div>
    <?php else : ?>
      <div class="form-floating">
        <input type="text" name="login" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.emailOrUsername') ?>">
        <label for="login"><?= lang('Auth.emailOrUsername') ?></label>
        <div class="invalid-feedback">
          <?= session('errors.login') ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="form-floating">
      <input type="password" name="password" class="form-control  <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>">
      <label for="password"><?= lang('Auth.password') ?></label>
      <div class="invalid-feedback">
        <?= session('errors.password') ?>
      </div>
    </div>

    <?php if ($config->allowRemembering) : ?>
      <div class="checkbox mb-3">
        <label class="form-check-label">
          <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
          <?= lang('Auth.rememberMe') ?>
        </label>
      </div>
    <?php endif; ?>

    <br>

    <button type="submit" class="w-100 btn btn-lg btn-primary"><?= lang('Auth.loginAction') ?></button>

    <hr>

    <?php if ($config->allowRegistration) : ?>
      <p class="text-white"><a class="text-white" href="<?= url_to('register') ?>"><?= lang('Auth.needAnAccount') ?></a></p>
    <?php endif; ?>
    <?php if ($config->activeResetter) : ?>
      <p><a href="<?= url_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a></p>
    <?php endif; ?>

  </form>
</main>

<?= $this->endSection() ?>