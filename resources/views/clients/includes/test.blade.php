<div class="modal fade" id="create-commande-${data.RECORD_ID}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action='http://localhost:8000/clients/${data.RECORD_ID}/commandes'>
                <div class="modal-header main-bg">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ajouter une commande</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf

                    <input type="hidden" class="form-control" name="id" value="${data.RECORD_ID}">

                    <div class="form-group">
                        <label>Date</label>
                        <input type="datetime-local" class="form-control" name="date" required>
                    </div>
                    <div class="form-group">
                        <label>Note :</label>
                        <textarea type="date" class="form-control" name="note"
                            placeholder="ajouter une note"></textarea>
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