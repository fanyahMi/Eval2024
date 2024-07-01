<div class="masonry-item col-md-12">
    <div class="bgc-white p-20 bd">
        <h4 class="c-grey-900"><b>Ajout penalitée</b></h4>
        <div class="mT-30">
            <form action="{{url('addPenalite')}}" method="post" >

                <!-- CSRF Token -->
                @csrf

                <!-- CSV File Field -->
                <div class="col-md-3">
                    <label for="etape_id" class="mR-10">Sélectionnez une etape</label>
                    <select class="form-control" id="etape_id" name="etape_id">
                        @foreach($etapes as $option)
                            <option value="{{ $option->id_etape }}" >{{ $option->etape }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="equipe_id" class="mR-10">Sélectionnez une equipe</label>
                    <select class="form-control" id="equipe_id" name="equipe_id">
                        @foreach($equipes as $option)
                            <option value="{{ $option->utilisateur_id }}" >{{ $option->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Excel File Field -->
                <div class="row mT-15">
                    <div class="col-md-3">
                        <label for="">Temps</label>
                        <input type="time" step="1" name="penalite" class="form-control" id="penalite" >
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <br>
                <button type="submit" class="btn btn-color" style="background: linear-gradient(to right, #364fcb, #4f6ad7);border: none;display: inline-block;">Ajouter</button>
            </form>
        </div>
    </div>
</div>
<div id="confirmationModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">&times;</span>
        <h2>Confirmation</h2>
      </div>
      <div class="modal-body">
        <p>Voulez-vous vraiment soumettre cette pénalité ?</p>
      </div>
      <div class="modal-footer">
        <button id="modalCancel" class="btn">Non</button>
        <button id="modalConfirm" class="btn">Oui</button>
      </div>
    </div>
  </div>

  <!-- Modal CSS -->
  <style>
  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
  }

  .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    animation-name: animatetop;
    animation-duration: 0.4s
  }

  @keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
  }

  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
  }

  .close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }

  .btn {
    padding: 10px 20px;
    border: none;
    cursor: pointer;
  }

  #modalCancel {
    background-color: #f44336;
    color: white;
  }

  #modalConfirm {
    background-color: #4CAF50;
    color: white;
  }
  </style>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script>
    $(document).ready(function() {
        var modal = document.getElementById("confirmationModal");
        var btnConfirm = document.getElementById("modalConfirm");
        var btnCancel = document.getElementById("modalCancel");
        var spanClose = document.getElementsByClassName("close")[0];

        $('form').on('submit', function(event) {
            event.preventDefault();
            modal.style.display = "block";
        });

        btnConfirm.onclick = function() {
            modal.style.display = "none";
            $('form').off('submit').submit();
        }

        btnCancel.onclick = function() {
            modal.style.display = "none";
        }

        spanClose.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });
</script>
