<!-- Modal Confirmação exclusão notícia-->
<div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmação de exclusão</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Tem certeza que deseja excluir?
      </div>
      <div class="modal-footer">
        <a href="<?= base_url('noticia/excluir/'.$linha['id']) ?>" type="button" class="btn btn-success">Excluir</a>
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Confirmação exclusão arquivo -->
        <div class="modal fade" id="modalExemplo2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmação de exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja excluir?
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('noticia/excluir_arquivo/'.$arquivo['id'].'/'.$noticia->id) ?>" type="button" class="btn btn-success">Excluir</a>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
            </div>
            </div>
        </div>
        </div>