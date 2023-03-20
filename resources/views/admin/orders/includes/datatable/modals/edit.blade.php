<script>
    $(function() {
        $("#order-edit-{{ $row->id }}-modal .product-select , #order-edit-{{ $row->id }}-modal .pc_number")
            .change(function() {
                let product_id = $("#order-edit-{{ $row->id }}-modal .product-select").val();

                let product = products.filter(e => e.id == product_id)[0];
                let pc_numbers = $("#order-edit-{{ $row->id }}-modal .pc_number").val();

                let price = calculePrice(product_id, pc_numbers);

                $("#order-edit-{{ $row->id }}-modal .prix").text(price);

                let info = `${product.min_pc_number} postes aux minimum`;
                $("#order-edit-{{ $row->id }}-modal .info_about_min_pc_number").text(info);
            });
    });
</script>
<div class="modal fade" id="order-edit-{{ $row->id }}-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form method="post"
                onsubmit=SendRequest(event,"{{ route('orders.update', $row->id) }}","{{ route('orders.index') }}");>
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        <i class="fa-solid fa-pen"></i> Modifier la Commande
                        #{{ $row->id }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errors"></div>
                    @csrf
                    @method('put')
                    <input type="hidden" name="doctor_id" value="{{ $row->doctor_id }}">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Réglement par :</label>
                                        <select name="payment_by" class="form-control">
                                            <option @selected($row->payment_by == $row->doctor->FAMNAME . ' ' . $row->doctor->SHORTNAME)
                                                value="{{ $row->doctor->FAMNAME }} {{ $row->doctor->SHORTNAME }}">
                                                {{ $row->doctor->FAMNAME }}
                                                {{ $row->doctor->SHORTNAME }}
                                            </option>
                                            <option value="MEDIS" @selected($row->payment_by == 'MEDIS')>MEDIS</option>
                                            <option value="ADWYA" @selected($row->payment_by == 'ADWYA')>ADWYA</option>
                                            <option value="OPALIA" @selected($row->payment_by == 'OPALIA')>OPALIA</option>
                                            <option value="VITAL" @selected($row->payment_by == 'VITAL')>VITAL</option>
                                            <option value="PHILADELPHIA" @selected($row->payment_by == 'PHILADELPHIA')>PHILADELPHIA
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Produit :</label>
                                        <select name="product_id" class="form-control product-select">
                                            <option value="" selected disabled hidden>Choisir</option>
                                            @foreach ($products as $product)
                                                <option @selected($product->id == $row->product_id) value="{{ $product->id }}">
                                                    {{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Licences :</label>
                                        <input type="text" class="form-control pc_number" name="licenses"
                                            value="{{ $row->licenses }}">
                                        <small class="info_about_min_pc_number"></small>
                                    </div>
                                    <div class="form-group">
                                        <label>OS :</label>
                                        <select name="os" class="form-control">
                                            <option @selected($row->os == 'Windows XP') value="Windows XP">Windows XP</option>
                                            <option @selected($row->os == 'Windows 7') value="Windows 7">Windows 7</option>
                                            <option @selected($row->os == 'Windows 8') value="Windows 8">Windows 8</option>
                                            <option @selected($row->os == 'Windows 10') value="Windows 10">Windows 10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date RDV </label>
                                        <input type="date" class="form-control" name="date"
                                            value="{{ date('Y-m-d', strtotime($row->date)) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>A :</label>
                                        <input type="time" class="form-control" name="time"
                                            value="{{ date('H:i', strtotime($row->date)) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Distance :</label>
                                        <div class="input-group">
                                            <input type="number" steps="0.1" class="form-control" name="distance"
                                                value="{{ $row->distance }}">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa-solid fa-location-dot"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Intervenant :</label>
                                        <select name="user_id" class="form-control">
                                            @foreach ($users as $user)
                                                <option @selected($user->id == $row->user_id) value="{{ $user->id }}">
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Note :</label>
                                        <textarea class="form-control" name="note" placeholder="ajouter une note">{{ $row->note }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Etat :</label>
                                <select name="status" class="form-control">
                                    <option @selected($row->status == 'installed') value="installed">Installé</option>
                                    <option @selected($row->status == 'in_progress') value="in_progress">En attend</option>
                                    <option @selected($row->status == 'canceled') value="canceled">Anulée</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Montant à payer :</label>
                                <h3>
                                    <span class="prix">{{ $row->price }}</span> DT
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>
