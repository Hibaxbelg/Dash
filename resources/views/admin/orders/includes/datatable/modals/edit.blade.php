<script>
    $(function() {
        function aff_prix_total() {
            let prix_deplacement = Number($("#order-edit-{{ $row->id }}-modal .prix_deplacement")
                .text());
            let prix_product = Number($("#order-edit-{{ $row->id }}-modal .prix").text());
            prix = (prix_deplacement + prix_product).toFixed(2);

            console.log(`prix_deplacement ${prix_deplacement}`)
            console.log(`prix_product ${prix_product}`)
            console.log(`prix ${prix}`)

            $("#order-edit-{{ $row->id }}-modal .prix_total").text(prix);
        }

        $("#order-edit-{{ $row->id }}-modal input[name='distance']").change(function() {
            let km = $(this).val();
            let prix = caclprixDeplacement(km);
            $("#order-edit-{{ $row->id }}-modal .prix_deplacement").text(prix);
            aff_prix_total();
        });

        $("#order-edit-{{ $row->id }}-modal .product-select , #order-edit-{{ $row->id }}-modal .pc_number")
            .change(function() {
                let product_id = $("#order-edit-{{ $row->id }}-modal .product-select").val();

                let product = products.filter(e => e.id == product_id)[0];
                let pc_numbers = $("#order-edit-{{ $row->id }}-modal .pc_number").val();

                let price = (calculePrice(product_id, pc_numbers)).toFixed(2);

                $("#order-edit-{{ $row->id }}-modal .prix").text(price);

                let info = `${product.min_pc_number} postes aux minimum`;
                $("#order-edit-{{ $row->id }}-modal .info_about_min_pc_number").text(info);

                aff_prix_total();

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
                                        <label>Distance (EN KM) :</label>
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
                                    <div class="form-group">
                                        <label>Etat :</label>
                                        <select name="status" class="form-control">
                                            <option @selected($row->status == 'installed') value="installed">Installé</option>
                                            <option @selected($row->status == 'in_progress') value="in_progress">En attente</option>
                                            <option @selected($row->status == 'canceled') value="canceled">Anulée</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>Element de la formation :</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-check mt-2">
                                                <input @checked(in_array(1, json_decode($row->formation ?? '[]'))) name="formation[]" value="1"
                                                    type="checkbox" class="form-check-input">
                                                <label>Nv-Patient + TTT</label>
                                            </div>
                                            <div class="form-group form-check">
                                                <input @checked(in_array(2, json_decode($row->formation ?? '[]'))) name="formation[]" value="2"
                                                    type="checkbox" class="form-check-input">
                                                <label>Nv-PatientAPCI + TTT</label>
                                            </div>
                                            <div class="form-group form-check">
                                                <input @checked(in_array(3, json_decode($row->formation ?? '[]'))) name="formation[]" value="3"
                                                    type="checkbox" class="form-check-input">
                                                <label>Visualisation du bordereau - Explication du '.txt' +</label>
                                            </div>
                                            <div class="form-group form-check">
                                                <input @checked(in_array(4, json_decode($row->formation ?? '[]'))) name="formation[]" value="4"
                                                    type="checkbox" class="form-check-input">
                                                <label>Exemple de suivi réguilier</label>
                                            </div>
                                            <div class="form-group form-check">
                                                <input @checked(in_array(5, json_decode($row->formation ?? '[]'))) name="formation[]" value="5"
                                                    type="checkbox" class="form-check-input">
                                                <label>Base médicamenteuse et recherche</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-check">
                                                <input @checked(in_array(6, json_decode($row->formation ?? '[]'))) name="formation[]" value="6"
                                                    type="checkbox" class="form-check-input">
                                                <label>Recette quotidienne / mensuelle</label>
                                            </div>
                                            <div class="form-group form-check">
                                                <input @checked(in_array(7, json_decode($row->formation ?? '[]'))) name="formation[]" value="7"
                                                    type="checkbox" class="form-check-input">
                                                <label>Montrer les videos de DVD et du site</label>
                                            </div>
                                            <div class="form-group form-check">
                                                <input @checked(in_array(8, json_decode($row->formation ?? '[]'))) name="formation[]" value="8"
                                                    type="checkbox" class="form-check-input">
                                                <label>Démo de Quick support</label>
                                            </div>
                                            <div class="form-group form-check">
                                                <input @checked(in_array(9, json_decode($row->formation ?? '[]'))) name="formation[]" value="9"
                                                    type="checkbox" class="form-check-input">
                                                <label>Insistance de contacter la HOTLINE</label>
                                            </div>
                                            <div class="form-group form-check">
                                                <input @checked(in_array(10, json_decode($row->formation ?? '[]'))) name="formation[]" value="10"
                                                    type="checkbox" class="form-check-input">
                                                <label>Générer le rapport récapitulatif</label>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label>Formateur</label>
                                        <input type="text" class="form-control" name="formateur"
                                            value="{{ $row->formateur }}">
                                    </div>


                                    <label>Qualité :</label>
                                    <div class="form-group form-check form-check-inline">
                                        <input @checked($row->qualite == 1) class="form-check-input" type="radio"
                                            value="1" name="qualite">
                                        <label class="form-check-label">
                                            Bonne
                                        </label>
                                    </div>
                                    <div class="form-group form-check form-check-inline">
                                        <input @checked($row->qualite == 2) class="form-check-input" type="radio"
                                            value="2" name="qualite">
                                        <label class="form-check-label">
                                            Acceptable
                                        </label>
                                    </div>
                                    <div class="form-group form-check form-check-inline">
                                        <input @checked($row->qualite == 3) class="form-check-input" type="radio"
                                            value="3" name="qualite">
                                        <label class="form-check-label">
                                            Mauvaise
                                        </label>
                                    </div>
                                    <div class="form-group form-check form-check-inline">
                                        <input @checked($row->qualite == 4) class="form-check-input" type="radio"
                                            value="4" name="qualite">
                                        <label class="form-check-label">
                                            Hors vue
                                        </label>
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
</div>
