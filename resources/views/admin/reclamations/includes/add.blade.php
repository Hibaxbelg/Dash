@pushIf(count($errors) > 0, 'scripts')
<script>
    $("#add-reclamation").modal()
</script>
@endPushIf
@push('scripts')
<script>
    $(document).ready(function() {
        // Retrieve the CSRF token value
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Set the CSRF token in the header of all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        // changes
        $('#SPECIALITE').change(function() {
            console.error('ajax SPECIALITE')
            var SPECIALITE = $(this).val();
            var selectGOUVNAME = document.getElementById('GOUVNAME');
            var GOUVNAME = selectGOUVNAME.value;

            if (SPECIALITE) {
                $.ajax({
                    url: '/doctors/search',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        SPECIALITE: SPECIALITE,
                        GOUVNAME: GOUVNAME
                    },
                    success: function(data) {
                        $('#doctor').empty();
                        $.each(data, function(key, value) {
                            $('#doctor').append('<option value="' + value.CNAMID + '">' + value.FAMNAME + '</option>');
                        });
                    }
                });
            }
        });

        $('#GOUVNAME').change(function() {
            var GOUVNAME = $(this).val();
            var selectSPECIALITE = document.getElementById('SPECIALITE');
            var SPECIALITE = selectSPECIALITE.value;

            if (GOUVNAME) {
                $.ajax({
                    url: '/doctors/search',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        SPECIALITE: SPECIALITE,
                        GOUVNAME: GOUVNAME
                    },
                    success: function(data) {
                        $('#doctor').empty();
                        $.each(data, function(key, value) {
                            $('#doctor').append('<option value="' + value.CNAMID + '">' + value.FAMNAME + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>
@endPush
@php
$items = DB::table('doctors')->select('SPECIALITE')->distinct()->get();
$gouvs = DB::table('doctors')->select('GOUVNAME')->distinct()->get();
@endphp
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-reclamation">
    <i class="fa-solid fa-square-plus"></i> Ajouter réclamation
</button>

<div class="modal fade" id="add-reclamation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('reclamations.store') }}">
            <div class="modal-content">
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ajouter reclamation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <i class="fa-solid fa-circle-xmark"></i> {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>SPECIALITE :</label>
                                <select id="SPECIALITE" name="SPECIALITE" class="form-control">
                                    <option>Select </option>
                                    @foreach ( $items as $user)
                                    <option value="{{ $user->SPECIALITE }}">{{ $user->SPECIALITE }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>GOUVNAME :</label>
                                <select id="GOUVNAME" name="GOUVNAME" class="form-control">
                                    @foreach ( $gouvs as $user)
                                    <option value="{{ $user->GOUVNAME }}">{{ $user->GOUVNAME }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Doctors :</label>
                                <select id="doctor" name="cnamId" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Objet :</label>
                                <input type="text" class="form-control" name="objet" value="{{ old('objet') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Solution :</label>
                                <input type="text" class="form-control" name="solution"
                                    value="{{ old('solution') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <label>description :</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="description"
                                    value="{{ old('description') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Intervenant :</label>
                            <select name="user_id" class="form-control">
                                @foreach (App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Confirmer</button>
                </div>
        </form>

    </div>
</div>
