<!-- Modal -->
<div class="modal fade" id="modal-option" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Create Option</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.option.store') }}" method="POST" id="form-option">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Entrez le nom de l'option">
                    </div>
                    <div class="modal-footer" style="border-top: 0; padding-inline: 0;">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="btn_save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>