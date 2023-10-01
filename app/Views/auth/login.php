<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.108.0">
  <title>Signin Template · Bootstrap v5.3</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
  <link href="<?= base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url(); ?>css/style.css">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="<?= base_url(); ?>css/sign-in.css" rel="stylesheet">
</head>

<body class="text-center">

  <main class="form-signin w-100 m-auto">
    <?php if (session()->getFlashdata('message')) : ?>
      <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('message'); ?>
      </div>
    <?php endif ?>
    <form action="/login" method="post">
      <!-- <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48" height="80" width="80" class="mb-4">
        <path fill="#FFED00" d="M31.75 1.74205C28.0885 1.53135 21.84 1.3137 15.6795 1.76418C13.6312 1.91397 11.8627 3.23803 11.1341 5.15288C8.0277 13.3169 6.54787 20.8474 5.9174 24.837C5.52188 27.3399 7.34104 29.5715 9.84314 29.7433C11.9813 29.8901 15.1216 30.0421 18.7883 30.0221C18.3976 33.1959 17.9905 37.4298 17.5864 41.9843C17.2245 46.0644 22.1306 48.5171 25.0508 45.388C32.5476 37.3552 39.4201 28.4222 43.1892 23.3312C45.2626 20.5306 43.4365 16.613 39.8961 16.5209C38.264 16.4784 36.2622 16.454 33.9067 16.4744C34.6034 13.4356 35.2332 10.1354 35.8122 6.94923C36.2824 4.36158 34.4289 1.8962 31.75 1.74205Z"></path>
      </svg>
      <h1 class="h3 mb-3 fw-normal">Administrator</h1>

      <div class="form-floating">
        <input type="email" class="form-control" id="inputUsername" placeholder="username" name="username">
        <label for="inputUsername">Username</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password">
        <label for="inputPassword">Password</label>
      </div>

      <!-- <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div> -->
      <button class="w-100 btn btn-lg btn-primary" name="login" value="LOGIN" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">MONELIS 2023</p>
    </form>
  </main>



</body>

</html>