<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title>Login Equipe</title>
    <link href="{{ asset('assets/css/login.min.css') }}" rel="stylesheet" />
  </head>
  <body class="app">
    <div id="loader">
      <div class="spinner"></div>
    </div>


    <div class="peers ai-s fxw-nw h-100vh">
      <div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c " style='background-image: url("assets/static/images/istockphoto-1204568605-612x612.jpg")'>
        <div class="pos-a centerXY" style="display: none">
          <div class="bgc-white bdrs-50p pos-r" style="width: 120px; height: 120px;">
            <img class="pos-a centerXY" src="assets/static/images/logo.png" alt="">
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style="min-width: 320px;">
        <h1 class="fw-300  mB-40" id="login"
        style="color: #f93765;font-size: 1cm;letter-spacing:
        2px;text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);text-transform: uppercase;font-family:
        'Georgia', serif;border-bottom: 3px solid #DAA520;">Login Equipe</h1>
        <form action="{{ url('siginEquipe') }}" method="POST">
            @csrf
            <div class="mb-3">

                <label style="font-family: 'Georgia', serif;font-size: 1.2em;" class="text-normal form-label">Identifiant</label>
                <input type="text" class="form-control" name="email" value="equipeA" required>
            </div>
            <div class="mb-3">
                <label style="font-family: 'Georgia', serif;font-size: 1.2em;" class="text-normal form-label" >Password</label>
                <input type="password" class="form-control" name="password" required value="equipeA">
            </div>
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
          <div class="">
            <div class="peers ai-c jc-sb fxw-nw">
              <div class="peer">
              </div>
              <div class="peer">
                <button style="background: linear-gradient(to right, #f93765, #fd695f);border: none;display: inline-block;" class="btn btn-color">Login</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </body>
  <script defer="defer" src="main.js"></script>
  <script src="{{ asset('assets/js/login.js') }}"></script>
</html>
