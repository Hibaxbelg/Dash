@pushIf(count($errors) > 0, 'scripts')
<script>
    $("#add-doctor").modal()
</script>
@endPushIf

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-doctor">
    <i class="fa-solid fa-square-plus"></i> Ajouter Médecin
</button>

<div class="modal fade" id="add-doctor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" action="{{ route('doctors.store') }}">
            <div class="modal-content">
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ajouter Médecin</h5>
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
                        <div class="col-6">
                            <div class="form-group">
                                <label>CNAMID</label>
                                <input type="text" class="form-control" name="CNAMID" value="{{ old('CNAMID') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>SPECIALITE</label>
                                <select name="SPECIALITE" class="form-control select2bs4">
                                    @foreach ($specialites as $specialite)
                                        <option value="{{ $specialite }}">{{ $specialite }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>SHORTNAME</label>
                                <input type="text" class="form-control" name="SHORTNAME"
                                    value="{{ old('SHORTNAME') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>FAMNAME</label>
                                <input type="text" class="form-control" name="FAMNAME" value="{{ old('FAMNAME') }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>GOUVNAME</label>
                                <select name="GOUVNAME" class="form-control select2bs4">
                                    @foreach ($gouvnames as $gouvname)
                                        <option value="{{ $gouvname }}">{{ $gouvname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>LOCALITE</label>
                                <select name="LOCALITE" class="form-control select2bs4">
                                    @foreach ($localites as $localite)
                                        <option value="{{ $localite }}">{{ $localite }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>ADRESSE</label>
                                <input type="text" class="form-control" name="ADRESSE" value="{{ old('ADRESSE') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>GSM</label>
                                <input type="text" class="form-control" name="GSM" value="{{ old('GSM') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>TELEPHONE</label>
                                <input type="text" class="form-control" name="TELEPHONE"
                                    value="{{ old('TELEPHONE') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
        </form>

    </div>
</div>
