<div class="modal fade" id="order-show-{{ $row->id }}-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header main-bg">
                <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa-solid fa-list"></i> Commande
                    #{{ $row->id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <div class="errors"></div>
                    @csrf
                    <input type="hidden" class="form-control" name="doctor_id" value="{{ $row->RECORD_ID }}">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 style="margin-top: -13px;">Client : </h4>
                                    <hr />
                                    <div class="form-group">
                                        <label>Nom Client :</label>
                                        <input type="text"
                                            value="{{ $row->doctor->FAMNAME }} {{ $row->doctor->SHORTNAME }}"
                                            class="form-control" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Téléphone :</label>
                                        <input type="text" value="{{ $row->doctor->TELEPHONE }}" class="form-control"
                                            disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>CnamID:</label>
                                        <input type="text" value="{{ $row->doctor->CNAMID }}" class="form-control"
                                            disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Localité :</label>
                                        <input type="text" value="{{ $row->doctor->LOCALITE }}" class="form-control"
                                            disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Gouv :</label>
                                        <input type="text" value="{{ $row->doctor->GOUVNAME }}" class="form-control"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4 style="margin-top: -13px;">Produit : </h4>
                                    <hr />
                                    <div class="form-group">
                                        <label>Réglement par :</label>
                                        <input type="text" value="{{ $row->payment_by }}" class="form-control"
                                            disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Produit :</label>
                                        <input type="text" value="{{ $row->product->name }}" class="form-control"
                                            disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Licences :</label>
                                        <input type="text" value="{{ $row->licenses }}" class="form-control"
                                            disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>OS :</label>
                                        <input type="text" value="{{ $row->os }}" class="form-control"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4 style="margin-top: -13px;">Rendez-vous : </h4>
                                    <hr />
                                    <div class="form-group">
                                        <label>Date RDV </label>
                                        <input type="text" value="{{ $row->date }}" class="form-control"
                                            disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Distance :</label>
                                        <input type="text" value="{{ $row->distance }}" class="form-control"
                                            disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Intervenant :</label>
                                        <input type="text" value="{{ $row->user->name }}" class="form-control"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Note :</label>
                                        <textarea type="date" class="form-control" name="note" disabled>{{ $row->note }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Prix Produit :</label>
                                <h3>
                                    <span class="prix">{{ $row->price }}</span> DT
                                </h3>
                            </div>
                            <div class="form-group">
                                <label>Prix Déplacement :</label>
                                <h3>
                                    <span class="prix_deplacement">{{ $row->dep_price }}</span> DT
                                </h3>
                            </div>
                            <hr>
                            <div class="form-group  text-danger mt-4">
                                <label>Montant à payer :</label>
                                <h3>
                                    <span class="prix_total">{{ $row->price + $row->dep_price }}</span> DT
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <form method="post" action="{{ route('contract.store') }}">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $row->id }}">
                                <button class="btn btn-primary">
                                    <i class="fa-solid fa-cloud-arrow-down"></i>
                                    Télécharger le contrat
                                </button>

                                <a href="{{ route('bon-de-commande', $row) }}" class="btn btn-primary"><i
                                        class="fa-solid fa-cloud-arrow-down"></i> Télécharger le
                                    bon de commande</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
