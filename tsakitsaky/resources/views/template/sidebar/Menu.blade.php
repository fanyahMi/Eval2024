<?php use App\Models\Utilisateurs; ?>
<ul class="sidebar-menu scrollable pos-r">

    @if(Utilisateurs::roleEquipe(session('roles')))
        <li class="nav-item">
            <a class="sidebar-link" href="/" >
            <span class="icon-holder">
                <i class="c-blue-500 ti-home"></i>
            </span>
            <span class="title">Acceuil</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="sidebar-link" href="{{url('liste-etapes-course')}}" >
            <span class="icon-holder">
                <i class="fas fa-chart-bar"></i>
            </span>
            <span class="title">Liste Etape</span>
            </a>
        </li>
    @endif

    @if(Utilisateurs::roleAdmin(session('roles')))

    <li class="nav-item">
        <a class="sidebar-link" href="{{url('clearBase')}}" >
        <span class="icon-holder">
            <i class=""></i>
        </span>
        <span class="title">Clear</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="sidebar-link" href="acceuil" >
        <span class="icon-holder">
            <i class="c-blue-500 ti-home"></i>
        </span>
        <span class="title">Acceuil</span>
        </a>
    </li>


    <li class="nav-item">
        <a class="sidebar-link" href="{{url('certificat')}}" >
        <span class="icon-holder">
            <i class="fas fas fa-box"></i>
        </span>
        <span class="title">Certificat</span>
        </a>
    </li>
        <li class="nav-item">
            <a class="sidebar-link" href="{{url('liste-des-etapes')}}" >
            <span class="icon-holder">
                <i class="fas fa-chart-bar"></i>
            </span>
            <span class="title">Liste Etape</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="sidebar-link" href="{{url('liste-des-penalites')}}" >
            <span class="icon-holder">
                <i class="fas fa-chart-bar"></i>
            </span>
            <span class="title">Liste penalité</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="sidebar-link" href="{{url('genererCategorie')}}" >
            <span class="icon-holder">
                <i class="fas fa-chart-bar"></i>
            </span>
            <span class="title">Generer Categorie</span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
              <span class="icon-holder">
                <i class="c-orange-500 ti-layout-list-thumb"></i>
              </span>
              <span class="title">Import</span>
              <span class="arrow">
                <i class="ti-angle-right"></i>
              </span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="sidebar-link" href="{{ url('importation-etapes-et-resultat') }}">Etapes et resultat</a>
              </li>
              <li>
                <a class="sidebar-link" href="{{url('importation-des-points')}}">Points</a>
              </li>
            </ul>
          </li>
    @endif

    <li class="nav-item dropdown">
        <a class="dropdown-toggle" href="javascript:void(0);">
          <span class="icon-holder">
            <i class="c-orange-500 ti-layout-list-thumb"></i>
          </span>
          <span class="title">Classemenet</span>
          <span class="arrow">
            <i class="ti-angle-right"></i>
          </span>
        </a>
        <ul class="dropdown-menu">
          <li>
            <a class="sidebar-link" href="{{url('classements-par-etape-par-equipe')}}">Etape</a>
          </li>
          <li>
            <a class="sidebar-link" href="{{url('classement-par-equipe-par-categorie')}}">Equipe</a>
          </li>
        </ul>
    </li>

</ul>
