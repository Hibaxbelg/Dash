<script>
    console.log("create-order-{{ $row->RECORD_ID }}");

    $(function() {
        $("#create-order-{{ $row->RECORD_ID }} .softwareVersion , #create-order-{{ $row->RECORD_ID }} .pc_number")
            .change(function() {
                let sotware_id = $("#create-order-{{ $row->RECORD_ID }} .softwareVersion").val();
                let software = softwareVersions.filter(e => e.id == sotware_id)[0];
                let pc_numbers = $("#create-order-{{ $row->RECORD_ID }} .pc_number").val();

                let price = calculePrice(software.id, pc_numbers);
                let price_with_tva = calculePrice(software.id, pc_numbers) + (calculePrice(software.id,
                    pc_numbers) * software.tva) / 100;


                $("#create-order-{{ $row->RECORD_ID }} .prix").val(price);
                $("#create-order-{{ $row->RECORD_ID }} .prix-tva").val(price_with_tva);


                let info = `${software.min_pc_number} postes aux minimum`;
                $("#create-order-{{ $row->RECORD_ID }} .info_about_min_pc_number").text(info);
            });
    });
</script>

<div class="modal fade" id="create-order-{{ $row->RECORD_ID }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action='{{ route('orders.store') }}'>
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ajouter une commande</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" class="form-control" name="doctor_id" value="{{ $row->RECORD_ID }}">
                    <div class="form-group">
                        <label>Version du programme :</label>
                        <select name="software_version_id" class="form-control softwareVersion" required>
                            <option value="" selected disabled hidden>Choisir</option>
                            @foreach ($softwareVersions as $softwareVersion)
                                <option value="{{ $softwareVersion->id }}">{{ $softwareVersion->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nombre des postes :</label>
                        <input type="number" min="1" class="form-control pc_number" name="posts" required>
                        <small class="info_about_min_pc_number"></small>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="datetime-local" class="form-control" name="date" required>
                    </div>
                    <div class="form-group">
                        <label>Note :</label>
                        <textarea type="date" class="form-control" name="note" placeholder="ajouter une note"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Prix (Hors TVA) :</label>
                        <div class="input-group">
                            <input type="text" class="form-control prix" disabled>
                            <div class="input-group-prepend">
                                <div class="input-group-text">DT</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Prix :</label>
                        <div class="input-group">
                            <input type="text" class="form-control prix-tva" disabled>
                            <div class="input-group-prepend">
                                <div class="input-group-text">DT</div>
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
