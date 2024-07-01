<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title>Sign In</title>
    <style>
      #loader {
        transition: all 0.3s ease-in-out;
        opacity: 1;
        visibility: visible;
        position: fixed;
        height: 100vh;
        width: 100%;
        background: #fff;
        z-index: 90000;
      }

      #loader.fadeOut {
        opacity: 0;
        visibility: hidden;
      }

      .spinner {
        width: 40px;
        height: 40px;
        position: absolute;
        top: calc(50% - 20px);
        left: calc(50% - 20px);
        background-color: #333;
        border-radius: 100%;
        -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
        animation: sk-scaleout 1.0s infinite ease-in-out;
      }


    .error-message {
        color: red;
        margin-top: 5px;
    }

      @-webkit-keyframes sk-scaleout {
        0% { -webkit-transform: scale(0) }
        100% {
          -webkit-transform: scale(1.0);
          opacity: 0;
        }
      }

      @keyframes sk-scaleout {
        0% {
          -webkit-transform: scale(0);
          transform: scale(0);
        } 100% {
          -webkit-transform: scale(1.0);
          transform: scale(1.0);
          opacity: 0;
        }
      }
    </style>
  <script defer="defer" src="main.js"></script></head>
  <body class="app">
    <div id="loader">
      <div class="spinner"></div>
    </div>

    <script>
      window.addEventListener('load', function load() {
        const loader = document.getElementById('loader');
        setTimeout(function() {
          loader.classList.add('fadeOut');
        }, 300);
      });
    </script>
    <div class="peers ai-s fxw-nw h-100vh">
      <div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c " style='background-image: url("assets/static/images/istockphoto-1204568605-612x612.jpg")'>
        <div class="pos-a centerXY" style="display: none">
          <div class="bgc-white bdrs-50p pos-r" style="width: 120px; height: 120px;">
            <img class="pos-a centerXY" src="assets/static/images/logo.png" alt="">
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style="min-width: 320px;">
        <h4 class="fw-300  mB-40" id="login" style="color: #f93765;font-size: 1cm;letter-spacing: 2px;text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);text-transform: uppercase;font-family: 'Georgia', serif;border-bottom: 3px solid #DAA520;">Login</h4>
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
                <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                  <input type="checkbox" id="inputCall1" name="inputCheckboxesCall" class="peer">
                  <label for="inputCall1" class="peers peer-greed js-sb ai-c form-label">
                    <span class="peer peer-greed">Remember Me</span>
                  </label>
                </div>
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
</html>
