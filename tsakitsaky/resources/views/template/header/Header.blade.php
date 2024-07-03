<div class="header navbar">
          <div class="header-container">
            <ul class="nav-left">
              <li>
                <a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);">
                  <i class="ti-menu"></i>
                </a>
              </li>
              <li class="search-box">
                <a class="search-toggle no-pdd-right" href="javascript:void(0);">
                  <i class="search-icon ti-search pdd-right-10"></i>
                  <i class="search-icon-close ti-close pdd-right-10"></i>
                </a>
              </li>
              <li class="search-input">
                <input class="form-control" type="text" placeholder="Search...">
              </li>
            </ul>
            <ul class="nav-right">
              <li class="dropdown">
                <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                  <div class="peer mR-10">
                    <img class="w-2r bdrs-50p" src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png" alt="">
                  </div>
                  <div class="peer">
                    <span class="fsz-sm c-grey-900">{{ session('name')  }}</span>
                  </div>
                </a>
                <ul class="dropdown-menu fsz-sm" aria-labelledby="dropdownMenuLink">

                  <li role="separator" class="divider"></li>
                  <li>
                        @if(session('id_utilisateurEquipe'))
                            <a href="{{ url('/logout-Equipe') }}" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-power-off mR-10"></i>
                            <span>Logout Equipe</span>
                          </a>
                        @endif
                        @if(session('id_utilisateurAdmin'))
                            <a href="{{ url('logoutAdmin') }}" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-power-off mR-10"></i>
                            <span>Logout</span>
                          </a>
                        @endif
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
