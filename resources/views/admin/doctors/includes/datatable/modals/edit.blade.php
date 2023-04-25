<div class="modal fade edit-client-modal" id="edit-doctor-{{ $row->RECORD_ID }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <form method="post" action="{{ route('doctors.update', $row->RECORD_ID) }}"
            onsubmit=SendRequest(event,"{{ route('doctors.update', $row->RECORD_ID) }}","{{ route('doctors.index') }}");>
            <div class="modal-content">
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modifier Médecin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errors"></div>
                    @csrf
                    @method('patch')
                    @csrf

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>CNAMID</label>
                                <input type="text" class="form-control" name="CNAMID" value="{{ $row->CNAMID }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>SPECIALITE</label>
                                <select name="SPECIALITE" class="form-control select2bs4 select2bs4-modal">
                                    @foreach ($specialites as $specialite)
                                        <option @selected($row->SPECIALITE == $specialite) value="{{ $specialite }}">
                                            {{ $specialite }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>SHORTNAME</label>
                                <input type="text" class="form-control" name="SHORTNAME"
                                    value="{{ $row->SHORTNAME }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>FAMNAME</label>
                                <input type="text" class="form-control" name="FAMNAME" value="{{ $row->FAMNAME }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>GOUVNAME</label>
                                <select name="GOUVNAME" class="form-control select2bs4 select2bs4-modal">
                                    @foreach ($gouvnames as $gouvname)
                                        <option @selected($row->gouvnames == $gouvname) value="{{ $gouvname }}">
                                            {{ $gouvname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>LOCALITE</label>
                                <select name="LOCALITE" class="form-control select2bs4 select2bs4-modal">
                                    @foreach ($localites as $localite)
                                        <option @selected($row->LOCALITE == $localite) value="{{ $localite }}">
                                            {{ $localite }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>ADRESSE</label>
                                <input type="text" class="form-control" name="ADRESSE" value="{{ $row->ADRESSE }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>GSM</label>
                                <input type="text" class="form-control" name="GSM" value="{{ $row->GSM }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>TELEPHONE</label>
                                <input type="text" class="form-control" name="TELEPHONE"
                                    value="{{ $row->TELEPHONE }}">
                            </div>
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
