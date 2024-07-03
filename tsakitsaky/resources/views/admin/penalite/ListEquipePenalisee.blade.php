<div class="row mT-30">
    <div class="row mT-15">
      <div class="col-md-12">
          <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <div class="row">
                  <div class="col-md-6">
                      <h1 style="font-size: 20px;font-weight: bold" class="c-grey-900 mB-20">Listes des Pénalité des équipes  </h1>
                  </div>
                  <div class="col-md-2"></div>
              </div>

              <br>
              <div class="row">
                <div class="col-md-6">
                   <a href="{{url('ajout_de_penalite')}}" style="background: linear-gradient(to right, #364fcb, #4f6ad7);border: none;display: inline-block;" class="btn btn-primary">Ajouter pénalite</a>
                </div>
            </div>
            <br>
              <div class="row">
                  <div class="col-md-12">
                      <div id="table-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Etape</th>
                                        <th>Equipe</th>
                                        <th>Pénalité</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    @foreach($liste as $data)
                                        <tr>
                                            <td>{{ $data->etape }}</td>
                                            <td>{{ $data->nom }}</td>
                                            <td>{{ $data->penalite }}</td>
                                           <td>
                                                <form action="{{url('supprimerPenalite')}}" method="get">
                                                    <input type="hidden" name="id" value="{{$data->id_penalite}}">
                                                    <input type="submit" value="suprimer">
                                                </form></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                      </div>
                  </div>
              </div>
                        </div>
      </div>
  </div>
</div>
<!-- Modal HTML -->
<div id="confirmationModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">&times;</span>
        <h2>Confirmation</h2>
      </div>
      <div class="modal-body">
        <p>Voulez-vous vraiment supprimer cette pénalité ?</p>
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



