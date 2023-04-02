<script>
    $(function() {

        function aff_prix_total() {
            let prix_deplacement = Number($("#create-order-{{ $row->RECORD_ID }} .prix_deplacement").text());
            let prix_product = Number($("#create-order-{{ $row->RECORD_ID }} .prix").text());
            prix = (prix_deplacement + prix_product).toFixed(2);

            console.log(`prix_deplacement ${prix_deplacement}`)
            console.log(`prix_product ${prix_product}`)
            console.log(`prix ${prix}`)

            $("#create-order-{{ $row->RECORD_ID }} .prix_total").text(prix);
        }

        $("#create-order-{{ $row->RECORD_ID }} input[name='distance']").change(function() {
            let km = $(this).val();
            let prix = caclprixDeplacement(km);
            $("#create-order-{{ $row->RECORD_ID }} .prix_deplacement").text(prix);
            aff_prix_total();
        });

        $("#create-order-{{ $row->RECORD_ID }} .product-select , #create-order-{{ $row->RECORD_ID }} .pc_number")
            .change(function() {
                let product_id = $("#create-order-{{ $row->RECORD_ID }} .product-select").val();

                let product = products.filter(e => e.id == product_id)[0];
                let pc_numbers = $("#create-order-{{ $row->RECORD_ID }} .pc_number").val();

                let price = (calculePrice(product_id, pc_numbers)).toFixed(2);

                $("#create-order-{{ $row->RECORD_ID }} .prix").text(price);

                let info = `${product.min_pc_number} postes aux minimum`;
                $("#create-order-{{ $row->RECORD_ID }} .info_about_min_pc_number").text(info);
                aff_prix_total();
            });
    });
</script>

<div class="modal fade" id="create-order-{{ $row->RECORD_ID }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form method="post" action='{{ route('orders.store') }}'
                onsubmit=SendRequest(event,"{{ route('orders.store') }}","{{ route('orders.index') }}");>
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa-solid fa-cart-plus"></i> Ajouter une
                        commande</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="errors"></div>
                    @csrf
                    <input type="hidden" class="form-control" name="doctor_id" value="{{ $row->RECORD_ID }}">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Réglement par :</label>
                                        <select name="payment_by" class="form-control">
                                            <option value="{{ $row->FAMNAME }} {{ $row->SHORTNAME }}">
                                                {{ $row->FAMNAME }}
                                                {{ $row->SHORTNAME }}
                                            </option>
                                            <option value="MEDIS">MEDIS</option>
                                            <option value="ADWYA">ADWYA</option>
                                            <option value="OPALIA">OPALIA</option>
                                            <option value="VITAL">VITAL</option>
                                            <option value="PHILADELPHIA">PHILADELPHIA</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Produit :</label>
                                        <select name="product_id" class="form-control product-select">
                                            <option value="" selected disabled hidden>Choisir</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Licences :</label>
                                        <input type="text" class="form-control pc_number" name="licenses">
                                        <small class="info_about_min_pc_number"></small>
                                    </div>
                                    <div class="form-group">
                                        <label>OS :</label>
                                        <select name="os" class="form-control">
                                            <option value="Windows XP">Windows XP</option>
                                            <option value="Windows 7">Windows 7</option>
                                            <option value="Windows 8">Windows 8</option>
                                            <option value="Windows 10">Windows 10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date RDV </label>
                                        <input type="date" class="form-control" name="date">
                                    </div>
                                    <div class="form-group">
                                        <label>A :</label>
                                        <input type="time" class="form-control" name="time">
                                    </div>
                                    <div class="form-group">
                                        <label>Distance (en KM) :</label>
                                        <div class="input-group">
                                            <input type="number" steps="0.1" class="form-control" name="distance">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <a target="_blank"
                                                        href="https://www.google.com/maps/dir/{{ $row->ADRESSE }},{{ $row->LOCALITE }}/37.2731977,9.8683245">
                                                        <i class="fa-solid fa-location-dot"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <small class="d-block w-100">{{ $row->ADRESSE }} ,
                                                {{ $row->LOCALITE }}</small>
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Note :</label>
                                        <textarea type="date" class="form-control" name="note" placeholder="ajouter une note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Prix Produit :</label>
                                <h3>
                                    <span class="prix">0.00</span> DT
                                </h3>
                            </div>
                            <div class="form-group">
                                <label>Prix Déplacement :</label>
                                <h3>
                                    <span class="prix_deplacement">0.00</span> DT
                                </h3>
                            </div>
                            <hr>
                            <div class="form-group  text-danger mt-4">
                                <label>Montant à payer :</label>
                                <h3>
                                    <span class="prix_total">0.00</span> DT
                                </h3>
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

</div>
